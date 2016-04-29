<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
use App\boraitem;
use App\everymonth;
use App\itservicerank;
use App\useracces;
use App\salesmen;
use App\calendar;
use App\mobicmappingdata;
use vendor\phpoffice\phpexcel\Classes\PHPExcel;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel5;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail;

class ServiceajaxController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */    
    public function itreceive()
    {
        $dep = Input::get('dep');
        $date = Input::get('date');
        $ordernumber = Input::get('ordernumber');
        $enumber = Input::get('enumber');
        $name = Input::get('name');
        $items = Input::get('items');
        $description = Input::get('description');
        $users = User::where('name','=',$enumber)->get();
        foreach ($users as $user) {
            $level = $user['level'];
        }
        // 如果level是空就打上manager 不然就打 GM 主要是判斷流程
        if (empty($level)) 
        {
            $level = 'manager';
        }
        else
        {
            $level = 'GM';
        }          
        if ($enumber=='b0164' or $enumber=='b0129' or $enumber=='b0068' or $enumber=='b0071' or $enumber=='b0029' or $enumber=='b0037') {
            $level = 'nanGM';      
        }    
        $ordercheck = itticket::where('ordernumber', '=', Input::get('ordernumber'))->count() ; 
        if ($ordercheck == 0) {
            $today = date('Y-m-d');
            $ordernumber = itticket::where('date','=',$today)->get()->max('ordernumber');
            if ($ordernumber=='') 
            {
                $ordernumber = $today.'001';
                $ordernumber = 'it'.str_replace('-','',$ordernumber);
            }
            else
            {
                $ordernumber = str_replace('it','',$ordernumber);
                $ordernumber = str_replace('-','',$ordernumber);
                $ordernumber = $ordernumber + 1;
                $ordernumber = 'it'.$ordernumber;
            }
            $insertitticket = new itticket;
            $insertitticket->ordernumber = $ordernumber ;
            $insertitticket->dep = $dep ;
            $insertitticket->date = $date ;
            $insertitticket->enumber = $enumber ;
            $insertitticket->name = $name ;
            $insertitticket->items = $items ;
            $insertitticket->description = $description ;
            $insertitticket->statue = 'N' ;
            $insertitticket->process = $level  ;
            $insertitticket->save();
            //填寫收信人信箱 
            $levelcheck = User::where('name','=',$enumber)->where('level','=','')->count();     
            if ($levelcheck>=1) 
            {
                $users = User::where('dep','=',$dep)->get(); 
                foreach ($users as $user) {
                    if ($user['name']==$enumber) {
                        if (is_null($user['spprocess']) or empty($user['spprocess'])) {
                            $targetusers = User::where('dep','=',$dep)->where('spprocess','=','')->where('level','=','manager')->get(); 
                        }
                        else
                        {        
                            $targetusers = User::where('dep','=',$dep)->where('spprocess','=',$user['spprocess'])->where('level','=','manager')->get(); 
                        }
                        foreach ($targetusers  as $targetuser) {
                            $mail = $targetuser['email'];
                        }
                    }
                }
            }
            else
            {
                //請改成Bobby的
                $mail = 'bobby.sheng@gmail.com';
            }    
            switch ($dep) {
                  case '採購部':
                      $mail = 'simon@bora-corp.com';
                      break;            
                  default:
                      # code...
                      break;
            } 
            if ($enumber=='b0164' or $enumber=='b0129' or $enumber=='b0068' or $enumber=='b0071' or $enumber=='b0029' or $enumber=='b0037') {
                $mail = 'homer.fang@bora-corp.com';
                $level = 'manager';      
            }  
            $todepmanager = $mail;
            //信件的內容
            $data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description );
            //寄出信件
            Mail::send('mail.itmail', $data, function($message) use ($todepmanager) 
            {
                $message->to($todepmanager)->subject('資訊需求單');
            });
        }
        else
        {
            $processcheck = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'manager')->count();
            $processcheckf = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'finish')->count();
            if ($processcheckf==1) 
            {
                $response = Input::get('response');
                $ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'finish')->update(['process' => 'close','itresponse'=>$response]);
                //$toit = 'luke.hsu@bora-corp.com';
                $users = User::where('name','=',$enumber)->get(); 
                foreach ($users as $user) {
                    $mail = $user['email'];
                }
                $tomyself = $mail;
                //信件的內容
                $data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description,'response'=>$response,'comment'=>'http://127.0.0.1/eip/public/'.Input::get('ordernumber').'/star');
                //寄出信件
                Mail::send('mail.itokmail', $data, function($message) use ($tomyself) 
                {
                    $message->to($tomyself)->subject('資訊需求單(完成)');
                });
            }
            elseif ($processcheck==1) 
            {
                $ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'manager')->update(['process' => 'finish']);
                $toit = 'it@bora-corp.com';
                //信件的內容
                $data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description);
                //寄出信件
                Mail::send('mail.itmail', $data, function($message) use ($toit) 
                {
                    $message->to($toit)->subject('資訊需求單(簽核流程已完成)');
                });             
            }
            else
            {   
                $ordernumber = Input::get('ordernumber');
                $ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'GM')->update(['process' => 'finish']);
                $ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'nanGM')->update(['process' => 'finish']);
                $toit = 'it@bora-corp.com';
                //信件的內容
                $data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description );
                //寄出信件
                Mail::send('mail.itmail', $data, function($message) use ($toit) 
                {
                    $message->to($toit)->subject('資訊需求單(簽核流程已完成)');
                });
            }   
        }
        
        if (Request::ajax()) {
            return response()->json(array(
                'ordernumber' => 'ok'
            ));
        } 
    }

    /*public function itrespone()
    {
    	$ordernumber = Input::get('ordernumber');
    	$dep = Input::get('dep');
    	$date = Input::get('date');
    	$enumber = Input::get('enumber');
    	$name = Input::get('name');
    	$items = Input::get('items');
    	$description = Input::get('description');
    	$itresponse = Input::get('itresponse');
    	$ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->update(['itresponse' => $itresponse]);
    	$toit = 'sean1606@gmail.com';
        $users = User::where('name','=',$enumber)->get(); 
		foreach ($users as $user) {
			$mail = $user['email'];
		}
        $tomyself = $mail;
        //信件的內容
        $data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description );
        //寄出信件
        Mail::send('mail.itmail', $data, function($message) use ($toit,$tomyself) 
        {
        	$message->to($toit)->to($tomyself)->subject('資訊需求單(您的需求已完成)');
        });
        if (Request::ajax()) {
            return response()->json(array(
                'ordernumber' => 'ok'
            ));
        } 
	}*/

    public function quickok()
    {
        // $ordernums 是一個陣列
        $ordernums = Input::get('ordernum');
        $users = User::where('name','=',Auth::user()->name)->get();   

        foreach ($users as $user) {
            
        }
        foreach ($ordernums as $ordernum) 
        {
            if ($user['dep']=='資訊部') {
                $ticketupdate = itticket::where('ordernumber', '=', $ordernum)->update(['process' => 'close']);               
            }
            else
            {    
                $ticketupdate = itticket::where('ordernumber', '=', $ordernum)->update(['process' => 'finish']);
            }
            $ticketupdates = itticket::where('ordernumber', '=', $ordernum)->get();
            foreach ($ticketupdates as $ticketupdate) {
                $dep = $ticketupdate->dep ;
                $date =  $ticketupdate->date ;
                $enumber = $ticketupdate->enumber ;
                $name = $ticketupdate->name ;
                $items = $ticketupdate->items ;
                $description = $ticketupdate->description ;
            }
            if ($user['dep']=='資訊部') 
            {
                $mail = user::where('name','=',$enumber)->get();
                $tomyself = null;
                foreach ($mail as $email) {
                    $tomyself = $email['email'];
                }

                $data = array('ordernumber'=>$ordernum,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description,'response'=>'','comment'=>'http://127.0.0.1/eip/public/'.$ordernum.'/star');
                Mail::send('mail.itokmail', $data, function($message) use ($tomyself) 
                {
                    $message->to($tomyself)->subject('資訊需求單(完成)');
                });         
            }
            else
            {    
                $toit = 'it@bora-corp.com';
                $data = array('ordernumber'=>$ordernum,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description );
                Mail::send('mail.itmail', $data, function($message) use ($toit) 
                {
                    $message->to($toit)->subject('資訊需求單(簽核流程已完成)');
                });
            }
        }
        if (Request::ajax()) {
            return response()->json(array(
                'ordernum' => 'ok'
            ));
        } 
    }



    public function itemscountajax() 
    {
        $medicine = Input::get('medicine');
        $accname = Input::get('accname');
        $season = Input::get('season');
        $itemcode = Input::get('itemcode');
        
        $titles = array( '業務', '客戶', '合計' , '1月' , '2月' , '3月', 'Q1' ,'4月' , '5月' , '6月' , 'Q2' ,'7月' , '8月' , '9月' , 'Q3', '10月' ,'11月' ,'12月', 'Q4');
        if ($medicine=='請選擇藥品') {
            $medicine = '';
        }       
        if ($accname=='請選擇業務') {
            $accname = '';
        }
        if ($season=='請選擇年分') {
            $season = '';
        }
        if (  $medicine <> '' and $accname <> '' and $season <> '') 
        {  
            $reports = everymonth::where('years','=',$season)->where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname  <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $accname <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($season <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname <> '' ) 
        {
            $reports = everymonth::where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        else 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        }

        
        $report = null;
        foreach ($reports as $reporttemp) 
        {  

            $report .= '<tr>';
            $report .= '<td >'.$reporttemp['emponame'].'</td>';
            $report .= '<td >'.mb_substr($reporttemp['customers'],0,8,"utf-8").'</td>';
            $report .= '<td class="text-center" style="background-color: #FCB941;">'.$reporttemp['allqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['janqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['febqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['marqty'].'</td>';
            $s1 = $reporttemp['janqty']+$reporttemp['febqty']+$reporttemp['marqty'];
            $report .= '<td class="text-center" style="background-color: #FCB941;">'.$s1.'</td>';
            $report .= '<td class="text-center">'.$reporttemp['aprqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['mayqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['junqty'].'</td>';
            $s2 = $reporttemp['aprqty']+$reporttemp['mayqty']+$reporttemp['junqty'];
            $report .= '<td class="text-center" style="background-color: #FCB941;">'.$s2.'</td>';
            $report .= '<td class="text-center">'.$reporttemp['julqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['augqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['sepqty'].'</td>';
            $s3 = $reporttemp['julqty']+$reporttemp['augqty']+$reporttemp['sepqty'];
            $report .= '<td class="text-center" style="background-color: #FCB941;">'.$s3.'</td>';
            $report .= '<td class="text-center">'.$reporttemp['octqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['novqty'].'</td>';
            $report .= '<td class="text-center">'.$reporttemp['decqty'].'</td>';
            $s4 = $reporttemp['octqty']+$reporttemp['novqty']+$reporttemp['decqty'];
            $report .= '<td class="text-center" style="background-color: #FCB941;">'.$s4.'</td>';
            $report .= '</tr>';
            //$report .='<br>';
        }
        if (substr(date('m'),0,1)==0) {
            $j=substr(date('m'),1,1);
        }
        else
        {
            $j=substr(date('m'),0,2);   
        }  
        if ($season=='2016' and $itemcode=='68MOB001') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $report .= '<tr>';
                $report .= '<td >'.$reporttemp['salename'].'-裕利</td>';
                $report .= '<td >'.mb_substr($reporttemp['cusname'],0,8,"utf-8").'</td>';
                $report .= '<td class="text-center" style="background-color: #FCB941;">'.$reporttemp['qty'].'</td>';
                for ($i=1; $i <=12 ; $i++) {
                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {          
                        $report .= '<td class="text-center">'.$reporttemp['qty'].'</td>';
                    }
                    if ($checkreports==0) {
                        $report .= '<td class="text-center">0</td>';
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $report .= '<td class="text-center" style="background-color: #FCB941;" >'.$reporttemp['qty'].'</td>';
                        }
                        if ($checkreports==0) {
                            $report .= '<td class="text-center" style="background-color: #FCB941;">0</td>';
                        }
                    }
                }     
                $report .= '</tr>'; 
            }
        }
        if ($season=='2016' and $itemcode=='68MOB002') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $report .= '<tr>';
                $report .= '<td >'.$reporttemp['salename'].'-裕利</td>';
                $report .= '<td >'.mb_substr($reporttemp['cusname'],0,8,"utf-8").'</td>';
                $report .= '<td class="text-center" style="background-color: #FCB941;">'.$reporttemp['qty'].'</td>';
                for ($i=1; $i <=12 ; $i++) {
                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {          
                        $report .= '<td class="text-center">'.$reporttemp['qty'].'</td>';
                    }
                    if ($checkreports==0) {
                        $report .= '<td class="text-center">0</td>';
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $report .= '<td class="text-center" style="background-color: #FCB941;" >'.$reporttemp['qty'].'</td>';
                        }
                        if ($checkreports==0) {
                            $report .= '<td class="text-center" style="background-color: #FCB941;">0</td>';
                        }
                    }
                }     
                $report .= '</tr>'; 
            }
        }    
        if ($season=='2016' and $itemcode=='68MOB003') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $report .= '<tr>';
                $report .= '<td >'.$reporttemp['salename'].'-裕利</td>';
                $report .= '<td >'.mb_substr($reporttemp['cusname'],0,8,"utf-8").'</td>';
                $report .= '<td class="text-center" style="background-color: #FCB941;">'.$reporttemp['qty'].'</td>';
                for ($i=1; $i <=12 ; $i++) {
                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {          
                        $report .= '<td class="text-center">'.$reporttemp['qty'].'</td>';
                    }
                    if ($checkreports==0) {
                        $report .= '<td class="text-center">0</td>';
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $report .= '<td class="text-center" style="background-color: #FCB941;" >'.$reporttemp['qty'].'</td>';
                        }
                        if ($checkreports==0) {
                            $report .= '<td class="text-center" style="background-color: #FCB941;">0</td>';
                        }
                    }
                }     
                $report .= '</tr>'; 
            }
        }  
        if (Request::ajax()) 
        {
            return response()->json(array(
                'titles'=>$titles,
                'report'=>$report,
                'accname'=>$accname,
                'season'=>$season,
            ));
        } 
    }

    public function transferajax() 
    {
        ini_set('memory_limit', '256M');
        $medicine = Input::get('medicinefrom');
        $accname = Input::get('accnamefrom');
        $season = Input::get('seasonfrom');
        $itemcode = Input::get('itemcodefrom');
        
        $titles = array( '業務', '客戶', '合計' , '1月' , '2月' , '3月', 'Q1' ,'4月' , '5月' , '6月' , 'Q2' ,'7月' , '8月' , '9月' , 'Q3', '10月' ,'11月' ,'12月', 'Q4');
        if ($medicine=='請選擇藥品') {
            $medicine = '';
        }       
        if ($accname=='請選擇業務') {
            $accname = '';
        }
        if ($season=='請選擇年分') {
            $season = '';
        }
        if (  $medicine <> '' and $accname <> '' and $season <> '') 
        {  
            $reports = everymonth::where('years','=',$season)->where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname  <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $accname <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($season <> '' ) 
        {
            $reports = everymonth::where('years','=',$season)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname <> '' ) 
        {
            $reports = everymonth::where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        else 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        }

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1','年度');
        $objPHPExcel->getActiveSheet()->setCellValue('B1','業務');
        $objPHPExcel->getActiveSheet()->setCellValue('C1','客戶');
        $objPHPExcel->getActiveSheet()->setCellValue('D1','商品中文名稱');
        $objPHPExcel->getActiveSheet()->setCellValue('E1','商品英文名稱');
        $objPHPExcel->getActiveSheet()->setCellValue('F1','合計');
        $objPHPExcel->getActiveSheet()->setCellValue('G1','1月');
        $objPHPExcel->getActiveSheet()->setCellValue('H1','2月.');
        $objPHPExcel->getActiveSheet()->setCellValue('I1','3月');
        $objPHPExcel->getActiveSheet()->setCellValue('J1','Q1');
        $objPHPExcel->getActiveSheet()->setCellValue('K1','4月');
        $objPHPExcel->getActiveSheet()->setCellValue('L1','5月');
        $objPHPExcel->getActiveSheet()->setCellValue('M1','6月');
        $objPHPExcel->getActiveSheet()->setCellValue('N1','Q2');
        $objPHPExcel->getActiveSheet()->setCellValue('O1','7月');
        $objPHPExcel->getActiveSheet()->setCellValue('P1','8月');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1','9月');
        $objPHPExcel->getActiveSheet()->setCellValue('R1','Q3');
        $objPHPExcel->getActiveSheet()->setCellValue('S1','10月');
        $objPHPExcel->getActiveSheet()->setCellValue('T1','11月');
        $objPHPExcel->getActiveSheet()->setCellValue('U1','12月');
        $objPHPExcel->getActiveSheet()->setCellValue('V1','Q4');
        $no = 2 ;

        foreach ($reports as $reporttemp)  {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , $reporttemp['years'] ); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $reporttemp['emponame'] );  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , $reporttemp['customers'] );
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , $reporttemp['itemchname'] ); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , $reporttemp['itemenname'] );  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['allqty'] ); 


            $objPHPExcel->getActiveSheet()->setCellValue('G'.$no , $reporttemp['janqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$no , $reporttemp['febqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$no , $reporttemp['marqty'] ); 
            $s1 = $reporttemp['janqty']+$reporttemp['febqty']+$reporttemp['marqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$no , $s1  );

            $objPHPExcel->getActiveSheet()->setCellValue('K'.$no , $reporttemp['aprqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$no , $reporttemp['mayqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$no , $reporttemp['junqty']); 
            $s2 = $reporttemp['aprqty']+$reporttemp['mayqty']+$reporttemp['junqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$no , $s2 );   

            $objPHPExcel->getActiveSheet()->setCellValue('O'.$no , $reporttemp['julqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$no , $reporttemp['augqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$no , $reporttemp['sepqty']);
            $s3 = $reporttemp['julqty']+$reporttemp['augqty']+$reporttemp['sepqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$no , $s3 ); 

            $objPHPExcel->getActiveSheet()->setCellValue('S'.$no , $reporttemp['octqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$no , $reporttemp['novqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$no , $reporttemp['decqty']); 
            $s4 = $reporttemp['octqty']+$reporttemp['novqty']+$reporttemp['decqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$no , $s4);  
            
            $no = $no + 1;
    
        }
        if ($season=='2016' and $itemcode=='68MOB001') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $col = 6;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , date('Y') );
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $reporttemp['salename'].'-裕利' );
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , mb_substr($reporttemp['cusname'],0,8,"utf-8"));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , '骨敏捷(R)錠7.5毫克(希臘廠)' ); 
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , 'MOBIC (R) TABLETS 7.5MG' );  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['qty'] ); 
                for ($i=1; $i <=12 ; $i++) {

                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {       
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col ,$no , $reporttemp['qty'] ); 
                        $col = $col + 1;
                    }
                    if ($checkreports==0) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                        $col = $col + 1;
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0210')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , $reporttemp['qty'] );
                            $col = $col + 1;
                        }
                        if ($checkreports==0) {
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                            $col = $col + 1;
                        }
                    }
                }     
                $no = $no + 1; 
            }
        }
        if ($season=='2016' and $itemcode=='68MOB002') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $col = 6;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , date('Y') );
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $reporttemp['salename'].'-裕利' );
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , mb_substr($reporttemp['cusname'],0,8,"utf-8"));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , '骨敏捷(R)錠15毫克(希臘廠)' ); 
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , 'MOBIC (R) TABLETS 15MG' );  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['qty'] ); 
                for ($i=1; $i <=12 ; $i++) {

                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {       
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col ,$no , $reporttemp['qty'] ); 
                        $col = $col + 1;
                    }
                    if ($checkreports==0) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                        $col = $col + 1;
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0211')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , $reporttemp['qty'] );
                            $col = $col + 1;
                        }
                        if ($checkreports==0) {
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                            $col = $col + 1;
                        }
                    }
                }     
                $no = $no + 1; 
            }
        }
        if ($season=='2016' and $itemcode=='68MOB003') {
            $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->orderBy('salename')->get();
            foreach ($reports as $reporttemp) {
                $col = 6;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , date('Y') );
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $reporttemp['salename'].'-裕利' );
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , mb_substr($reporttemp['cusname'],0,8,"utf-8"));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , '骨敏捷(R)針劑(希臘廠)' ); 
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , 'MOBIC (R)AMG' );  
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['qty'] ); 
                for ($i=1; $i <=12 ; $i++) {

                    $monstart = date('Y').'-'.$i.'-1';
                    $monend =   date("t",strtotime($monstart));
                    $monend =  date('Y').'-'.$i.'-'.$monend; 
                    $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                    $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$monstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                    foreach ($reports as $reporttemp) {       
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col ,$no , $reporttemp['qty'] ); 
                        $col = $col + 1;
                    }
                    if ($checkreports==0) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                        $col = $col + 1;
                    }
                    if ($i==3 or $i==6 or $i==9 or $i==12 ) {
                        $start = $i-2 ;
                        $submonstart = date('Y').'-'.$start.'-1';
                        $checkreports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->count();
                        $reports = mobicmappingdata::selectraw('sum(qty) as qty,salename,cusname')->where('cusname', '=',$reporttemp['cusname'])->where('salename', '=',$reporttemp['salename'])->where('date', '>=',$submonstart)->where('date', '<=',$monend)->where('ItemNo', '=','A0076')->where('SaleType', '=','A2')->GroupBy('cusname')->get();
                        foreach ($reports as $reporttemp) {          
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , $reporttemp['qty'] );
                            $col = $col + 1;
                        }
                        if ($checkreports==0) {
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$no , '0' );
                            $col = $col + 1;
                        }
                    }
                }     
                $no = $no + 1; 
            }
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //產生header
        $filename = "count.xlsx";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename" );
        //header('Cache-Control: max-age=0');
        //header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        //Export to Excel2007 (.xlsx) 匯出成2007
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('test.xlsx');
        //Export to Excel5 (.xls) 匯出成2003
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }

    public function medicinecode() 
    {

        $medicine = Input::get('medicine');
        $season = Input::get('season');
        $allcodes = boraitem::where('years','=',$season)->where('itemchname','=',$medicine)->get();
        $codes = array();

        foreach ($allcodes as $code) {
            array_push($codes, $code['itemno']) ;
        }

        if (Request::ajax()) 
        {
            return response()->json(array(
                'codes'=>$codes,
            ));
        } 
    }

    public function company() 
    {

        $company = Input::get('company');
        $season = Input::get('season');

        $allcodes = boraitem::where('years','=',$season)->get();
        $codes = array();
        if ($company=='保瑞') 
        {
            foreach ($allcodes as $code) 
            {
                if ($code['itemno'] =='68PTV001'|| $code['itemno']=='68DEN001' || $code['itemno']=='68LEP002' || $code['itemno']=='68LEP001' || $code['itemno']=='68LXP001' || $code['itemno']=='68EBP001' || $code['itemno']=='68DEP001' || $code['itemno']=='68LMP002' || $code['itemno']=='A0022' || $code['itemno']=='A0024' || $code['itemno']=='A0076' || $code['itemno']=='A0210' || $code['itemno']=='68MOB001' || $code['itemno']=='68MOB002' || $code['itemno']=='68MOB003' ) 
                {
                    array_push($codes, $code['itemchname']) ;
                }
            }            
        }
        elseif ($company=='聯邦') 
        {    
            foreach ($allcodes as $code) 
            {
                if ($code['itemno'] =='67HWLCBN'|| $code['itemno']=='67HWLCBC' || $code['itemno']=='67HWLCBJ' || $code['itemno']=='67QCTCBQ' || $code['itemno']=='57ABPNPA' || $code['itemno']=='57ABPNBA'  ) 
                {
                    array_push($codes, $code['itemchname']) ;
                }
            }
        }
        else
        {
            foreach ($allcodes as $code) 
            {
                if ($code['itemno'] <>'68PTV001'and $code['itemno']<>'68DEN001' and $code['itemno']<>'68LEP002' and $code['itemno']<>'68LEP001' and $code['itemno']<>'68LXP001' and $code['itemno']<>'68EBP001' and $code['itemno']<>'68DEP001' and $code['itemno']<>'68LMP002' and $code['itemno'] <>'67HWLCBN'and $code['itemno']<>'67HWLCBC' and $code['itemno']<>'67HWLCBJ' and $code['itemno']<>'67QCTCBQ' and $code['itemno']<>'57ABPNPA' and $code['itemno']<>'57ABPNBA'  ) 
                {
                    array_push($codes, $code['itemchname']) ;
                }
            }
        }    


        if (Request::ajax()) 
        {
            return response()->json(array(
                'itemchname'=>array_unique($codes),
            ));
        } 
    }

    public function itservicerank()
    {
        $rank = Input::get('rank');
        $comment = Input::get('comment');  
        $ordernumber = Input::get('ordernumber');
        $servicerank = new itservicerank;
        $servicerank->ordernumber = $ordernumber;
        $servicerank->enumber = Auth::user()->name;
        $servicerank->rank = $rank;
        $servicerank->comment = $comment;
        $servicerank->save();
        if (Request::ajax()) 
        {
            return response()->json(array(
                'status'=>'ok',
            ));
        } 
    }

    public function accountreportajax()
    {
        $delay = Input::get('delay');
        $day = Input::get('day');
        $workon = Input::get('workon');
        $workoff = Input::get('workoff');
        $leave = Input::get('leave');
        $username= Input::get('username');
        $usernumber = Input::get('usernumber');
        $allinfos = Input::get('allinfo');
        $deletetemp = salesmen::where('usernumber', '=', $usernumber)->where('reportday', '=', $day)->delete();
        if ($delay=='1') {

            $delay = '補單';
        }
        else
        {
            $delay = '正常';
        }    
        foreach ($allinfos as $allinfo) 
        {
            $insert = new salesmen;
            $insert->delay = $delay  ;
            $insert->reportday = $day ;
            $insert->username = $username ;
            $insert->usernumber = $usernumber ;
            $insert->workon = $workon;
            $insert->workoff = $workoff ;
            $insert->leave  = $leave  ;
            $insert->visit = $allinfo['0'];
            $insert->where = $allinfo['1'];
            $insert->division = $allinfo['2'];
            $insert->consumer = $allinfo['3'];
            $insert->who = $allinfo['4'];
            $insert->title = $allinfo['5'];
            $insert->medicine = $allinfo['6'];
            $insert->category = $allinfo['7'];
            $insert->talk = $allinfo['8'];
            $insert->other = $allinfo['9'];
            $insert->save();
        }

        if (Request::ajax()) 
        {
            return response()->json(array(
                'status'=>'ok',
            ));
        } 
    }




    public function transferdailycheck() 
    {
        ini_set('memory_limit', '256M');
        $startday = Input::get('startday');
        $endday = Input::get('endday');
        
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        /*
        $objPHPExcel->getActiveSheet()->setCellValue('A1','日期');
        $objPHPExcel->getActiveSheet()->setCellValue('B1','星期');
        $objPHPExcel->getActiveSheet()->setCellValue('C1','人員');
        $objPHPExcel->getActiveSheet()->setCellValue('D1','上班時間');
        $objPHPExcel->getActiveSheet()->setCellValue('E1','下班時間');
        $objPHPExcel->getActiveSheet()->setCellValue('F1','休假');
        $objPHPExcel->getActiveSheet()->setCellValue('G1','補單');
        $objPHPExcel->getActiveSheet()->setCellValue('H1','國定假日');
        */
        $daterow = 2;
        $col = 2;
        $row = 2;
        $users = useracces::where('access','=','業務日報表')->get();
        foreach ($users as $user) 
        {
            $userch = user::where('name','=',$user['user'])->first();
            $calendars = calendar::where('monthdate','>=',$startday)->where('monthdate','<=',$endday)->orderBy('monthdate', 'ASC')->get();
            foreach ($calendars as $calendar) {      
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0',$daterow , $calendar['monthdate']); 
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1',$daterow , $calendar['weekday']); 
                $daterow = $daterow + 1 ;
                $checkreports = salesmen::where('reportday','>=',$calendar['monthdate'])->where('reportday','<=',$calendar['monthdate'])->where('usernumber','=',$user['user'])->count();  
                if ($calendar['weekday']=='星期六' or $calendar['weekday']=='星期日') {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,'1' ,$userch['cname']);  
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row , ''); 
                    $row = $row  + 1;   
                }
                elseif ($checkreports==0) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,'1' ,$userch['cname']);  
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row , '缺'); 
                    $row = $row  + 1;
                }
                else
                {    
                    $reports = salesmen::where('reportday','>=',$calendar['monthdate'])->where('reportday','<=',$calendar['monthdate'])->where('usernumber','=',$user['user'])->get();  
                    foreach ($reports as $reporttemp)  {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,'1' , $reporttemp['username']);  
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row , $reporttemp['delay']); 
                        $row = $row  + 1;  
                        break;
                    } 
                }
            }
            $col = $col +1; 
            $daterow = 2; 
            $row = 2;
        }  
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //產生header
        $filename = "dailycheck.xlsx";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename" );
        //header('Cache-Control: max-age=0');
        //header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        //Export to Excel2007 (.xlsx) 匯出成2007
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('test.xlsx');
        //Export to Excel5 (.xls) 匯出成2003
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }


    public function accountmanagerajax() 
    {
        $startday = Input::get('startday');
        $endday = Input::get('endday');
        $accname = Input::get('accname');
        $equal = '=';
        if ($accname=='所有業務人員') {
            $equal = '<>';
        }
        $reports = salesmen::where('reportday','>=',$startday)->where('reportday','<=',$endday)->where('username',$equal,$accname)->orderBy('reportday','desc')->orderBy('username','desc')->get();
        $main = array();
        $submain = array();
        foreach ($reports as $ticket) {
            array_push($submain,$ticket['reportday'],$ticket['username'], $ticket['usernumber'], $ticket['workon'], $ticket['workoff'], $ticket['visit'], $ticket['where'],$ticket['division'],$ticket['consumer'],$ticket['who'],$ticket['title'],$ticket['medicine'],$ticket['category'],$ticket['talk'],$ticket['other']);
            array_push($main,$submain);
            $submain = [];
        }
        if (Request::ajax()) 
        {
            return response()->json(array(
                'status'=>'ok',
                'main'=>$main,
            ));
        }    
    }

    public function accountmanagerexcel() 
    {
        ini_set('memory_limit', '256M');
        $startday = Input::get('startday');
        $endday = Input::get('endday');
        $accname = Input::get('accname');
        $equal = '=';
        if ($accname=='所有業務人員') {
            $equal = '<>';
        }
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1','日期');
        $objPHPExcel->getActiveSheet()->setCellValue('B1','星期');
        $objPHPExcel->getActiveSheet()->setCellValue('C1','人員');
        $objPHPExcel->getActiveSheet()->setCellValue('D1','上班時間');
        $objPHPExcel->getActiveSheet()->setCellValue('E1','下班時間');
        $objPHPExcel->getActiveSheet()->setCellValue('F1','休假');
        $objPHPExcel->getActiveSheet()->setCellValue('G1','補單');
        $objPHPExcel->getActiveSheet()->setCellValue('H1','拜訪時間');
        $objPHPExcel->getActiveSheet()->setCellValue('I1','地區');
        $objPHPExcel->getActiveSheet()->setCellValue('J1','科別');
        $objPHPExcel->getActiveSheet()->setCellValue('K1','客戶名稱');
        $objPHPExcel->getActiveSheet()->setCellValue('L1','拜訪對象');
        $objPHPExcel->getActiveSheet()->setCellValue('M1','職稱');
        $objPHPExcel->getActiveSheet()->setCellValue('N1','藥品');
        $objPHPExcel->getActiveSheet()->setCellValue('O1','類別');
        $objPHPExcel->getActiveSheet()->setCellValue('P1','拜訪情形');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1','備註');
        $no = 2 ;
        $calendars = calendar::where('monthdate','>=',$startday)->where('monthdate','<=',$endday)->orderBy('monthdate', 'desc')->get();
        foreach ($calendars as $calendar ) {      
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , $calendar['monthdate']); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $calendar['weekday']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , '' );
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , '' ); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , '' );  
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , '' ); 
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$no , '' ); 
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$no , $calendar['holiday'] );
            if ($calendar['weekday']=='星期六' or $calendar['weekday']=='星期日' or $calendar['offday']=='1') {
                $objPHPExcel->getActiveSheet()->getStyle('A'.$no.':'.'Q'.$no)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$no.':'.'Q'.$no)->getFill()->getStartColor()->setARGB('FF808080');
            }  
            $reports = salesmen::where('reportday','>=',$calendar['monthdate'])->where('reportday','<=',$calendar['monthdate'])->where('username',$equal,$accname)->orderBy('username','desc')->get();  
                foreach ($reports as $reporttemp)  {
                    $no = $no + 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , ''); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , '');  
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , $reporttemp['username'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , $reporttemp['workon'] ); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , $reporttemp['workoff'] );  
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['leave'] ); 
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$no , $reporttemp['delay']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$no , $reporttemp['visit'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$no , $reporttemp['where'] ); 
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$no , $reporttemp['division'] );  
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$no , $reporttemp['consumer'] ); 
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$no , $reporttemp['who']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$no , $reporttemp['title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$no , $reporttemp['medicine'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$no , $reporttemp['category'] ); 
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$no , $reporttemp['talk'] );  
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$no , $reporttemp['other'] );        
                }
            $no = $no + 1 ;
        }
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //產生header
        $filename = "dailycheck.xlsx";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename" );
        //header('Cache-Control: max-age=0');
        //header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        //Export to Excel2007 (.xlsx) 匯出成2007
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('test.xlsx');
        //Export to Excel5 (.xls) 匯出成2003
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); 
    }
}