<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>聯邦日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <link rel="stylesheet"  href="../bootstrap331/dist/css/datepickerplacehold.css">
  <script src="../bootstrap331/dist/js/highcharts.js"></script>
  <script src="../bootstrap331/dist/js/html2canvas.js"></script>
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
            text: {!!$chardate!!} + '業績表'
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
                name: "Pitavol （經銷商）",
                y: {!!$MC['Pitavol']!!},
            }, {
                name: "Denset （經銷商)",
                y: {!!$MC['Denset']!!},
            }, {
                name: "Brexa (經銷商）",
                y: {!!$MC['Brexa']!!},
            },{
                name: "胃爾康",
                y: {!!$MC['Wilcon']!!},
            }, {
                name: "氯四環素",
                y: {!!$MC['Kso']!!},
            }, {
                name: "優平",
                y: {!!$MC['Upi']!!},
            }, { 
                name: "優福",
                y: {!!$MC['Ufo']!!},
            }, { 
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
<div class="container-fluid" id="ourdiv" style="background-color:#FFFFFF;width:512px;height:900;">
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
              Itemno
            </th>
            <th class="text-center">
              Product
            </th>
            <th class="text-center">
              QTY.
            </th>
            <th class="text-center">
              AMT
            </th>
            <th class="text-center">
              ACT-MON
            </th>
            <th class="text-center">
              Budget-MON
            </th>
            <th class="text-center">
              ACH.%
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol<br>經銷商
            </td>
            <td class='text-right' id="q1">
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Pitavol']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Denset
            </td>
            <td>
              Denset<br>經銷商
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Denset'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Denset'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Denset'])!!}
            </td>
              <td class='text-right'>
              {!!number_format($MB['Denset'])!!}
            </td>
              <td class='text-right'>
              {!!$MC['Denset']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Brexa
            </td>
            <td>
              Brexa<br>經銷商
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Brexa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Brexa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Brexa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Brexa'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Brexa']!!} %
            </td>
          </tr>
          <tr  class="active">
            <td style="display:none">
              Wilcon
            </td>
            <td>
              胃爾康
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Wilcon'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Wilcon'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Wilcon'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Wilcon'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Wilcon']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Kso
            </td>
            <td>
              氯四環素
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Kso'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Kso'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Kso'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Kso'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Kso']!!} %
            </td>
          </tr>
          <tr  class="active">
            <td style="display:none">
              Upi
            </td>
            <td>
              優達平
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Upi'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Upi'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Upi'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Upi'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Upi']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Ufo
            </td>
            <td>
              優福
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Ufo'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Ufo'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Ufo'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Ufo'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Ufo']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Others
            </td>
            <td>
              Others
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Others'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Others'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Others'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Others'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Others']!!} %
            </td>
          </tr>
          <tr >
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Total
            </td>
            <td class='text-right'>
              {!!number_format($allqty)!!}
            </td>
            <td class='text-right'>
              {!!number_format($totalsell)!!}
            </td>
            <td class='text-right'>
              {!!number_format($totalma,0)!!}
            </td>
            <td class='text-right'>
              {!!number_format($totalmb,0)!!}
            </td>
            <td class='text-right'>
              {!!$totalmc!!} %
            </td>
          </tr>
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
            window.location.replace("http://127.0.0.1/eip/public/unidiary/" + $("#datetimepicker").val());
          }); 
        } 
        else 
        { 
          $("#datetimepicker").blur(function(){
            window.location.replace("http://127.0.0.1/eip/public/unidiary/" + $("#datetimepicker").val());
          }); 
        } 
--> 
</script> 
<script type="text/javascript">
  $(function(){
    setTimeout(function(){
      $.getScript("../bootstrap331/dist/js/pic.js");
    },9000)
  })
</script>
</body>
</html>