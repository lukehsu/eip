<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
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
            renderTo: 'chart',
            type: 'column'
        },
        title: {
            text: '銷售達成率'
        },
        subtitle: {
            text: '日業績表'
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
    <div class="col-md-1">
        <input  type="text" id="datetimepicker"  class="dateinput" value="{!!$todaydate!!}">
        <button id="changedate" type="button" class="btn btn-xs btn-info">選擇其他日期</button>
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
            <th class="text-center" style="display:none">
              Itemno
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
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
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
            <td class='text-right'>
              {!!$ML['Pitavol']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Pitavol']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Pitavol']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Denset
            </td>
            <td>
              Denset
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
            <td class='text-right'>
              {!!$ML['Denset']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Denset'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Denset'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Denset']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Denset']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Lepax10
            </td>
            <td>
              Lepax 10mg
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Lepax10']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['Lepax10']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Lepax10']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Lepax10']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Lepax5
            </td>
            <td>
              Lepax 5mg
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Lepax5']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['Lepax5']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Lepax5']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Lepax5']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Lexapro
            </td>
            <td>
              Lexapro
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Lexapro']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['Lexapro']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Lexapro']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Lexapro']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Ebixa
            </td>
            <td>
              Ebixa
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Ebixa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Ebixa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Ebixa'])!!}
            </td>
              <td class='text-right'>
              {!!$MC['Ebixa']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['Ebixa']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Ebixa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Ebixa'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Ebixa']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Ebixa']!!} %
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Deanxit
            </td>
            <td>
              Deanxit
            </td>
            <td class='text-right'>
              {!!number_format($medicine['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Deanxit'])!!}
            </td>
              <td class='text-right'>
              {!!$MC['Deanxit']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['Deanxit']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Deanxit']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Deanxit']!!} %
            </td>
          </tr>
          <tr  class="active">
            <td style="display:none">
              LendorminBora
            </td>
            <td>
              Lendormin
            </td>
            <td class='text-right'>
              {!!number_format($medicine['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['LendorminBora']!!} %
            </td>
            <td class='text-right'>
              {!!$ML['LendorminBora']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['LendorminBora']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['LendorminBora']!!} %
            </td>
          </tr>
          <tr >
            <td style="display:none">
              Others
            </td>
            <td>
              Others
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
            <td class='text-right'>
              {!!$ML['Others']!!} %
            </td>
            <td class='text-right'>
              {!!number_format($MAA['Others'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MBB['Others'])!!}
            </td>
            <td class='text-right'>
              {!!$MCC['Others']!!} %
            </td>
            <td class='text-right'>
              {!!$MLL['Others']!!} %
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Total
            </td>
            <td>
              Total
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
            <td class='text-right'>
              {!!number_format($totalml)!!} %
            </td>
            <td class='text-right'>
              {!!number_format($totalmaa)!!}
            </td>
            <td class='text-right'>
              {!!number_format($totalmbb)!!}
            </td>
            <td class='text-right'>
              {!!$totalmcc!!} %
            </td>
            <td class='text-right'>
              {!!number_format($totalmll)!!} %
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--javascript-->
<script type="text/javascript" src="../bootstrap331/dist/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
  $('#datetimepicker').datetimepicker({
      language:  'en',
      format: 'yyyy-mm-dd',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
  });
</script>
<script type="text/javascript">
    $("#changedate").click(function(){
    $('#datetimepicker').focus();
    });
</script>
<script type="text/javascript">
    $("#changedate").click(function(){
    $('#datetimepicker').focus();
    });
</script>
<script type="text/javascript">
    $("#datetimepicker").change(function(){
      window.location.replace("http://127.0.0.1/eip/public/accountdiary/" + $("#datetimepicker").val());
    });
</script>
</body>
</html>