<?php 
namespace App\Http\Controllers;
use Request;
use Input;
use App\dailyreport;
use App\boramonthbudget;
use vendor\phpoffice\phpexcel\Classes\PHPExcel;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel5;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory;
use App\Http\Requests;
use Response;
use Auth;
//use Redirect, Auth, Log;


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
	{    // guest 是原來的
		//$this->middleware('guest');
        $this->middleware('auth', ['except' => ['login','show']]);
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


    public function first()
    {
        
        $customer = dailyreport::all();

    	return view('first',['customer'=>$customer]);
    }


    public function second()
    {
        $objPHPExcel = new \PHPExcel();
        /*
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPExcel->getProperties()->setCategory("Test result file");

        //Add some data 添加數據
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Hello');//可以指定位置
        $objPHPExcel->getActiveSheet()->setCellValue('A2', true);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', false);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'world!');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 2);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Hello');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'world!');
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        */
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //$inputFileName = dirname(__FILE__).'/t.xls'; 
        $inputFileName = dirname(__FILE__).'/TestController.xlsx'; 
        echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory with a defined reader type of ',$inputFileType,'<br />'; 
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType); 
        $objPHPExcel = $objReader->load($inputFileName); 
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); //取得總行數 
        $highestColumn = $sheet->getHighestColumn(); //取得列（英文顯示）
        //$objWorksheet = $objPHPExcel->getActiveSheet();//取得總行數(不指定sheet寫法) 
        //$highestRow = $objWorksheet->getHighestRow();//取得總列數(不指定sheet寫法)  
        echo 'highestRow='.$highestRow ; 
        echo "<br>"; 
        //$highestColumn = $objWorksheet->getHighestColumn();//我不知道這一行到底是幹嘛的
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);//列數轉化成數字 
        echo 'highestColumnIndex='.$highestColumnIndex.'test'; 
        echo "<br />"; 
        $headtitle=array(); 
        $test = null;
        $a = null;
        for ($row = 1;$row <= $highestRow;$row++) 
        { 
            $strs=array(); 
        //注意highestColumnIndex的列數索引從0開始 
            for ($col = 0;$col < $highestColumnIndex;$col++) 
            {  
                $strs[$col] = $sheet->getCellByColumnAndRow($col, $row)->getValue();//宣告陣列長度
            }  
                $info = array( 
                'word0'=>"$strs[0]", 
                'word1'=>"$strs[1]", 
                'word2'=>"$strs[2]", 
                'word3'=>"$strs[3]",  
                'word4'=>"$strs[4]",
                'word5'=>"$strs[5]",               
                'word6'=>"$strs[6]",
                'word7'=>"$strs[7]", 
                'word8'=>"$strs[8]", 
                'word9'=>"$strs[9]",
                'word10'=>"$strs[10]", 
                'word11'=>"$strs[11]", 
                'word12'=>"$strs[12]", 
                'word13'=>"$strs[13]", 
                'word14'=>"$strs[14]", 
                'word15'=>"$strs[15]",
                
                ); 
                //寫入資料庫了 

                $alldatabase = new dailyreport ;
                $alldatabase->SalesType = $info['word0'];
                $alldatabase->OrderNo = $info['word1'];
                $alldatabase->LineNo = $info['word2'];
                $alldatabase->NoteNo = $info['word3'];
                $alldatabase->BORACustomerNo = $info['word4'];
                $alldatabase->BORACustomerName=$info['word5'];
                $alldatabase->InvDate=$info['word6'];
                $alldatabase->OrderQty=$info['word7'];
                $alldatabase->FGQty=$info['word8'];
                $alldatabase->InoviceAmt=$info['word9'];
                $alldatabase->BORAItemNo=$info['word10'];
                $alldatabase->BORAItemTCHIName=$info['word11'];
                $alldatabase->BORAItemEngName=$info['word12'];
                $alldatabase->GUINo=$info['word13'];
                $alldatabase->SalesRepresentativeNo=$info['word14'];
                $alldatabase->SalesRepresentativeName=$info['word15'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
        } 
        $test = dailyreport::all() ;
        $test = $alldatabase->InoviceAmt;
        $a = $test + $a ;
        echo $a;
    }

    public function third()
    {

        return view('third');
    }
    
    public function fourth()
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
        $todaydate = date('Y-m-d');//今天日期
        $dailyreportstable = dailyreport::where('InvDate','=',$todaydate)->get();
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
                default:
                    $MB['Others'] = $MonthTotal ;
                    $MC['Others'] = round(($MA['Others'] / $MonthTotal) * 100) ;                     
                    break;
            }
        } 
        $totalmb = $MB['Pitavol'] + $MB['Denset'] + $MB['Lepax10'] + $MB['Lepax5'] + $MB['Lexapro'] + $MB['Ebixa'] + $MB['Deanxit'] + $MB['LendorminBora'] ;
        $totalmb = $MB['Lendorminann'] + $MB['Wilcon'] + $MB['Kso'] + $MB['Bpn'] + $MB['Others'] + $totalmb ; 
        $totalmc = $MC['Pitavol'] + $MC['Denset'] + $MC['Lepax10'] + $MC['Lepax5'] + $MC['Lexapro'] + $MC['Ebixa'] + $MC['Deanxit'] + $MC['LendorminBora'] ;
        $totalmc = $MC['Lendorminann'] + $MC['Wilcon'] + $MC['Kso'] + $MC['Bpn'] + $MC['Others'] + $totalmc ; 
        return view('fourth',['Pitavol'=>$medicine['Pitavol'],
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
























    public function fifth()
    {
        $medicine = array('Deanxit'=>0,'Ebixa'=>0,'Lendormin'=>0,'Lexapro'=>0,'Lepax5'=>0,'Lepax10'=>0,'Pitavol'=>0,'Denset'=>0,'Other'=>0);
        $qtys =  array('Deanxit'=>0,'Ebixa'=>0,'Lendormin'=>0,'Lexapro'=>0,'Lepax5'=>0,'Lepax10'=>0,'Pitavol'=>0,'Denset'=>0,'Other'=>0);
        $todaydate = date('Y-m-d');//今天日期
        $dailyreportstable = dailyreport::where('InvDate','=','2015-07-28')->get();
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $dailysell = $dailyreport->InoviceAmt;
            $qty  = $dailyreport->OrderQty;         
            switch ($BORAItemNo) {
                case '68DEP001':
                    $medicine['Deanxit'] = $medicine['Deanxit'] + $dailysell;
                    $qtys['Deanxit'] = $qtys['Deanxit'] + $qty ; 
                    break;
                case '68EBP001':
                    $medicine['Ebixa']  = $medicine['Ebixa'] + $dailysell ;
                    $qtys['Ebixa'] = $qtys['Ebixa'] + $qty ; 
                    break;
                case '68LXP001':
                    $medicine['Lexapro'] = $medicine['Lexapro']  + $dailysell ;
                    $qtys['Lexapro'] = $qtys['Lexapro'] + $qty ; 
                    break;
                case '68LEP001':
                    $medicine['Lepax5'] = $medicine['Lepax5']+ $dailysell ;
                    $qtys['Lepax5'] = $qtys['Lepax5'] + $qty ; 
                    break;
                case '68LEP002':
                    $medicine['Lepax10'] = $medicine['Lepax10'] + $dailysell ;
                    $qtys['Lepax10'] = $qtys['Lepax10'] + $qty ; 
                    break;
                case '68PTV001':
                    $medicine['Pitavol'] = $medicine['Pitavol'] + $dailysell ;
                    $qtys['Pitavol'] = $qtys['Pitavol'] + $qty ; 
                    break;
                case '68DEN001':
                    $medicine['Denset'] = $medicine['Denset'] + $dailysell ;
                    $qtys['Denset'] = $qtys['Denset'] + $qty ; 
                    break;                  
                default:
                    $medicine['Other'] = $medicine['Other'] + $dailysell ;
                    $qtys['Other'] = $qtys['Other'] + $qty ; 
                    break;
            }
        }
        $dailyreportstable = dailyreport::where('InvDate','>=','2015-07-01')->where('InvDate','<=',$todaydate)->get();//and寫法註記一下
        $MT =  array('Deanxit'=>0,'Ebixa'=>0,'Lendormin'=>0,'Lexapro'=>0,'Lepax5'=>0,'Lepax10'=>0,'Pitavol'=>0,'Denset'=>0,'Other'=>0);
        foreach ($dailyreportstable as $dailyreport) {
            $BORAItemNo = $dailyreport->BORAItemNo;
            $MonthTotal = $dailyreport->InoviceAmt;       
            switch ($BORAItemNo) {
                case '68DEP001':
                    $MT['Deanxit'] = $MT['Deanxit'] + $MonthTotal;
                    break;
                case '68EBP001':
                    $MT['Ebixa']  = $MT['Ebixa'] + $MonthTotal;
                    break;
                case '68LXP001':
                    $MT['Lexapro'] = $MT['Lexapro'] + $MonthTotal;
                    break;
                case '68LEP001':
                    $MT['Lepax5'] = $MT['Lepax5'] + $MonthTotal;
                    break;
                case '68LEP002':
                    $MT['Lepax10'] = $MT['Lepax10'] + $MonthTotal;
                    break;
                case '68PTV001':
                    $MT['Pitavol'] = $MT['Pitavol'] + $MonthTotal;
                    break;
                case '68DEN001':
                    $MT['Denset'] = $MT['Denset'] + $$MonthTotal;
                    break;                  
                default:
                    $MT['Other'] = $MT['Other'] + $MonthTotal;
                    break;
            }
        }
        $Totalsell = $medicine['Deanxit'] + $medicine['Ebixa'] + $medicine['Lexapro'] + $medicine['Lepax5'] + $medicine['Lepax10'] + $medicine['Pitavol'] + $medicine['Denset'] + $medicine['Other'] ;        
        $allqty = 0 ;
        foreach ($qtys as $name => $Value) {
            $allqty = $allqty + $Value ;
        }
        $Totalmt = 0;
        foreach ($MT as $name => $Value) {
            $Totalmt = $Totalmt + $Value ;
        }
        return view('fifth',[ 'Pitavol'=>$medicine['Pitavol'],
                              'Denset'=>$medicine['Denset'],
                              'Lepax10'=>$medicine['Lepax10'],
                              'Lepax5'=>$medicine['Lepax5'],
                              'Lexapro'=>$medicine['Lexapro'],
                              'Ebixa'=>$medicine['Ebixa'],
                              //'LendorminBora'=>$LendorminBora,
                              //'Lendorminann'=>$Lendorminann,
                              'Others'=>$medicine['Other'],
                              'qtys'=>$qtys,
                              'todaydate'=>$todaydate,
                              'Totalsell'=>$Totalsell,
                              'Allqty'=>$allqty,
                              'MT'=>$MT, 
                              'Totalmt'=>$Totalmt
                              ]);
    }


    public function test()
    {

        if(Auth::guest()){
            return redirect('/');
        }
        return view('third');
    }
    
}