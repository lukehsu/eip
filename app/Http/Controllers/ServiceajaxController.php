<?php 
namespace App\Http\Controllers;
use App\user;
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
    	$today = date('Y-m-d');
    	$ordernumber = Input::get('ordernumber');
    	$dep = Input::get('dep');
    	$date = Input::get('date');
    	$enumber = Input::get('enumber');
    	$name = Input::get('name');
    	$items = Input::get('items');
    	$description = Input::get('description');
		$insertitticket = new itticket;
		$insertitticket->ordernumber = $ordernumber ;
		$insertitticket->dep = $dep ;
		$insertitticket->date = $date ;
		$insertitticket->enumber = $enumber ;
		$insertitticket->name = $name ;
		$insertitticket->items = $items ;
		$insertitticket->description = $description ;
        $insertitticket->save();
	    $ordernumber = itticket::where('date','=',$today)->get()->max('ordernumber');
		$ordernumber = str_replace('-','',$ordernumber);
		$ordernumber = substr($ordernumber,2,12);
		$ordernumber = $ordernumber + 1;
        if (Request::ajax()) {
            return response()->json(array(
                'ordernumber' => $ordernumber

            ));
        } 
    }
}