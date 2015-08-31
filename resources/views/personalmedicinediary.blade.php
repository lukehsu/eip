<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/flat-ui.css">
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/placeholdercolor.css">
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/datepickerplacehold.css">
  <script type="text/javascript" src="./../../bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./../../bootstrap331/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="./../../bootstrap331/dist/js/highcharts.js"></script>
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
            text: $('#username').html().trim() + {!!$chardate!!} +'業績表'
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
            data: [{
                name: "Pitavol",
                y: {!!$MC['Pitavol']!!},
            }, {
                name: "Denset",
                y: {!!$MC['Denset']!!},
            }, {
                name: "Lepax 10mg",
                y: {!!$MC['Lepax10']!!},
            }, {
                name: "Lepax 5mg",
                y: {!!$MC['Lepax5']!!},
            }, {
                name: "Lexapro",
                y: {!!$MC['Lexapro']!!},
            }, {
                name: "Ebixa",
                y: {!!$MC['Ebixa']!!},
            }, {
                name: "Denset",
                y: {!!$MC['Denset']!!},
            }, {
                name: "Lendormin",
                y: {!!$MC['LendorminBora']!!},
            },{
                name: "Others",
                y: {!!$MC['Others']!!},
            }]
          }]
      };
      $("#chart").highcharts(options);
    });
  </script>
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
            <th class="text-center" style="border:#FFFFFF 1px solid; ">
             
            </th>
            <th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid">
              Diary
            </th>
            <th class="text-center" colspan="4" style="background-color:#E0E0E0;border:#FFFFFF 3px solid">
              MTD
            </th>
            <th class="text-center" colspan="4" style="background-color:#BDC3C7;border:#FFFFFF 3px solid">
              YTD
            </th>
          </tr>
          <tr>
            <th class="text-center" id='username' style="display:none">
              {!!$user!!}
            </th>
            <th class="text-center">
              Product
            </th>
            <th class="text-center">
              Amount
            </th>
            <th class="text-center">
              Month Actual
            </th>
            <th class="text-center">
              Month Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <th class="text-center">
              A / L
            </th>
            <th class="text-center">
              Month Actual
            </th>
            <th class="text-center">
              Month Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <th class="text-center">
              A / L
            </th>
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
    $("#datetimepicker").change(function(){
        window.location.replace("http://127.0.0.1/eip/public/personalmedicinediary/"+ $('#username').html().trim() + '/' + $("#datetimepicker").val());
    });
</script>
</body>
</html>