

//var testdiv = document.getElementById("ourdiv");
//把ourdiv轉為canvas
    var Today=new Date();
    html2canvas($("#ourdiv"), {
        onrendered: function(canvas) {
        // canvas is the final rendered <canvas> element
      	var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        var b = (Today.getDate()-1);
        var c = '';
        if (b<=9) {
            c = 0;
        };
        var d = (Today.getMonth() +1 );
        var e = '';
        if (d<=9) {
            e = 0;
        };
        a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
        a.download = Today.getFullYear()+'-'+ e + (Today.getMonth()+1)+'-'+ c +(Today.getDate()-1)+'.jpg';
        a.click();
        }
    });

