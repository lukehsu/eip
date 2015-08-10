
  <div class="row">
    <div class="col-md-12">
      <nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="navbar-header">  
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
             <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button> <a class="navbar-brand" href="#">Bora</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">報表相關<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="#">當日業績表</a>
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li class="divider">
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li class="divider">
                </li>
                <li>
                  <a href="#">X</a>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" method="POST" action="login">
            <div class="form-group">
              <input type="text" id="name" name="name" class="form-control" />
              <input type="text" id="password" name="password"  class="form-control" />
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            </div> 
            <button type="submit" class="btn btn-default">
              登入
            </button>
          </form>
          </ul>
        </div>   
      </nav>
    </div>
  </div>

