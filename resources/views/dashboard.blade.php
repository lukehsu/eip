<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  @include('head.bootstrapcss')
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
</body>
</html>