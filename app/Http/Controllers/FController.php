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
   
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#這邊開始是算人員月售,季銷,年銷
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public static function teampeople()
    {
        $teampall = [];
        $teams = DB::table('importantallsheadp')->where('owner','=',Auth::user()->cname)->orderBy('sortid','asc')->get();
        foreach ($teams as $team) {
            $teampall[$team->group] = $team->category;
        }
        return $teampall;
    }
    
    public static function salesformedicine($shipping,$importantarget,$peoples,$usergroup,$choiceday,$monthstart,$db)
    {
        $finaldata = [] ;
        foreach ($peoples as $people) {
            $cname = [] ;
            #每月業績保瑞
            $monsaleboramed = array();
            foreach ($importantarget as $code) {
                $usercname = user::where('name','=',$people)->first();
                $target = DB::table($db)->where('itemno','=',$code)->first();
                //$target = importantp::where('itemno','=',$code)->first();
                #依公司區別保瑞
                if ($target->company=='bora') {
                #判斷同一產品有不同產品代碼的情況
                    (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                    if ($code=='Others') 
                    {
                        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
                    }
                    else
                    {
                        $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->where('BORAItemNo','=', $code)->get();
                    }    
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                    }
                }
                #依公司區別百靈佳
                elseif ($target->company=='boehringer') {

                    (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                    }
                    $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                    foreach ($monthsales as $monthsale) {
                        $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] - $monthsale['saletotal'];
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
        $importantall = array();
        $choiceday = substr($choiceday,0,8).'01';
        if ($usergroup=='藥品') {
            $databasebudget = 'budgetgps';
            $databaseimportant = 'importantps';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='保健') {
            $databasebudget = 'budgetheals';
            $databaseimportant = 'importantheals';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        foreach ($cnames as $key => $cname) {
            $budgetgpscheck = DB::table($databasebudget)->where('bmonth','=',$choiceday)->where('cname','=',$cname)->count();
            //離職人員使用判斷
            if ($budgetgpscheck == 0) {
                $budgetgps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
                foreach ($budgetgps as $budgetgp) {
                    $budget[$budgetgp->importantproduct] = 0; 
                    $ab[$budgetgp->importantproduct] = 0;
                }
            }
            //在職人員使用判斷
            else
            {
                foreach ($importantall as $value) {
                    $budgetgpcount = DB::table($databasebudget)->where('BORAItemEngName','=',$value)->where('bmonth','=',$choiceday)->where('cname','=',$cname)->count();
                    if ($budgetgpcount==0) {
                        $budget[$value] = 0;
                        $ab[$value]=0; 

                    }
                    else
                    {
                        $budgetgps = DB::table($databasebudget)->where('BORAItemEngName','=',$value)->where('bmonth','=',$choiceday)->where('cname','=',$cname)->get();
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

    //每季包括年的銷售
    public static function Csalesformedicine($shipping,$importantarget,$choiceday,$peoples,$usergroup,$db)
    {
        $year = substr($choiceday,0,4) ;
        $Qsalesformedicine = ['C1'=>0,'C2'=>0,'C3'=>0,'C4'=>0,'C5'=>0,'C6'=>0];
        $endendday = date('t',strtotime(substr($choiceday,0,7)));
        $Q5date = substr($choiceday, 0,8).$endendday;
        if (!empty($peoples)) {
            for ($i=1; $i <= 6; $i++)
            { 
                ($i == 1)?($C1 = []):('');
                ($i == 2)?($C2 = []):('');
                ($i == 3)?($C3 = []):('');
                ($i == 4)?($C4 = []):('');   
                ($i == 5)?($C5 = []):(''); 
                ($i == 6)?($C6 = []):('');         
                ($i == 1)?($monthstart = $year.'-01-01'):('');
                ($i == 2)?($monthstart = $year.'-03-01'):('');
                ($i == 3)?($monthstart = $year.'-05-01'):('');
                ($i == 4)?($monthstart = $year.'-07-01'):('');
                ($i == 5)?($monthstart = $year.'-09-01'):('');
                ($i == 6)?($monthstart = $year.'-11-01'):('');
                ($i == 1)?($choiceday  = $year.'-02-29'):('');
                ($i == 2)?($choiceday  = $year.'-04-30'):('');
                ($i == 3)?($choiceday  = $year.'-06-30'):('');
                ($i == 4)?($choiceday  = $year.'-08-31'):('');
                ($i == 5)?($choiceday  = $year.'-10-31'):('');
                ($i == 6)?($choiceday  = $year.'-12-31'):('');
                $Qsalesformedicine = [];
                foreach ($peoples as $people) {
                    //$cname = [] ;
                    #每月業績保瑞
                    $monsaleboramed = array();
                    foreach ($importantarget as $code) {
                        $usercname = user::where('name','=',$people)->first();
                        $target = DB::table($db)->where('itemno','=',$code)->first();
                        //$target = importantp::where('itemno','=',$code)->first();
                        #依公司區別保瑞
                        if ($target->company=='bora') {
                        #判斷同一產品有不同產品代碼的情況
                            (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                            if ($code=='Others') 
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
                            }
                            else
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->where('BORAItemNo','=', $code)->get();
                            }    
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                            }

                        }
                        #依公司區別百靈佳
                        elseif ($target->company=='boehringer') {

                            (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                            }
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] - $monthsale['saletotal'];
                            }
                        }
                    }
                    $usercname = user::where('name','=',$people)->first();
                    $cname[$usercname['cname']] = $monsaleboramed;
                }
                ($i == 1)?($C1 = $cname):('');
                ($i == 2)?($C2 = $cname):('');
                ($i == 3)?($C3 = $cname):('');
                ($i == 4)?($C4 = $cname):('');
                ($i == 5)?($C5 = $cname):('');
                ($i == 6)?($C6 = $cname):('');
            }
            $Qsalesformedicine['C1'] = $C1;
            $Qsalesformedicine['C2'] = $C2;
            $Qsalesformedicine['C3'] = $C3;
            $Qsalesformedicine['C4'] = $C4;
            $Qsalesformedicine['C5'] = $C5;
            $Qsalesformedicine['C6'] = $C6;
        }
        return $Qsalesformedicine;
    }



    //每季包括年的銷售
    public static function Qsalesformedicine($shipping,$importantarget,$choiceday,$peoples,$usergroup,$db)
    {
        $year = substr($choiceday,0,4) ;
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
                ($i == 1)?($monthstart = $year.'-01-01'):('');
                ($i == 2)?($monthstart = $year.'-04-01'):('');
                ($i == 3)?($monthstart = $year.'-07-01'):('');
                ($i == 4)?($monthstart = $year.'-10-01'):('');
                ($i == 5)?($monthstart = $year.'-01-01'):('');
                ($i == 1)?($choiceday =  $year.'-03-31'):('');
                ($i == 2)?($choiceday =  $year.'-06-30'):('');
                ($i == 3)?($choiceday =  $year.'-09-30'):('');
                ($i == 4)?($choiceday =  $year.'-12-31'):('');
                ($i == 5)?($choiceday = $Q5date):('');
                $Qsalesformedicine = [];
                foreach ($peoples as $people) {
                    //$cname = [] ;
                    #每月業績保瑞
                    $monsaleboramed = array();
                    foreach ($importantarget as $code) {
                        $usercname = user::where('name','=',$people)->first();
                        $target = DB::table($db)->where('itemno','=',$code)->first();
                        //$target = importantp::where('itemno','=',$code)->first();
                        #依公司區別保瑞
                        if ($target->company=='bora') {
                        #判斷同一產品有不同產品代碼的情況
                            (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                            if ($code=='Others') 
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('BORAItemNo', $importantarget)->get();
                            }
                            else
                            {
                                $monthsales = dailyreport::selectraw('sum(InoviceAmt) as saletotal')->where('SalesRepresentativeName','=',$usercname['cname'])->where('SalesRepresentativegroup','=',$usergroup)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->where('BORAItemNo','=', $code)->get();
                            }    
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                            }

                        }
                        #依公司區別百靈佳
                        elseif ($target->company=='boehringer') {

                            (isset($monsaleboramed[$target->importantproduct])) ? (''):($monsaleboramed[$target->importantproduct] = 0);
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','A2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] + $monthsale['saletotal'];
                            }
                            $monthsales = mobicmappingdata::selectraw('sum(Amount) as saletotal')->where('dep','=',$usergroup)->where('salename','=',$usercname['cname'])->where('SaleType','=','R2')->where('Date','>=',$monthstart)->where('Date','<=',$choiceday)->where('ItemNo','=',$code)->get(); 
                            foreach ($monthsales as $monthsale) {
                                $monsaleboramed[$target->importantproduct] = $monsaleboramed[$target->importantproduct] - $monthsale['saletotal'];
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

    //每季包括年的預算
    public static function Cbudgetmonth($cnames,$choiceday,$importantarget,$usergroup)
    {
        $year = substr($choiceday,0,4) ;
        #C1
        $Q1budget = array();
        $Q1pbudget = array();
        #C2
        $Q2budget = array();
        $Q2pbudget = array();
        #C3
        $Q3budget = array();
        $Q3pbudget = array();
        #C4
        $Q4budget = array();
        $Q4pbudget = array();
        #C5
        $Q5budget = array();
        $Q5pbudget = array();
        #C5
        $Q6budget = array();
        $Q6pbudget = array();

        //$endendday = date('t',strtotime(substr($choiceday,0,7)));
        //$Q5date = substr($choiceday, 0,8).$endendday;

        if ($usergroup=='藥品') {
            $databasebudget = 'budgetgps';
            $databaseimportant = 'importantps';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='保健') {
            $databasebudget = 'budgetheals';
            $databaseimportant = 'importantheals';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        $Qbudgetmonth = array();
        foreach ($cnames as $key => $cname) {
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-02-29')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-02-29')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-02-29')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q1budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q1budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q1budget[$value] = 0; 
                }    
            }  
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-03-01')->where('bmonth','<=',$year.'-04-30')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-03-01')->where('bmonth','<=',$year.'-04-30')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-03-01')->where('bmonth','<=',$year.'-04-30')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q2budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q2budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q2budget[$value] = 0; 
                }    
            }   
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-05-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-05-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-05-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q3budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q3budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q3budget[$value] = 0; 
                }    
            }   
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-08-31')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-08-31')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-08-31')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q4budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q4budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q4budget[$value] = 0; 
                }    
            }  
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-09-01')->where('bmonth','<=',$year.'-10-31')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-09-01')->where('bmonth','<=',$year.'-10-31')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-09-01')->where('bmonth','<=',$year.'-10-31')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q5budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q5budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q5budget[$value] = 0; 
                }    
            }    
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-11-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-11-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-11-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q6budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q6budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q6budget[$value] = 0; 
                }    
            }      
            $Q1pbudget[$cname] = $Q1budget;
            $Q2pbudget[$cname] = $Q2budget;
            $Q3pbudget[$cname] = $Q3budget;
            $Q4pbudget[$cname] = $Q4budget;
            $Q5pbudget[$cname] = $Q5budget;
            $Q6pbudget[$cname] = $Q6budget;
        }
        $Qbudgetmonth['C1'] = $Q1pbudget;
        $Qbudgetmonth['C2'] = $Q2pbudget;
        $Qbudgetmonth['C3'] = $Q3pbudget;
        $Qbudgetmonth['C4'] = $Q4pbudget;
        $Qbudgetmonth['C5'] = $Q5pbudget;
        $Qbudgetmonth['C6'] = $Q6pbudget;
        return $Qbudgetmonth;
    }

    //每季包括年的預算
    public static function Qbudgetmonth($cnames,$choiceday,$importantarget,$usergroup)
    {
        $year = substr($choiceday,0,4) ;
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
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='醫院') {
            $databasebudget = 'budgethps';
            $databaseimportant = 'importanths';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        elseif ($usergroup=='保健') {
            $databasebudget = 'budgetheals';
            $databaseimportant = 'importantheals';
            $importantps = DB::table($databaseimportant)->distinct()->select('importantproduct')->get();
            foreach ($importantps as $importantp) {
                $importantall[] = $importantp->importantproduct;
            }
        }
        $Qbudgetmonth = array();
        foreach ($cnames as $key => $cname) {
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-03-31')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-03-31')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-03-31')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q1budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q1budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q1budget[$value] = 0; 
                }    
            }  
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-04-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-04-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-04-01')->where('bmonth','<=',$year.'-06-30')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q2budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q2budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q2budget[$value] = 0; 
                }    
            }   
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-09-30')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-09-30')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-09-30')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q3budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q3budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q3budget[$value] = 0; 
                }    
            }   
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-10-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-10-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-10-01')->where('bmonth','<=',$year.'-12-31')->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q4budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q4budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q4budget[$value] = 0; 
                }    
            }    
            $budgetgpcheck = DB::table($databasebudget)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$Q5date)->where('cname','=',$cname)->count();
            if ($budgetgpcheck>0) 
            {
                foreach ($importantall as $value) {
                    $budgetgpscount = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$Q5date)->where('cname','=',$cname)->count();
                    if ($budgetgpscount>0) {
                        $budgetgps = DB::table($databasebudget)->selectraw('sum(budget) as budget,BORAItemEngName')->where('BORAItemEngName','=',$value)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$Q5date)->where('cname','=',$cname)->get();
                        foreach ($budgetgps as $budgetgp) {
                            $Q5budget[$budgetgp->BORAItemEngName] = $budgetgp->budget;  
                        } 
                    }
                    else
                    {
                        $Q5budget[$value] = 0;
                    }    
                }   
            }
            else
            {    

                foreach ($importantall as $value) {
                    $Q5budget[$value] = 0; 
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

    //線形圖
    public static function ach($shipping,$importantarget,$peoples,$usergroup,$choiceday)
    {
        $limit = substr($choiceday,5,2);
        $year = substr($choiceday,0,4);
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
        elseif ($usergroup=='保健') {
            $databasebudget = 'budgetheals';
            $databaseimportant = 'importantheals';
        }
        if (!empty($peoples)) {
            foreach ($peoples as $people) {
                $monsaleboramed = [];
                $achnocode = [];
                for ($i=1 ; $i <= $limit ; $i++)
                { 
                    $allstart = $year.'-'.$i.'-01';
                    $endstartday = $year .'-'.$i.'-';
                    $endendday = date('t',strtotime($year.'-'.$i));
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
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#這邊開始是算藥品月售,季銷,年銷
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    //拆字歸納權限(藥品,醫院)
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
    //組別分類
    public static function team()
    {
        $teamall = [];
        $teams = DB::table('importantallshead')->where('owner','=',Auth::user()->cname)->get();
        foreach ($teams as $team) {
            $teamall[$team->group] = $team->category;
        }
        return $teamall;
    }
    //組合選單權限(藥品,醫院,裕利等等)
    public static function provideraccess($provider)
    {
        $allaccess=[];
        $paccess = [];
        $buaccess=[];
        $companyaccess=[];
        $i = 0;
        $provideraccessexist = DB::table('providerinfos')->where('owner','=',Auth::user()->cname)->count();
        if (count($provideraccessexist)>0) {
            foreach ($provider as $value) {
                $provideraccessexist = DB::table('providerinfos')->where('owner','=',Auth::user()->cname)->where('display','=',$value)->get();
                foreach ($provideraccessexist as $provideraccess) {
                    $paccess[] = $provideraccess->group;
                    $buaccess[] = $provideraccess->bugroup;
                    $companyaccess[]=$provideraccess->company;       
                }
            } 
        $allaccess[]=$companyaccess;
        $allaccess[]=$paccess;  
        $allaccess[]=$buaccess;    
        }
        return $allaccess;
    }
    //撈所有品項排除主要計算others    
    public static function allitems($radioadmin)
    {
        $allitems = [];
        $radioadmin = str_replace('"','',$radioadmin);
        $items = DB::table('importantalls')->where('group','=',$radioadmin)->where('owner','=',Auth::user()->cname)->get();
        foreach ($items as $item) {
            if ($item->itemno<>'Others') {
                $allitems[] = $item->itemno;
            }
        }
        return $allitems;
    }
    public static function productssell($medvalue,$choicedaymed,$monthstartmed,$usergroup,$allitems,$provideraccess,$companyaccess)
    {
        $productsell = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $itemcode = [];
            $codes = importantall::distinct()->select('itemno')->where('importantproduct','=',$value)->get();
            foreach ($codes as $code) {
                $itemcode[] = $code['itemno'];
            }
            $productsell[$value] = 0 ;
            if ($itemcode[0]=='Others') {
                $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->whereIn('Salesgroup',$provideraccess)->whereNotIn('Itemno',$allitems)->whereIn('Company',$companyaccess)->where('InvDate','>=',$monthstartmed)->where('InvDate','<=',$choicedaymed)->get();
            }
            else
            {
                $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->whereIn('Salesgroup',$provideraccess)->whereIn('Itemno',$itemcode)->whereIn('Company',$companyaccess)->where('InvDate','>=',$monthstartmed)->where('InvDate','<=',$choicedaymed)->get();
            }    
            
            foreach ($monthsales as $monthsale) {
                $productsell[$value] = $monthsale->saletotal;
            }
        }
        return $productsell;
    }
    public static function productsbudget($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$providerbuaccess,$companyaccess)
    {
        $producbudget = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','=',$monthstartmed)->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('BORAItemEngName','=',$value)->GroupBy('BORAItemEngName')->count();
            if ($budgetgps>0) {
                $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->where('bmonth','=',$monthstartmed)->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('BORAItemEngName','=',$value)->GroupBy('BORAItemEngName')->get();
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
            else
            {
                $producbudget[$value]=0;
            }    
        }
        return $producbudget;
    }
    public static function productssellC($medvalue,$choicedaymed,$monthstartmed,$usergroup,$allitems,$provideraccess,$companyaccess)
    {
        $productsellQ = [];
        $year = substr($choicedaymed,0,4);
        $inputselect = $medvalue;
        for ($i=1; $i <= 6 ; $i++) {         
            ($i == 1)?($monthstart = $year.'-01-01'):('');
            ($i == 2)?($monthstart = $year.'-03-01'):('');
            ($i == 3)?($monthstart = $year.'-05-01'):('');
            ($i == 4)?($monthstart = $year.'-07-01'):('');
            ($i == 5)?($monthstart = $year.'-09-01'):('');
            ($i == 6)?($monthstart = $year.'-11-01'):('');
            ($i == 1)?($choiceday  = $year.'-02-29'):('');
            ($i == 2)?($choiceday  = $year.'-04-30'):('');
            ($i == 3)?($choiceday  = $year.'-06-30'):('');
            ($i == 4)?($choiceday  = $year.'-08-31'):('');
            ($i == 5)?($choiceday  = $year.'-10-31'):('');
            ($i == 6)?($choiceday  = $year.'-12-31'):('');
            foreach ($inputselect as $value) {
                $itemcode = [];
                $codes = importantall::where('importantproduct','=',$value)->get();
                foreach ($codes as $code) {
                    $itemcode[] = $code['itemno'];
                }

                $productsell[$value] = 0 ;
                if ($itemcode[0]=='Others') 
                {
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('Itemno',$allitems)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();

                }
                else
                {   
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereIn('Itemno',$itemcode)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();
                }    
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $monthsale->saletotal;
                    if (empty($productsell[$value])) {
                        $productsell[$value] = 0 ;
                    }
                }
                ($i == 1)?($productsellQ['C1'] = $productsell):('');
                ($i == 2)?($productsellQ['C2'] = $productsell):('');
                ($i == 3)?($productsellQ['C3'] = $productsell):('');
                ($i == 4)?($productsellQ['C4'] = $productsell):('');
                ($i == 5)?($productsellQ['C5'] = $productsell):('');
                ($i == 6)?($productsellQ['C6'] = $productsell):('');
            }
        }
        return $productsellQ;
    }
    public static function productssellQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$allitems,$provideraccess,$companyaccess)
    {
        $productsellQ = [];
        $year = substr($choicedaymed,0,4);
        $inputselect = $medvalue;
        for ($i=1; $i <= 5 ; $i++) {         
            ($i == 1)?($monthstart = $year.'-01-01'):('');
            ($i == 2)?($monthstart = $year.'-04-01'):('');
            ($i == 3)?($monthstart = $year.'-07-01'):('');
            ($i == 4)?($monthstart = $year.'-10-01'):('');
            ($i == 5)?($monthstart = $year.'-01-01'):('');
            ($i == 1)?($choiceday  = $year.'-03-31'):('');
            ($i == 2)?($choiceday  = $year.'-06-30'):('');
            ($i == 3)?($choiceday  = $year.'-09-30'):('');
            ($i == 4)?($choiceday  = $year.'-12-31'):('');
            ($i == 5)?($choiceday  = $choicedaymed):('');
            foreach ($inputselect as $value) {
                $itemcode = [];
                $codes = importantall::where('importantproduct','=',$value)->get();
                foreach ($codes as $code) {
                    $itemcode[] = $code['itemno'];
                }

                $productsell[$value] = 0 ;
                if ($itemcode[0]=='Others') 
                {
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereNotIn('Itemno',$allitems)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();

                }
                else
                {   
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$monthstart)->where('InvDate','<=',$choiceday)->whereIn('Itemno',$itemcode)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();
                }    
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $monthsale->saletotal;
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
    public static function productsbudgetC($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$providerbuaccess,$companyaccess)
    {
        $year = substr($choicedaymed,0,4);
        $producbudget1 = [];
        $producbudget2 = [];
        $producbudget3 = [];
        $producbudget4 = [];
        $producbudget5 = [];
        $producbudget6 = [];
        $producbudgetq = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-02-29')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-02-29')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-03-01')->where('bmonth','<=',$year.'-04-30')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-03-01')->where('bmonth','<=',$year.'-04-30')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-05-01')->where('bmonth','<=',$year.'-06-30')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-05-01')->where('bmonth','<=',$year.'-06-30')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-08-31')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-08-31')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-09-01')->where('bmonth','<=',$year.'-10-31')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-09-01')->where('bmonth','<=',$year.'-10-31')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-11-01')->where('bmonth','<=',$year.'-12-31')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-11-01')->where('bmonth','<=',$year.'-12-31')->where('BORAItemEngName','=',$value)->get();
            if ($budgetgpcount>0) 
            {
                foreach ($budgetgps as $budget) 
                {
                    if (isset($producbudget6[$budget->BORAItemEngName])) 
                    {
                        $producbudget6[$budget->BORAItemEngName]= $producbudget6[$budget->BORAItemEngName] + $budget->budget;
                    }
                    else
                    {
                        $producbudget6[$budget->BORAItemEngName]=$budget->budget;
                    }    
                }    
            }
            else
            {
                if (!isset($producbudget6[$value])) 
                {
                    $producbudget6[$value]=0;
                }  
            }
        }
        $producbudgetq['C1'] = $producbudget1;
        $producbudgetq['C2'] = $producbudget2;
        $producbudgetq['C3'] = $producbudget3;
        $producbudgetq['C4'] = $producbudget4;
        $producbudgetq['C5'] = $producbudget5;
        $producbudgetq['C6'] = $producbudget6;
        return $producbudgetq;
    }
    public static function productsbudgetQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$providerbuaccess,$companyaccess)
    {
        $year = substr($choicedaymed,0,4);
        $producbudget1 = [];
        $producbudget2 = [];
        $producbudget3 = [];
        $producbudget4 = [];
        $producbudget5 = [];
        $producbudgetq = [];
        $inputselect = $medvalue;
        foreach ($inputselect as $value) {
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-03-31')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$year.'-03-31')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-04-01')->where('bmonth','<=',$year.'-06-30')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-04-01')->where('bmonth','<=',$year.'-06-30')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-09-30')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-07-01')->where('bmonth','<=',$year.'-09-30')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-10-01')->where('bmonth','<=',$year.'-12-31')->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-10-01')->where('bmonth','<=',$year.'-12-31')->where('BORAItemEngName','=',$value)->get();
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
            $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$choicedaymed)->where('BORAItemEngName','=',$value)->count();
            $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','>=',$year.'-01-01')->where('bmonth','<=',$choicedaymed)->where('BORAItemEngName','=',$value)->get();
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
        return $producbudgetq;
    }
    public static function yearach($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$allitems,$provideraccess,$providerbuaccess,$companyaccess,$choicedaymed)
    {
        $limit = substr($choicedaymed,5,2);
        $year = substr($choicedaymed,0,4);
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
                $allstart = $year.'-'.$i.'-01';
                $endstartday = $year .'-'.$i.'-';
                $endendday = date('t',strtotime($year.'-'.$i));
                $allend = $endstartday.$endendday;      
                if ($itemcode[0]=='Others') 
                {
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$allstart)->where('InvDate','<=',$allend)->whereNotIn('Itemno',$allitems)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();
                }       
                else
                {
                    $monthsales = DB::table('allreport')->selectraw('sum(Money) as saletotal')->where('InvDate','>=',$allstart)->where('InvDate','<=',$allend)->whereIn('Itemno',$itemcode)->whereIn('Company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->get();
                } 
                foreach ($monthsales as $monthsale) {
                    $productsell[$value] = $monthsale->saletotal;
                }


                $budgetgpcount = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','=',$allstart)->where('BORAItemEngName','=',$value)->count();
                $budgetgps = DB::table('allbudget')->selectraw('sum(budget) as budget,BORAItemEngName')->whereIn('group',$providerbuaccess)->whereIn('company',$companyaccess)->where('bmonth','=',$allstart)->where('BORAItemEngName','=',$value)->get();
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

                ($producbudget[$value]<>0)?( $medeverymon[] =  round(($productsell[$value]/$producbudget[$value])*100) ):( $medeverymon[]=0 ) ;
                $yearach[$value] = $medeverymon;
                $producbudget[$value] = 0;
            }
        }
        return $yearach;
    }
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#這邊開始是算個人銷售明細
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public static function persondetail($name,$date,$persondetailgroup)
    {
        if ($persondetailgroup=='GPpeople') {
            $db = 'importantps';
            $Salesgroup = array('藥品');
        }
        else if ($persondetailgroup=='HPpeople') {
            $db = 'importanths';
            $Salesgroup = array('醫院');
        }
        else if ($persondetailgroup=='Healpeople')
        {
            $db = 'importantheals';
            $Salesgroup = array('藥局','通路');
        }    
        $allstuff = DB::table($db)->get();
        foreach ($allstuff  as $stuff) {
            if ($stuff->importantproduct=='Others') {
                $allstuffforother = DB::table($db)->get();
                foreach ($allstuffforother as $other) {
                    $medno[$stuff->importantproduct][] = $other->itemno;
                }
            }
            else
            {
                $medno[$stuff->importantproduct][] = $stuff->itemno;
            }    
        }
        $datestart = substr($date,0,8).'01';
        $detailf = [];
        $detailhead = [];
        $detailinfo = [];
        $sum = [];
        foreach ($medno as $key => $value) {
            if ($key=='Others') {
                $details = DB::table('allreport')->where('salesname','=',$name)->whereIn('Salesgroup',$Salesgroup)->where('Invdate','>=',$datestart)->where('Invdate','<=',$date)->whereNotIn('Itemno',$value)->orderBy('Invdate','desc')->get();
            }
            else
            {
                $details = DB::table('allreport')->where('salesname','=',$name)->whereIn('Salesgroup',$Salesgroup)->where('Invdate','>=',$datestart)->where('Invdate','<=',$date)->whereIn('Itemno',$value)->orderBy('Invdate','desc')->get();
            }    
            foreach ($details as $detail) {
                if ($detail->Money <> 0 ) {
                    $detailinfo['Invdate'] = $detail->Invdate;
                    $detailinfo['customer'] = $detail->Cusname;
                    $detailinfo['money'] = $detail->Money;
                    $detailinfo['Itemchname'] = $detail->Itemchname;
                    $detailhead[] = $detailinfo;
                }
            }
            if (!empty($detailhead)) {
                $detailf[$key] = $detailhead;
                $detailsum = 0 ;
                foreach ($detailhead as  $value) {
                    $detailsum = $detailsum + $value['money'];
                }
                $sum[$key] = $detailsum;
            }
            $detailhead = [];
        }
        $detailallinfo[] = $detailf;
        $detailallinfo[] = $sum;
        $detailallinfo[] = array_sum($sum);
        return $detailallinfo;
    }
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#這邊開始是算單價及庫存
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public static function pervalue($dateend,$itemnotemp,$provideraccess,$companyaccess)
    {
        $monthqty = [];
        $monthdetail = [];
        $monthqtyR = [];
        $monthdetailR = [];
        $itemnoarray = $itemnotemp;
        $datestart = substr($dateend,0,8).'01';
        $GroupBy = 'Guino';
        $monthqtyfinal = [];
        foreach ($itemnoarray as $itemno) {
            //算出所有數量金額正項
            $perinfos = DB::table('allreport')->selectraw('sum(qty) as qty,sum(Money) as Money, fqty,Cusname,Salesname,Salesgroup,Itemno,Guino')->whereIn('company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->where('Itemno',$itemno)->where('Invdate','>=',$datestart)->where('Invdate','<=',$dateend)->where('SalesType','<>','R2')->GroupBy($GroupBy)->orderBy('Cusname')->get();
            foreach ($perinfos as $perinfo) {
                if (isset($monthqty[$itemno][$perinfo->Cusname]['qty'])) {
                    $monthqty[$itemno][$perinfo->Cusname][$perinfo->Guino]['qty'] = $monthqty[$itemno][$perinfo->Cusname]['qty'] + $perinfo->qty;
                }
                else
                {
                    $monthqty[$itemno][$perinfo->Cusname][$perinfo->Guino]['qty'] = $perinfo->qty + $perinfo->fqty;
                } 
                if (isset($monthqty[$itemno][$perinfo->Cusname]['money'])) {
                    $monthqty[$itemno][$perinfo->Cusname][$perinfo->Guino]['money'] = $monthqty[$itemno][$perinfo->Cusname]['money'] + $perinfo->Money;
                }
                else
                {
                    $monthqty[$itemno][$perinfo->Cusname][$perinfo->Guino]['money'] = $perinfo->Money;
                }    
            }
            //算出所有數量金額負項
            $perinfos = DB::table('allreport')->selectraw('sum(qty) as qty,sum(Money) as Money,Cusname,Salesname,Salesgroup,Itemno,Guino')->whereIn('company',$companyaccess)->whereIn('Salesgroup',$provideraccess)->where('Itemno',$itemno)->where('Invdate','>=',$datestart)->where('Invdate','<=',$dateend)->where('SalesType','=','R2')->GroupBy($GroupBy)->orderBy('Cusname')->get();
            foreach ($perinfos as $perinfo) {
                if (isset($monthqtyR[$itemno][$perinfo->Cusname]['qty'])) {

                    $monthqtyR[$itemno][$perinfo->Cusname][$perinfo->Guino]['qty'] = $monthqtyR[$itemno][$perinfo->Cusname]['qty'] + $perinfo->qty;
                }
                else
                {
                    $monthqtyR[$itemno][$perinfo->Cusname][$perinfo->Guino]['qty'] = $perinfo->qty;
                } 
                if (isset($monthqtyR[$itemno][$perinfo->Cusname]['money'])) {
                    $monthqtyR[$itemno][$perinfo->Cusname][$perinfo->Guino]['money'] = $monthqtyR[$itemno][$perinfo->Cusname]['money'] + $perinfo->Money;
                }
                else
                {
                    $monthqtyR[$itemno][$perinfo->Cusname][$perinfo->Guino]['money'] = $perinfo->Money;
                }    
            }
            //撈當月所有單號做比對
            if (isset($monthqty[$itemno])) {
                foreach ($monthqty[$itemno] as $cusname => $guinoarray) {
                    foreach ($guinoarray as $guino => $value) {
                        if (isset($monthqty[$itemno][$cusname][$guino]['qty']) and isset($monthqtyR[$itemno][$cusname][$guino]['qty'])) {
                            //多這個判斷是因為退貨系統一定要打數量所以業助會打1故把數量部分歸零
                            if ($monthqtyR[$itemno][$cusname][$guino]['qty']>0 and $monthqtyR[$itemno][$cusname][$guino]['qty']<2 ) {
                                $monthqtyR[$itemno][$cusname][$guino]['qty']=0;
                            }
                            $monthqty[$itemno][$cusname][$guino]['qty'] = $monthqty[$itemno][$cusname][$guino]['qty'] - $monthqtyR[$itemno][$cusname][$guino]['qty'];
                            if (isset($monthqtyfinal[$itemno][$cusname]['qty'])) {
                                $monthqtyfinal[$itemno][$cusname]['qty'] = $monthqtyfinal[$itemno][$cusname]['qty'] + $monthqty[$itemno][$cusname][$guino]['qty'];
                            }
                            else
                            {
                                $monthqtyfinal[$itemno][$cusname]['qty'] = $monthqty[$itemno][$cusname][$guino]['qty'] ; 
                            }    
                        }
                        if (isset($monthqty[$itemno][$cusname][$guino]['qty']) and !isset($monthqtyR[$itemno][$cusname][$guino]['qty'])) {
                            if (isset($monthqtyfinal[$itemno][$cusname]['qty'])  ) {
                                $monthqtyfinal[$itemno][$cusname]['qty'] = $monthqtyfinal[$itemno][$cusname]['qty'] + $monthqty[$itemno][$cusname][$guino]['qty'];
                            }
                            else
                            {
                                $monthqtyfinal[$itemno][$cusname]['qty'] = $monthqty[$itemno][$cusname][$guino]['qty'] ; 
                            }    
                        }
                        if (!isset($monthqty[$itemno][$cusname][$guino]['qty']) and isset($monthqtyR[$itemno][$cusname][$guino]['qty'])) {
                            if (isset($monthqtyfinalprevious[$itemno][$cusname]['qty'])) {
                                $monthqtyfinalprevious[$itemno][$cusname]['qty'] = $monthqtyfinalprevious[$itemno][$cusname]['qty'] + $monthqty[$itemno][$cusname][$guino]['qty'];
                            }
                            else
                            {
                                $monthqtyfinalprevious[$itemno][$cusname]['qty'] = $monthqty[$itemno][$cusname][$guino]['qty'] ; 
                            }    
                        }
                        if (isset($monthqty[$itemno][$cusname][$guino]['money']) and isset($monthqtyR[$itemno][$cusname][$guino]['money'])) {
                            $monthqty[$itemno][$cusname][$guino]['money'] = $monthqty[$itemno][$cusname][$guino]['money'] + $monthqtyR[$itemno][$cusname][$guino]['money'];
                            if (isset($monthqtyfinal[$itemno][$cusname]['money'])) {
                                $monthqtyfinal[$itemno][$cusname]['money'] = $monthqtyfinal[$itemno][$cusname]['money'] + $monthqty[$itemno][$cusname][$guino]['money'];
                            }
                            else
                            {
                                $monthqtyfinal[$itemno][$cusname]['money'] = $monthqty[$itemno][$cusname][$guino]['money'] ; 
                            }  
                        }
                        if (isset($monthqty[$itemno][$cusname][$guino]['money']) and !isset($monthqtyR[$itemno][$cusname][$guino]['money'])) {
                            if (isset($monthqtyfinal[$itemno][$cusname]['money'])) {
                                $monthqtyfinal[$itemno][$cusname]['money'] = $monthqtyfinal[$itemno][$cusname]['money'] + $monthqty[$itemno][$cusname][$guino]['money'];
                            }
                            else
                            {
                                $monthqtyfinal[$itemno][$cusname]['money'] = $monthqty[$itemno][$cusname][$guino]['money'] ; 
                            }    
                        }
                        if (!isset($monthqty[$itemno][$cusname][$guino]['money']) and isset($monthqtyR[$itemno][$cusname][$guino]['money'])) {
                            if (isset($monthqtyfinalprevious[$itemno][$cusname]['money'])) {
                                $monthqtyfinalprevious[$itemno][$cusname]['money'] = $monthqtyfinalprevious[$itemno][$cusname]['money'] + $monthqty[$itemno][$cusname][$guino]['money'];
                            }
                            else
                            {
                                $monthqtyfinalprevious[$itemno][$cusname]['money'] = $monthqty[$itemno][$cusname][$guino]['money'] ; 
                            }    
                        }
                    }
                }
                //剔除數量是負數的如果不是負數則計算單位成本
                foreach ($monthqtyfinal[$itemno] as $hospital => $value) {
                    if ($value['qty']<0) 
                    {
                        unset($monthqtyfinal[$itemno][$hospital]);
                    }
                    else
                    {
                        $monthqtyfinal[$itemno][$hospital]['uniprice'] = $monthqtyfinal[$itemno][$hospital]['money']/$monthqtyfinal[$itemno][$hospital]['qty'];
                        $monthqtyfinal[$itemno][$hospital]['uniprice'] = round($monthqtyfinal[$itemno][$hospital]['uniprice'],2);
                    }    
                }  
            }          
        }
        return $monthqtyfinal;
    }
}