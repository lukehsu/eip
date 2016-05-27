<?php 
namespace App\Http\Controllers;
use App\user;
use App\hareport;
use App\calendar;
use App\boehringer;
use App\big;
use App\monthach;
use App\Http\Controllers\FController;
use App\mobicmappingdata;
use App\agentsmonthbudget;
use App\bigsangent;
use App\userstate;
use App\importantagentsp;
use App\importantp;
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
    $this->middleware('logincheck', ['except' => ['login','show','sign']]);
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

    public function sign()
    {
      return view('sign');
    }
    
    public function boradiary($todaydate)
    {

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
        return view('boradiary',[
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
        $medicine = array(
                          'Mobic' => 0 ,
                          'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );

        $itemno = array(  
                          'Mobic' => null ,
                          'Pitavol' => null , 
                          'Denset' => null , 
                          'Lepax10' => null , 
                          'Lepax5' => null , 
                          'Lexapro' => null , 
                          'Ebixa' => null , 
                          'Deanxit' => null , 
                          'LendorminBora' => null , 
                          'Others' => null,
                         );

        $qtys = array(    
                          'Mobic' => 0 ,
                          'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                    );
        include(app_path().'/Http/Controllers/ReferenceController.php');
        /*$dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;
            $BORACustomerName = $dailyreport->BORACustomerName;
            $BORACustomerNo = $dailyreport->BORACustomerNo; 
            //if (substr($dailyreport['BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225') 
            //{                   
              switch ($BORAItemNo) {
                case '68MOB001':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ; 
                    $itemno['Mobic'] = $BORAItemNo; 
                }
                    break;
                case '68MOB002':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ; 
                    $itemno['Mobic'] = $BORAItemNo;
                }
                    break;
                case '68MOB003':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                    $medicine['Mobic'] = $medicine['Mobic'] + $dailysell;
                    $qtys['Mobic'] = $qtys['Mobic'] + $qty ;  
                } 
                    break;
                case '68PTV001':
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                    $itemno['Pitavol'] = $BORAItemNo;
                    break;
                case '68DEN001':
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                    $itemno['Denset'] = $BORAItemNo;
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
            //}
        }*/ 
        $change1 = 'B0181';
        $change2 = '陳瑛旼';
        if ($todaydate<'2016-04-01') {
          $change1 = 'ww';
          $change2 = 'ww';
        }
        //and寫法註記一下單月銷售累加
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
                          'Others' => 0,
                         );
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt; 
            $BORACustomerNo = $dailyreport->BORACustomerNo; 
            //if (substr($dailyreport['BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225') 
            //{                   
              switch ($BORAItemNo) {
                case '68MOB001':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;   
                }   
                break;
                case '68MOB002':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;   
                }   
                break;
                case '68MOB003':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MA['Mobic'] = $MA['Mobic'] + $MonthTotal;
                }  
                break;
                case '68PTV001':
                  if ($BORACustomerNo <> '11032') {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal; 
                  }
                break;
                case '68DEN001':
                if ($BORACustomerNo <> '20602') {
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
                if ($BORACustomerNo<>'11073' and $BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                }    
                break;
              }
            //} 
        }
        //百靈佳MOBIC另外再算一次
        $dailyreportstable = mobicmappingdata::where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          $amount = $dailyreport->Amount;
          $boehringerItemNo = $dailyreport->ItemNo;
          switch ($boehringerItemNo) {
            case 'A0076':
            case 'A0210':
            case 'A0211':
            if ($dailyreport['salename']<>'許峻哲' and $dailyreport['salename']<>$change2 and $dailyreport['salename']<>'李琪芬' and $dailyreport['salename']<>'劉經翊' and $dailyreport['cusno']<>'030049' and $dailyreport['cusno']<>'094487' and $dailyreport['cusno']<>'050694' and $dailyreport['cusno']<>'010015' and $dailyreport['cusno']<>'030021' and $dailyreport['cusno']<>'030007' and $dailyreport['cusno']<>'060020' and $dailyreport['cusno']<>'010005' and $dailyreport['cusno']<>'020069' ) {
              if ($dailyreport['SaleType']=='R2') {
                $amount = 0 - $amount;
              }
              $MA['Mobic'] = $MA['Mobic'] + $amount ;
            }  
            break;
            default:

            break;
          }  
        }  
        $MAA = array(     'Mobic' => 0 ,
                          'Pitavol' => 0 , 
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
            //if (substr($dailyreport['BORAItemNo'],0,2)<>'67' and $dailyreport['BORACustomerNo']<>'UCS05' and $dailyreport['BORACustomerNo']<>'10824' and $dailyreport['BORACustomerNo']<>'10973' and $dailyreport['BORACustomerNo']<>'11032' and $dailyreport['$BORAItemNo'] <>'57ARZTPG' and $dailyreport['BORACustomerNo'] <>'10103'  and $dailyreport['BORACustomerNo'] <>'10080' and $dailyreport['BORACustomerNo'] <>'10149' and $dailyreport['BORACustomerNo'] <>'10152' and $dailyreport['BORACustomerNo'] <>'10167' and $dailyreport['BORACustomerNo'] <>'10179' and $dailyreport['BORACustomerNo'] <>'10234' and $dailyreport['BORACustomerNo'] <>'10242'and $dailyreport['BORACustomerNo'] <>'10249' and $dailyreport['BORACustomerNo'] <>'11014'and $dailyreport['BORACustomerNo'] <>'20017' and $dailyreport['BORACustomerNo'] <>'20046' and $dailyreport['BORACustomerNo'] <>'20131' and $dailyreport['BORACustomerNo'] <>'20674' and $dailyreport['BORACustomerNo'] <>'20769' and $dailyreport['BORACustomerNo'] <>'30120' and $dailyreport['BORACustomerNo'] <>'30180' and $dailyreport['BORACustomerNo'] <>'30195' and $dailyreport['BORACustomerNo'] <>'30201' and $dailyreport['BORACustomerNo'] <>'30221' and $dailyreport['BORACustomerNo'] <>'30225') 
            //{ 
            if ($dailyreport['SalesRepresentativeNo']<>$change1 ){        
              switch ($BORAItemNo) {
                case '68MOB001':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MAA['Mobic'] = $MAA['Mobic'] + $dailysell;  
                }    
                break;
                case '68MOB002':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MAA['Mobic'] = $MAA['Mobic'] + $dailysell;  
                }    
                break;
                case '68MOB003':
                if ($dailyreport['SalesRepresentativeNo']<>'B0171' and $dailyreport['SalesRepresentativeNo']<>'B0182' and $dailyreport['SalesRepresentativeNo']<>$change1 and $dailyreport['SalesRepresentativeNo']<>'B0195' ) {
                  $MAA['Mobic'] = $MAA['Mobic'] + $dailysell;
                }  
                break;
                case '68PTV001':
                  if ($BORACustomerNo <> '11032') {
                    $MAA['Pitavol'] = $MAA['Pitavol'] + $dailysell;
                  }   
                break;
                case '68DEN001':
                if ($BORACustomerNo <> '20602') {
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
                if ($BORACustomerNo<>'11073' and $BORACustomerNo<>'10973' and $BORACustomerNo<>'11032' and $BORACustomerNo<> 'UCS05' and $BORACustomerNo<>'10824' and $BORAItemNo<>'57ARZTPG' and substr($BORAItemNo,0,2)<>'67' ) 
                {
                    $MAA['Others'] = $MAA['Others'] + $dailysell ;   
                }    
                break;
              }
            }
        }
        $dailyreportstable = mobicmappingdata::where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          $amount = $dailyreport->Amount;
          $boehringerItemNo = $dailyreport->ItemNo;
          switch ($boehringerItemNo) {
            case 'A0076':
            case 'A0210':
            case 'A0211':
            if ($dailyreport['salename']<>'許峻哲' and $dailyreport['salename']<>$change2 and $dailyreport['salename']<>'李琪芬' and $dailyreport['salename']<>'劉經翊' and $dailyreport['cusno']<>'030049' and $dailyreport['cusno']<>'094487' and $dailyreport['cusno']<>'050694' and $dailyreport['cusno']<>'010015' and $dailyreport['cusno']<>'030021' and $dailyreport['cusno']<>'030007' and $dailyreport['cusno']<>'060020' and $dailyreport['cusno']<>'010005' and $dailyreport['cusno']<>'020069' ) {
              if ($dailyreport['SaleType']=='R2') {
                $amount = 0 - $amount;
              }
              $MAA['Mobic'] = $MAA['Mobic'] + $amount ;
            }  
            break;
            default:

            break;
          }  
        } 
        //撈每月目標業績
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
                          'Others' => 0,
                         );
        $MBB = array(     'Mobic' => 0 ,
                          'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
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
                          'Others' => 0,
                         );
        $MCC = array(     'Mobic' => 0 ,
                          'Pitavol' => 0 , 
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
                case 'Mobicae':
                  $MB['Mobic'] = $MonthTotal;    
                break;
                /*case '68MOB002':
                  $MB['Mobic'] = $MonthTotal;     
                break;
                case '68MOB003':
                  $MB['Mobic'] = $MonthTotal; 
                break;*/
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
                case 'Mobicae':
                  $MBB['Mobic'] = $MBB['Mobic'] + $MonthTotal;    
                break; 
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
        $ML = array(      'Mobic' => 0 ,
                          'Pitavol' => 0 , 
                          'Denset' => 0 , 
                          'Lepax10' => 0 , 
                          'Lepax5' => 0 , 
                          'Lexapro' => 0 , 
                          'Ebixa' => 0 , 
                          'Deanxit' => 0 , 
                          'LendorminBora' => 0 , 
                          'Others' => 0,
                         );
        $MLL = array(     'Mobic' => 0 ,
                          'Pitavol' => 0 , 
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
        $totalml = 0 ;
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
                                    'season'=>$season,
                                  ]);
    }

    public function personaldiary($todaydate)
    {
      include(app_path().'/Http/Controllers/ReferenceController.php');
      //用網址判斷是否為藥品或醫院人員差異在於撈取的對象不同
      if ($uris=='personaldiary') {
        $office = '藥品';
      }
      else
      {
        $office = '醫院';
      }        
      //提取所有要排除的廠商
      $outs = big::all();
      foreach ($outs as $out) 
      {
        array_push($outcounts, $out['customercode']);
      }
      //程式起點提取人名
      $users = User::where('dep','=','藥品事業部')->where('location','=','外勤')->orderBy('sorts', 'ASC')->get();
      foreach ($users as $user) 
      {

        $userdate =  substr($todaydate,0,8).'01';
        $userstates = userstate::where('cname','=',$user['cname'])->where('userdate','=',$userdate)->first();
        if ($userstates['userstatus']==$office or $user['cname']=='陳瑛旼' ) {
          if ($user['cname']=='陳瑛旼' and $uris=='personalhp' ) {
            $monthstart = '2016-04-01';
            $yearstart = '2016-04-01';
          } 
          $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','=',$todaydate)->get();
          $dailyreportaday = 0 ;
          foreach ($dailyreports as $dailyreport) 
          {  
            foreach ($outcounts as $outcount) {
              if ($outcount==$dailyreport['BORACustomerNo'] ) {
                $dailyreport['InoviceAmt'] = 0 ;
              }
            } 
            $dailyreportaday = $dailyreportaday + $dailyreport['InoviceAmt']; 
          }
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$user['cname'])->where('Date','=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$user['cname'])->where('Date','=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$user['cname'])->where('Date','=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
            $dailyreportaday = $dailyreportaday + $dailyreport['Amount'];
          } 
          //計算由月初累計至當日業績
          $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
          $MA = 0 ;
          foreach ($dailyreports as $dailyreport) 
          {
            foreach ($outcounts as $outcount) {
              if ($outcount==$dailyreport['BORACustomerNo'] ) {
                $dailyreport['InoviceAmt'] = 0 ;
              }
            }
            $MA = $MA + $dailyreport['InoviceAmt'];  
          }
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$user['cname'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$user['cname'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$user['cname'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
            $MA = $MA + $dailyreport['Amount'];
          }  
          //提取每月目標
          $MB = 0;
          $monthbudgets = personalmonthbudget::where('zone','=',$user['cname'])->where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
          foreach ($monthbudgets as $monthbudget) {
            $MB = $monthbudget['budget'];
          } 
          //結至當日達成率
          if ($MB==0) {
            $MC[$i] = 0;
          }
          else
          {
            $MC[$i] = round(($MA/$MB) * 100) ;            
          }  
          //計算季累計由年初至當日
          $dailyreports = dailyreport::where('SalesRepresentativeNo','=',$user['name'])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
          $MAA = 0 ;
          foreach ($dailyreports as $dailyreport) 
          { 
            foreach ($outcounts as $outcount) {
              if ($outcount==$dailyreport['BORACustomerNo'] ) {
                $dailyreport['InoviceAmt'] = 0 ;
              }
            }
            $MAA = $MAA + $dailyreport['InoviceAmt']; 
          }
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$user['cname'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$user['cname'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$user['cname'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
            $MAA = $MAA + $dailyreport['Amount'];
          } 
          //計算年累計目標由年初至當月
          $monthbudgets = personalmonthbudget::where('zone','=',$user['cname'])->where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
          $MBB  = 0 ;
          foreach ($monthbudgets as $monthbudget) {
            $MBB = $MBB +  $monthbudget['budget'];
          } 
          // MCC  A/B
          if ($MBB==0) {
            $MCC[$i] = 0;
          }
          else
          {
            $MCC[$i] = round(($MAA/$MBB) * 100) ;            
          }  
          if ($user['cname']=='陳瑛旼' and $uris=='personaldiary' and $todaydate >= '2016-04-01' ) {
            $MA = 0;
            $MB = 0;
            $MAA = '883078';
            $MBB = '858525';
            $MC[$i] = 0 ;
            $MCC[$i] = round(($MAA/$MBB) * 100) ;
          }
          //計算totel起點
          $totaldairy = $totaldairy + $dailyreportaday;
          $totalMA = $totalMA + $MA;
          $totalMB = $totalMB + $MB;
          $totalMAA = $totalMAA + $MAA;
          $totalMBB = $totalMBB + $MBB;
          $chkuser = monthach::where('name','=',$user['cname'])->where('mondate','=',$monthstart)->count();   
          if ($chkuser==0){
            $ach = new  monthach;
            $ach->mondate = $monthstart;
            $ach->ach = $MC[$i];
            $ach->name = $user['cname'];
            $ach->save();
          }  
          else
          {
            $ach = monthach::where('name','=',$user['cname'])->where('mondate','=',$monthstart)->update(array('mondate' => $monthstart,'ach' => $MC[$i],'mondate' => $monthstart,'name' => $user['cname']));        
          }  
          $achs = monthach::where('name','=',$user['cname'])->where('mondate','=',$monthstart)->get();
          foreach ($achs as $ach) {
            $allach[$user['cname']] = $ach['ach'];
          }
          //計算totel終點
          $form .= '<tr ><td class="text-center"><a href="http://127.0.0.1/eip/public/personalmedicinediary/'.$user['cname'].'/'.$todaydate.'">'.$user['cname'].'</a></td>';
          $form .= '<td class="text-center">'.number_format($MA).'</td>';
          $form .= '<td class="text-center">'.number_format($MB).'</td><td class="text-center">'.$MC[$i].' %</td>';
          $form .= '<td class="text-center">'.number_format($MAA).'</td>'; 
          $form .= '<td class="text-center">'.number_format($MBB).'</td><td class="text-center">'.$MCC[$i].' %</td>';  
          $form .= '</tr>';
          $style = $style + 1 ;
          $i = $i+1;
        }
      }
      //所有人員的TOTAL起點
      $totalMC = round(($totalMA/$totalMB) * 100);
      $totalMCC = round(($totalMAA/$totalMBB) * 100);
      $form .= '<tr><td class="text-center subcolor"><i>Sub-TTL</i></td>';
      $form .= '<td class="text-center subcolor">'.number_format($totalMA).'</td>';
      $form .= '<td class="text-center subcolor">'.number_format($totalMB).'</td><td class="text-center subcolor">'.$totalMC.' %</td>';
      $form .= '<td class="text-center subcolor">'.number_format($totalMAA).'</td>'; 
      $form .= '<td class="text-center subcolor">'.number_format($totalMBB).'</td><td class="text-center subcolor">'.$totalMCC.' %</td>';  
      $form .= '</tr>';
      //所有人員的TOTAL終點
      //物流計算起點藥品組須算業績的廠商以及醫院組要算業績的廠商
      if ($uris=='personaldiary') {
        $outs = big::where('income','=','Y')->get();
        $checksp =0;
      }
      else
      {
        $outs = big::where('income','=','SP')->get();
        $checksp = 1 ;
      }  
      $dailyreportaday = 0 ;
      $MA = 0 ;
      $MAA = 0 ;
      $MBB  = 0 ;
      foreach ($outs as $out) 
      {
        //計算當日業績醫院組金容平廷只會出現在裕利表單所以這邊給中文沒差
        $dailyreports = dailyreport::where('BORACustomerNo','=',$out['customercode'])->where('InvDate','=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) 
        {  
          $dailyreportaday = $dailyreportaday + $dailyreport['InoviceAmt']; 
        }
        //計算由月初累計至當日業績
        $dailyreports = dailyreport::where('BORACustomerNo','=',$out['customercode'])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        if ($checksp==1) {
          $MA = 0 ;
        } 
        foreach ($dailyreports as $dailyreport) 
        {
          if ($outcount==$dailyreport['BORACustomerNo'] ) {
              $dailyreport['InoviceAmt'] = 0 ;
          }
          $MA = $MA + $dailyreport['InoviceAmt'];  
        }
        //計算當日業績醫院組金容平廷只會出現在裕利表單所以這邊給中文
        $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['SaleType']=='R2') {
            $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
          }
            $MA = $MA + $dailyreport['Amount'];
        } 
        //提取每月目標
        $monthbudgets = personalmonthbudget::where('zone','=',$out['customercode'])->where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          $MB = $monthbudget['budget'];
        } 
        //結至當日達成率
        $MC[$i] = round(($MA/$MB) * 100) ;
        //計算年累計由年初至當日
        $dailyreports = dailyreport::where('BORACustomerNo','=',$out['customercode'])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        if ($checksp==1) {
          $MAA = 0 ;
        } 
        foreach ($dailyreports as $dailyreport) 
        {
          if ($outcount==$dailyreport['BORACustomerNo'] ) {
            $dailyreport['InoviceAmt'] = 0 ;
          }
          $MAA = $MAA + $dailyreport['InoviceAmt']; 
        }
        $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['SaleType']=='R2') {
            $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
          }
            $MAA = $MAA + $dailyreport['Amount'];
        } 
        //計算年累計目標由年初至當月因為$out['customercode']為編號因無物流代號故使用中文
        $monthbudgets = personalmonthbudget::where('zone','=',$out['customercode'])->where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        $MBB = 0 ;
        foreach ($monthbudgets as $monthbudget) {
          $MBB = $MBB +  $monthbudget['budget'];
        } 
        // MCC  A/B
        if ($MBB<>0) {
          $MCC[$i] = round(($MAA/$MBB) * 100) ;
        }
        if ($uris=='personalhp'){ 
          //計算醫院組totel起點         
          $totaldairy = $totaldairy + $dailyreportaday;
          $totalMA = $totalMA + $MA;
          $totalMB = $totalMB + $MB;
          $totalMAA = $totalMAA + $MAA ;
          $totalMBB = $totalMBB + $MBB;
          $chkuser = monthach::where('name','=',$out['customercode'])->where('mondate','=',$monthstart)->count();   
          if ($chkuser==0){
            $ach = new  monthach;
            $ach->mondate = $monthstart;
            $ach->ach = $MC[$i];
            $ach->name = $out['customercode'];
            $ach->save();
          }  
          else
          {
            $ach = monthach::where('name','=',$out['customercode'])->where('mondate','=',$monthstart)->update(array('mondate' => $monthstart,'ach' => $MC[$i],'mondate' => $monthstart,'name' => $out['customercode']));        
          }  
          $achs = monthach::where('name','=',$out['customercode'])->where('mondate','=',$monthstart)->get();
          foreach ($achs as $ach) {
            $allach[$out['customercode']] = $ach['ach'];
          }
          //計算醫院組totel終點
          //醫院組金容平廷起點
          $form .= '<tr ><td width="200px" class="text-center">'.$out['customercode'].'</td>';
          $form .= '<td class="text-center">'.number_format($MA).'</td>';
          $form .= '<td class="text-center">'.number_format($MB).'</td><td class="text-center">'.$MC[$i].' %</td>';
          $form .= '<td class="text-center">'.number_format($MAA).'</td>';
          $form .= '<td class="text-center">'.number_format($MBB).'</td><td class="text-center">'.$MCC[$i].' %</td>';  
          $form .= '</tr>';
          //醫院組金容平廷終點
          $i = $i + 1;
        }
      }  
      $user['cname'] = '物流';
      //物流計算終點
      if ($uris=='personaldiary'){ 
        //計算totel起點
        $totaldairy = $totaldairy + $dailyreportaday;
        $totalMA = $totalMA + $MA;
        $totalMB = $totalMB + $MB;
        $totalMAA = $totalMAA + $MAA ;
        $totalMBB = $totalMBB + $MBB;
        $totalMC = round(($totalMA/$totalMB) * 100);
        $totalMCC = round(($totalMAA/$totalMBB) * 100);
        //計算totel終點
        //藥品組物流起點
        $form .= '<tr ><td width="200px" class="text-center"><a href="http://127.0.0.1/eip/public/personalmedicinediary/'.$user['cname'].'/'.$todaydate.'">'.$out['customercode'].'</a></td>';
        $form .= '<td class="text-center">'.number_format($MA).'</td>';
        $form .= '<td class="text-center">'.number_format($MB).'</td><td class="text-center">'.$MC[$i].' %</td>';
        $form .= '<td class="text-center">'.number_format($MAA).'</td>';
        $form .= '<td class="text-center">'.number_format($MBB).'</td><td class="text-center">'.$MCC[$i].' %</td>';  
        //藥品組物流終點
      }  
      else
      { 
        //醫院組的達成率
        $totalMC = round(($totalMA/$totalMB) * 100);
        $totalMCC = round(($totalMAA/$totalMBB) * 100);
      }
      $form .= '<tr ><td class="text-center endcolor">TOTAL</td>';
      $form .= '<td class="text-center endcolor">'.number_format($totalMA).'</td>';
      $form .= '<td class="text-center endcolor">'.number_format($totalMB).'</td><td class="text-center endcolor">'.$totalMC.' %</td>';
      $form .= '<td class="text-center endcolor">'.number_format($totalMAA).'</td>';
      $form .= '<td class="text-center endcolor">'.number_format($totalMBB).'</td><td class="text-center endcolor">'.$totalMCC.' %</td>';  
      $form .= '</tr>';     
      $allnames = json_encode($allname);
      return view($uris,[ 'form'=>$form,
                                    'MC'=>$MC, 
                                    'todaydate'=>$todaydate,
                                    'chardate'=>$chardate, 
                                    'today'=>$todaydate,
                                    'allname'=>$allnames,
                                    'season'=>$season,
                                  ]);
    }



    public function personalmedicinediary($user,$todaydate)
    {
      include(app_path().'/Http/Controllers/ReferenceController.php');
      $charuser =  $user ; 
      $iteminfo = array();
      $outcounts = array();
      $outs = big::all();//提取所有要排除的廠商
      foreach ($outs as $out) 
      {
        array_push($outcounts, $out['customercode']);
      }
      $medicines = importantp::all();
      foreach ($medicines as $medicinep) 
      {
        $iteminfo[] = $medicinep['itemno'];
        $medicine[$medicinep['importantproduct']] = 0;
        $MA[$medicinep['importantproduct']] = 0;
        $MAA[$medicinep['importantproduct']] = 0; 
        $MB[$medicinep['importantproduct']] = 0; 
        $MBB[$medicinep['importantproduct']] = 0; 
        $MC[$medicinep['importantproduct']] = 0; 
        $MCC[$medicinep['importantproduct']] = 0; 
      }
      $medicine['Others'] = 0;
      $MA['Others'] = 0;
      $MAA['Others'] = 0; 
      $MB['Others'] = 0; 
      $MBB['Others'] = 0; 
      $MC['Others'] = 0; 
      $MCC['Others'] = 0; 
      if ($user<>'物流') {
        $search = 'SalesRepresentativeName';
        $target[] = $user;
        $j = 0;
      }
      else
      {
        $income = [];
        $search = 'BORACustomerNo';
        $incomebigs = big::where('income','=','Y')->get();
        foreach ($incomebigs as $incomebig) 
        {
          $income[] = $incomebig['customercode'];
        }
        $target = $income;
        $j = count($income) - 1;
      }  
        $checkmedicinenumber = count($iteminfo);
        //每日銷售
        for ($i=0; $i <= $j ; $i++) { 
          $dailyreports = dailyreport::where($search,'=',$target[$i])->where('InvDate','=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            $checkmedicine = 0;
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno ) {
                if ($j==0) {
                  foreach ($outcounts as $outcount) {
                    if ($dailyreport['BORACustomerNo']==$outcount) {
                      $dailyreport['InoviceAmt'] = 0 ;
                    }
                  }
                }  
                $itemnames = importantp::where('itemno','=',$itemno)->first();
                $itemname = $itemnames->importantproduct;  
                $medicine[$itemname] = $medicine[$itemname] + $dailyreport['InoviceAmt'];
              }
              else 
              {
                $checkmedicine = $checkmedicine + 1;
              }
            }
            if ($checkmedicinenumber == $checkmedicine ) {
              if ($j==0) {
                foreach ($outcounts as $outcount) {
                  if ($dailyreport['BORACustomerNo']==$outcount) {
                    $dailyreport['InoviceAmt'] = 0 ;
                  }
                }
              }
            if (substr($dailyreport['BORAItemNo'],0,2)=='AA') 
            {
               $dailyreport['InoviceAmt'] = 0;
            }   
              $medicine['Others'] = $medicine['Others'] + $dailyreport['InoviceAmt'];
            } 
          }  
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$target[$i])->where('Date','=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$target[$i])->where('Date','=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$target[$i])->where('Date','=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
              $medicine['Mobic'] = $medicine['Mobic'] + $dailyreport['Amount'];
          }  
        }       
        //單月銷售累加
        for ($i=0; $i <= $j ; $i++) {
        $dailyreports = dailyreport::where($search,'=',$target[$i])->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          $checkmedicine = 0;
          foreach ($iteminfo as $itemno) {
            if ($dailyreport['BORAItemNo']==$itemno) {
              if ($j==0) {  
                foreach ($outcounts as $outcount) {
                  if ($dailyreport['BORACustomerNo']==$outcount) {
                    $dailyreport['InoviceAmt'] = 0 ;
                  }
                }
              }  
              $itemnames = importantp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MA[$itemname] = $MA[$itemname] + $dailyreport['InoviceAmt'];
            }
            else 
            {
              $checkmedicine = $checkmedicine + 1;
            }
          }
          if ($checkmedicinenumber == $checkmedicine ) {
            if ($j==0) {
              foreach ($outcounts as $outcount) {
                if ($dailyreport['BORACustomerNo']==$outcount) {
                  $dailyreport['InoviceAmt'] = 0 ;
                }
              }
            } 
            if (substr($dailyreport['BORAItemNo'],0,2)=='AA') 
            {
              $dailyreport['InoviceAmt'] = 0;
            } 
            $MA['Others'] = $MA['Others'] + $dailyreport['InoviceAmt'];
          }
        }
        $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$target[$i])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$target[$i])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$target[$i])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['SaleType']=='R2') {
            $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
          }
            $MA['Mobic'] = $MA['Mobic'] + $dailyreport['Amount'];
        }
        }
        //年初至當日 
        for ($i=0; $i <= $j ; $i++) { 
        $dailyreports = dailyreport::where($search,'=',$target[$i])->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          $checkmedicine = 0;
          foreach ($iteminfo as $itemno) {
            if ($dailyreport['BORAItemNo']==$itemno) {
              if ($j==0) {
                foreach ($outcounts as $outcount) {
                  if ($dailyreport['BORACustomerNo']==$outcount) {
                    $dailyreport['InoviceAmt'] = 0 ;
                  }
                }
              }
              $itemnames = importantp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MAA[$itemname] = $MAA[$itemname] + $dailyreport['InoviceAmt'];
            }
            else
            {
              $checkmedicine = $checkmedicine + 1;
            }
          }
          if ($checkmedicinenumber == $checkmedicine ) {
            if ($j==0) {
              foreach ($outcounts as $outcount) {
                if ($dailyreport['BORACustomerNo']==$outcount) {
                  $dailyreport['InoviceAmt'] = 0 ;
                }
              }
            }  
            if (substr($dailyreport['BORAItemNo'],0,2)=='AA') 
            {
              $dailyreport['InoviceAmt'] = 0;
            } 
            $MAA['Others'] = $MAA['Others'] + $dailyreport['InoviceAmt'];
          }
        }
        $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$target[$i])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$target[$i])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$target[$i])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreports as $dailyreport) {
          if ($dailyreport['SaleType']=='R2') {
            $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
          }
            $MAA['Mobic'] = $MAA['Mobic'] + $dailyreport['Amount'];
        }
        } 
        //撈每月目標業績
        if ($j==0) {
          $userbudget = $user;
        }
        else
        {
          $userbudget = '物流';
        }  
        $monthbudgets = medicinebudgetbypersonal::where('month','>=',$monthstart)->where('month','<=',$todaydate)->where('zone','=',$userbudget)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as $itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MB[$itemname] = $monthbudget['budget'];
            }
          }
          if ($monthbudget['BORAItemNo']=='others') {
            $MB['Others'] = $monthbudget['budget'];
          }    
        }
        $monthbudgets = medicinebudgetbypersonal::where('month','>=',$yearstart)->where('month','<=',$todaydate)->where('zone','=',$userbudget)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as$itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MBB[$itemname] = $MBB[$itemname] + $monthbudget['budget'];
            } 
          }
          if ($monthbudget['BORAItemNo']=='others') {
            $MBB['Others'] = $MBB['Others'] + $monthbudget['budget'];
          } 
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
        $totalsell = array_sum($medicine);
        $totalma   = array_sum($MA); 
        $totalmb   = array_sum($MB);
        $totalmc   = round(($totalma/$totalmb)* 100);
        $totalmaa  = array_sum($MAA);
        $totalmbb  = array_sum($MBB);
        $totalmcc  = round(($totalmaa/$totalmbb)* 100);
        $form  = null;
        $medicines = importantp::select('importantproduct')->distinct()->get();
        foreach ($medicines as $value) 
        { 
          $form  .= '<tr><td width="300px">'.$value['importantproduct'].'</td><td class="text-center">'.number_format($MA[$value['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$value['importantproduct']]).'</td><td class="text-center">'.$MC[$value['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$value['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$value['importantproduct']]).'</td><td class="text-center">'.$MCC[$value['importantproduct']].'%</td></tr>' ;      
        }  
        $form  .= '<tr><td>Others</td><td class="text-center">'.number_format($MA['Others']).'</td><td class="text-center">'.number_format($MB['Others']).'</td><td class="text-center">'.$MC['Others'].'%</td><td class="text-center">'.number_format($MAA['Others']).'</td><td class="text-center">'.number_format($MBB['Others']).'</td><td class="text-center">'.$MCC['Others'].'%</td></tr>' ;      
        $form  .= '<tr><td class="endcolor">TOTAL</td><td class="text-center endcolor">'.number_format($totalma).'</td><td class="text-center endcolor">'.number_format($totalmb).'</td><td class="text-center endcolor">'.$totalmc.'%</td><td class="text-center endcolor">'.number_format($totalmaa).'</td><td class="text-center endcolor">'.number_format($totalmbb).'</td><td class="text-center endcolor">'.$totalmcc.'%</td></tr>' ;              
        return view('personalmedicinediary',['form'=>$form,
                                             'MC'=>$MC,
                                             'user'=>$user,
                                             'chardate'=>$chardate,
                                             'today'=>$todaydate,
                                             'season'=>$season,
                                            ]);
    }

    public function itemscount()
    {
      $seasons = array('2014','2015','2016');
      $boraitems = boraitem::all();
      $allitems = array();
      foreach ($boraitems as $boraitem) {
        array_push($allitems, $boraitem['itemchname'].'|'.$boraitem['itemenname']) ;
      }
      $boraallaccount = boraallaccount::all();
      $allaccounts = array();
      foreach ($boraallaccount as $allaccount) {
        array_push($allaccounts, $allaccount['emponame']) ;
      }
      return view('itemscount',['allitems'=>$allitems,
                                'allaccounts'=>$allaccounts,
                                'seasons'=>$seasons,
        ]);
    }

    public function star()
    {
      $ordernumber = strstr(Request::path(),'/',true);
      $check1 = itticket::where('enumber','=',Auth::user()->name)->where('ordernumber','=',$ordernumber)->where('process','=','close')->count();
      $check2 = itservicerank::where('enumber','=',Auth::user()->name)->where('ordernumber','=',$ordernumber)->count();
      $infos = itticket::where('enumber','=',Auth::user()->name)->where('ordernumber','=',$ordernumber)->where('process','=','close')->get();
      foreach ($infos as $info) {
        $date = $info['date'];
        $items = $info['items'];
        $description = $info['description'];
        $response = $info['itresponse'];
      }
      //$check1=1 is itticket available and $check2=0 is itservicerank not available 
      if ($check1==1 and $check2==0 ) {
        return view('star',['date'=>$date,'items'=>$items,'description'=>$description,'response'=>$response,'ordernumber'=>$ordernumber]);
      }
      else
      {
        return redirect('dashboard');
      }  
    }
    public function accountreport()
    {
      $users = user::where('name','=',Auth::user()->name)->get();
      $username = null ;
      $usernumber = Auth::user()->name ;
      foreach ($users  as $user ) {
        $username = $user['cname'];    
      }
      $today = date('Y-m-d');

      $ticketnumber = salesmen::where('usernumber','=',$usernumber)->where('reportday','=',$today)->count();
      $tickets = salesmen::where('usernumber','=',$usernumber)->where('reportday','=',$today)->get();
      $reportarray = array();
      $ticketarray = array();

      foreach ($tickets as $ticket) {
        array_push($reportarray,$ticket['reportday'],$ticket['username'], $ticket['usernumber'], $ticket['workon'], $ticket['workoff'], $ticket['visit'], $ticket['where'],$ticket['division'],$ticket['consumer'],$ticket['who'],$ticket['title'],$ticket['medicine'],$ticket['category'],$ticket['talk'],$ticket['other']);
        array_push($ticketarray,$reportarray);
        $reportarray= [];
      }
      $ticketarray = json_encode($ticketarray);


        
      return view('accountreport',[ 'username'  =>$username,
                                    'usernumber'=>$usernumber,
                                    'ticketnumber'=>$ticketnumber,
                                    'ticketarray'=>$ticketarray
                                    ]);
    }
    public function accountreportdelay()
    {
      $users = user::where('name','=',Auth::user()->name)->get();
      $username = null ;
      $usernumber = Auth::user()->name ;
      foreach ($users  as $user ) {
        $username = $user['cname'];    
      }
      $today = date('Y-m-d');

      $ticketnumber = salesmen::where('usernumber','=',$usernumber)->where('reportday','=',$today)->count();
      $tickets = salesmen::where('usernumber','=',$usernumber)->where('reportday','=',$today)->get();
      $reportarray = array();
      $ticketarray = array();

      foreach ($tickets as $ticket) {
        array_push($reportarray,$ticket['reportday'],$ticket['username'], $ticket['usernumber'], $ticket['workon'], $ticket['workoff'], $ticket['visit'], $ticket['where'],$ticket['division'],$ticket['consumer'],$ticket['who'],$ticket['title'],$ticket['medicine'],$ticket['category'],$ticket['talk'],$ticket['other']);
        array_push($ticketarray,$reportarray);
        $reportarray= [];
      }
      $ticketarray = json_encode($ticketarray);


        
      return view('accountreportdelay',[ 'username'  =>$username,
                                    'usernumber'=>$usernumber,
                                    ]);
    }

  public function daycheck()
  {
    return view('daycheck');
  }

  public function accountmanager()
  {
    $usernumber = Auth::user()->name;
    $users = user::where('name','=',$usernumber)->get();
    foreach ($users as $user) {
      $level = $user['level'];
      $name = $user['cname'];
      $dep = $user['dep'];
    }
    if ($level=='' and $dep == '藥品事業部' and $name <> '鍾碧如' ) {
      $personalarr = [];
        array_push($personalarr,str_replace(" ", "",$name));
    }
    else
    {
      $personals = salesmen::distinct()->select('username')->get();
      $personalarr = ['所有業務人員'];
      foreach ($personals as $personal) {
        array_push($personalarr,str_replace(" ", "",$personal['username']));
      }
    }  
    return view('accountmanager',['personalarrs'=>$personalarr]);
  }  

  public function webmail()
  {
    return redirect('http://mail.bora-corp.com:8080/webmail-cgi/XwebMail?_task=login');
  }  

  public function borauni($todaydate)
  {
    include(app_path().'/Http/Controllers/ReferenceController.php');
    $alltargets = array();
    $alltargetnames = array();
    $targetps = importantboraunip::all();
    foreach ($targetps as $targetp) {
      $alltargets[] = $targetp['itemno'];
      $MA[$targetp['importantproduct']] = 0 ;
      $MAA[$targetp['importantproduct']] = 0 ;
      $MB[$targetp['importantproduct']] = 0; 
      $MBB[$targetp['importantproduct']] = 0;
      $MC[$targetp['importantproduct']] = 0 ;
      $MCC[$targetp['importantproduct']] = 0 ;
    }
    $MA['others'] = 0 ;
    $MAA['others'] = 0 ;
    $MB['others'] = 0; 
    $MBB['others'] = 0;
    $MC['others'] = 0 ;
    $MCC['others'] = 0 ;
    //程式起點利用資料庫撈取
    $products = dailyreport::where('Invdate','>=',$monthstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          if ($itemname=='Bpn' and $product['BORACustomerNo'] <> 'UCS05' ) {
            $product['InoviceAmt'] = 0;
          }
          $MA[$itemname] = $MA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 and substr($product['BORAItemNo'], 0,2)=='67' ) 
      { 
        $MA['others'] = $MA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MB[$itemname] = $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='borauni') {
        $MB['others']=$unimonthbudget['budget'];
      }        
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      $MC[$itemname] = round(($MA[$itemname] / $MB[$itemname]) * 100);
    }
    $MC['others'] = round(($MA['others'] / $MB['others']) * 100);
    $products = dailyreport::where('Invdate','>=',$yearstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          if ($itemname=='Bpn' and $product['BORACustomerNo'] <> 'UCS05' ) {
            $product['InoviceAmt'] = 0;
          }
          $MAA[$itemname] = $MAA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 and substr($product['BORAItemNo'], 0,2)=='67' ) 
      { 
        $MAA['others'] = $MAA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = boramonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MBB[$itemname] = $MBB[$itemname] + $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='borauni') {
        $MBB['others']= $MBB['others'] + $unimonthbudget['budget'];
      } 
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      $MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
    }
    $MCC['others'] = round(($MAA['others'] / $MBB['others']) * 100);
    $totalma   = array_sum($MA); 
    $totalmb   = array_sum($MB);
    $totalmc   = round(($totalma/$totalmb)* 100);
    $totalmaa  = array_sum($MAA);
    $totalmbb  = array_sum($MBB);
    $totalmcc  = round(($totalmaa/$totalmbb)* 100);
    $form = null;
    $finals = importantboraunip::select('importantproduct')->distinct()->get();
    foreach ($finals as $final) 
    { 
      $itemnames = importantboraunip::where('importantproduct','=',$final['importantproduct'])->first();
      $itemname = $itemnames->importantproductchname;
      $form  .= '<tr><td width="200px" class="text-center">'.$itemname.'</td><td class="text-center">'.number_format($MA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$final['importantproduct']]).'</td><td class="text-center">'.$MC[$final['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$final['importantproduct']]).'</td><td class="text-center">'.$MCC[$final['importantproduct']].'%</td></tr>' ;  
    }
    $form  .= '<tr><td class="text-center">Others</td><td class="text-center">'.number_format($MA['others']).'</td><td class="text-center">'.number_format($MB['others']).'</td><td class="text-center">'.$MC['others'].'%</td><td class="text-center">'.number_format($MAA['others']).'</td><td class="text-center">'.number_format($MBB['others']).'</td><td class="text-center">'.$MCC['others'].'%</td></tr>' ;  
    $form  .= '<tr><td class="text-center endcolor">TOTAL</td><td class="text-center endcolor">'.number_format($totalma).'</td><td class="text-center endcolor">'.number_format($totalmb).'</td><td class="text-center endcolor">'.$totalmc.'%</td><td class="text-center endcolor">'.number_format($totalmaa).'</td><td class="text-center endcolor">'.number_format($totalmbb).'</td><td class="text-center endcolor">'.$totalmcc.'%</td></tr>' ; 
    return view('borauni',['form'=>$form,
                           'todaydate'=>$todaydate,
                           'MC'=>$MC,
                           'season'=>$season
                          ]);
  }

  public function uniuni($todaydate)
  {
    include(app_path().'/Http/Controllers/ReferenceController.php');
    $alltargets = array();
    $alltargetnames = array();
    $targetps = importantuniunip::all();
    foreach ($targetps as $targetp) {
      $alltargets[] = $targetp['itemno'];
      $MA[$targetp['importantproduct']] = 0 ;
      $MAA[$targetp['importantproduct']] = 0 ;
      $MB[$targetp['importantproduct']] = 0; 
      $MBB[$targetp['importantproduct']] = 0;
      $MC[$targetp['importantproduct']] = 0 ;
      $MCC[$targetp['importantproduct']] = 0 ;
    }
    $MA['others'] = 0 ;
    $MAA['others'] = 0 ;
    $MB['others'] = 0; 
    $MBB['others'] = 0;
    $MC['others'] = 0 ;
    $MCC['others'] = 0 ;
    //程式起點利用資料庫撈取
    $products = unidiaryreport::where('Invdate','>=',$monthstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          $MA[$itemname] = $MA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0) 
      { 
        $MA['others'] = $MA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = unimonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MB[$itemname] = $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='others') {
        $MB['others']=$unimonthbudget['budget'];
      }        
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      if ($MB[$itemname]==0) {
        $MC[$itemname]=0;
      }
      else
      {
        $MC[$itemname] = round(($MA[$itemname] / $MB[$itemname]) * 100);
      }
    }
    if ($MB['others']==0) {
      $MC['others']=0;
    }
    else
    {
      $MC['others'] = round(($MA['others'] / $MB['others']) * 100);
    }  
    $products = unidiaryreport::where('Invdate','>=',$yearstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {

          $MAA[$itemname] = $MAA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 ) 
      { 
        $MAA['others'] = $MAA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = unimonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MBB[$itemname] = $MBB[$itemname] + $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='others') {
        $MBB['others']= $MBB['others'] + $unimonthbudget['budget'];
      } 
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      //$MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
      if ($MBB[$itemname]==0) {
        $MCC[$itemname]=0;
      }
      else
      {
        $MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
      }
    }
    if ($MBB['others']==0) {
      $MCC['others']=0;
    }
    else
    {
      $MCC['others'] = round(($MAA['others'] / $MBB['others']) * 100);
    } 
    $totalma   = array_sum($MA); 
    $totalmb   = array_sum($MB);
    $totalmc   = round(($totalma/$totalmb)* 100);
    $totalmaa  = array_sum($MAA);
    $totalmbb  = array_sum($MBB);
    $totalmcc  = round(($totalmaa/$totalmbb)* 100);
    $form = null;
    $finals = importantuniunip::select('importantproduct')->distinct()->get();
    foreach ($finals as $final) 
    { 
      $itemnames = importantuniunip::where('importantproduct','=',$final['importantproduct'])->first();
      $itemname = $itemnames->importantproductchname;
      $form  .= '<tr><td width="205px" class="text-center">'.$itemname.'</td><td class="text-center">'.number_format($MA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$final['importantproduct']]).'</td><td class="text-center">'.$MC[$final['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$final['importantproduct']]).'</td><td class="text-center">'.$MCC[$final['importantproduct']].'%</td></tr>' ;  
    }
    $form  .= '<tr><td class="text-center">Others</td><td class="text-center">'.number_format($MA['others']).'</td><td class="text-center">'.number_format($MB['others']).'</td><td class="text-center">'.$MC['others'].'%</td><td class="text-center">'.number_format($MAA['others']).'</td><td class="text-center">'.number_format($MBB['others']).'</td><td class="text-center">'.$MCC['others'].'%</td></tr>' ;  
    $form  .= '<tr><td class="text-center endcolor">TOTAL</td><td class="text-center endcolor">'.number_format($totalma).'</td><td class="text-center endcolor">'.number_format($totalmb).'</td><td class="text-center endcolor">'.$totalmc.'%</td><td class="text-center endcolor">'.number_format($totalmaa).'</td><td class="text-center endcolor">'.number_format($totalmbb).'</td><td class="text-center endcolor">'.$totalmcc.'%</td></tr>' ; 
    return view('uniuni',['form'=>$form,
                           'todaydate'=>$todaydate,
                           'MC'=>$MC,
                           'season'=>$season
                          ]);
  }
  public function acbudget()
  {
    $thisyear = date("Y");
    $thismonth = date("m");
    $thismonday = date("t");
    $weekday = date("D");
    $monthstart = $thisyear.'-'.$thismonth.'-01';
    $monthend = $thisyear.'-'.$thismonth.'-'.$thismonday;
    $lastyeart = date("Y-m-d", strtotime('-1 month'));
    $lastyear = date("Y", strtotime($lastyeart));
    $lastmonth = date("m", strtotime($lastyeart));
    $lastmonday = date("t", strtotime($lastyeart));
    $lastmonthstart = $lastyear.'-'.$lastmonth.'-01';
    $lastmonthend = $lastyear.'-'.$lastmonth.'-'.$lastmonday; 
    $qty = 0;
    $i = 1;
    $j = 1;
    $weekarrs = [];
    $lastweekarrs = [];
    $thisqtyinfo = [];
    $lastqtyinfo = [];
    $countweeks = calendar::where('monthdate','>=',$lastmonthstart)->where('monthdate','<=',$lastmonthend)->orderBy('monthdate','asc')->get();
    foreach ($countweeks as $countweek ) {
      $lastqtys = dailyreport::where('InvDate','=',$countweek['monthdate'])->where('SalesRepresentativeName','=','江隆昌')->where('BORAItemNo','=','68LMP002')->where('BORACustomerNo','=','10191')->get(); 
      foreach ($lastqtys as $lastqty) {
        if ($lastqty['SalesType']=='R2') {
          $lastqty['OrderQty'] = 0 - $lastqty['OrderQty'];
        }
        $qty = $qty + $lastqty['OrderQty'];
      }
      if ($countweek['weekday']<>'星期日' and count($lastweekarrs)==0 and count($lastqtyinfo)==0 ) {
        array_push($lastweekarrs, '1');
        array_push($lastqtyinfo, $qty);
        $qty = 0;
      }
      if ($countweek['weekday']=='星期日') {
        $i = $i + 1 ;
        array_push($lastweekarrs, $i);
        array_push($lastqtyinfo, $qty);
        $qty = 0;
      }
    }
    $lastsum = array_sum($lastqtyinfo);
    $qty = 0;
    $countweeks = calendar::where('monthdate','>=',$monthstart)->where('monthdate','<=',$monthend)->orderBy('monthdate','asc')->get();
    foreach ($countweeks as $countweek ) {
      $thisqtys = dailyreport::where('InvDate','=',$countweek['monthdate'])->where('SalesRepresentativeName','=','江隆昌')->where('BORAItemNo','=','68LMP002')->where('BORACustomerNo','=','10191')->get(); 
      foreach ($thisqtys as $thisqty) {
        if ($thisqty['SalesType']=='R2') {
          $thisqty['OrderQty'] = 0 - $thisqty['OrderQty'];
        }
        $qty = $qty + $thisqty['OrderQty'];
      }
      if ($countweek['weekday']<>'星期日' and count($weekarrs) == 0 and count($thisqtyinfo) == 0 ) {
        array_push($weekarrs, '1');
        array_push($thisqtyinfo, $qty);
        $qty = 0;
      }
      if ($countweek['weekday']=='星期日') {
        $j = $j + 1 ;
        array_push($weekarrs, $j);
        array_push($thisqtyinfo, $qty);
        $qty = 0;
      }
    }
    return view('acbudget',['thismonth'=>$thismonth,
                            'lastmonth'=>$lastmonth,
                            'lastweekarrs'=>$lastweekarrs,
                            'weekarrs'=>$weekarrs,
                            'lastqtyinfos'=>$lastqtyinfo,
                            'thisqtyinfos'=>$thisqtyinfo,
                            'i'=>$i,
                            'j'=>$j
                          ]);
  }
  public function agents($todaydate)
  {
        include(app_path().'/Http/Controllers/ReferenceController.php');
        $total = 0; 
        $iteminfo = array();
        $outs = bigsangent::all();//提取所有要的廠商
        foreach ($outs as $out) 
        {
          $outcounts[] = $out['customercode'];
        }
        $medicines = importantagentsp::all();
        foreach ($medicines as $medicinep) 
        {
          $iteminfo[] = $medicinep['itemno'];
          $outs = bigsangent::all();
          foreach ($outs as $out) 
          {          
            $MAtarget[$medicinep['itemno']][$out['customercode']]=0;
            $MAAtarget[$medicinep['itemno']][$out['customercode']]=0;  
          }  
          $MB[$medicinep['importantproduct']] = 0; 
          $MBB[$medicinep['importantproduct']] = 0; 
          $MC[$medicinep['importantproduct']] = 0; 
          $MCC[$medicinep['importantproduct']] = 0; 
        } 
        //$checkmedicinenumber = count($iteminfo);
        foreach ($outcounts as $outcount) {
          $dailyreports = dailyreport::where('BORACustomerNo','=',$outcount)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAtarget[$itemno][$outcount] = $MAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
          $dailyreports = unidiaryreport::where('BORACustomerno','=',$outcount)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAtarget[$itemno][$outcount] = $MAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
        //}
        //年初至當日
        //foreach ($outcounts as $outcount) { 
          $dailyreports = dailyreport::where('BORACustomerNo','=',$outcount)->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAAtarget[$itemno][$outcount] = $MAAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }
            }
          }

          $dailyreports = unidiaryreport::where('BORACustomerno','=',$outcount)->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAAtarget[$itemno][$outcount] = $MAAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
        }
        //撈每月目標業績
        $monthbudgets = agentsmonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as $itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantagentsp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MB[$itemname] = $monthbudget['budget'];
            }
          }  
        }

        $monthbudgets = agentsmonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as$itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantagentsp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MBB[$itemname] = $MBB[$itemname] + $monthbudget['budget'];
            } 
          }
        }
        $totalma = 0;
        $totalmb = 0;
        $totalmaa = 0;
        $totalmbb = 0;
        $totalmc = 0;
        $totalmcc = 0;
        $form = null;
        $medicines = importantagentsp::select('itemno')->distinct()->get();
        foreach ($medicines as $medicine) 
        { 
          $itemnames = importantagentsp::where('itemno','=',$medicine['itemno'])->first();
          $itemname = $itemnames->importantproduct;
          $form  .= '<tr><td class="subcolor">'.$itemname.'</td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td></tr>';
          foreach ($MAtarget[$medicine['itemno']] as $subkey => $submedicine) {
            if ($submedicine<>0) {
              $comnames = bigsangent::where('customercode','=',$subkey)->first();
              $comname = $comnames->customerchname;
              $form  .= '<tr><td>&nbsp;&nbsp;&nbsp;'.$comname.'</td><td class="text-right">'.$submedicine.'</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td></tr>' ; 
            }
          }
          $MC[$itemname] = round((array_sum($MAtarget[$medicine['itemno']]) / $MB[$itemname]) * 100 );
          $MCC[$itemname] = round((array_sum($MAAtarget[$medicine['itemno']]) / $MBB[$itemname]) * 100 );
          $form  .= '<tr><td class="text-left">&nbsp;&nbsp;&nbsp;<i>Sub-TTL</i></td><td class="text-right">'.array_sum($MAtarget[$medicine['itemno']]) .'</td><td class="text-right">'.$MB[$itemname] .'</td><td class="text-right">'.$MC[$itemname].'%</td><td class="text-right">'.array_sum($MAAtarget[$medicine['itemno']]).'</td><td class="text-right">'.$MBB[$itemname].'</td><td class="text-right">'.$MCC[$itemname].'%</td></tr>';   
          $totalma = $totalma + array_sum($MAtarget[$medicine['itemno']]);
          $totalmaa = $totalmaa + array_sum($MAAtarget[$medicine['itemno']]);
        }  
          $totalmb =  array_sum($MB);
          $totalmbb =  array_sum($MBB);
          $totalmc = round(($totalma / $totalmb) * 100 );
          $totalmcc = round(($totalmaa / $totalmbb) * 100 );
          $form  .= '<tr><td class="endcolor">TOTAL</td><td class="text-right endcolor">'.number_format($totalma).'</td><td class="text-right endcolor">'.number_format($totalmb).'</td><td class="text-right endcolor">'.$totalmc.'%</td><td class="text-right endcolor">'.number_format($totalmaa).'</td><td class="text-right endcolor">'.number_format($totalmbb).'</td><td class="text-right endcolor">'.$totalmcc.'%</td></tr>' ;         
        return view('agents',['form'=>$form,
                                'MC'=>$MC,
                                'todaydate'=>$todaydate,
                                'chardate'=>$chardate,
                                'season'=>$season,
                              ]);
  }
  public function allborauni($todaydate)
  {
    include(app_path().'/Http/Controllers/ReferenceController.php');
    $alltargets = array();
    $alltargetnames = array();
    $FMC =  array();
    $targetps = importantboraunip::all();
    foreach ($targetps as $targetp) {
      $alltargets[] = $targetp['itemno'];
      $MA[$targetp['importantproduct']] = 0 ;
      $MAA[$targetp['importantproduct']] = 0 ;
      $MB[$targetp['importantproduct']] = 0; 
      $MBB[$targetp['importantproduct']] = 0;
      $MC[$targetp['importantproduct']] = 0 ;
      $MCC[$targetp['importantproduct']] = 0 ;
      $formtemp[$targetp['importantproduct']] = null;
    }
    $formtemp['others'] = null;
    $MA['others'] = 0 ;
    $MAA['others'] = 0 ;
    $MB['others'] = 0; 
    $MBB['others'] = 0;
    $MC['others'] = 0 ;
    $MCC['others'] = 0 ;
    //程式起點利用資料庫撈取
    $products = dailyreport::where('Invdate','>=',$monthstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          if ($itemname=='Bpn' and $product['BORACustomerNo'] <> 'UCS05' ) {
            $product['InoviceAmt'] = 0;
          }
          $MA[$itemname] = $MA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 and substr($product['BORAItemNo'], 0,2)=='67' ) 
      { 
        $MA['others'] = $MA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MB[$itemname] = $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='borauni') {
        $MB['others']=$unimonthbudget['budget'];
      }        
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      $MC[$itemname] = round(($MA[$itemname] / $MB[$itemname]) * 100);
    }
    $MC['others'] = round(($MA['others'] / $MB['others']) * 100);
    $products = dailyreport::where('Invdate','>=',$yearstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          if ($itemname=='Bpn' and $product['BORACustomerNo'] <> 'UCS05' ) {
            $product['InoviceAmt'] = 0;
          }
          $MAA[$itemname] = $MAA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 and substr($product['BORAItemNo'], 0,2)=='67' ) 
      { 
        $MAA['others'] = $MAA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = boramonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MBB[$itemname] = $MBB[$itemname] + $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='borauni') {
        $MBB['others']= $MBB['others'] + $unimonthbudget['budget'];
      } 
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantboraunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      $MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
    }
    $MCC['others'] = round(($MAA['others'] / $MBB['others']) * 100);
    $totalborama   = array_sum($MA); 
    $totalboramb   = array_sum($MB);
    $totalboramc   = round(($totalborama/$totalboramb)* 100);
    $totalboramaa  = array_sum($MAA);
    $totalborambb  = array_sum($MBB);
    $totalboramcc  = round(($totalboramaa/$totalborambb)* 100);
    $finals = importantboraunip::select('importantproduct')->distinct()->get();
    foreach ($finals as $final) 
    { 
      $itemnames = importantboraunip::where('importantproduct','=',$final['importantproduct'])->first();
      $itemname = $itemnames->importantproductchname;
      $formtemp[$final['importantproduct']]  = '<tr><td width="205px" class="text-center">'.$itemname.'-保瑞</td><td class="text-center">'.number_format($MA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$final['importantproduct']]).'</td><td class="text-center">'.$MC[$final['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$final['importantproduct']]).'</td><td class="text-center">'.$MCC[$final['importantproduct']].'%</td></tr>' ;  
    }
    $formtemp['others']  = '<tr><td class="text-center">Others-保瑞</td><td class="text-center">'.number_format($MA['others']).'</td><td class="text-center">'.number_format($MB['others']).'</td><td class="text-center">'.$MC['others'].'%</td><td class="text-center">'.number_format($MAA['others']).'</td><td class="text-center">'.number_format($MBB['others']).'</td><td class="text-center">'.$MCC['others'].'%</td></tr>' ;  
    foreach ($MC as $key => $value) {
      $FMC[] = $value ; 
    }
    /////////////////////////
    include(app_path().'/Http/Controllers/ReferenceController.php');
    $alltargets = array();
    $alltargetnames = array();

    $MA = array(); 
    $MAA = array() ;
    $MB = array(); 
    $MBB = array();
    $MC = array() ;
    $MCC = array() ;
    $targetps = importantuniunip::all();
    foreach ($targetps as $targetp) {
      $alltargets[] = $targetp['itemno'];
      $MA[$targetp['importantproduct']] = 0 ;
      $MAA[$targetp['importantproduct']] = 0 ;
      $MB[$targetp['importantproduct']] = 0; 
      $MBB[$targetp['importantproduct']] = 0;
      $MC[$targetp['importantproduct']] = 0 ;
      $MCC[$targetp['importantproduct']] = 0 ;
    }
    $MA['others'] = 0 ;
    $MAA['others'] = 0 ;
    $MB['others'] = 0; 
    $MBB['others'] = 0;
    $MC['others'] = 0 ;
    $MCC['others'] = 0 ;
    //程式起點利用資料庫撈取
    $products = unidiaryreport::where('Invdate','>=',$monthstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {
          $MA[$itemname] = $MA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0) 
      { 
        $MA['others'] = $MA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = unimonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MB[$itemname] = $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='others') {
        $MB['others']=$unimonthbudget['budget'];
      }        
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      if ($MB[$itemname]==0) {
        $MC[$itemname]=0;
      }
      else
      {
        $MC[$itemname] = round(($MA[$itemname] / $MB[$itemname]) * 100);
      }
    }
    if ($MB['others']==0) {
      $MC['others']=0;
    }
    else
    {
      $MC['others'] = round(($MA['others'] / $MB['others']) * 100);
    }  
    $products = unidiaryreport::where('Invdate','>=',$yearstart)->where('Invdate','<=',$todaydate)->get();
    foreach ($products as $product) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($product['BORAItemNo']==$alltarget) 
        {

          $MAA[$itemname] = $MAA[$itemname] + $product['InoviceAmt'];
        } 
        else
        {
          $check = 0;
          foreach ($alltargets as $alltargetother) {
            if ($product['BORAItemNo']==$alltargetother) {
              $check = 1;
            }
          }      
        }  
      }
      if ($check == 0 ) 
      { 
        $MAA['others'] = $MAA['others'] + $product['InoviceAmt'];
      }
    }
    $unimonthbudgets = unimonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
    foreach ($unimonthbudgets as $unimonthbudget) {
      foreach ($alltargets as $alltarget) {
        $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
        $itemname = $itemnames->importantproduct;
        if ($unimonthbudget['BORAItemNo']==$alltarget) 
        {
          $MBB[$itemname] = $MBB[$itemname] + $unimonthbudget['budget'];
        } 
      } 
      if ($unimonthbudget['BORAItemNo']=='others') {
        $MBB['others']= $MBB['others'] + $unimonthbudget['budget'];
      } 
    }
    foreach ($alltargets as $alltarget) {
      $itemnames = importantuniunip::where('itemno','=',$alltarget)->first();
      $itemname = $itemnames->importantproduct;
      //$MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
      if ($MBB[$itemname]==0) {
        $MCC[$itemname]=0;
      }
      else
      {
        $MCC[$itemname] = round(($MAA[$itemname] / $MBB[$itemname]) * 100);
      }
    }
    $MCC['others'] = round(($MAA['others'] / $MBB['others']) * 100);
    $totalma   = array_sum($MA); 
    $totalmb   = array_sum($MB);
    $totalmc   = round(($totalma/$totalmb)* 100);
    $totalmaa  = array_sum($MAA);
    $totalmbb  = array_sum($MBB);
    $totalmcc  = round(($totalmaa/$totalmbb)* 100);
    $checkarray = 1 ;
    $finals = importantuniunip::select('importantproduct')->distinct()->get();
    foreach ($finals as $final) 
    { 
      $itemnames = importantuniunip::where('importantproduct','=',$final['importantproduct'])->first();
      $itemname = $itemnames->importantproductchname;
      if (array_key_exists($final['importantproduct'], $formtemp)) {
        $form  .= $formtemp[$final['importantproduct']].'<tr><td class="text-center">'.$itemname.'-聯邦</td><td class="text-center">'.number_format($MA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$final['importantproduct']]).'</td><td class="text-center">'.$MC[$final['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$final['importantproduct']]).'</td><td class="text-center">'.$MCC[$final['importantproduct']].'%</td></tr>' ;
      }
      else
      { 
        if ($checkarray==1) {
          $form  .= $formtemp['Bpn'];
          $checkarray = 0 ;
        } 
        $form  .= '<tr><td class="text-center">'.$itemname.'-聯邦</td><td class="text-center">'.number_format($MA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MB[$final['importantproduct']]).'</td><td class="text-center">'.$MC[$final['importantproduct']].'%</td><td class="text-center">'.number_format($MAA[$final['importantproduct']]).'</td><td class="text-center">'.number_format($MBB[$final['importantproduct']]).'</td><td class="text-center">'.$MCC[$final['importantproduct']].'%</td></tr>' ;          
      }  
    }   
    $form .= $formtemp['others'];
    $form .= '<tr><td class="text-center">Others-聯邦</td><td class="text-center">'.number_format($MA['others']).'</td><td class="text-center">'.number_format($MB['others']).'</td><td class="text-center">'.$MC['others'].'%</td><td class="text-center">'.number_format($MAA['others']).'</td><td class="text-center">'.number_format($MBB['others']).'</td><td class="text-center">'.$MCC['others'].'%</td></tr>'; 
    $totalma = $totalborama + $totalma ;
    $totalmb = $totalboramb + $totalmb;
    $totalmc = round(($totalma/$totalmb)* 100);
    $totalmaa = $totalboramaa + $totalmaa;
    $totalmbb = $totalborambb + $totalmbb;
    $totalmcc = round(($totalmaa/$totalmbb)* 100);
    $form  .= '<tr><td class="text-center endcolor">TOTAL</td><td class="text-center endcolor">'.number_format($totalma).'</td><td class="text-center endcolor">'.number_format($totalmb).'</td><td class="text-center endcolor">'.$totalmc.'%</td><td class="text-center endcolor">'.number_format($totalmaa).'</td><td class="text-center endcolor">'.number_format($totalmbb).'</td><td class="text-center endcolor">'.$totalmcc.'%</td></tr>' ; 
    foreach ($MC as $key => $value) {
      $FMC[] = $value ; 
    }
    //////////////////////////////////////////////////////////////////////////////
    return view('allborauni',['form'=>$form,
                           'todaydate'=>$todaydate,
                           'FMC'=>$FMC,
                           'season'=>$season
                          ]);
  }
  public function imborauni($todaydate)
  {
        include(app_path().'/Http/Controllers/ReferenceController.php');
        $iteminfo = array();
        $outs = bigsangent::all();//提取所有要的廠商
        foreach ($outs as $out) 
        {
          $outcounts[] = $out['customercode'];
        }
        $medicines = importantagentsp::all();
        foreach ($medicines as $medicinep) 
        {
          $iteminfo[] = $medicinep['itemno'];
          $outs = bigsangent::all();
          foreach ($outs as $out) 
          {          
            $MAtarget[$medicinep['itemno']][$out['customercode']]=0;
            $MAAtarget[$medicinep['itemno']][$out['customercode']]=0;  
          }  
          $MB[$medicinep['importantproduct']] = 0; 
          $MBB[$medicinep['importantproduct']] = 0; 
          $MC[$medicinep['importantproduct']] = 0; 
          $MCC[$medicinep['importantproduct']] = 0; 
        } 
        //這一大段只是為了跑出pitavol起點
        //月初至當日
        foreach ($outcounts as $outcount) {
          $dailyreports = dailyreport::where('BORACustomerNo','=',$outcount)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAtarget[$itemno][$outcount] = $MAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
          $dailyreports = unidiaryreport::where('BORACustomerno','=',$outcount)->where('InvDate','>=',$monthstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAtarget[$itemno][$outcount] = $MAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
        //年初至當日
          $dailyreports = dailyreport::where('BORACustomerNo','=',$outcount)->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAAtarget[$itemno][$outcount] = $MAAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }
            }
          }
          $dailyreports = unidiaryreport::where('BORACustomerno','=',$outcount)->where('InvDate','>=',$yearstart)->where('InvDate','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            foreach ($iteminfo as $itemno) {
              if ($dailyreport['BORAItemNo']==$itemno) { 
                $MAAtarget[$itemno][$outcount] = $MAAtarget[$itemno][$outcount] + $dailyreport['InoviceAmt'];
              }              
            } 
          }
        }
        //撈每月目標業績
        $monthbudgets = agentsmonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as $itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantagentsp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MB[$itemname] = $monthbudget['budget'];
            }
          }  
        }
        //撈年初至當月每月目標業績
        $monthbudgets = agentsmonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
        foreach ($monthbudgets as $monthbudget) {
          foreach ($iteminfo as$itemno) {
            if ($monthbudget['BORAItemNo']==$itemno) {
              $itemnames = importantagentsp::where('itemno','=',$itemno)->first();
              $itemname = $itemnames->importantproduct;
              $MBB[$itemname] = $MBB[$itemname] + $monthbudget['budget'];
            } 
          }
        }
        $medicines = importantagentsp::select('itemno')->distinct()->get();
        foreach ($medicines as $medicine) 
        { 
          if ($medicine['itemno']=='57PTV001') {        
            $itemnames = importantagentsp::where('itemno','=',$medicine['itemno'])->first();
            $itemname = $itemnames->importantproduct;
            $form  .= '<tr><td class="subcolor">'.$itemname.'</td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td></tr>';
            foreach ($MAtarget[$medicine['itemno']] as $subkey => $submedicine) {
              if ($submedicine<>0) {
                $comnames = bigsangent::where('customercode','=',$subkey)->first();
                $comname = $comnames->customerchname;
                $form  .= '<tr><td>&nbsp;&nbsp;&nbsp;'.$comname.'</td><td class="text-right">'.number_format($submedicine).'</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td><td class="text-right">-</td></tr>' ; 
              }
            }
            $MC[$itemname] = round((array_sum($MAtarget[$medicine['itemno']]) / $MB[$itemname]) * 100 );
            $MCC[$itemname] = round((array_sum($MAAtarget[$medicine['itemno']]) / $MBB[$itemname]) * 100 );
            $form  .= '<tr><td class="text-left">&nbsp;&nbsp;&nbsp;<i>Sub-TTL</i></td><td class="text-right">'.number_format(array_sum($MAtarget[$medicine['itemno']])) .'</td><td class="text-right">'.number_format($MB[$itemname]) .'</td><td class="text-right">'.$MC[$itemname].'%</td><td class="text-right">'.number_format(array_sum($MAAtarget[$medicine['itemno']])).'</td><td class="text-right">'.number_format($MBB[$itemname]).'</td><td class="text-right">'.$MCC[$itemname].'%</td></tr>';
            $totalMA = array_sum($MAtarget[$medicine['itemno']]);
            $totalMB = $MB[$itemname];
            $totalMAA = $totalMAA + array_sum($MAAtarget[$medicine['itemno']]);
            $totalMBB = $totalMBB + $MBB[$itemname];
            $char1 = $MC[$itemname];
          }
        }  
        //這一大段只是為了跑出pitavol終點
        //這一大段只是為了跑出mobic起點
        $form  .= '<tr><td class="subcolor">Mobic</td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td></tr>';
        $i = 0;
        $MA = 0;
        $MAA = 0;
        $MMA = 0;
        $MMAA = 0;
        $MMB = 0;
        $MMBB = 0;
        $outs = big::where('income','=','SP')->get();
        foreach ($outs as $out) 
        {
          //計算當日業績醫院組金容平廷只會出現在裕利表單所以這邊給中文沒差
          //計算由月初累計至當日業績
          //計算當月業績醫院組金容平廷只會出現在裕利表單所以這邊給中文
          $MA = 0;
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$out['customercode'])->where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
              $MA = $MA + $dailyreport['Amount'];
          } 
          //提取每月目標
          $monthbudgets = personalmonthbudget::where('zone','=',$out['customercode'])->where('month','>=',$monthstart)->where('month','<=',$todaydate)->get();
          foreach ($monthbudgets as $monthbudget) {
            $MB = $monthbudget['budget'];
          } 
          //結至當日達成率
          $MC[$i] = round(($MA/$MB) * 100) ;
          //計算年累計由年初至當日
          $MAA = 0;
          $dailyreports = mobicmappingdata::where('ItemNo','=','A0076')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0210')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->orwhere('ItemNo','=','A0211')->where('salename','=',$out['customercode'])->where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
          foreach ($dailyreports as $dailyreport) {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
              $MAA = $MAA + $dailyreport['Amount'];
          } 
          //計算年累計目標由年初至當月因為$out['customercode']為編號因無物流代號故使用中文
          $monthbudgets = personalmonthbudget::where('zone','=',$out['customercode'])->where('month','>=',$yearstart)->where('month','<=',$todaydate)->get();
          $MBB = 0 ;
          foreach ($monthbudgets as $monthbudget) {
            $MBB = $MBB +  $monthbudget['budget'];
          }
          // MCC  A/B
          if ($MBB<>0) {
            $MCC[$i] = round(($MAA/$MBB) * 100) ;
          }
          $MMA = $MMA + $MA ;
          $MMAA = $MMAA + $MAA;
          $MMB = $MMB + $MB ;
          $MMBB = $MMBB + $MBB;
          $form .= '<tr ><td>&nbsp;&nbsp;&nbsp;'.$out['customercode'].'</td>';
          $form .= '<td class="text-right">'.number_format($MA).'</td>';
          $form .= '<td class="text-right">'.number_format($MB).'</td><td class="text-right">'.$MC[$i].'%</td>';
          $form .= '<td class="text-right">'.number_format($MAA).'</td>';
          $form .= '<td class="text-right">'.number_format($MBB).'</td><td class="text-right">'.$MCC[$i].'%</td>';   
          $i= $i+1;
        }  
        $MMC = round(($MMA/$MMB) * 100) ;
        $MMCC = round(($MMAA/$MMBB) * 100) ;
        $form  .= '<tr><td class="text-left">&nbsp;&nbsp;&nbsp;<i>Sub-TTL</i></td><td class="text-right">'.number_format($MMA) .'</td><td class="text-right">'.number_format($MMB) .'</td><td class="text-right">'.$MMC.'%</td><td class="text-right">'.number_format($MMAA).'</td><td class="text-right">'.number_format($MMBB) .'</td><td class="text-right">'.$MMCC.'%</td></tr>';
        $totalMA = $totalMA +  $MMA;
        $totalMB = $totalMB + $MMB;
        $totalMAA = $totalMAA +  $MMAA;
        $totalMBB = $totalMBB + $MMBB;
        $char2 = $MMC;
        //這一大段只是為了跑出mobic終點  
        $form  .= '<tr><td class="subcolor">Lendormin</td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td><td class="subcolor"></td></tr>';     
        $i = 0;
        $MA = 0;
        $MAA = 0;
        $MMA = 0;
        $MMAA = 0;
        $MMB = 0;
        $MMBB = 0;
        //這一大段只是為了跑出lendormin起點 
        //和安戀多眠 
        $dailyreportstable = hareport::where('INVDT','>=',$monthstart)->where('INVDT','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          if ($dailyreport['HAITMNO']=='LEN25100') {
            $MA = $MA + $dailyreport['INVAM'] - $dailyreport['CDAMT'];
          }
        }  
        $dailyreportstable = hareport::where('INVDT','>=',$yearstart)->where('INVDT','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          if ($dailyreport['HAITMNO']=='LEN25100') {
            $MAA = $MAA + $dailyreport['INVAM'] - $dailyreport['CDAMT'];
          }
        }
        $MMA = $MMA + $MA ;
        $MMAA = $MMAA + $MAA;   
        $form .= '<tr ><td>&nbsp;&nbsp;&nbsp;和安</td>';
        $form .= '<td class="text-right">'.number_format($MA).'</td>';
        $form .= '<td class="text-right">-</td><td class="text-right">-</td>';
        $form .= '<td class="text-right">'.number_format($MAA).'</td>';
        $form .= '<td class="text-right">-</td><td class="text-right">-</td>';   
        $MA = 0;
        $MAA = 0;
        //裕利戀多眠
        $dailyreportstable = boehringer::where('Date','>=',$monthstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          if ($dailyreport['ItemNo']=='A0195') {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
            $MA = $MA + $dailyreport['Amount'] - $dailyreport['CDAMT'];
          }
        }  
        $dailyreportstable = boehringer::where('Date','>=',$yearstart)->where('Date','<=',$todaydate)->get();
        foreach ($dailyreportstable as $dailyreport) {
          if ($dailyreport['ItemNo']=='A0195') {
            if ($dailyreport['SaleType']=='R2') {
              $dailyreport['Amount'] = 0 - $dailyreport['Amount'];
            }
            $MAA = $MAA + $dailyreport['Amount'] - $dailyreport['CDAMT'];
          }
        }  
        $MMA = $MMA + $MA ;
        $MMAA = $MMAA + $MAA; 
        $form .= '<tr ><td>&nbsp;&nbsp;&nbsp;裕利</td>';
        $form .= '<td class="text-right">'.number_format($MA).'</td>';
        $form .= '<td class="text-right">-</td><td class="text-right">-</td>';
        $form .= '<td class="text-right">'.number_format($MAA).'</td>';
        $form .= '<td class="text-right">-</td><td class="text-right">-</td>';   
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$todaydate)->where('BORAItemNo','=','68PTV001123')->get();
        foreach ($monthbudgets  as $monthbudget) {
          $MB = $monthbudget['budget'];
        }
        $MBB = 0;
        $monthbudgets = boramonthbudget::where('month','>=',$yearstart)->where('month','<=',$todaydate)->where('BORAItemNo','=','68PTV001123')->get();
        foreach ($monthbudgets  as $monthbudget) {
          $MBB = $MBB + $monthbudget['budget'];
        }
        $MC = round(($MMA/$MB)* 100);
        $MCC = round(($MMAA/$MBB)* 100);
        $form .= '<tr><td class="text-left">&nbsp;&nbsp;&nbsp;<i>Sub-TTL</i></td><td class="text-right">'.number_format($MMA) .'</td><td class="text-right">'.number_format($MB) .'</td><td class="text-right">'.$MC.'%</td><td class="text-right">'.number_format($MMAA).'</td><td class="text-right">'.number_format($MBB) .'</td><td class="text-right">'.$MCC.'%</td></tr>';   
        $char3 = $MC;
        //這一大段只是為了跑出lendormin終點 
        $totalMA = $totalMA + $MMA;
        $totalMB = $totalMB + $MB;
        $totalMAA = $totalMAA + $MMAA;
        $totalMBB = $totalMBB + $MBB;
        $totalMC = round(($totalMA/$totalMB)* 100);
        $totalMCC = round(($totalMAA/$totalMBB)* 100);
        $form  .= '<tr><td class="endcolor">TOTAL</td><td class="text-right endcolor">'.number_format($totalMA).'</td><td class="text-right endcolor">'.number_format($totalMB).'</td><td class="text-right endcolor">'.$totalMC.'%</td><td class="text-right endcolor">'.number_format($totalMAA).'</td><td class="text-right endcolor">'.number_format($totalMBB).'</td><td class="text-right endcolor">'.$totalMCC.'%</td></tr>' ; 
        return view('imborauni',['form'=>$form,
                                'MC'=>$MC,
                                'todaydate'=>$todaydate,
                                'chardate'=>$chardate,
                                'char1'=>$char1,
                                'char2'=>$char2,
                                'char3'=>$char3,
                                'season'=>$season,
                              ]);
  }
  public function neww()
  {
    return view('new');
  }
  public function go()
  {

    $choiceday = Input::get('datepicker');
    $peoples = Input::get('checkvalue');
    $quitpeoples = Input::get('checkvaluequit');
    $monthstart = substr($choiceday, 0,8).'01';
    $usergroup = '藥品';
    #接收input選項 
    (isset($quitpeoples)) ? ($peoples = array_merge($peoples,$quitpeoples)):('');
    $userstatedate = date('Y-m-01');
    $cnames = [];
    (isset($peoples)) ? (''):($peoples = []);

    #撈在職人員for view
    $users = userstate::where('userdate','=',$userstatedate)->where('userstatus','=','藥品')->get();
    foreach ($users as $user) {
      $cnamesforpage[$user['usernum']] = $user['cname'];
    }

    #撈離職人員for view
    $users = userstate::where('userstatus','=','藥品')->get();
    foreach ($users as $user) {
      (isset($cnamesforpage[$user['usernum']])) ? (''):($cnamesquitforpage[$user['usernum']] = $user['cname']);
    }

    #填充$cnames = [] 所有程式重這邊開始並以人員為迴圈的開始
    foreach ($peoples as $usernum) {
      $users = userstate::where('usernum','=',$usernum)->where('userstatus','=','藥品')->first();
      $cnames[$users['usernum']] = $users['cname'];
    }
    #撈物流
    $shipping = array();
    $bigs = big::all();
    foreach ($bigs as $big) {
      $shipping[] = $big['customercode'];
    }
    #撈要產品
    $importantarget = array();
    $importantps = importantp::all();
    foreach ($importantps as $importantp) {
      $importantarget[] =  $importantp['itemno'];  
    }
    #撈每月業績與預算
    $everyone = FController::salesformedicine($shipping,$importantarget,$peoples,$usergroup,$choiceday,$monthstart);
    $budgetmonth = FController::budgetmonth($cnames,$everyone);
    #數字索引部份分別為個人當月業績預算,個人當月達成率,個人當月總total
    $pbudget= $budgetmonth[0];
    $pab= $budgetmonth[1];
    $totals= $budgetmonth[2];
    $everyonejava = json_encode($everyone);

    #撈季度業績與預算
    $Qsalesformedicine = FController::Qsalesformedicine($shipping,$importantarget,$peoples,$usergroup);
    $Qbudgetmonth = FController::Qbudgetmonth($cnames,$importantarget);
    //$Qtotal = FController::Qtatol($Qsalesformedicine,$Qbudgetmonth);
    //print_r($Qtotal);
    /*foreach ($Qsalesformedicine as $season => $cnames) {
      foreach ($cnames as $key => $med) {
        if ($season=='Q1') {
          $Qtotal[$season][$key] = [];
          $salestotal = array_sum($Qsalesformedicine[$season][$key]);
          $budgettotal = $ptotal = array_sum($Qbudgetmonth[$season][$key]);
          $abtotal = round($salestotal/$budgettotal * 100);
          array_push($Qtotal[$season][$key],$salestotal ,$budgettotal,$abtotal);
        }
        foreach ($med as $medkey => $value) {
          if ($season=='Q1') 
          {
            if ($Qbudgetmonth[$season][$key][$medkey]==0) {
              $Q1pab[$key][$medkey] = 0;
            }
            else
            {
              $Q1pab[$key][$medkey] = round($value/$Qbudgetmonth[$season][$key][$medkey] * 100);
            } 
          } 
        }
      }
    }*/
    //$Qtotal = [];
    foreach ($Qsalesformedicine as $season => $cnames) {
      foreach ($cnames as $key => $med) 
      {
        $Qtotal[$season][$key] = [];
        $salestotal = array_sum($Qsalesformedicine[$season][$key]);
        $budgettotal = $ptotal = array_sum($Qbudgetmonth[$season][$key]);
        ($budgettotal==0)?($abtotal=0):($abtotal = round($salestotal/$budgettotal * 100));
        array_push($Qtotal[$season][$key],$salestotal ,$budgettotal,$abtotal);
        foreach ($med as $medkey => $value) 
        {   
          $Qpab[$season][$key][$medkey] = [];
          ($Qbudgetmonth[$season][$key][$medkey]==0) ? ($Qpab[$season][$key][$medkey] = 0) : ($Qpab[$season][$key][$medkey] = round($value/$Qbudgetmonth[$season][$key][$medkey] * 100));
        } 
      }
    }
    $abc = [3,6,4,8,3,6,4,8,3,6,4,8];
    $test = json_encode($abc);
    return view('go',['totals'=>$totals 
                    ,'pab'=>$pab 
                    ,'pbudget'=>$pbudget 
                    ,'test'=>$test
                    ,'everyone'=>$everyone
                    ,'everyonejava'=>$everyonejava
                    ,'cnames'=>$cnames
                    ,'cnamesforpage'=>$cnamesforpage
                    ,'cnamesquitforpage'=>$cnamesquitforpage
                    ,'choiceday'=>$choiceday
                    ,'Qbudgetmonth'=>$Qbudgetmonth
                    ,'Qsalesformedicine'=>$Qsalesformedicine
                    ,'Qtotal'=>$Qtotal
                    ,'Qpab'=>$Qpab
                    ]);
  }
}