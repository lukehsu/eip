<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>保瑞日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="../bootstrap331/dist/js/highcharts.js"></script>
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
        <input  type="text" id="datetimepicker"  class="dateinput" name='ag' value="{!!$todaydate!!}">
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
              Itemno
            </th>
            <th class="text-center">
              Product
            </th>
            <th class="text-center">
              Quantity
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
              Achievement %
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
          </tr>
          <tr class="active">
            <td style="display:none">
              Denset
            </td>
            <td>
              Denset
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Denset'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Denset)!!}
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
              Lepax10
            </td>
            <td>
              Lepax 10mg
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Lepax10'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Lepax10)!!}
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
          </tr>
          <tr class="active">
            <td style="display:none">
              Lepax5
            </td>
            <td>
              Lepax5
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Lepax5'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Lepax5)!!}
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
          </tr>
          <tr>
            <td style="display:none">
              Lexapro
            </td>
            <td>
              Lexapro
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Lexapro'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Lexapro)!!}
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
          </tr>
          <tr class="active">
            <td style="display:none">
              Ebixa
            </td>
            <td>
              Ebixa
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Ebixa'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Ebixa)!!}
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
          </tr>
          <tr>
            <td style="display:none">
              Deanxit
            </td>
            <td>
              Deanxit
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Deanxit'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Deanxit)!!}
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
          </tr>
          <tr  class="active">
            <td style="display:none">
              LendorminBora
            </td>
            <td>
              Lendormin (Bora)
            </td>
            <td class='text-right'>
              {!!number_format($qtys['LendorminBora'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($LendorminBora)!!}
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
          </tr>
          <tr>
            <td style="display:none">
              Lendorminann
            </td>
            <td>
              Lendormin (和安)
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Lendorminann'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Lendorminann)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Lendorminann'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Lendorminann'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Lendorminann']!!} %
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
              {!!number_format($Wilcon)!!}
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
              {!!number_format($Kso)!!}
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
              Bpn
            </td>
            <td>
              帕金寧
            </td>
            <td class='text-right'>
              {!!number_format($qtys['Bpn'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($Bpn)!!}
            </td>
            <td class='text-right'>
              {!!number_format($MA['Bpn'])!!}
            </td>
            <td class='text-right'>
              {!!number_format($MB['Bpn'])!!}
            </td>
            <td class='text-right'>
              {!!$MC['Bpn']!!} %
            </td>
          </tr>
          <tr>
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
              {!!number_format($Others)!!}
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
          <tr class="active">
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
        $('tr').eq(14).find('td').eq(6).html((data.totalmc / 12).toFixed(0) + ' %');
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