<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>Bora-EIP</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/jquery.pwstabs.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery.pwstabs.js"></script>

  <style type="text/css">

a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,table,tbody,td,tfoot,th,thead,time,tr,tt,u,ul,var,video
{margin:0;padding:0;border:0;font-size:100%;font-family:'微軟正黑體',arial,helvetica,sans-serif;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1;background-color:#fff}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:'';content:none}table{border-collapse:collapse;border-spacing:0}
/*#129793,;font-family:'Roboto Condensed',arial,helvetica,sans-serif*/
.main {
  width: 1366px;
  margin: 0 auto; 
}
.header{
   width: 100%;
   display: block;
   text-align: center;
   padding: 20px 0;
   font-size: 15px;
   color: #505050;
   background-color: #fff;
   margin-bottom: 30px;
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
}
.header h1{
   font-size: 60px;
   font-weight: bold;
   color: #ff7260;
   margin: 0 0 15px 0;
   padding: 0;
}
.header a{
   color: #ff7260;
   font-size: 15px;
   text-decoration: underline;
}
.header a:hover{
   color: #505050;
}

.header p{
   margin: 6px 0;
   padding: 0;
   font-size: 15px;
   color: #505050;
}
.header p.header_buttons{
   margin-top: 15px;
}
.header p.header_buttons a{
   background-color: #ff7260;
   color: #fff;
   display: inline-block;
   text-align: center;
   padding: 10px 30px;
   margin: 0 10px;
   text-decoration: none;
   text-transform: uppercase;
}
p.header_buttons a:hover{
   background-color: #9bd7d5;
}
.content{
   width: 940px;
   display: block;
   margin: 0 auto;
}
.content.demo_responsive{
   width: 100%;
   padding: 0 20px;
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
}
.content h2{
   font-size: 40px;
   font-weight: bold;
   color: #fff;
   margin-bottom: 30px;
   margin-top: 30px;
}
.content h3{
   font-size: 35px;
   font-weight: 300;
   color: #fff;
   margin-bottom: 15px;
   margin-top: 25px;
}
.content a{
   color: #fff5c3;
   text-decoration: underline;
}
.content a:hover{
   color: #fff;
   text-decoration: none;
}
.content code{
   width: 100%;
   background-color: #f0f0f0;
   display: block;
   padding: 20px;
   color: #000;
   letter-spacing: 0.5px;
   font-size: 16px;
   font-weight: normal;
   margin: 15px 0 30px 0;
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
}
.content p{
   color: #fff;
   font-size: 17px;
   margin: 15px 0;
}
.content strong{
   font-weight: bold;
   font-size: 17px;
   color: #fff5c3;
}
.content code strong{
   color: #000;
}
.content table{
   background-color: #fff;
   width: 100%;
}
.content table thead tr th{
   border: 1px solid #505050;
   padding: 8px;
   font-size: 17px;
   color: #ff7260;
   font-weight: bold;
}
.content table tr:nth-child(even) td{
   background-color: #f0f0f0;
}
.content .pws_example_mixed_content_block{
   width: 900px;
   position: relative;
}
.content .pws_example_mixed_content_block:after{
   display: block;
   content: '';
   clear: both;
}
.content .pws_example_mixed_content_left{
   width: 350px;
   position: relative;
   float: left;
   display: block;
}
.content .pws_example_mixed_content_right{
   width: 550px;
   position: relative;
   float: left;
   display: block;
   color: #505050;
}
.content .pws_example_mixed_content_right h3,
.content .pws_example_mixed_content_right p{
   margin: 0 0 15px 0;
   color: #505050;
}
table tbody tr td{
   border: 1px solid #505050;
   padding: 8px;
   font-size: 17px;
   color: #505050;
   font-weight: 300;
}
/* Demo colors */
.content .pws_demo_colors{
   display: block;
   margin: 15px 0;
}

.content .pws_demo_colors_title{
    color:#fff;
    vertical-align:top;
    display:inline-block;
    width:120px;
    height:30px;
    
    padding:6px 0 0 0;
    
    box-sizing:border-box;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
}

.content .pws_demo_colors a{
   width: 30px;
   height: 30px;
   display: inline-block;
   border: 3px solid #fff;
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
}
.content .pws_demo_colors a[data-demo-color="cyan"],
.content .pws_demo_colors a[data-demo-color="dark_cyan"]{
   background-color: #9bd7d5;
}
.content .pws_demo_colors a[data-demo-color="violet"],
.content .pws_demo_colors a[data-demo-color="dark_violet"]{
   background-color: #c72c66;
}
.content .pws_demo_colors a[data-demo-color="green"],
.content .pws_demo_colors a[data-demo-color="dark_green"]{
   background-color: #86c447;
}
.content .pws_demo_colors a[data-demo-color="yellow"],
.content .pws_demo_colors a[data-demo-color="dark_yellow"]{
   background-color: #fdb813;
}
.content .pws_demo_colors a[data-demo-color="gold"],
.content .pws_demo_colors a[data-demo-color="dark_gold"]{
   background-color: #f89827;
}
.content .pws_demo_colors a[data-demo-color="orange"],
.content .pws_demo_colors a[data-demo-color="dark_orange"]{
   background-color: #f15b42;
}
.content .pws_demo_colors a[data-demo-color="red"],
.content .pws_demo_colors a[data-demo-color="dark_red"]{
   background-color: #e41937;
}
.content .pws_demo_colors a[data-demo-color="purple"],
.content .pws_demo_colors a[data-demo-color="dark_purple"]{
   background-color: #672e8d;
}
.content .pws_demo_colors a[data-demo-color="grey"],
.content .pws_demo_colors a[data-demo-color="dark_grey"]{
   background-color: #4d4d4f;
}

.pa{
	padding-top: 10px;

}

  </style>  
    <script>
    jQuery(document).ready(function ($) {
        $('.tabset0').pwstabs();
        $('.tabset1').pwstabs({
            effect: 'scale',
            defaultTab: 3,
            //containerWidth: '600px',
        });
        // Colors Demo
        $('.pws_demo_colors a').click(function (e) {
            e.preventDefault();
            $('.pws_tabs_container').removeClass('pws_theme_cyan pws_theme_grey pws_theme_violet pws_theme_green pws_theme_yellow pws_theme_gold pws_theme_orange pws_theme_red pws_theme_purple pws_theme_dark_cyan pws_theme_dark_grey pws_theme_dark_violet pws_theme_dark_green pws_theme_dark_yellow pws_theme_dark_gold pws_theme_dark_orange pws_theme_dark_red pws_theme_dark_purple').addClass('pws_theme_'+$(this).attr('data-demo-color') );
        });
    });
    </script>
</head>
<body>
<div class="container-fluid main">
  @include('includes.navbar')
	<div class="row">
    	<div class="col-xs-9" >
      		<div class="tabset0">
         	  <div id='t1' data-pws-tab="tab1" data-pws-tab-name="資訊需求單" class="col-xs-12" >
					     <div class="row" style="height:30px">
    					   <div class="col-xs-1" style="padding:0px 10px;">
							     <h2>項目</h2>
    					   </div>
    					   <div class="col-xs-2">
							     <h2>日期</h2>
    					   </div>
    					   <div class="col-xs-2">
							     <h2>部門</h2>
    					   </div>	
    					   <div class="col-xs-2">
							     <h2>姓名</h2>
    					   </div>	
    					   <div class="col-xs-2">
							     <h2>需求</h2>
    					   </div>	
    					   <div class="col-xs-3">
							     <h2>說明</h2>
    					   </div>			
					     </div>
					     <div class="row">
    					   <div class="col-xs-12" style="height:2px;background-color:#95A5A6"></div>			
					     </div>
               {!!$itservice!!}
						   <div class="row">
    					   <div class="col-xs-12" style="height:2px;margin-top:8px;background-color:#95A5A6"></div>			
					     </div>
               <div class="row" style="margin-top:8px">
                 <div class="col-xs-2" ><a id="selectall"  class="btn btn-info">全選</a></div>  
                 <div class="col-xs-offset-7 col-xs-2"><a id="submitall"  class="btn btn-info">送出</a></div>     
               </div>
         		</div>
            <div id='t2'  data-pws-tab="tab2" data-pws-tab-name="資訊" class="col-xs-12" >
               <div class="row" style="height:30px">
                 <div class="col-xs-1">
                   <h2>項目</h2>
                 </div>
                 <div class="col-xs-2">
                   <h2>日期</h2>
                 </div>
                 <div class="col-xs-2">
                   <h2>部門</h2>
                 </div> 
                 <div class="col-xs-2">
                   <h2>姓名</h2>
                 </div> 
                 <div class="col-xs-2">
                   <h2>需求</h2>
                 </div> 
                 <div class="col-xs-3">
                   <h2>說明</h2>
                 </div>     
               </div>
               <div class="row">
                 <div class="col-xs-12" style="height:2px;background-color:#95A5A6"></div>      
               </div>
               
               <div class="row">
                 <div class="col-xs-12" style="height:2px;margin-top:8px;background-color:#95A5A6"></div>     
               </div>
            </div>
          </div>
		</div>
		<div class="col-xs-3" >

		</div>
	</div>		
</div> 
  <script type="text/javascript" src="./bootstrap331/dist/js/vendor/jquery.min.js"></script> 
  <script type="text/javascript" src="./bootstrap331/dist/js/flat-ui.min.js"></script> 
  <script type="text/javascript" src="./bootstrap331/dist/js/application.js"></script> 
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>  
<script type="text/javascript">
  $(document).ready(function() {
    var count = true;
    $('#selectall').click(function(){
      if (count) 
      {
        $("input[name='itbox']").each(function(){
          $(this).prop("checked",true);
        });
        count = false;
      }
      else
      {
        $("input[name='itbox']").each(function(){
          $(this).prop("checked",false);
        });   
        count = true;    
      } 

    });
    $('#submitall').click(function()
    {
      var submitorder = [];
      for (var i = 1; i <= {!!$icount!!}; i++) {
        if ($('#checkbox'+i).prop("checked"))
        {
          submitorder.push($('#ordernumber'+i).val());
        } 
      };
                $.ajax({
                    type: 'POST',
                    url: '/eip/public/quickok',
                    data: {ordernum:submitorder},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    success:  function(data){
                        alert('您的需求單已送出 謝謝');
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