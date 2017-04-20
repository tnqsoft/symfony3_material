/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 04/2017
 */

// Extends Class UploadFile
var FileManageUpload= function(fileManagerBox, itemHtml){
    this.fileManagerBox = fileManagerBox;
    this.itemHtml = itemHtml;
    this.currentItem = null;
    let apiUpload = Routing.generate('api_file_upload', {
        type: this.fileManagerBox.data('type'),
        path: this.fileManagerBox.data('path')
    });
    let btnUpload = $('.btn-upload', this.fileManagerBox);
    UploadFile.apply(this, [apiUpload, btnUpload]);
};
FileManageUpload.prototype = Object.create(UploadFile.prototype);
FileManageUpload.prototype.constructor = FileManageUpload;
FileManageUpload.prototype.parent = UploadFile.prototype;

FileManageUpload.prototype.onUploadStart = function(_this, e) {
    _this.btnUpload.prop('disabled', true);
    let uuid = generateUUID();
    let item = $(_this.itemHtml);
    item.data('uuid', uuid);
    _this.currentItem = uuid;
    item.addClass('state-uploading');
    $('.list-file', _this.fileManagerBox).append(item);
};

FileManageUpload.prototype.onUploadChange = function(_this, e, data) {
    // console.log('Change');
};

FileManageUpload.prototype.onUploadProgress = function(_this, e, data) {
    let progress = parseInt(data.loaded / data.total * 100, 10);
    let currentItem = $('.file-item', _this.fileManagerBox).filter(function(){ return $(this).data("uuid") == _this.currentItem});
    $('.uploaded-percent', currentItem).html(progress);
};

FileManageUpload.prototype.onUploadDone = function(_this, e, data) {
    let file = data.jqXHR.responseJSON;
    let currentItem = $('.file-item', _this.fileManagerBox).filter(function(){ return $(this).data("uuid") == _this.currentItem});
    $('.file-item-display', currentItem).attr('src', file.url);
    $('.file-item-name', currentItem).html(file.name);
    currentItem.data('type', _this.fileManagerBox.data('type'));
    currentItem.data('path', _this.fileManagerBox.data('path'));
    currentItem.data('file', file.name);
    currentItem.data('context', JSON.stringify(file));
    currentItem.removeClass('state-uploading');
    _this.btnUpload.prop('disabled', false);
};

FileManageUpload.prototype.onUploadFail = function(_this, e, data) {
    let status = data.jqXHR.status
    let message = data.jqXHR.responseJSON.file;
    console.log(message);
};
