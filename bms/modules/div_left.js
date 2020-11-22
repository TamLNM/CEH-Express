if (screen.width>1024)
{	
	document.write('<div id="divStayTopleft" style="position:absolute;display:none;">');
	var verticalpos="fromtop";
	document.write('</div>');
        divleft_timeout=false;
	function JSFX_FloatTopDiv()
	{
        var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;        
        $('#divStayTopleft').show();
		var startX = 5,
		startY = y-$('#divStayTopleft').height()>0?(y-$('#divStayTopleft').height())/2:5;
		var ns = (navigator.appName.indexOf("Netscape") != -1);
		function ml(id)
		{
			var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
			if(d.layers)el.style=el;
			el.sP=function(x,y){this.style.right=($(window).width()+5-($(window).width()-1000)/2)+'px';this.style.top=y+'px';};
			el.x = startX;
			if (verticalpos=="fromtop")
			el.y = startY;
			else{
			el.y = ns ? pageYOffset + innerHeight : document.body.scrollTop + document.body.clientHeight;
			el.y -= startY;
			}
			return el;
		}
		window.stayTop=function()
		{              
			if (verticalpos=="fromtop"){
			var pY = ns ? pageYOffset : document.body.scrollTop;
			ftlObj.y += (pY + startY - ftlObj.y)/8;
			}
			else{
			var pY = ns ? pageYOffset + innerHeight : document.body.scrollTop + document.body.clientHeight;
			ftlObj.y += (pY - startY - ftlObj.y)/8;
			}
            if(ftlObj.y+$('#divStayTopleft').height()<$(document).height()) {
                ftlObj.sP(ftlObj.x, ftlObj.y);
            }
			divleft_timeout=setTimeout("stayTop()", 20);
		}
		ftlObj = ml("divStayTopleft");
		stayTop();
	}
	divleft_timeout=setTimeout("JSFX_FloatTopDiv()",2000);
}
