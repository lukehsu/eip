<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <link rel="stylesheet"  href="../bootstrap331/dist/css/datepickerplacehold.css">
  <script src="../bootstrap331/dist/js/highcharts.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#chart").css("display","none");
      $("#chart").fadeIn(2000);
      $("#tablezone").css("display","none");
      $("#tablezone").fadeIn(2000);
      var options = 
      {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Monthly Average Temperature'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (%)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: {!!$allname!!},
            data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 0, 0, 0, 0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 0, 0, 0, 0]
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
  .subcolor{
    background-color:#E0E0E0;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
  <div class="row">
    <div class="col-md-3">
        <input type="date" id="datetimepicker" style="background-color:#95A5A6;cursor:pointer;" class="dateinput" placeholder="日期選擇">
        <!--button id="changedate" type="button" class="btn btn-xs btn-info">選擇其他日期</button-->
    </div>
  </div>
  <br>
  <div class="row">
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
            <th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid">
             <span class="fui-calendar"></span>&nbsp;&nbsp;{!!$today!!}&nbsp;&nbsp;
            </th>
            <th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid">
              Diary
            </th>
            <th class="text-center" colspan="3" style="background-color:#E0E0E0;border:#FFFFFF 3px solid">
              MTD
            </th>
            <th class="text-center" colspan="3" style="background-color:#BDC3C7;border:#FFFFFF 3px solid">
              YTD
            </th>
          </tr>
          <tr>
            <th class="text-center" style="display:none">
              Itemno
            </th>
            <th class="text-center">
              Name
            </th>
            <th class="text-center">
              Amount
            </th>
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
            {!!$form!!}
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
            window.location.replace("http://127.0.0.1/eip/public/personaldiary/" + $("#datetimepicker").val());
          }); 
        } 
        else 
        { 
          $("#datetimepicker").blur(function(){
            window.location.replace("http://127.0.0.1/eip/public/personaldiary/" + $("#datetimepicker").val());
          }); 
        } 
--> 
</script> 
</body>
</html>