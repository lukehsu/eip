<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/placeholdercolor.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/datepickerplacehold.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#chart").css("display","none");
      $("#chart").fadeIn(2000);
      $("#tablezone").css("display","none");
      $("#tablezone").fadeIn(2000);
      var options = 
      {    
        chart: {
            renderTo: 'chart',
            type: 'column'
        },
        title: {
            text: '銷售達成率'
        },
        subtitle: {
            text: '業績表'
        },
        xAxis: {
            type: 'category'
        },
        credits:{
              //隱藏官方連結
             enabled: false
        },
        yAxis: {
            title: {
                text: '百分比'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y:.2f}%</b><br/>'
        },
        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [
            {
                name: "胃爾康",
                y:  0,
            }]
          }]
      };
      $("#chart").highcharts(options);
    });
  </script>
  <style type="text/css">
  .endcolor{
    background-color:#7F8C8D;
    color: #FFFFFF;
  }
  #mwt_mwt_slider_scroll
  {
    top: 30px;
    left:-1280px;
    width:1280px;  
    position:fixed;
    z-index:9999;
  }
  #mwt_slider_content{
    background:#3c5a98;
    text-align:center;
    padding-top:20px;
  }
  #mwt_fb_tab {
    position:absolute;
    top:20px;
    right:-24px;
    width:24px;
    background:#3c5a98;
    color:#ffffff;
    font-family:Arial, Helvetica, sans-serif; 
    text-align:center;
    padding:9px 0;
    -moz-border-radius-topright:10px;
    -moz-border-radius-bottomright:10px;
    -webkit-border-top-right-radius:10px;
    -webkit-border-bottom-right-radius:10px;  
  }
  #mwt_fb_tab span {
    display:block;
    height:42px;
    padding:10px 0;
    line-height:12px;
    text-transform:uppercase;
    font-size:30px;
  }
  </style>
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
  <br> 
  <div class="row">
  <div id="mwt_mwt_slider_scroll">
     <div id="mwt_fb_tab">
      <span> > </span>
    </div>
    <div id="mwt_slider_content">
      <button id="ff">123</button>
      
    </div>
</div>
    <div class="col-md-12" id='chart'></div>
  </div>
  <br>
  <br>
  <div class="row">
    <div class="col-md-12" id="tablezone">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="text-center" style="display:none">

            </th>
            <th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid; ">
              
            </th>
            <!--th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid">
              Diary
            </th-->
            <th class="text-center" colspan="3" style="background-color:#E0E0E0;border:#FFFFFF 3px solid">
              MTD
            </th>
            <th class="text-center" colspan="3" style="background-color:#BDC3C7;border:#FFFFFF 3px solid">
              YTD
            </th>
          </tr>
          <tr>
            <th class="text-center" id='username' style="display:none">
   
            </th>
            <th class="text-center">
              Product
            </th>
            <!--th class="text-center">
              Amount
            </th-->
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <!--th class="text-center">
              A / L
            </th-->
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <!--th class="text-center">
              A / L
            </th-->
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
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
          $("#datetimepicker").change(function(){
            window.location.replace("http://127.0.0.1/eip/public/personalmedicinediary/"+ $('#username').html().trim() + '/' + $("#datetimepicker").val());
          }); 
        } 
        else 
        { 
          $("#datetimepicker").blur(function(){
            window.location.replace("http://127.0.0.1/eip/public/personalmedicinediary/"+ $('#username').html().trim() + '/' + $("#datetimepicker").val());
          }); 
        } 
--> 
</script> 
<script type="text/javascript">
  $(function() {
    var check = 0;
    $('#mwt_fb_tab').click(function() {
      if (check==0) {
        $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '1280px'}, 200);
        check = 1;
      }
      else
      {
       $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '-2px'}, 200); 
       check = 0;
      }  
    });
    $('#ff').click(function() {
      $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '-2px'}, 200);
    });
  });
    </script>
</body>
</html>