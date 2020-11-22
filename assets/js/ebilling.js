/**
 * Created by levuh on 18/05/2018.
 */
/**
 * Created by ad on 11/30/2017.
 */
var datacall="";
var _arrContentBtnLoading = {};

Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};
function number_fm(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "").replace(/\.00$/, '');
  } catch (e) {
    console.log(e)
  }
};

Array.prototype.getIndexs = function (cols) {
    var result = [];
    if(Array.isArray(this)){
        if(Array.isArray(cols)){
            this.forEach(function (item, idx) {
                if(cols.indexOf(item) > -1){
                    result.push(idx);
                }
            });
            return result;
        }else{
            this.forEach(function (item, idx) {
                if(item == cols){
                    return result.push(idx);
                }
            });
        }
    }
    return result;
};
var resizefunc = [];
$.fn.blockUI = function() {
    this.block({ 
        message: '<i class="la la-spinner spinner"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait',
            'box-shadow': '0 0 0 1px #ddd'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
    return this;
};
 
function getDateTime(fullDateTime) {
    if(fullDateTime) {
        var ua = window.navigator.userAgent;
        var td = '';
        var msie = ua.indexOf("MSIE");
        var tdie = ua.indexOf("Trident");
        var safari = ua.indexOf("Safari");

        if (msie > 0 || tdie > 0 || safari > 0)
        {
            var year = fullDateTime.substr(0, 4);
            var month = parseInt(fullDateTime.substr(5, 2))-1;
            var day = fullDateTime.substr(8, 2);
            var h = fullDateTime.substr(11, 2);
            var i = fullDateTime.substr(14, 2);
            var s = fullDateTime.substr(17, 2);
            var now = new Date(year, month, day, h, i, s);
        }
        else
        {
            var now = new Date(fullDateTime);
        }
        if(now.toString().indexOf('Invalid') != -1){
            return fullDateTime;
        }

        var year    = now.getFullYear();
        var month   = now.getMonth()+1;
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds();

        if(month.toString().length == 1) {
            var month = '0'+month;
        }
        if(day.toString().length == 1) {
            var day = '0'+day;
        }
        if(hour.toString().length == 1) {
            var hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
            var minute = '0'+minute;
        }
        if(second.toString().length == 1) {
            var second = '0'+second;
        }

        var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;
    } else {
        var dateTime = '';
    }

    return dateTime;
}

function dateformat(timestamp) {
    var date = new Date(timestamp*1000);
    var year = date.getFullYear();
    var month = ("0"+(date.getMonth()+1)).substr(-2);
    var day = ("0"+date.getDate()).substr(-2);
    var hour = ("0"+date.getHours()).substr(-2);
    var minutes = ("0"+date.getMinutes()).substr(-2);
    var seconds = ("0"+date.getSeconds()).substr(-2);

    return day+"/"+month+"/"+year+" "+hour+":"+minutes+":"+seconds;
}
function getMonth(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getMonth() + 1;
}
function getYear(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getFullYear();
}
function getDay(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getDate();
}
function daysInMonth (month, year) {
    return new Date(year, month, 0).getDate();
}

function fromDatetoDate(month, year){
    var result = [];
    result.push("01"+"/"+ (month.length>1?month:"0"+month)+"/"+year);
    result.push(daysInMonth(month, year)+"/"+ (month.length>1?month:"0"+month)+"/"+year);
    return result;
}

function changeDateFormat(formatstring, value){
    if(!value) return "";
    var finddate = value.split(/[ ]+|T/);
    var time = finddate[0].indexOf(":") == -1 ? finddate[1] : finddate[0];

    formatstring = formatstring.toLowerCase();
    var year_start = formatstring.indexOf("y");
    var year_length = (formatstring.match(/y/g)).length;

    var month_start = formatstring.indexOf("m");
    var month_length = (formatstring.match(/m/g)).length;

    var day_start = formatstring.indexOf("d");
    var day_length = (formatstring.match(/d/g)).length;

    var y = value.substring(year_start, year_start + year_length);
    var m = value.substring(month_start, month_start + month_length);
    var d = value.substring(day_start, day_start + day_length);

    return (y.length == 2 ? ("20"+y) : y) + "-" + (m.length == 1 ? "0"+m : m) + "-" + (d.length == 1 ? "0"+d : d) + " " + time;
}

function adjustheader(headtbl, bodytbl, hasrow){
    window.setTimeout(function () {
        var addw = (window.navigator.userAgent.indexOf('Firefox') > -1 ? 0 : 1);
        $(headtbl).css('width',  (parseFloat(window.getComputedStyle(bodytbl).width) + addw) + "px");
        if(hasrow){
            var _thbody = $(bodytbl).find('thead tr th');
            $.each($(headtbl).find('thead tr th'), function (k, v) {
                $(v).css('width', parseFloat(getComputedStyle(_thbody[$(v).index()]).width)+'px');
            });
        }
        var element = document.getElementsByClassName("dataTables_scrollBody")[0];
        if(element.scrollHeight - element.scrollTop !== element.clientHeight){
            $('.dataTables_scrollHeadInner').css("width", element.scrollWidth +'px');
        }
    }, 2);
}

function setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toUTCString());
}

function setCookietoEndofDay(c_name, value) {
    var now = new Date();
    var expire = new Date();
    expire.setFullYear(now.getFullYear());
    expire.setMonth(now.getMonth());
    expire.setDate(now.getDate()+1);
    expire.setHours(0);
    expire.setMinutes(0);
    expire.setSeconds(0);

    document.cookie = c_name + "=" + escape(value) + ((expire == null) ? "" : ";expires=" + expire.toUTCString());
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        var c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            var c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function deleteCookie(c_name){
    document.cookie = c_name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

$.fn.extend({
    has_required: function () {
        var checkError = [];
        var datas = $(this);

        if($(this).parent().is('td') || $(this).is('select')){
            $(this).parent().removeClass('error');
        }else{
            $(this).removeClass('error');
        }
        $.each(datas, function(key, data) {
            if($(data).is('input') || $(data).is('select') || $(data).is('textarea')){
                if(!data.value || data.value == '0') {
                    if($(data).parent().is('td') || $(data).is('select')){
                        $(data).parent().addClass('error');
                    }else{
                        $(data).addClass('error');
                    }
                    checkError.push('error');
                }
            }
        });
        return checkError.length > 0;
    },
    clear_error: function () {
        $(this).removeClass('error');
    },
    check_cont_iso: function () {
        var con = $(this).val();
        if (!con || con == "" || con.length != 11) { return false; }
        con = con.toUpperCase();
        var re = /^[A-Z]{4}\d{7}/;
        if (re.test(con)) {
            var sum = 0;
            for (i = 0; i < 10; i++) {
                var n = con.substr(i, 1);
                if (i < 4) {
                    n = "0123456789A?BCDEFGHIJK?LMNOPQRSTU?VWXYZ".indexOf(con.substr(i, 1));
                }
                n *= Math.pow(2, i);
                sum += n;
            }
            if (con.substr(0, 4) == "HLCU") {
                sum -= 2;
            }
            sum %= 11;
            sum %= 10;
            return sum == con.substr(10);
        } else {
            return false;
        }
    },
    autocompleteText: function (arr, callback_success, callback_error) {
        $(this).autocomplete({
            source: arr,
            minLength: 1,
            create: function( event, ui ) {
                $(document).find('.ui-helper-hidden-accessible').remove();
            }
        });
        if($(this).parent().is('td')){
            $(this).on('change', function () {
                if(arr.indexOf($(this).val()) == "-1" && arr.indexOf($(this).val().toUpperCase()) == "-1"){
                    $(this).val('');
                    $(this).parent().addClass('error');
                    $('.toast').remove();
                    var idx = $(this).parent().closest('tr').children().index($(this).parent());
                    var colheadertext = $(this).parent().closest('table').find('thead tr td:eq('+ idx +')').first().text();
                    toastr['error'](colheadertext + ' không phù hợp!');
                    if(callback_error){
                        callback_error($(this));
                    }
                }else{
                    if(callback_success){
                        callback_success($(this));
                    }
                    $(this).parent().removeClass('error');
                }
            });
        }
    }
});





(function($) {
    var origAppend = $.fn.prepend;
    $.fn.prepend = function () {
        return origAppend.apply(this, arguments).trigger("prepend");
    };
})(jQuery);

(function($) {
    var origAppend = $.fn.toggleClass;
    $.fn.toggleClass = function () {
        return origAppend.apply(this, arguments).trigger("toggleClass");
    };

    $.fn.button = function (action) {
        var appendElem = $(this).attr('data-loading-text');
        var id = $(this).attr('id');

        switch(action){
            case "loading":
                $(this).prop('disabled', true);
                var content = $(this).html();
                _arrContentBtnLoading[id] = content;
                $(this).html('').append(appendElem);
                break;
            case "reset":
                $(this).prop('disabled', false);
                $(this).html('').append(_arrContentBtnLoading[id]);
                delete _arrContentBtnLoading[id];
                break;
        }
        return $(this);
    };
})(jQuery);











function get_screen_height(){
            $("body").append("<div class=tmpgetwh style='position:fixed;top:0px;left:0px;width:100%;height:100%'></div>");
            var sh=$(".tmpgetwh").outerHeight();
            $(".tmpgetwh").remove();
            return sh;
}
function make_ftable(data){
            $("#find-modal.modal").show();
            $("#find-modal .modal-dialog.modal-dialog-mw").width();
            setTimeout(function(){$("#find-modal.modal").addClass("show");},100);
            var html="<table id=find_table  class=\"table table-striped display nowrap\" cellspacing=\"0\" style=\"width: 99.8%\"><thead><tr>";
            html+="<th col-name=\"STT\">STT</th>";
            
            if(typeof data.col_list_name == "undefined")
                data.col_list_name=data.col_list;

            for (var i = 0; i < data.col_list.length; i++) {
                var colname=data.col_list_name[i];
                html+="<th col-name=\""+data.col_list[i]+"\">"+colname+"</th>";
            }
            html+="</tr></thead><tbody>";
            data.data.forEach(function(entry) {
                        html+="<tr class=trselect idx='"+entry[1]+"'>";
                        for (var i = 0; i < entry.length; i++) {
                            html+="<td>"+entry[i]+"</td>";
                        }
                        html+="</tr>";
                    });
            html+="</tbody></table>";
            $("#moda-content").html(html);
            $("#find_table").DataTable({
                scrollY: '30vh',
                columnDefs: [
                { type: "num", className: "text-center", targets: 0 }
                ],
                order: [[ 0, 'asc' ]],
                paging: false,
                keys:true,
                autoFill: {
                    focus: 'focus'
                },
                select: false,
                rowReorder: false
            });
           
                var width=$("#find_table").outerWidth()+40;
            var left=(screen.width-width)/2;
            var top=(get_screen_height()-$("#find-modal .modal-dialog.modal-dialog-mw").outerHeight())/2;
            $("#find-modal .modal-dialog.modal-dialog-mw").css({"margin-top":top+"px","margin-left":left+"px","max-width":width+"px"});
            $("#find_table").DataTable().draw();
           
            

}











//ready
$(function() {

$.extend( true, $.fn.dataTable.defaults, {
        language: {
            info: "Số dòng: _TOTAL_",
            emptyTable: "------------ Không có dữ liệu hiển thị ------------",
            infoFiltered: "(trên _MAX_ dòng)",
            infoEmpty: "Số dòng: 0",
            search: '<span>Tìm:</span> _INPUT_',
            zeroRecords:    "------------ Không có dữ liệu được tìm thấy ------------",
            sThousands: ",",
            sDecimal: ".",
            // autoFill: {
            //     // fillHorizontal: 'Đổ dữ liệu theo dòng',
            //     // fillVertical: 'Đổ dữ liệu theo cột',
            //     // fill: b[0][0].label,
            //     // increment: 'Thay đổi tất cả các ô theo giá trị: <input type="number" value="1">',
            //     // cancel: 'Hủy bỏ',
            //     // button:'Go!'
            // },
            select: {
                rows: {
                    _: "Đã chọn %d dòng",
                    0: ""
                }
            }
        },
        search: {
            regex: true
        },
        info: true,
        orderClasses: false,
        paging: false,
        scrollY: 419,
        scrollX: true,
        lengthChange: false,
        scrollCollapse: false,
        deferRender: true,
        processing: true,
        autoWidth: true,
        dom: '<"datatable-header"fl<"datatable-info-right"Bip>><"datatable-scroll-wrap"t>',
        buttons: [
            {extend: 'selectAll', text: 'Chọn tất cả', className: 'btn btn-xs btn-default'},
            {extend: 'selectNone', text: 'Bỏ chọn', className: 'btn btn-xs btn-default'}
        ],
        destroy: true
    });



$('#sidebar-collapse').slimScroll({height:"100%",railOpacity:"0.9"});
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "swing",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('a.nav-link.sidebar-toggler.js-sidebar-toggler').on('click', function () {
            setTimeout(function () {
                $('.dataTable tbody').closest('table').each(function (k, v) {
                    $(v).realign();
                });
            }, 250);
        });

        //remove class error when change value
        $(document).on('input', '.error input', function () {
            $(this).parent().removeClass('error');
        });

        $('[data-action="reloadUI"]').on('click', function (e) {
            var block = $(this).attr('data-reload-target');
            $(block).block({ 
                message: '<i class="la la-spinner spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait',
                    'box-shadow': '0 0 0 1px #ddd'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });

if($("a[href='"+window.location.href+"']").length>0){
    $("a[href='"+window.location.href+"']").first().addClass("active");
    $("a[href='"+window.location.href+"']").first().closest("ul").addClass("in");
    $("a[href='"+window.location.href+"']").first().closest("ul").closest("li").addClass("active");
}

    $('.collapsible-box i.la').on('click', function () {
        $(this).parent().find('.ibox-body').toggle(700);
        if($(this).hasClass('la-angle-double-down')){
            $(this).removeClass('la-angle-double-down')
                .addClass('la-angle-double-up');
        }else{
            $(this).removeClass('la-angle-double-up')
                .addClass('la-angle-double-down');
        }

    });
    $('table.dataTable tr').on('click', function () {
        $('.m-row-selected').removeClass('m-row-selected');
        $(this).addClass('m-row-selected');
    });






    if($(".mobile_tbl").length>0 && $(window).width()<=768){
        var css="";
        $(".mobile_tbl").each(function(i){
            var tblid="#"+$(this).attr("id");        
            $(this).find("th").each(function(){
                var inx=$(this).index()+1;
                css+=tblid+" tbody tr td:nth-child("+inx+"):before{content:\""+$(this).text()+" : \";color:#795548;}";
            });
            $("head").append("<style>@media only screen and (max-width: 768px){"+css+"}</style>");
        });
    }




$(document).on("click",".input-group-addon.bg-white.btn.text-warning,.find_i_ajax",function(e){
    datacall=$(this).closest(".input-group").find("input");
    var tablek=$(this).closest(".input-group").find("span").attr("dtable");
    var title=$(this).closest(".input-group").find("input").attr("placeholder");
    //alert(tablek);
    $("#search-ship-name").val("");
    $("#groups-modalLabel").attr("xtable",tablek);
    $("#groups-modalLabel").html("Chọn "+title);
    
    var gvar="undefined";
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


        $(document).on("dblclick","#find_table tbody tr",function(e){
            $("#select-ship").trigger("click");
        });
        $(document).on("click","#reload-ship",function(e){
            $("#search-ship-name").trigger("input");
        });

var tuC;
        if($("#search-ship-name").length>0)
            $(document).on("input","#search-ship-name",function(e){
                clearTimeout(tuC);
                $("#find_table").waitingLoad();
                tuC=setTimeout(function(){
                    var dt={"key":$("#search-ship-name").val(),"table":$("#groups-modalLabel").attr("xtable"),"page":"1"};
                    $.ajax({
                        url: AJAX_URL,
                        dataType: 'json',
                        data: dt,
                        type: 'POST',
                        success: function (data) {
                            $('.ibox.collapsible-box').unblock();
                            $("#find_table").DataTable().clear().draw();
                            make_ftable(data);
                        },
                        error: function(err){
                            toastr["error"]("Tải dữ liệu thất bại !!");
                            $('.ibox.collapsible-box').unblock();
                            $("#find_table").DataTable().clear().draw();
                            console.log(err);
                        }
                    });
                },1000);
                
            });

$(document).on("click",".btn[data-dismiss='modal']",function(e){
             $("#find-modal.modal").removeClass("show");
            setTimeout(function(){$("#find-modal.modal").hide();},500);
        });
$(document).on("click",".trselect",function(e){
            $(".trselected").removeClass("trselected");
            $(this).addClass("trselected");
        });


});