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
use App\importantall;
use App\salesmen;
use App\calendar;
use App\dailyreport;
use App\mobicmappingdata;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail,DB;

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
                        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
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
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                    }
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
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


    public static function budgetmonth($cnames,$everyone,$choiceday,$usergroup)
    {
        $budget = array();
        $pbudget = array();
        $ab = array();
        $pab = array();
        $totals = array();
        $budgetmonth = array();
        $choiceday = substr($choiceday,0,8).'01';
        if ($usergroup=='藥品') {
            $databasebudget = 'budgetgps';
            $databaseimportant = 'importantps';
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
        }
        foreach ($cnames as $key => $cname) {
            $budgetgpscheck = DB::table($databasebudget)->where('bmonth','=',$choiceday)->where('cname','=',$cname)->count();
            if ($budgetgpscheck == 0) {
                $budgetgps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
                foreach ($budgetgps as $budgetgp) {
                    $budget[$budgetgp->importantproduct] = 0; 
                    $ab[$budgetgp->importantproduct] = 0;
                }
            }
            else
            {
                $budgetgps = DB::table($databasebudget)->where('bmonth','=',$choiceday)->where('cname','=',$cname)->get();
                foreach ($budgetgps as $budgetgp) {
                    $budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                    if ($budgetgp->budget==0) 
                    {
                        $ab[$budgetgp->BORAItemEngName]=0;
                    }
                    else
                    {
                        $ab[$budgetgp->BORAItemEngName]=round($everyone[$key][$cname][$budgetgp->BORAItemEngName]/$budgetgp->budget * 100).'%';
                    }  
                }
            }   
            $pbudget[$cname] = $budget;
            $pab[$cname] = $ab;
            if ($budgetgpscheck == 0) {
                if ($everyone[$key][$cname]<>0) {
                    $sell = array_sum($everyone[$key][$cname]);
                    $totals[$cname] = [$sell,0,0];
                }
                else
                {
                    $totals[$cname] = [0,0,0];
                }    
            }
            else
            {
                $totals[$cname] = [array_sum($everyone[$key][$cname]),array_sum($budget),round(array_sum($everyone[$key][$cname])/array_sum($budget)*100)];
            }    
        }
        array_push($budgetmonth, $pbudget,$pab,$totals);
        return $budgetmonth;
    }

    public static function Qsalesformedicine($shipping,$importantarget,$choiceday,$peoples,$usergroup)
    {
        $Qsalesformedicine = ['Q1'=>0,'Q2'=>0,'Q3'=>0,'Q4'=>0,'Q5'=>0];
        $endendday = date('t',strtotime(substr($choiceday,0,7)));
        $Q5date = substr($choiceday, 0,8).$endendday;
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
                ($i == 5)?($choiceday = $Q5date):('');
                $Qsalesformedicine = [];
                foreach ($peoples as $people) {
                    //$cname = [] ;
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
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target['importantproduct']] = $monsaleboramed[$target['importantproduct']] + $monthsale['saletotal'];
                            }
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
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



    public static function Qbudgetmonth($cnames,$choiceday,$importantarget,$usergroup)
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
        $endendday = date('t',strtotime(substr($choiceday,0,7)));
        $Q5date = substr($choiceday, 0,8).$endendday;
        if ($usergroup=='藥品') {
            $databasebudget = 'budgetgps';
            $databaseimportant = 'importantps';
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
        }
        $Qbudgetmonth = array();
        foreach ($cnames as $key => $cname) {
            $budgetgpcheck = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=','2016-03-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=','2016-03-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q1budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = DB::table($databasebudget)->where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q1budget[$BORAItemEngName->BORAItemEngName] = 0;  
                    }       
                }   
            }  
            $budgetgpcheck = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-04-01')->where('bmonth','<=','2016-06-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-04-01')->where('bmonth','<=','2016-06-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q2budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = DB::table($databasebudget)->where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q2budget[$BORAItemEngName->BORAItemEngName] = 0;  
                    }       
                }   
            }  
            $budgetgpcheck = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-07-01')->where('bmonth','<=','2016-09-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-07-01')->where('bmonth','<=','2016-09-30')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q3budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = DB::table($databasebudget)->where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q3budget[$BORAItemEngName->BORAItemEngName] = 0;  
                    }       
                }   
            }  
            $budgetgpcheck = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-10-01')->where('bmonth','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-10-01')->where('bmonth','<=','2016-12-31')->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q4budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = DB::table($databasebudget)->where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q4budget[$BORAItemEngName->BORAItemEngName] = 0;  
                    }       
                }   
            }   
            $budgetgpcheck = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=',$Q5date)->where('cname','=',$cname)->GroupBy('BORAItemEngName')->count();
            $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=',$Q5date)->where('cname','=',$cname)->GroupBy('BORAItemEngName')->get();
            if ($budgetgpcheck>0) 
            {
                foreach ($budgetgps as $budgetgp) {
                    $Q5budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                }    
            }
            else
            {    
                foreach ($importantarget as $budgetgp) {
                    $BORAItemEngName = DB::table($databasebudget)->where('BORAItemNo','=',$budgetgp)->first();
                    if (isset($BORAItemEngName)) {
                        $Q5budget[$BORAItemEngName->BORAItemEngName] = 0;  
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


    public static function ach($shipping,$importantarget,$peoples,$usergroup)
    {
        $limit = date('m');
        $monsaleboramed = [];
        $ach = [];
        if ($usergroup=='藥品') {
            $databasebudget = 'budgetgps';
            $databaseimportant = 'importantps';
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
        }
        if (!empty($peoples)) {
            foreach ($peoples as $people) {
                $monsaleboramed = [];
                $achnocode = [];
                for ($i=1 ; $i <= $limit ; $i++)
                { 
                    $allstart = '2016-'.$i.'-01';
                    $endstartday = '2016-'.$i.'-';
                    $endendday = date('t',strtotime("2016-".$i));
                    $allend = $endstartday.$endendday;
                    $usercname = user::where('name','=',$people)->first();
                    #每月業績保瑞
                    $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativegroup','=',$usergroup)->where("SalesRepresentativeName",'=',$usercname['cname'])->where('InvDate','>=',$allstart)->where('InvDate','<=',$allend)->get();
                    foreach ($monthsales as $monthsale) {
                        $monsalebora = $monthsale['saletotal'];
                    }
                    #每月業績裕利加
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('Date','>=',$allstart)->where('Date','<=',$allend)->where('SaleType','=','A2')->whereNotIn('ItemNo', ['A0195'])->get();
                    foreach ($monthsales as $monthsale) {
                        $monsalemobicgain = $monthsale['saletotal'];
                    } 
                    #每月業績裕利減 
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('Date','>=',$allstart)->where('Date','<=',$allend)->where('SaleType','=','R2')->whereNotIn('ItemNo', ['A0195'])->get();
                    foreach ($monthsales as $monthsale) {
                        $monsalemobicreturn = $monthsale['saletotal'];
                    }  
                    #每月業績合計
                    $monsale = $monsalebora + $monsalemobicgain - $monsalemobicreturn;
                    $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget')->where('bmonth','=',$allstart)->where('cname','=',$usercname['cname'])->count();
                    $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget')->where('bmonth','=',$allstart)->where('cname','=',$usercname['cname'])->get();
                    foreach ($budgetgps as $budgetgp) {
                        if ($budgetgpcount>0) 
                        {
                            $achchart = round($monsale/$budgetgp->budget * 100);
                        }
                        else
                        {
                            $achchart = 0;
                        }
                    }
                    array_push($monsaleboramed,$achchart);
                    $achnocode[$usercname['cname']] = $monsaleboramed;
                    $ach[$people]= $achnocode;
                }
            }
        }
        return $ach;
    }
    public static function radiomedaccess()
    {
        $sellaccess = [];
        $medaccessexist = DB::table('importantalls')->where('owner','=',Auth::user()->cname)->count();
        if ($medaccessexist>0) 
        {
            $medaccess = DB::table('importantalls')->where('owner','=',Auth::user()->cname)->first();
            $medaccess =  $medaccess->group;
            $limit =  mb_strlen($medaccess);
            for ($i=0; $i < $limit ; $i = $i + 2 ) { 
                $sellaccess[] = mb_substr($medaccess,$i,2);
            }
        }

        return $sellaccess;
    }
    public static function products()
    {
        $productsselect = [];
        $products = importantall::distinct()->select('importantproduct')->where('owner','=',Auth::user()->cname)->get();
        foreach ($products as $product) {
            $productsselect[] = $product['importantproduct'];
        }
        return $productsselect;
    }
    public static function providerinfo()
    {
        $providerinfo = [];
        $providers = DB::table('providerinfos')->where('owner','=',Auth::user()->cname)->get();
        foreach ($providers as $provider) {
            $providerinfo[$provider->group] = $provider->display;
        }
        return $providerinfo;
    }    
    public static function allitems()
    {
        $items = importantp::all();
        foreach ($items as $item) {
            $allitems[] = $item['itemno'];
        }
        return $allitems;
    }
    public static function productssell($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$allitems)
    {
        $productsell = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $itemcode = [];
            $codes = importantall::where('importantproduct','=',$value)->get();
            foreach ($codes as $code) {
                $itemcode[] = $code['itemno'];
            }
            $productsell[$value] = 0 ;
            if ($itemcode[0]=='Others') {
                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->whereIn('SalesRepresentativegroup',$medaccess)->whereNotIn('BORAItemNo',$allitems)->where('InvDate','>=',$monthstartmed)->where('InvDate','<=',$choicedaymed)->get();
            }
            else
            {
                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->whereIn('SalesRepresentativegroup',$medaccess)->whereIn('BORAItemNo',$itemcode)->where('InvDate','>=',$monthstartmed)->where('InvDate','<=',$choicedaymed)->get();
            }    
            
            foreach ($monthsales as $monthsale) {
                $productsell[$value] = $monthsale['saletotal'];
            }
            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','A2')->where('Date','>=',$monthstartmed)->where('Date','<=',$choicedaymed)->whereIn('ItemNo', $itemcode)->get(); 
            foreach ($monthsales as $monthsale) {
               $productsell[$value] = $productsell[$value] + $monthsale['saletotal'] ;
            }
            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','R2')->where('Date','>=',$monthstartmed)->where('Date','<=',$choicedaymed)->whereIn('ItemNo', $itemcode)->get(); 
            foreach ($monthsales as $monthsale) {
               $productsell[$value] = $productsell[$value] - $monthsale['saletotal'] ;
            }
        }
        return $productsell;
    }
    public static function productsbudget($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess)
    {
        $producbudget = [];
        $inputselect = $medvalue;
        foreach ($medaccess as $usergroup) 
        {
            if ($usergroup=='藥品') {
                $databasebudget = 'budgetgps';
            }
            elseif ($usergroup=='醫院') 
            {
                $databasebudget = 'budgethps';
            }
            foreach ($inputselect as $value) {
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','=',$monthstartmed)->where('BORAItemEngName','=',$value)->GroupBy('BORAItemEngName')->get();
                foreach ($budgetgps as $budget) {
                    if (!isset($producbudget[$budget->BORAItemEngName])) {
                        $producbudget[$budget->BORAItemEngName]=$budget->budget;
                    }
                    else
                    {
                        $producbudget[$budget->BORAItemEngName]=$producbudget[$budget->BORAItemEngName] + $budget->budget;
                    }    
                }
            }
        }
        return $producbudget;
    }
    public static function productssellQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$allitems)
    {
        $productsellQ = [];
        $inputselect = $medvalue;
        for ($i=1; $i <= 5 ; $i++) {         
            ($i == 1)?($monthstart ='2016-01-01'):('');
            ($i == 2)?($monthstart ='2016-04-01'):('');
            ($i == 3)?($monthstart ='2016-07-01'):('');
            ($i == 4)?($monthstart ='2016-10-01'):('');
            ($i == 5)?($monthstart ='2016-01-01'):('');
            ($i == 1)?($choiceday  ='2016-03-31'):('');
            ($i == 2)?($choiceday  ='2016-06-30'):('');
            ($i == 3)?($choiceday  ='2016-09-30'):('');
            ($i == 4)?($choiceday  ='2016-12-31'):('');
            ($i == 5)?($choiceday  = $choicedaymed):('');
            foreach ($inputselect as $value) {
                $itemcode = [];
                $codes = importantall::where('importantproduct','=',$value)->get();
                foreach ($codes as $code) {
                    $itemcode[] = $code['itemno'];
                }

                $productsell[$value] = 0 ;
                if ($itemcode[0]=='Others') {
                    $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo',$allitems)->whereIn('SalesRepresentativegroup',$medaccess)->get();
                }
                else
                {
                    $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereIn('BORAItemNo',$itemcode)->whereIn('SalesRepresentativegroup',$medaccess)->get();
                }    
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $monthsale['saletotal'];
                }
                $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->whereIn('ItemNo', $itemcode)->get(); 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $productsell[$value] + $monthsale['saletotal'] ;
                }
                $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->whereIn('ItemNo', $itemcode)->get(); 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $productsell[$value] - $monthsale['saletotal'] ;
                }
                ($i == 1)?($productsellQ['Q1'] = $productsell):('');
                ($i == 2)?($productsellQ['Q2'] = $productsell):('');
                ($i == 3)?($productsellQ['Q3'] = $productsell):('');
                ($i == 4)?($productsellQ['Q4'] = $productsell):('');
                ($i == 5)?($productsellQ['Q5'] = $productsell):('');
            }
        }
        return $productsellQ;
    }
    public static function productsbudgetQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess)
    {
        $producbudget1 = [];
        $producbudget2 = [];
        $producbudget3 = [];
        $producbudget4 = [];
        $producbudget5 = [];
        $producbudgetq = [];
        $inputselect = $medvalue;
        foreach ($medaccess as $usergroup) {
            if ($usergroup=='藥品') {
                $databasebudget = 'budgetgps';
            }
            elseif ($usergroup=='醫院') {
                $databasebudget = 'budgethps';
            }
            foreach ($inputselect as $value) {
                $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=','2016-03-31')->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=','2016-03-31')->where('BORAItemEngName','=',$value)->get();
                if ($budgetgpcount>0) 
                {
                    foreach ($budgetgps as $budget) 
                    {
                        if (isset($producbudget1[$budget->BORAItemEngName])) 
                        {
                            $producbudget1[$budget->BORAItemEngName]= $producbudget1[$budget->BORAItemEngName] + $budget->budget;
                        }
                        else
                        {
                            $producbudget1[$budget->BORAItemEngName]=$budget->budget;
                        }    
                    }    
                }
                else
                {
                    if (!isset($producbudget1[$value])) 
                    {
                        $producbudget1[$value]=0;
                    }  
                }
                $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-04-01')->where('bmonth','<=','2016-06-30')->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-04-01')->where('bmonth','<=','2016-06-30')->where('BORAItemEngName','=',$value)->get();
                if ($budgetgpcount>0) 
                {
                    foreach ($budgetgps as $budget) 
                    {
                        if (isset($producbudget2[$budget->BORAItemEngName])) 
                        {
                            $producbudget2[$budget->BORAItemEngName]= $producbudget2[$budget->BORAItemEngName] + $budget->budget;
                        }
                        else
                        {
                            $producbudget2[$budget->BORAItemEngName]=$budget->budget;
                        }    
                    }    
                }
                else
                {
                    if (!isset($producbudget2[$value])) 
                    {
                        $producbudget2[$value]=0;
                    }  
                }
                $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-07-01')->where('bmonth','<=','2016-09-30')->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-07-01')->where('bmonth','<=','2016-09-30')->where('BORAItemEngName','=',$value)->get();
                if ($budgetgpcount>0) 
                {
                    foreach ($budgetgps as $budget) 
                    {
                        if (isset($producbudget3[$budget->BORAItemEngName])) 
                        {
                            $producbudget3[$budget->BORAItemEngName]= $producbudget3[$budget->BORAItemEngName] + $budget->budget;
                        }
                        else
                        {
                            $producbudget3[$budget->BORAItemEngName]=$budget->budget;
                        }    
                    }    
                }
                else
                {
                    if (!isset($producbudget3[$value])) 
                    {
                        $producbudget3[$value]=0;
                    }  
                }
                $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-10-01')->where('bmonth','<=','2016-12-31')->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-10-01')->where('bmonth','<=','2016-12-31')->where('BORAItemEngName','=',$value)->get();
                if ($budgetgpcount>0) 
                {
                    foreach ($budgetgps as $budget) 
                    {
                        if (isset($producbudget4[$budget->BORAItemEngName])) 
                        {
                            $producbudget4[$budget->BORAItemEngName]= $producbudget4[$budget->BORAItemEngName] + $budget->budget;
                        }
                        else
                        {
                            $producbudget4[$budget->BORAItemEngName]=$budget->budget;
                        }    
                    }    
                }
                else
                {
                    if (!isset($producbudget4[$value])) 
                    {
                        $producbudget4[$value]=0;
                    }  
                }
                $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=',$choicedaymed)->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','>=','2016-01-01')->where('bmonth','<=',$choicedaymed)->where('BORAItemEngName','=',$value)->get();
                if ($budgetgpcount>0) 
                {
                    foreach ($budgetgps as $budget) 
                    {
                        if (isset($producbudget5[$budget->BORAItemEngName])) 
                        {
                            $producbudget5[$budget->BORAItemEngName]= $producbudget5[$budget->BORAItemEngName] + $budget->budget;
                        }
                        else
                        {
                            $producbudget5[$budget->BORAItemEngName]=$budget->budget;
                        }    
                    }    
                }
                else
                {
                    if (!isset($producbudget5[$value])) 
                    {
                        $producbudget5[$value]=0;
                    }  
                }
            }
            $producbudgetq['Q1'] = $producbudget1;
            $producbudgetq['Q2'] = $producbudget2;
            $producbudgetq['Q3'] = $producbudget3;
            $producbudgetq['Q4'] = $producbudget4;
            $producbudgetq['Q5'] = $producbudget5;
        }
        return $producbudgetq;
    }
    public static function yearach($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$allitems)
    {
        $limit = date('m');
        $productsell = [];
        $yearach = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $medeverymon = [];
            $itemcode = [];
            $codes = importantall::where('importantproduct','=',$value)->get();
            foreach ($codes as $code) {
                $itemcode[] = $code['itemno'];
            }
            $productsell[$value] = 0 ;
            for ($i=1; $i <= $limit ; $i++) { 
                $allstart = '2016-'.$i.'-01';
                $endstartday = '2016-'.$i.'-';
                $endendday = date('t',strtotime("2016-".$i));
                $allend = $endstartday.$endendday;      
                if ($itemcode[0]=='Others') 
                {
                    $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->whereNotIn('BORAItemNo',$allitems)->whereIn('SalesRepresentativegroup',$medaccess)->where('InvDate','>=',$allstart)->where('InvDate','<=',$allend)->get();
                }       
                else
                {
                    $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->whereIn('BORAItemNo',$itemcode)->whereIn('SalesRepresentativegroup',$medaccess)->where('InvDate','>=',$allstart)->where('InvDate','<=',$allend)->get();
                } 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $monthsale['saletotal'];
                }
                $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','A2')->where('Date','>=',$allstart)->where('Date','<=',$allend)->whereIn('ItemNo', $itemcode)->get(); 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $productsell[$value] + $monthsale['saletotal'] ;
                }
                $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->whereIn('dep',$medaccess)->where('SaleType','=','R2')->where('Date','>=',$allstart)->where('Date','<=',$allend)->whereIn('ItemNo', $itemcode)->get(); 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $productsell[$value] - $monthsale['saletotal'] ;
                }
                foreach ($medaccess as $usergroup) {
                    if ($usergroup=='藥品') {
                        $databasebudget = 'budgetgps';
                    }
                    elseif ($usergroup=='醫院') 
                    {
                        $databasebudget = 'budgethps';
                    }
                    $budgetgpcount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','=',$allstart)->where('BORAItemEngName','=',$value)->count();
                    $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','=',$allstart)->where('BORAItemEngName','=',$value)->get();
                    if ($budgetgpcount>0) 
                    {
                        foreach ($budgetgps as $budget) 
                        {
                            if (isset($producbudget[$budget->BORAItemEngName])) 
                            {
                                $producbudget[$budget->BORAItemEngName] = $producbudget[$budget->BORAItemEngName] + $budget->budget;
                            }
                            else
                            {
                                $producbudget[$budget->BORAItemEngName] = $budget->budget;
                            }    
                        }  
                    }
                    else
                    {
                        if (!isset($producbudget[$value])) 
                        {
                            $producbudget[$value]=0;
                        }  
                    }
                }    
                ($producbudget[$value]<>0)?( $medeverymon[] =  round(($productsell[$value]/$producbudget[$value])*100) ):( $medeverymon[]=0 ) ;
                $yearach[$value] = $medeverymon;
                $producbudget[$value] = 0;
            }
        }
        return $yearach;
    }
}