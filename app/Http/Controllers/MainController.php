<?php 
namespace App\Http\Controllers;
use App\user;
use App\hareport;
use App\dailyreport;//bora 每日業績
use App\boramonthbudget;//bora每月預算
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\logistic;
use App\medicinebudgetbypersonal;
use App\Http\Requests;
use App\personalmonthbudget;
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
        $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
        $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初  
        $chardate =  str_replace('-','',$todaydate);
        $dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;    
            $BORACustomerNo = $dailyreport->BORACustomerNo;    
            $SaleType = $dailyreport->SaleType;
            switch ($BORAItemNo) {
                case '68PTV001':
                //10824 = 和安
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
                //10973 = 衛采  11032 = 聯邦化學   57ARZTPG = 羅莎疼
                if ($BORACustomerNo<>'10973' and $BORACustomerNo<>'11032'  and $BORAItemNo<>'57ARZTPG'  ) 
                  {
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                    break;
                  } 
            }
        }
        //和安戀多眠另外再算一次
        $dailyreportstable = hareport::where('INVDT','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $HAItemNo = $dailyreport->HAITMNO;
            $dailysell = $dailyreport->INVAM;
            $qty  = $dailyreport->ORQTY;    
            $HACustomerNo = $dailyreport->CUSNAME;  
            $CDAMT = $dailyreport->CDAMT;
            switch ($HAItemNo) {
                case 'LEN25100':
                    $medicine['Lendorminann'] = $medicine['Lendorminann'] + $dailysell - $CDAMT ;
                    $qtys['Lendorminann'] = $qtys['Lendorminann'] + $qty ; 
                    $itemno['Lendorminann'] = $HACustomerNo ; 
                    break;
                default:

                    break;
            }    
        }    
        //每月銷售累加 還有  and 寫法
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
            $SalesType= $dailyreport->SalesType;   
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824' ) {
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
        //和安戀多眠另外再算一次 
        $dailyreportstable = hareport::where('INVDT','>=',$monthstart)->where('INVDT','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $HAItemNo = $dailyreport->HAITMNO;
            $dailysell = $dailyreport->INVAM; 
            $CDAMT = $dailyreport->CDAMT;
            switch ($HAItemNo) {
                case 'LEN25100':
                    $MA['Lendorminann'] = $MA['Lendorminann'] + $dailysell - $CDAMT;
                break;
                default:

                 break;
            }    
        }  
        //每月目標業績
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
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    break;
                ////分段一下這邊是LendorminBora兩種分類    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    break;
                case '68PTV001123':
                    $MB['Lendorminann'] = $MonthTotal ;
                    break;
                //分段一下這邊是聯邦產品    
                case '67HWLCBN'://胃爾康 100ml
                    $MB['Wilcon'] = $MonthTotal ; 
                    break; 
                case '67HWLCBC'://胃爾康 100ml  
                    $MB['Wilcon'] = $MonthTotal ; 
                    break; 
                case '67HWLCBJ'://胃爾康 60ml 
                    $MB['Wilcon'] = $MonthTotal ; 
                    break; 
                case '67QCTCBQ'://氯四環素
                    $MB['Kso'] = $MonthTotal ;
                    break; 
                case '57ABPNPA'://帕金寧
                    $MB['Bpn'] = $MonthTotal ;
                    break;    
                case '57ABPNBA'://帕金寧
                    $MB['Bpn'] = $MonthTotal ;
                    break;  
                case '11111111'://others
                    $MB['Others'] = $MonthTotal ;
                    break;             
                default:
                    break;
            }
        } 
        $q = 0 ;
        $allqty  = 0 ;
        $totalsell = 0 ;
        $totalma = 0; 
        $totalmb = 0;
        $totalmc = 0;
        foreach ($MB as $key => $value) {
          if ($MB[$key]<>0)
          {
            $q = $q + 1 ;
          }
        }
        foreach ($qtys as $key => $value) {
          $allqty  = $allqty + $qtys[$key] ;
        }
        foreach ($medicine as $key => $value) {
          $totalsell = $totalsell + $medicine[$key];
        }
        foreach ($MA as $key => $value) {
          $totalma = $totalma + $MA[$key];
        }
        foreach ($MB as $key => $value) {
          $totalmb = $totalmb + $MB[$key] ;
        }
        foreach ($MC as $key => $value) {
          if ($MB[$key]<>0)
          {  
            $MC[$key] = round(($MA[$key] / $MB[$key])* 100) ;
          }
          else
          {
            $MC[$key] = 0 ;
          }  
        }
        foreach ($MC as $key => $value) {
          $totalmc = $totalmc + $MC[$key] ;
        }
        $totalmc = round(($totalma / $totalmb) * 100) ;
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
                              'chardate'=>$chardate, 
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
        $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
        $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初 
        $chardate =  str_replace('-','',$todaydate);
        //每日販賣數量 金額
        $dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
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
                case '68BRP001':
                if ($BORACustomerNo=='10824') {
                    $medicine['Brexa'] = $medicine['Brexa'] + $dailysell ;
                    $qtys['Brexa'] = $qtys['Brexa'] + $qty ; 
                    $itemno['Brexa'] = $BORAItemNo;
                }    
                break;
                default:

                break;
            } 
        }      	
        $dailyreportstable = unidiaryreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerName = $dailyreport->BORACustomerName;        
            switch ($BORAItemNo) {
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
        $MA = array(      'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Brexa' => 0 , 
                          'Wilcon' => 0 ,
                          'Kso' => 0 ,
                          'Upi' => 0,
                          'Ufo'=>0,
                          'Others' => 0,
                   );
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt;       
            $BORACustomerNo= $dailyreport->BORACustomerNo;      
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo=='10824') {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                }      
                break;
                case '68DEN001':
                if ($BORACustomerNo=='10824') {
                    $MA['Denset'] = $MA['Denset'] + $MonthTotal;
                }    
                break;
                case '68BRP001':
                if ($BORACustomerNo=='10824') {
                    $MA['Brexa'] = $MA['Brexa'] + $MonthTotal;
                }    
                break;
                default:

                break;
            } 
        }  
        $dailyreportstable = unidiaryreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt; 
            $BORACustomerNo= $dailyreport->BORACustomerNo;       
            switch ($BORAItemNo) { 
                // 胃爾康
                case '57HWLCBC':
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
                    break;
                case '57HWLCBJ':
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
                    break;
                case '57HWLCBK':
                    $MA['Wilcon'] = $MA['Wilcon'] + $MonthTotal;
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
                case '68PTV001':
                    $MB['Pitavol'] = $MonthTotal ;
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    break;
                case '68BRP001':
                    $MB['Brexa'] = $MonthTotal ;
                    break;
                case '57HWLCBC':
                    $MB['Wilcon'] = $MonthTotal ;
                    break;
                case '57HWLCBJ':
                    $MB['Wilcon'] = $MonthTotal ;
                    break;
                case '57HWLCBK':
                    $MB['Wilcon'] = $MonthTotal ;
                    break;
                // 氯四環素
                case '57QCTCBQ':
                    $MB['Kso'] = $MonthTotal  ;
                    break;
                case '57QCTCBR':
                    $MB['Kso'] = $MonthTotal ;
                    break;
                // 優平
                case '57BUATPG': 
                    $MB['Upi']  = $MonthTotal  ;
                    break;
                case '57BUPTB2':
                    $MB['Upi']  = $MonthTotal ;
                    break;
                case '57BUPTPJ': 
                    $MB['Upi']  = $MonthTotal  ;
                    break;
                case '57BUTTPG':
                    $MB['Upi']  = $MonthTotal  ;
                    break;
                // 優福   
                case '57JFOIB4':
                    $MB['Ufo'] = $MonthTotal ;
                    break;
                case '57JFOIC4':
                    $MB['Ufo'] = $MonthTotal ;
                    break;          
                default:
                    $MB['Others'] = $MonthTotal  ;                 
                    break;
            }
        }
        $allqty = 0 ;
        $totalsell = 0 ; 
        $totalma = 0;
        $totalmb = 0 ;
        $totalmc = 0 ;
        foreach ($qtys as $key => $value) {
          $allqty  = $allqty + $qtys[$key] ;
        }
        foreach ($medicine as $key => $value) {
          $totalsell = $totalsell + $medicine[$key];
        }
        foreach ($MA as $key => $value) {
          $totalma = $totalma + $MA[$key];
        }
        foreach ($MB as $key => $value) {
          $totalmb = $totalmb + $MB[$key];
        }
        foreach ($MC as $key => $value) {
          if ($MB[$key]<>0)
          {  
            $MC[$key] = round(($MA[$key] / $MB[$key])* 100) ;
          }
          else
          {
            $MC[$key] = 0 ;
          }  
        }
        foreach ($MC as $key => $value) {
          $totalmc = $totalmc + $MC[$key];
        }
        $totalmc = round(($totalma / $totalmb) * 100) ;
        return view('unidiary',['medicine'=>$medicine,
                                'itemno'=>$itemno,
                                'qtys'=>$qtys,
                                'todaydate'=>$todaydate,
                                'totalsell'=>$totalsell,
                                'allqty'=>$allqty,
                                'MA'=>$MA, 
                                'MB'=>$MB, 
                                'MC'=>$MC, 
                                'chardate'=>$chardate, 
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
        $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
        $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初 
        $lastyear = substr($todaydate, 0,5) - 1 ;//去年年分
        $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
        $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初   
        $lastyearstart = $lastyear.'-01-01';//依照選擇的日期轉換去年每年年初 
        $lastyearmonthstart = $lastyear.substr($todaydate, 4,4).'01';//依照選擇的日期轉換去年每月月初   
        $lastyearday = $lastyear.substr($todaydate, 4);//依照選擇的日期轉換去年今日 
        $chardate =  str_replace('-','',$todaydate);
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
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    break;       
                case '22222222'://others
                    $MB['Others'] = $MonthTotal ;
                    break;             
                default:
                  
                    break;
            }
        } 
        $monthbudgets = boramonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MBB['Pitavol'] = $MBB['Pitavol'] + $MonthTotal;
                    break;
                case '68DEN001':
                    $MBB['Denset'] = $MBB['Denset'] + $MonthTotal ; 
                    break;
                case '68LEP002':
                    $MBB['Lepax10'] = $MBB['Lepax10'] + $MonthTotal ;
                    break;
                case '68LEP001':
                    $MBB['Lepax5'] = $MBB['Lepax5'] + $MonthTotal ;
                    break;
                case '68LXP001':
                    $MBB['Lexapro'] = $MBB['Lexapro'] + $MonthTotal ;
                    break;
                case '68EBP001': 
                    $MBB['Ebixa']  = $MBB['Ebixa'] + $MonthTotal ;
                    break;
                case '68DEP001':
                    $MBB['Deanxit'] = $MBB['Deanxit'] + $MonthTotal ;
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MBB['LendorminBora'] = $MBB['LendorminBora'] + $MonthTotal ;
                    break;       
                case '22222222'://others
                    $MBB['Others'] = $MBB['Others'] + $MonthTotal ;
                    break;             
                default:
                  
                    break;
            }
        }
        $ML = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MLL = array(     'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $dailyreportstable = dailyreport::where('InvDate','>=',$lastyearmonthstart)->where('InvDate','<=',$lastyearday)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerNo = $dailyreport->BORACustomerNo;          
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $ML['Pitavol'] = $ML['Pitavol'] + $dailysell;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $ML['Denset'] = $ML['Denset'] + $dailysell ;
                }   
                    break;
                case '68LEP002':
                    $ML['Lepax10'] = $ML['Lepax10'] + $dailysell ; 
                    break;
                case '68LEP001':
                    $ML['Lepax5'] = $ML['Lepax5'] + $dailysell ;
                    break;
                case '68LXP001':
                    $ML['Lexapro'] = $ML['Lexapro'] + $dailysell ;
                    break;
                case '68EBP001': 
                    $ML['Ebixa']  = $ML['Ebixa'] + $dailysell ;
                    break;
                case '68DEP001':
                    $ML['Deanxit'] = $ML['Deanxit'] + $dailysell ;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $ML['LendorminBora'] = $ML['LendorminBora'] + $dailysell ;
                    break;
                default: 
                if ( $BORACustomerNo <> '10973' and $BORACustomerNo <> '11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo <> '57ARZTPG'  and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $ML['Others'] = $ML['Others'] + $dailysell ;
                }     
                break;
            }
        } 
        $dailyreportstable = dailyreport::where('InvDate','>=',$lastyearstart)->where('InvDate','<=',$lastyearday)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;  
            $BORACustomerNo = $dailyreport->BORACustomerNo;          
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') {
                    $MLL['Pitavol'] = $MLL['Pitavol'] + $dailysell;
                }    
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') {
                    $MLL['Denset'] = $MLL['Denset'] + $dailysell ;
                }   
                    break;
                case '68LEP002':
                    $MLL['Lepax10'] = $MLL['Lepax10'] + $dailysell ; 
                    break;
                case '68LEP001':
                    $MLL['Lepax5'] = $MLL['Lepax5'] + $dailysell ;
                    break;
                case '68LXP001':
                    $MLL['Lexapro'] = $MLL['Lexapro'] + $dailysell ;
                    break;
                case '68EBP001': 
                    $MLL['Ebixa']  = $MLL['Ebixa'] + $dailysell ;
                    break;
                case '68DEP001':
                    $MLL['Deanxit'] = $MLL['Deanxit'] + $dailysell ;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $MLL['LendorminBora'] = $MLL['LendorminBora'] + $dailysell ;
                    break;
                default: 
                if ( $BORACustomerNo <> '10973' and $BORACustomerNo <> '11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo <> '57ARZTPG'  and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MLL['Others'] = $MLL['Others'] + $dailysell ;
                }     
                break;
            }
        } 
        $q = 0 ;
        $allqty  = 0 ;
        $totalsell = 0 ;
        $totalma = 0; 
        $totalmb = 0;
        $totalmc = 0;
        $totalml = 0 ;
        $totalmaa = 0 ;
        $totalmbb = 0 ;
        $totalmcc = 0 ;
        $totalmll = 0 ;
        foreach ($MB as $key => $value) {
          if ($MB[$key]<>0)
          {
            $q = $q + 1 ;
          }
        }
        foreach ($qtys as $key => $value) {
          $allqty  = $allqty + $qtys[$key] ;
        }
        foreach ($medicine as $key => $value) {
          $totalsell = $totalsell + $medicine[$key];
        }
        foreach ($MA as $key => $value) {
          $totalma = $totalma + $MA[$key];
        }
        foreach ($MB as $key => $value) {
          $totalmb = $totalmb + $MB[$key] ;
        }
        foreach ($MC as $key => $value) {
          if ($MB[$key]<>0)
          {  
            $MC[$key] = round(($MA[$key] / $MB[$key])* 100) ;
          }
          else
          {
            $MC[$key] = 0 ;
          }  
        }
        foreach ($MC as $key => $value) {
          $totalmc = $totalmc + $MC[$key] ;
        }
        foreach ($MAA as $key => $value) {
          $totalmaa = $totalmaa + $MAA[$key];
        }
        foreach ($MBB as $key => $value) {
          $totalmbb = $totalmbb + $MBB[$key];
        }
        foreach ($MCC as $key => $value) {
          if ($MBB[$key]<>0)
          {  
            $MCC[$key] = round(($MAA[$key] / $MBB[$key]) * 100) ;
          }
          else
          {
            $MCC[$key] = 0 ;
          }  
        }
        foreach ($ML as $key => $value) 
        {
          $totalml = $totalml + $ML[$key];
          if ($ML[$key]<>0)
          {  
            $ML[$key] = $MA[$key] / $ML[$key]  ;
            if ($ML[$key]<1) 
            {
              $ML[$key] ='-'.round((1-$ML[$key])*100);
            }
            else
            {
              $ML[$key] = round($ML[$key] * 100) ;
            }  
          }
          else
          {
            $ML[$key] = 0 ;
          }  
        }
        foreach ($MLL as $key => $value) 
        {
          $totalmll = $totalmll + $MLL[$key];
          if ($MLL[$key]<>0)
          {  
            $MLL[$key] = $MAA[$key] / $MLL[$key]  ;
            if ($MLL[$key]<1) 
            {
              $MLL[$key] = '-'. round((1-$MLL[$key])*100);
            }
            else
            {
              $MLL[$key] = round($MLL[$key] * 100) ;
            }  
          }
          else
          {
            $MLL[$key] = 0 ;
          }  
        }
        $totalmc = round(($totalma / $totalmb) * 100) ;
        $totalmcc = round(($totalmaa / $totalmbb) * 100) ;
        $totalml = $totalma / $totalml ;
        $totalmll = $totalmaa / $totalmll ;
        if ($totalml<1) 
        {
          $totalml = '-'. round((1-$totalml)*100);
        }
        else
        {
          $totalml = round( $totalml * 100) ;
        } 
        if ($totalmll<1) 
        {
          $totalmll = '-'. round((1-$totalmll)*100);
        }
        else
        {
          $totalmll = round( $totalmll * 100) ;
        } 
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
                                    'ML'=>$ML,
                                    'MLL'=>$MLL,
                                    'chardate'=>$chardate, 
                                    'totalma'=>$totalma,
                                    'totalmaa'=>$totalmaa,                
                                    'totalmb'=>$totalmb,
                                    'totalmbb'=>$totalmbb,
                                    'totalmc'=>$totalmc,
                                    'totalmcc'=>$totalmcc,
                                    'totalml'=>$totalml,
                                    'totalmll'=>$totalmll,
                                  ]);
    }

    public function personaldiary($todaydate)
    {
      $form = null;
      $style = 0 ;
      $i = 0;
      $lastyear = substr($todaydate, 0,5) - 1 ;//去年年分
      $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
      $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初   
      $lastyearstart = $lastyear.'-01-01';//依照選擇的日期轉換去年每年年初 
      $lastyearmonthstart = $lastyear.substr($todaydate, 4,4).'01';//依照選擇的日期轉換去年每月月初   
      $lastyearday = $lastyear.substr($todaydate, 4);//依照選擇的日期轉換去年今日
      $chardate =  str_replace('-','',$todaydate); 
      $MC = array();
      $users = User::where('dep','=','藥品事業部')->where('location','<>','')->orderBy('sorts', 'ASC')->get();
      foreach ($users as $user) {
        if ($user['name']=='b0153') {
          	$user['cname'] = '物流';
          	$dailyreports = logistic::where('InvDate','=',$todaydate)->get();
        	$dailyreportaday = 0 ;
        	foreach ($dailyreports as $dailyreport) {  
          		if (substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' ) 
          		{
            		$dailyreportaday = $dailyreportaday + $dailyreport['InoviceAmt']; 
          		}
        	}
        }
        else
        {
          	$dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','=',$todaydate)->get();
        	$dailyreportaday = 0 ;
        	foreach ($dailyreports as $dailyreport) {  
          		if (substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225') 
          		{
            		$dailyreportaday = $dailyreportaday + $dailyreport['InoviceAmt']; 
          		}
        	}
        }

        if ($user['name']=='b0153') {
          	$user['cname'] = '物流';
          	$dailyreports = logistic::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        	$MA = 0 ;
        	foreach ($dailyreports as $dailyreport) {
          		if (substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG') 
          		{
            		$MA = $MA + $dailyreport['InoviceAmt'];
          		}  
        	}
        }
        else
        {
        	$dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        	$MA = 0 ;
        	foreach ($dailyreports as $dailyreport) {
          		if ( substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225' ) 
          		{   
            		$MA = $MA + $dailyreport['InoviceAmt'];
          		}  
        	} 
        }

        $monthbudgets = personalmonthbudget::where('zone','=',$user['location'])->where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          $MB = $monthbudget['budget'];
        } 

        // MC  A/B
        $MC[$i] = round(($MA/$MB) * 100) ;

        // ML  A/L
        /*if ($user['name']=='b0153') {
          $user['cname'] = '物流';
          $dailyreports = logistic::where('InvDate','>=',$lastyearmonthstart)->where('InvDate','<=',$lastyearday)->get();
        }
        else
        {
          $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$lastyearmonthstart)->where('InvDate','<=',$lastyearday)->get();
        }
        $ML = 0 ;
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG'  ) 
          {
            $ML = $ML + $dailyreport['InoviceAmt'];
          }  
        }*/


        if ($user['name']=='b0153') {
          	$user['cname'] = '物流';
          	$dailyreports = logistic::where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        	$MAA = 0 ;

        	foreach ($dailyreports as $dailyreport) {
          		if (substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG') 
          		{
            		$MAA = $MAA + $dailyreport['InoviceAmt'];
          		}  
        	}
        }
        else
        {
          	$dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        	$MAA = 0 ;
        	foreach ($dailyreports as $dailyreport) {
          		if (substr($dailyreport['$BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225' ) 
          		{
            		$MAA = $MAA + $dailyreport['InoviceAmt'];
          		}  
        	}
        }

        $monthbudgets = personalmonthbudget::where('zone','=',$user['location'])->where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        $MBB  = 0 ;

        foreach ($monthbudgets as $monthbudget) {
          $MBB = $MBB +  $monthbudget['budget'];
        } 

        // MCC  A/B
        $MCC = round(($MAA/$MBB) * 100) ;


        // MLL  A/L
        /*if ($user['name']=='b0153') {
          $user['cname'] = '物流';
          $dailyreports = logistic::where('InvDate','>=',$lastyearstart)->where('InvDate','<=',$lastyearday)->get();
        }
        else
        {
          $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$lastyearstart)->where('InvDate','<=',$lastyearday)->get();
        }
        $MLL = 0 ;
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG'  ) 
          {
            $MLL = $MLL + $dailyreport['InoviceAmt'];
          }  
        }*/

        if ($style==2 or $style==0) {
          $style = 0 ;
          $active = '' ;
        }
        else
        {
          $active = 'active'  ;       
        } 

        $form .= '<tr class='.$active.'><td><a href="http://127.0.0.1/eip/public/personalmedicinediary/'.$user['cname'].'/'.$todaydate.'">'.$user['location'].'   /  '.$user['cname'].'</a></td>';
        $form .= '<td class="text-right">'.number_format($dailyreportaday).'</td><td class="text-right">'.number_format($MA).'</td>';
        $form .= '<td class="text-right">'.number_format($MB).'</td><td class="text-right">'.$MC[$i].' %</td>';
        $form .= '<td class="text-right">'.''.'</td><td class="text-right">'.number_format($MAA).'</td>';
        $form .= '<td class="text-right">'.number_format($MBB).'</td><td class="text-right">'.$MCC.' %</td>';  
        $form .= '<td class="text-right">'.''.'</td>';  
        $form .= '</tr>';
        $style = $style + 1 ;
        $i = $i+1;
      }
      return view('personaldiary',[ 'form'=>$form,
                                    'MC'=>$MC, 
                                    'todaydate'=>$todaydate,
                                    'chardate'=>$chardate, 
                                  ]);
    }

    public function personalmedicinediary($user,$todaydate)
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
        $lastyear = substr($todaydate, 0,5) - 1 ;//去年年分
        $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
        $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初  
        $lastyearstart = $lastyear.'-01-01';//依照選擇的日期轉換去年每年年初 
        $lastyearmonthstart = $lastyear.substr($todaydate, 4,4).'01';//依照選擇的日期轉換去年每月月初   
        $lastyearday = $lastyear.substr($todaydate, 4);//依照選擇的日期轉換去年今日
        $charuser =  $user ; 
        $chardate =  str_replace('-','',$todaydate);
        $users = User::where('cname','=',$user)->get();
        foreach ($users as $userinfo ) {
        }
        $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$userinfo['name'])->where('InvDate','=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell  = $dailyreport->InoviceAmt;
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
        //單月銷售累加
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
        $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$userinfo['name'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
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
        $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$userinfo['name'])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
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
        //撈每月目標業績
        $monthbudgets = medicinebudgetbypersonal::where('month','>=',$monthstart)->where('month','<=',$todaydate)->where('zone','=',$userinfo['location'])->get();
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
                    break;
                case '68DEN001':
                    $MB['Denset'] = $MonthTotal ;
                    break;
                case '68LEP002':
                    $MB['Lepax10'] = $MonthTotal ;
                    break;
                case '68LEP001':
                    $MB['Lepax5'] = $MonthTotal ;
                    break;
                case '68LXP001':
                    $MB['Lexapro'] = $MonthTotal ;
                    break;
                case '68EBP001': 
                    $MB['Ebixa']  = $MonthTotal ;
                    break;
                case '68DEP001':
                    $MB['Deanxit'] = $MonthTotal ;
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MB['LendorminBora'] = $MonthTotal ;
                    break;       
                case '33333333'://others
                    $MB['Others'] = $MonthTotal ;
                    break;             
                default:
                  
                    break;
            }
        } 
        $monthbudgets = medicinebudgetbypersonal::where('month','>=',$yearstart)->where('month','<=',$todaydate)->where('zone','=',$userinfo['location'])->get();
        foreach ($monthbudgets as $monthbudget) {
            $BORAItemNo = $monthbudget->BORAItemNo;
            $MonthTotal = $monthbudget->budget; 
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MBB['Pitavol'] = $MBB['Pitavol'] + $MonthTotal;
                    break;
                case '68DEN001':
                    $MBB['Denset'] = $MBB['Denset'] + $MonthTotal ; 
                    break;
                case '68LEP002':
                    $MBB['Lepax10'] = $MBB['Lepax10'] + $MonthTotal ;
                    break;
                case '68LEP001':
                    $MBB['Lepax5'] = $MBB['Lepax5'] + $MonthTotal ;
                    break;
                case '68LXP001':
                    $MBB['Lexapro'] = $MBB['Lexapro'] + $MonthTotal ;
                    break;
                case '68EBP001': 
                    $MBB['Ebixa']  = $MBB['Ebixa'] + $MonthTotal ;
                    break;
                case '68DEP001':
                    $MBB['Deanxit'] = $MBB['Deanxit'] + $MonthTotal ;
                    break;
                ////分段一下這邊是LendorminBora    
                case '68LMP002':
                    $MBB['LendorminBora'] = $MBB['LendorminBora'] + $MonthTotal ;
                    break;       
                case '33333333'://others
                    $MBB['Others'] = $MBB['Others'] + $MonthTotal ;
                    break;             
                default:
                  
                    break;
            }
        } 
        $q = 0 ;
        $allqty  = 0 ;
        $totalsell = 0 ;
        $totalma = 0; 
        $totalmb = 0;
        $totalmc = 0;
        $totalmaa = 0 ;
        $totalmbb = 0 ;
        $totalmcc = 0 ;
        foreach ($MB as $key => $value) {
          if ($MB[$key]<>0)
          {
            $q = $q + 1 ;
          }
        }
        foreach ($qtys as $key => $value) {
          $allqty  = $allqty + $qtys[$key] ;
        }
        foreach ($medicine as $key => $value) {
          $totalsell = $totalsell + $medicine[$key];
        }
        foreach ($MA as $key => $value) {
          $totalma = $totalma + $MA[$key];
        }
        foreach ($MB as $key => $value) {
          $totalmb = $totalmb + $MB[$key] ;
        }
        foreach ($MC as $key => $value) {
          if ($MB[$key]<>0)
          {  
            $MC[$key] = round(($MA[$key] / $MB[$key])* 100) ;
          }
          else
          {
            $MC[$key] = 0 ;
          }  
        }
        foreach ($MC as $key => $value) {
          $totalmc = $totalmc + $MC[$key] ;
        }
        foreach ($MAA as $key => $value) {
          $totalmaa = $totalmaa + $MAA[$key];
        }
        foreach ($MBB as $key => $value) {
          $totalmbb = $totalmbb + $MBB[$key];
        }
        foreach ($MCC as $key => $value) {
          if ($MBB[$key]<>0)
          {  
            $MCC[$key] = round(($MAA[$key] / $MBB[$key]) * 100) ;
          }
          else
          {
            $MCC[$key] = 0 ;
          }  
        }
        $totalmc = round(($totalma / $totalmb) * 100) ;
        $totalmcc = round(($totalmaa / $totalmbb) * 100) ;
        $form  = '<tr><td>pivavol</td><td class="text-right">'.number_format($medicine['Pitavol']).'</td><td class="text-right">'.number_format($MA['Pitavol']).'</td><td class="text-right">'.number_format($MB['Pitavol']).'</td><td class="text-right">'.$MC['Pitavol'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['Pitavol']).'</td><td class="text-right">'.number_format($MBB['Pitavol']).'</td><td class="text-right">'.$MCC['Pitavol'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr class="active"><td>Denset</td><td class="text-right">'.number_format($medicine['Denset']).'</td><td class="text-right">'.number_format($MA['Denset']).'</td><td class="text-right">'.number_format($MB['Denset']).'</td><td class="text-right">'.$MC['Denset'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['Denset']).'</td><td class="text-right">'.number_format($MBB['Denset']).'</td><td class="text-right">'.$MCC['Denset'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr><td>Lepax 10mg</td><td class="text-right">'.number_format($medicine['Lepax10']).'</td><td class="text-right">'.number_format($MA['Lepax10']).'</td><td class="text-right">'.number_format($MB['Lepax10']).'</td><td class="text-right">'.$MC['Lepax10'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['Lepax10']).'</td><td class="text-right">'.number_format($MBB['Lepax10']).'</td><td class="text-right">'.$MCC['Lepax10'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr class="active"><td>Lepax 5mg</td><td class="text-right">'.number_format($medicine['Lepax5']).'</td><td class="text-right">'.number_format($MA['Lepax5']).'</td><td class="text-right">'.number_format($MB['Lepax5']).'</td><td class="text-right">'.$MC['Lepax5'].'%</td><td class="text-right">'.''.'</td><td class="text-right">'.number_format($MAA['Lepax5']).'</td><td class="text-right">'.number_format($MBB['Lepax5']).'</td><td class="text-right">'.$MCC['Lepax5'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr><td>Lexapro</td><td class="text-right">'.number_format($medicine['Lexapro']).'</td><td class="text-right">'.number_format($MA['Lexapro']).'</td><td class="text-right">'.number_format($MB['Lexapro']).'</td><td class="text-right">'.$MC['Lexapro'].'%</td><td class="text-right">'.''.'</td><td class="text-right">'.number_format($MAA['Lexapro']).'</td><td class="text-right">'.number_format($MBB['Lexapro']).'</td><td class="text-right">'.$MCC['Lexapro'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr class="active"><td>Ebixa</td><td class="text-right">'.number_format($medicine['Ebixa']).'</td><td class="text-right">'.number_format($MA['Ebixa']).'</td><td class="text-right">'.number_format($MB['Ebixa']).'</td><td class="text-right">'.$MC['Ebixa'].'%</td><td class="text-right">'.''.'</td><td class="text-right">'.number_format($MAA['Ebixa']).'</td><td class="text-right">'.number_format($MBB['Ebixa']).'</td><td class="text-right">'.$MCC['Ebixa'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr><td>Deanxit</td><td class="text-right">'.number_format($medicine['Deanxit']).'</td><td class="text-right">'.number_format($MA['Deanxit']).'</td><td class="text-right">'.number_format($MB['Deanxit']).'</td><td class="text-right">'.$MC['Deanxit'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['Deanxit']).'</td><td class="text-right">'.number_format($MBB['Deanxit']).'</td><td class="text-right">'.$MCC['Deanxit'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr class="active"><td>Lendormin</td><td class="text-right">'.number_format($medicine['LendorminBora']).'</td><td class="text-right">'.number_format($MA['LendorminBora']).'</td><td class="text-right">'.number_format($MB['LendorminBora']).'</td><td class="text-right">'.$MC['LendorminBora'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['LendorminBora']).'</td><td class="text-right">'.number_format($MBB['LendorminBora']).'</td><td class="text-right">'.$MCC['LendorminBora'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr><td>Others</td><td class="text-right">'.number_format($medicine['Others']).'</td><td class="text-right">'.number_format($MA['Others']).'</td><td class="text-right">'.number_format($MB['Others']).'</td><td class="text-right">'.$MC['Others'].'%</td><td>'.''.'</td><td class="text-right">'.number_format($MAA['Others']).'</td><td class="text-right">'.number_format($MBB['Others']).'</td><td class="text-right">'.$MCC['Others'].'%</td><td>'.''.'</td></tr>';
        $form .= '<tr class="active"><td>Total</td><td class="text-right">'.number_format($totalsell).'</td><td class="text-right">'.number_format($totalma).'</td><td class="text-right">'.number_format($totalmb).'</td><td class="text-right">'.$totalmc.'%</td><td class="text-right">'.''.'</td><td class="text-right">'.number_format($totalmaa).'</td><td class="text-right">'.number_format($totalmbb).'</td><td class="text-right">'.$totalmcc.'%</td><td class="text-right">'.''.'</td></tr>';
        return view('personalmedicinediary',['form'=>$form,
                                             'MC'=>$MC,
                                             'user'=>$userinfo['cname'],
                                             'chardate'=>$chardate
                                            ]);
    }
}