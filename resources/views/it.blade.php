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
@include('includes.navbar')
    <div class="col-md-10 col-md-offset-1" style="padding-bottom:12px;box-shadow:3px 3px 5px 6px #cccccc;">
      <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="row">
            <div class="col-md-3" style="margin-left:40px;" >
                <div class="row">
                    <div class="col-md-12"><label>單號:</label><br><p id="ordernumber">it{!!$ordernumber!!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><label>部門:</label><input  type="text" id="dep"  value="{!!$dep!!}"  class="form-control inputformat" {!!$disabled!!} /></div>
                    <div class="col-md-6"><label>日期:</label><input  type="text" id="date" value="{!!$today!!}"  class="form-control inputformat" {!!$disabled!!} /></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><label>員編:</label><input  type="text" id="enumber" value="{!!$enumber!!}"  class="form-control inputformat" {!!$disabled!!}  /></div>
                    <div class="col-md-6"><label>姓名:</label><input  type="text" name="name" id="name" value="{!!$name!!}"  class="form-control inputformat" {!!$disabled!!} /></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label>需求項目:</label>
                        <section class="main"  >
                            <div class="wrapper-demo" >
                                <div name="items" id="dd" class="wrapper-dropdown-3" tabindex="1" style="{!!$style!!}">
                                    <input type="hidden" name="items" id="hiddenitems" value="">
                                    <span id="items">{!!$items!!}</span>
                                        <ul  class="dropdown uiscroll"  >
                                            <li><a href="#"><i></i>硬體相關</a></li>
                                            <li><a href="#"><i></i>軟體相關</a></li>
                                            <li><a href="#"><i></i>密碼相關</a></li>
                                            <li><a href="#"><i></i>ERP相關</a></li>
                                            <li><a href="#"><i></i>資訊系統服務申請</a></li>
                                            <li><a href="#"><i></i>其他</a></li>
                                        </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!--隱藏用-->
                <!--div style="display:{!!$none!!}">
                <div class="row">
                    <div class="col-md-12" >
                        <label>回覆使用者:</label>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><textarea id="itresponse" style="font-size:12px;border:2px #ccc solid;border-radius:10px;width:100%;"  rows="3"   placeholder="處理方式...." {!!$disable!!}></textarea></div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-top:0px;">
                        <button type="submit" id="noway" class="btn  btn-danger">否</button>
                    </div>
                    <div class="col-md-6" style="margin-top:0px;">
                        <button type="submit" id="yesway" class="btn  btn-info">是</button>
                    </div>
                </div> 
                </div-->    
            </div>  
            <div class="col-md-4" >
                <div class="row">
                    <div class="col-md-12" ><label>問題說明:</label><textarea id="description" style="border:2px #ccc solid;border-radius:10px;width:100%;" rows="18"  cols="20" {!!$disabled!!} >{!!$description!!}</textarea></div>
                </div>
            </div>    
            <div class="col-md-3" >
                <div class="row">
                    <div class="col-md-12"><label>回覆意見:</label><textarea id="response"  style="border:2px #ccc solid;border-radius:10px;width:100%;"  rows="8"  cols="20" {!!$disable!!}></textarea></div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top:90px"><!--label>單據下一流程:</label><br>{!!$name!!}<br>↓<br>{!!$dep!!}主管--></div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-top:63px;">
                        <button type="submit" class="btn btn-block btn-lg btn-default disabled">退單</button>
                    </div>
                    <div class="col-md-6" style="margin-top:63px;">
                        <button type="submit" id="done" class="btn btn-block btn-lg btn-info">送出</button>
                    </div>
                </div> 
            </div> 
        </div>
    </div>  
</div>
<!-- javascript -->
    <script type="text/javascript">     
            function DropDown(el) {
                this.dd = el;
                this.placeholder = this.dd.children('span');
                this.opts = this.dd.find('ul.dropdown > li');
                this.val = '';
                this.index = -1;
                this.initEvents();
            }
            DropDown.prototype = {
                initEvents : function() {
                    var obj = this;

                    obj.dd.on('click', function(event){
                        $(this).toggleClass('active');
                        return false;
                    });

                    obj.opts.on('click',function(){
                        var opt = $(this);
                        obj.val = opt.text();
                        obj.index = opt.index();
                        obj.placeholder.text(obj.val);
                    });
                },
                getValue : function() {
                    return this.val;
                },
                getIndex : function() {
                    return this.index;
                }
            }
            $(function() {
                var dd = new DropDown( $('#dd') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#done').click(function(){
                $('#hiddenitems').val($('#items').text().trim());
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/itreceive',
                    data: {ordernumber: $("#ordernumber").text() , dep: $("#dep").val(), date: $("#date").val() , enumber: $("#enumber").val() , name: $("#name").val() , items: $("#hiddenitems").val() , description: $("#description").val(), response: $("#response").val()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        $("#items").text('請選擇');
                        $("#description").val('');
                        $("#ordernumber").text('it'+data.ordernumber);
                        alert('已送出，案件完成後，系統會寄出滿意度回覆表，請務必填寫，完成後方可以在建立新的資訊需求單，謝謝');
                        document.location.href="http://127.0.0.1/eip/public/dashboard";
                    },
                    error: function(xhr, type){
                        alert('??');
                    }
                });  
            });
            $('#yesway').click(function(){
                $('#hiddenitems').val($('#items').text().trim());
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/itrespone',
                    data: {ordernumber: $("#ordernumber").text() , dep: $("#dep").val(), date: $("#date").val() , enumber: $("#enumber").val() , name: $("#name").val() , items: $("#hiddenitems").val() , description: $("#description").val()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        alert('已送出 謝謝');
                        document.location.href="http://127.0.0.1/eip/public/dashboard";
                    },
                    error: function(xhr, type){
                        alert('??');
                    }
                });  
            });
        });
    </script>
</body>
</html>