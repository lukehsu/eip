<?php 
namespace App\Http\Controllers;
use Request;
use Input;
use App\dailyreport;
use App\boramonthbudget;
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\Http\Requests;
use Response;
use Auth;

class datechangController extends Controller {


    public function borareportdate(Request $request) 
    {
        //選擇的日期
        $getdate = Input::get('date');
        $monthstart = substr($getdate, 0,8).'01';//依照選擇的日期轉換每月月初
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
        $dailyreportstable = dailyreport::where('InvDate','=',$getdate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;
            $BORACustomerNo= $dailyreport->BORACustomerNo;           
            switch ($BORAItemNo) {
                case '68PTV001':
                if ($BORACustomerNo<>'10824') 
                  {
                      $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell;
                      $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                      $itemno['Pitavol'] = $BORAItemNo;
                  }
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') 
                  {
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
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                    break;
            }
        }
        //and寫法註記一下每月銷售累加
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$getdate)->get();
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
                if ($BORACustomerNo<>'10824') 
                  {
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                  }
                    break;
                case '68DEN001':
                if ($BORACustomerNo<>'10824') 
                  {
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
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                    break;
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Lepax10'] + $medicine['Lepax5'] + $medicine['Lexapro'] +  $medicine['Ebixa'] + $medicine['Deanxit'] + $medicine['LendorminBora'] ;
        $totalsell = $medicine['Lendorminann'] + $medicine['Wilcon'] + $medicine['Kso'] + $medicine['Bpn'] + $medicine['Others'] + $totalsell ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Lepax10'] + $qtys['Lepax5'] + $qtys['Lexapro'] + $qtys['Ebixa'] + $qtys['Deanxit'] + $qtys['LendorminBora'] ;
        $allqty = $qtys['Lendorminann'] + $qtys['Wilcon'] + $qtys['Kso'] + $qtys['Bpn'] + $qtys['Others'] + $allqty;    
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Lepax10'] + $MA['Lepax5'] + $MA['Lexapro'] + $MA['Ebixa'] + $MA['Deanxit'] + $MA['LendorminBora'] ;
        $totalma = $MA['Lendorminann'] + $MA['Wilcon'] + $MA['Kso'] + $MA['Bpn'] + $MA['Others'] + $totalma;  
        //撈每月目標業績
        $monthbudgets = boramonthbudget::where('month','>=',$monthstart)->where('month','<=',$getdate)->get();
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
        if (Request::ajax()) {
            return response()->json(array(
                'status' => 2,
                'medicine'=>$medicine,
                'itemno'=>$itemno,
                'qtys'=>$qtys,
                'totalsell'=>$totalsell,
                'allqty'=>$allqty,
                'MA'=>$MA, 
                'MB'=>$MB, 
                'MC'=>$MC, 
                'totalma'=>$totalma,
                'totalmb'=>$totalmb,
                'totalmc'=>$totalmc,
                'monthstart'=>$monthstart
            ));
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors('錯誤！');
        }
    }





    public function unireportdate(Request $request) 
    {

        $getdate = Input::get('date');
        $monthstart = substr($getdate, 0,8).'01';//依照選擇的日期轉換每月月初
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
        $todaydate = date('Y-m-d');//今天日期
        //每日販賣數量 金額
        $dailyreportstable = unidiaryreport::where('InvDate','=', $getdate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;         
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
        //每月銷售累加  and寫法註記一下
        $dailyreportstable = unidiaryreport::where('InvDate','>=',$monthstart)->where('InvDate','<=', $getdate)->get();
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
            switch ($BORAItemNo) { 
                // 胃爾康
                case '57HWLCBC':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    break;
                case '57HWLCBJ':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    break;
                case '57HWLCBK':
                    $MA['Wilcon'] = $medicine['Wilcon'] + $dailysell;
                    break;
                // 氯四環素
                case '57QCTCBQ':
                    $MA['Kso'] = $MA['Kso'] + $dailysell ;
                    break;
                case '57QCTCBR':
                    $MA['Kso'] = $MA['Kso'] + $dailysell ;
                    break;
                // 優平
                case '57BUATPG': 
                    $MA['Upi']  = $MA['Upi'] + $dailysell ;
                    break;
                case '57BUPTB2':
                    $MA['Upi']  = $MA['Upi'] + $dailysell ;
                    break;
                case '57BUPTPJ': 
                    $MA['Upi']  = $MA['Upi'] + $dailysell ;
                    break;
                case '57BUTTPG':
                    $MA['Upi']  = $MA['Upi'] + $dailysell ;
                    break;
                // 優福   
                case '57JFOIB4':
                    $MA['Ufo'] = $MA['Ufo'] + $dailysell ;
                    break;
                case '57JFOIC4':
                    $MA['Ufo'] = $MA['Ufo'] + $dailysell ;
                    break;          
                default:
                    $MA['Others'] = $MA['Others'] + $dailysell ;
                    break;
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Brexa'] + $medicine['Wilcon'] + $medicine['Kso'] + $medicine['Upi'] + $medicine['Ufo'] + $medicine['Others'] ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Brexa'] + $qtys['Wilcon'] + $qtys['Kso'] + $qtys['Upi'] + $qtys['Ufo'] + $qtys['Others'] ;
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Brexa'] + $MA['Wilcon'] + $MA['Kso'] + $MA['Upi'] + $MA['Ufo'] + $MA['Others'] ;
        //撈每月目標業績
        $monthbudgets = unimonthbudget::where('month','>=',$monthstart)->where('month','<=', $getdate )->get();
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

        if (Request::ajax()) {
            return response()->json(array(
                'status' => 2,
                'medicine'=>$medicine,
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
                'monthstart'=>$monthstart
            ));
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors('錯誤！');
        }
    }


    public function accountreportdate(Request $request) 
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

        $medicinealltime = array('Pitavol' => 0 , 
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
        $todaydate = date('Y-m-d');//今天日期
        $getdate = Input::get('date');        
        $dailyreportstable = dailyreport::where('InvDate','=',$getdate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;         
            switch ($BORAItemNo) {
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
                    $medicine['Others'] = $medicine['Others'] + $dailysell ;
                    $qtys['Others'] = $qtys['Others'] + $qty ; 
                    $itemno['Others'] = $BORAItemNo ; 
                    break;
            }
        }

        $dailyreportstable = dailyreport::where('InvDate','>=',$yearstart)->where('InvDate','<=',$getdate)->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;         
            switch ($BORAItemNo) {
                case '68PTV001':
                    $medicinealltime['Pitavol'] = $medicinealltime['Pitavol'] + $dailysell;
                    break;
                case '68DEN001':
                    $medicinealltime['Denset'] = $medicinealltime['Denset'] + $dailysell ;
                    break;
                case '68LEP002':
                    $medicinealltime['Lepax10'] = $medicinealltime['Lepax10'] + $dailysell ; 
                    break;
                case '68LEP001':
                    $medicinealltime['Lepax5'] = $medicinealltime['Lepax5'] + $dailysell ;
                    break;
                case '68LXP001':
                    $medicinealltime['Lexapro'] = $medicinealltime['Lexapro'] + $dailysell ;
                    break;
                case '68EBP001': 
                    $medicinealltime['Ebixa']  = $medicinealltime['Ebixa'] + $dailysell ;
                    break;
                case '68DEP001':
                    $medicinealltime['Deanxit'] = $medicinealltime['Deanxit'] + $dailysell ;
                    break;
                ////分段一下這邊是LendorminBora  
                case '68LMP002':
                    $medicinealltime['LendorminBora'] = $medicinealltime['LendorminBora'] + $dailysell ;
                    break;
                default:
                    $medicinealltime['Others'] = $medicinealltime['Others'] + $dailysell ;
                    break;
            }
        }
        $medicinealltimetotla = $medicinealltime['Pitavol'] + $medicinealltime['Denset'] + $medicinealltime['Lepax10'] + $medicinealltime['Lepax5'] ;
        $medicinealltimetotla = $medicinealltimetotla + $medicinealltime['Lexapro'] + $medicinealltime['Ebixa'] + $medicinealltime['Deanxit'] + $medicinealltime['LendorminBora'] + $medicinealltime['Others'] ;
        //and寫法註記一下單月銷售累加
        $dailyreportstable = dailyreport::where('InvDate','>=',$monthstart)->where('InvDate','<=',$getdate)->get();
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
            switch ($BORAItemNo) {
                case '68PTV001':
                    $MA['Pitavol'] = $MA['Pitavol'] + $MonthTotal;
                    break;
                case '68DEN001':
                    $MA['Denset'] = $MA['Denset'] + $MonthTotal;
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
                    $MA['Others'] = $MA['Others'] + $MonthTotal;
                    break;
            }
        }
        $totalsell = $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Lepax10'] + $medicine['Lepax5'] + $medicine['Lexapro'] +  $medicine['Ebixa'] + $medicine['Deanxit'] + $medicine['LendorminBora'] ;
        $totalsell =  $medicine['Others'] + $totalsell ;
        $allqty = $qtys['Pitavol'] + $qtys['Denset'] + $qtys['Lepax10'] + $qtys['Lepax5'] + $qtys['Lexapro'] + $qtys['Ebixa'] + $qtys['Deanxit'] + $qtys['LendorminBora'] ;
        $allqty =  $qtys['Others'] + $allqty;    
        $totalma = $MA['Pitavol'] + $MA['Denset'] + $MA['Lepax10'] + $MA['Lepax5'] + $MA['Lexapro'] + $MA['Ebixa'] + $MA['Deanxit'] + $MA['LendorminBora'] ;
        $totalma = $MA['Others'] + $totalma;  
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
                default:
                    $MB['Others'] = $MonthTotal ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ;                     
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] ;
        $totalmb = $MB['Others'] + $totalmb ; 
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Lepax10'] + $MC['Lepax5'] + $MC['Lexapro'] + $MC['Ebixa'] + $MC['Deanxit'] + $MC['LendorminBora'] ;
        $totalmc = $MC['Others'] + $totalmc ; 
        $totalmc = round($totalmc / 9) ;
        if (Request::ajax()) {
            return response()->json(array(
                                    'medicine'=>$medicine,
                                    'medicinealltime'=>$medicinealltime,
                                    'medicinealltimetotla'=>$medicinealltimetotla,
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
                                    'monthstart'=>$monthstart
            ));
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors('錯誤！');
        }
    }
}