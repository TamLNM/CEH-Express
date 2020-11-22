var ismobile=false;
			$(document).ready(function () {

				if($(window).width()<=768)
					ismobile=true;




function back_btn_fnc(){
	
	if($("#contenttable").closest(".himb").is(":visible")){
		$("#trucktable").closest(".himb").hide();
		$("#item_table").closest(".himb").hide();
		$("#contenttable").closest(".himb").hide();
		$("#item_table").closest(".himb").show();
		$("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() {
		});
	}
	else
	if($("#item_table").closest(".himb").is(":visible")){
		$("#trucktable").closest(".himb").hide();
		$("#item_table").closest(".himb").hide();
		$("#contenttable").closest(".himb").hide();
		$("#trucktable").closest(".himb").show();
		$("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() {
		});
	}
	else
	if($("#trucktable").closest(".himb").is(":visible")){
		
	}
}



$(document).on(evClick,".back_btn",function(){
back_btn_fnc();
});










				$( ".selectpicker" ).selectmenu();
				var _columns = ["STT", "Code", "Name", "Description", "Unit", "ItemGroup", "SKU", "NetWeight","CustomerNo"];

				var tbl = $('#contenttable');
				var dataTbl = tbl.DataTable({
					scrollY: 'auto',
					columnDefs: [
					{ type: "num", className: "text-center", targets: _columns.indexOf("STT") }
					],
					order: [[ 0, 'asc' ]],
					paging: false,
					keys:true,
					select: true,
					rowReorder: false
				});
				var flg = false;
				$(document).on("change", ".clItemCode", function(e){
					if( flg ){
						flg = false;
						e.preventDefault();
						return;
					};
					flg = true;
					var currentCell = $( e.target );
			var currentRow = currentCell.closest('tr'); // var currentRow = currentCell.parent();
			if ($( e.target ).hasClass('clItemCode')) {
				var item = cbItem.filter( p => p.Name == currentCell.text() )[0];
				var cellItemData = "<input class='hiden-input' value='"+ item.Code +"' > " + item.Name;
				vGridDetails.DataTable().cell(currentRow.find( "td:eq("+_colGirdDetails.indexOf("ItemCode")+")")).data(cellItemData);

				var cellUnitCode = currentRow.find( "td:eq("+ _colGirdDetails.indexOf("Unit") + ")" );
				var cellUnitData = "<input class='hiden-input' value="+ item.Unit +" >" + item.UnitName;
				vGridDetails.DataTable().cell(cellUnitCode).data( cellUnitData );
				vGridDetails.DataTable().cell(currentRow.find( "td:eq("+_colGirdDetails.indexOf("NetWeight")+")")).data(item.NetWeight);
				vGridDetails.DataTable().draw(false);
			};
		});


				$(document).on(evClick,".ui-switch.switch-icon.switch-solid-success.switch-large",function(e){
					e.stopPropagation();
					e.preventDefault();
					$(this).find("input[type='checkbox']").prop("checked",!$(this).find("input[type='checkbox']").prop("checked"));
				});
//-------------------------------------------- SOCKET---------------------------------------------------
var socket = io.connect(wsUri);
socket.on('connect', function(soc){
	socket.emit("tenthietbi","InOut");
});
socket.on('truck_alert', function(iData){
	var jdata=JSON.parse(iData);
	if(jdata.com=="truck_alert"){
		toastr['success'](jdata.mes);
		get_truck_in();
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






$("#item_table").DataTable({
	scrollY: 'auto',
	columnDefs: [
	{ type: "num", className: "text-center", targets:0 }
	],
	order: [[ 0, 'asc' ]],
	paging: false,
	keys:false,
	select: false,
	rowReorder: false,
	"initComplete": function(settings, json) {
		$('#item_table_wrapper .datatable-info-right').css({"margin-right":"0px","padding-top":"3px"}).append('<button id="barcode_scan" class="btn btn-outline-success btn-sm mr-1" title="Quét Barcode"><span class="btn-icon"><i class="fa fa-barcode"></i>Quét Barcode</span></button>');
	}
});
// if(ismobile){
// 	$("#trucktable").find("th:nth-child(5)").remove();
// 	$("<th col-name=\"check\" class=\"editor-cancel\">Cho Ra</th>").insertAfter($("#trucktable").find("th:nth-child(1)"));
// }

$("#trucktable").DataTable({
	scrollY: 'auto',
	columnDefs: [
	{ type: "num", className: "text-center", targets:0 }
	],
	order: [[ 0, 'asc' ]],
	paging: false,
	keys:false,
	select: true,
	rowReorder: false
});

get_truck_in();

function get_truck_in(){
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd1,
		dataType: 'json',
		data: {},
		type: 'POST',
		success: function (data) {
                	$('.page-content.fade-in-up').unblock();
                	if(data.deny) {
                		toastr["error"](data.deny);
                		return;
                	};
                	var formarr=[];
                	var ii=0;
                	$("#trucktable").DataTable().clear();
                	if(typeof data[0] != "undefined"){
                		$(data).each(function(i,item){
                			var itemarr=[];
                			// if(ismobile){
                			// 	itemarr.push(i+1);
                			// 	if(item.SUCCESS=="1")
                			// 		itemarr.push('<label GUID="'+item.ROWGUID+'" class="ui-switch switch-icon switch-solid-success switch-large pushsuccess"><input type="checkbox" checked=""><span></span></label>');
                			// 	else
                			// 		itemarr.push('<label GUID="'+item.ROWGUID+'" class="ui-switch switch-icon switch-solid-success switch-large pushsuccess"><input type="checkbox" ><span></span></label>');
                			// 	itemarr.push(item.TRUCKNO);
                			// 	itemarr.push(item.PINCODE);
                			// 	itemarr.push(item.WAREHOUSE_NAME);
                			// }
                			// else
                			{
                				itemarr.push(i+1);

                				itemarr.push(item.TRUCKNO);
                				itemarr.push(item.PINCODE);
                				itemarr.push(item.WAREHOUSE_NAME);
                				if(item.SUCCESS=="1")
                					itemarr.push('<label GUID="'+item.ROWGUID+'" class="ui-switch switch-icon switch-solid-success switch-large pushsuccess"><input type="checkbox" checked=""><span></span></label>');
                				else
                					itemarr.push('<label GUID="'+item.ROWGUID+'" class="ui-switch switch-icon switch-solid-success switch-large pushsuccess"><input type="checkbox" ><span></span></label>');
                			}                	
                			var addj=$("#trucktable").DataTable().row.add(itemarr).draw();
                			$("#trucktable").find("tr:nth-child("+(i+1)+")").attr("PINCODE",item.PINCODE);
                			$("#trucktable").find("tr:nth-child("+(i+1)+")").data("jdata",item);
                		});
                		
                	}
                	
                },
                error: function(err){
                	toastr["error"]("Error!");
                	$('.page-content.fade-in-up').unblock();
                	console.log(err);
                }
            });
}



tbl.editableTableWidget(); //Cho Table Edit

$('#addrow').on('click', function(){
	$.confirm({
		title: 'Chọn số lượng hàng!',
		type: 'orange',
		icon: 'fa fa-warning',
		content: 'Nhập số lượng hàng muốn thêm <input id=comidnb type=number value="1"> ?',
		buttons: {
			ok: {
				text: 'Xác nhận',
				btnClass: 'btn-warning',
				keys: ['Enter'],
				action: function(){
					var numrc=parseInt($("#comidnb").val());
					for(var i=0;i<numrc;i++){
						tbl.newRow();
					}
					tbl.updateSTT(_columns.indexOf("STT"));
				}
			},
			cancel: {
				text: 'Hủy bỏ',
				btnClass: 'btn-default',
				keys: ['ESC']
			}
		}
	});
});

$('#delete').on('click', function () {
	if(tbl.getSelectedRows().length == 0){
		$('.toast').remove();
		toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
	}else{
		tbl.confirmDelete( function(selectedData){
			postDel(selectedData);
		});
	}
});

$('#save').on('click', function(){

	$.confirm({
		title: 'Thông báo!',
		type: 'orange',
		icon: 'fa fa-warning',
		content: 'Tất cả sẽ được lưu lại!\nTiếp tục?',
		buttons: {
			ok: {
				text: 'Xác nhận lưu',
				btnClass: 'btn-warning',
				keys: ['Enter'],
				action: function(){

					check_required("#row-transfer-left",function(){

						saveData();
					},function(err){
						alert(err);

					});
				}
			},
			cancel: {
				text: 'Hủy bỏ',
				btnClass: 'btn-default',
				keys: ['ESC']
			}
		}
	});
});

$("#CONTRACT_CODE").on("input",function(){
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd2,
		dataType: 'json',
		data: {"CONTRACT_CODE":$(this).val()},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			if(typeof data[0] != "undefined"){
				$("#CUSTOMER_CODE").val(data[0].CUSTOMER_CODE);
				$("#WAREHOUSE_CODE").val(data[0].WAREHOUSE_CODE);
                    	//$("#CUSTOMER_CODE").val(data[0].CUSTOMER_CODE);
                    }
                    
                },
                error: function(err){
                	toastr["error"]("Error!");
                	$('.page-content.fade-in-up').unblock();
                	console.log(err);
                }
            });
});

function load_kiemden(that){
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd3,
		dataType: 'json',
		data: {"ORDERNO":that},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			var formarr=[];
			var ii=0;
			$("#contenttable").DataTable().clear();
			if(typeof data[0] != "undefined"){
				$(data).each(function(i,item){
					var itemarr=[];
					itemarr.push(i+1);
					itemarr.push(item.TRUCK_COUNT);
					itemarr.push(item.ITEM_CODE);
					itemarr.push(item.ESTIMATED_NUMBER);
					itemarr.push(item.ACTUAL_NUMBER);
					if(item.CHECKED==null || item.CHECKED==0)
						itemarr.push('<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>');
					else
						itemarr.push('<label class="checkbox checkbox-primary"><input type="checkbox" value="0" checked><span class="input-span"></span></label>');
					itemarr.push(item.ROWGUID);

					var addj=$("#contenttable").DataTable().row.add(itemarr).draw();
				});

			}

		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});
}

function load_item_truck(TRUCKNO,PINCODE){
	$("#item_table").DataTable().clear();
	$("#item_table").attr("TRUCKNO",TRUCKNO).attr("PINCODE",PINCODE);
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd4,
		dataType: 'json',
		data: {"TRUCKNO":TRUCKNO,PINCODE:PINCODE},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			var formarr=[];
			var ii=0;
			$("#item_table").DataTable().clear();
			if(typeof data[0] != "undefined"){
				$(data).each(function(i,item){
					var itemarr=[];
					itemarr.push(i+1);
					if(item.LOT!=null)
						itemarr.push(item.ITEM_CODE+"<i>"+item.PALLET_NUMBER+"<i>"+"<i>"+item.LOT+"<i>");
					else
						itemarr.push(item.ITEM_CODE);	                    
					itemarr.push(parseFloat(item.CTNPPALLET));
					itemarr.push(parseFloat(item.PALLET_QTY));
					itemarr.push(parseFloat(item.ESTIMATED_NUMBER));
					itemarr.push(parseFloat(item.ACTUAL_NUMBER));
					itemarr.push((item.ROWGUID));
					var addj=$("#item_table").DataTable().row.add(itemarr).draw();
				});

			}

		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});
}
if(ismobile){
// $("#trucktable").closest(".himb").hide();
// $("#item_table").closest(".himb").hide();
// $("#contenttable").closest(".himb").hide();
$("#trucktable").closest(".pb-3").show();
}
$(document).on(evClick,"#trucktable tbody tr",function(){
			//alert($("#trucktable th[col-name='TRUCKNO']").index());

			var TRUCKNO=$(this).find("td:nth-child("+($("#trucktable th[col-name='TRUCKNO']").index()+1)+")").text();
			var PINCODE=$(this).find("td:nth-child("+($("#trucktable th[col-name='PINCODE']").index()+1)+")").text();
			var dftruck=$("#item_table").attr("truckno");
			var dfPincode=$("#item_table").attr("pincode");
			$(".trgselect").removeClass("trgselect");
			$(this).addClass("trgselect");
			//if(TRUCKNO!=dftruck || PINCODE!=dfPincode)
			{
				load_item_truck(TRUCKNO,PINCODE);
				$("#contenttable").DataTable().clear().draw();
			}
			if(ismobile){
				$("#item_table").closest(".pb-3").show();
				$("#trucktable").closest(".pb-3").hide();
				//$("#item_table_filter input").focus();
				$("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() {
					//$("#item_table_filter input").focus();
				});
				//location.assign
			}
	//alert(1);
});



function update_seq(TRUCKNO,ITEM_CODE,PINCODE,LOT,ROWGUID,check){
if(ismobile){
		$("#item_table").closest(".pb-3").hide();
		$("#trucktable").closest(".pb-3").hide();
		$("#contenttable").closest(".pb-3").show();
	}
var check =check||false;
	$("#contenttable").DataTable().clear();
	$("#contenttable").attr("TRUCKNO",TRUCKNO).attr("ITEM_CODE",ITEM_CODE).attr("PINCODE",PINCODE).attr("LOT",LOT).attr("ROWGUID",ROWGUID);
	$("#contenttable").data("JG_ROWGUID",$("tr.trgselect").data("jdata").ROWGUID);
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd5,
		dataType: 'json',
		data: {"TRUCKNO":TRUCKNO,"ITEM_CODE":ITEM_CODE,"PINCODE":PINCODE,"LOT":LOT,"ROWGUID":ROWGUID},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			var formarr=[];
			var ii=0;
			$("#contenttable").DataTable().clear();
			if(typeof data[0] != "undefined"){
				$(data).each(function(i,item){
					ii=i+1;
					var itemarr=[];
					itemarr.push(item.SEQNO);
					itemarr.push( parseFloat(item.ACTUAL_NUMBER));
					var itemvl='<button class="update_seq">Xác nhận</button>';
					if(i>=data.length-1)
						itemvl='<button class="update_seq">Xác nhận</button><button class="remove_seq">Xóa</button>';
					itemarr.push(itemvl);
					itemarr.push(item.ROWGUID);
					var addj=$("#contenttable").DataTable().row.add(itemarr).draw();
				});
				var itemarr=[];
				itemarr.push("Chưa Thêm");
				itemarr.push($("#item_table tr.selecttr").find("td:nth-child(5)").html()||"");
				itemarr.push('<button class="update_seq">Xác nhận</button>');
				itemarr.push("");
				var addj=$("#contenttable").DataTable().row.add(itemarr).draw();
				if(check)
				$("#contenttable").find(".update_seq").last().trigger("tip");

			}
			else
			{
				var itemarr=[];
				itemarr.push("Chưa Thêm");
				itemarr.push($("#item_table tr.selecttr").find("td:nth-child(5)").html()||"");
				itemarr.push('<button class="update_seq">Xác nhận</button>');
				itemarr.push("");
				var addj=$("#contenttable").DataTable().row.add(itemarr).draw();
				if(check)
				$("#contenttable").find(".update_seq").last().trigger("tip");
			}

		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});

}



$(document).on(evClick+" tip","#item_table tbody tr",function(e){

	$("#item_table tr").removeClass("selecttr").removeClass("selected");
	if($(this).hasClass("selecttr")){
		$(this).removeClass("selecttr").removeClass("selected");
	}
	else
	{
		$(this).addClass("selecttr").removeClass("selected");
	}
	var TRUCKNO=$("#item_table").attr("TRUCKNO");
	var PINCODE=$("#item_table").attr("PINCODE");
	var ITEM_CODE=$(this).find("td:nth-child(2)").clone().find("i").remove().end().text();
	var LOT=$(this).find("td:nth-child(2)").find("i").text();
	var ROWGUID=$(this).find("td:nth-child(7)").text();
	var df_TRUCKNO=$("#contenttable").attr("truckno");
	var df_PINCODE=$("#contenttable").attr("pincode");
	var df_ITEM_CODE=$("#contenttable").attr("item_code");
	var df_LOT=$("#contenttable").attr("lot");
	var df_ROWGUID=$("#contenttable").attr("ROWGUID");

	//alert(ITEM_CODE);
	//if(ROWGUID!=df_ROWGUID)

	if(e.type=="tip")
	update_seq(TRUCKNO,ITEM_CODE,PINCODE,LOT,ROWGUID,true);
	else
	update_seq(TRUCKNO,ITEM_CODE,PINCODE,LOT,ROWGUID,false);
	if(ismobile){
		$("#item_table").closest(".pb-3").hide();
		$("#trucktable").closest(".pb-3").hide();
		$("#contenttable").closest(".pb-3").show();

		$("#contenttable").find("tr").last().find("td:nth-child(2)").trigger("click touchend");
				// $("html, body").stop().animate({scrollTop:0}, 1000, 'swing', function() {
				// 	var vali=($("#contenttable").find("tr").last().find("td:nth-child(2)").html());
				// 	$("#contenttable").find("tr").last().find("td:nth-child(2)").focus().trigger("touchend");
				// 	$("#editor-input").val(vali);
				// });
	}
});


$(document).on("mouseup touchend",".remove_seq_",function(){

	//var indexes = $("#contenttable").filterRowIndexes( _columns.indexOf( "Code" ), deletedUnitCode);
	//$("#contenttable").DataTable().rows( indexes ).remove().draw( false );
	$("#contenttable").DataTable().rows($(this).closest("tr")).remove().draw( false );
});

$(document).on("mouseup touchend",".remove_seq",function(){
	$('.page-content.fade-in-up').blockUI();
	var ROWGUID=$(this).closest("tr").find("td:nth-child(4)").text();

	$.ajax({
		url: ROOT_URL+"/"+ajd6,
		dataType: 'json',
		data: {"ACTION":"REMOVE","ROWGUID":ROWGUID},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			if(data.success) {
				toastr["success"](data.success);
				load_item_truck($("#contenttable").attr("TRUCKNO"),$("#contenttable").attr("PINCODE"));
				update_seq($("#contenttable").attr("TRUCKNO"),$("#contenttable").attr("ITEM_CODE"),$("#contenttable").attr("PINCODE"),$("#contenttable").attr("LOT"),$("#contenttable").attr("ROWGUID"));
				$(".selecttr").find("td:nth-child(6)").html(data.num);
				return;
			};
		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});
});

$(document).on("mouseup touchend tip",".update_seq",function(ev){
	$(".page-content.fade-in-up").blockUI();
	var TRUCKNO=$(this).closest("table").attr("TRUCKNO");
	var ITEM_CODE=$(this).closest("table").attr("ITEM_CODE");
	var PINCODE=$(this).closest("table").attr("PINCODE");
	var LOT=$(this).closest("table").attr("LOT");
	var ACTUAL_NUMBER=$(this).closest("tr").find("td:nth-child(2)").text();
	var ROWGUID=$(this).closest("tr").find("td:nth-child(4)").text();
	var ORDER_ROWGUID=$(this).closest("table").attr("ROWGUID");
	//alert(ROWGUID);return false;
	$.ajax({
		url: ROOT_URL+"/"+ajd6,
		dataType: 'json',
		data: {"TRUCKNO":TRUCKNO,"ITEM_CODE":ITEM_CODE,"PINCODE":PINCODE,"ACTUAL_NUMBER":ACTUAL_NUMBER,"ROWGUID":ROWGUID,"LOT":LOT,"ORDER_ROWGUID":ORDER_ROWGUID,"JG_ROWGUID":$("tr.trgselect").data("jdata").ROWGUID},
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				if(ev.type=="tip")
				$("#barcode_scan").trigger(evClick).focus();
				return;
			};
			if(data.success) {
				toastr["success"](data.success);
				update_seq($("#contenttable").attr("TRUCKNO"),$("#contenttable").attr("ITEM_CODE"),$("#contenttable").attr("PINCODE"),$("#contenttable").attr("LOT"),$("#contenttable").attr("ROWGUID"));
				$(".selecttr").find("td:nth-child(6)").html(data.num);
				if(ev.type=="tip")
				$("#barcode_scan").trigger(evClick).focus();
				return;
			};
		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});
});

$(document).on(evClick,".pushsuccess",function(){
	$(".page-content.fade-in-up").blockUI();
	var ROWGUID=$(this).attr("GUID");
	var action=0;
	if($(this).find("input[type='checkbox']").prop("checked")){
		action=1;
	}
			//alert(action); return false;
			$.ajax({
				url: ROOT_URL+"/"+ajd7,
				dataType: 'json',
				data: {"ROWGUID":ROWGUID,"action":action},
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
					toastr["error"]("Error!");
					$('.page-content.fade-in-up').unblock();
					console.log(err);
				}
			});
		});


$(document).on("change","#contenttable tr td:nth-child(6) input",function(e){
	var ROWGUID=$(this).closest("tr").find("td:nth-child(7)").html();
	var SOLUONG=$(this).closest("tr").find("td:nth-child(5)").html();
	var inp=$(this).closest("tr").find("td:nth-child(6) input");
	if($(this).closest("tr").find("td:nth-child(6) input").is(":checked"))
		var CHECKED=1;
	else
		var CHECKED=0;

	var dt={"ROWGUID":ROWGUID,"SOLUONG":SOLUONG,"CHECKED":CHECKED};
	
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd8,
		dataType: 'json',
		data: dt,
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny)
			{
				toastr['error'](data.deny);
				if(CHECKED==1){
					inp.prop("checked",false);
				}
				else{
					inp.prop("checked",true);
				}
			}
			if(data.success)
			{
				toastr['success'](data.success);
				if(CHECKED==1){
					inp.prop("checked",true);
				}
				else{
					inp.prop("checked",false);
				}
			}
		},
		error: function(err){
			toastr["error"]("Tải dữ liệu thất bại !!");
			$('.page-content.fade-in-up').unblock();
                	//console.log(err);
                }
            });
});


// //gate pass
// $("#quacong").on(evClick,function(){
// 	if($("#ORDERNO").val()==""){
// 		toastr["error"]("Số order không được để trống !");
// 		return false;
// 	}
// 	if($("#PINCODE").val()==""){
// 		toastr["error"]("Số Pin không được để trống !");
// 		return false;
// 	}
// 	if($("#TRUCKNO").val()==""){
// 		toastr["error"]("Số xe không được để trống !");
// 		return false;
// 	}
// 	if($("#DRIVER").val()==""){
// 		toastr["error"]("Tài xế không được để trống !");
// 		return false;
// 	}
// 	if($("#TEL").val()==""){
// 		toastr["error"]("Số điện thoại không được để trống !");
// 		return false;
// 	}
// 	var dt={
// 		"ORDERNO":$("#ORDERNO").val(),
// 		"PINCODE":$("#PINCODE").val(),
// 		"TRUCKNO":$("#TRUCKNO").val(),
// 		"DRIVER":$("#DRIVER").val(),
// 		"TEL":$("#TEL").val(),
// 		"NOTE":$("#NOTE").val()
// 	};
// 	$('.page-content.fade-in-up').blockUI();
// 	$.ajax({
// 		url: "<?=site_url(md5('InOut') . '/' . md5('gate_pass'));?>",
// 		dataType: 'json',
// 		data: dt,
// 		type: 'POST',
// 		success: function (data) {
// 			$('.page-content.fade-in-up').unblock();
// 			if(data.deny) {
// 				toastr["error"](data.deny);
// 				return;
// 			};
// 			console.log(data);
// 			if(data.success){
// 				toastr["success"](data.success);
// 				$.confirm({
// 					title: data.success,
// 					type: 'orange',
// 					icon: 'fa fa-warning',
// 					content: 'Bạn muốn xóa dữ liệu cũ !',
// 					buttons: {
// 						ok: {
// 							text: 'Xác nhận',
// 							btnClass: 'btn-warning',
// 							keys: ['Enter'],
// 							action: function(){
// 								clearall();
// 							}
// 						},
// 						cancel: {
// 							text: 'Hủy bỏ',
// 							btnClass: 'btn-default',
// 							keys: ['ESC']
// 						}
// 					}
// 				});
// 			}

// 		},
// 		error: function(err){
// 			toastr["error"]("Error!");
// 			$('.page-content.fade-in-up').unblock();
// 			console.log(err);
// 		}
// 	});
// });

//viet them table


// $(document).on("keypress touch click",function(){
// 	if($("td.focus").length>0 && $("td.focus").index()==1){
// 		if($("td.focus").attr("contenteditable")!="true")
// 			$("td.focus").attr("contenteditable","true");
// 		if($("td.focus").text()=="0")
// 			$("td.focus").html("");
// 		$("td.focus").focus();
// 	}
// });
// $(document).on("focusout","td",function(){
// 	if($(this).attr("contenteditable")=="true"){
// 		$(this).html(parseFloat($(this).text()));
// 		$(this).removeAttr("contenteditable");
// 	}
// });
// $(document).on('input paste keydown',"#contenttable td", function (e) {
// 	if(e.type == "keydown"){
// 					// Allow: backspace, delete, tab, escape, enter and .
// 					if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190, 188]) !== -1 ||
// 						((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
// 						(e.keyCode >= 35 && e.keyCode <= 40)) {
// 						return;
// 				}
// 					// Ensure that it is a number and stop the keypress
// 					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
// 						e.preventDefault();
// 						return;
// 					}
// 				}else if(e.type == "paste"){
// 					var tempval = e.originalEvent.clipboardData.getData('Text').replace(',','');
// 					editor.val($.isNumeric(tempval) ? tempval : "");

// 					e.preventDefault();
// 					return;
// 				}
// 			});











    // Start the live stream scanner when the modal opens
    $('#livestream_scanner').on('shown.bs.modal', function (e) {
    	codeReader.decodeFromInputVideoDeviceContinuously(selectedDeviceId, 'video', (result, err) => {
              if (result) {
                $('#livestream_scanner').modal('hide');
                document.getElementById('result').textContent = result.text
                $("#item_table_filter input").val(result.text).focus().trigger("keypress").trigger("input").trigger("change");
                setTimeout(function(){

if($("#item_table tbody tr .dataTables_empty").length>0){

			}
			else
			{
				if($("#item_table tbody tr").length==1)
					$("#item_table tbody tr:nth-child(1)").trigger("tip");
			}
                },100);
			
              }
              if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error(err)
                document.getElementById('result').textContent = err
              }
            })
    });
    $(document).on(evClick,"#barcode_scan",function(){    
    	$('#livestream_scanner').modal('show');
    });
    
    
    
    // Stop quagga in any case, when the modal is closed
    $('#livestream_scanner').on('hide.bs.modal', function(){
    	codeReader.reset();

    });
    
var strKey="";
var inpkey;
$(window).on('keypress',function(e){
	var key = e.which;
	strKey+=String.fromCharCode(key);
	console.log(strKey);
	clearTimeout(inpkey);
	inpkey=setTimeout(function(){
		if(strKey.length>=5)
		{
			$("#item_table_filter input").val(strKey).trigger("keypress").trigger("input").trigger("change");
			 setTimeout(function(){
if($("#item_table tbody tr .dataTables_empty").length>0){

			}
			else
			{
				if($("#item_table tbody tr").length==1)
					$("#item_table tbody tr:nth-child(1)").trigger("tip");
			}
                },100);
		}
		strKey="";
	},100);
	
	//console.log(key,e);
});

let selectedDeviceId;
const codeReader = new ZXing.BrowserMultiFormatReader();
codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
          const sourceSelect = document.getElementById('sourceSelect')
          //selectedDeviceId = videoInputDevices[0].deviceId
          if (videoInputDevices.length >= 1) {
           selectedDeviceId = videoInputDevices[0].deviceId
           if (videoInputDevices.length >= 2)
           	selectedDeviceId = videoInputDevices[1].deviceId
        }
    }).catch((err) => {
          console.error(err)
        });


});



