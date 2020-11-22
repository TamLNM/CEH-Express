function onUnloadHandler(){
    if(self.VBArray){
        var e = self.event, s = self.screen;
        if(e.clientX + s.width < 0
            && e.clientY + s.height < 0
            && typeof(window.onclose) == "function"){
            window.onclose();
        }
    }
}
onunload =onUnloadHandler;
function onclose(){
    window.location='index.php?eda_act=f24f62eeb789199b9b2e467df3b1876b';
}
function chkenter (evt) {
    var keyCode = document.layers ? evt.which : document.all ?
    evt.keyCode : evt.keyCode;
    if (keyCode == 13)
        return true;
    else {
        return false;
    }
}
function getposx(e)
{
    var posx=0;
    if (!e)
        var e = window.event||window.Event;		
    if (e.pageX || e.pageY)
        posx = e.pageX;
    else if (e.clientX || e.clientY)
        posx = e.clientX;
    return posx;
}
function getposy(e)
{
    var posy=0;
    if (!e)
        var e = window.event||window.Event;		
    if (e.pageX || e.pageY)
        posy = e.pageY;
    else if (e.clientX || e.clientY)
        posy = e.clientY;
    return posy;
}	 

var cur_div_move='no';
var eX=0;
var eY=0;
var cur_div='no';
var cur_index=50;
function move_window(e)
{
    if (!e)
        var e = window.event||window.Event;		
    var posx=getposx(e);
    var posy=getposy(e);
    if(cur_div_move!='no')
    {
        x=posx-eX ;
        y=posy-eY;
        eX=posx;
        eY=posy;
        document.getElementById(cur_div_move+'div').style.left=parseInt(document.getElementById(cur_div_move+'div').style.left)+x;
        document.getElementById(cur_div_move+'div').style.top=parseInt(document.getElementById(cur_div_move+'div').style.top)+y;
        if(document.getElementById(cur_div_move+'iframe'))
        {
            document.getElementById(cur_div_move+'iframe').style.left=parseInt(document.getElementById(cur_div_move+'iframe').style.left)+x;
            document.getElementById(cur_div_move+'iframe').style.top=parseInt(document.getElementById(cur_div_move+'iframe').style.top)+y;
			
        }
    }
}
function hidediv(d)
{
    document.getElementById(d+'div').style.zIndex =cur_index;
    if(document.getElementById(d+'iframe'))
        document.getElementById(d+'iframe').style.zIndex =cur_index-1;		
    document.getElementById(d+'div').style.visibility='hidden';
    if(document.getElementById(d+'iframe'))
        document.getElementById(d+'iframe').style.visibility='hidden';
    cur_div='no';
}
function maxdiv(d)
{
    if($('#'+d+'div').attr('max')==="min") {
        $('#'+d+'div').attr('oldwidth',$('#'+d+'div').css("width"));
        $('#'+d+'div').attr('oldheight',$('#'+d+'div').css("height"));
        $('#'+d+'div').attr('oldtop',$('#'+d+'div').css("top"));
        $('#'+d+'div').attr('oldleft',$('#'+d+'div').css("left"));
        $('#'+d+'div').css({width:'100%',height:'100%',top:0,left:0});
        if($('#dataid').length>0) {
            $('#dataid').attr('oldwidth',$('#dataid').css("width"));
            $('#dataid').attr('oldheight',$('#dataid').css("max-height"));
            $('#dataid').css({width:'',"max-height":''});
        }
        $('#'+d+'div').attr('max',"max");
    } else {
        $('#'+d+'div').css({width:$('#'+d+'div').attr('oldwidth'),height:$('#'+d+'div').attr('oldheight'),top:$('#'+d+'div').attr('oldtop'),left:$('#'+d+'div').attr('oldleft')});
        if($('#dataid').length>0) {
            $('#dataid').css({width:$('#dataid').attr('oldwidth'),"max-height":$('#dataid').attr('oldheight')});
        }
        $('#'+d+'div').attr('max',"min");
    }
}
function closediv(d)
{
    hidediv(d);
    l=(screen.width-1000)/2+160;
    document.getElementById(d+'div').style.left=l; 
    document.getElementById(d+'div').style.top='50px';
    if(document.getElementById(d+'iframe'))
    {
        document.getElementById(d+'iframe').style.left=l; 
        document.getElementById(d+'iframe').style.top='50px';			
    }
}
function showdiv(d)
{
    var l=($(window).width()-$('#'+d+'div').width())/2;
    document.getElementById(d+'div').style.left=l+'px';
    document.getElementById(d+'div').style.top=(document.body.scrollTop+20)+"px";		
    document.getElementById(d+'iframe').style.left=l+'px';
    document.getElementById(d+'iframe').style.top=(document.body.scrollTop+20)+"px";		
    if(document.getElementById(d+'head'))
        document.getElementById(d+'head').style.backgroundImage='url(bms/images/head_bg.gif)';
    document.getElementById(d+'div').style.visibility='visible';
    document.getElementById(d+'iframe').style.visibility='visible';
    if(cur_div!=d)
    {
        if(cur_div!='no')
        {
            if(document.getElementById(cur_div+'head'))
                document.getElementById(cur_div+'head').style.backgroundImage='url(bms/images/head_bg_dis.gif)';
            document.getElementById(cur_div+'div').style.zIndex =cur_index;
            document.getElementById(cur_div+'iframe').style.zIndex =cur_index-1;
        }
        if(document.getElementById(d+'head'))
            document.getElementById(d+'head').style.backgroundImage='url(bms/images/head_bg.gif)';
        document.getElementById(d+'div').style.zIndex =52;
        document.getElementById(d+'iframe').style.zIndex =51;
    }
    cur_div=d;
    cur_div_move='no';
}
function divclick(d,e)
{
    if(cur_div!=d)
    {
        if(cur_div!='no')
        {
            if(document.getElementById(cur_div+'head'))
                document.getElementById(cur_div+'head').style.backgroundImage='url(bms/images/head_bg_dis.gif)';
            document.getElementById(cur_div+'div').style.zIndex =cur_index;
            if(document.getElementById(d+'iframe'))
                document.getElementById(cur_div+'iframe').style.zIndex =cur_index-1;
        }
        if(document.getElementById(d+'head'))
            document.getElementById(d+'head').style.backgroundImage='url(bms/images/head_bg.gif)';
        document.getElementById(d+'div').style.zIndex =52;
        if(document.getElementById(d+'iframe'))
            document.getElementById(d+'iframe').style.zIndex =51;
    }
    cur_div_move=d;
    cur_div=d;
    if (!e)
        var e = window.event||window.Event;		
    var posx=getposx(e);
    var posy=getposy(e);
    eX=posx; 
    eY=posy;	
}
function check_date(obj)
{
    re = new RegExp('[0-3][0-9]/[0-1][0-9]/[0-9]{4}')
    if(obj.value!='' && !obj.value.match(re))
    {
        alert('Hãy nhập dữ liệu dạng ngày tháng dd/mm/yyyy');
        obj.focus();
        obj.value='';
    }
}		 
function obj_filter(obj,o)
{
    if(navigator.appVersion.indexOf("IE")>0)
    {
        obj.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+o+")";
        if(o==100)
            obj.style.filter="";
    }
    else
    {
        o=o/100;
        obj.style.MozOpacity=o;
        obj.style.Opacity=o;
        obj.style.khtmlOpacity=o;
    }
}	 
function dropCategory(obj){
    if(obj.className == "on"){
        obj.className = "off";
    }
    else{
        obj.className = "on";
    }
}

function popUp(location, w, h , resizable, screenX, screenY, menubar , scrollbars) 
{
    if( w == null ) {
        w = 400;
    }
    if( h == null ) {
        h = 200;
    }
    if(screenX == null) screenX = (screen.width-w)/2;
    if(screenY == null) screenY = (screen.height-h)/2-50;
    if( menubar == null) menubar = "0";
    if(scrollbars == null) scrollbars="0";
    if(resizable == null) resizable="0";	

    var toolbar = "'menubar="+menubar+",scrollbars="+scrollbars+", resizable="+resizable+",screenX="+screenX+",screenY="+screenY+", top="+screenY+", left="+screenX+",width="+w+",height="+h+"'";
    var editorWin = window.open(location,'editWin', toolbar);
    editorWin.focus(); 
}


//kiem tra email
function isEmail(s)
{   
    if (s=="") return false;
    if(s.indexOf(" ")>0) return false;
    if(s.indexOf("@")==-1) return false;
    var i = 1;
    var sLength = s.length;
    if (s.indexOf(".")==-1) return false;
    if (s.indexOf("..")!=-1) return false;
    if (s.indexOf("@")!=s.lastIndexOf("@")) return false;
    if (s.lastIndexOf(".")==s.length-1) return false;
    var str="abcdefghikjlmnopqrstuvwxyz-@._"; 
    for(var j=0;j<s.length;j++)
        if(str.indexOf(s.charAt(j))==-1)
            return false;
    return true;
}
function strtoint(v) {
    if(v=='') {
        return 0;
    }
    return parseInt(v.replace(/\,/g,''));
}
function strtofloat(v) {
    if(v=='') {
        return 0;
    }
    return parseFloat(v.replace(/\,/g,''));
}
/*
 function format(input){
	var vl=input.value?input.value:input;
	if(vl=='') {
		input.value='';
		return true;
	} 
  var num = vl.replace(/\,/g,'');
  num = num.replace(/\./g,'');
   if(!isNaN(num)){
     if(num.indexOf(',') > -1){
        num = num.split(',');
        num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.').split('').reverse().join('').replace(/^[\.]/,'');
       if(num[1].length > 0){
          num[1] = num[1].substring(0,num[1].length-1);
       }  input.value = num[0]+'.'+num[1];        
     } else { 
     	input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.').split('').reverse().join('').replace(/^[\.]/,'');
     }
   }
   else{ 
        // input.value = input.value.substring(0,input.value.length-1);
        input.value='';
   }
 }
 */
function format(input){
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
        if(num.indexOf('.') > -1){
            num = num.split('.');
            num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
            if(num[1].length > 5){
                num[1] = num[1].substring(0,num[1].length-1);
            }
            input.value = num[0]+'.'+num[1];
        } else{
            input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'')
            };
    }
    else{ 
        input.value = input.value.substring(0,input.value.length-1);
    }
}	
function formatnumber(num,n,p) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
        num = "0";
    var n=n||',';
    var p=p||'.';
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
        cents = "0" + cents;
    if(cents==0)
    {
        cents="";
        p="";
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+n+
        num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + num + p + cents);
}		

function numF(num,n,p){
    return formatnumber(num,n,p);
}
function numR(num){
    return num.replace(/[^0-9]/g, "");
}
function check_number(control)
{
    if(isNaN(control.value))
    {
        alert('Hãy nhập dữ liệu dạng số');
        control.value=0;
    }
    if(control.value=='')
        control.value=0;
} 

function format_number(pnumber,decimals){
    if (isNaN(pnumber)) {
        return 0
        };
    if (pnumber=='') {
        return 0
        };
	var decimals=decimals||0;
    var snum = new String(pnumber);
    var sec = snum.split('.');
    var whole = parseFloat(sec[0]);
    var result = '';
	
    if(sec.length > 1){
        var dec = new String(sec[1]);
        dec = String(parseFloat(sec[1])/Math.pow(10,(dec.length - decimals)));
        dec = String(whole + Math.round(parseFloat(dec))/Math.pow(10,decimals));
        var dot = dec.indexOf('.');
        if(dot == -1){
            dec += '.'; 
            dot = dec.indexOf('.');
        }
        while(dec.length <= dot + decimals) {
            dec += '0';
        }
        result = dec;
    } else{
        var dot;
        var dec = new String(whole);
        dec += '.';
        dot = dec.indexOf('.');		
        while(dec.length <= dot + decimals) {
            dec += '0';
        }
        result = dec;
    }	
    return result;
}
function tabOnEnter (field, evt) {
    var keyCode = document.layers ? evt.which : document.all ?
    evt.keyCode : evt.keyCode;
    if (keyCode != 13 || field.type=='button' || field.type=='textarea')
        return true;
    else {
        var el=getNextElement(field);
        if (el.type!='hidden' && el.disabled==false && el.readOnly==false)
            el.focus();
        else
            while (el.type=='hidden' || el.disabled==true || el.readOnly==true)
                el=getNextElement(el);
        el.focus();
        return false;
    }
}
function getNextElement (field) {
    var form = field.form;
    for (var e = 0; e < form.elements.length; e++) {
        if (field == form.elements[e])
            break;
    }
    return form.elements[++e % form.elements.length];
}
function serializefiles (frm) {
    var obj = $(frm);
    /* ADD FILE TO PARAM AJAX */
    var formData = new FormData();
    $.each($(obj).find("input[type='file']"), function(i, tag) {
        $.each($(tag)[0].files, function(i, file) {
            formData.append(tag.name, file);
        });
    });
    var params = $(obj).serializeArray();
    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });
    return formData;
};



function fnExcelReportx()
{
    var tab_text="<table border='2px'>";
    var textRange;
    var j=0;
    tab = $(".auto_excel_tbl").eq(0); // id of table
    //alert($(tab).find("thead tr").html());
    var theader="";
    $(tab).find("thead tr").each(function(i,tr){
        var trr="<tr>"
        $(this).find("th,td").each(function(ii,td){
            if($(this).is(":visible"))
            trr+="<td bgcolor='"+($(this).attr("bgcolor")||"#bddcef")+"' bgcolor='#bddcef' valign='middle' align='center' width='"+$(this).outerWidth()+"' colspan="+($(this).attr("colspan")||1)+" rowspan="+($(this).attr("rowspan")||1)+"><b>"+$(this).text()+"</b></td>";
        });
        trr+="</tr>";
        theader+=trr;
    });
    //console.log(theader);
    tab_text+=theader;
var tbody="";
    $(tab).find("tbody tr").each(function(i,tr){
        var trr="<tr>"
        $(tr).find("td").each(function(ii,td){
            if($(this).is(":visible"))
            trr+="<td bgcolor='"+($(this).attr("bgcolor")||"#FFFFFF")+"' colspan="+($(this).attr("colspan")||1)+" rowspan="+($(this).attr("rowspan")||1)+" align='"+($(this).attr("align")||"")+"'>"+$(this).text()+"</td>";
        });
        trr+="</tr>";
        tbody+=trr;
        
    });
    tab_text+=tbody;
    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
// $("html").html(tab_text);
// setInterval(function(){
//     $("html").html("<div>"+tab_text+"</div>");
// });
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xlsx");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}




$(document).ready(function(){





if($(".auto_excel_tbl").length>0){
    $("a.cart_payment b:contains('Xuất Excel')").closest("a").attr("onclick","");
}

$(document).on("click","a.cart_payment b:contains('Xuất Excel')",function(e){
    e.stopPropagation();
    e.preventDefault();
    fnExcelReportx();
});












load_alert();
$(document).on("click",".alert_ico",function(){
    $(".alert_ico_box").toggleClass("openx");
    load_alert();
});

});


function load_alert(){
    
    $.ajax({
        url : "?eda_act=2705a83a5a0659cce34583972637eda5&eda_code=54d19a515e559f1d940c89b51141a92a",
        dataType: 'json',
        type: 'post',
        data : {
            action : 'load_bell'
        },
        success: function(data){
           console.log(data);
           var html="";
           if(typeof data['exp'][0] !="undefined" || typeof data['qty'][0] !="undefined"){

            if(typeof data['exp'][0] !="undefined")
            $(data['exp']).each(function(i,item){
                if(item.day<0){
                    html+="<div class='ite_alert'>"+item.quantity+" "+item.mat_name+" (HSD:"+item.exp_date+") của kho ["+item.stock_name+"] đã quá hạn "+Math.abs(item.day)+" ngày</div>";
                }else
                if(item.day==0){
                    html+="<div class='ite_alert text_danger'>"+item.quantity+" "+item.mat_name+" (HSD:"+item.exp_date+") của kho ["+item.stock_name+"] hôm nay là quá hạn</div>";
                }else
                if(item.day>0){
                    html+="<div class='ite_alert text_warning'>"+item.quantity+" "+item.mat_name+" (HSD:"+item.exp_date+") của kho ["+item.stock_name+"] còn "+Math.abs(item.day)+" ngày là quá hạn</div>";
                }
            });

            if(typeof data['qty'][0] !="undefined")
            $(data['qty']).each(function(i,item){
                
                    html+="<div class='ite_alert'>"+item.mat_name+" còn "+item.s_qty+"/"+item.alert_qty+" sản phẩm</div>";
                
            });

            if($(".alert_ico").length<=0){
                $("body").append("<div class=alert_ico></div>");
                $("body").append("<div class=alert_ico_box>"+html+"</div>");
            }
            else
            {
                $(".alert_ico_box").html(html);
            }
            
           }
           else{
            $(".alert_ico").remove();
            $(".alert_ico_box").remove();
           }
        }
    });
    
}