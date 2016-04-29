<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <form class="navbar-form navbar-left" method="POST" action="sign">
            <div class="form-group">
              <input type="text" id="name" name="name" class="form-control" />
              <input type="text" id="password" name="password"  class="form-control" />
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            </div> 
            <button type="submit" class="btn btn-default">
              登入
            </button>
          </form>
            </div>
        </div>
    </body>
</html>
