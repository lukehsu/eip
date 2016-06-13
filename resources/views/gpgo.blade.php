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
  <link rel="stylesheet"  href="./bootstrap331/dist/css/magic-check.css"> 
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="./bootstrap331/dist/css/gocss.css">
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <script type="text/javascript">
    $(function () {
      var charobj = {!!$achjava!!};
      $.each(charobj , function(key, value){ 
        var myData = [];
        $.each(value , function(cname, value1){ 
          $.each(value1 , function(cname1, value2){
            myData.push(value2);
          });             
          $('#chart' + key).highcharts({
            chart: {
              type: 'line'
            },
            credits: {  
              enabled: false  
            },
            title: {
              text: cname + '每月達成率  %'
            },
            subtitle: {
              text: ''
            },
            xAxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
              title: {
                text: '達成率'
              }
            },
            plotOptions: {
              line: {
                dataLabels: {
                  enabled: true
                },
                enableMouseTracking: false
              }
            },
            series: [{
              name: cname,
              data: myData
            }]
          });
        });  
      });//
    });
  </script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  });
  </script>
</head>
<body>
<div class="container-fluid original">
  @include('includes.navbar')
  <div class="row">
    <div class="col-xs-offset-4 col-xs-8"  >
      <div class="col-xs-3 tab10" align="center"  >依部門查詢</div>
      <div class="col-xs-3 tab11" align="center" >依人員查詢</div>
    </div>
    <div class="col-xs-offset-1 col-xs-10 col-xs-offset-1 tab2">
      <form action="gpgo">
        <div class="col-xs-4 selectpanel" ><h2>GP組在職人員:</h2>
        @foreach ($cnamesforpage as $key => $cname)
          <input class="magic-checkbox"  type="checkbox" name="checkvalue[]" id="{!!$key!!}" value="{!!$key!!}" {!!$checkboxinfo[$key]!!}> 
          <label for="{!!$key!!}">{!!$cname!!}</label> 
        @endforeach
        </div>
        <div class="col-xs-4 selectpanel" ><h2>GP組離職/轉組人員:</h2>
        @foreach ($cnamesquitforpage as $key => $cname)
          <input class="magic-checkbox"  type="checkbox" name="checkvaluequit[]" id="{!!$key!!}" value="{!!$key!!}" {!!$checkboxinfo[$key]!!}> 
          <label for="{!!$key!!}">{!!$cname!!}</label>
        @endforeach
        </div>
        <div class="col-xs-4 selectpanel" ><h2>請選擇日期:</h2>
          <div class="row selectpanel" >
            <div class="col-xs-7">
              <input type="text" name="datepicker" placeholder="請選擇日期" class="form-control" id="datepicker" value="{!!$choiceday!!}" />
            </div>  
          </div>
          <div class="row" style="margin-top: 120px">
            <div class="col-xs-7">
              <input type="submit" class="btn btn-block btn-lg btn-info">
            </div>  
          </div>
        </div>
      <form>
    </div>
  </div>
  <HR>
  @if (count($everyone) >= 1)
  @foreach ($everyone as $key => $cname)
  <div class="rowstyle">
    <div class="row">
      <div id="chart{!!$key!!}" class="col-xs-7">    
      </div>
      <div class="col-xs-5">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;{!!$choiceday!!}&nbsp;&nbsp;{!!$salesname!!}&nbsp;&nbsp;</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub sortright" >Actual</div>
        <div class="col-xs-3 grillsub sortright" >Budget</div>
        <div class="col-xs-3 grillsub sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($sale)!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$pbudget[$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$pab[$salesname][$key]!!}</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($totals[$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif  
        @endforeach
        @endforeach
      </div>
    </div>


    <div class="row">
      <div class="col-xs-6">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 grillsub" >Q1</div>
        <div class="col-xs-3 qcheck" >Q2</div>
        <div class="col-xs-3 grillsub" >Q3</div>
        <div class="col-xs-3 grillsub" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qsalesformedicine['Q2'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qbudgetmonth['Q2'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Qpab['Q2'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q2'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>


      <div class="col-xs-6">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;2016-01~{!!$mon!!}年度累積加總&nbsp;&nbsp;{!!$salesname!!}&nbsp;&nbsp;</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub sortright" >Actual</div>
        <div class="col-xs-3 grillsub sortright" >Budget</div>
        <div class="col-xs-3 grillsub sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qsalesformedicine['Q5'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qbudgetmonth['Q5'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Qpab['Q5'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q5'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>
    </div>
  </div>  
  <HR>
  @endforeach
  <div class="row">
        <div class="col-xs-12 finalgrill" >業績加總(不含物流)</div>
        <div class="col-xs-3 grillsub" >{!!$mon!!}月份加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($finaltotalsalenobig)!!}</div>
        <div class="col-xs-3 " >{!!number_format($finaltotalbudgetnobig)!!}</div>
        <div class="col-xs-3 " >{!!$finalabnobig!!} %</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >2016-01~{!!$mon!!}累積加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($finalyeartotalsalenobig)!!}</div>
        <div class="col-xs-3 " >{!!number_format($finalyeartotalbudgetnobig)!!}</div>
        <div class="col-xs-3 " >{!!$finalyearabnobig!!} %</div>
  </div>
  <HR>
  <div class="row">
        <div class="col-xs-12 finalgrill" >業績加總(含物流)</div>
        <div class="col-xs-3 grillsub" >{!!$mon!!}月份加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($finaltotalsale)!!}</div>
        <div class="col-xs-3 " >{!!number_format($finaltotalbudget)!!}</div>
        <div class="col-xs-3 " >{!!$finalab!!} %</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >2016-01~{!!$mon!!}累積加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($finalyeartotalsale)!!}</div>
        <div class="col-xs-3 " >{!!number_format($finalyeartotalbudget)!!}</div>
        <div class="col-xs-3 " >{!!$finalyearab!!} %</div>
  </div>
  @else

@endif
</body>
</html>