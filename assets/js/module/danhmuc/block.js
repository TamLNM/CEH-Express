$(document).ready(function () {
		var _columns = ["STT", "Code", "Name", "Description", "Unit", "ItemGroup", "SKU", "NetWeight","CustomerNo"];

		var tbl = $('#contenttable');
		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
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
	//SET COMBOBOX cho lưới-----------------------------------------------------------------
	var cboUOM = [{"Code":0,"Name":"Tạm"},{"Code":1,"Name":"Sẵn Sàng"},{"Code":2,"Name":"Giữ"}];
	var tblDetails_Header = tbl.parent().prev().find('table');
	tblDetails_Header.find(' th:eq(5) ').setSelectSource( cboUOM.map( p=>p.Name ) );
	tbl.setExtendDropdown({
		target: "#cell-context-cboUOM",
		source: cboUOM.map( p=>p.Name ),
		colIndex: 5,
		onSelected: function(cell, value){
			var keys = cboUOM.filter(p => p.Name == value).map(x=>x.Code)[0];
			var tempHtml = "<input class='hiden-input' value='" + keys + "' >" + value;
			if(!$(cell).parent().hasClass("addnew"))
				$(cell).parent().addClass("editing");
			tbl.DataTable().cell(cell).data(tempHtml).draw(false);
		}
	});
	//--------------------------------------------------------------------------------------
	

		tbl.editableTableWidget(); //Cho Table Edit

		$('#addrow').on('click', function(){
			tbl.newRow();
			tbl.updateSTT(_columns.indexOf("STT"));
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
			if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0) {
				$('.toast').remove();
				toastr["info"]("Không có dữ liệu thay đổi!");
			}
			else {
				$.confirm({
					title: 'Thông báo!',
					type: 'orange',
					icon: 'fa fa-warning',
					content: 'Tất cả các thay đổi sẽ được lưu lại!\nTiếp tục?',
					buttons: {
						ok: {
							text: 'Xác nhận lưu',
							btnClass: 'btn-warning',
							keys: ['Enter'],
							action: function(){
								saveData();
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
		});


        //save functions
        function saveData(){        	
        	var newData = tbl.getAddNewData();

        	if(newData.length > 0){
        		var fnew = {
        			'action': 'add',
        			'data': newData
        		};
        		postSave(fnew);
        	}

        	var editData = tbl.getEditData();
        	if(editData.length > 0){
        		var fedit = {
        			'action': 'edit',
        			'data': editData
        		};
        		postSave(fedit);
        	}
        }

        function postSave(formData){
        	var checla=false;
        	if(formData.data.length>0){
        		$(formData.data).each(function(i,item){
        			if(item.TIER=="" || parseInt(item.TIER)<=0)
        			{
        				toastr["error"]("Số tần không được bé hơn 0!");checla=true;
        			}
        			if(item.SLOT=="" || parseInt(item.SLOT)<=0)
        			{
        				toastr["error"]("Số ô từng tần không được bé hơn 0!");checla=true;
        			}
        			if(item.BLOCK.trim()=="")
        			{
        				toastr["error"]("Tên block không được bỏ trống!");checla=true;
        			}
        			if(checla)
        				return false;
        			
        		});
        	}
        	if(checla)
        		return false;
        	var saveBtn = $('#save');
        	saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

        	$.ajax({
        		url: ROOT_URL+"/"+ajd1,
        		dataType: 'json',
        		data: formData,
        		type: 'POST',
        		success: function (data) {
        			saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
        			if(data.deny) {
        				toastr["error"](data.deny);
        				return;
        			};

                    $(data).each(function(i,item){
                        if(item.deny){
                            toastr["error"](item.deny);
                        }
                        if(item.success){
                            toastr["success"](item.success);
                            if(item.type=="add"){                                
                                var indexes = tbl.filterRowIndexes(1,item.data[tbl.find("tr th:nth-child(2)").attr('col-name')])[0];
                                tbl.DataTable().cell({ row: indexes, column: tbl.find("tr th").length-1 }).data(item.data.ROWGUID).draw(false);
                                tbl.DataTable().rows(indexes).nodes().to$().removeClass("editing").removeClass("addnew");
                                tbl.updateSTT(_columns.indexOf("STT"));
                            }
                            if(item.type=="edit"){
                                var indexes = tbl.filterRowIndexes(1,item.data[tbl.find("tr th:nth-child(2)").attr('col-name')])[0];
                                tbl.DataTable().rows(indexes).nodes().to$().removeClass("editing").removeClass("addnew");
                            }
                            
                        }
                    });
        			

        			
        		},
        		error: function(err){
        			toastr["error"]("Error!");
        			saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
        			console.log(err);
        		}
        	});
        }

        function postDel(rows){
        	$('.ibox.collapsible-box').blockUI();

        	var delUnits = rows.map(p=>p[tbl.find("tr th").length-1]);

        	var delBtn = $('#delete');
        	delBtn.button('loading');

        	var formdata = {
        		'action': 'delete',
        		'data': delUnits
        	};
        	$.ajax({
        		url: ROOT_URL+"/"+ajd1,
        		dataType: 'json',
        		data: formdata,
        		type: 'POST',
        		success: function (output) {
        			delBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
        			if(output.deny) {
        				toastr["error"](output.deny);
        				return;
        			};
        			var data = output.result;
        			if(data.error && data.error.length > 0){
        				for (var i = 0; i < data.error.length; i++) {
        					toastr["error"](data.error[i]);
        				}
        			}

        			if(data.success && data.success.length > 0){
        				for (var i = 0; i < data.success.length; i++) {
        					var deletedUnitCode = data.success[i].split(':')[1].trim();
        					var indexes = tbl.filterRowIndexes( tbl.find("tr th").length-1, deletedUnitCode);
        					tbl.DataTable().rows( indexes ).remove().draw( false );
        					tbl.updateSTT( _columns.indexOf( "STT" ) );
        					toastr["success"]( data.success[i] );
        				}
        			}

        			$('.ibox.collapsible-box').unblock();
        		},
        		error: function(err){
        			delBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
        			console.log(err);
        		}
        	});
        }















        /*ajax select*/
        
        $(document).on("mouseenter","#contenttable tr td:nth-child(5)",function(e){
        	$(".vk_findaq").remove();
        	$(this).append("<div class='vk_findaq'></div>");
        });
        $(document).on("mouseleave","#contenttable tr td:nth-child(5)",function(e){
        	$(".vk_findaq").remove();
        });
        $(document).on("click","#contenttable tr td:nth-child(5)",function(e){
        	datacall=this;
        	var tablek=ajd2;
        	$("#search-ship-name").val("");
        	$("#groups-modalLabel").attr("xtable",tablek);
        	$("#groups-modalLabel").html("Chọn kho");
        	
        	var gvar=$(this).closest("tr").find("td:nth-child(3) input").val();
        	var dt={"key":"","table":$("#groups-modalLabel").attr("xtable"),"page":"1","var":""};
        	$("#search-ship-name").attr("var",gvar);
        	
        	$('.ibox.collapsible-box').blockUI();
        	$.ajax({
        		url: AJAX_URL,
        		dataType: 'json',
        		data: dt,
        		type: 'POST',
        		success: function (data) {
        			$('.ibox.collapsible-box').unblock();
        			make_ftable(data);
        		},
        		error: function(err){
        			toastr["error"]("Tải dữ liệu thất bại !!");
        			$('.ibox.collapsible-box').unblock();
                	//console.log(err);
                }
            });
        });


        

        $(document).on("click","#select-ship",function(e){
        	if($(".trselected").length<=0) return false;
        	if(!$(datacall).parent().hasClass("addnew"))
        		$(datacall).parent().addClass("editing");
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

        /*end ajax select*/

        

//file input
var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function () {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);

    $.ajax({
        type: "POST",
        url: ROOT_URL+"/"+ajd3,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
            var data=JSON.parse(data);
            $("#fileinput").val('');
            if(data.length>0)
            {
                var stt=$("#contenttable").DataTable().rows().count();
                $.each(data, function (k, v) {  
                    stt++;
                    var ite=[];
                    ite[0]=stt;
                    
                    ite[1]=v[1];
                    ite[2]=v[2];
                    ite[3]=v[3];
                    ite[4]=v[4];
                    ite[5]=v[5];
                    ite[6]=v[6];
                    if(ite[5]=="Giữ")
                        ite[5]='<input class="hiden-input" value=2>Giữ';
                    else
                        ite[5]='<input class="hiden-input" value=1>Sẵn sàng';          
                    
                    ite[7]=0;
                    ite[8]="";
                    var addj=$("#contenttable").DataTable().row.add(ite).draw();    
                    $("#contenttable").find("tr").eq(stt).addClass("addnew");    
                });
            }
        },
        error: function (error) {
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    console.log(percent+"%");
};
$(document).on("click","#addexcel",function(){
    $("#fileinput").trigger("click");
});
$(document).on("change","#fileinput",function(){
    var code=$(this).attr("code");
    var file = $("#fileinput")[0].files[0];
    var upload = new Upload(file);
    upload.doUpload();
});




});