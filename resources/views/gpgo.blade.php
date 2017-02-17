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
  <script src="./bootstrap331/dist/js/jquery-ui.js"></script>
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
      });
    });
  </script>
  <script type="text/javascript">
    $(function () {  
      var char = {!!$yearachjava!!} ;    
      $.each(char , function(key, value){ 
        var Data = [];
        $.each(value , function(cname, value1){ 
          Data.push(value1);
        });  
        $('#chart'+ key ).highcharts({
          chart: {
            type: 'line'
          },
          credits: {  
            enabled: false  
          },
          title: {
            text: key + '每月達成率  %'
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
            name: key,
            data: Data
          }]
        });
      });  
    });
  </script>
  <script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  });
  </script>
  <script type="text/javascript">
  $(function(){
    $(".q1play").click(function(){
      $(".Q1").css('display','block');
      $(".Q2").css('display','none');
      $(".Q3").css('display','none');
      $(".Q4").css('display','none');
    });
    $(".q2play").click(function(){
      $(".Q1").css('display','none');
      $(".Q2").css('display','block');
      $(".Q3").css('display','none');
      $(".Q4").css('display','none');
    });
    $(".q3play").click(function(){
      $(".Q1").css('display','none');
      $(".Q2").css('display','none');
      $(".Q3").css('display','block');
      $(".Q4").css('display','none');
    });
    $(".q4play").click(function(){
      $(".Q1").css('display','none');
      $(".Q2").css('display','none');
      $(".Q3").css('display','none');
      $(".Q4").css('display','block');
    });
    $(".c1play").click(function(){
      $(".C1").css('display','block');
      $(".C2").css('display','none');
      $(".C3").css('display','none');
      $(".C4").css('display','none');
      $(".C5").css('display','none');
      $(".C6").css('display','none');
    });
    $(".c2play").click(function(){
      $(".C1").css('display','none');
      $(".C2").css('display','block');
      $(".C3").css('display','none');
      $(".C4").css('display','none');
      $(".C5").css('display','none');
      $(".C6").css('display','none');
    });
    $(".c3play").click(function(){
      $(".C1").css('display','none');
      $(".C2").css('display','none');
      $(".C3").css('display','block');
      $(".C4").css('display','none');
      $(".C5").css('display','none');
      $(".C6").css('display','none');
    });
    $(".c4play").click(function(){
      $(".C1").css('display','none');
      $(".C2").css('display','none');
      $(".C3").css('display','none');
      $(".C4").css('display','block');
      $(".C5").css('display','none');
      $(".C6").css('display','none');
    });
    $(".c5play").click(function(){
      $(".C1").css('display','none');
      $(".C2").css('display','none');
      $(".C3").css('display','none');
      $(".C4").css('display','none');
      $(".C5").css('display','block');
      $(".C6").css('display','none');
    });
    $(".c6play").click(function(){
      $(".C1").css('display','none');
      $(".C2").css('display','none');
      $(".C3").css('display','none');
      $(".C4").css('display','none');
      $(".C5").css('display','none');
      $(".C6").css('display','block');
    });
    if ($('#datepickermed').val()!='' ||  $('#datepicker').val()!='' ) {
      if ($('#datepickermed').val().substr(5,2)<=3)
      {
        $(".q1play").click();
      } 
      else if ($('#datepickermed').val().substr(5,2)>=4 && $('#datepickermed').val().substr(5,2)<=6) 
      {
        $(".q2play").click();
      }
      else if ($('#datepickermed').val().substr(5,2)>=7 && $('#datepickermed').val().substr(5,2)<=9) 
      {
        $(".q3play").click();
      }  
      else
      {
        $(".q4play").click();
      }  
    }
    if ($('#datepickermed').val()!='' ||  $('#datepicker').val()!='' ) {
      if ($('#datepickermed').val().substr(5,2)<=2)
      {
        $(".c1play").click();
      } 
      else if ($('#datepickermed').val().substr(5,2)>=3 && $('#datepickermed').val().substr(5,2)<=4) 
      {
        $(".c2play").click();
      }
      else if ($('#datepickermed').val().substr(5,2)>=5 && $('#datepickermed').val().substr(5,2)<=6) 
      {
        $(".c3play").click();
      }  
      else if ($('#datepickermed').val().substr(5,2)>=7 && $('#datepickermed').val().substr(5,2)<=8) 
      {
        $(".c4play").click();
      }  
      else if ($('#datepickermed').val().substr(5,2)>=9 && $('#datepickermed').val().substr(5,2)<=10) 
      {
        $(".c5play").click();
      }  
      else
      {
        $(".c6play").click();
      }  
    }
    $(".tab1").click(function(){
      $(".tab1").css({'background-color':'#E67E22','color':'#FFFFFF'});
      $(".tab11").css('display','block');
      $(".tab2").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab21").css('display','none');
      $(".tab3").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab31").css('display','none');
    });
    $(".tab2").click(function(){
      $(".tab1").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab11").css('display','none');
      $(".tab2").css({'background-color':'#7F8C8D','color':'#FFFFFF'});
      $(".tab21").css('display','block');
      $(".tab3").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab31").css('display','none');
    });
    $(".tab3").click(function(){
      $(".tab1").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab11").css('display','none');
      $(".tab2").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab21").css('display','none');
      $(".tab3").css({'background-color':'#2980B9','color':'#FFFFFF'});
      $(".tab31").css('display','block');
    });
    $("#submit").click(function(){
      if ($('#datepicker').val()=='') {
        alert('尚未選擇日期');
        return false;
      }
    }); 
    $("#submitmed").click(function(){
      $('input:checkbox[name="checkvalue[]"]').attr('disabled', true);
      $('input:checkbox[name="checkvaluequit[]"]').attr('disabled', true);
      $('#datepicker').val('');
    });   
    $("#submit").click(function(){
      $('input:checkbox[name="checkmedvalue[]"]').attr('disabled', true);
      $('#datepickermed').val('');
    });  
  });
  </script>
  <script type="text/javascript">
  $(function(){
    if ({!!$choicedaymed!!}) 
    {
      $(".tab1").css({'background-color':'#E67E22','color':'#FFFFFF'});
      $(".tab11").css('display','block');
      $(".tab2").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab21").css('display','none');
      $(".tab3").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab31").css('display','none');       
    }
    /*elseif ({!!$choiceday!!}) 
    {
      $(".tab1").css({'background-color':'#FFFFFF','color':'#34495e'});
      $(".tab11").css('display','none');
      $(".tab2").css({'background-color':'#7F8C8D','color':'#FFFFFF'});
      $(".tab21").css('display','block');
    }*/
  });
  </script>  
  <script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  });
  </script>
</head>
<body>
<div class="container-fluid original">
  @include('includes.navbar')
  <div class="row">
    <div class="col-xs-offset-4 col-xs-9"  >
      <div class="col-xs-3 tab1" align="center" >藥品業績</div>
      <div class="col-xs-3 tab2" align="center" >人員業績</div>
      <!--div class="col-xs-3 tab3" align="center" >保瑞全藥品</div-->
    </div>
    <div class="col-xs-offset-1 col-xs-10 col-xs-offset-1 tab11">
      <form  action="{!!$fromsubmit!!}">
        <div class="col-xs-4 selectpanel">
          @if (count($team) >= 1)
          <div ><h2>請選擇銷售組別:</h2>
            @foreach ($team as $key => $tm)
            <input class="magic-radio productradio" type="radio" name="radio" id="{!!$key!!}" value="{!!$key!!}" >
            <label for="{!!$key!!}">
              {!!$tm!!}
            </label>
            @endforeach
          </div>
          @endif
          <div id="mexist" style="width: 300px"><h2>請選擇產品:</h2></div>
        </div>
        <div id="mpackage" class="col-xs-4 selectpanel" ><h2>銷售組合:</h2></div>
        <div class="col-xs-4 selectpanel" ><h2>請選擇日期:</h2>
          <div class="row selectpanel" >
            <div class="col-xs-7">
              <input type="text" name="datepickermed" placeholder="請選擇日期" class="form-control datepicker" id="datepickermed" value="{!!$choicedaymed!!}" />
            </div>
          </div>
          <div class="row" style="margin-top: 120px;margin-bottom: 20px">
            <div class="col-xs-7">
              <input type="submit" id="submitmed" class="btn btn-block btn-lg btn-info">
            </div>  
          </div>
        </div>
      </form>
    </div>
    <div class="col-xs-offset-1 col-xs-10 col-xs-offset-1 tab21" >
      <form id="ff" action="{!!$fromsubmit!!}">
        <div class="col-xs-4 selectpanel">
          @if (count($teamp) >= 1)
          <div ><h2>請選擇組別:</h2>
            @foreach ($teamp as $key => $tm)
            <input class="magic-radio teamradio" type="radio" name="radiopeople" id="{!!$key!!}" value="{!!$key!!}" >
            <label for="{!!$key!!}" style="width: 110px">
              {!!$tm!!}
            </label>
            @endforeach
          </div>
          @endif
          <div id="pexist"><h2>在職人員:</h2></div>
          <div id="pv"><h2>虛擬帳號:</h2></div>
        </div>
        <div id="pgo" class="col-xs-4 selectpanel" >離職/轉組人員</div>
        <div class="col-xs-4 selectpanel" ><h2>請選擇日期:</h2>
          <div class="row selectpanel" >
            <div class="col-xs-7">
              <input type="text" name="datepicker" placeholder="請選擇日期" class="form-control datepicker" id="datepicker" value="{!!$choiceday!!}" />
            </div>  
          </div>
          <div class="row" style="margin-top: 120px;margin-bottom: 20px">
            <div class="col-xs-7">
              <input type="submit" id="submit" class="btn btn-block btn-lg btn-info">
            </div>  
          </div>
        </div>
      </form>
    </div>


  </div>
  <HR>
  @if (count($everyone) >= 1)
  @foreach ($everyone as $key => $cname)
<!--人員起點-->    
  <div class="rowstyle">

    @foreach ($cname as $salesname => $value)
    <div class="row" style="margin-bottom: 10px">
      <form action="acdetail">
        <div class="col-md-offset-7 col-xs-12 col-md-5">
          <div class="col-xs-12 col-md-offset-7 col-md-5" style="text-align:center;background-color:#C0392B;color:#FFFFFF">
            <span class="fui-search"></span>
            <input type="hidden" name="persondetailname" value="{!!$salesname!!}">
            <input type="hidden" name="persondetaildate" value="{!!$choiceday!!}">
            <input type="hidden" name="persondetailgroup" value="{!!$radiopeople!!}">
            <input id="othererror" type="submit" name="" value="出貨明細" style="background-color:#C0392B;border:3px #C0392B solid;">
          </div>
        </div>
      </form> 
    </div>
    @endforeach

    <div class="row" style="margin-bottom: 10px">
      <div id="chart{!!$key!!}" class="col-xs-12 col-md-7">    
      </div>
      <div class="col-xs-12 col-md-5">
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
    @if (isset($ccheck))
    <div class="row call" style="margin-bottom: 10px">
      <div class="col-xs-12 col-md-12 C1">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 qcheck qselect">C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C1'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C1'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C1'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C1'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>

      <div class="col-xs-12 col-md-12 C2">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 qcheck qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C2'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C2'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C2'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C2'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>

      <div class="col-xs-12 col-md-12 C3">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 qcheck qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C3'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C3'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C3'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C3'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>

      <div class="col-xs-12 col-md-12 C4">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 qcheck qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C4'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C4'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C4'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C4'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>  

      <div class="col-xs-12 col-md-12 C5">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 qcheck qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C5'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C5'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C5'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C5'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>  

      <div class="col-xs-12 col-md-12 C6">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 qcheck qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Csalesformedicine['C6'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Cbudgetmonth['C6'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Cpab['C6'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Ctotal['C6'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>  
    </div>
    @endif  

    <div class="row">
      <div class="col-xs-12 col-md-6 Q1">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 qcheck qselect">Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qsalesformedicine['Q1'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qbudgetmonth['Q1'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Qpab['Q1'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q1'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>


      <div class="col-xs-12 col-md-6 Q2">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 qcheck qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
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

      <div class="col-xs-12 col-md-6 Q3">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 qcheck qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qsalesformedicine['Q3'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qbudgetmonth['Q3'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Qpab['Q3'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q3'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>


      <div class="col-xs-12 col-md-6 Q4">
        @foreach ($cname as $salesname => $value)
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 qcheck qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        @foreach ($value as $key => $sale)
        <div class="col-xs-3" >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qsalesformedicine['Q4'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format((int)$Qbudgetmonth['Q4'][$salesname][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!$Qpab['Q4'][$salesname][$key]!!}%</div>
        @endforeach
        <div class="col-xs-3 grill" >Total</div>
        @foreach ($Qtotal['Q4'][$salesname] as $total)
        @if(strlen($total)<=3)
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}%</div>
        @else
          <div class="col-xs-3 grill sortright" >{!!number_format((int)$total)!!}</div>
        @endif
        @endforeach
        @endforeach
      </div>      

      <div class="col-xs-12 col-md-6">
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
        <div class="col-xs-12 finalgrill" >業績加總(不含{!!$shippingbig!!})</div>
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
        <div class="col-xs-12 finalgrill" >業績加總(含{!!$shippingbig!!})</div>
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
  @elseif (count($productssell)>0)
  @foreach ($productssell as $key => $value)
<!--藥品起點-->  
  <div class="rowstyle">
    <div class="row uniprice" style="margin-bottom: 10px ">
      <form action="acbudget">
          <div class="col-md-offset-7 col-xs-12 col-md-5">
            <div class="col-xs-12 col-md-offset-7 col-md-5" style="text-align:center;background-color:#C0392B;color:#FFFFFF">
              <span class="fui-search"></span>
              @foreach ($companyaccess as  $vals)
              <input type="hidden" name="companyaccess[]"  value="{!!$vals!!}">
              @endforeach
              @foreach ($provideraccess as  $vals)
              <input type="hidden" name="provideraccess[]" value="{!!$vals!!}">
              @endforeach
              <input type="hidden" name="med" value="{!!$key!!}">
              <input type="hidden" name="meddate" value="{!!$choicedaymed!!}">
            <input id="othererror" type="submit" name="" value="單價及出貨明細" style="background-color:#C0392B;border:3px #C0392B solid;">
          </div>
        </div>
      </form> 
    </div>
    <div class="row">
      <div id="chart{!!$key!!}" class="col-xs-7">    
      </div>
      <div class="col-xs-5 underspace">
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;{!!$choicedaymed!!}業績</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub sortright" >Actual</div>
        <div class="col-xs-3 grillsub sortright" >Budget</div>
        <div class="col-xs-3 grillsub sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($value)!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($producbudget[$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productab[$key])!!}%</div>
      </div>
      <div class="col-xs-5 underspace Q1">
        <div class="col-xs-3 qcheck qselect" >Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellQ['Q1'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetQ['Q1'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productQab['Q1'][$key])!!}%</div>
      </div>
      <div class="col-xs-5 underspace Q2">
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 qcheck qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellQ['Q2'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetQ['Q2'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productQab['Q2'][$key])!!}%</div>
      </div>
      <div class="col-xs-5 underspace Q3">
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 qcheck qselect" >Q3</div>
        <div class="col-xs-3 grillsub q4play qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellQ['Q3'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetQ['Q3'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productQab['Q3'][$key])!!}%</div>
      </div>
      <div class="col-xs-5 underspace Q4">
        <div class="col-xs-3 grillsub q1play qselect" >Q1</div>
        <div class="col-xs-3 grillsub q2play qselect" >Q2</div>
        <div class="col-xs-3 grillsub q3play qselect" >Q3</div>
        <div class="col-xs-3 qcheck qselect" >Q4</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellQ['Q4'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetQ['Q4'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productQab['Q4'][$key])!!}%</div>
      </div>
      <div class="col-xs-5 underspace">
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;2016-01~{!!$monmed!!}年度累積加總</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub sortright" >Actual</div>
        <div class="col-xs-3 grillsub sortright" >Budget</div>
        <div class="col-xs-3 grillsub sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellQ['Q5'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetQ['Q5'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productQab['Q5'][$key])!!}%</div>
      </div>
    </div>

    @if (isset($ccheckm))
    <div class="row">
      <div class="col-xs-12 col-md-12  underspace C1">
        <div class="col-xs-2 qcheck qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C1'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C1'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C1'][$key])!!}%</div>
      </div>
      <div class="col-xs-12 col-md-12 underspace C2">
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 qcheck qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C2'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C2'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C2'][$key])!!}%</div>
      </div>
      <div class="col-xs-12 col-md-12 underspace C3">
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 qcheck qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C3'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C3'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C3'][$key])!!}%</div>
      </div>
      <div class="col-xs-12 col-md-12 underspace C4">
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 qcheck qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C4'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C4'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C4'][$key])!!}%</div>
      </div>
      <div class="col-xs-12 col-md-12 underspace C5">
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 qcheck qselect" >C5</div>
        <div class="col-xs-2 grillsub c6play qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill" >Actual</div>
        <div class="col-xs-3 grill" >Budget</div>
        <div class="col-xs-3 grill" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C5'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C5'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C5'][$key])!!}%</div>
      </div>
      <div class="col-xs-12 col-md-12 underspace C6">
        <div class="col-xs-2 grillsub c1play qselect" >C1</div>
        <div class="col-xs-2 grillsub c2play qselect" >C2</div>
        <div class="col-xs-2 grillsub c3play qselect" >C3</div>
        <div class="col-xs-2 grillsub c4play qselect" >C4</div>
        <div class="col-xs-2 grillsub c5play qselect" >C5</div>
        <div class="col-xs-2 qcheck qselect" >C6</div>
        <div class="col-xs-3 grill" >Item</div>
        <div class="col-xs-3 grill sortright" >Actual</div>
        <div class="col-xs-3 grill sortright" >Budget</div>
        <div class="col-xs-3 grill sortright" >A / B</div>
        <div class="col-xs-3 " >{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productssellC['C6'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productsbudgetC['C6'][$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productCab['C6'][$key])!!}%</div>
      </div>
    </div>
    @endif
  </div>
  <HR>
  @endforeach
  <div class="row">
        <div class="col-xs-12 finalgrill" >業績加總</div>
        <div class="col-xs-3 grillsub" >{!!$monmed!!}月份加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($allproductssell)!!}</div>
        <div class="col-xs-3 " >{!!number_format($allproducbudget)!!}</div>
        <div class="col-xs-3 " >{!!$allproductab!!} %</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >2016-01~{!!$monmed!!}累積加總</div>
        <div class="col-xs-3 grillsub" >Actual</div>
        <div class="col-xs-3 grillsub" >Budget</div>
        <div class="col-xs-3 grillsub" >A / B</div>
  </div>
  <div class="row">
        <div class="col-xs-3 grillsub" >Total</div>
        <div class="col-xs-3 " >{!!number_format($ytdallproductssell)!!}</div>
        <div class="col-xs-3 " >{!!number_format($ytdallproducbudget)!!}</div>
        <div class="col-xs-3 " >{!!$ytdallproductab!!} %</div>
  </div>
@endif
<script type="text/javascript">
  $(function(){
    $(".teamradio").click(function(){
      var checkp = {!!$peoplesjava!!};
      var checkparray = [];
      $.each(checkp,function(key,value){
        checkparray[value]=value;
      });  
      $.ajax({
        type: 'POST',
        url: '/eip/public/chooseman',
        data: { info : $(this).val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
            var stay = '';
            var vur = '';
            var go = '';
            $.each(data[0],function(key,value){
              var checked = '';
              if (key==checkparray[key]) {
                checked = 'checked';
              }
              if ({!!$peoplesjava!!}=='') {
                checked = 'checked';
              }
              stay += '<input class="magic-checkbox" type="checkbox" name="checkvalue[]" id="'+key+'" value="'+key+'" style="width:auto;"'+ checked +'> <label for="'+key+'" id="'+key+'nl" style="width:auto;">' + value + '</label>';
            })
            $("#pexist").html("<h2>在職人員:</h2>"+stay);

            $.each(data[1],function(key,value){
              var checked = '';
              if (key==checkparray[key]) {
                checked = 'checked';
              }
              vur += '<input class="magic-checkbox" type="checkbox" name="checkvalue[]" id="'+key+'" value="'+key+'" style="width:auto;"'+ checked +'> <label for="'+key+'" id="'+key+'nl" style="width:auto;">' + value + '</label>';
            })
            $("#pv").html("<h2>虛擬帳號:</h2>"+vur);

            $.each(data[2],function(key,value){
              var checked = '';
              if (key==checkparray[key]) {
                checked = 'checked';
              }
              go += '<input class="magic-checkbox" type="checkbox" name="checkvalue[]" id="'+key+'" value="'+key+'" style="width:auto;"' + checked +'> <label for="'+key+'" id="'+key+'nl" style="width:auto;">' + value + '</label>';
            })
            $("#pgo").html("<h2>離職/轉組人員:</h2>"+go);
        },
        error: function(xhr, type){
          $('#error').html('error');
        }
      }); 
    }); 
  });
</script>
<script type="text/javascript">
    $(function(){
      if ({!!$radiopeoplejava!!} == 'GPpeople' ) 
      {
        $('#GPpeople').click();
      }
      else if ({!!$radiopeoplejava!!} == 'HPpeople'  ) 
      {
        $('#HPpeople').click();
      }
      else if ({!!$radiopeoplejava!!} == 'Healpeople'  ) 
      {
        $('#Healpeople').click();
      }
      if ($("#GPpeople").length > 0 && {!!$radiopeoplejava!!} == null   ) 
      {
        $('#GPpeople').click();
      }
      else if ($("#HPpeople").length > 0 && {!!$radiopeoplejava!!} == null  ) 
      {
        $('#HPpeople').click();
      }
      else if ($("#Healpeople").length > 0 && {!!$radiopeoplejava!!} == null  ) 
      {
        $('#Healpeople').click();
      }
    });  
</script>  
<script type="text/javascript">
  $(function(){
    $(".productradio").click(function(){
      var checkp = {!!$medvaluejava!!};
      var checkprovider = {!!$checkproviderjava!!};
      var checkparray = [];
      var checkproviderarray = [];
      var thisradio = $(this).val();
      $.each(checkp,function(key,value){
        checkparray[value]=value;
      });
      $.each(checkprovider,function(key,value){
        checkproviderarray[value]=value;
      });
      $.ajax({
        type: 'POST',
        url: '/eip/public/chooseproduct',
        data: { info : $(this).val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
          var med = '';
          var medstore = '';
          $.each(data[0],function(key,value){
            var checked = '';
            if (value==checkparray[value] && {!!$radioadminjava!!}==thisradio) {
              checked = 'checked';
            }
            if ({!!$medvaluejava!!}=='') {
              checked = 'checked';
            }
            med += '<input class="magic-checkbox" type="checkbox" name="checkmedvalue[]" id="'+value+'" value="'+value+'"'+checked+'> <label id="'+value+'1" style="width:140px;"  for="'+value+'">'+value+'</label>'; 
          });  
          $("#mexist").html("<h2>請選擇產品:</h2><input class='magic-checkbox' type='checkbox' name='chooseallcheck' id='chooseall'  style='width:auto;' ><label for='chooseall' class='chooseall' style='width:auto;'>全選</label><br>"+med);
          $('.chooseall').click(function()
          {
            if ($("input[name='chooseallcheck']").prop('checked')) {
              $("input[name='checkmedvalue[]']").prop('checked',false);
            }
            else
            {
              $("input[name='checkmedvalue[]']").prop('checked',true);
            }  
          })
          $('.chooseall').click();
          $.each(data[1],function(key,value){
            var checked = '';
            if (key==checkproviderarray[key] && {!!$radioadminjava!!}==thisradio) {
              checked = 'checked';
            }
            if ({!!$checkproviderjava!!}=='') {
              checked = 'checked';
            }
            medstore += '<input class="magic-checkbox "  type="checkbox" name="checkprovider[]" id="'+key+'" value="'+key+'" '+checked+' > <label style="width:auto;" for="'+key+'">'+key+'</label>'
          });
          $("#mpackage").html("<h2>請選擇銷售組合:</h2>"+medstore);
        },
        error: function(xhr, type){
          $('#error').html('error');
        }
      }); 
    }); 
  });
</script>
<script type="text/javascript">
  $(function(){
    if ({!!$radioadmin!!}=='GP') {
      $('#GP').click();

    }
    else if ({!!$radioadmin!!}=='HP')
    {
      $('#HP').click();

    }
    else if ({!!$radioadmin!!}=='uni')
    {
      $('#uni').click();

    } 
    else if ({!!$radioadmin!!}=='heal')
    {
      $('#heal').click();

    } 
    if ($("#GP").length > 0 && {!!$radioadmin!!}==null ) 
    {
      $('#GP').click();

    } 
    else if ($("#HP").length > 0 && {!!$radioadmin!!}==null ) 
    {
      $('#HP').click();

    }
    else if ($("#uni").length > 0 && {!!$radioadmin!!}==null ) 
    {
      $('#uni').click();

    }  
    else if ($("#heal").length > 0 && {!!$radioadmin!!}==null ) 
    {
      $('#heal').click();
    } 
  });
</script>
<script type="text/javascript">
  $('#GP').click(function(){
    $('.uniprice').show();
  });
  $('#HP').click(function(){
    $('.uniprice').show();
  });
  $('#uni').click(function(){
    $('.uniprice').hide();
    alert('123');
  });
  $('#heal').click(function(){
    $('.uniprice').hide();
  });
</script>
</body>
</html>