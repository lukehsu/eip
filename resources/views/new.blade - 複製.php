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
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <style type="text/css">
  #mwt_mwt_slider_scroll
  {
    top: 30px;
    left:-1280px;
    width:1280px;  
    position:fixed;
    z-index:9999;
  }
  #mwt_slider_content{
    background:#FFFFFF;
    text-align:center;
    height:550px; 
    -moz-border-radius-topright:10px;
    -moz-border-radius-bottomright:10px;
    -webkit-border-top-right-radius:10px;
    -webkit-border-bottom-right-radius:10px; 
    -webkit-box-shadow: 4px 4px 12px 4px rgba(20%,20%,40%,0.5);
    -moz-box-shadow: 4px 4px 12px 4px rgba(20%,20%,40%,0.5);
    box-shadow: 4px 4px 12px 4px rgba(20%,20%,40%,0.5);
    padding-top:20px;
  }
  #mwt_fb_tab {
    position:absolute;
    top:20px;
    right:-24px;
    width:24px;
    background:#95A5A6;
    color:#ffffff;
    font-family:Arial, Helvetica, sans-serif; 
    text-align:center;
    padding:9px 0;
    -moz-border-radius-topright:10px;
    -moz-border-radius-bottomright:10px;
    -webkit-border-top-right-radius:10px;
    -webkit-border-bottom-right-radius:10px;  
  }
  #mwt_fb_tab span {
    display:block;
    height:42px;
    padding:10px 0;
    line-height:12px;
    text-transform:uppercase;
    font-size:30px;
  }
  </style>
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
  <div class="row">
    <div id="mwt_mwt_slider_scroll">
      <div id="mwt_fb_tab">
        <span> >> </span>
      </div>
      <div id="mwt_slider_content">
        <button id="ff">123</button>
        <input type="text" class="form-control inputformat"></input>
      </div>
    </div>
    <div class="col-md-12" id='chart'></div>
  </div>
</div> 
<script type="text/javascript">
  $(function() {
    var check = 0;
    $('#mwt_fb_tab').click(function() {
      if (check==0) {
        $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '1280px'}, 200);
        check = 1;
      }
      else
      {
       $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '-2px'}, 200); 
       check = 0;
      }  
    });
    $('#ff').click(function() {
      $('#mwt_mwt_slider_scroll').stop().animate({'marginLeft': '-2px'}, 200);
    });
  });
    </script>
</body>
</html>