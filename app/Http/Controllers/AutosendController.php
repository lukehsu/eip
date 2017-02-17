<?php 
namespace App\Http\Controllers;
use App\User;
use App\hareport;
use App\boehringer;
use App\big;
use App\useracces;
use App\calendar;
use App\mobicmappingdata;
use App\agentsmonthbudget;
use App\bigsangent;
use App\userstate;
use App\importantagentsp;
use App\importantp;
use App\importanth;
use App\budgetgp;
use App\importantuniunip;
use App\importantboraunip;
use App\dailyreport;//bora 每日業績
use App\boramonthbudget;//bora每月預算
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\logistic;
use App\itticket;
use App\itservicerank;
use App\everymonth;
use App\salesmen;
use App\boraallaccount;
use App\boraitem;
use App\medicinebudgetbypersonal;
use App\Http\Requests;
use App\personalmonthbudget;
use App\Http\Controllers\ReferenceController;
use Hash,Input,Request,Response,Auth,Redirect,Log,DB,Mail;
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
    public function loginau()
    {
        
        return view('indexau');
    }
    public function sendboradiary()
    {
        $todaydate = date('Y-m-d');
        $todaydate = strtotime($todaydate) - 3600*24;
        $todaydate =  date('Y-m-d',$todaydate);
        $medicine = array('Mobic' => 0 , 
                          'Pitavol' => 0 , 
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

        $itemno = array(  'Mobic' => null , 
                          'Pitavol' => null , 
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

        $qtys = array(    'Mobic' => 0 , 
                          'Pitavol' => 0 , 
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
                case '68MOB001':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ; 
                    $itemno['Mobic'] = $BORAItemNo;
                }    
                    break;
                case '68MOB002':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ; 
                    $itemno['Mobic'] = $BORAItemNo;
                }    
                    break;
                case '68MOB003':
                if ($BORACustomerNo<>'10824') {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ; 
                    $itemno['Mobic'] = $BORAItemNo;
                }    
                    break;
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
            $boehringerItemNo = $dailyreport->ItemNo;
            switch ($boehringerItemNo) {
                case 'A0195':
                  if ($dailyreport['SaleType']=='R2') {
                    $amount = 0 - $amount;
                  }
                  $medicine['Lendorminann'] = $medicine['Lendorminann'] + $amount ;
                  $qtys['Lendorminann'] = $qtys['Lendorminann'] + $qty ; 
                break;
                case 'A0076':
                case 'A0210':
                case 'A0211':
                  if ($dailyreport['SaleType']=='R2') {
                    $amount = 0 - $amount;
                  }
                  $medicine['Mobic'] = $medicine['Mobic'] + $amount ;
                  $medicine['Mobic'] = $medicine['Mobic'] + $qty ; 
                break;                  
                default:

                  break;
            }  
        }       
           
        //每月銷售累加 還有  and 寫法
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        $MA = array(      'Mobic' => 0 , 
                          'Pitavol' => 0 , 
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
                case '68MOB001':
                if ($BORACustomerNo<>'10824' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;
                }      
                break;
                case '68MOB002':
                if ($BORACustomerNo<>'10824' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;
                }      
                break;
                case '68MOB003':
                if ($BORACustomerNo<>'10824' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;
                }      
                break;
                case '68PTV001':
                if ($BORACustomerNo<>'10824' and $BORACustomerNo<>'11032'  ) {
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
        //百靈佳戀多眠MOBIC另外再算一次
        $dailyreportstable = boehringer::where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          $amount = $dailyreport->Amount;
          $boehringerItemNo = $dailyreport->ItemNo;
          switch ($boehringerItemNo) {
            case 'A0195':
              if ($dailyreport['SaleType']=='R2') {
                $amount = 0 - $amount;
              }
              $MA['Lendorminann'] = $MA['Lendorminann'] + $amount;
            break;
            case 'A0076':
            case 'A0210':
            case 'A0211':
              if ($dailyreport['SaleType']=='R2') {
                $amount = 0 - $amount;
              }
              $MA['Mobic'] = $MA['Mobic'] + $amount ;
            break;
            default:

            break;
          }  
        }    
        //每月目標業績
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        $MB = array(      'Mobic' => 0 , 
                          'Pitavol' => 0 , 
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

        $MC = array(      'Mobic' => 0 , 
                          'Pitavol' => 0 , 
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
                case '68MOB001':
                    $MB['Mobic'] = $MonthTotal;
                    break;
                case '68MOB002':
                    $MB['Mobic'] = $MonthTotal ;
                    break;
                case '68MOB003':
                    $MB['Mobic'] = $MonthTotal ;
                    break;
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
        return view('sendboradiary',[
                              'Mobic'=>$medicine['Mobic'],
                              'Pitavol'=>$medicine['Pitavol'],
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
      $GP = dirname(__FILE__).'/sendreport/'.$todaydate.'GP.jpg';
      $HP = dirname(__FILE__).'/sendreport/'.$todaydate.'HP.jpg';
      $uni = dirname(__FILE__).'/sendreport/'.$todaydate.'uni.jpg';
      $heal = dirname(__FILE__).'/sendreport/'.$todaydate.'heal.jpg';
      //$bora = dirname(__FILE__).'/sendreport/2015-11-02bora.jpg';
      //$union = dirname(__FILE__).'/sendreport/2015-11-02union.jpg';
      //$to = ['luke.hsu@bora-corp.com','sean1606@gmail.com'];
      //$to = ['luke.hsu@bora-corp.com','sam.wu@bora-corp.com','whitney.huang@bora-corp.com','demi.tai@bora-corp.com'];
      //$to = ['luke.hsu@bora-corp.com'];
      $to = ['bobby.sheng@gmail.com','christie.hsu@bora-corp.com','demi.tai@bora-corp.com'];
      //信件的內容
      $data = ['GP'=>$GP,'HP'=>$HP ,'uni'=>$uni ,'heal'=>$heal];
      //寄出信件
      Mail::send('mail.sendreport', $data, function($message) use ($to,$GP,$HP,$uni,$heal,$todaydate) 
      {
         $message->to($to)->subject($todaydate.'業績日報表')->attach($GP)->attach($HP)->attach($uni)->attach($heal);
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
    public function createha()
    {
      ini_set('memory_limit', '256M');
      $objPHPExcel = new \PHPExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      $year = date('Y');
      $today = date('Y');
      $dbcount = DB::table('everymonths')->where('years','=',$year)->count();
      $months = DB::table('everymonths')->where('years','=',$year)->get();
      $i = 2;
      $titlearray = ['區域','區域說明'  ,'業務員' ,'業務員姓名' ,'銷售客戶'  ,'客戶名稱'  ,'產品代號'  ,'產品名稱' , '產品英文名稱',  '合計數量',  '合計金額'  ,'201601數量'  ,'201601金額',  '201602數量' , '201602金額' , '201603數量',  '201603金額' , '201604數量' , '201604金額',  '201605數量' , '201605金額' ,'201606數量' , '201606金額' , '201607數量' , '201607金額'  ,'201608數量' , '201608金額' , '201609數量', '201609金額' , '201610數量',  '201610金額' , '201611數量' , '201611金額' , '201612數量' , '201612金額'];
      for ($j=0; $j < 31 ; $j++) { 
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,1 ,$titlearray[$j]);
      }
      foreach ($months as $month) 
      {
        if (substr($month->itemno,0,2)=='68') 
        {
          if ($month->itemno<>'68MOB001' and $month->itemno<>'68MOB002' and $month->itemno<>'68MOB003' and $month->itemno<>'68PTV001' and $month->itemno<>'68DEN001') 
          {
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i ,$month->zone1);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i ,$month->zone2);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i ,$month->empono);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i ,$month->emponame);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i ,$month->customersno);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i ,$month->customers);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i ,$month->itemno);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i ,$month->itemchname);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i ,$month->itemenname);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i ,$month->allqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i ,$month->allmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i ,$month->janqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i ,$month->janmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i ,$month->febqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i ,$month->febmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i ,$month->marqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i ,$month->marmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i ,$month->aprqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i ,$month->aprmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i ,$month->mayqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i ,$month->maymoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i ,$month->junqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$i ,$month->junmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$i ,$month->julqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$i ,$month->julmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$i ,$month->augqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$i ,$month->augmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$i ,$month->sepqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$i ,$month->sepmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$i ,$month->octqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$i ,$month->octmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$i ,$month->novqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$i ,$month->novmoney);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$i ,$month->decqty);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$i ,$month->decmoney);
              $i = $i + 1 ;
          }
        }
      }
      $objPHPExcel->setActiveSheetIndex(0);
      $filename = urlencode("boramon.xlsx");
      ob_end_clean();
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=$filename" );
      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
      header("Pragma: public");
      $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');  
      echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>"; 
    }
    public function sendha()
    {
      $todaydate = date('Y-m-d');
      $todaydate = strtotime($todaydate) - 3600*24;
      $todaydate = date('Y-m-d',$todaydate);
      //Windows
      //$bora  = 'C:\\pic\\'.$todaydate.'bora.jpg';
      //$union = 'C:\\pic\\'.$todaydate.'union.jpg';
      //Linux
      $boramon = dirname(__FILE__).'/sendreport/boramon.xlsx';
      //$bora = dirname(__FILE__).'/sendreport/2015-11-02bora.jpg';
      //$union = dirname(__FILE__).'/sendreport/2015-11-02union.jpg';
      //$to = ['luke.hsu@bora-corp.com','sean1606@gmail.com'];
      //$to = ['luke.hsu@bora-corp.com','sam.wu@bora-corp.com','whitney.huang@bora-corp.com','demi.tai@bora-corp.com'];
      //$to = ['luke.hsu@bora-corp.com'];#weilin.chu@hoanpharma.com
      $to = ['weilin.chu@hoanpharma.com'];
      //信件的內容
      $data = [''];
      //寄出信件
      Mail::send('mail.sendha', $data, function($message) use ($to,$boramon,$todaydate) 
      {
         $message->to($to)->subject($todaydate.'業績報表')->attach($boramon);
      });
      echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>"; 
    }
  public function sendgo()
  {
    $choiceday = Input::get('datepicker');
    $choicedaymed = Input::get('datepickermed');
    $checkprovider = Input::get('checkprovider');
    $peoples = Input::get('checkvalue');
    $medvalue = Input::get('checkmedvalue');
    $monthstart = substr($choiceday, 0,8).'01';
    $radioadmin = Input::get('radio');
    $radiopeople = Input::get('radiopeople');
    $monthstartmed = substr($choicedaymed, 0,8).'01';
    $usergroup = Auth::user()->office;
    $mon = substr($choiceday,5,2);
    $monmed = substr($choicedaymed,5,2);
    #接收input選項 
    (isset($peoples)) ? (''):($peoples = []);
    (isset($medvalue)) ? (''):($medvalue = []);
    (isset($checkprovider)) ? (''):($checkprovider = []);
    $peoplesjava = json_encode($peoples);
    $medvaluejava = json_encode($medvalue);
    $radioadminjava = json_encode($radioadmin);
    $checkproviderjava = json_encode($checkprovider);
    $userstatedate = date('Y-m-01');
    $cnames = [];
    $shippingbig = '物流';
    if ($radiopeople=='GPpeople') {
      $usergroup = '藥品';
      $db = 'importantps';
    }
    else if ($radiopeople=='HPpeople') {
      $usergroup = '醫院';
      $db = 'importanths';
    }
    elseif ($radiopeople=='Healpeople') {
      $usergroup = '保健';
      $db = 'importantheals';
    }
    else
    {
      $db = 'notables';
    } 
    #身份辨識for區別主管跟非主管
    /*if (Auth::user()->level=='') {
      $cnamesforpage = [];
      $checkboxinfo = [];
      $cnamesquitforpage = [];
      $cnamesforpage[Auth::user()->name]=Auth::user()->cname;
      $checkboxinfo[Auth::user()->name] = 'checked' ;
      if (Input::get('checkvalue')<>''and $peoples[0] <> Auth::user()->name) {
        return redirect('gpgo') ;
      }
    }*/
    #捞產品，產品預算，產品達成率產品程式開始
    #$productsselect填充程式起點
    $team = FController::team();
    $radioadmin = json_encode($radioadmin);
    #撈所有產品
    $allitems = FController::allitems($radioadmin);
    #也是撈所有產品跟上一句差別在於這邊給最高權限者使用
    $allitemsforadmin = null;
    #因為$checkprovider已被下面程式利用故在宣告一個$provider
    $provider = $checkprovider;
    $allaccess = FController::provideraccess($provider);
    $companyaccess = $allaccess[0];
    $provideraccess = $allaccess[1];
    $providerbuaccess = $allaccess[2];
    $provideraccess = array_unique($provideraccess);
    $checkboxinfomed = [];
    $medaccess = FController::radiomedaccess();
    $productssell   = FController::productssell($medvalue,$choicedaymed,$monthstartmed,$usergroup,$allitems,$provideraccess,$companyaccess);
    $producbudget   = FController::productsbudget($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$providerbuaccess,$companyaccess);
    $productab = [];
    foreach ($productssell  as $key => $value) {
      if ($producbudget[$key]==0) {
        $productab[$key] = 0;
      }
      else
      {
        $productab[$key] = round(($value/$producbudget[$key])*100);
      }  
    }
    $productssellQ   = FController::productssellQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$allitems,$provideraccess,$companyaccess);
    $productsbudgetQ = FController::productsbudgetQ($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$providerbuaccess,$companyaccess);
    $productQab = [];
    foreach ($productssellQ  as $keys => $values) {
      foreach ($values as $key => $value) {
        if ($productsbudgetQ[$keys][$key]==0) {
          $productQab[$keys][$key] = 0;
        }
        else
        {
          $productQab[$keys][$key] = round($value/$productsbudgetQ[$keys][$key]*100);
        }  
      } 
    }
    $allproductssell = 0;
    foreach ($productssell as $key => $value) {
      $allproductssell = $allproductssell +  $value;
    }
    $allproducbudget = 0;
    foreach ($producbudget as $key => $value) {
      $allproducbudget = $allproducbudget + $value;
    }
    ($allproducbudget<>0)?($allproductab = round(($allproductssell/$allproducbudget)*100)):($allproductab=0);
    $ytdallproductssell = 0;
    if (isset($productssellQ['Q5'])) {
      foreach ($productssellQ['Q5'] as $key => $value) {
        $ytdallproductssell = $ytdallproductssell + $value;
      }
    }
    $ytdallproducbudget = 0;
    if (isset($productsbudgetQ['Q5'])) {
      foreach ($productsbudgetQ['Q5'] as $key => $value) {
        $ytdallproducbudget = $ytdallproducbudget + $value;
      }
    }
    ($ytdallproducbudget<>0)?($ytdallproductab = round(($ytdallproductssell/$ytdallproducbudget)*100)):($ytdallproductab = 0);
    $yearach = FController::yearach($medvalue,$choicedaymed,$monthstartmed,$usergroup,$medaccess,$allitems,$provideraccess,$providerbuaccess,$companyaccess,$choicedaymed);
    $yearachjava = json_encode($yearach);
    #捞產品，產品預算，產品達成率產品程式結束

    #填充$cnames = [] 人員程式重這邊開始並以人員為迴圈的開始
    $teamp = FController::teampeople();
    $radiopeoplejava = json_encode($radiopeople);
    $firstradio = current($teamp);
    $firstradio = json_encode($firstradio);
    foreach ($peoples as $usernum) {
      $users = DB::table('alluserstates')->where('usernum','=',$usernum)->first();
      $cnames[$users->usernum] = $users->cname;
    }
    #撈物流
    $shipping = array();
    $bigs = big::all();
    foreach ($bigs as $big) {
      $shipping[] = $big['customercode'];
    }
    #撈產品
    $importantarget = array();
    if (isset($db)) {
      $importantps = DB::table($db)->get();
      foreach ($importantps as $importantp) {
        $importantarget[] =  $importantp->itemno;  
      }
    }
    #撈每月業績與預算
    $everyone = FController::salesformedicine($shipping,$importantarget,$peoples,$usergroup,$choiceday,$monthstart,$db);
    $budgetmonth = FController::budgetmonth($cnames,$everyone,$choiceday,$usergroup);
    #數字索引部份分別為個人當月業績預算,個人當月達成率,個人當月總total
    $pbudget= $budgetmonth[0];
    $pab= $budgetmonth[1];
    $totals= $budgetmonth[2];
    $everyonejava = json_encode($everyone);

    #撈季度業績,預算,年達成率
    $Qtotal=[];
    $Qpab=[];
    $Qsalesformedicine = FController::Qsalesformedicine($shipping,$importantarget,$choiceday,$peoples,$usergroup,$db);
    $Qbudgetmonth = FController::Qbudgetmonth($cnames,$choiceday,$importantarget,$usergroup);
    $ach = FController::ach($shipping,$importantarget,$peoples,$usergroup,$choiceday);
    $achjava = json_encode($ach);
    foreach ($Qsalesformedicine as $season => $cnames) {
      if ($cnames<>0) {
        foreach ($cnames as $key => $med) 
        {
          $Qtotal[$season][$key] = [];
          $salestotal = array_sum($Qsalesformedicine[$season][$key]);
          $budgettotal  = array_sum($Qbudgetmonth[$season][$key]);
          ($budgettotal==0)?($abtotal=0):($abtotal = round($salestotal/$budgettotal * 100));
          array_push($Qtotal[$season][$key],$salestotal ,$budgettotal,$abtotal);
          foreach ($med as $medkey => $value) 
          {   
            $Qpab[$season][$key][$medkey] = [];
            ($Qbudgetmonth[$season][$key][$medkey]==0) ? ($Qpab[$season][$key][$medkey] = 0) : ($Qpab[$season][$key][$medkey] = round($value/$Qbudgetmonth[$season][$key][$medkey] * 100));
          } 
        }
      }
    }
    $finaltotalsalenobig = null;
    $finaltotalbudgetnobig = null;
    $finalyeartotalsalenobig = null;
    $finalyeartotalbudgetnobig = null;
    $finaltotalsale = null;
    $finaltotalbudget = null;
    $finalyeartotalsale = null;
    $finalyeartotalbudget = null;
    $finalabnobig= null;
    $finalyearabnobig = null;
    $finalab= null;
    $finalyearab = null;
    if ($cnames<>0) {
      foreach ($budgetmonth[2] as $key => $value) {
        if ($key<>'鍾碧如' and $key<>'金容' and $key<>'平廷' ) {
          foreach ($value as $key => $addvalue) {
            if ($key==0) {
              $finaltotalsalenobig = $finaltotalsalenobig + $addvalue;
            }
            if ($key==1) {
              $finaltotalbudgetnobig  = $finaltotalbudgetnobig  + $addvalue;
            }
          }
        }
      }
      if ($finaltotalbudgetnobig==0) {
        $finalabnobig = 0 ;
      }
      else
      {
        $finalabnobig = round($finaltotalsalenobig/$finaltotalbudgetnobig * 100);       
      }  
      foreach ($Qsalesformedicine['Q5'] as $key => $values) {
        if ($key<>'鍾碧如' and $key<>'金容' and $key<>'平廷') {
          $finalyeartotalsalenobig = $finalyeartotalsalenobig + array_sum($values);
        }
      }
      foreach ($Qbudgetmonth['Q5'] as $key => $values) {
        if ($key<>'鍾碧如' and $key<>'金容' and $key<>'平廷' ) {
          $finalyeartotalbudgetnobig = $finalyeartotalbudgetnobig + array_sum($values);
        }
      }
      if ($finalyeartotalbudgetnobig==0) {
        $finalyearabnobig = 0;
      }
      else
      {
        $finalyearabnobig = round($finalyeartotalsalenobig/$finalyeartotalbudgetnobig * 100);
      }  
      foreach ($budgetmonth[2] as $key => $value) {
        foreach ($value as $key => $addvalue) {
          if ($key==0) {
            $finaltotalsale = $finaltotalsale + $addvalue;
          }
          if ($key==1) {
            $finaltotalbudget = $finaltotalbudget  + $addvalue;
          }
        }
      }
      if ($finaltotalbudget==0) 
      {
        $finalab = 0;
      }
      else
      {
        $finalab = round($finaltotalsale/$finaltotalbudget * 100);
      }  
      foreach ($Qsalesformedicine['Q5'] as $key => $values) {
        $finalyeartotalsale = $finalyeartotalsale + array_sum($values);
      }
      foreach ($Qbudgetmonth['Q5'] as $key => $values) {
        $finalyeartotalbudget = $finalyeartotalbudget + array_sum($values);
      }
      if ($finalyeartotalbudget==0) 
      {
        $finalyearab = 0;
      }
      else
      {
        $finalyearab = round($finalyeartotalsale/$finalyeartotalbudget * 100);
      } 
    }

    return view('sendgo',['totals'=>$totals 
                    ,'pab'=>$pab 
                    ,'pbudget'=>$pbudget 
                    ,'everyone'=>$everyone
                    ,'everyonejava'=>$everyonejava
                    ,'cnames'=>$cnames
                    ,'choiceday'=>$choiceday
                    ,'Qbudgetmonth'=>$Qbudgetmonth
                    ,'Qsalesformedicine'=>$Qsalesformedicine
                    ,'Qtotal'=>$Qtotal
                    ,'Qpab'=>$Qpab
                    ,'achjava'=>$achjava
                    ,'finaltotalsalenobig'=>$finaltotalsalenobig
                    ,'finaltotalbudgetnobig'=>$finaltotalbudgetnobig 
                    ,'finalabnobig'=>$finalabnobig
                    ,'finalyeartotalsalenobig'=>$finalyeartotalsalenobig
                    ,'finalyeartotalbudgetnobig'=>$finalyeartotalbudgetnobig
                    ,'finalyearabnobig'=>$finalyearabnobig
                    ,'finaltotalsale'=>$finaltotalsale
                    ,'finaltotalbudget'=>$finaltotalbudget
                    ,'finalab'=>$finalab
                    ,'finalyeartotalsale'=>$finalyeartotalsale
                    ,'finalyeartotalbudget'=>$finalyeartotalbudget
                    ,'finalyearab'=>$finalyearab
                    ,'mon'=>$mon
                    ,'fromsubmit'=>'gpgo'
                    ,'productssell'=>$productssell
                    ,'producbudget'=>$producbudget
                    ,'productab'=>$productab
                    ,'productssellQ'=>$productssellQ
                    ,'productsbudgetQ'=>$productsbudgetQ 
                    ,'productQab'=>$productQab
                    ,'yearachjava'=>$yearachjava
                    ,'choicedaymed'=>$choicedaymed
                    ,'monmed'=>$monmed
                    ,'allproductssell'=>$allproductssell
                    ,'allproducbudget'=>$allproducbudget
                    ,'allproductab'=>$allproductab
                    ,'ytdallproductssell'=>$ytdallproductssell
                    ,'ytdallproducbudget'=>$ytdallproducbudget
                    ,'ytdallproductab'=>$ytdallproductab
                    ,'checkboxinfomed'=>$checkboxinfomed
                    ,'shippingbig'=>$shippingbig
                    ,'team'=>$team
                    ,'radioadmin'=>$radioadmin
                    ,'teamp'=>$teamp
                    ,'firstradio'=>$firstradio
                    ,'radiopeoplejava'=>$radiopeoplejava
                    ,'peoplesjava'=>$peoplesjava
                    ,'medvaluejava'=>$medvaluejava
                    ,'radioadminjava'=>$radioadminjava
                    ,'checkproviderjava'=>$checkproviderjava
                    ]);
  }
  public function logincount()
  {
    $gp = [];
    $hp = [];
    $uni = [];
    $heal = [];
    $other = [];
    $allname = [];
    $m = date("m");
    $d = date("t");
    $mf = $m.'-01';
    $md = $m.'-'.$d;
    $y = date("Y");
    $counts = DB::table('userstatesgps')->where('exist','=','在職')->where('usernum','like','b%')->orderby('sortstand','desc')->get();
    foreach ($counts as $count) {
      $counts = DB::table('loginhistory')->where('salename','=',$count->cname)->where('logindate','>=',$mf)->where('logindate','<=',$md)->where('loginyear','=',$y )->distinct()->count(['logindate']);
      $gp[$count->cname] = $counts ;
      $user = DB::table('users')->where('cname','=',$count->cname)->first();
      $dotnumber = strpos($user->email, '.');
      if ($dotnumber>=10) {
        $dotnumber = strpos($user->email, '@');
      }
      $userenmame = substr($user->email, 0,$dotnumber);
      $allname[$count->cname] = ucfirst($userenmame) ;
    }

    $counts = DB::table('userstateshps')->where('exist','=','在職')->where('usernum','like','b%')->orderby('sortstand','desc')->get();
    foreach ($counts as $count) {
      $counts = DB::table('loginhistory')->where('salename','=',$count->cname)->where('logindate','>=',$mf)->where('logindate','<=',$md)->where('loginyear','=',$y )->distinct()->count(['logindate']);
      $hp[$count->cname] = $counts ;
      $user = DB::table('users')->where('cname','=',$count->cname)->first();
      $dotnumber = strpos($user->email, '.');
      if ($dotnumber>=10) {
        $dotnumber = strpos($user->email, '@');
      }
      $userenmame = substr($user->email, 0,$dotnumber);
      $allname[$count->cname] = ucfirst($userenmame) ;
    }
    $counts = DB::table('userstatesunisforcount')->where('exist','=','在職')->where('usernum','like','b%')->orderby('sortstand','desc')->get();
    foreach ($counts as $count) {
      $counts = DB::table('loginhistory')->where('salename','=',$count->cname)->where('logindate','>=',$mf)->where('logindate','<=',$md)->where('loginyear','=',$y )->distinct()->count(['logindate']);
      $uni[$count->cname] = $counts ;
      $user = DB::table('users')->where('cname','=',$count->cname)->first();
      $dotnumber = strpos($user->email, '.');
      if ($dotnumber>=10) {
        $dotnumber = strpos($user->email, '@');
      }
      $userenmame = substr($user->email, 0,$dotnumber);
      $allname[$count->cname] = ucfirst($userenmame) ;
    }
    $counts = DB::table('userstateshealthys')->where('exist','=','在職')->where('usernum','like','b%')->orderby('sortstand','desc')->get();
    foreach ($counts as $count) {
      $counts = DB::table('loginhistory')->where('salename','=',$count->cname)->where('logindate','>=',$mf)->where('logindate','<=',$md)->where('loginyear','=',$y )->distinct()->count(['logindate']);
      $heal[$count->cname] = $counts ;
      $user = DB::table('users')->where('cname','=',$count->cname)->first();
      $dotnumber = strpos($user->email, '.');
      if ($dotnumber>=10) {
        $dotnumber = strpos($user->email, '@');
      }
      $userenmame = substr($user->email, 0,$dotnumber);
      $allname[$count->cname] = ucfirst($userenmame) ;
    }
    $counts = DB::table('userstatesothers')->where('exist','=','在職')->where('usernum','like','b%')->orderby('sortstand','desc')->get();
    foreach ($counts as $count) {
      $counts = DB::table('loginhistory')->where('salename','=',$count->cname)->where('logindate','>=',$mf)->where('logindate','<=',$md)->where('loginyear','=',$y )->distinct()->count(['logindate']);
      $other[$count->cname] = $counts ;
      $user = DB::table('users')->where('cname','=',$count->cname)->first();
      $dotnumber = strpos($user->email, '.');
      if ($dotnumber>=10) {
        $dotnumber = strpos($user->email, '@');
      }
      $userenmame = substr($user->email, 0,$dotnumber);
      $allname[$count->cname] = ucfirst($userenmame) ;
    }
    $gpjava = json_encode($gp);
    $hpjava = json_encode($hp);
    $unijava = json_encode($uni);
    $healjava = json_encode($heal);
    $otherjava = json_encode($other);
    $allnamejava = json_encode($allname);
    return view('logincount',['gpjava'=>$gpjava,
                              'hpjava'=>$hpjava,
                              'unijava'=>$unijava,
                              'healjava'=>$healjava,
                              'otherjava'=>$otherjava,
                              'allnameava'=>$allnamejava
                              ]);
  }
    public function sendlogincount()
    {
      $todaydate = date("Y-m-d");
      $countspic = dirname(__FILE__).'/sendreport/'.$todaydate.'.jpg';
      //$bora = dirname(__FILE__).'/sendreport/2015-11-02bora.jpg';
      //$union = dirname(__FILE__).'/sendreport/2015-11-02union.jpg';
      //$to = ['luke.hsu@bora-corp.com','sean1606@gmail.com'];
      //$to = ['luke.hsu@bora-corp.com','sam.wu@bora-corp.com','whitney.huang@bora-corp.com','demi.tai@bora-corp.com'];
      //$to = ['luke.hsu@bora-corp.com'];
      $to = ['luke.hsu@bora-corp.com'];
      //信件的內容
      $data = ['countspic'=>$countspic];
      //寄出信件
      Mail::send('mail.sendlogincount', $data, function($message) use ($to,$countspic) 
      {
         $message->to($to)->subject('各部門每月EIP登入表')->attach($countspic);
      });
      echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>"; 
    }
  public function sendmeal()
  {
    $who = [];
    $date = [];
    $total = [];
    $mainsub = '';
    $todaydate = date("Y-m-d");
    $meals = DB::table('meal')->where('pay','=','0')->orderby('day','asc')->groupBy('day')->get();
    foreach ($meals as $value) 
    {
      $to = [];
      $meal = DB::table('meal')->selectraw('sum(price) as price')->where('name','=',$value->name)->where('day','=',$value->day)->where('pay','=','0')->get();
      foreach ($meal as $val) 
      {
        $context = '';

        $ml = DB::table('meal')->where('name','=',$value->name)->where('day','=',$value->day)->where('pay','=','0')->get();
        foreach ($ml as $v) {
          $context .= $v->items . '  ' . $v->price .'元<br>';
        }
        $mainsub = '您'.$value->day.'的餐費'.$val->price.'元還未繳納,謝謝';
        //寄件人
        $usermails = DB::table('users')->where('cname','=',$value->name)->get();
        foreach ($usermails as $value) {
          $to[] = $value->email;
        }
        $to[] = 'abby.lin@bora-corp.com';
        //信件的內容
        $data = ['context'=>$context];
        //寄出信件
        Mail::send('mail.sendmeal', $data, function($message) use ($to,$mainsub) 
        {
          $message->to($to)->subject($mainsub);
        });
      }
    }
    echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>";
  }
  public function sendinfosafe()
  {
      $countspic = dirname(__FILE__).'/infopic.jpg';
      $context = '';
      $mainsub = '資訊安全宣導';
      //寄件人
      $to = ['all@bora-corp.com','tainan@bora-corp.com'];
      //信件的內容
      $data = ['countspic'=>$countspic];
      //寄出信件
      Mail::send('mail.sendinfosafe', $data, function($message) use ($to,$mainsub) 
      {
        $message->to($to)->subject($mainsub);
      });
    echo  "<script type='text/javascript'>setTimeout(self.close(),15000);</script>";
  }
}