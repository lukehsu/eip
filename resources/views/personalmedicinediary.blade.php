<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/flat-ui.css">
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/placeholdercolor.css">
  <script type="text/javascript" src="./../../bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./../../bootstrap331/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  href="./../../bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script src="./../../bootstrap331/dist/js/highcharts.js"></script>

</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
  <div class="row">
    <div class="col-md-1">

    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12" id='chart'></div>
  </div>
  <br>
  <br>
  <div class="row">
    <div class="col-md-12" id="tablezone">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="text-center" style="display:none">

            </th>
            <th class="text-center" style="border:#FFFFFF 1px solid; ">
             
            </th>
            <th class="text-center" style="background-color:#ECF0F1;border:#FFFFFF 3px solid">
              Diary
            </th>
            <th class="text-center" colspan="4" style="background-color:#E0E0E0;border:#FFFFFF 3px solid">
              MTD
            </th>
            <th class="text-center" colspan="4" style="background-color:#BDC3C7;border:#FFFFFF 3px solid">
              YTD
            </th>
          </tr>
          <tr>
            <th class="text-center" style="display:none">
              Itemno
            </th>
            <th class="text-center">
              Product
            </th>
            <th class="text-center">
              Amount
            </th>
            <th class="text-center">
              Month Actual
            </th>
            <th class="text-center">
              Month Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <th class="text-center">
              A / L
            </th>
            <th class="text-center">
              Month Actual
            </th>
            <th class="text-center">
              Month Budget
            </th>
            <th class="text-center">
              A / B
            </th>
            <th class="text-center">
              A / L
            </th>
          </tr>
        </thead>
        <tbody>
{!!$form!!}
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--javascript-->
</body>
</html>