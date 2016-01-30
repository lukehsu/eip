<?php 
namespace App\Http\Controllers;
use App\user;
use App\hareport;
use App\boehringer;
use App\dailyreport;//bora 每日業績
use App\boramonthbudget;//bora每月預算
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\salesmen;
use App\useracces;
use App\calendar;
use App\logistic;
use App\medicinebudgetbypersonal;
use App\Http\Requests;
use App\personalmonthbudget;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail;
class AutosendController extends Controller {

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

    public function sendboradiary()
    {
        $todaydate = date('Y-m-d');
        $todaydate = strtotime($todaydate) - 3600*24;
        $todaydate =  date('Y-m-d',$todaydate);
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

        //百靈佳戀多眠另外再算一次
        $dailyreportstable = boehringer::where('Date','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $amount = $dailyreport->Amount;
            $qty = $dailyreport->QTY;
            if ($dailyreport['SaleType']=='R2') {
              $amount = 0 - $amount;
            }
            $medicine['Lendorminann'] = $medicine['Lendorminann'] + $amount;
            $qtys['Lendorminann'] = $qtys['Lendorminann'] + $qty ;
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
        //百靈佳戀多眠另外再算一次
        $dailyreportstable = boehringer::where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $amount = $dailyreport->Amount;
            if ($dailyreport['SaleType']=='R2') {
              $amount = 0 - $amount;
            }
            $MA['Lendorminann'] = $MA['Lendorminann'] + $amount;
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
        return view('sendboradiary',['Pitavol'=>$medicine['Pitavol'],
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


    public function sendunidiary()
    {
        $todaydate = date('Y-m-d');
        $todaydate = strtotime($todaydate) - 3600*24;
        $todaydate =  date('Y-m-d',$todaydate);
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
        return view('sendunidiary',['medicine'=>$medicine,
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

 public function nonesendboradiary($todaydate)
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
        return view('nonesendboradiary',['Pitavol'=>$medicine['Pitavol'],
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



   public function nonesendunidiary($todaydate)
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
        return view('nonesendunidiary',['medicine'=>$medicine,
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
    public function sendreport()
    {
      $todaydate = date('Y-m-d');
      $todaydate = strtotime($todaydate) - 3600*24;
      $todaydate = date('Y-m-d',$todaydate);
      //Windows
      //$bora  = 'C:\\pic\\'.$todaydate.'bora.jpg';
      //$union = 'C:\\pic\\'.$todaydate.'union.jpg';
      //Linux
      $bora = dirname(__FILE__).'/sendreport/'.$todaydate.'bora.jpg';
      $union = dirname(__FILE__).'/sendreport/'.$todaydate.'union.jpg';
      //$bora = dirname(__FILE__).'/sendreport/2015-11-02bora.jpg';
      //$union = dirname(__FILE__).'/sendreport/2015-11-02union.jpg';
      //$to = ['luke.hsu@bora-corp.com','sean1606@gmail.com'];
      //$to = ['luke.hsu@bora-corp.com','sam.wu@bora-corp.com','whitney.huang@bora-corp.com','demi.tai@bora-corp.com'];
      //$to = ['luke.hsu@bora-corp.com'];
      $to = ['bobby.sheng@gmail.com','whitney.huang@bora-corp.com','demi.tai@bora-corp.com'];
      //信件的內容
      $data = ['borapic'=>$bora,'unionpic'=>$union];
      //寄出信件
      Mail::send('mail.sendreport', $data, function($message) use ($to,$bora,$union,$todaydate) 
      {
         $message->to($to)->subject($todaydate.'業績日報表')->attach($bora)->attach($union);
      });
      echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>"; 
    }

    public function accountreminder()
    {
        $today = date('Y-m-d');
        $today = strtotime($today) - 3600*24;
        $today = date('Y-m-d',$today);
        $arr = [];
        $checkholiday = calendar::where('monthdate','=',$today)->where('offday','=','1')->count();
        if ($checkholiday==0) 
        {
          $users = useracces::where('access','=','業務日報表')->get();
          foreach ($users as $user) 
          {
            $checks = salesmen::where('reportday','=',$today)->where('usernumber','=',$user['user'])->count();
            if ($checks==0) {
              $mails = user::where('name','=',$user['user'])->get();
              foreach ($mails as $mail) {
                array_push($arr, $mail['email']);
              }
            }
          }
          array_push($arr, 'vincent.liao@bora-corp.com');
          array_push($arr, 'daisy.teng@bora-corp.com');
          $to = $arr;
          //信件的內容
          $data = [];
          //寄出信件
          Mail::send('mail.mail', [], function($message) use ($to) 
          {
            $message->to($to)->subject('昨日並未收到您的日報表，請記得補單，謝謝');
          });
          echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }       
    }
    public function autoacbudget()
    {
      return view('autoacbudget');   
    }
}