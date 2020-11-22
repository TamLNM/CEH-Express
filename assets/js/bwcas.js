/**
 * Created by ad on 22/09/2018.
 */
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
            if(allowPaste == true) {     // conditionally set allowPaste to false in situations where you want to do regular paste instead
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

})(jQuery);