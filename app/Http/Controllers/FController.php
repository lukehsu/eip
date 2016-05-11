<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
use App\boraitem;
use App\everymonth;
use App\importantp;
use App\itservicerank;
use App\useracces;
use App\salesmen;
use App\calendar;
use App\dailyreport;
use App\mobicmappingdata;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail;

class FController extends Controller {

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
    public static function salesforman($shipping)
    {
        #每月業績保瑞
        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=','鄒子健')->where('InvDate','>=','2016-01-01')->where('InvDate','<=','2016-01-31')->whereNotIn('BORACustomerNo', $shipping)->get();
        foreach ($monthsales as $monthsale) {
            $monsalebora = $monthsale['saletotal'];
        }
        #每月業績裕利加
        $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=','鄒子健')->where('Date','>=','2016-01-01')->where('Date','<=','2016-01-31')->where('SaleType','=','A2')->whereNotIn('ItemNo', ['A0195'])->get();
        foreach ($monthsales as $monthsale) {
            $monsalemobicgain = $monthsale['saletotal'];
        } 
        #每月業績裕利減 
        $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=','鄒子健')->where('Date','>=','2016-01-01')->where('Date','<=','2016-01-31')->where('SaleType','=','R2')->whereNotIn('ItemNo', ['A0195'])->get();
        foreach ($monthsales as $monthsale) {
            $monsalemobicreturn = $monthsale['saletotal'];
        }  
        #每月業績合計
        $monsale = $monsalebora + $monsalemobicgain - $monsalemobicreturn;
        
        #年初至當月保瑞
        $yearsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=','鄒子健')->where('InvDate','>=','2016-01-01')->where('InvDate','<=','2016-01-31')->whereNotIn('BORACustomerNo', $shipping)->get();
        foreach ($yearsales as $yearsale) {
            $yearsalebora = $yearsale['saletotal'];
        }
        #年初至當月裕利加
        $yearsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=','鄒子健')->where('Date','>=','2016-01-01')->where('Date','<=','2016-01-31')->where('SaleType','=','A2')->whereNotIn('ItemNo', ['A0195'])->get();
        foreach ($yearsales as $yearsale) {
            $yearmobicgain = $yearsale['saletotal'];
        }
        #年初至當月裕利減
        $yearsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=','鄒子健')->where('Date','>=','2016-01-01')->where('Date','<=','2016-01-31')->where('SaleType','=','R2')->whereNotIn('ItemNo', ['A0195'])->get();
        foreach ($yearsales as $yearsale) {
            $yearmobicreturn = $yearsale['saletotal'];
        } 
        #每月累積業績合計
        $yearsale = $yearsalebora + $yearmobicgain - $yearmobicreturn;
        return $monsalemobicgain;
    }

    
    public static function salesformedicine($shipping,$importantarget)
    {
        #每月業績保瑞
        $monsaleboramed = array();
        foreach ($importantarget as $code) {
            $target = importantp::where('itemno','=',$code)->first();
            #判斷同一產品有不同型號的情況
            (isset($monsaleboramed[$target['importantproduct']])) ? (''):($monsaleboramed[$target['importantproduct']] = 0);
            if ($code=='Others') 
            {
                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=','鄒子健')->where('InvDate','>=','2016-01-01')->where('InvDate','<=','2016-01-31')->whereNotIn('BORAItemNo', $importantarget)->whereNotIn('BORACustomerNo', $shipping)->get();
            }
            else
            {
                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=','鄒子健')->where('InvDate','>=','2016-01-01')->where('InvDate','<=','2016-01-31')->where('BORAItemNo','=', $code)->whereNotIn('BORACustomerNo', $shipping)->get();
            }    
            foreach ($monthsales as $monthsale) {
                $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
            }
        }
        return $monsaleboramed;
    }
}