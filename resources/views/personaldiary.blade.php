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



{!!Form::open(['route' => 'search', 'method' => 'GET'])!!}
    <input type="text" name="term"/>
    <select name="category" id="">
        <option value="auto">Auto</option>
        <option value="moto">Moto</option>
    </select>
    {!! Form::submit('Send') !!}
{!! Form::close() !!}


</div>
<!--javascript-->
<script type="text/javascript" src="../public/bootstrap331/dist/js/bootstrap-datetimepicker.js"></script>
</body>
</html>