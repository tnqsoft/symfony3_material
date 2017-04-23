/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 04/2017
 */

var FileManage = function(type, path) {
    this.type = type;
    this.path = path;
    this.listFiles = [];
    this.fileManagerBox = null;
    this.okCallback = function(){};
    this.selectedItems = [];
    this.init();
    this.fileManageUpload = new FileManageUpload(this.fileManagerBox, this.getItemPhotoHtml());
};

FileManage.prototype.init = function() {
    this.renderMain();
    this.bindAction();
};

FileManage.prototype.bindAction = function() {
    let _this = this;

    this.fileManagerBox
        .on('shown.bs.modal', function() {
            _this.loadList();
        })
        .on('hidden.bs.modal', function() {})
        .on('click', '.btn-ok', function(){
            let selectedItem = $('.file-item.active', _this.fileManagerBox);
            let file = JSON.parse(selectedItem.data('context'));
            _this.okCallback(file);
            _this.fileManagerBox.modal('hide');
        });

    this.fileManagerBox.on('click', '.file-item', function(e) {
        e.stopPropagation();
        let reverse = $(this).hasClass('active');
        _this.clearSelectItem();
        $(this).addClass('active');
        _this.showInfo($(this));
        $('.btn-ok', _this.fileManagerBox).prop('disabled', false);
    }).on('dblclick', '.file-item', function(e) {
        e.stopPropagation();
        $('.btn-ok', _this.fileManagerBox).trigger('click');
    });

    this.fileManagerBox.on('click', '.list-file', function() {
        _this.clearSelectItem();
    });

    this.fileManagerBox.on('click', '.file-item .btn-delete', function(e) {
        e.stopPropagation();
        let item = $(this).closest('.file-item');
        let popup = new B3Popup();
        popup.confirmBox(function() {
            _this.deleteFile(item);
        });
    });

    this.fileManagerBox.on('click', '.file-item .btn-edit', function(e) {
        e.stopPropagation();
        let item = $(this).closest('.file-item');
        _this.cropFile(item);
    });
};

FileManage.prototype.cropFile = function(item) {
    var _parent = this;
    let info = JSON.parse(item.data('context'));
    let apiCrop = Routing.generate('api_file_crop', {
        type: item.data('type'),
        path: item.data('path')
        // file: item.data('file')
    });
    let cropFile = new CropFile(apiCrop);
    cropFile.setOnCropSuccess(function(_this, file){
        $('.file-item-display', item).attr('src', file.url + '?rnd=' + getUnixTimestamp());
        $('.file-item-name', item).html(file.name);
        item.data('file', file.name);
        item.data('context', JSON.stringify(file));
        _parent.showInfo(item);
    });
    cropFile.setOnCropError(function(_this, error){
        let popup = new B3Popup();
        popup.alertBox('error', error);
    });
    cropFile.showCropModal(info.url, info.width, info.height);
};


FileManage.prototype.clearSelectItem = function() {
    $('.file-item', this.fileManagerBox).removeClass('active');
    $('.file-item-info', this.fileManagerBox).hide();
    $('.btn-ok', this.fileManagerBox).prop("disabled", true);
};

FileManage.prototype.loadList = function() {
    let _this = this;
    $('.list-file', this.fileManagerBox).empty();
    $('.file-item-info', this.fileManagerBox).hide();
    $('.icon-loading', this.fileManagerBox).show();
    let listApi = Routing.generate('api_file_list', {
        type: this.type,
        path: this.path,
    });
    let api = new ApiCrud(listApi, '', '', '');
    api.getList({})
        .done(function(list) {
            _this.listFiles = list;
            _this.renderListFiles();
            $('.icon-loading', _this.fileManagerBox).hide();    
        })
        .fail(function(error) {
            let popup = new B3Popup();
            popup.alertBox('error', error.responseJSON.error);
        });
};

FileManage.prototype.showInfo = function(item) {
    let info = JSON.parse(item.data('context'));
    let infoBox = $('.file-item-info', this.fileManagerBox);
    let isReadable = '';
    let isWritable = '';
    if (info.is_readable) {
        isReadable = '<i class="fa fa-check text-success"></i>';
    } else {
        isReadable = '<i class="fa fa-times text-danger"></i>';
    }

    if (info.is_writable) {
        isWritable = '<i class="fa fa-check text-success"></i>';
    } else {
        isWritable = '<i class="fa fa-times text-danger"></i>';
    }
    if (info.is_image === true) {
        $('.info-display', infoBox).attr('src', info.url + '?rnd=' + getUnixTimestamp());
    } else {
        $('.info-display', infoBox).attr('src', '/bundles/tnqsoftmaterial/img/file.png');
    }

    $('.info-name span', infoBox).html(info.name);
    $('.info-extension span', infoBox).html(info.extension);
    $('.info-mime span', infoBox).html(info.mime);
    $('.info-size span', infoBox).html(formatFileSize(info.size));
    $('.info-width span', infoBox).html(info.width);
    $('.info-height span', infoBox).html(info.height);
    $('.info-isreadable span', infoBox).html(isReadable);
    $('.info-iswritable span', infoBox).html(isWritable);
    $('.info-modification span', infoBox).html(info.modification);
    infoBox.show();
};

FileManage.prototype.deleteFile = function(item) {
    let _this = this;
    let api = new ApiCrud('', '', '', Routing.generate('api_file_delete', {
        type: item.data('type'),
        path: item.data('path'),
        file: item.data('file')
    }));
    api.doDelete(0)
        .done(function() {
            item.remove();
            $('.file-item-info', _this.fileManagerBox).hide();
        })
        .fail(function(error) {
            let popup = new B3Popup();
            popup.alertBox('error', error.responseJSON.error);
        });
};

FileManage.prototype.renderListFiles = function(list) {
    if (this.listFiles.length > 0) {
        for (let i = 0; i < this.listFiles.length; i++) {
            let file = this.listFiles[i];
            let item = $(this.getItemPhotoHtml());
            if (file.is_image === true) {
                $('.file-item-display', item).attr('src', file.url + '?rnd=' + getUnixTimestamp());
            } else {
                $('.btn-edit', item).remove();
            }
            $('.file-item-name', item).html(file.name);
            item.data('type', this.type);
            item.data('path', this.path);
            item.data('file', file.name);
            item.data('context', JSON.stringify(file));
            $('.list-file', this.fileManagerBox).append(item);

            for(let j=0; j < this.selectedItems.length; j++) {
                if (file.name === this.selectedItems[j]) {
                    item.trigger('click');
                }
            }
        }
    }
}

FileManage.prototype.showBox = function() {
    this.fileManagerBox.modal('show');
};

FileManage.prototype.renderMain = function() {
    let html = '';
    html += '<div class="modal inmodal" id="modalFileManager" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">';
    html += '<div class="modal-dialog">';
    html += '    <div class="modal-content animated flipInY">';
    html += '        <div class="modal-header">';
    html += '            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Bỏ qua</span></button>';
    html += '            <h4 class="modal-title">Quản lý file <i class="fa fa-circle-o-notch fa-spin fa-fw icon-loading"></i></h4>';
    html += '        </div>';
    html += '        <div class="modal-body form-group-box">';
    html += '            <div class="row">';
    html += '               <div class="col-md-10"><div class="row list-file"></div></div>';
    html += '               <div class="col-md-2"><div class="file-item-info">';
    html += '                   <p><img class="img-responsive1 info-display" src="\/bundles\/tnqsoftmaterial\/img\/file.png"></p>';
    html += '                   <p class="info-name"><strong>Tên</strong>: <span></span></p>';
    html += '                   <p class="info-extension"><strong>Phần mở rộng</strong>: <span></span></p>';
    html += '                   <p class="info-mime"><strong>Mime</strong>: <span></span></p>';
    html += '                   <p class="info-size"><strong>Độ lớn</strong>: <span></span></p>';
    html += '                   <p class="info-width"><strong>Chiều dài</strong>: <span></span>px</p>';
    html += '                   <p class="info-height"><strong>Chiều cao</strong>: <span></span>px</p>';
    html += '                   <p class="info-isreadable"><strong>Được phép đọc</strong>: <span></span></p>';
    html += '                   <p class="info-iswritable"><strong>Được phép ghi</strong>: <span></span></p>';
    html += '                   <p class="info-modification"><strong>Ngày cập nhật</strong>: <span></span></p>';
    html += '               </div></div>';
    html += '            </div>';
    html += '        </div>';
    html += '        <div class="modal-footer">';
    html += '            <div class="row">';
    html += '                <div class="col-xs-6 text-left">';
    html += '                    <button type="button" class="btn btn-success btn-upload">';
    html += '                        <i class="fa fa-cloud-upload"></i> Upload file';
    html += '                    </button> <span class="text-muted"> <i class="fa fa-mouse-pointer"></i> Hoặc là kéo thả nhiều file vào danh sách file</span>';
    html += '                </div>';
    html += '                <div class="col-xs-6">';
    html += '                    <button type="button" class="btn btn-primary btn-ok">';
    html += '                        <i class="fa fa-check"></i> Chọn file';
    html += '                    </button>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '</div>';
    if (jQuery('#modalFileManager').length === 0) {
        jQuery('body').append(html);
        this.fileManagerBox = $('#modalFileManager');
        this.fileManagerBox.data('type', this.type);
        this.fileManagerBox.data('path', this.path);
        $('.btn-ok', this.fileManagerBox).prop("disabled", true);
    }
};

FileManage.prototype.getItemPhotoHtml = function() {
    let html = '';
    html += '<div class="col-xs-6 col-sm-3 col-md-4 col-lg-2 file-item">';
    html += '    <div class="thumbnail">';
    html += '        <img class="img-responsive center-block file-item-display" src="/bundles/tnqsoftmaterial/img/file.png" alt="Photo">';
    html += '        <div class="caption text-center">';
    html += '            <span class="file-item-name">Đang upload file...</span>';
    html += '            <a href="#" class="btn-delete"><i class="fa fa-trash fa-lg"></i></a>';
    html += '            <a href="#" class="btn-edit"><i class="fa fa-scissors fa-lg"></i></a>';
    html += '        </div>';
    html += '        <div class="progress">';
    html += '            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">';
    html += '                <span class="sr-only">40% Complete (success)</span>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '    <i class="fa fa-check-circle fa-2x text-green file-item-selected"></i>';
    html += '</div>';

    return html;
};
