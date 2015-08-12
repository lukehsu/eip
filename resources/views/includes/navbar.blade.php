<?php
//選單權限資料庫
use App\mainmenudisplay;
$mainitems = mainmenudisplay::where('user','=',Auth::user()->name)->distinct()->get(array('mainitem'));
$menuitem = null;
foreach ($mainitems as $mainitem) 
{
  $menuitem .= '<ul class="nav navbar-nav"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' ;
  $menuitem .= $mainitem['mainitem'] ;
  $menuitem .= '<strong class="caret"></strong></a><ul class="dropdown-menu">';
  $subitems = mainmenudisplay::where('user','=',Auth::user()->name)->where('mainitem','=',$mainitem['mainitem'])->get();
  foreach ($subitems as $subitem) 
  {
    $menuitem .=  '<li><a href="'.$subitem['url'].'">'.$subitem['subitem'].'</a></li>';
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
          </button> <a class="navbar-brand" href="dashboard">Bora</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          {!!$menuitem!!}}
          <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" method="POST" action="logout">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <button type="submit" class="btn btn-default">
              登出
            </button>
          </form>
          </ul>
        </div>   
      </nav>
    </div>
  </div>

