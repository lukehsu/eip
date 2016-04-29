<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>資訊服務單</title>
    <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet"  href="../bootstrap331/dist/css/flat-ui.css">
    <link rel="stylesheet"  href="../bootstrap331/dist/css/droplist.css">
    <script type="text/javascript" src="../bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../bootstrap331/dist/js/bootstrap.min.js"></script>
    <style type="text/css">
    .inputformat{
        height: 35px; 
    }
    </style>
</head>
<body>
<div class="container-fluid">
<form method="post" action="https://api.zoom.us/v1/user/create">
<input type="text" name="api_key">
<input type="text" name="api_secret">
<input type="submit">
</form>

</body>
</html>