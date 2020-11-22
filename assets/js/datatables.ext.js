/**
 * Created by ad on 11/30/2017.
 */
 var _selectionSoure;
(function($) {
	$.pasteCell = function(callback) {
        var allowPaste = true;
        var foundContent = false;
        if(typeof(callback) == "function") {
            
            // Patch jQuery to add clipboardData property support in the event object
            $.event.props.push('clipboardData');
            
            // Add the paste event listener
            $(document).bind("paste", doPaste);

            // If Firefox (doesn't support clipboard object), create DIV to catch pasted image
            if (!window.Clipboard) { // Firefox
                var pasteCatcher = $(document.createElement("textarea"));
                pasteCatcher.css({"position" : "absolute", "left" : "-999",  width : "0", height : "0", "overflow" : "hidden", outline : 0});
                $(document.body).prepend(pasteCatcher);
            }
        }
        // Handle paste event
        function doPaste(e)  {
            if(allowPaste == true && $(e.target).is("td") ) {     // conditionally set allowPaste to false in situations where you want to do regular paste instead
                // Check for event.clipboardData support
                if (e.clipboardData.items) { // Chrome
                    // Get the items from the clipboard
                    var content = e.clipboardData.getData('Text');
                    if (content) {
                        callback(content);
                    }
                } else {
                    /* If we can't handle clipboard data directly (Firefox), we need to read what was pasted from the contenteditable element */
                    //Since paste event detected, focus on DIV to receive pasted image
                    pasteCatcher.focus();
                    foundContent = true;
                    // "This is a cheap trick to make sure we read the data AFTER it has been inserted"
                    setTimeout(checkInput, 100); // May need to be longer if large image
                }
            }
        }

        /* Parse the input in the paste catcher element */
        function checkInput() {
            // Store the pasted content in a variable
            if(foundContent == true) {
                if (pasteCatcher.text()) {
                    callback(pasteCatcher.text());
                    foundContent = false;
                    pasteCatcher.html(""); // erase contents of pasteCatcher DIV
                }
            }
        }   
    };

    $.isDateValid = function(value) {
        switch (typeof value) {
            case 'string':
                return !isNaN(Date.parse(value));
            case 'object':
                if (value instanceof Date) {
                    return !isNaN(value.getTime());
                }
            default:
                return false;
        }
    };

    $.tableSelectPicker = function(option){
		option.Container = "body";

		return $(this).each(function(idx, item){
			$(item).selectpicker(option);
		})
	};

})(jQuery);

$.fn.extend({
	setSelectSource: function (source) {
		$(this).attr('select-source', JSON.stringify(source));
	},
	moreButton: function( option ){
		var colIndexs = option.columns,
			callback = option.onShow;

		var tbl = $(this);

		$(document).on("click", "td.show-more", function(e){
			var cell = $( this ),
				roww = $( this ).closest("tr");

			if( !cell.closest("table").is(tbl) ){
				e.preventDefault();
				return;
			}

			var indx = Array.isArray( colIndexs ) ? colIndexs : [colIndexs];
			if( indx.indexOf( cell.index() ) == -1 ){
				e.preventDefault();
				return;
			}

			var widthOfAfterCell = parseInt( parseFloat( window.getComputedStyle( cell[0], ":after" ).width ).toFixed(0) ),
				paddingRightOfCell = parseInt( cell.css("padding-right") ),
				righOfAfterCell = parseInt( window.getComputedStyle( cell[0], ":after" ).right );

			if( e.offsetX > ( cell[0].offsetWidth
										- (widthOfAfterCell > paddingRightOfCell ? widthOfAfterCell : paddingRightOfCell)
										- righOfAfterCell ) )
			{
				$( tbl.find("th:eq("+ cell.index() +")").attr("show-target") ).modal("show");

				callback( cell );
			}
		});
	},
	setExtendSelect: function(colIndex, callback){
		var tbl = $(this), td;
		var cloneProperties = ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right', 'font', 'font-size', 'font-family', 'font-weight'];

		var btn = document.createElement("button");
		btn.innerText = "...";
		btn.className = "btn";
		btn.style.cssText = "position: absolute; z-index: 3; display: none";
		tbl.parent().append(btn);

		var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
		var x1, x2, y1, y2;

		$(document).on("mouseover", "td", function(){
			if(!$(this).closest("table").is(tbl) || !$(this).closest("tr").find("td:eq("+colIndex+")").is($(this))){
				return;
			}

			td = $(this);

			var parentOffset = td.offset();
			x1 = parentOffset.left; x2 = parentOffset.left + td.outerWidth(); y1 = parentOffset.top; y2 = parentOffset.top + td.outerHeight();

			$(btn).css(td.css(cloneProperties));
			$(btn).show()
				.offset({
					top: parentOffset.top + 4,
					left: parentOffset.left + (td.width() - $(btn).width() -7)
				})
				.height(td.height() - 7); //- 3 

			td.on("mouseout", function(event){
				if((event.pageX < x1 || event.pageX > x2) || (event.pageY < y1 || event.pageY > y2)){
					$(btn).hide();
				}
			});
		});

		$(btn).on("mouseout", function(e){
			if(e.pageX > x2){
				$(btn).hide();
			}
		});

		tbl.on("mouseout", function(e){
			if(e.pageX > x2){
				$(btn).hide();
			}
		});

		$(btn).on("click", function(){
			var rowIndex = td.closest("tr").index();
			callback(rowIndex, colIndex);
		});
	},
	columnDropdownButton: function( option ){
		var tbl = $(this);

		return this.each(function () {

            // Open context menu
            $(this).on("click", "td.show-dropdown", function (e) {
            	var cell = $( this ),
					roww = $( this ).closest("tr");

				$(".dropdown-menu.dropdown-menu-column").remove();

				if( !cell.closest("table").is(tbl) ){
					e.preventDefault();
					return;
				}

				var indx = option.data.map( x => x.colIndex );
				if( !indx || indx.length == 0 || indx.indexOf( cell.index() ) == -1 ){
					e.preventDefault();
					return;
				}

				var widthOfAfterCell = parseInt( parseFloat( window.getComputedStyle( cell[0], ":after" ).width ).toFixed(0) ),
					paddingRightOfCell = parseInt( cell.css("padding-right") ),
					righOfAfterCell = parseInt( window.getComputedStyle( cell[0], ":after" ).right );

				if( e.offsetX > ( cell[0].offsetWidth
					 				- (widthOfAfterCell > paddingRightOfCell ? (widthOfAfterCell - righOfAfterCell) : paddingRightOfCell) ) )
				{
					var ul = document.createElement("div");
					ul.setAttribute( "role", "menu" );
					ul.className =  "dropdown-menu dropdown-menu-column";
					ul.style.css = "display: none";

					var source = option.data.filter( p => p.colIndex == cell.index() ).map( x => x.source )[0];
					$.each(source, function(idx, item){
						var dta;

						if(typeof(item) === "object" || Array.isArray(item)){
							dta = $.map(item, function(value, index) {
							    return [value];
							});
						}else{
							dta = [item];
						}
						var strLi = '<li><a tabindex="-1" href="#" code="'+ dta[0] +'">'
										+ ( dta[1] ? dta[1] : dta[0] ) 
									+'</a></li>';

						ul.innerHTML += strLi;
					});

					$("body").append( ul );
	                // //open menu
	                $(ul).data("cellClicked", $(e.target))
	                    .show()
	                    .css({
	                        position: "absolute",
	                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
	                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
	                    })
	                    .off('click')
	                    .on('click', 'a', function (e) {
	                
	                        var $cellClicked = $(ul).data("cellClicked");
	                        var $selectedMenu = $(e.target);

	                        $(ul).remove();

	                        option.onSelected.call(this, $cellClicked, $selectedMenu);
	                    });
				}
                return false;
            });

            // //make sure menu closes on any click
            $('body').click(function () {
                $(".dropdown-menu.dropdown-menu-column").remove();
            });
        });

        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(".dropdown-menu.dropdown-menu-column:last")[direction](),
                position = mouse + scroll;
                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }
		
	},
	setExtendDropdown: function(option){
		var target = option.target,
			source = option.source,
			colIndex = option.colIndex,
			callback = option.onSelected;

		if(!source || source.length == 0) {
			$(target).find(".dropdown-menu").empty();
			return;
		}

		var tbl = $(this), td;
		var cloneProperties = ['font', 'font-size', 'font-family', 'font-weight'];

		$(target).css({position: "absolute", zIndex: "105", display: "none"});
		$(target).find(".dropdown-menu").empty();

		$.each(source, function(idx, item){
			var dta;

			if(typeof(item) === "object" || Array.isArray(item)){
				dta = $.map(item, function(value, index) {
				    return [value];
				});
			}else{
				dta = [item];
			}

			$(target).find(".dropdown-menu").append(
				''//'<div style="max-height: 30px!important; min-height: 30px!important; background-color: #eee; color: white!important">'
				+ '<li><a style="width: 100%; left: 5px; background-color: white; background-color: #FFFACD;"  class="dropdown-item";>'+ dta[0] + (dta[1] ? ('<span class="sub-text">'+ dta[1] +'</span>') : "") 
				+ '</a></li>'
			);
		});


		tbl.parent().parent().append($(target));

		var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
		var x1, x2, y1, y2;
		var dropMenu = $(target).find(".dropdown-menu");


		/*
		$(document).on("mouseover", "td", function(){
			if(!$(this).closest("table").is(tbl) || !$(this).closest("tr").find("td:eq("+colIndex+")").is($(this))){
				return;
			}

			td = $(this);

			var parentOffset = td.offset(),
				dOffset = dropMenu.offset();

			x1 = parentOffset.left >= dOffset.left ? parentOffset.left : dOffset.left;
			x2 = (parentOffset.left + td.outerWidth()) >= (dOffset.left + dropMenu.outerWidth()) 
														? (parentOffset.left + td.outerWidth()) : (dOffset.left + dropMenu.outerWidth());
			y1 = parentOffset.top <= dOffset.top ? parentOffset.top : dOffset.top;
			y2 = (parentOffset.top + td.outerHeight()) >= (dOffset.top + dropMenu.outerHeight())
														? (parentOffset.top + td.outerHeight()) : (dOffset.top + dropMenu.outerHeight());

			$(target).css(td.css(cloneProperties));
			$(target).show()
					.offset({
						top: parentOffset.top + 3,
						left: parentOffset.left + 5,
					})
					.height(td.innerHeight() - 5)
					.width(td.innerWidth() * 0.6);

			td.on("mouseout", function(event){
				if((event.pageX < x1 || event.pageX > x2) || (event.pageY < y1 || event.pageY > y2)){
					dropMenu.removeClass("show");
					$(target).hide();
				}
			});
		});
		*/

		var tdOffsetBef;
		$(document).on("click", "td", function(){
			if(!$(this).closest("table").is(tbl) || !$(this).closest("tr").find("td:eq("+colIndex+")").is($(this))){
				return;
			}

			td = $(this);

			var parentOffset = td.offset(),
				dOffset = dropMenu.offset();

			if (tdOffsetBef && tdOffsetBef.left == parentOffset.left && tdOffsetBef.top == parentOffset.top){
				dropMenu.removeClass("show");
				$(target).hide();
				tdOffsetBef = '';
				return;
			}
			tdOffsetBef = parentOffset;

			x1 = parentOffset.left >= dOffset.left ? parentOffset.left : dOffset.left;
			x2 = (parentOffset.left + td.outerWidth()) >= (dOffset.left + dropMenu.outerWidth()) 
														? (parentOffset.left + td.outerWidth()) : (dOffset.left + dropMenu.outerWidth());
			y1 = parentOffset.top <= dOffset.top ? parentOffset.top : dOffset.top;
			y2 = (parentOffset.top + td.outerHeight()) >= (dOffset.top + dropMenu.outerHeight())
														? (parentOffset.top + td.outerHeight()) : (dOffset.top + dropMenu.outerHeight());

			$(target).css(td.css(cloneProperties));
			$(target).show()
					.offset({
						top: parentOffset.top + 3,
						left: parentOffset.left + 5,
					})
					.height(td.innerHeight() - 5)
					.width(td.innerWidth() * 0.6);

			td.on("mouseout", function(event){
				if((event.pageX < x1 || event.pageX > x2) || (event.pageY < y1 || event.pageY > y2)){
					tdOffsetBef = '';
					dropMenu.removeClass("show");
					$(target).hide();
				}
			});
		});

		/*
		tbl.on("mouseout", function(e){
			if(e.pageX > x2){
				dropMenu.removeClass("show");
				$(target).hide();
			}
		});
		*/

		$(target).on("mouseout", function(e){
			if(e.pageX > x2){
				dropMenu.removeClass("show");
				$(target).hide();
			}
		});
		
		$(target).on("click", "a.dropdown-item", function(){
			dropMenu.removeClass("show");
			$(target).hide();
			callback( td, $( this ).contents().not( $( this ).children() ).text() );
		});
	}
});
$.fn.extend({	
	initComplete: function(x){
		var tbl = $(this);
		var cusName = tbl.selector.replace('#', '');

		var styleFormatL   = '"width: 80px; height: 20px; margin-right: 3px; margin-top: 5px;"',
			styleFormatS   = '"width: 40px; height: 20px; margin-right: 3px; margin-top: 5px;"',
			styleFormatKT  = '"height: 20px; margin-right: 3px; margin-top: 5px; border: none; background-color: transparent; color: red; text-decoration: underline;"',
			styleFormatDNK = '"height: 20px; margin-right: 3px; margin-top: 5px; border: none; background-color: transparent; color: green; text-decoration: underline;"';

		if (x && x.IMPORT) {
			var src = '<input style="width: 60px; height: 20px; margin-right: 3px; margin-top: 5px;" type="button" value="Import" name="" id="btnImport" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(src);
		}

		if (x && x.EXPORT){
			var btnSrc =  '<button id="btnExport" style="font-family: Times New Roman; border-radius: 5px; height: 2rem; width: 7vw; background-color: #207b99; border: #207b99 solid 1px; color: white; margin-left: 10px;"><p style="margin-top: auto; margin-bottom: auto">Xuất Excel</p></button>';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}

		if (x && x.REFRESH) {
			var cusRef = "<button id=\"" + cusName + "_btnSearch\" class=\"btn btn-outline-warning btn-sm btn-loading mr-1\" data-loading-text=\"<i class='la la-spinner spinner'></i>Nạp\" title=\"Nạp\"> \
				<span class=\"btn-icon\"><i class=\"ti-search\"></i>Nạp</span></button>";
			// $(tbl.selector + '_wrapper .datatable-info-right').css({"margin-right":"0px","padding-top":"3px"}).append(cusRef);
			$(tbl.selector + '_wrapper .datatable-info-right').append(cusRef);
		}
		if (x && x.ADD) {
			var cusAdd = '<input style=' + styleFormatL + ' type="button" value="Thêm dòng" name="" id="btnAdd" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(cusAdd);

			$(document).on('click', tbl.selector + "_btnAdd", function(){
				$('#add-row-modal').attr("cusTable", tbl.selector);
				$('#add-row-modal').modal("show");
			});
		}
		if (x && x.SAVE) {
			var cusSave = '<input style=' + styleFormatS + ' type="button" value="Lưu" name="" id="btnSave" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(cusSave);
		}
		if (x && x.DELETE) {
			var cusDelete = '<input style=' + styleFormatS + ' type="button" value="Xóa" name="" id="btnDelete" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(cusDelete);
		}
		if (x && x.WAREHOUSE) {
			var btnSrc = '<input style=' + styleFormatL + ' type="button" value="Chọn kho" name="" id="btnChooseWarehouse" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}
		if (x && x.KT){
			var btnSrc = '<input style=' + styleFormatKT + ' type="button" value="Khởi tạo" name="" id="btnKT" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}

		if (x && x.NK){
			var btnSrc = '<input style=' + styleFormatDNK + ' type="button" value="Đã nhập kho" name="" id="btnNK" class="button">';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}

		if (x && x.THCK){
			var btnSrc =  '<button id="transport_warehouse" style="font-family: Times New Roman; border-radius: 5px; height: 2rem; width: 15vw; background-color: #207b99; border: #207b99 solid 1px; color: white; margin-left: 10px;"><p style="margin-top: auto; margin-bottom: auto">THỰC HIỆN CHUYỂN KHO</p></button>';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}

		if (x && x.XNNK){
			var btnSrc =  '<button id="confirm_import_stock" style="font-family: Times New Roman; border-radius: 5px; height: 2rem; width: 15vw; background-color: #207b99; border: #207b99 solid 1px; color: white; margin-left: 10px;"><p style="margin-top: auto; margin-bottom: auto">XÁC NHẬN NHẬP KHO</p></button>';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}

		if (x && x.QMCT){
			var btnSrc =  '<button id="check_QR_import_stock" style="font-family: Times New Roman; border-radius: 5px; height: 2rem; width: 150px; background-color: #207b99; border: #207b99 solid 1px; color: white; margin-left: 10px;"><p style="margin-top: auto; margin-bottom: auto"><span class="btn-icon"><i class="fa fa-barcode"></i>Quét mã chứng từ</span></p></button>';
			$(tbl.selector + '_wrapper .datatable-info-right').append(btnSrc);
		}
		$(tbl.selector + '_info').css("display", "none");
	},
	newDataTable: function(opt){
		var tbl = $(this);
		if(opt){
			if(opt.arrayColumns && opt.arrayColumns.length > 0){
				var headers = tbl.find('thead:first tr:first').find('th');
				$.each(headers, function(idx, item){
					$(item).attr('col-name', opt.arrayColumns[idx]);
				});
				delete opt.arrayColumns;
			}
			return tbl.DataTable(opt);
		}else{
			return tbl.DataTable();
		}
	},
	allowedit: function() {
		if($(this).has("input").length){
			var xx = $(this).find("input").first();
			if(xx.css('display') != 'none' || xx.attr('type') == 'checkbox')
				return false;
		}
		if($(this).has("select").length){
			return false
		}
		if($(this).has("button").length){
			return false
		}
		if($(this).parent().hasClass("addnew")){
			return false;
		}
		if($(this).parent().find('td:first-child').is($(this))){
			return false;
		}
		return true;
	},
	getAddNewData: function(_saveColumns){
		return this.getChangedData(_saveColumns, ".addnew");
	},
	getEditData: function(_saveColumns){
		return this.getChangedData(_saveColumns, ".editing");
	},
	getChangedData: function(_saveColumns, typeClass){
		var tbl = $(this).DataTable();
		var result = [];
		var headers = $(this).find('thead:first tr:first');
		var changedData = tbl.rows( typeClass ).data().toArray();

		if(changedData.length > 0){
			$.each(changedData, function(idx, row){
				var rowData = {};
				if(_saveColumns && _saveColumns.length > 0){
					$.each(_saveColumns, function(index, item){
						var colIndex = headers.find('th[col-name="'+item+'"]').index();
						var content = row[colIndex ? colIndex : index];

						var tmp = document.createElement("div");
						tmp.innerHTML = content;

						if($(tmp).find("input").length > 0){
							var inp = $(tmp).find("input").first();
							content = inp.attr("type") == "checkbox" ? (inp.is(":checked") ? "1" : "0") : inp.val();
						}else{
							content = $(tmp).text();
						}

						rowData[item] = content;
					});
				}else{
					$.each(row, function(i, t){
						var colName = headers.find('th:eq('+i+')').first().attr('col-name');
						if(colName == "STT"){
							return;
						}
						var content = t;
		
						var tmp = document.createElement("div");
						tmp.innerHTML = content;

						if($(tmp).find("input").length > 0){
							var inp = $(tmp).find("input").first();
							content = inp.attr("type") == "checkbox" ? (inp.is(":checked") ? "1" : "0") : inp.val();
						}else{
							content = $(tmp).text();
						}

						rowData[colName ? colName : i] = content;
					});
				}
				result.push(rowData);
			});
		}
		return result;
	},
	newRow: function(){
		// if (typeof objec === "undefined" || objec === null) {
		// 	objec = $(this);
		// }
		var objec = $(this);
		var colnums = objec.find('thead:first tr:first').find('th');

		var rowdata = [];
		var eqHidden = [];

		var styleFormatL = '"font-size: 11px; background-color: transparent; margin-right: 3px; font-style: italic; color: red; font-weight: bold; border: none;"';

		for(var i=0; i<=colnums.size()-1; i++){
			var datatypes = $(colnums[i]).attr('class').match(/data-type-([0-9a-zA-Z]\S+)/);
			var cell_data = "";

			if($(colnums[i]).hasClass('hiden-input')){
				eqHidden.push(i);
			}

			/*
			if ($(colnums[i]).attr('col-name') == 'STT') {
				cell_data = "00.";
			}
			*/

			if(datatypes != null && datatypes[1]){
				switch (datatypes[1]){
					case "button":
						cell_data= "<button class='btn btn-xs btn-default'>...</button>";
						break;
					case "numeric":
						cell_data = 0;
						break;
					case "checkbox":
						cell_data = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked="true"><span class="input-span"></span></label>';
						break;
					case "color":
						cell_data = '<input type="color" value="#000000">';
						break;
					case "address":
						cell_data = '<button style=' + styleFormatL + ' value="Thêm địa chỉ" name="" class="addAddress">(+) Thêm địa chỉ</button>';
						break;
					case "shipping-address":
						cell_data = '<button style=' + styleFormatL + ' value="Thêm địa chỉ" name="" class="addShippingAddress">(+) Thêm địa chỉ</button>';
						break;
					case "tariff":
						cell_data = '<button style=' + styleFormatL + ' value="Chọn biểu cước" name="" class="addTariff">(+) Chọn biểu cước</button>';
						break;
					case "stocktype":
						cell_data = '<button style=' + styleFormatL + ' value="Chọn loại hàng" name="" class="addStockType">(+) Chọn loại hàng</button>';
						break;
					default:
						break;
				}
			}
			rowdata.push(cell_data);
		}
		var rowNodes = objec.DataTable().row.add(rowdata).draw( false ).node();

		$( rowNodes ).addClass("addnew").find('td').attr('tabindex', 1);
		$.each(eqHidden, function(k, i){
			$( rowNodes ).find('td:eq('+i+')').addClass('hiden-input');
		});
	},
	newMoreRows: function(rowsNumeric, currentRowsCount){
		var object = $(this);
		var colnums = object.find('thead:first tr:first').find('th');
		var styleFormatL = '"font-size: 11px; background-color: transparent; margin-right: 3px; font-style: italic; color: red; font-weight: bold; border: none;"';

		for(j = currentRowsCount; j < currentRowsCount + rowsNumeric; j++){			
			var rowdata = [], eqHidden = [];
			for(var i=0; i<=colnums.size()-1; i++){
				var datatypes = $(colnums[i]).attr('class').match(/data-type-([0-9a-zA-Z]\S+)/),
					cell_data = "";
					
				if($(colnums[i]).hasClass('hiden-input')){
					eqHidden.push(i);
				}

				if ($(colnums[i]).attr('col-name') == 'STT') {
					cell_data = j + 1 - currentRowsCount;
				}

				if(datatypes != null && datatypes[1]){
					switch (datatypes[1]){
						case "button":
							cell_data = "<button class='btn btn-xs btn-default'>...</button>";
							break;
						case "numeric":
							cell_data = 0;
							break;
						case "checkbox":
							cell_data = '<label class="checkbox checkbox-primary"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
							break;
						case "color":
							cell_data = '<input type="color" value="#000000">';
							break;
						case "address":
							cell_data = '<button style=' + styleFormatL + ' value="Thêm địa chỉ" name="" class="addAddress">(+) Thêm địa chỉ</button>';
							break;
						case "shipping-address":
							cell_data = '<button style=' + styleFormatL + ' value="Thêm địa chỉ" name="" class="addShippingAddress">(+) Thêm địa chỉ</button>';
							break;
						case "tariff":
							cell_data = '<button style=' + styleFormatL + ' value="Chọn biểu cước" name="" class="addTariff">(+) Chọn biểu cước</button>';
							break;
						case "stocktype":
							cell_data = '<button style=' + styleFormatL + ' value="Chọn loại hàng" name="" class="addStockType">(+) Chọn loại hàng</button>';
							break;
					}
				}
				rowdata.push(cell_data);
			}
			rowNodes = object.DataTable().row.add(rowdata).draw( false ).node();
			$( rowNodes ).addClass("addnew").find('td').attr('tabindex', j + 1);
			$.each(eqHidden, function(k, i){
				$( rowNodes ).find('td:eq('+i+')').addClass('hiden-input');
			});
		}		
	},
	newRow_1: function(callback){
		// if (typeof objec === "undefined" || objec === null) {
		// 	objec = $(this);
		// }
		var objec = $(this);
		var colnums = objec.find('thead:first tr:first').find('th');

		var rowdata = [];
		var eqHidden = [];
		for(var i=0; i<=colnums.size()-1; i++){
			var datatypes = $(colnums[i]).attr('class').match(/data-type-([0-9a-zA-Z]\S+)/);
			var cell_data = "";

			if($(colnums[i]).hasClass('hiden-input')){
				eqHidden.push(i);
			}

			if ($(colnums[i]).attr('col-name') == 'STT') {
				cell_data = "00.";
			}

			var defaultVal = $(colnums[i]).attr('default-col-val');
			if ( defaultVal ) {
				cell_data = defaultVal;
			}
			

			if(datatypes != null && datatypes[1]){
				switch (datatypes[1]){
					case "button":
						cell_data= "<button class='btn btn-xs btn-default'>...</button>";
						break;
					case "numeric":
						cell_data = 0;
						break;
					case "checkbox":
						cell_data = '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>';
						break;
				}
			}
			rowdata.push(cell_data);
		}
		var rowNodes = objec.DataTable().row.add(rowdata).draw( false )
														.node();

		$( rowNodes ).addClass("addnew").find('td').attr('tabindex', 1);
		$.each(eqHidden, function(k, i){
			$( rowNodes ).find('td:eq('+i+')').addClass('hiden-input');
		});
		callback(rowNodes);
	},
	waitingLoad: function (columncount) {
		$(this).removeClass('selected-all').removeClass('deselected-all');

		if (typeof columncount === "undefined" || columncount === null) {
			columncount = $(this).find('thead tr:first').children().length;
		}

		var sub = window.location.pathname.split( '/' )[1].indexOf('index') > -1 ? "":window.location.pathname.split( '/' )[1] ;
		var baseurl = window.location.origin+"/"+sub;
		$(this).find("tr:not(:first)").remove();
		$(this).find("tbody:first").append('<tr><td colspan="'+columncount+'" align="center"><img src="'+ (baseurl+'/assets/img/process-bar.gif') +'"></td></tr>');
	},
	getData: function() {
		var table = $(this).DataTable();
		var rows = [];

		var data = table
					.rows()
					.data()
					.to$();

		$.each(data, function (k, v) {
			var erows2 = [];
			if(v.length > 0){
				$.each(v, function (k1, v1) {
					var td = "<td>"+v1+"</td>";
					var inp = $(td).find('input:first, select:first').val();
					if(inp != undefined){
						erows2.push(inp);
					}
					else{
						erows2.push($(td).text() == "null" ? "" : $(td).text());
					}
				});
				rows.push(erows2);
			}
		});

		return rows;
	},
	getDataByColumns: function (colnames) {
		var tbl = $(this).DataTable();
		var rows = tbl.rows().data().toArray();
		var allRows = [];

		if(rows.length == 0) return {};
		for(var i = 0; i < rows.length; i++){
			var temp = {};

			for(var j = 0; j < rows[i].length; j++){
				var celldata = (rows[i][j]).toString().replace(/\<button(.*)\<\/button\>/, '');
				var vlue = celldata;
				
				var tagInput = celldata.match(/\<input(.*)\>/);
				if(tagInput != null && tagInput[0]){
					var n = $("<div>"+celldata+"</div>").find('input:first');
					if($(n).is(":checkbox")){
						vlue = $(n).attr("value") ? $(n).attr("value") : "0";
					}else{
						vlue = $(n).val();
					}
				}else{
					var tagDiv = celldata.match(/\<div(.*)\<\/div\>/);
					if(tagDiv != null && tagDiv[0]){
						vlue = $(tagDiv[0]).text();
					}
				}
				temp[colnames[j]] = vlue;
			}
			allRows.push(temp);
		}
		return allRows;
	},
	getRowData: function (colnames, row) {
		var tbl = $(this).DataTable();
		var rows = tbl.rows(row).data().toArray();
		if(rows.length == 0) return {};
		var temp = {};
		for(var j = 0; j < rows[0].length; j++){
			var celldata = (rows[0][j]).toString().replace(/\<button(.*)\<\/button\>/, '');
			var vlue = celldata;
			
			var tagInput = celldata.match(/\<input(.*)\>/);
			if(tagInput != null && tagInput[0]){
				var n = $("<div>"+celldata+"</div>").find('input:first');
				if($(n).is(":checkbox")){
					vlue = $(n).attr("value") ? $(n).attr("value") : "0";
				}else{
					vlue = $(n).val();
				}
			}else{
				var tagDiv = celldata.match(/\<div(.*)\<\/div\>/);
				if(tagDiv != null && tagDiv[0]){
					vlue = $(tagDiv[0]).text();
				}
			}
			temp[colnames[j]] = vlue;
		}
		return temp;
	},
	getEditedRows: function () {
		var table = $(this).DataTable();
		var editrows = [];
		var isImport = $(this).attr('is-import');
		if(!isImport || isImport == "0"){
			table.rows('.editing').every( function ( rowIdx, tableLoop, rowLoop ) {
				var r = this.row(rowIdx).node();
				var erows = [];
				var etds = $(r).find('td');
				if(etds.length > 0)
				{
					etds.each(function(){
						var inp = $(this).find('input:first, select:first').val();
						if(inp != undefined){
							erows.push(inp);
						}
						else{
							erows.push($(this).text() == "null" ? "" : $(this).text());
						}
					});
					editrows.push(erows);
				}
			} );
		}else{
			var data = table
						.rows()
						.data()
						.to$();
			$.each(data, function (k, v) {
				var erows2 = [];
				if(v.length > 0){
					$.each(v, function (k1, v1) {
						var td = "<td>"+v1+"</td>";
						var inp = $(td).find('input:first, select:first').val();
						if(inp != undefined){
							erows2.push(inp);
						}
						else{
							erows2.push($(td).text() == "null" ? "" : $(td).text());
						}
					});
					editrows.push(erows2);
				}
			});
		}
		return editrows;
	},
	getNewRows: function () {
		var addnewrows = [];
		$(this).find('tr.addnew').each(function() {
			var nrows = [];
			var ntds = $(this).find('td');
			if(ntds.length > 0)
			{
				ntds.each(function(td){
					var inp = $(this).find("input:first, select:first").val();
					if(inp != undefined){
						nrows.push(inp);
					}
					else{
						nrows.push($(this).text() == "null" ? "" : $(this).text());
					}
				});
				addnewrows.push(nrows);
			}
		});
		return addnewrows;
	},
	validate_required: function () {
		var datas = $(this).find('tr.m-row-selected, tr.editing, tr.addnew').find('td.m-required');
		var checkError = [];
		$.each(datas, function (key, data) {
			var content;
			if($(data).find('input, select').length > 0){
				content = $(data).find('input, select').first().val();
			}else{
				content = $(data).text();
			}

			if(!content){
				var IDRef = $(data).parent().find('td:eq(0)');
				if(!IDRef && !$(data).parent().hasClass('editing')) return;

				$(data).addClass('error');
				checkError.push('error');
			}
		});
		if(checkError.length > 0){
			toastr["error"]('Vui lòng nhập đầy đủ thông tin!');
			return false;
		}
 		return true;
	},
	updateSTT: function (col_index){
		if (typeof col_index === "undefined" || col_index === null) {
			col_index = 0;
		}
		var tbl = $(this).DataTable();
		var data = tbl.rows().data();
		if(!data || data.length == 0) return;
		$.each(data.toArray(), function(idx, item){
			tbl.cell(idx, col_index).data(idx + 1);
		});
		tbl.draw(false);
	},
	filterRowIndexes: function(colIndx, key){
		var tbl = $(this).DataTable();
		return tbl.rows()
					.eq( 0 )
					.filter( function (rowIdx) {
							    return tbl.cell( rowIdx, colIndx ).data() === key ? true : false;
							} );;
	},
	getSelectedRows: function () {
		var tbl = $(this).DataTable();
		var selectedrows = tbl.rows('.selected');
		if(!selectedrows.data() || selectedrows.data().length == 0) return [];
		return selectedrows;
	},
	getSelectedData: function () {;
		var tbl = $(this).DataTable();
		var selectedData = tbl.rows('.selected').data();
		if(!selectedData || selectedData.length == 0) return [];
		return selectedData.toArray();
	},
	confirmDelete: function(callback){
		var tbl = $(this).DataTable();
		if(tbl.rows('.selected').data().length == 0) return false;

        $.confirm({
            title: 'Thông báo!',
            type: 'orange',
            icon: 'fa fa-warning',
            content: 'Các dòng dữ liệu được chọn sẽ được xóa?',
            buttons: {
                ok: {
                    text: 'Chấp nhận',
                    btnClass: 'btn-warning',
                    keys: ['Enter'],
                    action: function(){
                    	tbl.rows('.selected.addnew').remove().draw(false);
                    	var delrow = tbl.rows('.selected').data().toArray();
                        if(callback && delrow.length > 0){
	                        callback(delrow);
                        }
                    }
                },
                cancel: {
                    text: 'Hủy bỏ',
                    btnClass: 'btn-default',
                    keys: ['ESC']
                }
            }
        });
	},
	realign: function () {
		var bodytbl = $(this);
		window.setTimeout(function () {
			var headtbl = $(bodytbl).closest('.dataTables_scroll').find('.dataTables_scrollHead .dataTables_scrollHeadInner table').first();
			var addw = (window.navigator.userAgent.indexOf('Firefox') > -1 ? 0 : 1);
			$(headtbl).css('width',  (parseFloat(window.getComputedStyle(bodytbl[0]).width) + addw) + "px");

			var _thbody = $(bodytbl).find('thead th');
			$.each($(headtbl).find('thead th'), function (k, v) {
				$(v).css('width', parseFloat(getComputedStyle(_thbody[$(v).index()]).width)+'px');
			});

			var element = $(bodytbl).parent()[0];
			if(element.scrollHeight - element.scrollTop !== element.clientHeight){
				$(bodytbl).closest('.dataTables_scroll').find('.dataTables_scrollHead .dataTables_scrollHeadInner').first().css("width", element.scrollWidth +'px');
			}
		}, 2);
	}
});

