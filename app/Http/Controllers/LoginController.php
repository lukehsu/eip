<?php 
namespace App\Http\Controllers;
use Request;
use Input;
use App\Http\Requests;
use Response;
use Auth;
use App\User;
use App\itticket;
use App\useracces;
use Hash;
use Closure;
use App\Http\Controllers\FlowController;
class LoginController extends Controller {

    public function login()
    {

      $userdata = array('name' => Input::get('name') , 'password' => Input::get('password') );
      if ($userdata['name']=='bobby') {
        $userdata['name'] = 'b0001';
        if(Auth::attempt(['name'=>$userdata['name'],'password'=>$userdata['password'] ]))
        {
          //return redirect()->intended('dashboard');
          return  response()->json(array('good'));
        }
      }
      else
      {  
        $users = User::where('name','=',Input::get('name'))->where('ad','=',1)->count();
        if ($users==1) {
          if(Auth::attempt(['name'=>$userdata['name'],'password'=>$userdata['password'] ]))
          {
            return  response()->json(array('good'));
          }  
        }
        $domain = 'bora.corp'; //設定網域名稱
        $dn="dc=bora,dc=corp";
        $ldap_server = '192.168.1.225';
        $user = $userdata['name']; //設定欲認證的帳號名稱
        $password = $userdata['password']; //設定欲認證的帳號密碼
        // 使用 ldap bind 
        $ldaprdn = $user . '@' . $domain; 
        // ldap rdn or dn 
        $ldappass = $password; // 設定密碼
        // 連接至網域控制站
        $ldapconn = ldap_connect($ldap_server) or die("無法連接至 $domain");
 
        // 如果要特別指定某一部網域主控站(DC)來作認證則上面改寫為
        //$ldapconn = ldap_connect('dc.domain.com) or die("無法連接至 dc.domain.com"); 
        // 或 
        // $ldapconn = ldap_connect('dc2.domain.com)or die("無法連接至 dc2.domain.com"); 
        //以下兩行務必加上，否則 Windows AD 無法在不指定 OU 下，作搜尋的動作
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        //下面$result = @ldap_search($ldapconn, $dn, $filter,$justtheseattributes)可以撈少一點的資訓
        //$justtheseattributes = array("sn");
        if ($ldapconn) 
        { 
          // binding to ldap server
          $ldapbind = ldap_bind($ldapconn, $ldaprdn, $password);     
          //$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);     
          //$ldapbind = ldap_bind($ldapconn);     
          // verify binding     
          if ($ldapbind) 
          {         
            $filter = "(sAMAccountName=$user)";        
            $result = @ldap_search($ldapconn, $dn, $filter);        
            if($result==false) 
            { 
              echo "認證失敗(找不到 $user)";      
            }   
            else
            {                      
              //取出帳號的所有資訊    
              $entries = ldap_get_entries($ldapconn, $result);
              $data = ldap_get_entries( $ldapconn, $result );
              //print_r($data);
              $user = User::where('name','=',$userdata['name'] )->count();   
              if ($user==0)
              {
                $user = new User ;
                $user->name = Input::get('name');
                $user->level = '';
                //這邊的陣列是AD資訊別搞錯
                $user->cname = $data[0]['name'][0];
                $user->email = $data[0]['mail'][0];
                $user->dep = $data[0]['department'][0];
                $user->password = Hash::Make(Input::get('password'));
                $user->save();
                
                $access = new useracces ;
                $access->user = Input::get('name');
                $access->access = '資訊需求單';
                $access->save();
                $access = new useracces ;
                $access->user = Input::get('name');
                $access->access = 'E-mail';
                $access->save();

              }
              else
              {
                $user = User::where('name','=',Input::get('name'))->first(); 
                $user->password = Hash::Make(Input::get('password'));
                $user->save();
              }
            //for($i = 0; $i <= $data ["count"]; $i ++)
            //{
              //for($j = 0; $j <= $data [$i] ["count"]; $j ++) 
              //{
                  //echo "[$i:$j]=".$data [$i] [$j] . ": " . $data [$i] [$data [$i] [$j]] [0] . "\n";
              //}
            //}        
            }    
          } 
        }  
        else
        {         
          echo "認證失敗";     
        } 
        //撈姓名出來
        //echo $data[0]['physicaldeliveryofficename'][0];
        //關閉LDAP連結
        ldap_close($ldapconn);
        if(Auth::attempt(['name'=>$userdata['name'],'password'=>$userdata['password'] ]))
        {
          //return redirect()->intended('dashboard');
          return  response()->json(array('good'));
        }
        else
        {    
          echo 'bad';
        }
      }
    }

    public function dashboard()
    {
      $userinfos = User::where('name','=',Auth::user()->name)->get();      
      foreach ($userinfos as $userinfo) {
        $cname = $userinfo->cname;
        $dep = $userinfo->dep;  
        $level = $userinfo->level;    
      } 
      //GM 專用判斷
      if (Auth::user()->name == 'b0001') {
        $level = 'GM';
        $itservice = null;
        $ittickets = itticket::where('process','=',$level)->orwhere('process','=','manager')->where('dep','=',$dep)->get();
      }
      elseif (Auth::user()->name=='b0002') 
      {
        $level = 'finish';
        $itservice = null;
        $ittickets = itticket::where('process','=','manager')->where('dep','=','採購部')->get();
      }
      elseif ($dep=='資訊部' and $level == 'manager' ) 
      {
        $level = 'finish';
        $itservice = null;
        $ittickets = itticket::where('process','=',$level)->orwhere('process','=','manager')->where('dep','=',$dep)->get();
      }
      elseif ($dep=='資訊部') 
      {
        $level = 'finish';
        $itservice = null;
        $ittickets = itticket::where('process','=',$level)->get();       
      }
      else
      {  
        $itservice = null;
        $ittickets = itticket::where('dep','=',$dep)->where('process','=',$level)->get();
      }  
      $i = 1;
      foreach ($ittickets as $itticket) {
        $ordernumber = $itticket->ordernumber;
        $name = $itticket->name;
        $dep = $itticket->dep; 
        $date = $itticket->date;
        $description = $itticket->description;
        $description = mb_substr($description,0,8,"utf-8")."......";
        $items = $itticket->items;
        $items = mb_substr($items,0,6,"utf-8")."......";
        $itservice .= '<div class="row" style="height:30px"><div class="col-md-1"><label id="chkgroup'.$i.'" class="checkbox"><input name="itbox" type="checkbox" value="1" id="checkbox'.$i.'" data-toggle="checkbox"></label></div><a href="http://127.0.0.1/eip/public/'.$ordernumber.'/it"><div class="col-md-2 pa">'.$date.'</div><div class="col-md-2 pa">'.$dep.'</div><div id="name'.$i.'" class="col-md-2 pa">'.$name.'</div><div class="col-md-2 pa">'.$items.'</div><div class="col-md-3 pa">'.$description.'<input id="ordernumber'.$i.'" type="hidden" value="'.$ordernumber.'"></div></a></div>' ;                     
        $i = $i + 1 ;
      } 

      if ($i<>0) 
      {
        $i = $i-1;
      }

      return view('dashboard',['itservice'=>$itservice,'icount'=>$i]);
    }

    public function logout()
    {
      Auth::logout();
      return redirect('login');       
    }

    public function test()
    {
      $c = new FlowController;
      $d = array('1','2');
      echo $c->tt($d);
      //echo 'c';
    }


    public function signok()
    {
      $user = User::where('name','=',Input::get('name'))->count();   
      if ($user==0)
      {
        $user = new User ;
        $user->name = Input::get('name');
        $user->password = Hash::Make(Input::get('password'));
        $user->ad = 1;
        $user->save();
        return  response()->json(array('good'));
      }
      else
      {
        echo 'bad';
      } 
    }
}