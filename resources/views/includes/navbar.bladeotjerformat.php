<?php
//選單權限資料庫
use App\mainmenudisplay;
$mainitems = mainmenudisplay::where('user','=',Auth::user()->name)->distinct()->orderBy('mainitemid', 'ASC')->get(array('mainitem','mainitemid'));
$menuitem = null;
$today = date('Y-m-d');
foreach ($mainitems as $mainitem) 
{

  $menuitem .= '<ul class="nav navbar-nav"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >' ;
  $menuitem .= '<span style="cursor:pointer;">'.$mainitem['mainitem'].'</span>' ;
  $menuitem .= '<strong class="caret"></strong></a><ul class="dropdown-menu">';
  $subitems = mainmenudisplay::where('user','=',Auth::user()->name)->where('mainitem','=',$mainitem['mainitem'])->orderBy('subitemid', 'ASC')->get();
  foreach ($subitems as $subitem) 
  {
    if ($mainitem['mainitemid']=='2')
    {
    $today = '' ;
    $menuitem .=  '<li><a href="http://127.0.0.1/eip/public/'.$subitem['url'].'/'.$today.'">'.$subitem['subitem'].'</a></li>';
    }
    else
    {
    $menuitem .=  '<li><a href="http://127.0.0.1/eip/public/'.$subitem['url'].'/'.$today.'">'.$subitem['subitem'].'</a></li>';
    }
  }

  $menuitem .=  '</ul></li></ul>';
}
?>
  <div class="row">
    <div class="col-md-12">
      <nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="navbar-header">  
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
             <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button> <a class="navbar-brand" href="http://127.0.0.1/eip/public/dashboard">Bora</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          {!!$menuitem!!}
          <ul class="nav navbar-nav navbar-right">
          <div class="navbar-form " >
            <button type="submit" id="logindisplays" class="btn btn-default">
              登入
            </button>
          </div>
          </ul>
        </div>   
      </nav>
    </div>
  </div>
    <div class="login-form col-md-2 col-md-offset-10" style="Z-index:9999;display:none" id="logindisplay" >
      <div class="form-group">
        <input type="text" class="form-control login-field" value="" placeholder="Account" id="login-name" />
        <label class="login-field-icon fui-user" for="login-name"></label>
      </div>
      <div class="form-group">
        <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
        <label class="login-field-icon fui-lock" for="login-pass"></label>
      </div>
      <a class="btn btn-primary btn-lg btn-block" id="checklogin">Login</a>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
      $("#logindisplays").click(function()
      {  
        $("#logindisplay").fadeIn(500);
      });
    });  
</script>







