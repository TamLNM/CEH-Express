

                var rdata=[];
                var jattr="";
                var blockchose=[];
function setLOCK(data){
    if(data.STATUS=="1")
    $(".blocker[block='"+data.BLOCK+"'] .pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"']").append("<div class='palock pall1'></div>");
    else
    if(data.STATUS=="2")
    $(".blocker[block='"+data.BLOCK+"'] .pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"']").append("<div class='palock pall2'></div>");
}
                function load_block(BLOCK,func){
                    
                    $.ajax({
                        url: ROOT_URL+"/"+ajd5,
                        dataType: 'json',
                        data: {BLOCK:BLOCK},
                        type: 'POST',
                        success: function (data) {
                            $('.page-content.fade-in-up').unblock();
                            if(typeof data != "undefined"){
                                $(data).each(function(i,item){
                                    if($(".blocker[block='"+item.BLOCK+"']").length>0)
                                        return false;
                                    make_block(item.BLOCK,item.TIER,item.SLOT);
                                    $(item.STOCK_LIST).each(function(i,stock){
                                        add_item_toblock(stock);
                                    });
                                    $(item.LOCK_LIST).each(function(i,stock){
                                        setLOCK(stock);
                                    });
                                    reload_block(item.BLOCK);                           

                                });
                            }
                            if(typeof func=="function"){
                                func();
                            }
                        },
                        error: function(err){
                            toastr["error"]("Tải dữ liệu thất bại !!");
                            $('.page-content.fade-in-up').unblock();
                    //console.log(err);
                }
            });
                }
function reload_block(blockname){
   var plarr=$(".blocker[block='"+blockname+"']").find(".pallet_i");
   var tong=plarr.length;
   var rc=0;
   $(plarr).each(function(){
    if($(this).find(".ctnitem2,.ctnitem").length>0){
        rc++;
    }
   });
   $(".blocker[block='"+blockname+"']").find(".block_header").html("BLOCK "+blockname+" - SLOT : "+tong+" - CÒN : "+(tong-rc));
}
                function load_item(){
    var recheck=false;
    if($("#list_citem li.active").length>0)
        recheck=$("#list_citem li.active").attr("jdata");
    $.ajax({
        url: ROOT_URL+"/"+ajd6,
        dataType: 'json',
        data: {BLOCK:blockchose},
        type: 'POST',
        success: function (data) {
            $('.page-content.fade-in-up').unblock();
            $("#list_citem").html("");
            if(typeof data.IN[0] != "undefined" || typeof data.OUT[0] != "undefined"){
                var html="";
                rdata=data;
                $(data.OUT).each(function(i,item){
                    html+='<li class="list-group-item outerx flexbox " item-name="'+item.ITEM_CODE+'" seq=\''+item.SEQ_CODE+'\' jdata=\''+JSON.stringify(item)+'\'><span class="flexbox"><i class="la ti-package mr-3 font-40"><i class="dt_an">'+parseFloat(item.cl)+"/"+parseFloat(item.TOTAL)+'</i></i><b class=ite_info><b class=citseq>'+(i+1)+'</b><b class=citcode>'+item.ITEM_CODE+'</b>'+(item.LOT!="" && item.LOT!=null?"<b class=clot>"+item.LOT+"</b>":"")+'<i class="citord">'+item.ORDERNO_OUT+'</i>'+"<br>"+(item.PALLET_NUMBER!="" && item.PALLET_NUMBER!=null?"<b class=cplno>"+item.PALLET_NUMBER+"</b>":"")+'<i class="cittruck">'+item.TRUCKNO_OUT+'</i></b></span></li>';
                });
                $(data.IN).each(function(i,item){
                    html+='<li class="list-group-item flexbox" item-name="'+item.ITEM_CODE+'" seq=\''+item.SEQ_CODE+'\' jdata=\''+JSON.stringify(item)+'\'><span class="flexbox"><i class="la ti-package mr-3 font-40"><i class="dt_an">'+parseFloat(item.ACTUAL_NUMBER)+'</i></i><b class=ite_info><b class=citseq>'+item.SEQNO+'</b><b class=citcode>'+item.ITEM_CODE+'</b>'+(item.LOT!="" && item.LOT!=null?"<b class=clot>"+item.LOT+"</b>":"")+'<i class="citord">'+item.ORDERNO+'</i><br>'+(item.PALLET_NUMBER!="" && item.PALLET_NUMBER!=null?"<b class=cplno>"+item.PALLET_NUMBER+"</b>":"")+'<i class="cittruck">'+item.TRUCKNO+'</i></b></span></li>';
                });

                $("#list_citem").html(html);
                if(recheck!=false){
                    if($("#list_citem li[jdata='"+recheck+"']").length>0)
                        $("#list_citem li[jdata='"+recheck+"']").addClass("active");
                }
                
                
            }
            else
            {
                $("#list_citem").html("");
            }
        },
        error: function(err){
            toastr["error"]("Tải dữ liệu thất bại !!");
            $('.page-content.fade-in-up').unblock();
                    //console.log(err);
                }
            });
}
function find_position(block,slot,tier,data){
$(".ctnitem,.ctnitem2").removeClass("noxi").removeClass("active");
    $(".ctnitem,.ctnitem2").removeClass("targerx");
    $(".ctnitem,.ctnitem2").each(function(){
        var jdata=JSON.parse($(this).attr('jdata'));
        if(jdata.ITEM_CODE==data.ITEM_CODE && jdata.LOT==data.LOT && jdata.PALLET_NUMBER==data.PALLET_NUMBER){
            $(this).addClass("targerx");
        }
        else
        $(this).addClass("noxi");
    });



var block =$(".targerx").first().closest(".blocker").attr("BLOCK");
var slot =$(".targerx").first().closest(".pallet_i").attr("x");
var tier =$(".targerx").first().closest(".pallet_i").attr("y");





    var elm=$(".blocker[block='"+block+"'] .pallet_i[x='"+slot+"'][y='"+tier+"']");
    var top=elm.position().top;
    var left=elm.position().left+elm.closest(".pallet_t").scrollLeft()-elm.closest(".pallet_t").position().left;
    $("html, body").stop().animate({scrollTop: top}, 1000);
    $(".blocker[block='"+block+"'] .pallet_t").stop().animate({scrollLeft: left}, 1000);
    var ite=elm.find(".ctnitem[seq='"+data.SEQ_CODE+"'],.ctnitem2[seq='"+data.SEQ_CODE+"']");
    
    $(".ctnitem[seq='"+data.SEQ_CODE+"'],.ctnitem2[seq='"+data.SEQ_CODE+"']").removeClass("noxi");

    ite.addClass("targerx");
    setTimeout(function(){
        $(".targerx").removeClass("targerx");
    },5000);
}

function load_block_ord(order,func){

    $.ajax({
        url: ROOT_URL+"/"+ajd7,
        dataType: 'json',
        data: {ORDERNO:order},
        type: 'POST',
        success: function (data) {
            $('.page-content.fade-in-up').unblock();
            if(typeof data != "undefined"){
                $(".blocker").hide();
                $(data.BLOCK_LIST).each(function(i,item){
                    if($(".blocker[block='"+item.BLOCK+"']").length>0)
                    {
                        $(".blocker[block='"+item.BLOCK+"']").show();
                        if(typeof func=="function")
                            func();                               
                    }
                    else
                    {
                        load_block(item.BLOCK,func);
                    }

                });
            }
        },
        error: function(err){
            toastr["error"]("Tải dữ liệu thất bại !!");
            $('.page-content.fade-in-up').unblock();
                    //console.log(err);
                }
            });
}







$(document).on("ready",function(){
    load_item();








//-------------------------------------------- SOCKET---------------------------------------------------
var socket = io.connect(wsUri);
socket.on('connect', function(soc){
    socket.emit("tenthietbi","InOut");
});
socket.on('QCheck', function(iData){
    load_item();
});
socket.on('STOCK', function(iData){
    var jdata=JSON.parse(iData);
    console.log(iData);
    load_item();
    if(jdata.sts=="F5"){
        load_item();

    }
    if(jdata.sts=="pintopin"){

        // var badd=true;
        // $(".blocker[block='"+jdata.BLOCK+"'] .pallet_i[x='"+jdata.SLOT+"'][y='"+jdata.TIER+"'] .pal_m").find(".ctnitem2,.ctnitem").each(function(){
        //     var jsdata=JSON.parse($(this).attr("jdata"));
        //     if(jsdata.SEQ_CODE==jdata.SEQ_CODE)
        //         badd=false;
        // });  
        // if(badd)      
        //     add_item_toblock(jdata,jdata.BLOCK,jdata.SLOT,jdata.TIER); 


    }
    if(jdata.sts=="add"){

        var badd=true;
        $(".blocker[block='"+jdata.BLOCK+"'] .pallet_i[x='"+jdata.SLOT+"'][y='"+jdata.TIER+"'] .pal_m").find(".ctnitem2,.ctnitem").each(function(){
            var jsdata=JSON.parse($(this).attr("jdata"));
            if(jsdata.SEQ_CODE==jdata.SEQ_CODE)
                badd=false;
        });  
        if(badd)      
            add_item_toblock(jdata,jdata.BLOCK,jdata.SLOT,jdata.TIER); 


    }
    if(jdata.sts=="update"){
        add_item_toblock(jdata,jdata.BLOCK,jdata.SLOT,jdata.TIER);
   }
   if(jdata.sts=="update_row"){
        $(".flexbox[ROWGUID='"+jdata.ROWGUID.toUpperCase()+"']").find(".dt_an").html(jdata.ACTUAL_NUMBER);
   }
    if(jdata.sts=="remove"){


        $(".blocker[block='"+jdata.BLOCK+"'] .pallet_i[x='"+jdata.SLOT+"'][y='"+jdata.TIER+"'] .pal_m").find(".flexbox.ctnitem,.flexbox.ctnitem2").each(function(){
            var jdata2=JSON.parse($(this).attr("jdata"));
            var parent=$(this).parent();
            if(jdata2.SEQ_CODE==jdata.SEQ_CODE){
                $(this).remove();
            }
            if(parent.find(".flexbox.ctnitem,.flexbox.ctnitem2").length>1)
            {
                parent.find(".flexbox.ctnitem,.flexbox.ctnitem2").removeClass("ctnitem").addClass("ctnitem2");
            }
            else
            {
                parent.find(".flexbox.ctnitem,.flexbox.ctnitem2").removeClass("ctnitem2").addClass("ctnitem");
            }
        });





        if($(".blocker[block='"+jdata.BLOCK+"'] .pallet_i[x='"+jdata.SLOT+"'][y='"+jdata.TIER+"'] .pal_m").html()!=""){
            
            $(".blocker[block='"+jdata.BLOCK+"'] .pallet_i[x='"+jdata.SLOT+"'][y='"+jdata.TIER+"'] .pal_m").find(".flexbox.ctnitem2,.flexbox.ctnitem").each(function(){
                var jdata2=JSON.parse($(this).attr("jdata"));
                if(jdata.SEQ_CODE==jdata2.SEQ_CODE){
                    $(this).remove();
                }
            });


        }
        reload_block(jdata.BLOCK);
    }
});

var isDisconnect = 0;
setInterval(function(){
    if(!socket.connected) {
        toastr.options = {
            "closeButton": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "tapToDismiss": false,
            "onclick": false,
            "timeOut": "0"
        };
        toastr['error']('Mất kết nối đến server! \r\nĐang kết nối lại ... ');
        isDisconnect = 1;
    }

    if(isDisconnect == 1 && socket.connected) {
        isDisconnect = 0;
        $('.toast').remove();
        toastr.options = {
            "closeButton": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "tapToDismiss": true,
            "onclick": null,
            "timeOut": "5000"
        };

        toastr['info']("Đã kết nối!");
    }
}, 1000);


//------------------------------------------------------------------------------------------------------        













$(document).on(evClick,".cblockbtn",function(){

    if($(this).find(".fa").hasClass("fa-circle-o"))
    {
        $(this).find(".fa").removeClass("fa-circle-o");
        $(this).find(".fa").addClass("fa-check-circle-o");
        blockchose.push($(this).attr("idx"));
    }
    else
    {
        $(this).find(".fa").addClass("fa-circle-o");
        $(this).find(".fa").removeClass("fa-check-circle-o");
        var index = blockchose.indexOf($(this).attr("idx"));
        if (index !== -1) blockchose.splice(index, 1);
    }
    
    



});




$(document).on(evClick,".saveblock",function(){
    $("#chose_blocker").hide();
    $(".blocker").remove();
    $(blockchose).each(function(i,item){
        load_block(item);
    });
    $(".blocktext").html(blockchose.join(","));
    load_item();
});

$(document).on(evClick,"#chonblockopen",function(){
    $("#chose_blocker").show();
});

});
function ref_pallet(block,tier,slot){
    var reflen=$(".blocker[block='"+block+"']").find(".pallet_i[x='"+slot+"'][y='"+tier+"'] .pal_m").find(".flexbox.ctnitem2,.flexbox.ctnitem").length;
$(".blocker[block='"+block+"']").find(".pallet_i[x='"+slot+"'][y='"+tier+"'] .pal_m").find(".flexbox.ctnitem2,.flexbox.ctnitem").each(function(){
    if(reflen>1)
    {
        $(this).removeClass("ctnitem2").removeClass("ctnitem").addClass("ctnitem2");
    }else
    {
        $(this).removeClass("ctnitem2").removeClass("ctnitem").addClass("ctnitem");
    }

});

}
function make_block(block,tier,slot){

        if(blockchose.indexOf(block)<0)
            return false;
        var html="";
        if($(".blocker[block='"+block+"']").length>0)
        {
        //return false;
    }
    else
    {
        $("#mainblock").append('<div class="blocker" block="'+block+'"><div class=block_header>BLOCK '+block+'</div><div class=pallet_t_r></div><div class=pallet_t></div></div>');
    }
    for (var i = tier; i >= 0; i--) {
        html+='<div class="pallet_r">';
        for (var j = 0; j <= slot; j++) {
            if(j==0 && i==0)
                $(".blocker[block='"+block+"'] .pallet_t_r").append('<div class="p_i_lr"></div>');
            else
                if(j==0)
                    $(".blocker[block='"+block+"'] .pallet_t_r").append('<div class="p_i_l">'+i+'</div>');
                else
                    if(i==0)
                        html+='<div class="p_i_r">'+j+'</div>';
                    else
                        html+='<div class="pallet_i" y='+i+' x='+j+'><div class="pal_m"></div><div class="pal_lb">'+block+'-'+('0' + i).slice(-2)+'-'+('0' + j).slice(-2)+'</div></div>';
                }
                html+='</div>';
            }
            $(".blocker[block='"+block+"'] .pallet_t").html(html);
        }
function add_item_toblock(data,block,x,y){
   if(typeof block!="undefined")
    data.BLOCK=block;
if(typeof x!="undefined")
    data.SLOT=x;
if(typeof y!="undefined")
    data.TIER=y;
var add_noxi="";
if($("#list_citem .list-group-item.outerx.flexbox.active").length>0){
    var jdata2=JSON.parse($(this).attr("jdata"));
    if(jdata2.SEQ_CODE==data.SEQ_CODE)
        add_noxi="noxi";
}
if(typeof data.OLD_ROWGUID == "undefined")
    data.OLD_ROWGUID="undefined";
else
    data.OLD_ROWGUID=data.OLD_ROWGUID.toUpperCase();


console.log(".blocker[block='"+block+"'].pallet_i[x='"+x+"'][y='"+y+"'] .pal_m.find.flexbox[SEQ_CODE='"+data.SEQ_CODE+"']");
if($(".blocker[block='"+block+"']").find(".pallet_i[x='"+x+"'][y='"+y+"'] .pal_m").find(".flexbox[SEQ='"+data.SEQ_CODE+"']").length>0){
var posdata=parseFloat($(".blocker[block='"+block+"']").find(".pallet_i[x='"+x+"'][y='"+y+"'] .pal_m").find(".flexbox[SEQ='"+data.SEQ_CODE+"']").find(".dt_an").html())||0;
var olddata=parseFloat($(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").find(".dt_an").html())||0;
var newdata=parseFloat(data.ACTUAL_NUMBER)||0;
$(".blocker[block='"+data.BLOCK+"']").find(".pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"'] .pal_m").find(".flexbox[SEQ='"+data.SEQ_CODE+"']").find(".dt_an").html(posdata+newdata);
if(olddata>newdata)
    $(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").find(".dt_an").html(olddata-newdata);
else
    $(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").remove();
ref_pallet(data.OLD_BLOCK,data.OLD_TIER,data.OLD_SLOT);
ref_pallet(block,y,x);
reload_block(data.OLD_BLOCK);
reload_block(block);
return false;
}

var olddata=parseFloat($(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").find(".dt_an").html())||0;
var newdata=parseFloat(data.ACTUAL_NUMBER)||0;
console.log("oltdata:",data,$(".flexbox[ROWGUID='"+data.OLD_ROWGUID.toUpperCase()+"']").find(".dt_an").html());
console.log("oltdata:",olddata,"___newdata:",newdata);
if(olddata>newdata)
    $(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").find(".dt_an").html(olddata-newdata);
else
    $(".blocker[block='"+data.OLD_BLOCK+"']").find(".pallet_i[x='"+data.OLD_SLOT+"'][y='"+data.OLD_TIER+"'] .pal_m").find(".flexbox[ROWGUID='"+data.OLD_ROWGUID+"']").remove();

$(".blocker[block='"+data.BLOCK+"']").find(".pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"'] .pal_m").find(".ctnitem").addClass("ctnitem").removeClass("ctnitem2");
var html='<div class="flexbox ctnitem '+add_noxi+'" ROWGUID=\''+data.ROWGUID.toUpperCase()+'\' ITEM_CODE=\''+data.ITEM_CODE+'\' LOT=\''+data.LOT+'\' PALLET_NUMBER=\''+data.PALLET_NUMBER+'\' seq=\''+data.SEQ_CODE+'\' jdata=\''+JSON.stringify(data)+'\' seq=\''+data.SEQ_CODE+'\'><span class="flexbox"><i class="la ti-package mr-3 font-40"></i><span><b class=bc_n>'+data.ITEM_CODE+'</b>'+(data.LOT!="" && data.LOT!=null?"<b class=bc_lot>"+data.LOT+"</b>":"")+(data.PALLET_NUMBER!="" && data.PALLET_NUMBER!=null?"<b class=bc_pn>"+data.PALLET_NUMBER+"</b>":"")+'</span></span><div class="pl_count"><span class="badge badge-success badge-pill"><i class=dt_an>'+parseFloat(data.ACTUAL_NUMBER)+'</i></span></div></div>';
$(".blocker[block='"+data.BLOCK+"']").find(".pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"'] .pal_m").append(html);
if($(".blocker[block='"+data.BLOCK+"']").find(".pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"'] .pal_m").find(".ctnitem").length>1){
    $(".blocker[block='"+data.BLOCK+"']").find(".pallet_i[x='"+data.SLOT+"'][y='"+data.TIER+"'] .pal_m").find(".ctnitem").addClass("ctnitem2").removeClass("ctnitem");
}
ref_pallet(data.OLD_BLOCK,data.OLD_TIER,data.OLD_SLOT);
ref_pallet(block,y,x);
reload_block(data.OLD_BLOCK);
reload_block(block);
}
$(document).ready(function () {
	





  function make_item_list(data){
   var html="";
   if(data.length>0){
      $(data).each(function(i,item){
         var myJSON = JSON.stringify(item);
         html+='<li class="list-group-item flexbox" item-name=\''+item.ITEM_CODE+'\' seq=\''+item.SEQ_CODE+'\' jdata=\''+myJSON+'\'><span class="flexbox"><i class="la ti-package mr-3 font-40"></i>'+item.ITEM_CODE+'</span><span class="badge badge-success badge-pill"><i class="dt_an">'+item.ACTUAL_NUMBER+'</i> / <i class="dt_en">'+item.ESTIMATED_NUMBER+'</i></span></li>';
     });
      
  }
  $("#list_citem").html(html);

}



$(document).on('input','#ORDERNO',function(){
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
        url: ROOT_URL+"/"+ajd1,
        dataType: 'json',
        data: {"ORDERNO":$(this).val()},
        type: 'POST',
        success: function (data) {
         $('.page-content.fade-in-up').unblock();
         if(data.deny) {
            toastr["error"](data.deny);
            return;
        };
        if(typeof data.ITEM_LIST[0] != "undefined"){
           rdata=data.ITEM_LIST;
           make_item_list(data.ITEM_LIST);
       }
       
   },
   error: function(err){
       $('.page-content.fade-in-up').unblock();
       console.log(err);
   }
});

});




function updatet(index) {
	$("#list_citem .list-group-item.flexbox[item-name='"+rdata[index].ITEM_CODE+"']").find(".dt_an").html(rdata[index].ACTUAL_NUMBER);
	$("#list_citem .list-group-item.flexbox[item-name='"+rdata[index].ITEM_CODE+"']").attr("jdata",JSON.stringify(rdata[index]));
	if(rdata[index].ACTUAL_NUMBER>0)
       $("#list_citem .list-group-item.flexbox[item-name='"+rdata[index].ITEM_CODE+"']").removeClass("error");
   else
       $("#list_citem .list-group-item.flexbox[item-name='"+rdata[index].ITEM_CODE+"']").addClass("error");
}
function add_ite(block,tier,slot,data){
    $.ajax({
        url: ROOT_URL+"/"+ajd2,
        dataType: 'json',
        data: {"BLOCK":block,"TIER":tier,"SLOT":slot,"DATA":data},
        type: 'POST',
        success: function (data) {
            $('.page-content.fade-in-up').unblock();
            if(data.deny) {
                toastr["error"](data.deny);
                return;
            };
            if(data.success) {
                toastr["success"](data.success);
                return;
            };
            
        },
        error: function(err){
            $('.page-content.fade-in-up').unblock();
            console.log(err);
        }
    });

}
function rmv_check(block,tier,slot,dataj,that){
    $('.page-content.fade-in-up').blockUI();
    $.ajax({
        url: ROOT_URL+"/"+ajd3,
        dataType: 'json',
        data: {"BLOCK":block,"TIER":tier,"SLOT":slot,"DATA":dataj},
        type: 'POST',
        success: function (data) {
            $('.page-content.fade-in-up').unblock();
            if(data.deny) {
                toastr["error"](data.deny);
                return;
            };
            if(typeof data[0] != "undefined"){
                if(data.length==1){
                    rmv_ite(block,tier,slot,dataj,data[0]['ROWGUID'],that);
                }
                else{
                    $(".dropdown-menu.show").remove();
                    
                    var eml=$(".blocker[block='"+block+"'] .pallet_i[x='"+slot+"'][y='"+tier+"'] .pal_m").find(".ctnitem[seq='"+dataj.SEQ_CODE+"'],.ctnitem2[seq='"+dataj.SEQ_CODE+"']");
                    var html="";
                    $(data).each(function(i,item){
                        html+='<b class="dropdown-item" rowguid="'+item.ROWGUID+'">'+item.TRUCKNO+'</b>';
                    });
                    $("body").append('<div class="dropdown-menu show ctn_truckcheck" block=\''+block+'\' slot=\''+slot+'\' tier=\''+tier+'\' jdata=\''+JSON.stringify(dataj)+'\'>'+html+'</div>');
                    $(".ctn_truckcheck").data("that",that);
                    $(".dropdown-menu.show").attr("css",'position: fixed; transform: translate3d(0px, 61px, 0px); will-change: transform;');
                    $(".dropdown-menu.show").offset({ top: eml.offset().top, left: eml.offset().left});

                }
            }
        },
        error: function(err){
            $('.page-content.fade-in-up').unblock();
            console.log(err);
        }
    });
}
$(document).on(evClick,".ctn_truckcheck .dropdown-item",function(e){
    e.stopPropagation();
    var rowguid=$(this).attr("rowguid");
    var par=$(this).closest(".ctn_truckcheck");
    var block=par.attr("block");
    var slot=par.attr("slot");
    var tier=par.attr("tier");
    var jdata=JSON.parse(par.attr("jdata"));
    var that=par.data("that");
    $(".ctn_truckcheck").remove();
    rmv_ite(block,tier,slot,jdata,rowguid,that);//
});
$(document).on(evClick,function(e){
 $(".ctn_truckcheck").remove();
});
function rmv_ite(block,tier,slot,dataj,truckgui,that){
    if(truckgui==""){
        $.confirm({
            title: 'Chưa chọn xe chở hàng!',
            type: 'orange',
            icon: 'fa fa-warning',
            content: 'Bạn cần chọn xe chở hàng trước khi dở hàng ?',
            buttons: {
                ok: {
                    text: 'Xác nhận',
                    btnClass: 'btn-warning',
                    keys: ['Enter'],
                    action: function(){
                    }
                },
                cancel: {
                    text: 'Hủy bỏ',
                    btnClass: 'btn-default',
                    keys: ['ESC']
                }
            }
        });
        return false;
    }
    var jdatax=JSON.parse($(that).attr("jdata"));




alertify
  .defaultValue($(that).find(".dt_an").html())
  .prompt("Nhập Số Lượng",
    function (val, ev) {
      ev.preventDefault();
      jdatax['soluong']=val;
      $.ajax({
        url: ROOT_URL+"/"+ajd4,
        dataType: 'json',
        data: {"BLOCK":block,"TIER":tier,"SLOT":slot,"DATA":jdatax,"truckgui":truckgui},
        type: 'POST',
        success: function (data) {
            $('.page-content.fade-in-up').unblock();
            if(data.deny) {
                toastr["error"](data.deny);
                return;
            };
            if(data.success) {
                toastr["success"](data.success);
                $(".blocker[block='"+block+"'] .pallet_i[x='"+slot+"'][y='"+tier+"'] .pal_m").find(".flexbox.ctnitem2,.flexbox.ctnitem").each(function(){
                    var jdata=JSON.parse($(this).attr("jdata"));
                    if(dataj.SEQ_CODE==jdata.SEQ_CODE){
                        $(this).remove();
                    }
                });
                return;
            };
            
        },
        error: function(err){
            $('.page-content.fade-in-up').unblock();
            console.log(err);
        }
    });
    }, function(ev) {
      ev.preventDefault();
      alertify.error("Hủy thao tác");
    }
  );










    
}
function remove_u(that,data){

    var x=$(that).attr("x");
    var y=$(that).attr("y");
    var BL=$(that).closest(".blocker").attr("block");
    var item=JSON.parse($(that).find(".flexbox").attr("jdata"));
    var html='<li class="list-group-item flexbox" item-name=\''+item.ITEM_CODE+'\' seq=\''+item.SEQ_CODE+'\' jdata=\''+$(that).find(".flexbox").attr("jdata")+'\'><span class="flexbox"><i class="la ti-package mr-3 font-40"></i>'+item.ITEM_CODE+' (SEQ:'+item.SEQNO+')</span><span class="badge badge-success badge-pill"><i class="dt_an">'+item.ACTUAL_NUMBER+'</i> / <i class="dt_en">'+item.ESTIMATED_NUMBER+'</i></span></li>';
    $(that).find(".pal_m").html("");
    //$("#list_citem").append(html);
    //rmv_ite(BL,y,x,data);
    return false;


}
function set_jdata(jdata) {
    $(".pal_m[y='"+jdata.TIER+"'][x='"+jdata.SLOT+"'] .flexbox[ITEM_CODE='"+jdata.ITEM_CODE+"'][LOT='"+jdata.LOT+"'][PALLET_NUMBER='"+jdata.PALLET_NUMBER+"'][seq='"+jdata.SEQ_CODE+"']").find(".dt_an").html(jdata.ACTUAL_NUMBER);
    if(parseFloat(jdata.ACTUAL_NUMBER)<=0){
        $(".pal_m .flexbox[ITEM_CODE='"+jdata.ITEM_CODE+"'][LOT='"+jdata.LOT+"'][PALLET_NUMBER='"+jdata.PALLET_NUMBER+"'][seq='"+jdata.SEQ_CODE+"']").remove();
    }
}

function make_u(that,data,sl){
    var x=$(that).attr("x");
    var y=$(that).attr("y");
    var BL=$(that).closest(".blocker").attr("block");
    // var dt2=data;
    // dt2.ACTUAL_NUMBER=parseFloat( data.ACTUAL_NUMBER)-sl;
    // data.TIER=y;
    // data.SLOT=x;
    // data.BLOCK=BL;
    //add_item_toblock(data,BL,x,y);
    data.ACTUAL_NUMBER=sl;
    add_ite(BL,y,x,data);
    //data.ACTUAL_NUMBER=sl;
    //set_jdata(dt2);
    //set_jdata(data);

}

$(document).on(evClick,"#list_citem .list-group-item.flexbox:not(.outerx)",function(e){
	
	$(".ctnitem,.ctnitem2").removeClass("noxi");
    $(".targerx").removeClass("targerx");
    if($(this).hasClass("active")){
      $("#list_citem .list-group-item.flexbox").removeClass("active");
  }
  else
  {
    $("#list_citem .list-group-item.flexbox").removeClass("active");
    $(this).addClass("active");

    var jgdata=JSON.parse($(this).attr("jdata"));
    load_block_ord(jgdata.ORDERNO);
    
    
}

});
$(document).on(evClick,"#list_citem .flexbox.outerx",function(e){
    
    if($(this).hasClass("active")){
        $("#list_citem .list-group-item.flexbox").removeClass("active");
        $(".ctnitem,.ctnitem2").removeClass("noxi");
    }
    else
    {
        $("#list_citem .list-group-item.flexbox").removeClass("active");
        $(this).addClass("active");
        var jgdata=JSON.parse($(this).attr("jdata"));
        load_block_ord(jgdata.ORDERNO,function(){find_position(jgdata.BLOCK,jgdata.SLOT,jgdata.TIER,jgdata);});        
        
    }
    
    
});

$(document).on(evClick,".pallet_i",function(){
	if($(".flexbox.active:not(.outerx)").length>0){
        var newdata=JSON.parse($(".flexbox.active:not(.outerx)").attr("jdata"));
var that=this;
if($(".flexbox.active:not(.outerx)").closest('.slimScrollDiv').length<=0)
{
alertify
  .defaultValue($(".flexbox.active:not(.outerx)").find(".dt_an").html())
  .prompt("Nhập Số Lượng",
    function (val, ev) {
      ev.preventDefault();
      make_u(that,newdata,parseFloat(val));
    }, function(ev) {
      ev.preventDefault();
      alertify.error("Hủy thao tác");
    }
  );
}
else
make_u(that,newdata,parseFloat(newdata.ACTUAL_NUMBER));
		
	}
	else
	{
		
	}

});

$(document).on(evClick,".flexbox.ctnitem2,.flexbox.ctnitem",function(e){
    e.stopPropagation();
    e.preventDefault();
    var that=this;
    if($("#list_citem .list-group-item.flexbox.outerx.active").length>0){

        if($(that).find(".flexbox").length>0){
            //alert("ok");
            var x=$(that).closest(".pallet_i").attr("x");
            var y=$(that).closest(".pallet_i").attr("y");
            var BL=$(that).closest(".blocker").attr("block");
            var item=JSON.parse($("#list_citem .list-group-item.flexbox.outerx.active").attr("jdata"));   
            //if($("#list_citem .list-group-item.flexbox.outerx.active").attr("seq")==$(that).attr("seq")) 
                rmv_check(BL,y,x,item,that);
            return false;
        }
    }
    else
    {
        if($(this).hasClass("active")){
            $(".flexbox.ctnitem2,.flexbox.ctnitem").removeClass("active"); 
        }
        else
        {
            $(".flexbox.ctnitem2,.flexbox.ctnitem").removeClass("active");
            $(this).addClass("active");
        }
        
    }

});













//fix

var fiexdcheck_top=$('#fixed_fload').offset().top;
var fiexdcheck_left=$('#fixed_fload').offset().left;
function fixDiv() {
    if($(window).width()<822)
        return false;
    var $cache = $('#fixed_fload');
    if ($(window).scrollTop() > fiexdcheck_top)
      $cache.css({
        'position': 'fixed',
        'top': fiexdcheck_top+'px',
        'left':fiexdcheck_left+'px',
    });
  else
      $cache.css({
        'position': 'relative',
        'top': 'auto',
        'left': 'auto'
    });
}
$(window).scroll(fixDiv);
fixDiv();





});