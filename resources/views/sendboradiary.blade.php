<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>保瑞日報表</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <link rel="stylesheet"  href="./bootstrap331/dist/css/datepickerplacehold.css">
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <script src="./bootstrap331/dist/js/html2canvas.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [{!!$MC['Pitavol']!!}, {!!$MC['Denset']!!}, {!!$MC['Lepax10']!!}, {!!$MC['Lepax5']!!}, {!!$MC['Lexapro']!!}, {!!$MC['Ebixa']!!}, {!!$MC['Deanxit']!!}, {!!$MC['LendorminBora']!!}, {!!$MC['Lendorminann']!!}, {!!$MC['Wilcon']!!}, {!!$MC['Kso']!!}, {!!$MC['Bpn']!!}, {!!$MC['Others']!!}];
        var ticks = ['Pitavol', 'Denset', 'Lepax 10mg', 'Lepax 5mg', 'Lexapro', 'Ebixa', 'Deanxit', 'Lendormin(Bora)', 'Lendormin(和安)', '胃爾康', '氯四環素', '帕金寧', 'Others'];
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true },
                rendererOptions: {
                varyBarColor: true
              }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    });
  </script>
</head>
<body>
<div class="container-fluid" id="ourdiv" style="background-color:#FFFFFF">
  <div class="row">
    <div class="col-md-12" style="align=center" ><h6><span style="font-weight:bold;">{!!$todaydate!!}保瑞業績表</span></h6></div>
  </div>
  <div class="row">
    <div id="chart1" class="col-md-12" style="height:300px;font-size:14px" ></div>
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
              ACT(MON)
            </th>
            <th class="text-center">
              Budget(MON)
            </th>
            <th class="text-center">
              ACH.%
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
              Lepax 5mg 
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
<script type="text/javascript"> 
<!-- 
        //平台操作系统 
        var system = { 
            win: false, 
            mac: false, 
            xll: false, 
            ipad:false 
        }; 
        //平台 
        var p = navigator.platform; 
        system.win = p.indexOf("Win") == 0; 
        system.mac = p.indexOf("Mac") == 0; 
        system.x11 = (p == "X11") || (p.indexOf("Linux") == 0); 
        system.ipad = (navigator.userAgent.match(/iPad/i) != null)?true:false; 

        if (system.win || system.mac || system.xll||system.ipad) 
        { 
          $("#datetimepicker").change(function(){
            window.location.replace("http://127.0.0.1/eip/public/boradiary/" + $("#datetimepicker").val());
          }); 
        } 
        else 
        { 
          $("#datetimepicker").blur(function(){
            window.location.replace("http://127.0.0.1/eip/public/boradiary/" + $("#datetimepicker").val());
          }); 
        } 
--> 
</script> 
<script type="text/javascript">
  $(function(){
    setTimeout(function(){
      $.getScript("./bootstrap331/dist/js/pic.js");
    },5000)
  })
</script>
  <script language="javascript">setTimeout("self.opener = null; self.close();",15000)</script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery.jqplot.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shCore.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shBrushJScript.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shBrushXml.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.barRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.pieRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.categoryAxisRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.pointLabels.min.js"></script>
</body>
</html>