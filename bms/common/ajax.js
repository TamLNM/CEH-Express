	//Writen by Do Thanh Hai
	//Copyright EDAJSC@2006	
 	
	function createAjaxObj(){
		var ajax_request=false;
		if (window.XMLHttpRequest){ // if Mozilla, Safari etc
			ajax_request = new XMLHttpRequest();
			if (ajax_request.overrideMimeType)
			ajax_request.overrideMimeType('text/xml')
		}
		else if (window.ActiveXObject)
		{ // if IE
			try 
			{
				ajax_request = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch (e)
			{
				try
				{
					ajax_request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e){}
			}
		}
		if (!ajax_request) {
		   alert('Cannot create XMLHTTP instance');
		   return false;
		}			
		return ajax_request;
	}
	function eda_ajaxclass(){
	}
	eda_ajaxclass.prototype.basedomain="http://"+window.location.hostname;
	eda_ajaxclass.prototype.ajaxobj=false;//createAjaxObj();
	eda_ajaxclass.prototype.filetype="txt";
	eda_ajaxclass.prototype.addrandomnumber=0; //Set to 1 or 0. See documentation.
	eda_ajaxclass.prototype.getAjaxRequest=function(url, parameters, callbackfunc, filetype){
		this.ajaxobj=createAjaxObj(); //recreate ajax object to defeat cache problem in IE
		if (this.addrandomnumber==1) //Further defeat caching problem in IE?
		var parameters=parameters+"&ajaxcachebust="+new Date().getTime();
		if (this.ajaxobj){
		this.filetype=filetype;
		this.ajaxobj.onreadystatechange=callbackfunc;
		this.ajaxobj.open('GET', url, true);
		this.ajaxobj.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		if(this.ajaxobj.overrideMimeType)
		//this.ajaxobj.overrideMimeType('text/html');
		//this.ajaxobj.setRequestHeader("Connection", "close");
		this.ajaxobj.send(null);
		}
	}
	eda_ajaxclass.prototype.postAjaxRequest=function(url, parameters, callbackfunc, filetype){
		this.ajaxobj=createAjaxObj(); //recreate ajax object to defeat cache problem in IE
		//if (this.ajaxobj){
		this.filetype=filetype;
		this.ajaxobj.onreadystatechange = callbackfunc;
		this.ajaxobj.open('POST', url, true);
		this.ajaxobj.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		if(this.ajaxobj.overrideMimeType)
		//this.ajaxobj.overrideMimeType('text/html');
		this.ajaxobj.setRequestHeader("Content-length", parameters.length);
		//this.ajaxobj.setRequestHeader("Connection", "close");
		this.ajaxobj.send(parameters);
	}
	function load(url,containerid,containertype,method,parameters,showstatus,funcs)
	{
		var eda_ajax=new eda_ajaxclass();
		if(method=="GET")
			eda_ajax.getAjaxRequest(url, null, function(){loadact(eda_ajax, containerid,containertype,showstatus,funcs);}, "txt");
		else
			eda_ajax.postAjaxRequest(url, parameters, function(){loadact(eda_ajax, containerid,containertype,showstatus,funcs);}, "txt");
		self.status='Runing...';
		if(containertype=="listbox")
		{
			document.getElementById(containerid).disabled=true;
		}		
		return eda_ajax;
	}
	function loadact(ajax_request, containerid,containertype,showstatus,funcs){
		if (ajax_request.ajaxobj.readyState == 4 && (ajax_request.ajaxobj.status==200 || window.location.href.indexOf("http")==-1))
		{
			if(containertype=="listbox")
			{
				add_listbox(document.getElementById(containerid),ajax_request.ajaxobj.responseText);
				document.getElementById(containerid).disabled=false;
			}
			else if(containertype=="func")
				eval(containerid+"('"+escape(ajax_request.ajaxobj.responseText)+"')");
			else if(containertype=="set_val")
			{
				document.getElementById(containerid).value=ajax_request.ajaxobj.responseText;				
			}
			else
				document.getElementById(containerid).innerHTML=ajax_request.ajaxobj.responseText;
			if(showstatus!='no')
			document.getElementById("loadid").style.visibility='hidden';
			self.status='Completed';
			if(containerid!="categories" && containertype=="html")
			{
				//window.scrollTo(0,0);
				document.getElementById("loadid").style.top=document.body.scrollTop+2;
			}
			ajax_request = null;
			eda_request=false;
		}
		else
		{
			 if(showstatus!='no' && showstatus!='in')
			 {
				document.getElementById("loadid").style.visibility='visible';
				document.getElementById("loadid").style.top=document.body.scrollTop+2;
				document.getElementById("loadid").innerHTML = '<img src="bms/images/loading.gif" width=18> &nbsp;<a class=tabcat style="color:green" href="javascript:ajax_abort(ajax_request)">'+showstatus+'</a>';
			 }
			 else if(showstatus=='in')
			 	 document.getElementById(containerid).innerHTML = '<img src="bms/images/loading.gif" width=18>&nbsp;<a class=tabcat style="color:green" href="javascript:ajax_abort(ajax_request)"> Đang tải dữ liệu...</a>';
		}
		
		if(typeof funcs != "undefined"){
			funcs();
		}
	}
	function ajax_abort(ajax_request)
	{
		ajax_request.ajaxobj.abort();
		document.getElementById("loadid").style.visibility='hidden';
		self.status='';
		ajax_request = false;	
	}
	function addOption(obj,text,value,selected)
	{
		var color='';
		var bold='';
		var dis='';
		var val='';
		var tmp=text;
		if(obj!=null && obj.options!=null && text!=null && value!=null)
		{
			if(text.indexOf('</selected>')>0)
			{
				tmp=text.split("</selected>");
				val=tmp[0];
				text=tmp[1];
			}			
			if(text.indexOf('</color>')>0)
			{
				tmp=text.split("</color>");
				color=tmp[0];
				text=tmp[1];
			}
			if(text.indexOf('</bold>')>0)
			{
				tmp=text.split("</bold>");
				bold=tmp[0];
				text=tmp[1];
			}
			if(text.indexOf('</disabled>')>0)
			{
				tmp=text.split("</disabled>");
				dis=tmp[0];
				text=tmp[1];
			}							
			obj.options[obj.options.length] = new Option(text, value, false, selected);
			if(color!='')
				obj.options[obj.options.length-1].style.color=color;
			if(bold!='')
				obj.options[obj.options.length-1].style.fontWeight=bold;
			if(val!='')
				obj.options[obj.options.length-1].selected=true;				
			if(dis!='')
			{
				obj.options[obj.options.length-1].disabled=true;
				obj.options[obj.options.length-1].style.backgroundColor='#eeeeee';
			}

		}
	}
	function add_listbox(containerid,responseText)
	{
		reset(containerid);
		//alert(responseText);
		responseText= responseText.split("</name>");
		if(isArray(responseText))
		{
			for(var i=0;i<responseText.length-1;i++)
			{
				tmp=responseText[i].split("</value>");
				if(isArray(tmp))
				{
					addOption(containerid,tmp[1],tmp[0],false);
				}
			}
		}
	}
	function reset(from)
	{
		if(from==null || from.options==null)
		{
			return;
		}
		for(var i=(from.options.length-1);i>=0;i--)
		{
			if(i>0 || (i==0 && !(from.options[i].value=='' || from.options[i].value==-1 || from.options[i].value==' ' || from.options[i].value==0)))
			from.options[i] = null;
		}
		from.selectedIndex = 0;
	}
	function isArray(obj)
	{
		return(typeof(obj.length)=="undefined")?false:true;
	}
	function ajax_delrow(url,obj,tb,showstatus)
	{
		var eda_ajax=new eda_ajaxclass();
		eda_ajax.getAjaxRequest(url, null, function(){delrowexec(eda_ajax,obj,tb,showstatus);}, "txt");
		self.status='Runing...';
		return eda_ajax;
	}
	function delrowexec(ajax_request,obj,tb,showstatus)
	{
		if (ajax_request.ajaxobj.readyState == 4 && (ajax_request.ajaxobj.status==200 || window.location.href.indexOf("http")==-1))
		{
			if(ajax_request.ajaxobj.responseText.search("executedok")!=-1)
			{
				delrow(obj,tb);
			}
			else
				alert('Undeleted');
			if(showstatus!='no')
			document.getElementById("loadid").style.visibility='hidden';			
			ajax_request=false;
			self.status='Complete';
		}
		else if(showstatus!='no')
		{
			document.getElementById("loadid").style.visibility='visible';
			document.getElementById("loadid").style.top=document.body.scrollTop+2;
			document.getElementById("loadid").innerHTML = '<img src="bms/images/loading.gif" width=18>&nbsp;<a class=tabcat href=javascript:ajax_abort(ajax_request)>'+showstatus+'</a>';
		}
	}
	function getPost(frm)
	{
		v="";t=Array();j=0;
		name="";
		t[0]="";
		for(i=0; i<document.forms[frm].elements.length;i++)
		{
		if(document.forms[frm].elements[i].type!="button" && document.forms[frm].elements[i].type!="submit" && (document.forms[frm].elements[i].type=="password" || document.forms[frm].elements[i].type=="select-one" || document.forms[frm].elements[i].type=="text" || document.forms[frm].elements[i].type=="hidden" || (document.forms[frm].elements[i].type=="checkbox" && document.forms[frm].elements[i].checked) || (document.forms[frm].elements[i].type=="radio" && document.forms[frm].elements[i].checked) || document.forms[frm].elements[i].type=="textarea"))
		{
			if(document.forms[frm].elements[i].name!=name)
			{
				if(t.length==1)
					v+="&"+name+"="+t[j];
				else
				{
					v+="&"+name+"="+serialize(t);
				}
				t=Array();j=0;
				name=document.forms[frm].elements[i].name;
				if(document.forms[frm].elements[i].type=="textarea" && typeof(tinyMCE)!='undefined')
				{
					t[0]=tinyMCE.get(document.forms[frm].elements[i].id).getContent().replace("&","và");
				}
				else
					t[0]=document.forms[frm].elements[i].value.replace("&","và");
			}
			else
			{
				if(document.forms[frm].elements[i].type=="textarea" && typeof(tinyMCE)!='undefined')
					t[++j]=tinyMCE.get(document.forms[frm].elements[i].id).getContent().replace("&","và");
				else
					t[++j]=document.forms[frm].elements[i].value.replace("&","và");
			}
		}
		}
		if(j==0)
			v+="&"+name+"="+t[0];
		else
		{
			v+="&"+name+"="+serialize(t);
		}
		return encodeURI(v);
	}
	function serialize(a)
	{
		var v="";
		for(var i=0; i<a.length;i++)
			v+=a[i]+'[eda_array]';
		return v;
	}		
	var eda_request = false;
