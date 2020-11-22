function load_gate(GUID){
						$('.page-content.fade-in-up').blockUI();
						$.ajax({
							url: ROOT_URL+"/"+ajd2,
							dataType: 'json',
							data: {ROWGUID:GUID},
							type: 'POST',
							success: function (data) {
								$('.page-content.fade-in-up').unblock();
								if(data.deny) {
									toastr["error"](data.deny);
									return;
								};
								var obj=data[0];
								Object.keys(obj).forEach(function(key) {
									$("#"+key).val(obj[key]);

								});
								$("#PINCODE").trigger("input");      
								
							},
							error: function(err){
								toastr["error"]("Error! load");
								$('.page-content.fade-in-up').unblock();
								console.log(err);
							}
						});
					}
					function get_truck_in(){
						$('.page-content.fade-in-up').blockUI();
						$.ajax({
							url: ROOT_URL+"/"+ajd3,
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
                	$("#trucktable").DataTable().clear().draw();
                	if(typeof data[0] != "undefined"){
                		$(data).each(function(i,item){
                			var itemarr=[];
                			itemarr.push(i+1);
                			itemarr.push(item.TRUCKNO);
                			itemarr.push(item.PINCODE);
                			itemarr.push(JSON.stringify(item));                   	
                			var addj=$("#trucktable").DataTable().row.add(itemarr).draw();
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
					$(document).ready(function () {


//-------------------------------------------- SOCKET---------------------------------------------------
var socket = io.connect(wsUri);
socket.on('connect', function(soc){
	socket.emit("tenthietbi","Gate");
});
socket.on('truck_alert', function(iData){
        	//alert(iData);
        	var jdata=JSON.parse(iData);
        	if(jdata.com=="truck_alert"){
        		toastr['success'](jdata.mes);
        		setTimeout(function(){
        			get_truck_in();
        		},100);
        		
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








var finttime;
$(document).on("input",".ajax_find",function(){
	var table=$(this).attr("table");
	var key=$(this).val();
	if(key=="" || table=="")return false;
	clearTimeout(finttime);
	var that=this;
	finttime=setTimeout(function(){
		$.ajax({
			url: ROOT_URL+"/"+ajd4,
			dataType: 'json',
			data: {"table":table,"key":key},
			type: 'POST',
			success: function (data) {
				if(data.deny) {
					toastr["error"](data.deny);
					return;
				};
				if(typeof data[0] != "undefined"){
					var html="";
					$(data).each(function(i,item){
						html+="<li class='finasin' table='"+table+"' jdata='"+JSON.stringify(item)+"'>"+item.TRUCKNO+"</li>";
					});
					$("body").append('<div id=find_htxp table="'+table+'" style="position:absolute;left:'+$(that).offset().left+'px;top:'+($(that).offset().top+$(that).outerHeight())+'px;width:'+$(that).outerWidth()+'px;background:#fff;border:1px solid #b6b6b6;z-index:9999;">'+html+'</div>');
					if($("#find_htxp").find(".finasin").length==1 && $("#find_htxp").find(".finasin").html()==$(that).attr("get-data")){
						$("#find_htxp").find(".finasin").trigger(evClick);
					}
				}
				else{
					$(".find_htxp").remove();
				}
				
			},
			error: function(err){
				toastr["error"]("Error!");
				$('.page-content.fade-in-up').unblock();
				console.log(err);
			}
		});
	},800);
	
});


$(document).on(evClick,".finasin",function(e){
	e.preventDefault();
	var table=$(this).attr("table");
	if(table=="BS_TRUCK"){
		var data=JSON.parse($(this).attr("jdata"));
		$("#TRUCKNO").val(data.TRUCKNO);
		if(data.TLDK!=null)
			$("#TLDK").val(data.TLDK);
		if(data.TTCPDK!=null)
			$("#TTCPDK").val(data.TTCPDK);
		if(data.TLREMOOC!=null)
			$("#TLREMOOC").val(data.TLREMOOC);
		if(data.TTCPREMOOC!=null)
			$("#TTCPREMOOC").val(data.TTCPREMOOC);
		if(data.REMOOCNO!=null)
			$("#REMOOCNO").val(data.REMOOCNO);
		if(data.CONTAINER!=null)
			$("#CONTAINER").val(data.CONTAINER);
	}

	
	$("#find_htxp").remove();
});

$(document).on(evClick,"body",function(e){

	$("#find_htxp").remove();
});





$( ".selectpicker" ).selectmenu();
var _columns = ["STT", "Code", "Name", "Description", "Unit", "ItemGroup", "SKU", "NetWeight","CustomerNo"];

var tbl = $('#contenttable');
var dataTbl = tbl.DataTable({
	scrollY: 'auto',
	columnDefs: [
	{ type: "num", className: "text-center", targets: _columns.indexOf("STT") }
	],
	order: [[ _columns.indexOf("STT"), 'asc' ]],
	paging: false,
	keys:true,
	autoFill: {
		focus: 'focus'
	},
	select: true,
	rowReorder: false
});
var dtruck;
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
			if($(this).val().length!=11)return false;
			$('.page-content.fade-in-up').blockUI();
			$.ajax({
				url: ROOT_URL+"/"+ajd5,
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
		function loadfromord(that){
			clearninput();
			if($(that).val().length!=11)return false;
			$('.page-content.fade-in-up').blockUI();
			$.ajax({
				url: ROOT_URL+"/"+ajd6,
				dataType: 'json',
				data: {"ORDERNO":$(that).val()},
				type: 'POST',
				success: function (data) {
					$('.page-content.fade-in-up').unblock();
					if(data.deny) {
						toastr["error"](data.deny);
						return;
					};
					var formarr=[];
					var ii=0;
					if(typeof data[0] != "undefined"){
						$("#InLenh").hide();
						if(data[0].METHOD_CODE=="XK")
							$("#InLenh").show();
						$("#PINCODE").val(data[0].PINCODE);
						$("#DO").val((data[0].DO==null?"":data[0].DO)+(data[0].PACKINGLIST==null?"":data[0].PACKINGLIST));
						$("#CUSTOMER_CODE").val(data[0].CUSTOMER_CODE);
						$("#CLASS_CODE").val(data[0].CLASS_CODE);
						$("#PACKINGLIST").val(data[0].PACKINGLIST);
						$("#WAREHOUSE_CODE").val(data[0].WAREHOUSE_CODE);
						$("#METHOD_NAME").val(data[0].METHOD_NAME);
						$("#CUSTOMER_NAME").val(data[0].CUSTOMER_NAME);
						$("#SHIPPING_NAME").val(data[0].SHIPPING_NAME);
						$("#CLASS_NAME").val(data[0].CLASS_NAME);
						$("#ORDERNO").val(data[0].ORDERNO);
						$("#WAREHOUSE_NAME").val(data[0].WAREHOUSE_NAME);

						
					}
					
				},
				error: function(err){
					
				}
			});
		}
		$("#ORDERNO").on("input",function(){
			loadfromord(this);
		});
		$("#ORDERNO").on("keypress",function(e){	
			if(e.which == 13) {
				loadfromord(this);
			}
		});
		function clearninput(){
			$("#row-transfer-left").find("input,textarea").each(function(){
				if($(this).attr("id")!="ORDERNO" && $(this).attr("id")!="PINCODE")
					$(this).val("");
			});
		}
		function clearall(){
			$(".truyvanthongtin").find("input,textarea").each(function(){
				$(this).val("");
			});
		}
		function loadfrompin(that){
			if($(that).val().length!=11)return false;
			clearninput();
			$('.page-content.fade-in-up').blockUI();
			$.ajax({
				url: ROOT_URL+"/"+ajd7,
				dataType: 'json',
				data: {"PINCODE":$(that).val()},
				type: 'POST',
				success: function (data) {
					$('.page-content.fade-in-up').unblock();
					if(data.deny) {
						toastr["error"](data.deny);
						return;
					};
					var formarr=[];
					var ii=0;
					if(typeof data[0] != "undefined"){
						$("#InLenh").hide();
						if(data[0].METHOD_CODE=="XK")
							$("#InLenh").show();
						$("#PINCODE").val(data[0].PINCODE);
						$("#STATUS_CODE").val(data[0].STATUS_CODE);
						$("#CONTRACT_CODE").val(data[0].CONTRACT_CODE);
						$("#METHOD_CODE").val(data[0].METHOD_CODE);
						$("#DO").val((data[0].DO==null?"":data[0].DO)+(data[0].PACKINGLIST==null?"":data[0].PACKINGLIST));
						$("#CUSTOMER_CODE").val(data[0].CUSTOMER_CODE);
						$("#CLASS_CODE").val(data[0].CLASS_CODE);
						$("#PACKINGLIST").val(data[0].PACKINGLIST);
						$("#WAREHOUSE_CODE").val(data[0].WAREHOUSE_CODE);
						$("#STATUS_CODE").selectmenu("refresh");
						$("#CLASS_CODE").selectmenu("refresh");
						$("#METHOD_CODE").selectmenu("refresh");
						$("#METHOD_NAME").val(data[0].METHOD_NAME);
						$("#CUSTOMER_NAME").val(data[0].CUSTOMER_NAME);
						$("#SHIPPING_NAME").val(data[0].SHIPPING_NAME);
						$("#CLASS_NAME").val(data[0].CLASS_NAME);
						$("#ORDERNO").val(data[0].ORDERNO);
						$("#CONTRACT_NAME").val(data[0].CONTRACT_NAME);
						$("#WAREHOUSE_NAME").val(data[0].WAREHOUSE_NAME);
						$("#CONTAINER").val(data[0].CONTAINER);
					}
					
				},
				error: function(err){
					
				}
			});
		}

		var gate="";
		var ISINOUT="0";
		function setout(){
			clearall();
			$(".truyvanthongtin").find("input").attr("readonly","true");
		}
		function setin(){
			$(".truyvanthongtin").find("input").removeAttr("readonly");
			$(".creadonly").find("input").attr("readonly","false");
			
		}

		$(document).on(evClick,".cgatebtn",function(){
			gate=$(this).attr("idx");
			ISINOUT=$(this).attr("inout");
			if(ISINOUT=="1")
				setout();
			else
				setin();
			$("#chose_gate").hide();
			$(".maincontent").show();
			$("#gatename").html($(this).html());
			dtruck=$("#trucktable").DataTable({
				scrollY: 'auto',
				columnDefs: [
				{ type: "num", className: "text-center", targets:0 }
				],
				order: [[ 1, 'asc' ]],
				paging: false,
				keys:true,
				autoFill: {
					focus: 'focus'
				},
				select: true,
				rowReorder: false
			});
			
			get_truck_in();
			



		});

		$(document).on(evClick,"#choncong",function(){
			gate="";
			$("#chose_gate").show();
			$(".maincontent").hide();
		});

		$(document).on(evClick,"#trucktable tbody tr",function(){
			var jdata=JSON.parse($(this).find("td:nth-child(4)").html());
	//alert(jdata.ROWGUID);
	load_gate(jdata.ROWGUID);
	// var pincode=$(this).find("td:nth-child(3)").html();
	// var truckno=$(this).find("td:nth-child(2)").html();
	// $("#PINCODE").val(pincode).trigger("input");
	// $("#TRUCKNO").val(truckno).trigger("input");
	// $("#TRUCKNO").attr("get-data",truckno);
});

		$("#PINCODE").on("input",function(){
			loadfrompin(this);
		});
		$("#PINCODE").on("keypress",function(e){
			
			if(e.which == 13) {
				loadfrompin(this);
			}
		});
		function check_required(obj,success,fal){
			var checkq=false;
			var err="";
			$(obj).find('input').each(function(){
				if(!$(this).prop('required')){
					
				} else {
					if($(this).val()=="")
					{
						checkq=true;
						err+=("Nhập thiếu trường "+$(this).attr("placeholder")+" !\n");
					}
					
					
					
				}
			});
			if(!checkq){
				success();
			} else {
				fal(err);
			}
		}
        //save functions
        function saveData(){      	
        	var newData = tbl.getData();
        	var formdt={};
        	var checkp=true;
        	if(parseFloat($("#TLDK").val())<=parseFloat($("#TTCPDK").val())){
        		toastr["error"]("Tổng trọng lượng đăng kiểm phải lớn hơn hoặc bằng trọng lượng đăng kiểm !");
        		checkp=false;
        	}
        	if(parseFloat($("#TLREMOOC").val())<=parseFloat($("#TTCPREMOOC").val())){
        		toastr["error"]("Tổng trọng lượng đăng kiểm Remooc phải lớn hơn hoặc bằng trọng lượng đăng kiểm Remooc !");
        		checkp=false;
        	}
        	$(newData).each(function(i,row){
        		if((row[2])==""){
        			toastr["error"]("Số lượng không được để trống !");
        			checkp=false;
        		}
        		else
        			if(parseFloat(row[2])<=0){
        				toastr["error"]("Số lượng phải lớn hơn 0 !");
        				checkp=false;
        			}
        			if((row[1])==""){
        				toastr["error"]("Mặt hàng không được để trống !");
        				checkp=false;
        			}
        			if((row[5])==""){
        				toastr["error"]("Chưa chọn ghi chú !");
        				checkp=false;
        			}
        			if((row[4])==""){
        				toastr["error"]("Trọng lượng không được để trống !");
        				checkp=false;
        			}
        			else
        				if(parseFloat(row[4])<=0){
        					toastr["error"]("Trọng lượng phải lớn hơn 0 !");
        					checkp=false;
        				}

        			});
        	$("#row-transfer-left").find('input,select').each(function(){
        		formdt[$(this).attr('id')]=$(this).val();
        	});

        	
        	var fnew = {
        		'action': 'save',
        		'data': newData,
        		'dataform':formdt
        	};
        	if(checkp)
        		postSave(fnew);
        	
        }

        function postSave(formData){
        	var saveBtn = $('#save');
        	saveBtn.button('loading');
        	$('.page-content.fade-in-up').blockUI();

        	$.ajax({
        		url: ROOT_URL+"/"+ajd8,
        		dataType: 'json',
        		data: formData,
        		type: 'POST',
        		success: function (data) {
        			saveBtn.button('reset');
        			$('.page-content.fade-in-up').unblock();
        			if(data.deny) {
        				toastr["error"](data.deny);
        				return;
        			};

        			if(formData.action == 'save'){
        				toastr["success"]("Cập nhật thành công!");
        				tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
        				tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
        				$("#ORDERNO").val(data.item_rp[0].ORDERNO);
        				$("#PINCODE").val(data.item_rp[0].PINCODE);
        				$("#ORDERNO").trigger("input");
        			};

        			
        		},
        		error: function(err){
        			toastr["error"]("Error!");
        			saveBtn.button('reset');
        			$('.page-content.fade-in-up').unblock();
        			console.log(err);
        		}
        	});
        }

        function postDel(rows){
        	$('.page-content.fade-in-up').blockUI();

        	var delUnits = rows.map(p=>p[6]);

        	var delBtn = $('#delete');
        	delBtn.button('loading');

        	var formdata = {
        		'action': 'delete',
        		'data': delUnits
        	};
        	$.ajax({
        		url: ROOT_URL+"/"+ajd8,
        		dataType: 'json',
        		data: formdata,
        		type: 'POST',
        		success: function (output) {
        			delBtn.button('reset');
        			var data = output.result;
        			if(data.error && data.error.length > 0){
        				for (var i = 0; i < data.error.length; i++) {
        					toastr["error"](data.error[i]);
        				}
        			}

        			if(data.success && data.success.length > 0){
        				for (var i = 0; i < data.success.length; i++) {
        					var deletedUnitCode = data.success[i].split(':')[1].trim();
        					var indexes = tbl.filterRowIndexes( 6, deletedUnitCode);
        					tbl.DataTable().rows( indexes ).remove().draw( false );
        					tbl.updateSTT( _columns.indexOf( "STT" ) );
        					toastr["success"]( data.success[i] );
        				}
        			}

        			$('.page-content.fade-in-up').unblock();
        		},
        		error: function(err){
        			delBtn.button('reset');
        			$('.page-content.fade-in-up').unblock();
        			console.log(err);
        		}
        	});
        }














        $(document).on(evClick,"#contenttable tr td:nth-child(4)",function(e){
        	datacall=this;
        	var tablek="BS_UNIT";
        	$("#search-ship-name").val("");
        	$("#groups-modalLabel").attr("xtable",tablek);
        	$("#groups-modalLabel").html("Chọn đơn vị tính");

        	var gvar=$(this).closest("tr").find("td:nth-child(3) input").val();
        	var dt={"key":"","table":$("#groups-modalLabel").attr("xtable"),"page":"1","var":""};
        	$("#search-ship-name").attr("var",gvar);
        	$('.page-content.fade-in-up').blockUI();
        	$.ajax({
        		url: AJAX_URL,
        		dataType: 'json',
        		data: dt,
        		type: 'POST',
        		success: function (data) {
        			$('.page-content.fade-in-up').unblock();
        			make_ftable(data);
        		},
        		error: function(err){
        			toastr["error"]("Tải dữ liệu thất bại !!");
        			$('.page-content.fade-in-up').unblock();
                	//console.log(err);
                }
            });
        });
        $(document).on(evClick,"#contenttable tr td:nth-child(2)",function(e){
        	datacall=this;
        	var tablek="BS_ITEM";
        	$("#search-ship-name").val("");
        	$("#groups-modalLabel").attr("xtable",tablek);
        	$("#groups-modalLabel").html("Chọn hàng hóa");

        	var gvar=$(this).closest("tr").find("td:nth-child(3) input").val();
        	var dt={"key":"","table":$("#groups-modalLabel").attr("xtable"),"page":"1","var":""};
        	$("#search-ship-name").attr("var",gvar);
        	$('.page-content.fade-in-up').blockUI();
        	$.ajax({
        		url: AJAX_URL,
        		dataType: 'json',
        		data: dt,
        		type: 'POST',
        		success: function (data) {
        			$('.page-content.fade-in-up').unblock();
        			make_ftable(data);
        		},
        		error: function(err){
        			toastr["error"]("Tải dữ liệu thất bại !!");
        			$('.page-content.fade-in-up').unblock();
                	//console.log(err);
                }
            });
        });

        $(document).on(evClick,"#InLenh",function(){
        	if($("#ORDERNO").val().substring(0,1)=="E")
        	window.open(ROOT_URL+"/"+ajd9+"/"+$("#ORDERNO").val());
        else
        	toastr["error"]("Xe này không xuất hàng !!");
        });

        $(document).on(evClick,"#select-ship",function(e){
        	if($(".trselected").length<=0) return false;
        	
        	if(!$(datacall).parent().hasClass("addnew"))
        		$(datacall).parent().addClass("editing");
        	if($(datacall).prop("tagName")=="INPUT")
        	{
        		
        		$(datacall).val($(".trselected").attr("idx"));
        		$(datacall).trigger("input");

        	}
        	else
        		if($(datacall).prop("tagName")=="TD")
        		{
	//$(datacall).html("<input class='hiden-input' value='"+$(".trselected").attr("idx")+"'>"+$(".trselected").find("td:nth-child(3)").html());
	if($("#groups-modalLabel").attr("xtable")=="CUSTOMERS")
	{
		if($("#contenttable2").length>0){
			$("#contenttable2").attr("xdata",$(".trselected").attr("idx"));
		}
	}
	if($(".trselected").closest("table").hasClass("cusi_table"))
	{
		$($(datacall).closest("table")).DataTable().cell($(datacall).closest("tr").find("td:nth-child(3)")).data("<input class='hiden-input' value='"+$(".trselected").attr("idx")+"'>"+$(".trselected").find("td:nth-child(3)").text()).draw();
		$($(datacall).closest("table")).DataTable().cell($(datacall).closest("tr").find("td:nth-child(4)")).data("<input class='hiden-input' value='"+$(".trselected").attr("unit")+"'>"+$(".trselected").find("td:nth-child(5)").text()).draw();
		$($(datacall).closest("table")).DataTable().cell($(datacall).closest("tr").find("td:nth-child(5)")).data($(".trselected").find("td:nth-child(4)").text()).draw();


	}
	else
		if($(".trselected").closest("table").hasClass("ckho_table"))
		{
			var jdata=JSON.parse($(".trselected").attr("jdata")); 
			$($(datacall).closest("table")).DataTable().cell($(datacall).closest("tr").find("td:nth-child(3)")).data("<input class='hiden-input' value='"+jdata[3]+"'>"+jdata[4]).draw();
			$($(datacall).closest("table")).DataTable().cell($(datacall).closest("tr").find("td:nth-child(4)")).data("<input class='hiden-input' value='"+jdata[1]+"'>"+jdata[2]).draw();


		}
		else
			
		{
			$($(datacall).closest("table")).DataTable().cell(datacall).data("<input class='hiden-input' value='"+$(".trselected").attr("idx")+"'>"+$(".trselected").find("td:nth-child(3)").html()).draw();
		}
	}
	
	if($(datacall).prop("tagName")=="SELECT")
		$(datacall).val($(".trselected").attr("idx"));
});

//gate pass
$("#quacong").on(evClick,function(){
	if($("#ORDERNO").val()==""){
		toastr["error"]("Số order không được để trống !");
		return false;
	}
	if($("#PINCODE").val()==""){
		toastr["error"]("Số Pin không được để trống !");
		return false;
	}
	if($("#TRUCKNO").val()==""){
		toastr["error"]("Số xe không được để trống !");
		return false;
	}
	var dt={
		"ORDERNO":$("#ORDERNO").val(),
		"PINCODE":$("#PINCODE").val(),
		"TRUCKNO":$("#TRUCKNO").val(),
		"DRIVER":$("#DRIVER").val(),
		"TEL":$("#TEL").val(),
		"TLDK":$("#TLDK").val(),
		"TTCPDK":$("#TTCPDK").val(),
		"REMOOCNO":$("#REMOOCNO").val(),
		"TLREMOOC":$("#TLREMOOC").val(),
		"TTCPREMOOC":$("#TTCPREMOOC").val(),
		"CONTAINER":$("#CONTAINER").val(),
		"COM":$("#COM").val(),
		"SIZE":$("#SIZE").val(),
		"GATE_CODE":gate,
		"NOTE":$("#NOTE").val()
	};
	$('.page-content.fade-in-up').blockUI();
	$.ajax({
		url: ROOT_URL+"/"+ajd1,
		dataType: 'json',
		data: dt,
		type: 'POST',
		success: function (data) {
			$('.page-content.fade-in-up').unblock();
			if(data.deny) {
				toastr["error"](data.deny);
				return;
			};
			if(data.success){
				toastr["success"](data.success);
				get_truck_in();
				$.confirm({
					title: data.success,
					type: 'orange',
					icon: 'fa fa-warning',
					content: 'Bạn muốn xóa dữ liệu cũ !',
					buttons: {
						ok: {
							text: 'Xác nhận',
							btnClass: 'btn-warning',
							keys: ['Enter'],
							action: function(){
								clearall();
							}
						},
						cancel: {
							text: 'Hủy bỏ',
							btnClass: 'btn-default',
							keys: ['ESC']
						}
					}
				});
			}
			
		},
		error: function(err){
			toastr["error"]("Error!");
			$('.page-content.fade-in-up').unblock();
			console.log(err);
		}
	});
});

});