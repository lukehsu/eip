<?php 
namespace App\Http\Controllers;
use App\user;
use App\itticket;
use App\Http\Requests;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail;
use Closure;

class ServiceController extends Controller {

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
	public function __construct()
	{   //guest 是原來的
		//$this->middleware('guest');
        $this->middleware('logincheck', ['except' => ['login','show']]);
	}
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */    

    public function it()
    {
    	$today = date('Y-m-d');
      	$users = User::where('name','=',Auth::user()->name)->get();
      	$items = '請選擇';
      	$description = '';
      	$disable = 'disabled';
      	$disabled = '';
      	$style = '';
      	$none = '';
      	foreach ($users as $user) {
      		$dep  = $user->dep;
      		$name = $user->cname;
      		$enumber =  $user->name;
		}
		//$ordercount = itticket::where('date','=',$today)->count();
	    /*
	    $ordernumber = itticket::where('date','=',$today)->get()->max('ordernumber');
		if ($ordernumber=='') 
		{
			$ordernumber = $today.'001';
			$ordernumber = str_replace('-','',$ordernumber);
		}
		else
		{
			$ordernumber = str_replace('-','',$ordernumber);
			$ordernumber = substr($ordernumber,2,12);
			$ordernumber = $ordernumber + 1;
		}
		*/
		$ordernumber = '';
		return view('it',['ordernumber'=>$ordernumber,
						  'dep'=>$dep,
						  'today'=>$today,
						  'enumber'=>$enumber,
						  'name'=>$name,
						  'items'=>$items,
						  'description'=>$description,
						  'disable'=>$disable,
						  'disabled'=>$disabled,
						  'style'=>$style,
						  'none'=>$none,
						]);
	}



    public function ordernumber($ordernumber)
    {
		$infos = itticket::where('ordernumber','=',$ordernumber)->get();
		foreach ($infos as $info) {
        	$ordernumber = $info->ordernumber;
        	$name = $info->name;
        	$dep = $info->dep; 
        	$enumber = $info->enumber; 
        	$date = $info->date;
        	$description = $info->description;
        	$items = $info->items;
		}
		$ordernumber = str_replace('it', '', $ordernumber);
		$users = user::where('name','=',Auth::user()->name)->get();
		foreach ($users as $user) {
			$dep = $user->dep;
		}
		if ($dep=='資訊部') {
			$disable = '';
		}
		else
		{
      		$disable = 'disabled';			
		}	

      	$disabled = 'disabled';
      	$style = 'background-color:#d5dbdb';
      	$none = '';
		return view('it',['ordernumber'=>$ordernumber,
						  'dep'=>$dep,
						  'today'=>$date,
						  'enumber'=>$enumber,
						  'name'=>$name,
						  'description'=>$description,
						  'items'=>$items,
						  'disable'=>$disable,
						  'disabled'=>$disabled,
						  'style'=>$style,
						  'none'=>$none,
						]);
	}
}