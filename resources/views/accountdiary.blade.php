<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="../public/bootstrap331/dist/js/highcharts.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Lepax5
            </td>
            <td>
              Lepax5
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
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
              ''
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--javascript-->
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
  $("document").ready(function(){
    $("#datetimepicker").change(function(){
      $.ajax({
        type: 'POST',
        url: '/eip/public/accountreportdate',
        data: { date : $("#datetimepicker").val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
        //因為最上面多一來所已開始預設為1
        var len = 1 ;
        //因為長度都一樣所以用medicine計算
        $.each(data.medicine, function (key,data) {len++ ;});
        
        //key 是 key data 是 value 
        $.each(data.medicine, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(2).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $.each(data.MA, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(3).html(Number(data).toLocaleString('en'));
            };
          };
        });
      
        $.each(data.MB, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(4).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $.each(data.MC, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(5).html(Number(data).toLocaleString('en') + ' %');
            };
          };
        });
        $.each(data.medicinealltime , function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(7).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $('tr').eq(11).find('td').eq(2).html(Number(data.totalsell).toLocaleString('en'));
        $('tr').eq(11).find('td').eq(3).html(Number(data.totalma).toLocaleString('en'));
        $('tr').eq(11).find('td').eq(4).html(Number(data.totalmb).toLocaleString('en'));
        $('tr').eq(11).find('td').eq(5).html(data.totalmc + ' %');
        $('tr').eq(11).find('td').eq(7).html(Number(data.medicinealltimetotla).toLocaleString('en'));
//我懶得縮排了      
                    //console.log(data.monthstart);
                    $("#chart").css("display","none");
                    $("#chart").fadeIn(2000);
                    $("#tablezone").css("display","none");
                    $("#tablezone").fadeIn(2000);
                    var options = 
                    {    
                      chart: 
                    {
                      renderTo: 'chart',
                      type: 'column'
                    },
                      title: {
                      text: '銷售達成率'
                    },
                      subtitle: {
                      text: '日業績表'
                    },
                      xAxis: 
                    {
                      type: 'category'
                    },
                      credits:{
                      //隱藏官方連結
                      enabled: false
                    },
                      yAxis: 
                    {
                      title: 
                      {
                        text: '百分比'
                      }
                    },
                      legend: 
                    {
                      enabled: false
                    },
                      plotOptions: 
                    {
                      series: 
                      {
                          borderWidth: 0,
                          dataLabels: 
                          {
                            enabled: true,
                            format: '{point.y:.1f}%'
                          }
                      }
                    },
                    tooltip: 
                    {
                      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                      pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y:.2f}%</b><br/>'
                    },
                    series: 
                    [{
                        name: "Brands",
                        colorByPoint: true,
                        data: 
                    [{
                        name: "Pitavol",
                        y: data.MC["Pitavol"],
                    }, {
                        name: "Denset",
                        y: data.MC["Denset"],
                    }, {
                        name: "Lepax 10mg",
                        y: data.MC["Lepax10"],
                    }, {
                        name: "Lepax 5mg",
                        y: data.MC["Lepax5"],
                    }, {
                        name: "Lexapro",
                        y: data.MC["Lexapro"],
                    }, {
                        name: "Ebixa",
                        y: data.MC["Ebixa"],
                    }, {
                       name: "Denset",
                        y: data.MC["Denset"],
                    }, {
                        name: "Lendormin (Bora)",
                        y: data.MC["LendorminBora"],
                    }, {
                      name: "Others",
                        y: data.MC["Others"],
                    }]
                    }]
                  };
                  $("#chart").highcharts(options);
                },
                  error: function(xhr, type)
                  {
                    alert('Ajax error!')
                  }
      });  
    });
  });
</script>
</body>
</html>