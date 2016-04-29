<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>每月數量分析表</title>
    <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
    <link rel="stylesheet"  href="./bootstrap331/dist/css/droplist.css">
    <link rel="stylesheet"  href="./bootstrap331/dist/css/bubble.css">
    <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
    <style type="text/css">
        .plusa:hover{
            background-color: #ECF0F1;
        }
        .plusb:hover{
            background-color: #ECF0F1;
        }
        .plusc:hover{
            background-color: #ECF0F1;
        }
    </style>
</head>
<body style="font-family:微軟正黑體">
<div class="container-fluid">
    @include('includes.navbar')  
    <div class="row">
        <!--頁面上的加號-->  
        <div  class="col-md-1">
            <span id="plus1" class="fui-plus-circle" style="padding:28px;"></span>
            <p id="pp1" class="triangle-border left" style="display:none;position:absolute;z-index:10;top:-32px;left:46px;cursor: pointer;" ><!--<span class="plusc">季度</span><br>--><span class="plusa">藥品</span><br><span class="plusb">業務</span></p>
        </div>
        <!--第一區-->
        <div id="searchc" class="col-md-2" style="display:block" >
            <!--<div style="position:absolute;z-index:9;top:-14px;left:200px;cursor: pointer"><span id="close3" class="fui-cross-circle" ></span></div>-->
            <div class="wrapper-demo" >
                <div name="items"  id="dd3" class="wrapper-dropdown-3" tabindex="1" style="padding:3px;" >
                    <input type="hidden" name="season" id="season" value="">
                    <span id="items3">請選擇年分</span>
                    <ul  class="dropdown utscroll"  >
                        @foreach($seasons as $season)
                            <li><a href="#"><i></i>
                            {!!$season!!}
                            </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
       <!--第二區-->  
        <div  id="searcha12" class="col-md-3" style="display:none;width:340px"  >
            <div style="position:absolute;z-index:9;top:-14px;left:310px;cursor: pointer"><span id="close1" class="fui-cross-circle"></span></div>
            <div class="wrapper-demo" >
                <div name="items" id="dd12" class="wrapper-dropdown-3" tabindex="1" style="padding:3px;" >
                    <input type="hidden" name="company" id="company" value="">
                    <span id="items12">請選擇產品別</span>
                    <ul  class="dropdown utscroll"  >
                            <li><a href="#"><i></i>
                            保瑞
                            </a></li>
                            <li><a href="#"><i></i>
                            聯邦
                            </a></li>
                            <li><a href="#"><i></i>
                            其他
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--第三區-->
        <div id="searchb" class="col-md-2" style="display:none;width:230px">
            <div style="position:absolute;z-index:9;top:-14px;left:200px;cursor: pointer"><span id="close2" class="fui-cross-circle" ></span></div>
            <div class="wrapper-demo" >
                <div name="items" id="dd2"  class="wrapper-dropdown-3" tabindex="1" style="padding:3px;" >
                    <input type="hidden" name="accname" id="accname" value="">
                    <span id="items2" >請選擇業務</span>
                    <ul  class="dropdown utscroll"  >
                        @foreach($allaccounts as $allaccount)
                            <li><a href="#"><i></i>
                            {!!$allaccount!!}
                            </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >  
        <div  id="searcha" class="col-md-offset-3 col-md-3" style="display:none;width:340px;margin-top:18px"  >
            <div class="wrapper-demo" >
                <div name="items" id="dd1" class="wrapper-dropdown-3" tabindex="1" style="padding:3px;" >
                    <input type="hidden" name="medicine" id="medicine" value="">
                    <span id="items1">請選擇藥品</span>
                    <ul  class="dropdown utscroll" id="medicinechname"  >

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div  id="searcha1" class="col-md-offset-3 col-md-3" style="display:none;width:340px;margin-top:18px"  >
            <div class="wrapper-demo" >
                <div name="items" id="dd11" class="wrapper-dropdown-3" tabindex="1" style="padding:3px;" >
                    <input type="hidden" name="medicinecode" id="medicinecode" value="">
                    <span id="items11">請選擇產品規格或編號</span>
                    <ul  class="dropdown utscroll" id="itemcodes"  >

                    </ul>
                </div>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-offset-4 col-md-2" style="margin-top:18px"><button id="done" class="btn btn-block btn-lg btn-info">送出</button></div> 
        <form id="form1" name="form1" method="post" action="transferajax">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <input type="hidden" name="medicinefrom" id="medicinefrom" value="">
        <input type="hidden" name="accnamefrom" id="accnamefrom" value="">
        <input type="hidden" name="seasonfrom" id="seasonfrom" value="">
        <input type="hidden" name="itemcodefrom" id="itemcodefrom" value="">
        <div class="col-md-2" style="margin-top:18px"><button id="transferexcel" class="btn btn-block btn-lg btn-info" disabled="disabled">轉出excel</button></div>
        </form>
    </div>
    <div class="row" style="margin-top:10px;">
      <div class="col-md-12" style="border-bottom:#1ABC9C 5px double;"></div>
    </div>
    <div class="row" id="tablezone">
        <div class="col-xs-12">
            <table class="table table-condensed">
                <thead id='tabhead'>
                </thead>
                <tbody id='tabbody'>                 
                </tbody>
            </table>    
        </div>
    </div>    
</div>
<!-- javascript -->
    <script type="text/javascript">
        $('#plus1').click(function(){
            $('#pp1').fadeIn(100);
            //$('#pp').animate({ left:'46px' }, 600 ,'swing');
        });
    </script>
    <script type="text/javascript">
        $('#close1').click(function(){
            $('#searcha').fadeOut(100);
            $('#searcha1').fadeOut(100);
            $('#searcha12').fadeOut(100);     
            $('#items1').text("請選擇藥品");
        });
        $('#close2').click(function(){
            $('#searchb').fadeOut(100);  
            $('#items2').text("請選擇業務");
        });
        $('#close3').click(function(){
            $('#searchc').fadeOut(100); 
            $('#items3').text("請選擇季度");  
        });
        $('.plusa').click(function(){
            $('#searcha').fadeIn(500);
            $('#searcha1').fadeIn(500);
            $('#searcha12').fadeIn(500);
            $('#pp1').fadeOut(100);     
        });
        $('.plusb').click(function(){
            $('#searchb').fadeIn(500);
            $('#pp1').fadeOut(100);
        });
        $('.plusc').click(function(){
            $('#searchc').fadeIn(500);
            $('#pp1').fadeOut(100); 
        });
    </script>
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
                var dd = new DropDown( $('#dd1') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
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
                var dd = new DropDown( $('#dd11') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
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
                var dd = new DropDown( $('#dd12') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
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
                var dd = new DropDown( $('#dd2') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
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
                var dd = new DropDown( $('#dd3') );
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });
            });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            //$("#tablezone").fadeToggle(3000);
            $('#done').click(function(){
                $('#transferexcel').removeAttr("disabled");
                $('#medicine').val($('#items1').text().trim());
                $('#accname').val($('#items2').text().trim());
                $('#season').val($('#items3').text().trim()); 
                $('#tabhead').html('');
                $('#tabbody').html('');
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/itemscountajax',
                    data: {itemcode: $('#items11').text(), medicine: $("#medicine").val() , accname: $("#accname").val() , season: $("#season").val()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        
                        $('#medicinefrom').val($('#items1').text().trim());
                        $('#itemcodefrom').val( $('#items11').text());
                        $('#accnamefrom').val($('#items2').text().trim());
                        $('#seasonfrom').val($('#items3').text().trim());

                        $('#tabhead').append('<tr>');
                        $.each(data.titles, function (key,data) {
                            $('#tabhead').append('<th class="text-center">'+data+'</th>');
                        });
                        $('#tabhead').append('</tr>'); 
                        $('#tabbody').append(data.report);
                 

                    },
                    error: function(xhr, type){
                        alert('??');
                    }
                });  
            });
        });
    </script>
    <script type="text/javascript">
        /*$(document).ready(function() {
            //$("#tablezone").fadeToggle(3000);
            $('#transferexcel1').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/transferajax',
                    data: {medicine: $("#medicine").val() , accname: $("#accname").val() , season: $("#season").val()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                    window.open('http://127.0.0.1/eip/public/itemscount','_blank' );

                    },
                    error: function(xhr, type){
                        alert('??');
                    }
                });  
            });
        });*/
    </script>
    <script type="text/javascript">
            $('#items12').on('DOMNodeInserted',function(){
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/company',
                    data: {company:$('#items12').text().trim(),season:$('#items3').text().trim()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        $('#items1').text('請選擇藥品');
                        $('#medicinechname').text('');
                        $.each(data.itemchname, function (key,data) {
                            $('#medicinechname').append('<li><a href="#">'+data+'</a></li>');
                        });
                        $("#medicinechname li").on("click", function(){    
                            $('#items1').text($(this).text()).trim;
                        });
                    },
                    error: function(xhr, type){
                        alert('??');                
                    }
                });
            });
    </script>
    <script type="text/javascript">
            $('#items1').on('DOMNodeInserted',function(){
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/medicinecode',
                    data: {medicine:$('#items1').text().trim(),season:$('#items3').text().trim()},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        $('#items11').text('請選擇產品規格或編號');
                        $('#itemcodes').text('');
                        $.each(data.codes, function (key,data) {
                            $('#itemcodes').append('<li><a href="#">'+data+'</a></li>');
                        });
                        $("#itemcodes li").on("click", function(){    
                            $('#items11').text($(this).text()).trim;
                        });
                    },
                    error: function(xhr, type){
                        alert('??');                
                    }
                });
            });
    </script>
    <script type="text/javascript">
       /* $(document).ready(function() {
            $('#items11').click(function(){
                $("#itemcodes li").on("click", function(){    
                    $('#items11').text($(this).text()).trim;
                });
            });
        });*/
    </script> 
</body>
</html>