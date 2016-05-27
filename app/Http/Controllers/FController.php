<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
use App\boraitem;
use App\everymonth;
use App\budgetgp;
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

    
    public static function salesformedicine($shipping,$importantarget,$peoples,$usergroup,$choiceday,$monthstart)
    {
        $finaldata = [] ;
        foreach ($peoples as $people) {
            $cname = [] ;
            #每月業績保瑞
            $monsaleboramed = array();
            foreach ($importantarget as $code) {
                $usercname = user::where('name','=',$people)->first();
                $target = importantp::where('itemno','=',$code)->first();
                #依公司區別保瑞
                if ($target['company']=='bora') {
                #判斷同一產品有不同產品代碼的情況
                    (isset($monsaleboramed[$target['importantproduct']])) ? (''):($monsaleboramed[$target['importantproduct']] = 0);
                    if ($code=='Others') 
                    {
                        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
                    }
                    else
                    {
                        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->where('BORAItemNo','=', $code)->get();
                    }    
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                    }

                }
                #依公司區別百靈佳
                elseif ($target['company']=='boehringer') {

                    (isset($monsaleboramed[$target['importantproduct']])) ? (''):($monsaleboramed[$target['importantproduct']] = 0);
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                    }
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] - $monthsale['saletotal'];
                    }
                }
            }
        $usercname = user::where('name','=',$people)->first();
        $cname[$usercname['cname']] = $monsaleboramed;
        $finaldata[$people] = $cname;
        }
        return $finaldata;
    }


    public static function budgetmonth($cnames,$everyone)
    {
        $budget = array();
        $pbudget = array();
        $ab = array();
        $pab = array();
        $totals = array();
        $budgetmonth = array();
        foreach ($cnames as $key => $cname) {
            $budgetgps = budgetgp::where('month','=','2016-05-01')->where('cname','=',$cname)->get();
            foreach ($budgetgps as $budgetgp) {
                $budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                if ($everyone[$key][$cname][$budgetgp['BORAItemEngName']]==0) 
                {
                    $ab[$budgetgp['BORAItemEngName']]=0;
                }
                else
                {
                    $ab[$budgetgp['BORAItemEngName']]=round($everyone[$key][$cname][$budgetgp['BORAItemEngName']]/$budgetgp['budget'] * 100).'%';
                }  
            }
            $pbudget[$cname] = $budget;
            $pab[$cname] = $ab;
            $totals[$cname] = [array_sum($everyone[$key][$cname]),array_sum($budget),round(array_sum($everyone[$key][$cname])/array_sum($budget)*100).'%'];
        }
        array_push($budgetmonth, $pbudget,$pab,$totals);
        return $budgetmonth;
    }

    public static function Qsalesformedicine($shipping,$importantarget,$peoples,$usergroup)
    {
        $Qsalesformedicine = ['Q1'=>0,'Q2'=>0,'Q3'=>0,'Q4'=>0,'Q5'=>0];
        if (!empty($peoples)) {
            for ($i=1; $i <= 5; $i++)
            { 

                ($i == 1)?($Q1 = []):('');
                ($i == 2)?($Q2 = []):('');
                ($i == 3)?($Q3 = []):('');
                ($i == 4)?($Q4 = []):('');   
                ($i == 5)?($Q5 = []):('');          
                ($i == 1)?($monthstart ='2016-01-01'):('');
                ($i == 2)?($monthstart ='2016-04-01'):('');
                ($i == 3)?($monthstart ='2016-07-01'):('');
                ($i == 4)?($monthstart ='2016-10-01'):('');
                ($i == 5)?($monthstart ='2016-01-01'):('');
                ($i == 1)?($choiceday ='2016-03-31'):('');
                ($i == 2)?($choiceday ='2016-06-30'):('');
                ($i == 3)?($choiceday ='2016-09-30'):('');
                ($i == 4)?($choiceday ='2016-12-31'):('');
                ($i == 5)?($choiceday ='2016-12-31'):('');
                $Qsalesformedicine = [];
                foreach ($peoples as $people) {
                    $cname = [] ;
                #每月業績保瑞
                    $monsaleboramed = array();
                    foreach ($importantarget as $code) {
                        $usercname = user::where('name','=',$people)->first();
                        $target = importantp::where('itemno','=',$code)->first();
                    #依公司區別保瑞
                        if ($target['company']=='bora') {
                        #判斷同一產品有不同產品代碼的情況
                            (isset($monsaleboramed[$target['importantproduct']])) ? (''):($monsaleboramed[$target['importantproduct']] = 0);
                            if ($code=='Others') 
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
                            }
                            else
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->where('BORAItemNo','=', $code)->get();
                            }    
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                            }

                        }
                    #依公司區別百靈佳
                        elseif ($target['company']=='boehringer') {

                            (isset($monsaleboramed[$target['importantproduct']])) ? (''):($monsaleboramed[$target['importantproduct']] = 0);
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                            }
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] - $monthsale['saletotal'];
                            }
                        }
                    }
                    $usercname = user::where('name','=',$people)->first();
                    $cname[$usercname['cname']] = $monsaleboramed;
                }
                ($i == 1)?($Q1 = $cname):('');
                ($i == 2)?($Q2 = $cname):('');
                ($i == 3)?($Q3 = $cname):('');
                ($i == 4)?($Q4 = $cname):('');
                ($i == 5)?($Q5 = $cname):('');
            }
            $Qsalesformedicine['Q1'] = $Q1;
            $Qsalesformedicine['Q2'] = $Q2;
            $Qsalesformedicine['Q3'] = $Q3;
            $Qsalesformedicine['Q4'] = $Q4;
            $Qsalesformedicine['Q5'] = $Q5;
        }
        return $Qsalesformedicine;
    }



    public static function Qbudgetmonth($cnames,$importantarget)
    {
        #Q1
        $Q1budget = array();
        $Q1pbudget = array();
        #Q2
        $Q2budget = array();
        $Q2pbudget = array();
        #Q3
        $Q3budget = array();
        $Q3pbudget = array();
        #Q4
        $Q4budget = array();
        $Q4pbudget = array();
        #Q5
        $Q5budget = array();
        $Q5pbudget = array();

        $Qbudgetmonth = array();
        foreach ($cnames as $key => $cname) {
            $budgetgpcheck = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-01-01')->where('month','<=','2016-03-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-01-01')->where('month','<=','2016-03-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q1budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                }   
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = budgetgp::where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q1budget[$BORAItemEngName['BORAItemEngName']] = 0;  
                    }       
                }    
            }
            $budgetgpscheck = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-04-01')->where('month','<=','2016-06-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-04-01')->where('month','<=','2016-06-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q2budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = budgetgp::where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q2budget[$BORAItemEngName['BORAItemEngName']] = 0;  
                    }       
                }   
            }  
            $budgetgpcheck = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-07-01')->where('month','<=','2016-09-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-07-01')->where('month','<=','2016-09-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q3budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = budgetgp::where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q3budget[$BORAItemEngName['BORAItemEngName']] = 0;  
                    }       
                }     
            }  
            $budgetgpcheck = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-10-01')->where('month','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-10-01')->where('month','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q4budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = budgetgp::where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q4budget[$BORAItemEngName['BORAItemEngName']] = 0;  
                    }       
                }     
            }  
            $budgetgpcheck = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-01-01')->where('month','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = budgetgp::selectraw('sum(budget) as budget,BORAItemEngName')->where('month','>=','2016-01-01')->where('month','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q5budget[$budgetgp['BORAItemEngName']] = $budgetgp['budget'];  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = budgetgp::where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q5budget[$BORAItemEngName['BORAItemEngName']] = 0;  
                    }       
                }     
            }
            $Q1pbudget[$cname] = $Q1budget;
            $Q2pbudget[$cname] = $Q2budget;
            $Q3pbudget[$cname] = $Q3budget;
            $Q4pbudget[$cname] = $Q4budget;
            $Q5pbudget[$cname] = $Q5budget;
        }
        $Qbudgetmonth['Q1'] = $Q1pbudget;
        $Qbudgetmonth['Q2'] = $Q2pbudget;
        $Qbudgetmonth['Q3'] = $Q3pbudget;
        $Qbudgetmonth['Q4'] = $Q4pbudget;
        $Qbudgetmonth['Q5'] = $Q5pbudget;
        return $Qbudgetmonth;
    }
}