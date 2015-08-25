<?php 
namespace App\Http\Controllers;

use App\user;
use App\dailyreport;
use App\boramonthbudget;
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
//use App\mainmenudisplay;
use vendor\phpoffice\phpexcel\Classes\PHPExcel;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel5;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory;
use App\Http\Requests;
class ExcelController extends Controller {

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

    public function diaryexcel()
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
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        $file = glob(dirname(__FILE__).'\borareport\*.*');
        //$file = glob(dirname(__FILE__).'/diaryexcel/*.xls');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $inputFileName = $file[0];
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
        for ($row = 2;$row < $highestRow;$row++) 
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


    public function uniexcel()
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
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        $file = glob(dirname(__FILE__).'\unireport\*.*');
        //echo ($file[0]) ;
        //$file = glob(dirname(__FILE__).'/diaryexcel/*.xls');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $inputFileName = $file[0];
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
        for ($row = 2;$row < $highestRow;$row++) 
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
                
                ); 
                //寫入資料庫了 

                $alldatabase = new unidiaryreport ;
                $alldatabase->BORACustomerName = $info['word3'];
                $alldatabase->InvDate=$info['word0'];
                $alldatabase->Ordernuber=$info['word2'];            
                $alldatabase->OrderQty=$info['word7'];
                $alldatabase->Unitprice=$info['word9'];
                $alldatabase->InoviceAmt=$info['word10'];
                $alldatabase->BORAItemNo=$info['word4'];
                $alldatabase->BORAItemTCHIName=$info['word5'];//
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
        } 
        $test = unidiaryreport::all() ;
        $test = $alldatabase->InoviceAmt;
        $a = $test + $a ;
        echo $a;
    }
}