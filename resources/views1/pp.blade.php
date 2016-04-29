<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>保瑞日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="../public/bootstrap331/dist/js/highcharts.js"></script>
</head>
<body>
<div class="container-fluid">
  @include('includes.pp1')


</div>
<!--javascript-->
<script type="text/javascript" src="../public/bootstrap331/dist/js/bootstrap-datetimepicker.js"></script>
</body>
</html>