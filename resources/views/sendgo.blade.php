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
  <script src="./bootstrap331/dist/js/html2canvas.js"></script>
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
      <form  action="sendgo">
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
  <HR>
  @endforeach
  @elseif (count($productssell)>0)
  <div id="ourdiv">
  @foreach ($productssell as $key => $value)
      <div class="col-xs-offset-1 col-xs-5 underspace" >
        <div class="col-xs-12 grill" ><span class="fui-calendar"></span>&nbsp;{!!$choicedaymed!!}業績</div>
        <div class="col-xs-3 grillsub" >Item</div>
        <div class="col-xs-3 grillsub sortright" >Actual</div>
        <div class="col-xs-3 grillsub sortright" >Budget</div>
        <div class="col-xs-3 grillsub sortright" >A / B</div>
        <div class="col-xs-3 " style="width: 110px">{!!$key!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($value)!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($producbudget[$key])!!}</div>
        <div class="col-xs-3 sortright" >{!!number_format($productab[$key])!!}%</div>
      </div>
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
          $("#mexist").html("<h2>請選擇產品:</h2>"+med);
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
  <script>
  $(function() {
    var Today = new Date(); 
    if (Today.getMinutes()<=5) {
      $( "#GP" ).click()
    }
    else if (Today.getMinutes()<=10) {
      $( "#HP" ).click()
    }
    else if (Today.getMinutes()<=15) {
      $( "#uni" ).click()
    }
    else if (Today.getMinutes()<=20) {
      $( "#heal" ).click()    
    }
    var preDate = new Date(Today.getTime() - 24*60*60*1000);
    var m = preDate.getMonth()+1;
    if (m<10) {
      m = '0' + m ;
    }
    $('#datepickermed').val(preDate.getFullYear()+ "-" + m + "-" + preDate.getDate());
    if ({!!$radioadminjava!!} == null) 
    {
      setTimeout(function(){
        $("#submitmed").click();
      },10000)
    }  
  });
  </script>
<script type="text/javascript">
  $(function(){
    setTimeout(function(){
      $.getScript("./bootstrap331/dist/js/pic.js");
    },10000)
  })
</script>
</body>
</html>