<?php 
namespace App\Http\Controllers;
use App\user;
use App\Http\Requests;
use Mail;
class FlowController extends Controller {

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
        //$this->middleware('logincheck', ['except' => ['login','show']]);
	}
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */    

    public function vv()
    {

      $a = 'a';
      return $a;
    }

    public function tt($u)
    {
      $b = $u;
      foreach ($b as $e) {
      	echo $e.'</br>';
      }
      return 'good';
    }
}