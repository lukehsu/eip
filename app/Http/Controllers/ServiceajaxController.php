<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
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
}