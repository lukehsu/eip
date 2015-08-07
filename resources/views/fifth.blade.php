<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>業務部日報表</title>
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/flat-ui.css">
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script type="text/javascript" src="../public/bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script type="text/javascript">
    $(function () {
    // Create the chart
      $('#test').highcharts({
        chart: {
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
                y: 80.33,
            }, {
                name: "Denset",
                y: 24.03,
            }, {
                name: "Lepax 10mg",
                y: 10.38,
            }, {
                name: "Lepax 5mg",
                y: 4.77,
            }, {
                name: "Lexapro",
                y: 0.91,
            }, {
                name: "Ebixa",
                y: 0.2,
            }, {
                name: "Lendormin (Bora)",
                y: 4.77,
            },{
                name: "Lendormin (和安)",
                y: 4.77,
            },{
                name: "聯邦產品1",
                y: 4.77,
            }, {
                name: "聯邦產品2",
                y: 4.77,
            }, {
                name: "聯邦產品3",
                y: 4.77,
            }, { 
                name: "聯邦產品4",
                y: 4.77,
            }, {
                name: "Others",
                y: 4.77,
            }]
          }]
      });
    });
  </script>
</head>
<body>
<div class="container-fluid">
  @include('navbar')
  <div class="row">
    <div class="col-md-2">
        <input  type="text" id="datetimepicker"  class="dateinput">
        <button id="changedate" type="button" class="btn btn-xs btn-info">選擇其他日期</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" id='test'></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="text-center">
            </th>
            <th bgcolor="" class="text-center">
              Daily
            </th>
            <th  colspan="4"  bgcolor="#ECF0F1" class="text-center">
              MTD
            </th>
            <th  colspan="4"  bgcolor="#e9e9e9" class="text-center">
              YTD
            </th>
          </tr>
          <tr>
            <th>
              Product
            </th>
            <th class="text-center">
              當日業績
            </th>
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              budget
            </th>
            <th class="text-center">
              A/B
            </th>
            <th class="text-center">
              A/L
            </th>
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              budget
            </th>
            <th class="text-center">
              A/B
            </th>
            <th class="text-center">
              A/L
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              Denset
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              Lepax 10mg
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              Lepax 5mg
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              Lexapro
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              Ebixa
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
              <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              Lendormin (Bora)
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              Lendormin (和安)
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              聯邦產品1
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              聯邦產品2
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              聯邦產品3
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              聯邦產品4
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              1
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr>
            <td>
              Others
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>
              
            </td>
          </tr>
          <tr class="active">
            <td>
              Total
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MT['Deanxit'])!!}
            </td>
            <td class='text-right'>
              
            </td>
            <td class='text-right'>      
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--javascript-->
<script type="text/javascript" src="../public/bootstrap331/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../public/bootstrap331/dist/js/bootstrap-datetimepicker.js"></script>
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
    $("#datetimepicker").change(function(){
      alert("123");
    });
</script>
</body>
</html>