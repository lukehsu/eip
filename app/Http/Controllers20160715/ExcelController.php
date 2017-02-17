<?php 
namespace App\Http\Controllers;
use App\User;
use App\dailyreport;
use App\hareport;
use App\boehringer;
use App\boramonthbudget;
use App\unidiaryreport;//每日業績
use App\unimonthbudget;//uni每月預算
use App\boracustomer;
use App\userstate;
use App\useracces;
use App\everymonth;
//use App\mainmenudisplay;
use vendor\phpoffice\phpexcel\Classes\PHPExcel;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel5;
use vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory;
use App\Http\Requests;
use Mail,DB;
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
    	ini_set('memory_limit', '2048M');
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
        //$file = glob(dirname(__FILE__).'\borareport\*.*');
        $file = glob(dirname(__FILE__).'/borareport/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            //填寫收信人信箱
            $to = ['luke.hsu@bora-corp.com','sam.wu@bora-corp.com'];
            //信件的內容
            $data = [];
            //寄出信件
            Mail::send('mail.mail', [], function($message) use ($to) 
            {
                $message->to($to)->subject('今日無新增資料');
            });
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {    
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
                if ($info['word0']=='R2') {
                	$info['word9'] = 0 - $info['word9'];
                }
                $usergroup = User::where('name','=',$info['word14'])->first();

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
                $alldatabase->SalesRepresentativegroup=$usergroup['office'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
                DB::table('reportbora')->insert(array('SalesType' => $info['word0']
                                                    , 'OrderNo' => $info['word1']
                                                    , 'Guino' => $info['word13']
                                                    , 'Cusno' => $info['word4']
                                                    , 'Cusname' => $info['word5']
                                                    , 'Itemno' => $info['word10']
                                                    , 'Itemname' => $info['word12']
                                                    , 'Itemchname' => $info['word11']
                                                    , 'Invdate' => $info['word6']
                                                    , 'Qty' => $info['word7']
                                                    , 'FQty' => $info['word8']
                                                    , 'Money' => $info['word9']
                                                    , 'Salesname' => $info['word15']
                                                    , 'Salesno' => $info['word14']
                                                    , 'Salesgroup' => $usergroup['office']
                                                    , 'Comany' => 'bora'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
        }
            //填寫收信人信箱
            $to = ['luke.hsu@bora-corp.com'];
            //信件的內容
            $data = [];
            //寄出信件
            Mail::send('mail.mail', [], function($message) use ($to) 
            {
                $message->to($to)->subject('今日資料已新增');
            });
        echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
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
        //$file = glob(dirname(__FILE__).'\unireport\*.*');
        $file = glob(dirname(__FILE__).'/unireport/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {    
        $inputFileName = $file[0];
        echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory with a defined reader type of ',$inputFileType,'<br />'; 
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType); 
        $objPHPExcel = $objReader->load($inputFileName); 
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); //取得總行數 
        $highestColumn = $sheet->getHighestColumn(); //取得列（英文顯示）
        //$objWorksheet = $objPHPExcel->getActiveSheet();//取得總行數(不指定sheet寫法) 
        //$highestRow = $objWorksheet->getHighestRow();//取得總列數(不指定sheet寫法)  
        echo 'highestRow123='.$highestRow ; 
        echo "<br>"; 
        //$highestColumn = $objWorksheet->getHighestColumn();//我不知道這一行到底是幹嘛的
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);//列數轉化成數字 
        echo 'highestColumnIndex='.$highestColumnIndex.'test'; 
        echo "<br />"; 
        $headtitle=array(); 
        $test = null;
        $a = null;
        for ($row = 2;$row <= $highestRow;$row++) 
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
                ); 
                //寫入資料庫了 
                $wordchange = substr($info['word0'], 0,3);
                $wordchangec = $wordchange + 1911;
                $info['word0'] = str_replace($wordchange, $wordchangec, $info['word0']);
                $alldatabase = new unidiaryreport ;
                $alldatabase->BORACustomerno = $info['word2'];
                $alldatabase->BORACustomerName = $info['word3'];
                $alldatabase->InvDate=$info['word0'];
                $alldatabase->Ordernuber=$info['word1'];            
                $alldatabase->OrderQty=$info['word7'];
                $alldatabase->Unitprice=$info['word9'];
                $alldatabase->InoviceAmt=$info['word10'];
                $alldatabase->BORAItemNo=$info['word4'];
                $alldatabase->BORAItemTCHIName=$info['word5'];//
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
                $SalesType = null;
                if ($info['word10']<0) {
                    $SalesType ='R2';
                }
                else
                {
                    $SalesType = 'A2';
                }    
                $info['word1'] = str_replace('銷貨：BB','',$info['word1']);
                if ($info['word11']=='林雪洪') {
                    $Salesgroup = '聯邦';
                }
                else
                {
                    $Salesgroup = '藥品'; 
                }    
                $salesno = DB::table('users')->where('cname','=',$info['word11'])->first();
                DB::table('reportuni')->insert(array('SalesType' =>$SalesType 
                                                    , 'OrderNo' =>$info['word1'] 
                                                    , 'Guino' =>''
                                                    , 'Cusno' =>$info['word2']
                                                    , 'Cusname' =>$info['word3']
                                                    , 'Itemno' =>$info['word4']
                                                    , 'Itemname' =>''
                                                    , 'Itemchname' =>$info['word5']
                                                    , 'Invdate' =>$info['word0']
                                                    , 'Qty' =>$info['word7']
                                                    , 'FQty' =>''
                                                    , 'Money' =>$info['word10']
                                                    , 'Salesname' =>$info['word11']
                                                    , 'Salesno' =>$salesno->name
                                                    , 'Salesgroup' =>$Salesgroup
                                                    , 'Comany' => 'uni'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
        } 
        echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
    }

    public function haexcel()
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
        //$file = glob(dirname(__FILE__).'\hareport\*.*');
        $file = glob(dirname(__FILE__).'/hareport/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {    
        //和安的因為資料有重複需要刪掉後再加入
        $monstart = date('Y-m-01');    
        $deldata = hareport::where('INVDT', '>=', $monstart)->delete();  
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
        for ($row = 2;$row <= $highestRow;$row++) 
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
                ); 
                //寫入資料庫了 
                $alldatabase = new hareport ;
                $alldatabase->SALTP=$info['word0'];
                $alldatabase->ORDNO=$info['word1'];
                $alldatabase->LINNO=$info['word2'];            
                $alldatabase->CUSNO=$info['word3'];
                $alldatabase->INVDT=$info['word4'];
                $alldatabase->ORQTY=$info['word5'];
                $alldatabase->FGQTY=$info['word6'];
                $alldatabase->INVAM=$info['word7'];
                $alldatabase->CDAMT=$info['word8'];
                $alldatabase->HAITMNO=$info['word9'];
                $alldatabase->GUINO=$info['word10'];
                $alldatabase->HACUS=$info['word11'];
                $alldatabase->Source=$info['word12'];
                $alldatabase->CUSNAME=$info['word13'];
                $alldatabase->CUSADDRESS=$info['word14'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
                $info['word0'] = trim($info['word0']);
                if ($info['word0']=='A2') 
                {
                    DB::table('reportha')->insert(array('SalesType' => $info['word0']
                                                    , 'OrderNo' => $info['word1']
                                                    , 'Guino' =>$info['word10'] 
                                                    , 'Cusno' =>$info['word3']
                                                    , 'Cusname' =>$info['word13']
                                                    , 'Itemno' =>$info['word9']
                                                    , 'Itemname' =>'' 
                                                    , 'Itemchname' =>'' 
                                                    , 'Invdate' =>$info['word4'] 
                                                    , 'Qty' =>$info['word5']
                                                    , 'FQty' =>$info['word6']
                                                    , 'Money' =>$info['word7']
                                                    , 'Salesname' => ''
                                                    , 'Salesno' =>'' 
                                                    , 'Salesgroup' => ''
                                                    , 'Comany' => 'ha'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
                    $info['word8'] = 0 - $info['word8'];
                    DB::table('reportha')->insert(array('SalesType' => 'R2'
                                                    , 'OrderNo' => $info['word1']
                                                    , 'Guino' =>$info['word10'] 
                                                    , 'Cusno' =>$info['word3']
                                                    , 'Cusname' =>$info['word13']
                                                    , 'Itemno' =>$info['word9']
                                                    , 'Itemname' =>'' 
                                                    , 'Itemchname' =>'' 
                                                    , 'Invdate' =>$info['word4'] 
                                                    , 'Qty' =>'0'
                                                    , 'FQty' =>'0'
                                                    , 'Money' =>$info['word8']
                                                    , 'Salesname' => ''
                                                    , 'Salesno' =>'' 
                                                    , 'Salesgroup' => ''
                                                    , 'Comany' => 'ha'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
                }
                else
                {
                    $info['word8'] = 0 - $info['word8'];
                    DB::table('reportha')->insert(array('SalesType' => $info['word0']
                                                    , 'OrderNo' => $info['word1']
                                                    , 'Guino' =>$info['word10'] 
                                                    , 'Cusno' =>$info['word3']
                                                    , 'Cusname' =>$info['word13']
                                                    , 'Itemno' =>$info['word9']
                                                    , 'Itemname' =>'' 
                                                    , 'Itemchname' =>'' 
                                                    , 'Invdate' =>$info['word4'] 
                                                    , 'Qty' =>$info['word5']
                                                    , 'FQty' =>$info['word6']
                                                    , 'Money' =>$info['word8']
                                                    , 'Salesname' => ''
                                                    , 'Salesno' =>'' 
                                                    , 'Salesgroup' => ''
                                                    , 'Comany' => 'ha'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
                }   
        } 
        echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
    }

    public function boehringer()
    {

        $objPHPExcel = new \PHPExcel();
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        //$file = glob(dirname(__FILE__).'\hareport\*.*');
        $file = glob(dirname(__FILE__).'/hareport/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {  
        //和安的因為資料有重複需要刪掉後再加入
        $monstart = date('Y-m-01');    
        $deldata = boehringer::where('date', '>=', $monstart)->delete();  
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
        for ($row = 2;$row <= $highestRow;$row++) 
        { 
            $strs=array(); 
        //注意highestColumnIndex的列數索引從0開始 
            for ($col = 0;$col <= $highestColumnIndex;$col++) 
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
                ); 
                //寫入資料庫了 
                $alldatabase = new boehringer ;
                $alldatabase->SaleType=$info['word0'];
                $alldatabase->SalesOrder=$info['word1'];
                $alldatabase->CustomerNo=$info['word2'];            
                $alldatabase->ItemNo=$info['word3'];
                $alldatabase->mappingdate=substr($info['word4'],0,4).'-'.substr($info['word4'],4,2);
                $alldatabase->Date=$info['word4'];
                $alldatabase->QTY=$info['word5'];
                $alldatabase->Amount=$info['word6'];
                $alldatabase->GUINo=$info['word7'];
                $alldatabase->RECID=$info['word8'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
                $whatday = substr($info['word4'],0,4).'-'.substr($info['word4'],4,2);
                $datapickupcount = DB::table('mobicmapping')->where('date','=',$whatday)->where('cusno','=',$info['word2'])->count();
                if ($datapickupcount>0) {
                    $datapickup = DB::table('mobicmapping')->where('date','=',$whatday)->where('cusno','=',$info['word2'])->first();
                    $Cusname = $datapickup->cusname;
                    $Salesname = $datapickup->salename;
                    $Salesgroup = $datapickup->dep;
                }
                else
                {
                    $Cusname = '';
                    $Salesname = '';
                    $Salesgroup = '';
                }    
                if ($info['word0']=='R2') {
                    $info['word6'] = 0 - $info['word6'];
                }
                DB::table('reportboeh')->insert(array('SalesType' => $info['word0']
                                                    , 'OrderNo' => $info['word1']
                                                    , 'Guino' =>$info['word7'] 
                                                    , 'Cusno' =>$info['word2']
                                                    , 'Cusname' => $Cusname
                                                    , 'Itemno' =>$info['word3'] 
                                                    , 'Itemname' =>'' 
                                                    , 'Itemchname' =>'' 
                                                    , 'Invdate' =>$info['word4'] 
                                                    , 'Qty' =>$info['word5'] 
                                                    , 'FQty' =>'' 
                                                    , 'Money' =>$info['word6'] 
                                                    , 'Salesname' => $Salesname
                                                    , 'Salesno' =>'' 
                                                    , 'Salesgroup' => $Salesgroup
                                                    , 'Comany' => 'boeh'
                                                    , 'updated_at' => date('Y-m-d h:i:sa')
                                                    , 'created_at' => date('Y-m-d h:i:sa')
                                                    ));
        } 
        echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
    }

    public function boracm()
    {

        $objPHPExcel = new \PHPExcel();
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        //$file = glob(dirname(__FILE__).'\borareport\*.*');
        $file = glob(dirname(__FILE__).'/boracus/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {  
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
        boracustomer::truncate();
        for ($row = 2;$row <= $highestRow;$row++) 
        { 
            $strs=array(); 
        //注意highestColumnIndex的列數索引從0開始 
            for ($col = 0;$col <= $highestColumnIndex;$col++) 
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
                'word16'=>"$strs[16]",
                'word17'=>"$strs[17]", 
                'word18'=>"$strs[18]", 
                'word19'=>"$strs[19]",
                'word20'=>"$strs[20]", 
                'word21'=>"$strs[21]", 
                'word22'=>"$strs[22]",
                'word23'=>"$strs[23]",
                'word24'=>"$strs[24]",
                ); 
                //寫入資料庫了 
                $alldatabase = new boracustomer ;
                $alldatabase->BORACustomerNo=$info['word0'];
                $alldatabase->CustomerNo=$info['word1'];
                $alldatabase->shortname=$info['word2'];            
                $alldatabase->name=$info['word3'];
                $alldatabase->address=$info['word4'];
                $alldatabase->phone11=$info['word5'];
                $alldatabase->phone12=$info['word6'];
                $alldatabase->phone13=$info['word7'];
                $alldatabase->phone14=$info['word8'];
                $alldatabase->phone15=$info['word9'];
                $alldatabase->phone16=$info['word10'];
                $alldatabase->phone17=$info['word11'];
                $alldatabase->phone21=$info['word12'];            
                $alldatabase->phone22=$info['word13'];
                $alldatabase->phone23=$info['word14'];
                $alldatabase->phone24=$info['word15'];
                $alldatabase->phone25=$info['word16'];
                $alldatabase->phone26=$info['word17'];
                $alldatabase->phone27=$info['word18'];
                $alldatabase->contact=$info['word19'];
                $alldatabase->fax=$info['word20'];
                $alldatabase->dep1=$info['word21'];
                $alldatabase->dep2=$info['word22'];
                $alldatabase->empono=$info['word23'];
                $alldatabase->empo=$info['word24'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
        } 
        //echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
    }

    public function everymonth()
    {
        ini_set('memory_limit', '1024M');
        $year = date('Y');
        echo $year;
        $objPHPExcel = new \PHPExcel();
        //$inputFileType = 'Excel5';    //這個是讀舊版的 
        $inputFileType = 'Excel2007';   //這個2003以上的 
        //另一種寫法
        //print_r (scandir(dirname(__FILE__))) ;
        //自動撈檔名 下面兩行一種是linux專用一種是windows
        //$file = glob(dirname(__FILE__).'\borareport\*.*');
        $file = glob(dirname(__FILE__).'/borareport/*.*');
        //$file = $file[0];
        //$file = str_replace(dirname(__FILE__).'\diaryexcel',"",$file);
        $check = count($file);
        if ($check<1) 
        {
            echo  "<script type='text/javascript'>setTimeout(self.close(),10000);</script>"; 
        }
        else
        {  
        //報表是累加的所以每天的資料要先刪除再加入
        $deldata = everymonth::where('years', '>=', $year)->delete();
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
        //代表只要從第八行開始且最後一行不要
        for ($row = 9;$row < $highestRow;$row++) 
        { 
            $strs=array(); 
        //注意highestColumnIndex的列數索引從0開始 
            for ($col = 0;$col <= $highestColumnIndex;$col++) 
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
                'word16'=>"$strs[16]",
                'word17'=>"$strs[17]", 
                'word18'=>"$strs[18]", 
                'word19'=>"$strs[19]",
                'word20'=>"$strs[20]", 
                'word21'=>"$strs[21]", 
                'word22'=>"$strs[22]",
                'word23'=>"$strs[23]",
                'word24'=>"$strs[24]",
                'word25'=>"$strs[25]",               
                'word26'=>"$strs[26]",
                'word27'=>"$strs[27]", 
                'word28'=>"$strs[28]", 
                'word29'=>"$strs[29]",
                'word30'=>"$strs[30]",
                'word31'=>"$strs[31]", 
                'word32'=>"$strs[32]",
                'word33'=>"$strs[33]",
                'word34'=>"$strs[34]",
                ); 
                //寫入資料庫了 
                $alldatabase = new everymonth ;
                $alldatabase->years=$year;
                $alldatabase->zone1=$info['word0'];
                $alldatabase->zone2=$info['word1'];
                $alldatabase->empono=$info['word2'];            
                $alldatabase->emponame=$info['word3'];
                $alldatabase->customersno=$info['word4'];
                $alldatabase->customers=$info['word5'];
                $alldatabase->itemno=$info['word6'];
                $alldatabase->itemchname=$info['word7'];
                $alldatabase->itemenname=$info['word8'];
                $alldatabase->allqty=$info['word9'];
                $alldatabase->allmoney=$info['word10'];
                $alldatabase->janqty=$info['word11'];
                $alldatabase->janmoney=$info['word12'];            
                $alldatabase->febqty=$info['word13'];
                $alldatabase->febmoney=$info['word14'];
                $alldatabase->marqty=$info['word15'];
                $alldatabase->marmoney=$info['word16'];
                $alldatabase->aprqty=$info['word17'];
                $alldatabase->aprmoney=$info['word18'];
                $alldatabase->mayqty=$info['word19'];
                $alldatabase->maymoney=$info['word20'];
                $alldatabase->junqty=$info['word21'];
                $alldatabase->junmoney=$info['word22'];
                $alldatabase->julqty=$info['word23'];
                $alldatabase->julmoney=$info['word24'];
                $alldatabase->augqty=$info['word25'];
                $alldatabase->augmoney=$info['word26'];
                $alldatabase->sepqty=$info['word27'];
                $alldatabase->sepmoney=$info['word28'];
                $alldatabase->octqty=$info['word29'];
                $alldatabase->octmoney=$info['word30'];
                $alldatabase->novqty=$info['word31'];
                $alldatabase->novmoney=$info['word32'];
                $alldatabase->decqty=$info['word33'];
                $alldatabase->decmoney=$info['word34'];
                $alldatabase->save();
                print_r($info); 
                echo '<br />'; 
        } 
            //填寫收信人信箱
            $to = ['luke.hsu@bora-corp.com'];
            //信件的內容
            $data = [];
            //寄出信件
            Mail::send('mail.mail', [], function($message) use ($to) 
            {
                $message->to($to)->subject('今日資料已新增');
            });
        	echo  "<script type='text/javascript'>setTimeout(self.close(),60000);</script>"; 
        }
    }

    public function test()
    {


return view('test');

        
    }

}