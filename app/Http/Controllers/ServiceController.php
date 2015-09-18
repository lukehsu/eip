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
      	foreach ($users as $user) {
      		$dep  = $user->dep;
      		$name = $user->cname;
      		$enumber =  $user->name;
		}
		$ordercount = itticket::where('date','=',$today)->count();
	    $ordernumber = itticket::where('date','=',$today)->get()->max('ordernumber');

		if ($ordernumber=='') {
			$ordernumber = $today.'001';
			$ordernumber = str_replace('-','',$ordernumber);
		}
		else
		{
			$ordernumber = str_replace('-','',$ordernumber);
			$ordernumber = substr($ordernumber,2,12);
			$ordernumber = $ordernumber + 1;
		}
		return view('it',['ordernumber'=>$ordernumber,
						  'dep'=>$dep,
						  'today'=>$today,
						  'enumber'=>$enumber,
						  'name'=>$name,
						]);
		}
}