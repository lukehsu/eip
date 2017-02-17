<?php 
namespace App\Http\Controllers;
use App\user;
use App\Http\Requests;
use Hash,Input,Request,Response,Auth,Redirect,Log;
class AdminController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  { //guest 是原來的
    //$this->middleware('guest');
    $this->middleware('logincheck', ['except' => ['login','show']]);
  }

  public function access()
  { 
      return view('access');
  }
}