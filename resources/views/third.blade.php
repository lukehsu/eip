<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="../public/bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
             //取得div容器的id
                renderTo: 'test',
                zoomType: 'xy',
                //折線圖
                type: 'line',
                //右方間距
                marginRight: 60,
                //下方間距
                marginBottom: 25
            },
            title: {
                text: '每月業績',
                x: -20 //位置至中
            },
            subtitle: {
                text: '當日',
                x: -20
            },
            credits: {
             //隱藏官方連結
             enabled: false
             },
            xAxis: {
             //x軸的座標點
                categories: ['1', '2','3', '4','5', '6','7', '8','9', '10','11', '12','13', '14','15', '16','17', '18','19', '20','21', '22','23', '24','25', '26']
            },
            yAxis: {
                title: {
                 //Y軸表頭
                    text: 'K'
                },
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'kkk';
                }
            },
            legend: {
             //由上至下
             layout: 'vertical',
             //靠左
          align: 'left',
          //從左上方為起點(0, 0)距離
          x: 40,
          y: 20,
          //靠上
          verticalAlign: 'top',
          floating: true,
          //框內背景顏色
          backgroundColor: '#FFFFFF'
            },
            series: [{
                name: 'a',
                data: [16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5]
            }, {
                name: 'b',
                data: [17.6, 18.5,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5]
            }, {
                name: 'c',
                data: [19.2, 20.2,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5]
            }, {
                name: 'd',
                data: [20.7, 21.4,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5, 17.3,16.5]
            }, {
                name: '目標',
                data: [20, 20,20,20,20,20,20,20,20,20,20,20,20,20,20, 20,20,20,20,20]
            }]
        });
    });
});
</script>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="navbar-header">  
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
             <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button> <a class="navbar-brand" href="#">Bora</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">報表相關<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="#">當日業績表</a>
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li class="divider">
                </li>
                <li>
                  <a href="#">X</a>
                </li>
                <li class="divider">
                </li>
                <li>
                  <a href="#">X</a>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" />
              <input type="text" class="form-control" />
            </div> 
            <button type="submit" class="btn btn-default">
              登入
            </button>
          </form>
          </ul>
        </div>   
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" id='test'></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th>
              No Product(產品名)
            </th>
            <th>
              Actual(實際業績)
            </th>
            <th>
              Target(業績目標)
            </th>
            <th>
              A/T(實際業績/業績目標)
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              1
            </td>
            <td>
              TB - Monthly
            </td>
            <td>
              01/04/2012
            </td>
            <td>
              Default
            </td>
          </tr>
          <tr class="active">
            <td>
              1
            </td>
            <td>
              TB - Monthly
            </td>
            <td>
              01/04/2012
            </td>
            <td>
              Approved
            </td>
          </tr>
          <tr class="success">
            <td>
              2
            </td>
            <td>
              TB - Monthly
            </td>
            <td>
              02/04/2012
            </td>
            <td>
              Declined
            </td>
          </tr>
          <tr class="warning">
            <td>
              3
            </td>
            <td>
              TB - Monthly
            </td>
            <td>
              03/04/2012
            </td>
            <td>
              Pending
            </td>
          </tr>
          <tr class="danger">
            <td>
              4
            </td>
            <td>
              TB - Monthly
            </td>
            <td>
              04/04/2012
            </td>
            <td>
              Call in to confirm
            </td>
            <td>
              Call in to confirm
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--javascript-->
<script type="text/javascript" src="../public/bootstrap331/dist/js/bootstrap.min.js"></script>
</body>
</html>