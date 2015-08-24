<?php 
namespace App\Http\Controllers;
use App\user;
use App\dailyreport;//bora 每日業績
use App\boramonthbudget;//bora每月預算
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
//use App\mainmenudisplay;
use App\Http\Requests;
use Hash,Input,Request,Response,Auth,Redirect,Log;
class MainController extends Controller {

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
    public function login()
    {
        
        return view('index');
    }


    public function boradiary($todaydate)
    {

        $medicine = array('Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Lendorminann' => 0 ,
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Bpn' => 0,
                          'Others' => 0,
                         );

        $itemno = array(  'Pitavol' => null , 
                          'Denset' => null , 
                          'Lepax10' => null , 
                          'Lepax5' => null , 
                          'Lexapro' => null , 
                          'Ebixa' => null , 
                          'Deanxit' => null , 
                          'LendorminBora' => null , 
                          'Lendorminann' => null ,
                          'Wilcon' => null ,
                          'Kso' => null ,
                          'Bpn' => null,
                          'Others' => null,
                         );

        $qtys = array(    'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Lendorminann' => 0 ,
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Bpn' => 0,
                          'Others' => 0,
                    );
        $total = 0; 
        $monthstart = date('Y-m-01');//每月月初
        //$todaydate = date('Y-m-d');//今天日期
        $dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;    
            $BORACustomerNo= $dailyreport->BORACustomerNo;    
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                    $itemno['Pitavol'] = $BORAItemNo;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                    $itemno['Denset'] = $BORAItemNo;
                }    
                    break;
                case '68LEP002':
                    $medicine['Lepax10'] = $medicine['Lepax10'] + $dailysell ;
                    $qtys['Lepax10'] = $qtys['Lepax10'] + $qty ; 
                    $itemno['Lepax10'] = $BORAItemNo;
                    break;
                case '68LEP001':
                    $medicine['Lepax5'] = $medicine['Lepax5'] + $dailysell ;
                    $qtys['Lepax5'] = $qtys['Lepax5'] + $qty ;
                    $itemno['Lepax5'] = $BORAItemNo; 
                    break;
                case '68LXP001':
                    $medicine['Lexapro'] = $medicine['Lexapro'] + $dailysell ;
                    $qtys['Lexapro'] = $qtys['Lexapro'] + $qty ; 
                    $itemno['Lexapro'] = $BORAItemNo;
                    break;
                case '68EBP001': 
                    $medicine['Ebixa']  = $medicine['Ebixa'] + $dailysell ;
                    $qtys['Ebixa'] = $qtys['Ebixa'] + $qty ; 
                    $itemno['Ebixa'] = $BORAItemNo;
                    break;
                case '68DEP001':
                    $medicine['Deanxit'] = $medicine['Deanxit'] + $dailysell ;
                    $qtys['Deanxit'] = $qtys['Deanxit'] + $qty ; 
                    $itemno['Deanxit'] = $BORAItemNo;
                    break;
                ////分段一下這邊是LendorminBora兩種分類    
                case '68LMP002':
                    $medicine['LendorminBora'] = $medicine['LendorminBora'] + $dailysell ;
                    $qtys['LendorminBora'] = $qtys['LendorminBora'] + $qty ; 
                    $itemno['LendorminBora'] = $BORAItemNo ; 
                    break;
                case '68PTV001123':
                    $medicine['Lendorminann'] = $medicine['Lendorminann'] + $dailysell ;
                    $qtys['Lendorminann'] = $qtys['Lendorminann'] + $qty ; 
                    $itemno['Lendorminann'] = $BORAItemNo ; 
                    break;
                //分段一下這邊是聯邦產品    
                case '67HWLCBN'://胃爾康 100ml
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell ;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    $itemno['Wilcon'] = $BORAItemNo ; 
                    break; 
                case '67HWLCBC'://胃爾康 100ml  
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell ;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    break; 
                case '67HWLCBJ'://胃爾康 60ml
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell ;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    break; 
                case '67QCTCBQ'://氯四環素
                    $medicine['Kso'] = $medicine['Kso'] + $dailysell ;
                    $qtys['Kso'] = $qtys['Kso'] + $qty ; 
                    $itemno['Kso'] = $BORAItemNo ; 
                    break; 
                case '57ABPNPA'://帕金寧
                    $medicine['Bpn'] = $medicine['Bpn'] + $dailysell ;
                    $qtys['Bpn'] = $qtys['Bpn'] + $qty ; 
                    $itemno['Bpn'] = $BORAItemNo ; 
                    break;    
                case '57ABPNBA'://帕金寧
                    $medicine['Bpn'] = $medicine['Bpn'] + $dailysell ;
                    $qtys['Bpn'] = $qtys['Bpn'] + $qty ; 
                    break;            
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032'  and $BORAItemNo<>'57ARZTPG'  ) 
                  {
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                    break;
                  } 
            }
        }
        //and寫法註記一下每月銷售累加
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        $MA = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Lendorminann' => 0 ,
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Bpn' => 0,
                          'Others' => 0,
                         );
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt;       
            $BORACustomerNo= $dailyreport->BORACustomerNo;      
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                }      
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Denset'] = $MA['Denset'] + $MonthTotal;
                }    
                    break;
                case '68LEP002':
                    $MA['Lepax10'] = $MA['Lepax10'] + $MonthTotal;
                    break;
                case '68LEP001':
                    $MA['Lepax5'] = $MA['Lepax5'] + $MonthTotal;
                    break;
                case '68LXP001':
                    $MA['Lexapro'] = $MA['Lexapro'] + $MonthTotal;
                    break;
                case '68EBP001': 
                    $MA['Ebixa']  = $MA['Ebixa'] + $MonthTotal;
                    break;
                case '68DEP001':
                    $MA['Deanxit'] = $MA['Deanxit'] + $MonthTotal;
                    break;
                ////分段一下這邊是LendorminBora兩種分類    
                case '68LMP002':
                    $MA['LendorminBora'] = $MA['LendorminBora'] + $MonthTotal;
                    break;
                case '68PTV001123':
                    $MA['Lendorminann'] = $MA['Lendorminann'] + $MonthTotal;
                    break;
                //分段一下這邊是聯邦產品    
                case '67HWLCBN'://胃爾康 100ml
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
                    break; 
                case '67HWLCBC'://胃爾康 100ml  
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
                    break; 
                case '67HWLCBJ'://胃爾康 60ml 
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
                    break; 
                case '67QCTCBQ'://氯四環素
                    $MA['Kso'] = $MA['Kso'] + $MonthTotal;
                    break; 
                case '57ABPNPA'://帕金寧
                    $MA['Bpn'] = $MA['Bpn'] + $MonthTotal;
                    break;    
                case '57ABPNBA'://帕金寧
                    $MA['Bpn'] = $MA['Bpn'] + $MonthTotal;
                    break;            
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032'  and $BORAItemNo<>'57ARZTPG') 
                  {
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                    break;
                  } 
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Lepax10'] + $medicine['Lepax5'] + $medicine['Lexapro'] +  $medicine['Ebixa'] + $medicine['Deanxit'] + $medicine['LendorminBora'] ;
        $totalsell = $medicine['Lendorminann'] + $medicine['Wilcon'] + $medicine['Kso'] + $medicine['Bpn'] + $medicine['Others'] + $totalsell ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Lepax10'] + $qtys['Lepax5'] + $qtys['Lexapro'] + $qtys['Ebixa'] + $qtys['Deanxit'] + $qtys['LendorminBora'] ;
        $allqty = $qtys['Lendorminann'] + $qtys['Wilcon'] + $qtys['Kso'] + $qtys['Bpn'] + $qtys['Others'] + $allqty;    
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Lepax10'] + $MA['Lepax5'] + $MA['Lexapro'] + $MA['Ebixa'] + $MA['Deanxit'] + $MA['LendorminBora'] ;
        $totalma = $MA['Lendorminann'] + $MA['Wilcon'] + $MA['Kso'] + $MA['Bpn'] + $MA['Others'] + $totalma;  
        //撈每月目標業績
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        $MB = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Lendorminann' => 0 ,
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Bpn' => 0,
                          'Others' => 0,
                         );
        $MC = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Lendorminann' => 0 ,
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Bpn' => 0,
                          'Others' => 0,
                         );
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MB['Pitavol'] = $MonthTotal;
                    $MC['Pitavol'] = round(($MA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    $MC['Denset'] = round(($MA['Denset'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    $MC['Lepax10'] = round(($MA['Lepax10'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    $MC['Lepax5'] = round(($MA['Lepax5'] / $MonthTotal) * 100) ; 
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    $MC['Lexapro'] = round(($MA['Lexapro'] / $MonthTotal) * 100) ; 
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    $MC['Ebixa'] = round(($MA['Ebixa'] / $MonthTotal) * 100) ; 
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    $MC['Deanxit'] = round(($MA['Deanxit'] / $MonthTotal) * 100) ; 
                    break;
                ////分段一下這邊是LendorminBora兩種分類    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    $MC['LendorminBora'] = round(($MA['LendorminBora'] / $MonthTotal) * 100); 
                    break;
                case '68PTV001123':
                    $MB['Lendorminann'] = $MonthTotal ;
                    $MC['Lendorminann'] = round(($MA['Lendorminann'] / $MonthTotal) * 100); 
                    break;
                //分段一下這邊是聯邦產品    
                case '67HWLCBN'://胃爾康 100ml
                    $MB['Wilcon'] = $MonthTotal ; 
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break; 
                case '67HWLCBC'://胃爾康 100ml  
                    $MB['Wilcon'] = $MonthTotal ; 
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break; 
                case '67HWLCBJ'://胃爾康 60ml 
                    $MB['Wilcon'] = $MonthTotal ; 
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break; 
                case '67QCTCBQ'://氯四環素
                    $MB['Kso'] = $MonthTotal ;
                    $MC['Kso'] = round(($MA['Kso'] / $MonthTotal) * 100) ; 
                    break; 
                case '57ABPNPA'://帕金寧
                    $MB['Bpn'] = $MonthTotal ;
                    $MC['Bpn'] = round(($MA['Bpn'] / $MonthTotal) * 100); 
                    break;    
                case '57ABPNBA'://帕金寧
                    $MB['Bpn'] = $MonthTotal ;
                    $MC['Bpn'] = round(($MA['Bpn'] / $MonthTotal) * 100); 
                    break;  
                case '11111111'://others
                    $MB['Others'] = $MonthTotal ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ; 
                    break;             
                default:
                  
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] ;
        $totalmb = $MB['Lendorminann'] + $MB['Wilcon'] + $MB['Kso'] + $MB['Bpn'] + $MB['Others'] + $totalmb ; 
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Lepax10'] + $MC['Lepax5'] + $MC['Lexapro'] + $MC['Ebixa'] + $MC['Deanxit'] + $MC['LendorminBora'] ;
        $totalmc = $MC['Lendorminann'] + $MC['Wilcon'] + $MC['Kso'] + $MC['Bpn'] + $MC['Others'] + $totalmc ; 
        $totalmc = round($totalmc / 13) ;
        return view('boradiary',['Pitavol'=>$medicine['Pitavol'],
                              'Denset'=>$medicine['Denset'],
                              'Lepax10'=>$medicine['Lepax10'],
                              'Lepax5'=>$medicine['Lepax5'],
                              'Lexapro'=>$medicine['Lexapro'],
                              'Ebixa'=>$medicine['Ebixa'],
                              'Deanxit'=> $medicine['Deanxit'],
                              'LendorminBora'=>$medicine['LendorminBora'],
                              'Lendorminann'=>$medicine['Lendorminann'],
                              'Wilcon'=>$medicine['Wilcon'],
                              'Kso'=>$medicine['Kso'],
                              'Bpn'=>$medicine['Bpn'],
                              'Others'=>$medicine['Others'],
                              'itemno'=>$itemno,
                              'qtys'=>$qtys,
                              'todaydate'=>$todaydate,
                              'totalsell'=>$totalsell,
                              'allqty'=>$allqty,
                              'MA'=>$MA, 
                              'MB'=>$MB, 
                              'MC'=>$MC, 
                              'totalma'=>$totalma,
                              'totalmb'=>$totalmb,
                              'totalmc'=>$totalmc,
                              ]);
    }


    public function unidiary($todaydate)
    {
        $medicine = array('Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                         );

        $itemno = array(  'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                         );

        $qtys = array(    'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                    );
        $total = 0; 
        $monthstart = date('Y-m-01');//每月月初
        //$todaydate = date('Y-m-d');//今天日期
        //每日販賣數量 金額
        $dailyreportstable = unidiaryreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerNo= $dailyreport->BORACustomerNo;        
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo=='10824') {
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                    $itemno['Pitavol'] = $BORAItemNo;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo=='10824') {
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                    $itemno['Denset'] = $BORAItemNo;
                }    
                    break;
                // 胃爾康
                case '57HWLCBC':
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    $itemno['Wilcon'] = $BORAItemNo;
                    break;
                case '57HWLCBJ':
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    $itemno['Wilcon'] = $BORAItemNo;
                    break;
                case '57HWLCBK':
                    $medicine['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    $qtys['Wilcon'] = $qtys['Wilcon'] + $qty ; 
                    $itemno['Wilcon'] = $BORAItemNo;
                    break;
                // 氯四環素
                case '57QCTCBQ':
                    $medicine['Kso'] = $medicine['Kso'] + $dailysell ;
                    $qtys['Kso'] = $qtys['Kso'] + $qty ;
                    $itemno['Kso'] = $BORAItemNo; 
                    break;
                case '57QCTCBR':
                    $medicine['Kso'] = $medicine['Kso'] + $dailysell ;
                    $qtys['Kso'] = $qtys['Kso'] + $qty ;
                    $itemno['Kso'] = $BORAItemNo; 
                    break;
                // 優平
                case '57BUATPG': 
                    $medicine['Upi']  = $medicine['Upi'] + $dailysell ;
                    $qtys['Upi'] = $qtys['Upi'] + $qty ; 
                    $itemno['Upi'] = $BORAItemNo;
                    break;
                case '57BUPTB2':
                    $medicine['Upi']  = $medicine['Upi'] + $dailysell ;
                    $qtys['Upi'] = $qtys['Upi'] + $qty ; 
                    $itemno['Upi'] = $BORAItemNo;
                    break;
                case '57BUPTPJ': 
                    $medicine['Upi']  = $medicine['Upi'] + $dailysell ;
                    $qtys['Upi'] = $qtys['Upi'] + $qty ; 
                    $itemno['Upi'] = $BORAItemNo;
                    break;
                case '57BUTTPG':
                    $medicine['Upi']  = $medicine['Upi'] + $dailysell ;
                    $qtys['Upi'] = $qtys['Upi'] + $qty ; 
                    $itemno['Upi'] = $BORAItemNo;
                    break;
                // 優福   
                case '57JFOIB4':
                    $medicine['Ufo'] = $medicine['Ufo'] + $dailysell ;
                    $qtys['Ufo'] = $qtys['Ufo'] + $qty ; 
                    $itemno['Ufo'] = $BORAItemNo ; 
                    break;
                case '57JFOIC4':
                    $medicine['Ufo'] = $medicine['Ufo'] + $dailysell ;
                    $qtys['Ufo'] = $qtys['Ufo'] + $qty ; 
                    $itemno['Ufo'] = $BORAItemNo ; 
                    break;          
                default:
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                    break;
            }
        }
        //每月銷售累加  and寫法註記一下
        $dailyreportstable = unidiaryreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        $MA = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                   );
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt; 
            $BORACustomerNo= $dailyreport->BORACustomerNo;       
            switch ($BORAItemNo) { 
                case '68PTV001':
                if ($BORACustomerNo=='10824') {
                    $MA['Pitavol'] = $medicine['Pitavol'] + $MonthTotal;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo=='10824') {
                    $MA['Denset'] = $medicine['Denset'] + $MonthTotal;
                }    
                    break;
                // 胃爾康
                case '57HWLCBC':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $MonthTotal;
                    break;
                case '57HWLCBJ':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $MonthTotal;
                    break;
                case '57HWLCBK':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $MonthTotal;
                    break;
                // 氯四環素
                case '57QCTCBQ':
                    $MA['Kso'] = $MA['Kso'] + $MonthTotal ;
                    break;
                case '57QCTCBR':
                    $MA['Kso'] = $MA['Kso'] + $MonthTotal ;
                    break;
                // 優平
                case '57BUATPG': 
                    $MA['Upi']  = $MA['Upi'] + $MonthTotal ;
                    break;
                case '57BUPTB2':
                    $MA['Upi']  = $MA['Upi'] + $MonthTotal ;
                    break;
                case '57BUPTPJ': 
                    $MA['Upi']  = $MA['Upi'] + $MonthTotal ;
                    break;
                case '57BUTTPG':
                    $MA['Upi']  = $MA['Upi'] + $MonthTotal ;
                    break;
                // 優福   
                case '57JFOIB4':
                    $MA['Ufo'] = $MA['Ufo'] + $MonthTotal ;
                    break;
                case '57JFOIC4':
                    $MA['Ufo'] = $MA['Ufo'] + $MonthTotal ;
                    break;          
                default:
                    $MA['Others'] = $MA['Others'] + $MonthTotal ;
                    break;
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Brexa'] + $medicine['Wilcon'] + $medicine['Kso'] + $medicine['Upi'] + $medicine['Ufo'] + $medicine['Others'] ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Brexa'] + $qtys['Wilcon'] + $qtys['Kso'] + $qtys['Upi'] + $qtys['Ufo'] + $qtys['Others'] ;
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Brexa'] + $MA['Wilcon'] + $MA['Kso'] + $MA['Upi'] + $MA['Ufo'] + $MA['Others'] ;
        //撈每月目標業績
        $monthbudgets = unimonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        $MB = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                    );
        $MC = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                    );
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case 'Pitavol':
                    $MB['Pitavol'] = $MonthTotal ;
                    $MC['Pitavol'] = round(($MA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case 'Denset':
                    $MB['Denset'] = $MonthTotal ;
                    $MC['Denset'] = round(($MA['Denset'] / $MonthTotal) * 100); 
                    break;
                case 'Brexa':
                    $MB['Brexa'] = $MonthTotal ;
                    $MC['Brexa'] = round(($MA['Brexa'] / $MonthTotal) * 100); 
                    break;
                case '57HWLCBC':
                    $MB['Wilcon'] = $MonthTotal ;
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break;
                case '57HWLCBJ':
                    $MB['Wilcon'] = $MonthTotal ;
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break;
                case '57HWLCBK':
                    $MB['Wilcon'] = $MonthTotal ;
                    $MC['Wilcon'] = round(($MA['Wilcon'] / $MonthTotal) * 100); 
                    break;
                // 氯四環素
                case '57QCTCBQ':
                    $MB['Kso'] = $MonthTotal  ;
                    $MC['Kso'] = round(($MA['Kso'] / $MonthTotal) * 100); 
                    break;
                case '57QCTCBR':
                    $MB['Kso'] = $MonthTotal ;
                    $MC['Kso'] = round(($MA['Kso'] / $MonthTotal) * 100); 
                    break;
                // 優平
                case '57BUATPG': 
                    $MB['Upi']  = $MonthTotal  ;
                    $MC['Upi'] = round(($MA['Upi'] / $MonthTotal) * 100); 
                    break;
                case '57BUPTB2':
                    $MB['Upi']  = $MonthTotal ;
                    $MC['Upi'] = round(($MA['Upi'] / $MonthTotal) * 100); 
                    break;
                case '57BUPTPJ': 
                    $MB['Upi']  = $MonthTotal  ;
                    $MC['Upi'] = round(($MA['Upi'] / $MonthTotal) * 100); 
                    break;
                case '57BUTTPG':
                    $MB['Upi']  = $MonthTotal  ;
                    $MC['Upi'] = round(($MA['Upi'] / $MonthTotal) * 100); 
                    break;
                // 優福   
                case '57JFOIB4':
                    $MB['Ufo'] = $MonthTotal ;
                    $MC['Ufo'] = round(($MA['Ufo'] / $MonthTotal) * 100); 
                    break;
                case '57JFOIC4':
                    $MB['Ufo'] = $MonthTotal ;
                    $MC['Ufo'] = round(($MA['Ufo'] / $MonthTotal) * 100); 
                    break;          
                default:
                    $MB['Others'] = $MonthTotal  ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100);                    
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Brexa'] + $MB['Wilcon'] + $MB['Kso'] + $MB['Upi'] + $MB['Ufo'] + $MB['Others'] ;
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Brexa'] + $MC['Wilcon'] + $MC['Kso'] + $MC['Upi'] + $MC['Ufo'] + $MC['Others'] ;
        return view('unidiary',['medicine'=>$medicine,
                                'itemno'=>$itemno,
                                'qtys'=>$qtys,
                                'todaydate'=>$todaydate,
                                'totalsell'=>$totalsell,
                                'allqty'=>$allqty,
                                'MA'=>$MA, 
                                'MB'=>$MB, 
                                'MC'=>$MC, 
                                'totalma'=>$totalma,
                                'totalmb'=>$totalmb,
                                'totalmc'=>$totalmc,
                               ]);
    }


    public function accountdiary($todaydate)
    {
        $medicine = array('Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );

        $itemno = array(  'Pitavol' => null , 
                          'Denset' => null , 
                          'Lepax10' => null , 
                          'Lepax5' => null , 
                          'Lexapro' => null , 
                          'Ebixa' => null , 
                          'Deanxit' => null , 
                          'LendorminBora' => null , 
                          'Others' => null,
                         );

        $qtys = array(    'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                    );
        $total = 0; 
        $yearstart = date('Y-01-01');//今年年初
        $monthstart = date('Y-m-01');//每月月初
        //$todaydate = date('Y-m-d');//今天日期
        $dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;
            $BORACustomerName = $dailyreport->BORACustomerName;
            $BORACustomerNo = $dailyreport->BORACustomerNo;        
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                    $itemno['Pitavol'] = $BORAItemNo;
                }
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                    $itemno['Denset'] = $BORAItemNo;
                } 
                    break;
                case '68LEP002':
                    $medicine['Lepax10'] = $medicine['Lepax10'] + $dailysell ;
                    $qtys['Lepax10'] = $qtys['Lepax10'] + $qty ; 
                    $itemno['Lepax10'] = $BORAItemNo;
                    break;
                case '68LEP001':
                    $medicine['Lepax5'] = $medicine['Lepax5'] + $dailysell ;
                    $qtys['Lepax5'] = $qtys['Lepax5'] + $qty ;
                    $itemno['Lepax5'] = $BORAItemNo; 
                    break;
                case '68LXP001':
                    $medicine['Lexapro'] = $medicine['Lexapro'] + $dailysell ;
                    $qtys['Lexapro'] = $qtys['Lexapro'] + $qty ; 
                    $itemno['Lexapro'] = $BORAItemNo;
                    break;
                case '68EBP001': 
                    $medicine['Ebixa']  = $medicine['Ebixa'] + $dailysell ;
                    $qtys['Ebixa'] = $qtys['Ebixa'] + $qty ; 
                    $itemno['Ebixa'] = $BORAItemNo;
                    break;
                case '68DEP001':
                    $medicine['Deanxit'] = $medicine['Deanxit'] + $dailysell ;
                    $qtys['Deanxit'] = $qtys['Deanxit'] + $qty ; 
                    $itemno['Deanxit'] = $BORAItemNo;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $medicine['LendorminBora'] = $medicine['LendorminBora'] + $dailysell ;
                    $qtys['LendorminBora'] = $qtys['LendorminBora'] + $qty ; 
                    $itemno['LendorminBora'] = $BORAItemNo ; 
                    break;
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67') 
                {
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                }
                    break;
            }
        }
        //and寫法註記一下單月銷售累加
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        $MA = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt; 
            $BORACustomerNo = $dailyreport->BORACustomerNo;                   
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Denset'] = $MA['Denset'] + $MonthTotal;
                }  
                    break;
                case '68LEP002':
                    $MA['Lepax10'] = $MA['Lepax10'] + $MonthTotal;
                    break;
                case '68LEP001':
                    $MA['Lepax5'] = $MA['Lepax5'] + $MonthTotal;
                    break;
                case '68LXP001':
                    $MA['Lexapro'] = $MA['Lexapro'] + $MonthTotal;
                    break;
                case '68EBP001': 
                    $MA['Ebixa']  = $MA['Ebixa'] + $MonthTotal;
                    break;
                case '68DEP001':
                    $MA['Deanxit'] = $MA['Deanxit'] + $MonthTotal;
                    break;
                ////分段一下這邊是LendorminBora   
                case '68LMP002':
                    $MA['LendorminBora'] = $MA['LendorminBora'] + $MonthTotal;
                    break;       
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                }
                break;
            }
        }

        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Lepax10'] + $medicine['Lepax5'] + $medicine['Lexapro'] +  $medicine['Ebixa'] + $medicine['Deanxit'] + $medicine['LendorminBora'] ;
        $totalsell =  $medicine['Others'] + $totalsell ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Lepax10'] + $qtys['Lepax5'] + $qtys['Lexapro'] + $qtys['Ebixa'] + $qtys['Deanxit'] + $qtys['LendorminBora'] ;
        $allqty =  $qtys['Others'] + $allqty;    
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Lepax10'] + $MA['Lepax5'] + $MA['Lexapro'] + $MA['Ebixa'] + $MA['Deanxit'] + $MA['LendorminBora'] ;
        $totalma = $MA['Others'] + $totalma;  
        $MAA = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $dailyreportstable = dailyreport::where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerNo = $dailyreport->BORACustomerNo;          
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MAA['Pitavol'] = $MAA['Pitavol'] + $dailysell;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MAA['Denset'] = $MAA['Denset'] + $dailysell ;
                }   
                    break;
                case '68LEP002':
                    $MAA['Lepax10'] = $MAA['Lepax10'] + $dailysell ; 
                    break;
                case '68LEP001':
                    $MAA['Lepax5'] = $MAA['Lepax5'] + $dailysell ;
                    break;
                case '68LXP001':
                    $MAA['Lexapro'] = $MAA['Lexapro'] + $dailysell ;
                    break;
                case '68EBP001': 
                    $MAA['Ebixa']  = $MAA['Ebixa'] + $dailysell ;
                    break;
                case '68DEP001':
                    $MAA['Deanxit'] = $MAA['Deanxit'] + $dailysell ;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $MAA['LendorminBora'] = $MAA['LendorminBora'] + $dailysell ;
                    break;
                default: 
                if ( $BORACustomerNo <> '10973' and $BORACustomerNo <> '11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo <> '57ARZTPG'  and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MAA['Others'] = $MAA['Others'] + $dailysell ;
                }     
                break;
            }
        }
        $totalmaa = $MAA['Pitavol'] + $MAA['Denset'] + $MAA['Lepax10'] + $MAA['Lepax5'] ;
        $totalmaa = $totalmaa + $MAA['Lexapro'] + $MAA['Ebixa'] + $MAA['Deanxit'] + $MAA['Deanxit'] + $MAA['Others'] ;
        //撈每月目標業績
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        $MB = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MBB = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MC = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MCC = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MB['Pitavol'] = $MonthTotal;
                    $MC['Pitavol'] = round(($MA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    $MC['Denset'] = round(($MA['Denset'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    $MC['Lepax10'] = round(($MA['Lepax10'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    $MC['Lepax5'] = round(($MA['Lepax5'] / $MonthTotal) * 100) ; 
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    $MC['Lexapro'] = round(($MA['Lexapro'] / $MonthTotal) * 100) ; 
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    $MC['Ebixa'] = round(($MA['Ebixa'] / $MonthTotal) * 100) ; 
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    $MC['Deanxit'] = round(($MA['Deanxit'] / $MonthTotal) * 100) ; 
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    $MC['LendorminBora'] = round(($MA['LendorminBora'] / $MonthTotal) * 100); 
                    break;       
                case '22222222'://others
                    $MB['Others'] = $MonthTotal ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ; 
                    break;             
                default:
                  
                    break;
            }
        } 
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MBB['Pitavol'] = $MonthTotal;
                    $MCC['Pitavol'] = round(($MAA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case '68DEN001':
                    $MBB['Denset'] = $MonthTotal ;
                    $MCC['Denset'] = round(($MAA['Denset'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP002':
                    $MBB['Lepax10'] = $MonthTotal ;
                    $MCC['Lepax10'] = round(($MAA['Lepax10'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP001':
                    $MBB['Lepax5'] = $MonthTotal ;
                    $MCC['Lepax5'] = round(($MAA['Lepax5'] / $MonthTotal) * 100) ; 
                    break;
                case '68LXP001':
                    $MBB['Lexapro'] = $MonthTotal ;
                    $MCC['Lexapro'] = round(($MAA['Lexapro'] / $MonthTotal) * 100) ; 
                    break;
                case '68EBP001': 
                    $MBB['Ebixa']  = $MonthTotal ;
                    $MCC['Ebixa'] = round(($MAA['Ebixa'] / $MonthTotal) * 100) ; 
                    break;
                case '68DEP001':
                    $MBB['Deanxit'] = $MonthTotal ;
                    $MCC['Deanxit'] = round(($MAA['Deanxit'] / $MonthTotal) * 100) ; 
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MBB['LendorminBora'] = $MonthTotal ;
                    $MCC['LendorminBora'] = round(($MAA['LendorminBora'] / $MonthTotal) * 100); 
                    break;       
                case '22222222'://others
                    $MBB['Others'] = $MonthTotal ;
                    $MCC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ; 
                    break;             
                default:
                  
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] + $MB['Others'] ;
        $totalmbb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] + $MB['Others'] ;
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Lepax10'] + $MC['Lepax5'] + $MC['Lexapro'] + $MC['Ebixa'] + $MC['Deanxit'] + $MC['LendorminBora'] + $MC['Others'] ;
        $totalmcc = $MCC['Pitavol'] + $MCC['Denset'] + $MCC['Lepax10'] + $MCC['Lepax5'] + $MCC['Lexapro'] + $MCC['Ebixa'] + $MCC['Deanxit'] + $MCC['LendorminBora'] + $MCC['Others'] ;
        $totalmc = round($totalmc / 9) ;
        $totalmcc = round($totalmcc / 9) ;
        return view('accountdiary',['medicine'=>$medicine,
                                    'itemno'=>$itemno,
                                    'qtys'=>$qtys,
                                    'todaydate'=>$todaydate,
                                    'totalsell'=>$totalsell,
                                    'allqty'=>$allqty,
                                    'MA'=>$MA,
                                    'MAA'=>$MAA, 
                                    'MB'=>$MB, 
                                    'MBB'=>$MBB, 
                                    'MC'=>$MC, 
                                    'MCC'=>$MCC, 
                                    'totalma'=>$totalma,
                                    'totalmaa'=>$totalmaa,                
                                    'totalmb'=>$totalmb,
                                    'totalmbb'=>$totalmbb,
                                    'totalmc'=>$totalmc,
                                    'totalmcc'=>$totalmcc,
                                  ]);
    }

    public function personaldiary($todaydate)
    {
      $form = null;
      $style = 0 ;
      $i = 0;
      $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
      $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初   
      $MC = array();
      $users = User::where('dep','=','藥品事業部')->get();
      foreach ($users as $user) {
        $dailyreports = dailyreport::where('SalesRepresentativeName','=',$user['cname'])->where('InvDate','=',$todaydate)->get();
        $dailyreportaday = 0 ;
        foreach ($dailyreports as $dailyreport) {
          $dailyreportaday = $dailyreportaday + $dailyreport['InoviceAmt'];
        }
        $dailyreports = dailyreport::where('SalesRepresentativeName','=',$user['cname'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        $MA = 0 ;
        foreach ($dailyreports as $dailyreport) {
          $MA = $MA + $dailyreport['InoviceAmt'];
        } 
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          $MB = $monthbudget['budget'];
        } 
        // M  A/B
        $MC[$i] = round(($MA/$MB) * 100) ;
        // M  A/L

        $dailyreports = dailyreport::where('SalesRepresentativeName','=',$user['cname'])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        $MAA = 0 ;
        foreach ($dailyreports as $dailyreport) {
          $MAA = $MAA + $dailyreport['InoviceAmt'];
        }
        $monthbudgets = boramonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          $MBB = $monthbudget['budget'];
        } 
        // M  A/B
        $MCC = round(($MAA/$MBB) * 100) ;
        // M  A/L
        if ($style==2 or $style==0) {
          $style = 0 ;
          $active = '' ;
        }
        else
        {
          $active = 'active'  ;       
        } 
        $form .= '<tr class='.$active.'><td><a href="http://127.0.0.1/eip/public/personalmedicinediary/'.$user['cname'].'">'.$user['cname'].'</a></td>';
        $form .= '<td>'.$dailyreportaday.'</td><td>'.$MA.'</td>';
        $form .= '<td>'.$MB.'</td><td>'.$MC[$i].' %</td>';
        $form .= '<td>'.'123'.'</td><td>'.$MAA.'</td>';
        $form .= '<td>'.$MBB.'</td><td>'.$MCC.' %</td>';  
        $form .= '<td>'.'123'.'</td>';  
        $form .= '</tr>';
        $style = $style + 1 ;
        $i = $i+1;
      }

      return view('personaldiary',[ 'form'=>$form,
                                    'MC'=>$MC, 
                                    'todaydate'=>$todaydate,
                                  ]);
    }



    public function personalmedicinediary($user)
    {
        $medicine = array('Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $qtys = array(    'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                    );
        $dailyreports = dailyreport::where('SalesRepresentativeName','=',$user)->where('InvDate','=','2015-07-01')->get();
        foreach ($dailyreports as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;
            $BORACustomerName = $dailyreport->BORACustomerName;
            $BORACustomerNo = $dailyreport->BORACustomerNo;        
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                }
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                } 
                    break;
                case '68LEP002':
                    $medicine['Lepax10'] = $medicine['Lepax10'] + $dailysell ;
                    $qtys['Lepax10'] = $qtys['Lepax10'] + $qty ; 
                    break;
                case '68LEP001':
                    $medicine['Lepax5'] = $medicine['Lepax5'] + $dailysell ;
                    $qtys['Lepax5'] = $qtys['Lepax5'] + $qty ;
                    break;
                case '68LXP001':
                    $medicine['Lexapro'] = $medicine['Lexapro'] + $dailysell ;
                    $qtys['Lexapro'] = $qtys['Lexapro'] + $qty ; 
                    break;
                case '68EBP001': 
                    $medicine['Ebixa']  = $medicine['Ebixa'] + $dailysell ;
                    $qtys['Ebixa'] = $qtys['Ebixa'] + $qty ; 
                    break;
                case '68DEP001':
                    $medicine['Deanxit'] = $medicine['Deanxit'] + $dailysell ;
                    $qtys['Deanxit'] = $qtys['Deanxit'] + $qty ; 
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $medicine['LendorminBora'] = $medicine['LendorminBora'] + $dailysell ;
                    $qtys['LendorminBora'] = $qtys['LendorminBora'] + $qty ; 
                    break;
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67') 
                {
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                }
                    break;
            }
        }
        $dailyreportstable = dailyreport::where('SalesRepresentativeName','=',$user)->where('InvDate','>=','2015-07-01')->where('InvDate','<=','2015-07-31')->get();
        $MA = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt; 
            $BORACustomerNo = $dailyreport->BORACustomerNo;                   
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MA['Denset'] = $MA['Denset'] + $MonthTotal;
                }  
                    break;
                case '68LEP002':
                    $MA['Lepax10'] = $MA['Lepax10'] + $MonthTotal;
                    break;
                case '68LEP001':
                    $MA['Lepax5'] = $MA['Lepax5'] + $MonthTotal;
                    break;
                case '68LXP001':
                    $MA['Lexapro'] = $MA['Lexapro'] + $MonthTotal;
                    break;
                case '68EBP001': 
                    $MA['Ebixa']  = $MA['Ebixa'] + $MonthTotal;
                    break;
                case '68DEP001':
                    $MA['Deanxit'] = $MA['Deanxit'] + $MonthTotal;
                    break;
                ////分段一下這邊是LendorminBora   
                case '68LMP002':
                    $MA['LendorminBora'] = $MA['LendorminBora'] + $MonthTotal;
                    break;       
                default:
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                }
                break;
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Lepax10'] + $medicine['Lepax5'] + $medicine['Lexapro'] +  $medicine['Ebixa'] + $medicine['Deanxit'] + $medicine['LendorminBora'] ;
        $totalsell = $medicine['Others'] + $totalsell ;  
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Lepax10'] + $MA['Lepax5'] + $MA['Lexapro'] + $MA['Ebixa'] + $MA['Deanxit'] + $MA['LendorminBora'] ;
        $totalma = $MA['Others'] + $totalma;  
        $MAA = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $yearstart = date('Y-01-01');//今年年初
        $dailyreportstable = dailyreport::where('InvDate','>=',$yearstart)->where('InvDate','<=','2015-07-01')->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerNo = $dailyreport->BORACustomerNo;          
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MAA['Pitavol'] = $MAA['Pitavol'] + $dailysell;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MAA['Denset'] = $MAA['Denset'] + $dailysell ;
                }   
                    break;
                case '68LEP002':
                    $MAA['Lepax10'] = $MAA['Lepax10'] + $dailysell ; 
                    break;
                case '68LEP001':
                    $MAA['Lepax5'] = $MAA['Lepax5'] + $dailysell ;
                    break;
                case '68LXP001':
                    $MAA['Lexapro'] = $MAA['Lexapro'] + $dailysell ;
                    break;
                case '68EBP001': 
                    $MAA['Ebixa']  = $MAA['Ebixa'] + $dailysell ;
                    break;
                case '68DEP001':
                    $MAA['Deanxit'] = $MAA['Deanxit'] + $dailysell ;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $MAA['LendorminBora'] = $MAA['LendorminBora'] + $dailysell ;
                    break;
                default: 
                if ( $BORACustomerNo <> '10973' and $BORACustomerNo <> '11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo <> '57ARZTPG'  and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MAA['Others'] = $MAA['Others'] + $dailysell ;
                }     
                break;
            }
        }
        $totalmaa = $MAA['Pitavol'] + $MAA['Denset'] + $MAA['Lepax10'] + $MAA['Lepax5'] ;
        $totalmaa = $totalmaa + $MAA['Lexapro'] + $MAA['Ebixa'] + $MAA['Deanxit'] + $MAA['Deanxit'] + $MAA['Others'] ;
        //撈每月目標業績
        $monthbudgets = boramonthbudget::where('month','>=','2015-08-01')->where('month','<=','2015-08-31')->get();
        $MB = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MBB = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MC = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MCC = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MB['Pitavol'] = $MonthTotal;
                    $MC['Pitavol'] = round(($MA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    $MC['Denset'] = round(($MA['Denset'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    $MC['Lepax10'] = round(($MA['Lepax10'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    $MC['Lepax5'] = round(($MA['Lepax5'] / $MonthTotal) * 100) ; 
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    $MC['Lexapro'] = round(($MA['Lexapro'] / $MonthTotal) * 100) ; 
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    $MC['Ebixa'] = round(($MA['Ebixa'] / $MonthTotal) * 100) ; 
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    $MC['Deanxit'] = round(($MA['Deanxit'] / $MonthTotal) * 100) ; 
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    $MC['LendorminBora'] = round(($MA['LendorminBora'] / $MonthTotal) * 100); 
                    break;       
                case '22222222'://others
                    $MB['Others'] = $MonthTotal ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ; 
                    break;             
                default:
                  
                    break;
            }
        } 
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MBB['Pitavol'] = $MonthTotal;
                    $MCC['Pitavol'] = round(($MAA['Pitavol'] / $MonthTotal) * 100); 
                    break;
                case '68DEN001':
                    $MBB['Denset'] = $MonthTotal ;
                    $MCC['Denset'] = round(($MAA['Denset'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP002':
                    $MBB['Lepax10'] = $MonthTotal ;
                    $MCC['Lepax10'] = round(($MAA['Lepax10'] / $MonthTotal) * 100) ; 
                    break;
                case '68LEP001':
                    $MBB['Lepax5'] = $MonthTotal ;
                    $MCC['Lepax5'] = round(($MAA['Lepax5'] / $MonthTotal) * 100) ; 
                    break;
                case '68LXP001':
                    $MBB['Lexapro'] = $MonthTotal ;
                    $MCC['Lexapro'] = round(($MAA['Lexapro'] / $MonthTotal) * 100) ; 
                    break;
                case '68EBP001': 
                    $MBB['Ebixa']  = $MonthTotal ;
                    $MCC['Ebixa'] = round(($MAA['Ebixa'] / $MonthTotal) * 100) ; 
                    break;
                case '68DEP001':
                    $MBB['Deanxit'] = $MonthTotal ;
                    $MCC['Deanxit'] = round(($MAA['Deanxit'] / $MonthTotal) * 100) ; 
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MBB['LendorminBora'] = $MonthTotal ;
                    $MCC['LendorminBora'] = round(($MAA['LendorminBora'] / $MonthTotal) * 100); 
                    break;       
                case '22222222'://others
                    $MBB['Others'] = $MonthTotal ;
                    $MCC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ; 
                    break;             
                default:
                  
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] + $MB['Others'] ;
        $totalmbb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] + $MB['Others'] ;
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Lepax10'] + $MC['Lepax5'] + $MC['Lexapro'] + $MC['Ebixa'] + $MC['Deanxit'] + $MC['LendorminBora'] + $MC['Others'] ;
        $totalmcc = $MCC['Pitavol'] + $MCC['Denset'] + $MCC['Lepax10'] + $MCC['Lepax5'] + $MCC['Lexapro'] + $MCC['Ebixa'] + $MCC['Deanxit'] + $MCC['LendorminBora'] + $MCC['Others'] ;
        $totalmc = round($totalmc / 9) ;
        $form  = '<tr><td>pivavol</td><td>'.$medicine['Pitavol'].'</td><td>'.$MA['Pitavol'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr class="active"><td>Denset</td><td>'.$medicine['Denset'].'</td><td>'.$MA['Denset'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr><td>Lepax 10mg</td><td>'.$medicine['Lepax10'].'</td><td>'.$MA['Lepax10'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr class="active"><td>Lepax 5mg</td><td>'.$medicine['Lepax5'].'</td><td>'.$MA['Lepax5'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr><td>Lexapro</td><td>'.$medicine['Lexapro'].'</td><td>'.$MA['Lexapro'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr class="active"><td>Ebixa</td><td>'.$medicine['Ebixa'].'</td><td>'.$MA['Ebixa'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr><td>Deanxit</td><td>'.$medicine['Deanxit'].'</td><td>'.$MA['Deanxit'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr class="active"><td>Lendormin</td><td>'.$medicine['LendorminBora'].'</td><td>'.$MA['LendorminBora'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr><td>Others</td><td>'.$medicine['Others'].'</td><td>'.$MA['Others'].'</td><td>'.$MB['Pitavol'].'</td></tr>';
        $form .= '<tr class="active"><td>Total</td><td>'.$totalsell.'</td><td>'.$totalma.'</td><td>'.$totalmb.'</td></tr>';
        return view('personalmedicinediary',['form'=>$form]);
    }
}