<?php 
namespace App\Http\Controllers;
use Request;
use Input;
use App\Http\Requests;
use Response;
use Auth;
use App\user;
use Hash;
use Closure;
class LoginController extends Controller {

    public function login()
    {

      $userdata = array('name' => Input::get('name') , 'password' => Input::get('password') );
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
            $user = User::where('name','=',$userdata['name'] )->count();   
            if ($user==0)
            {
              $user = new User ;
              $user->name = Input::get('name');
              //這邊是AD資訊別搞錯
              $user->cname = $data[0]['name'][0];
              $user->email = $data[0]['mail'][0];
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
      //echo $data[0]['mail'][0];
      //關閉LDAP連結
      ldap_close($ldapconn);
 
      if(Auth::attempt(['name'=>$userdata['name'],'password'=>$userdata['password'] ]))
      {
        return redirect()->intended('boradiary');
        //echo  Auth::user()->name;
      }
      else
      {    
        echo 'bad';
      }
    }

    public function logout()
    {

        Auth::logout();
        return redirect('login');       
    }
}