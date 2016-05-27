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
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <script type="text/javascript">
    $(function () {
      var myData = [];
      var phparray = {!!$test!!};
      for (i in phparray) {
        myData.push( phparray[i] );
      }
      var charobj = {!!$everyonejava!!};
      $.each(charobj , function(key, value){ 
        var charloop = charobj[key] ;
        var charloopp = [];
        $.each(charloop , function(key, value){ 
          charloopp[key] = charloop[key];
        });
        $('#chart' + key).highcharts({
          chart: {
            type: 'line'
          },
          credits: {  
            enabled: false  
          },
          title: {
            text: charloopp['cname']+'每月達成率'
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
            name: charloopp['cname'],
            data: myData
          }]
        });
      });//
    });
  </script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  });
  </script>
  <style type="text/css">
  .original{
    width: 1300px;
    margin: 0 auto; 
  }
  .rowstyle{
    margin-top: 8px;
  }
  .tab1{
    background-color:#7F8C8D;
    color: #FFFFFF;
  }
  .tab2{
    border-color:#7F8C8D   ;
    border-width:1px;
    border-style:solid;
  }
  .grill{
    background-color:#7F8C8D;
    color: #FFFFFF;
  }
  .grillsub{
    background-color:#7F8C8D;
    color: #FFFFFF;
    border:2px white solid;
  }
  .grillsub1{
    background-color:#7F8C8D;
    color: #FFFFFF;
    border:2px #7F8C8D solid;
  }
 .te{
  top: 10px;
 } 
  </style>
</head>
<body>
<div class="container-fluid original">
  @include('includes.navbar')
  <div class="row">
    <div class="col-xs-offset-4 col-xs-8">
      <div class="col-xs-2" align="center">依部門查詢</div>
      <div class="col-xs-2 tab1" align="center">依人員查詢</div>
    </div>
    <div class="col-xs-offset-1 col-xs-10 col-xs-offset-1 tab2">
      <form action="go">
        <div class="col-xs-4" style="margin-top: 10px"><h2>GP組在職人員:</h2>
        @foreach ($cnamesforpage as $key => $cname)
          <input class="magic-checkbox"  type="checkbox" name="checkvalue[]" id="{!!$key!!}" value="{!!$key!!}"> 
          <label for="{!!$key!!}">{!!$cname!!}</label>
        @endforeach
        </div>
        <div class="col-xs-4" style="margin-top: 10px"><h2>GP組離職/轉組人員:</h2>
        @foreach ($cnamesquitforpage as $key => $cname)
          <input class="magic-checkbox"  type="checkbox" name="checkvaluequit[]" id="{!!$key!!}" value="{!!$key!!}"> 
          <label for="{!!$key!!}">{!!$cname!!}</label>
        @endforeach
        </div>
        <div class="col-xs-4" style="margin-top: 10px"><h2>請選擇日期:</h2>
          <div class="row" style="margin-top: 10px">
            <div class="col-xs-7">
              <input type="text" value="" name="datepicker" placeholder="請選擇日期" class="form-control" id="datepicker" />
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
  <HP>
@if (isset($everyone))

  @foreach ($everyone as $key => $cname)
  <div class="rowstyle">
    <div class="row">
      <div id="chart{!!$key!!}" class="col-xs-7">    
      </div>
      <div class="col-xs-5">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;{!!$choiceday!!}&nbsp;&nbsp;{!!$salesname!!}&nbsp;&nbsp;</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3" >{!!$sale!!}</div>
        <div class="col-xs-3" >{!!$pbudget[$salesname][$key]!!}</div>
        <div class="col-xs-3" >{!!$pab[$salesname][$key]!!}</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($totals[$salesname] as $total)
        <div class="col-xs-3 grill" >{!!$total!!}</div>
        @endforeach
        @endforeach
      </div>
    </div>


    <div class="row">
      <div class="col-xs-6">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 grillsub" >Q1</div>
        <div class="col-xs-3 grillsub1" >Q2</div>
        <div class="col-xs-3 grillsub" >Q3</div>
        <div class="col-xs-3 grillsub" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3" >{!!$Qsalesformedicine['Q1'][$salesname][$key]!!}</div>
        <div class="col-xs-3" >{!!$Qbudgetmonth['Q1'][$salesname][$key]!!}</div>
        <div class="col-xs-3" >{!!$Qpab['Q1'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q1'][$salesname] as $total)
        <div class="col-xs-3 grill" >{!!$total!!}</div>
        @endforeach
        @endforeach
      </div>


      <div class="col-xs-6">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;年度&nbsp;&nbsp;{!!$salesname!!}&nbsp;&nbsp;</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3" >{!!$Qsalesformedicine['Q5'][$salesname][$key]!!}</div>
        <div class="col-xs-3" >{!!$Qbudgetmonth['Q5'][$salesname][$key]!!}</div>
        <div class="col-xs-3" >{!!$Qpab['Q5'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q5'][$salesname] as $total)
        <div class="col-xs-3 grill" >{!!$total!!}</div>
        @endforeach
        @endforeach
      </div>
    </div>
  </div>  
  <HR>
  @endforeach
@else

@endif

</body>
</html>