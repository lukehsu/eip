<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>聯邦日報表</title>
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
                name: "Pitavol （經銷商）",
                y: 0,
            }, {
                name: "Denset （經銷商)",
                y: 0,
            }, {
                name: "Brexa (經銷商）",
                y: 0,
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
              Pitavol （經銷商）
            </td>
            <td class='text-right' id="q1">
              0
            </td>
            <td class='text-right'>
              0
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
              Denset （經銷商）
            </td>
            <td class='text-right'>
              0
            </td>
            <td class='text-right'>
              0
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
              Brexa (經銷商）
            </td>
            <td class='text-right'>
              0
            </td>
            <td class='text-right'>
              0
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
        url: '/eip/public/unireportdate',
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
        $('tr').eq(9).find('td').eq(2).html(Number(data.allqty).toLocaleString('en'));
        $('tr').eq(9).find('td').eq(3).html(Number(data.totalsell).toLocaleString('en'));
        $('tr').eq(9).find('td').eq(4).html(Number(data.totalma).toLocaleString('en'));
        $('tr').eq(9).find('td').eq(5).html(Number(data.totalmb).toLocaleString('en'));
        $('tr').eq(9).find('td').eq(6).html(data.totalmc + ' %');
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
                        name: "Pitavol （經銷商）",
                        y: 0,
                    }, {
                        name: "Denset （經銷商)",
                        y: 0,
                    }, {
                        name: "Brexa (經銷商）",
                        y: 0,
                    },{
                        name: "胃爾康",
                        y: data.MC['Wilcon'],
                    }, {
                        name: "氯四環素",
                        y: data.MC['Kso'],
                    }, {
                      name: "優平",
                        y: data.MC['Upi'],
                    }, { 
                      name: "優福",
                        y: data.MC['Ufo'],
                    }, { 
                        name: "Others",
                        y: data.MC['Others'],
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