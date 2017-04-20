/**
 * Created by nntuan on 9/11/2016.
 */

function replaceAll(subject, str1, str2) {
    var re = new RegExp(str1, "gi");
    return subject.replace(re, str2);
}

function trimStr(str) {
    return str.replace(/^\s+|\s+$/g, "");
}

function slugify(str) {
    tmp = trimStr(str);
    tmp = replaceAll(tmp, ' ', '-');
    tmp = replaceAll(tmp, '_', '-');
    tmp = tmp.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/gi, 'a');
    tmp = tmp.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/gi, 'e');
    tmp = tmp.replace(/(ì|í|ị|ỉ|ĩ)/gi, 'i');
    tmp = tmp.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/gi, 'o');
    tmp = tmp.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/gi, 'u');
    tmp = tmp.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/gi, 'y');
    tmp = tmp.replace(/(đ)/gi, 'd');
    tmp = tmp.replace(/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/gi, 'A');
    tmp = tmp.replace(/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/gi, 'E');
    tmp = tmp.replace(/(Ì|Í|Ị|Ỉ|Ĩ)/gi, 'I');
    tmp = tmp.replace(/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/gi, 'O');
    tmp = tmp.replace(/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/gi, 'U');
    tmp = tmp.replace(/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/gi, 'Y');
    tmp = tmp.replace(/(Đ)/gi, 'D');
    tmp = tmp.replace(/(%|\!|`|\.|'|"|&|@|\^|=|\+|\:|,|{|}|\?|\\|\/|quot;)/gi, '');
    tmp = tmp.toLowerCase();
    return tmp;
}

function generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
    return uuid;
};

function formatFileSize(size) {
    var sizes = [' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB'];
    for (var i = 1; i < sizes.length; i++) {
        if (size < Math.pow(1024, i)) return (Math.round((size/Math.pow(1024, i-1))*100)/100) + sizes[i-1];
    }
    return size;
}

function getUnixTimestamp() {
    return moment().format('x');
}

$.fn.enterKey = function(fnc) {
    return this.each(function() {
        $(this).keypress(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                ev.preventDefault();
                fnc.call(this, ev);
            }
        });
    });
};
