/*global $, window*/
var cancelEditorType = ["button", "checkbox"];
$.fn.editableTableWidget = function (options) {
	alert(1);
	'use strict';
	return $(this).each(function () {
		var builCustomOptions = function () {
				if(!options){
					return {editor : $('#editor-input')};
				}

				var strID = $(options.editor).map(function(){
												return "#" + this.id;
											})
											.get()
											.join( ", " ) + ", #editor-input";

				options.editor = $(strID);
				var opts = $.extend({}, options);
				opts.editor = opts.editor.clone();
				return opts;
			},
			buildDefaultOptions = function () {
				var opts = $.extend({}, $.fn.editableTableWidget.defaultOptions);
				opts.editor = opts.editor.clone();
				return opts;
			},
			activeOptions = $.extend(buildDefaultOptions(), builCustomOptions()),
			ARROW_LEFT = 37, ARROW_UP = 38, ARROW_RIGHT = 39, ARROW_DOWN = 40, ENTER = 13, ESC = 27, TAB = 9, BACK_SPACE = 8, DELETE = 46,
			CTRL = 17, 
			element = $(this),
			editor = activeOptions.editor.css('position', 'absolute').hide().appendTo(element.parent()),
			active,
			showEditor = function (select, keyInput) {
				active = element.find('td.focus');
				if (active.length) {
					var isDateTime = false;
					if(element.find('th:eq('+active.index()+')').hasClass('data-type-datetime')){
						isDateTime = true;
						editor.datetimepicker({
							controlType: 'select',
							oneLine: true,
							dateFormat: 'yy-mm-dd',
							timeFormat: 'HH:mm:00',
							timeInput: true,
							onClose: function () {
								editor.hide();
								editor.trigger('blur');
								active.trigger('click');
							}
						});
					}else if(element.find('th:eq('+active.index()+')').hasClass('data-type-date')){
						isDateTime = true;
						editor.datepicker({
							controlType: 'select',
							oneLine: true,
							dateFormat: 'yy-mm-dd',
							timeInput: true,
							onClose: function () {
								editor.hide();
								editor.trigger('blur');
								active.trigger('click');
							}
						});
					}else{
						isDateTime = false;
						editor.datepicker("destroy");
					}

					editor.val((!isDateTime && keyInput) ? keyInput : (editor.is('select') ? active.find('input:first').val() : active.text()))
						.removeClass('error')
						.show()
						.offset(active.offset())
						.css(active.css(activeOptions.cloneProperties))
						.width(active.width())
						.height(active.height())
						.focus();
					if (select) {
						editor.select();
					}
				}
			},
			setActiveText = function () {
				var text = editor.val(),
					evt = $.Event('change'),
					originalContent;
				if (active.text() === text || editor.hasClass('error')) {
					return true;
				}
				originalContent = active.html();
				active.text(text).trigger(evt, text);
				if (evt.result === false) {
					active.html(originalContent);
				}
			},
			movement = function (element, keycode) {
				if (keycode === ARROW_RIGHT) {
					return element.next('td');
				} else if (keycode === ARROW_LEFT) {
					return element.prev('td');
				} else if (keycode === ARROW_UP) {
					return element.parent().prev().children().eq(element.index());
				} else if (keycode === ARROW_DOWN) {
					return element.parent().next().children().eq(element.index());
				}
				return [];
			};
		editor.blur(function () {
			setActiveText();
			var str = editor.is('select') ? '<input class="hidden-input" value="'+ editor.val() +'"/> ' + editor.find(':selected').text() : editor.val();
			if($(active).hasClass("wrap-text")){
				str = "<div class='wrap-text'>" + str + "</div>";
			}

			$(active).closest('table').DataTable().cell(active).data(str).draw(false);
			if(!editor.hasClass('hasDatepicker')){
				editor.hide();
			}
			
		}).keydown(function (e) {
			if (e.which === ENTER) {
				setActiveText();
				var str = editor.is('select') ? '<input class="hidden-input" value="'+ editor.val() +'"/>' + editor.find(':selected').text() : editor.val();
				if($(active).hasClass("wrap-text")){
					str = "<div class='wrap-text'>" + str + "</div>";
				}
				$(active).closest('table').DataTable().cell(active).data(str).draw(false);
				editor.hide();
				active.focus();
				e.preventDefault();
				e.stopPropagation();
			} else if (e.which === ESC) {
				editor.val(active.text());
				e.preventDefault();
				e.stopPropagation();
				editor.hide();
				active.focus();
			} else if (e.which === TAB) {
				setActiveText();
				var str1 = editor.is('select') ? '<input class="hidden-input" value="'+ editor.val() +'"/>' + editor.find(':selected').text() : editor.val();
				if($(active).hasClass("wrap-text")){
					str = "<div class='wrap-text'>" + str + "</div>";
				}

				$(active).closest('table').DataTable().cell(active).data(str1).draw(false);
				editor.hide();
				active.focus();
				e.preventDefault();
				e.stopPropagation();
			} else if (this.selectionEnd - this.selectionStart === this.value.length) {
				var possibleMove = movement(active, e.which);
				if (possibleMove.length > 0) {
					possibleMove.focus();
					e.preventDefault();
					e.stopPropagation();
				}
			}
		})
		.on('input paste keydown', function (e) {
			if(element.find('th[colspan=1]:eq('+active.index()+')').hasClass('data-type-numeric')){
				if(e.type == "keydown"){
					// Allow: backspace, delete, tab, escape, enter and .
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 188]) !== -1 ||
						((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
						(e.keyCode >= 35 && e.keyCode <= 40)) {
						return;
					}
					// Ensure that it is a number and stop the keypress
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
						return;
					}
				}else if(e.type == "paste"){
					var tempval = e.originalEvent.clipboardData.getData('Text').replace(',','');
					editor.val($.isNumeric(tempval) ? tempval : "");

					e.preventDefault();
					return;
				}
			}
			var evt = $.Event('validate');
			active.trigger(evt, editor.val());
			if (evt.result === false) {
				editor.addClass('error');
			} else {
				editor.removeClass('error');
			}
		});
		element.on('keypress dblclick', function(e){
			var tdActive = element.find('td.focus'),
				thCurrent = element.find('th[colspan=1]:eq('+tdActive.index()+')'),
				editorID = thCurrent.attr('class').match(/editor-(.*) (.*)/),
				editTag = '',
				keyInput = '';
alert(123);
			if(e.type == "keypress"){
				if(thCurrent.hasClass('editor-cancel')) return;


				if(e.originalEvent.charCode == 0){
					if(e.originalEvent.keyCode === BACK_SPACE){
						e.stopPropagation();
						e.preventDefault();
						element.DataTable().cell(tdActive).data('').draw(false);
					}else if(e.originalEvent.keyCode === DELETE){
						e.preventDefault();
						if(thCurrent.hasClass('editor-cancel')) return;
						element.DataTable().cell(tdActive).data('').draw(false);
						tdActive.focus();
						return;
					}else{
						return;
					}
				}else{
					if(e.ctrlKey){
						if(e.originalEvent.key == "c"){
							e.preventDefault();
							var el = document.createElement('textarea');
							el.value = element.DataTable().cell(tdActive).data();
							document.body.appendChild(el);
							el.select();
							document.execCommand('copy');
							document.body.removeChild(el);
						}
						return;
					}
					if(thCurrent.hasClass('data-type-numeric') && !$.isNumeric(e.originalEvent.key)){
						e.preventDefault();
						return;
					}
					keyInput = e.originalEvent.key;
				}
			}

			if(editorID != null && editorID[1]){
				var tgName = editorID[1].split(" ")[0];
				if($('#'+tgName).length == 0) return;
				editTag = tgName;
				keyInput = undefined;
			}

			var existsEditor = false;
			if(editTag != ''){
				$.each(activeOptions.editor, function (idx, item) {
					if($(item).attr('id') == editTag){
						editor = $(item);
						existsEditor = true;
						return;
					}
				});
			}

			if(!existsEditor){
				editor = $('#editor-input');
			}

			showEditor(false, keyInput);
		})
		.keydown(function (e) {
			var prevent = true;
			// // if (e.which === ENTER) {
			// // 	showEditor(false);
			// // } else if (e.which === 17 || e.which === 91 || e.which === 93) {
			// // 	showEditor(true);
			// // 	prevent = false;
			// // } else {
			// // 	prevent = false;
			// // }
			// if(e.which === BACK_SPACE || e.which === DELETE || e.which === TAB){
			// 	prevent = false;
			// }

			switch(e.which){
				case ESC:
					prevent = true;
					break;
				default:
					prevent = false;
			}

			if (prevent) {
				e.stopPropagation();
				e.preventDefault();
			}
		});

		element.find('td').prop('tabindex', 1);

		$(window).on('resize', function () {
			if (editor.is(':visible')) {
				editor.offset(active.offset())
				.width(active.width())
				.height(active.height());
			}
		});

		$.pasteCell(function(e){
			var tdActive = element.find('td.focus'),
				thCurrent = element.find('th:eq('+tdActive.index()+')'),
				editorID = thCurrent.attr('class').match(/editor-(.*) (.*)/),
				editTag = "editor-input";

			if(editorID != null && editorID[1]){
				if($('#'+editorID[1]).length == 0) return;
				editTag = editorID[1];
			}
			
			if(editTag == "editor-input"){
				if(thCurrent.hasClass('data-type-numeric') && !$.isNumeric(e)) return;
				if(thCurrent.hasClass('data-type-date')){
					if(!$.isDateValid(e)) return;
					e = e.trim().split(' ')[0];
				}

				if(thCurrent.hasClass('data-type-datetime')){
					if(!$.isDateValid(e)) return;
					e = e.trim().split(' ').length > 1 ? e.trim() : e.trim() + " 00:00:00";
				}

				if((thCurrent.hasClass('data-type-date') || thCurrent.hasClass('data-type-datetime')) && !$.isDateValid(e)) return;
				element.DataTable().cell(tdActive).data(e).draw(false);
				tdActive.focus();
			}
		});
	});

};
$.fn.editableTableWidget.defaultOptions = {
	cloneProperties: ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
					  'text-align', 'font', 'font-size', 'font-family', 'font-weight',
					  'border', 'border-top', 'border-bottom', 'border-left', 'border-right'],
	editor: $('<div>')
};

