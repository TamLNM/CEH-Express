if (screen.width>1024)
{	
	document.write('<div id="divStayTopright" style="position:absolute;display:none;">');
	var verticalposr="fromtop";
	document.write('</div>');
        divright_timeout=false;
	function JSFX_FloatTopDiv_Right()
	{
        var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;          
        $('#divStayTopright').show();
		var startXr = screen.width-160,
		startYr = y-$('#divStayTopright').height()>0?(y-$('#divStayTopright').height())/2:5;
		var ns = (navigator.appName.indexOf("Netscape") != -1);
		function mlr(id)
		{
			var elr=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
			if(d.layers)el.style=elr;
			elr.sP=function(x,y){this.style.left=(($(window).width()-1000)/2+1005)+'px';this.style.top=y+'px';};
			elr.x = startXr;
			if (verticalposr=="fromtop")
			elr.y = startYr;
			else{
			elr.y = ns ? pageYOffset + innerHeight : document.body.scrollTop + document.body.clientHeight;
			elr.y -= startYr;
			}
			return elr;
		}
		window.stayTopright=function()
		{
                    
			if (verticalposr=="fromtop"){
			var pYr = ns ? pageYOffset : document.body.scrollTop;
			ftlObjr.y += (pYr + startYr - ftlObjr.y)/8;
			}
			else{
			var pYr = ns ? pageYOffset + innerHeight : document.body.scrollTop + document.body.clientHeight;
			ftlObjr.y += (pYr - startYr - ftlObjr.y)/8;
			}
                        if(ftlObjr.y+$('#divStayTopright').height()<$(document).height()) {
                            ftlObjr.sP(ftlObjr.x, ftlObjr.y);
                        }
			divright_timeout=setTimeout("stayTopright()", 20);
		}
		ftlObjr = mlr("divStayTopright");
		stayTopright();
	}
	divright_timeout=setTimeout("JSFX_FloatTopDiv_Right()",2000);
}
