/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 04/2017
 */

var UploadFile = function(api, btnUpload) {
    if (this.constructor === UploadFile) {
        throw new Error("Can't instantiate abstract class!");
    }
    this.api = api;
    this.btnUpload = btnUpload;
    this.fileUploadId = 'fileupload';

    this.init();
    this.bindAction();
};

UploadFile.prototype.onUploadStart = function(_this, e) {
    throw new Error("Abstract method!");
};

UploadFile.prototype.onUploadChange = function(_this, e, data) {
    throw new Error("Abstract method!");
};

UploadFile.prototype.onUploadProgress = function(_this, e, data) {
    throw new Error("Abstract method!");
};

UploadFile.prototype.onUploadDone = function(_this, e, data) {
    throw new Error("Abstract method!");
};

UploadFile.prototype.onUploadFail = function(_this, e, data) {
    throw new Error("Abstract method!");
};

UploadFile.prototype.init = function() {
    html = '<input id="' + this.fileUploadId + '" type="file" name="file" class="hidden">';
    $('body').append(html);
};

UploadFile.prototype.bindAction = function() {
    var _this = this;

    $('#' + this.fileUploadId).fileupload({
        dataType: 'json',
        autoUpload: true,
        url: _this.api,
        type: 'POST',
        change: function(e, data) {
            _this.onUploadChange(_this, e, data);
        },
        start: function(e) {
            _this.onUploadStart(_this, e);
        },
        progress: function(e, data) {
            _this.onUploadProgress(_this, e, data);
        },
        done: function(e, data) {
            _this.onUploadDone(_this, e, data);
        },
        fail: function(e, data) {
            _this.onUploadFail(_this, e, data);
        }
    });

    this.btnUpload.click(function(e) {
        e.preventDefault();
        $('#' + _this.fileUploadId).trigger('click');
    });
};
