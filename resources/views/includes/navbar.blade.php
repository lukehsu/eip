<?php
//選單權限資料庫
use App\mainmenudisplay;
$mainitems = mainmenudisplay::where('mainitem','<>','隱藏選單')->where('user','=',Auth::user()->name)->distinct()->orderBy('mainitemid', 'ASC')->get(array('mainitem','mainitemid'));
$menuitem = null;
$today = date('Y-m-d');
$today = strtotime($today) - 3600*24;
$today =  date('Y-m-d',$today);
foreach ($mainitems as $mainitem) 
{
  $menuitem .= '<ul class="nav navbar-nav"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >' ;
  $menuitem .= '<span style="cursor:pointer;">'.$mainitem['mainitem'].'</span>' ;
  $menuitem .= '<strong class="caret"></strong></a><ul id="ul1" class="dropdown-menu">';
  $subitems = mainmenudisplay::where('user','=',Auth::user()->name)->where('mainitem','=',$mainitem['mainitem'])->distinct()->orderBy('subitemid', 'ASC')->get(array('subitem'));
  foreach ($subitems as $subitem) 
  { 
    ////////////
    $subitem2ss = '<ul  class="ul2 ul4">';
    $subitem2s = mainmenudisplay::where('user','=',Auth::user()->name)->where('subitem','=',$subitem['subitem'])->orderBy('subitemid', 'ASC')->orderBy('subitem2id', 'ASC')->get();
    foreach ($subitem2s as $subitem2) {   
      if ($subitem2['subitem2'] <> '保瑞' and $subitem2['subitem2'] <> '聯邦' and $subitem2['subitem2'] <> '業務部每日業績表' and $subitem2['subitem2'] <> '個人業績表(藥品)' and $subitem2['subitem2'] <> '個人業績表(醫院)' and $subitem2['subitem2'] <> '保瑞聯邦' and $subitem2['subitem2'] <> '聯邦聯邦' and $subitem2['subitem2'] <> '經銷商' and $subitem2['subitem2'] <> '保瑞聯邦合計' and $subitem2['subitem2'] <> '重點產品') {
        $subitem2ss .= '<li class="ul3" ><a  href="http://127.0.0.1/eip/public/'.$subitem2['url'].'">'.$subitem2['subitem2'].'</a></li>';
      }
      else
      {  
        $subitem2ss .= '<li class="ul3" ><a  href="http://127.0.0.1/eip/public/'.$subitem2['url']."/".$today.'">'.$subitem2['subitem2'].'</a></li>';  
      }  
    }
    $subitem2ss .= '</ul>';
    //////////
    if ($subitem2['subitem2']=='') {
      $menuitem .=  '<li><a href="http://127.0.0.1/eip/public/'.$subitem2['url'].'">'.$subitem2['subitem'].'</a></li>';
    }
    else
    { 
      $menuitem .=  '<li class="ul1"><a>'.$subitem2['subitem'].'<strong class="caretright"></strong></a>'.$subitem2ss.'</li>';
    }
  }
  $menuitem .=  '</ul></li></ul>';
}
?>
  <style type="text/css">

a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,table,tbody,td,tfoot,th,thead,time,tr,tt,u,ul,var,video
{margin:0;padding:0;border:0;font-size:100%;font-family:'微軟正黑體',arial,helvetica,sans-serif;}ol,ul{list-style:none}blockquote,q{quotes:none}
/*#129793,;font-family:'Roboto Condensed',arial,helvetica,sans-serif*/

  .ul1{
    position: relative;
  }
  .ul2{
    display: none;
    position: absolute;
    top:0;
    left: 100%;
    border-radius: 4px;
    background: #34495e;
    margin-left:9px; 
    width: 140px;
    font-size: 14px;
  }
  .ul3{  
    color: #666;    
    background: #34495e;
    padding: 3px;
    width: 140px;
    border-radius: 4px;
  } 
  .ul3 a{
    display: block;
    color:#e1e4e7;
    border-radius: 4px;
    padding: 6px 9px;
    line-height: 1.42857143;
  }
  .ul4 li > a:hover{
    color: #fff;
    background-color: #1abc9c;
  }  
  #ul1 li > ul:hover{
    color: #fff;
  }  
  .arrow-right {
    display: inline-block;
    margin-left: 12px;  
    border-top: 3px solid transparent;
    border-bottom: 3px solid transparent;
    border-left: 3px solid #666;    
    width: 1px;
    height: 1px;
  }
</style>
<script type="text/javascript">
 $(document).ready(function(){
     $(".ul1").on("click", function(event) {
        event.stopPropagation();
      });   
  });
</script>
<script type="text/javascript">
 $(document).ready(function(){
     $("#ul1 li").click(function() {
        $('.ul2').css('display','none');
        $(this).children('.ul2').css('display','block');
      });   
  });
</script>
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
              logout
            </button>
          </div>
          </ul>
        </div>   
      </nav>
    </div>
  </div>
<script type="text/javascript">
    $(document).ready(function() {
      $("#logindisplays").click(function()
      {  
        window.location.replace("http://127.0.0.1/eip/public/logout");
      });
    });  
</script>