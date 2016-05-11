<?php 
namespace App\Http\Controllers;
use App\user;
use App\dailyreport;
use App\hareport;
use App\boehringer;
use App\boramonthbudget;
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\boracustomer;
use App\useracces;
use PHPExcel_Shared_Date;
use App\everymonth;
use PHPExcel_Cell_DataType;
use vendor\phpoffice\phpexcel\Classes\PHPExcel;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel5;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory;
use App\Http\Requests;
use Mail;
class ExportExcelController extends Controller {

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

  public function eisaireport()
  {
    ini_set('memory_limit', '256M');
    $objPHPExcel = new \PHPExcel();
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        //$file = glob(dirname(__FILE__).'\eisai\*.*');
        //$file2 = glob(dirname(__FILE__).'\eisai\check\*.*');///////////
        $file = glob(dirname(__FILE__).'/eisai/*.*');
        $file2 = glob(dirname(__FILE__).'/eisai/*.*');///////////
        $inputFileName = $file[0];
        $inputFileName2 = $file2[0];//////////////
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType); 
        $objPHPExcels = $objReader->load($inputFileName); 
        $objPHPExcels2 = $objReader->load($inputFileName2); //////////////////////
        $sheet = $objPHPExcels->getSheet(0); 
        $sheet2 = $objPHPExcels2->getSheet(0); //////
        $highestRow = $sheet->getHighestRow(); //取得總行數 
        $highestColumn = $sheet->getHighestColumn(); //取得列（英文顯示）
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);//列數轉化成數字 
        $objPHPExcel->setActiveSheetIndex(0);
        $strs = array();
        $addrow = 0;
        $rowf = 1;
        //注意Row索引從1開始 
        for ($row = 2 ; $row < $highestRow ; $row++) 
        { 
            //注意Col索引從0開始
            $strs = null; 
            for ($col = 0 ; $col < $highestColumnIndex ; $col++) 
            {  
                $strs[$col] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
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
                );
            if ($info['word9']=='68EIS001' or $info['word9']=='68EIS002' ) {
                if ($info['word1'] <> '0' and $info['word1'] == $sheet2->getCellByColumnAndRow(1, $row+1)->getValue() and $info['word9'] == $sheet2->getCellByColumnAndRow(9, $row+1)->getValue()) 
                {
                //echo 'a'.$info['word1'].'b' .$sheet2->getCellByColumnAndRow(1, $row+1)->getValue().'<br>';
                    $info['word7'] = $sheet2->getCellByColumnAndRow(7, $row+1)->getValue().'.00';
                    $info['word7'] = '       '.$info['word7'];
                    $info['word7'] = substr($info['word7'],-9);
                    $uniprice = round($info['word8']/($info['word6']+$info['word7']),2);
                    $uniprice = number_format($uniprice,2);
                    $uniprice = number_format($uniprice,2);
                    $uniprice  = '      '.$uniprice;
                    $uniprice  = substr($uniprice,-9);
                    $addrow = 1;
                }
                else
                {
                    $info['word7'] = $info['word7'].'.00';
                    $info['word7'] = '       '.$info['word7'];
                    $info['word7'] = substr($info['word7'],-9);
                    $uniprice = round($info['word8']/$info['word6'],2) ;
                    $uniprice = number_format($uniprice,2);
                    $uniprice  = '      '.$uniprice;
                    $uniprice  = substr($uniprice,-9);
                }    
                $info['word1'] = substr($info['word1'],2,8);
                ($info['word0']=='A2') ? ($info['word0']=1):($info['word0']=2);
                if ($info['word9']=='68EIS001')  {
                    $a='ALE     ';
                    $b='128G  ';
                }
                else
                {
                    $a='Z-CN    ';
                    $b='115G  ';
                }
                $info['word3'] = $info['word3'].'       ';
                $info['word3'] = substr($info['word3'],0,7);    
                $info['word5'] = PHPExcel_Shared_Date::ExcelToPHP($info['word5']);  
                $info['word5'] = date( 'Ymd', $info['word5']); 

                $info['word6'] = $info['word6'].'.00';
                $info['word6'] = '       '.$info['word6'];
                $info['word6'] = substr($info['word6'],-9);
                if ($info['word0']==1) {
                    $returnprice = '       0';
                    $info['word8'] = $info['word8'];
                    $info['word8'] = '          '.$info['word8'];
                    $info['word8'] = substr($info['word8'],-8);
                    $allprice = $info['word8'];
                }
                else
                {
                    $allprice = '       0' ;
                    $info['word8'] = $info['word8'];
                    $info['word8'] = '          '.$info['word8'];
                    $info['word8'] = substr($info['word8'],-8);
                    $returnprice = $info['word8']; 
                }    
                $comment = '          ';
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowf,$info['word1'].$info['word0'].$info['word5'].$info['word3'].$a.$b.$info['word6'].$info['word7'].$uniprice.$allprice.$returnprice.$comment);
                if ($addrow==1) {
                    $row = $row +1 ;
                    $addrow = 0;
                }
                $rowf = $rowf + 1;
            }
        }
        $filename = "sale.csv";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename" );
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')->setDelimiter(',')->setEnclosure('');;
        print(chr(0xEF).chr(0xBB).chr(0xBF));
        $objWriter->save('php://output');
    }
    public function eisaicus()
    {
        ini_set('memory_limit', '256M');
        $objPHPExcel = new \PHPExcel();
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        //$file = glob(dirname(__FILE__).'\eisaicus\*.*');
        $file = glob(dirname(__FILE__).'/eisai/*.*');
        $inputFileName = $file[0];
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType); 
        $objPHPExcels = $objReader->load($inputFileName); 
        $sheet = $objPHPExcels->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); //取得總行數 
        $highestColumn = $sheet->getHighestColumn(); //取得列（英文顯示）
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);//列數轉化成數字 
        $objPHPExcel->setActiveSheetIndex(0);
        $strs = array();
        $addrow = 0;
        $rowf = 1;
        $chkloop = 'test';
        //注意Row索引從1開始 
        for ($row = 2 ; $row < $highestRow ; $row++) 
        { 
            $cusexist = boracustomer::where('BORACustomerNo','=',$sheet->getCellByColumnAndRow(3, $row)->getValue())->count();
            if ($cusexist==0) {
                return '請更新客戶資料';
            }
        }        
        for ($row = 2 ; $row < $highestRow ; $row++) 
        { 
            //注意Col索引從0開始
            $strs = null; 
            for ($col = 0 ; $col < $highestColumnIndex ; $col++) 
            {   
                $strs[$col] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
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
                );
            if ($info['word9']=='68EIS001' or $info['word9']=='68EIS002' ) {
                $cusinfos = boracustomer::where('BORACustomerNo','=',$info['word3'])->get();
                foreach ($cusinfos as $cusinfo) {
                    if ($chkloop==$info['word3']) {
                        
                    }
                    else
                    {    
                        $cusinfo['BORACustomerNo'] = $cusinfo['BORACustomerNo'].'      ';
                        $cusinfo['BORACustomerNo'] = substr($cusinfo['BORACustomerNo'],0,7);
                        $cusinfo['shortname'] = trim(mb_substr($cusinfo['shortname'],0,4));
                        $a = $cusinfo['shortname'];
                        ($cusinfo['shortname']=="") ? ( $limit = 7 ) : ($limit = 8 - mb_strwidth($a) );
                        ($cusinfo['shortname']=="") ? ( $a = ' ' ) : ($a = $cusinfo['shortname']);
                        for ($i=1; $i <= $limit ; $i++) { 
                            $a = chunk_split($a,strlen($a)," ");
                        } 
                        $cusinfo['shortname'] = $a;                        
                        $cusinfo['name'] = trim($cusinfo['name']);
                        $a = $cusinfo['name'];
                        ($cusinfo['name']=="") ? ( $limit = 39 ) : ($limit = 40 - mb_strwidth($a) );
                        ($cusinfo['name']=="") ? ( $a = ' ' ) : ($a = $cusinfo['name']);
                        for ($i=1; $i <= $limit ; $i++) { 
                            $a = chunk_split($a,strlen($a)," ");
                        } 
                        $cusinfo['name'] = $a;
                        $storeown = '        ';
                        $cusinfo['contact'] = trim($cusinfo['contact']);
                        $a = $cusinfo['contact'];
                        ($cusinfo['contact']=="") ? ( $limit = 7 ) : ($limit = 8 - mb_strwidth($a) );
                        ($cusinfo['contact']=="") ? ( $a = ' ' ) : ($a = $cusinfo['contact']);
                        for ($i=1; $i <= $limit ; $i++) { 
                            $a = chunk_split($a,strlen($a)," ");
                        } 
                        $cusinfo['contact'] = $a;
                        $cusinfo['phone25'] = trim($cusinfo['phone25']);
                        $a = $cusinfo['phone25'];
                        ($cusinfo['phone25']=="") ? ( $limit = 11 ) : ($limit = 12 - mb_strwidth($a) );
                        ($cusinfo['phone25']=="") ? ( $a = ' ' ) : ($a = $cusinfo['phone25']);
                        for ($i=1; $i <= $limit ; $i++) { 
                            $a = chunk_split($a,strlen($a)," ");
                        } 
                        $cusinfo['phone25'] = $a;
                        $cusinfo['fax'] = trim($cusinfo['fax']);
                        $a = $cusinfo['fax'] ;
                        ($cusinfo['fax']=="") ? ( $limit = 11 ) : ($limit = 12 - mb_strwidth($a) );
                        ($cusinfo['fax']=="") ? ( $a = ' ' ) : ($a = $cusinfo['fax']);
                        for ($i=1; $i <= $limit ; $i++) { 
                            $a = chunk_split($a,strlen($a)," ");
                        } 
                        $cusinfo['fax'] = $a;
                        $cusinfo['address'] = trim($cusinfo['address']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowf,$cusinfo['BORACustomerNo'].$cusinfo['shortname'].$cusinfo['name'].$storeown.$cusinfo['contact'].$cusinfo['phone25'].$cusinfo['fax'].$cusinfo['address']);
                        $chkloop =  $info['word3'];
                        $rowf = $rowf + 1; 
                    }
                }                  
            }
        }
        $filename = "cus.csv";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename" );
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')->setDelimiter(',')->setEnclosure('');
        print(chr(0xEF).chr(0xBB).chr(0xBF));
        $objWriter->save('php://output');
    }
}