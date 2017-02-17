

//var testdiv = document.getElementById("ourdiv");
//把ourdiv轉為canvas
    var Today = new Date(); 
    var preDate = Today;
    html2canvas($("#ourdiv"), {
        onrendered: function(canvas) {
        // canvas is the final rendered <canvas> element
      	var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        var b = (preDate.getDate());
        var c = '';
        if (b<=9) {
            c = 0;
        };
        var d = (preDate.getMonth()+1);
        var e = '';
        if (d<=9) {
            e = 0;
        };
        a.href = canvas.toDataURL();
        a.download = preDate.getFullYear()+'-'+ e + (preDate.getMonth()+1)+'-'+ c +(preDate.getDate())+'.jpg';
        a.click();
        }
    });

