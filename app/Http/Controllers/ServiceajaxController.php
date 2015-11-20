<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
use App\boraitem;
use App\everymonth;
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
        	$users = User::where('dep','=',$dep)->where('level','=','manager')->get(); 
			foreach ($users as $user) {
				$mail = $user['email'];
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
    			$toit = 'luke.hsu@bora-corp.com';
                $users = User::where('name','=',$enumber)->get(); 
                foreach ($users as $user) {
                    $mail = $user['email'];
                }
                $tomyself = $mail;
    			//信件的內容
        		$data = array('ordernumber'=>$ordernumber,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description,'response'=>$response);
        		//寄出信件
        		Mail::send('mail.itokmail', $data, function($message) use ($toit,$tomyself) 
        		{
        			$message->to($toit)->to($tomyself)->subject('資訊需求單(完成)');
        		});
    		}
    		elseif ($processcheck==1) 
    		{
    			$ticketupdate = itticket::where('ordernumber', '=', Input::get('ordernumber'))->where('process', '=', 'manager')->update(['process' => 'finish']);
    			$toit = 'luke.hsu@bora-corp.com';
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
    		    $toit = 'luke.hsu@bora-corp.com';
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
        /*$users = User::where('name','=',Auth::user()->name)->get();   
        foreach ($users as $user) {
            # code...
        }*/
        foreach ($ordernums as $ordernum) {
            $ticketupdate = itticket::where('ordernumber', '=', $ordernum)->update(['process' => 'finish']);
            $ticketupdates = itticket::where('ordernumber', '=', $ordernum)->get();
            foreach ($ticketupdates as $ticketupdate) {
                $dep = $ticketupdate->dep ;
                $date =  $ticketupdate->date ;
                $enumber = $ticketupdate->enumber ;
                $name = $ticketupdate->name ;
                $items = $ticketupdate->items ;
                $description = $ticketupdate->description ;
            }
            $toit = 'luke.hsu@bora-corp.com';
            //信件的內容
            $data = array('ordernumber'=>$ordernum,'dep'=>$dep,'date'=>$date,'enumber'=>$enumber,'name'=>$name,'items'=>$items,'description'=>$description );
            //寄出信件
            Mail::send('mail.itmail', $data, function($message) use ($toit) 
            {
                $message->to($toit)->subject('資訊需求單(簽核流程已完成)');
            });
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
        if ($season=='請選擇季度') {
            $season = '';
        }
        if (  $medicine <> '' and $accname <> '' and $season <> '') 
        {  
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname  <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $accname <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($season <> '' ) 
        {
            $reports = everymonth::all();
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
            switch ($season) {
                case 'Q1':
                    $reporttemp['allqty'] = 0 ;
                    $reporttemp['aprqty'] = '---';
                    $reporttemp['mayqty'] = '---';
                    $reporttemp['junqty'] = '---';
                    $reporttemp['julqty'] = '---';
                    $reporttemp['augqty'] = '---';
                    $reporttemp['sepqty'] = '---';
                    $reporttemp['octqty'] = '---';
                    $reporttemp['novqty'] = '---';
                    $reporttemp['decqty'] = '---';                    
                    break;

                case 'Q2':
                    $reporttemp['allqty'] = 0 ;
                    $reporttemp['janqty'] = '---';
                    $reporttemp['febqty'] = '---';
                    $reporttemp['marqty'] = '---';
                    $reporttemp['julqty'] = '---';
                    $reporttemp['augqty'] = '---';
                    $reporttemp['sepqty'] = '---';
                    $reporttemp['octqty'] = '---';
                    $reporttemp['novqty'] = '---';
                    $reporttemp['decqty'] = '---';                     
                    break;

                case 'Q3':
                    $reporttemp['allqty'] = 0 ;
                    $reporttemp['janqty'] = '---';
                    $reporttemp['febqty'] = '---';
                    $reporttemp['marqty'] = '---';
                    $reporttemp['aprqty'] = '---';
                    $reporttemp['mayqty'] = '---';
                    $reporttemp['junqty'] = '---';
                    $reporttemp['octqty'] = '---';
                    $reporttemp['novqty'] = '---';
                    $reporttemp['decqty'] = '---';                    
                    break;

                case 'Q4':
                    $reporttemp['allqty'] = 0 ;
                    $reporttemp['janqty'] = '---';
                    $reporttemp['febqty'] = '---';
                    $reporttemp['marqty'] = '---';
                    $reporttemp['aprqty'] = '---';
                    $reporttemp['mayqty'] = '---';
                    $reporttemp['junqty'] = '---';
                    $reporttemp['julqty'] = '---';
                    $reporttemp['augqty'] = '---';
                    $reporttemp['sepqty'] = '---';                   
                    break;                
                default:
                    
                    break;
            }
            $report .= '<tr>';
            $report .= '<td >'.$reporttemp['emponame'].'</td>';
            $report .= '<td >'.$reporttemp['customers'].'</td>';
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
        if ($season=='請選擇季度') {
            $season = '';
        }
        if (  $medicine <> '' and $accname <> '' and $season <> '') 
        {  
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($accname  <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $season  <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->orderBy('emponame','DESC')->get();
        } 
        elseif ($medicine <> '' and $accname <> '' ) 
        {
            $reports = everymonth::where('itemno','=',$itemcode)->where('emponame','=',$accname)->orderBy('emponame','DESC')->get();
        } 
        elseif ($season <> '' ) 
        {
            $reports = everymonth::all();
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1','業務');
        $objPHPExcel->getActiveSheet()->setCellValue('B1','客戶');
        $objPHPExcel->getActiveSheet()->setCellValue('C1','合計');
        $objPHPExcel->getActiveSheet()->setCellValue('D1','1月');
        $objPHPExcel->getActiveSheet()->setCellValue('E1','2月.');
        $objPHPExcel->getActiveSheet()->setCellValue('F1','3月');
        $objPHPExcel->getActiveSheet()->setCellValue('G1','Q1');
        $objPHPExcel->getActiveSheet()->setCellValue('H1','4月');
        $objPHPExcel->getActiveSheet()->setCellValue('I1','5月');
        $objPHPExcel->getActiveSheet()->setCellValue('J1','6月');
        $objPHPExcel->getActiveSheet()->setCellValue('K1','Q2');
        $objPHPExcel->getActiveSheet()->setCellValue('L1','7月');
        $objPHPExcel->getActiveSheet()->setCellValue('M1','8月');
        $objPHPExcel->getActiveSheet()->setCellValue('N1','9月');
        $objPHPExcel->getActiveSheet()->setCellValue('O1','Q3');
        $objPHPExcel->getActiveSheet()->setCellValue('P1','10月');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1','11月');
        $objPHPExcel->getActiveSheet()->setCellValue('R1','12月');
        $objPHPExcel->getActiveSheet()->setCellValue('S1','Q4');
        $no = 2 ;

        foreach ($reports as $reporttemp)  {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$no , $reporttemp['emponame'] );  
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$no , $reporttemp['customers'] );  
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$no , $reporttemp['allqty'] ); 


            $objPHPExcel->getActiveSheet()->setCellValue('D'.$no , $reporttemp['janqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$no , $reporttemp['febqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$no , $reporttemp['marqty'] ); 
            $s1 = $reporttemp['janqty']+$reporttemp['febqty']+$reporttemp['marqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$no , $s1  );

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$no , $reporttemp['aprqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$no , $reporttemp['mayqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$no , $reporttemp['junqty']); 
            $s2 = $reporttemp['aprqty']+$reporttemp['mayqty']+$reporttemp['junqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$no , $s2 );   

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$no , $reporttemp['julqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$no , $reporttemp['augqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$no , $reporttemp['sepqty']);
            $s3 = $reporttemp['julqty']+$reporttemp['augqty']+$reporttemp['sepqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$no , $s3 ); 

            $objPHPExcel->getActiveSheet()->setCellValue('P'.$no , $reporttemp['octqty'] );    
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$no , $reporttemp['novqty']); 
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$no , $reporttemp['decqty']); 
            $s4 = $reporttemp['octqty']+$reporttemp['novqty']+$reporttemp['decqty'];
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$no , $s4); 
            
            $no = $no + 1;
    
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
        $allcodes = boraitem::where('itemchname','=',$medicine)->get();
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
        $allcodes = boraitem::all();
        $codes = array();
        if ($company=='保瑞') 
        {
            foreach ($allcodes as $code) 
            {
                if ($code['itemno'] =='68PTV001'|| $code['itemno']=='68DEN001' || $code['itemno']=='68LEP002' || $code['itemno']=='68LEP001' || $code['itemno']=='68LXP001' || $code['itemno']=='68EBP001' || $code['itemno']=='68DEP001' || $code['itemno']=='68LMP002' ) 
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


}