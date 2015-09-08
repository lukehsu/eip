<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>權限表</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
  <div class="row">
    <div class="col-md-3">
          <div class="todo">
            <ul>
              <li class="todo-done">

                  <h4 class="todo-name">
                    <strong>報表</strong>
                  </h4>


              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
            </ul>
      </div><!-- /.todo -->
    </div>
    <div class="col-md-3">
          <div class="todo">
            <ul>
              <li class="todo-done">

                  <h4 class="todo-name">
                    <strong>報表</strong>
                  </h4>


              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
            </ul>
      </div><!-- /.todo -->
    </div>
    <div class="col-md-3">
          <div class="todo">
            <ul>
              <li class="todo-done">

                  <h4 class="todo-name">
                    <strong>報表</strong>
                  </h4>


              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
            </ul>
      </div><!-- /.todo -->
    </div>
    <div class="col-md-3">
          <div class="todo">
            <ul>
              <li class="todo-done">

                  <h4 class="todo-name">
                    <strong>報表</strong>
                  </h4>


              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
              <li>
                  <h4 class="todo-name">
                    Meet <strong>Adrian</strong> at <strong>6pm</strong>
                  </h4>
                  Times Square
              </li>
            </ul>
      </div><!-- /.todo -->
    </div> 
  </div>
</div>
<!--javascript-->
<script type="text/javascript"> 
<!-- 
        //平台操作系统 
        var system = { 
            win: false, 
            mac: false, 
            xll: false, 
            ipad:false 
        }; 
        //平台 
        var p = navigator.platform; 
        system.win = p.indexOf("Win") == 0; 
        system.mac = p.indexOf("Mac") == 0; 
        system.x11 = (p == "X11") || (p.indexOf("Linux") == 0); 
        system.ipad = (navigator.userAgent.match(/iPad/i) != null)?true:false; 

        if (system.win || system.mac || system.xll||system.ipad) 
        { 
          ; 
        } 
        else 
        { 
          ; 
        } 
--> 
</script> 
</body>
</html>