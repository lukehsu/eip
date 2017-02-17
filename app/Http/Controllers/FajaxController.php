<?php 
namespace App\Http\Controllers;
use App\User;
use App\itticket;
use App\Http\Requests;
use App\boraitem;
use App\everymonth;
use App\budgetgp;
use App\importantp;
use App\itservicerank;
use App\useracces;
use App\importantall;
use App\salesmen;
use App\calendar;
use App\dailyreport;
use App\mobicmappingdata;
use Hash,Input,Request,Response,Auth,Redirect,Log,Mail,DB;

class FajaxController extends Controller {

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
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */    
////////人員選單////////////////////////////////////////////    
    public static function chooseman()
    {
        $cnamesforpage = [];
        $checkboxinfo  = [];
        $vcnamesquitforpage = [];
        $cnamesquitforpage  = [];
        switch (Input::get('info')) {
            case 'GPpeople':
                $userstatus = '藥品';
                break;
            case 'HPpeople':
                $userstatus = '醫院';
                break;
            case 'Healpeople':
                $userstatus = '保健';
                break;            
            default:
                break;
        }
//////////在職人員/////////////////////////////////////////////
        if (Auth::user()->office=='管理' or Auth::user()->level<>'' ) {
            $users = DB::table('alluserstates')->where('userstatus','=',$userstatus)->where('exist','=','在職')->where('usernum','like','b%')->orderBy('sortstand','asc')->get();
        }
        else
        {
            $users = DB::table('alluserstates')->where('cname','=',Auth::user()->cname)->where('userstatus','=',$userstatus)->where('exist','=','在職')->where('usernum','like','b%')->orderBy('sortstand','asc')->get();
        }  
        foreach ($users as $user) {
            $cnamesforpage[$user->usernum] = $user->cname; 
        }
//////////虛擬帳號/////////////////////////////////////////////
        if (Auth::user()->office=='管理' or Auth::user()->level<>'' ) {
            $users = DB::table('alluserstates')->where('userstatus','=',$userstatus)->where('usernum','like','v%')->orderBy('sortstand','asc')->get();
            foreach ($users as $user) {
                $vcnamesquitforpage[$user->usernum] = $user->cname; 
            }
        }
//////////離職人員/////////////////////////////////////////////
        if (Auth::user()->office=='管理' or Auth::user()->level<>'' ) {
            $users = DB::table('alluserstates')->where('userstatus','=',$userstatus)->where('exist','<>','在職')->where('usernum','like','b%')->orderBy('sortstand','asc')->get();
            foreach ($users as $user) {
                $cnamesquitforpage[$user->usernum] = $user->cname; 
            }
        }
        return response()->json(array($cnamesforpage,$vcnamesquitforpage,$cnamesquitforpage,$checkboxinfo));
    }   



///////////產品選單/////////////////////////////////////////
    public static function chooseproduct()
    {
        $productsselect = [];
        $providerinfo = [];
        $products = importantall::distinct()->select('importantproduct')->where('group','=',Input::get('info'))->where('owner','=',Auth::user()->cname)->GroupBy('importantproduct')->get();
        foreach ($products as $product) {
            $productsselect[] = $product['importantproduct'];
        }
        $providers = DB::table('providerinfos')->where('providerclass','=',Input::get('info'))->where('owner','=',Auth::user()->cname)->orderBy('sortid','asc')->get();
        foreach ($providers as $provider) {
            $providerinfo[$provider->display] = $provider->display;
        }
        return response()->json(array($productsselect,$providerinfo));
    } 



    public static function createvendorajax()
    {
        $post = Input::get('info') ;
        $vendor = '';
        foreach ($post as $vendor ) {
            $vendors = $vendor[0];
        }    
        DB::table('bendon')->where('vendor','=',$vendors)->delete();
        foreach ($post as $vendor ) {
            DB::table('bendon')->insert(array('vendor' => $vendor[0] , 'category'=>$vendor[1] , 'items'=>$vendor[2] , 'price'=>$vendor[3] ,'tel'=>$vendor[4] ));
            $i = '店家已新增!!';
        }
        return response()->json(array($i));
    }         

    public static function orderluajax()
    {
        $post = Input::get('info') ;
        $day = Input::get('day') ;
        $vendor = Input::get('vendor') ;
        foreach ($post as $value) {
            $findstuffs = DB::table('bendon')->where('vendor','=',$vendor)->where('items','=',$value)->get();
            foreach ($findstuffs as $value) {
                DB::table('meal')->insert(array('vendor' => $vendor,'items'=>$value->items ,'price'=>$value->price,'name'=>Auth::user()->cname,'day'=>$day,'sysday'=>$day));
            }
        }
        return response()->json(array('您的餐點已送出,謝謝'));
    }    
    public static function vendorfunajax()
    {
        $post = Input::get('info') ;
        $day = date('Y-m-d');
        $count = DB::table('mealtoday')->where('day','=',$day)->count();
        if ($count==0) {
            DB::table('mealtoday')->insert(array('vendor' => $post,'day'=>$day));
        }
        else
        {
            DB::table('mealtoday')->where('day','=',$day)->update(['vendor' => $post]);
        }    
        return response()->json(array($post));
    }  
    public static function vendorfundelajax()
    {
        $post = Input::get('info') ;
        DB::table('bendon')->where('vendor','=',$post)->update(['enable' => 0]); 
        return response()->json(array($post));
    } 
    public static function orderfunajax()
    {
        $info = Input::get('info') ;
        $day = Input::get('day') ;
        $allx= Input::get('allx') ;
        $x = Input::get('info') ;
        if ($allx==0) {
            foreach ($x as $value) {
                DB::table('meal')->where('name','=',$value)->where('day','=',$day)->update(['pay' => 1]);
                $data = '已付款設定完成!!';
            }
        }
        elseif ($allx==1) {
            foreach ($x as $value) {
                DB::table('meal')->where('name','=',$value)->where('day','=',$day)->update(['pay' => 0]);
                $data = '未付款設定完成!!';
            }
        }
        elseif ($allx==2)
        {
            DB::table('meal')->where('name','=',$info)->where('day','=',$day)->update(['pay' => 1]);
            $data = '已付款設定完成!!';
        }
        elseif ($allx==3) {
            DB::table('meal')->where('name','=',$info)->where('day','=',$day)->update(['pay' => 0]); 
            $data = '未付款設定完成!!';              
        }    
        return response()->json(array($data));
    }     
    public static function stationeryajax()
    {
        $info = Input::get('info');
        $name = Input::get('name');
        $dep = Input::get('dep');
        $tday = Input::get('tday');
        $sysday = date('Y-m-d');
        $context = '';
        $dataf = '您的單據已送出,謝謝';
        foreach ($info as $value) {
            if ($value[0]<>'') {
                DB::table('stationerytable')->insert(array('name' => $name,'dep'=>$dep,'item'=>$value[0],'standard'=>$value[1],'qty'=>$value[2],'sp'=>$value[3],'spdetail'=>$value[4],'spn'=>$value[5],'requestday'=>$tday,'sysday'=>$sysday));
            }
        }
        $formail = DB::table('stationerytable')->where('name','=',$name)->where('requestday','=',$tday)->where('done','=','0')->get();
        foreach ($formail as $value) {
           $context .=  ' 品項 :'.$value->item. ' 規格 :' .$value->standard. ' 數量 :' .$value->qty. ' 品牌 :' . $value->spdetail . '<hr><br>';
        }
        $cname = Auth::user()->cname;
        $to[] = 'abby.lin@bora-corp.com';
        //信件主旨
        $mainsub = "文具申請單";
        //信件的內容
        $data = ['context'=>$context,'cname'=>$cname];
        //寄出信件
        Mail::send('mail.sendstationery', $data, function($message) use ($to,$mainsub) 
        {
          $message->to($to)->subject($mainsub);
        });
        return response()->json(array($dataf));
    }  
    public static function stationerycheckajax()
    {
        $info = Input::get('info');
        $day = Input::get('day');
        $sysday = date('Y-m-d');
        $data = '您的單據已送出,謝謝';
        DB::table('stationerytable')->where("name",'=',$info)->where("requestday",'=',$day)->update(['done'=>'1']);
        return response()->json(array($data));
    }  
    public static function systemcreateajax()
    {
        $accidentdate = Input::get('accidentdate');
        $closedate = Input::get('closedate');
        $closeman = Input::get('closeman');
        $describe = Input::get('describe');
        $how = Input::get('how');
        $howdo = Input::get('howdo');
        $others = Input::get('others');
        $sysday = date('Y-m-d');
        $data = '您的單據已送出,謝謝';
        DB::table('systemerror')->insert(array('accidentdate' => $accidentdate,'closedate'=>$closedate,'closeman'=>$closeman,'describe'=>$describe,'how'=>$how,'howdo'=>$howdo,'others'=>$others,'systemday'=>$sysday));
        return response()->json(array($data));
    }   
    public static function systemupdateajax()
    {
        $accidentdate = Input::get('accidentdate');
        $closedate = Input::get('closedate');
        $closeman = Input::get('closeman');
        $describe = Input::get('describe');
        $how = Input::get('how');
        $howdo = Input::get('howdo');
        $others = Input::get('others');
        $sysday = date('Y-m-d');
        $caseid = Input::get('caseid');
        $data = '您的單據已送出,謝謝';
        DB::table('systemerror')->where('id','=',$caseid)->update(['accidentdate' => $accidentdate,'closedate'=>$closedate,'closeman'=>$closeman,'describe'=>$describe,'how'=>$how,'howdo'=>$howdo,'others'=>$others,'systemday'=>$sysday]);
        return response()->json(array($data));
    }  
    public static function heathycheckajax()
    {
        $search = Input::get('search');
        $checked = Input::get('checked');
        $ISP = Input::get('ISP');
        $FireWall = Input::get('FireWall');
        $Switch = Input::get('Switch');
        $VMHost = Input::get('VMHost');
        $NAS = Input::get('NAS');
        $ARTS = Input::get('ARTS');
        $sysdate = Input::get('sysdate');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $status = [];
        if ($search==1) {
           $infos = DB::table('dailycheck')->where('sysdate',$sysdate)->get();
           foreach ($infos as $info) {
                $status[] = $info->ISP;
                $status[] = $info->FireWall;
                $status[] = $info->Switch;
                $status[] = $info->VMHost;
                $status[] = $info->NAS;
                $status[] = $info->ARTS;
           }
           if (empty($status)) {
               $status = '當日還未檢查';
           }
        }
        else if ($search==2 and $checked==0 ) {
            DB::table('dailycheck')->insert(array('ISP' => $ISP,'FireWall'=>$FireWall,'Switch'=>$Switch,'VMHost'=>$VMHost,'NAS'=>$NAS,'ARTS'=>$ARTS,'sysdate'=>$sysdate));
            $status = '已新增紀錄';
        }
        else if ($search==2 and $checked==1 ) {
            DB::table('dailycheck')->where('sysdate',$sysdate)->update(array('ISP' => $ISP,'FireWall'=>$FireWall,'Switch'=>$Switch,'VMHost'=>$VMHost,'NAS'=>$NAS,'ARTS'=>$ARTS,'sysdate'=>$sysdate));
            $status = '已更新紀錄';
        }
        else if ($search==3) {
            $infos = DB::table('dailycheck')->where('sysdate','>=',$startdate)->where('sysdate','<=',$enddate)->orderBy('sysdate','desc')->get();
            foreach ($infos as $info) {
                $status[] = $info->ISP;
                $status[] = $info->FireWall;
                $status[] = $info->Switch;
                $status[] = $info->VMHost;
                $status[] = $info->NAS;
                $status[] = $info->ARTS;
                $status[] = $info->sysdate;
            }

        }
        return response()->json($status);
    }            
}