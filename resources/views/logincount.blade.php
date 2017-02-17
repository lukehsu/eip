<!DOCTYPE html >
<html>
<head>
    <link rel="stylesheet" href="demos.css" type="text/css" media="screen" />
    <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script src="./bootstrap331/dist/js/RGraph.common.core.js" ></script>
    <script src="./bootstrap331/dist/js/RGraph.bar.js" ></script>
    <script src="./bootstrap331/dist/js/html2canvas.js"></script>

    <title>每月登入次數表</title>
    
    <meta name="robots" content="noindex,nofollow" />
    <meta name="description" content="A Bar chart using labelsAbove" />
</head>
<body>
    <div id="ourdiv">
        <p>GP組本月登入次數</p>
        <div style="padding-left: 35px; display: inline-block">
            <canvas id="gp" width="950" height="300">[No canvas support]</canvas>
        </div>
        <p>HP組本月登入次數</p>
        <div style="padding-left: 35px; display: inline-block">
            <canvas id="hp" width="950" height="300">[No canvas support]</canvas>
        </div>
        <p>聯邦組本月登入次數</p>
        <div style="padding-left: 35px; display: inline-block">
            <canvas id="uni" width="300" height="300">[No canvas support]</canvas>
        </div>
        <p>保健組本月登入次數</p>
        <div style="padding-left: 35px; display: inline-block">
            <canvas id="heal" width="950" height="300">[No canvas support]</canvas>
        </div>
        <p>其他主管本月登入次數</p>
        <div style="padding-left: 35px; display: inline-block">
            <canvas id="others" width="650" height="300">[No canvas support]</canvas>
        </div>
    </div>
    <script>
        var names = [];
        var counts = [];
        var gpjava = {!!$gpjava!!};
        var allnameava = {!!$allnameava!!};
        var i = 0 ;
        $.each(gpjava,function(key,value){
            names[i] = key + ' ' + allnameava[key];
            counts[i] = value;
            i = i + 1 ;
        });
        new RGraph.Bar({
            id: 'gp',
            data: counts,
            options: {
                ymax: 31,
                unitsPost: '',
                labelsAbove: true,
                labelsAboveDecimals: 0,
                labelsAboveUnitsPost: '',
                labelsAboveColor: 'black',
                labelsAboveSize: 10,
                hmargin: 20,
                colors: ['#86B5BC','#E30513','#1C1C1B','#86BC24','#E5007D','#2F8DCD','#F9D900','#F6A200','#BCBCBC'],
                colorsSequential: true,
                labels: names,
                textSize: 10,
                textColor: 'gray',
                backgroundGridVlines: false,
                backgroundGridAutofitNumhlines: 4,
                backgroundGridBorder: false,
                noaxes: true,
                ylabelsCount: 4,
                title: '',
                titleX: 25,
                titleY: 0,
                titleHalign: 'left',
                titleColor: '#999',
                ylabelsOffsetx: -10
            }
        }).grow({frames: 60});
    </script>
    <script>
        var names = [];
        var counts = [];
        var hpjava = {!!$hpjava!!};
        var allnameava = {!!$allnameava!!};
        var i = 0 ;
        $.each(hpjava,function(key,value){
            names[i] = key + ' ' + allnameava[key];
            counts[i] = value;
            i = i + 1 ;
        });
        new RGraph.Bar({
            id: 'hp',
            data: counts,
            options: {
                ymax: 31,
                unitsPost: '',
                labelsAbove: true,
                labelsAboveDecimals: 0,
                labelsAboveUnitsPost: '',
                labelsAboveColor: 'black',
                labelsAboveSize: 10,
                hmargin: 20,
                colors: ['#86B5BC','#E30513','#1C1C1B','#86BC24','#E5007D','#2F8DCD','#F9D900','#F6A200','#BCBCBC'],
                colorsSequential: true,
                labels: names,
                textSize: 10,
                textColor: 'gray',
                backgroundGridVlines: false,
                backgroundGridAutofitNumhlines: 4,
                backgroundGridBorder: false,
                noaxes: true,
                ylabelsCount: 4,
                title: '',
                titleX: 25,
                titleY: 0,
                titleHalign: 'left',
                titleColor: '#999',
                ylabelsOffsetx: -10
            }
        }).grow({frames: 60});
    </script>
    <script>
        var names = [];
        var counts = [];
        var unijava = {!!$unijava!!};
        var allnameava = {!!$allnameava!!};
        var i = 0 ;
        $.each(unijava,function(key,value){
            names[i] = key + ' ' + allnameava[key];
            counts[i] = value;
            i = i + 1 ;
        });
        new RGraph.Bar({
            id: 'uni',
            data: counts,
            options: {
                ymax: 31,
                unitsPost: '',
                labelsAbove: true,
                labelsAboveDecimals: 0,
                labelsAboveUnitsPost: '',
                labelsAboveColor: 'black',
                labelsAboveSize: 10,
                hmargin: 20,
                colors: ['#86B5BC','#E30513','#1C1C1B','#86BC24','#E5007D','#2F8DCD','#F9D900','#F6A200','#BCBCBC'],
                colorsSequential: true,
                labels: names,
                textSize: 10,
                textColor: 'gray',
                backgroundGridVlines: false,
                backgroundGridAutofitNumhlines: 4,
                backgroundGridBorder: false,
                noaxes: true,
                ylabelsCount: 4,
                title: '',
                titleX: 25,
                titleY: 0,
                titleHalign: 'left',
                titleColor: '#999',
                ylabelsOffsetx: -10
            }
        }).grow({frames: 60});
    </script>
    <script>
        var names = [];
        var counts = [];
        var healjava = {!!$healjava!!};
        var allnameava = {!!$allnameava!!};
        var i = 0 ;
        $.each(healjava,function(key,value){
            names[i] = key + ' ' + allnameava[key];
            counts[i] = value;
            i = i + 1 ;
        });
        new RGraph.Bar({
            id: 'heal',
            data: counts,
            options: {
                ymax: 31,
                unitsPost: '',
                labelsAbove: true,
                labelsAboveDecimals: 0,
                labelsAboveUnitsPost: '',
                labelsAboveColor: 'black',
                labelsAboveSize: 10,
                hmargin: 20,
                colors: ['#86B5BC','#E30513','#1C1C1B','#86BC24','#E5007D','#2F8DCD','#F9D900','#F6A200','#BCBCBC'],
                colorsSequential: true,
                labels: names,
                textSize: 10,
                textColor: 'gray',
                backgroundGridVlines: false,
                backgroundGridAutofitNumhlines: 4,
                backgroundGridBorder: false,
                noaxes: true,
                ylabelsCount: 4,
                title: '',
                titleX: 25,
                titleY: 0,
                titleHalign: 'left',
                titleColor: '#999',
                ylabelsOffsetx: -10
            }
        }).grow({frames: 60});
    </script>
    <script>
        var names = [];
        var counts = [];
        var otherjava = {!!$otherjava!!};
        var allnameava = {!!$allnameava!!};
        var i = 0 ;
        $.each(otherjava,function(key,value){
            names[i] = key + ' ' + allnameava[key];
            counts[i] = value;
            i = i + 1 ;
        });
        new RGraph.Bar({
            id: 'others',
            data: counts,
            options: {
                ymax: 31,
                unitsPost: '',
                labelsAbove: true,
                labelsAboveDecimals: 0,
                labelsAboveUnitsPost: '',
                labelsAboveColor: 'black',
                labelsAboveSize: 10,
                hmargin: 20,
                colors: ['#86B5BC','#E30513','#1C1C1B','#86BC24','#E5007D','#2F8DCD','#F9D900','#F6A200','#BCBCBC'],
                colorsSequential: true,
                labels: names,
                textSize: 10,
                textColor: 'gray',
                backgroundGridVlines: false,
                backgroundGridAutofitNumhlines: 4,
                backgroundGridBorder: false,
                noaxes: true,
                ylabelsCount: 4,
                title: '',
                titleX: 25,
                titleY: 0,
                titleHalign: 'left',
                titleColor: '#999',
                ylabelsOffsetx: -10
            }
        }).grow({frames: 60});
    </script>
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
                $.getScript("./bootstrap331/dist/js/pic_1.js");
            },5000)
        })
    </script>
</body>
</html>