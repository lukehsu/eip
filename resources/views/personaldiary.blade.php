<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>保瑞日報表</title>
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
                name: "Lendormin (Bora)",
                y: {!!$MC['LendorminBora']!!},
            },{
                name: "Lendormin (和安)",
                y: {!!$MC['Lendorminann']!!},
            },{
                name: "胃爾康",
                y: {!!$MC['Wilcon']!!},
            }, {
                name: "氯四環素",
                y: {!!$MC['Kso']!!},
            }, {
                name: "帕金寧",
                y: {!!$MC['Bpn']!!},
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
              Name
            </th>
            <th class="text-center">
              Diary
            </th>
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              Budget
            </th>
            <th class="text-center">
              A/B
            </th>
            <th class="text-center">
              A/L
            </th>
            <th class="text-center">
              Product
            </th>
            <th class="text-center">
              Actual
            </th>
            <th class="text-center">
              Budget
            </th>
            <th class="text-center">
              A/B
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr  class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr  class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr  class="active">
             <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr>
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
            </td>
          </tr>
          <tr class="active">
            <td style="display:none">
              Pitavol
            </td>
            <td>
              Pitavol
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
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
              {!!number_format($qtys['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Pitavol)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Pitavol'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Pitavol'])!!}
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
        url: '/eip/public/borareportdate',
        data: { date : $("#datetimepicker").val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
        var len = 0 ;
        //因為長度都一樣所以用medicine計算
        $.each(data.medicine, function (key,data) {len++ ;});
        
        //key 是 key data 是 value 
        $.each(data.qtys, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(2).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $.each(data.medicine, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(3).html(Number(data).toLocaleString('en'));
            };
          };
        });
      
        $.each(data.MA, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(4).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $.each(data.MB, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(5).html(Number(data).toLocaleString('en'));
            };
          };
        });
        $.each(data.MC, function (key,data) {
          for (var i = 1; i <= len ; i++) {          
            if (key==$('tr').eq(i).find('td').eq(0).text().trim()) {
              $('tr').eq(i).find('td').eq(6).html(Number(data).toLocaleString('en') + ' %');
            };
          };
        });
        $('tr').eq(14).find('td').eq(2).html(Number(data.allqty).toLocaleString('en'));
        $('tr').eq(14).find('td').eq(3).html(Number(data.totalsell).toLocaleString('en'));
        $('tr').eq(14).find('td').eq(4).html(Number(data.totalma).toLocaleString('en'));
        $('tr').eq(14).find('td').eq(5).html(Number(data.totalmb).toLocaleString('en'));
        $('tr').eq(14).find('td').eq(6).html(data.totalmc + ' %');
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
                       name: "Lendormin (和安)",
                        y: data.MC["Lendorminann"],
                    }, {
                      name: "胃爾康",
                        y: data.MC["Wilcon"],
                    }, {
                      name: "氯四環素",
                         y: data.MC["Kso"],
                    }, {
                      name: "帕金寧",
                         y: data.MC["Bpn"],
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