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

    this.fileManagerBox.on('click', '.file-item', function() {
        let reverse = $(this).hasClass('active');
        $('.file-item', this.fileManagerBox).removeClass('active');
        $('.file-item-info', _this.fileManagerBox).hide();
        $('.btn-ok', _this.fileManagerBox).prop("disabled", true);
        if (reverse === false) {
          $(this).addClass('active');
          _this.showInfo($(this));
          $('.btn-ok', _this.fileManagerBox).prop('disabled', false);;
        }
    });

    this.fileManagerBox.on('click', '.file-item .btn-delete', function(e) {
        e.preventDefault();
        let item = $(this).closest('.file-item');
        let popup = new B3Popup();
        popup.confirmBox(function() {
            _this.deleteFile(item);
        });
    });
};

FileManage.prototype.loadList = function() {
    let _this = this;
    $('.list-file', this.fileManagerBox).empty();
    $('.file-item-info', this.fileManagerBox).hide();
    let listApi = Routing.generate('api_file_list', {
        type: this.type,
        path: this.path,
    });
    let api = new ApiCrud(listApi, '', '', '');
    api.getList({})
        .done(function(list) {
            _this.listFiles = list;
            _this.renderListFiles();
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
    $('.info-display', infoBox).attr('src', info.url);
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
    let api = new ApiCrud('', '', '', Routing.generate('api_file_delete', {
        type: item.data('type'),
        path: item.data('path'),
        file: item.data('file')
    }));
    api.doDelete(0)
        .done(function() {
            item.remove();
        })
        .fail(function(error) {
            console.log(error);
            let popup = new B3Popup();
            popup.alertBox('error', error.responseJSON.error);
        });
};

FileManage.prototype.renderListFiles = function(list) {
    if (this.listFiles.length > 0) {
        for (let i = 0; i < this.listFiles.length; i++) {
            let file = this.listFiles[i];
            let item = $(this.getItemPhotoHtml());
            $('.file-item-display', item).attr('src', file.url);
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
    // else {
    //     $('.list-file', this.fileManagerBox).append('<p class="text-center text-red">Thư mục chưa có ảnh. Bạn cần upload ảnh lên.</p>');
    // }
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
    html += '            <h4 class="modal-title">Quản lý thư viện ảnh</h4>';
    html += '        </div>';
    html += '        <div class="modal-body form-group-box">';
    html += '            <div class="row">';
    html += '               <div class="col-md-10"><div class="row list-file"></div></div>';
    html += '               <div class="col-md-2"><div class="file-item-info">';
    html += '                   <h5>Thông tin tệp tin</h5>';
    html += '                   <hr/>';
    html += '                   <p><img class="img-responsive info-display" src="\/bundles\/tnqsoftmaterial\/img\/no-picture.png" height="120"></p>';
    html += '                   <p class="info-name"><strong>Tên</strong>: <span></span></p>';
    html += '                   <p class="info-extension"><strong>Phần mở rộng</strong>: <span></span></p>';
    html += '                   <p class="info-mime"><strong>Mime</strong>: <span></span></p>';
    html += '                   <p class="info-size"><strong>Độ lớn</strong>: <span></span></p>';
    html += '                   <p class="info-width"><strong>Chiều dài</strong>: <span></span></p>';
    html += '                   <p class="info-height"><strong>Chiều rộng</strong>: <span></span></p>';
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
    html += '                        <i class="fa fa-cloud-upload"></i> Upload ảnh';
    html += '                    </button>';
    html += '                </div>';
    html += '                <div class="col-xs-6">';
    html += '                    <button type="button" class="btn btn-primary btn-ok">';
    html += '                        <i class="fa fa-check"></i> Chọn ảnh';
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
    html += '    <div class="box box-default box-solid">';
    html += '        <div class="box-body">';
    html += '            <img class="img-responsive center-block file-item-display" src="/bundles/tnqsoftmaterial/img/no-picture.png" alt="Photo">';
    html += '            <div class="text-center file-item-name"></div>';
    html += '        </div>';
    html += '        <div class="box-footer">';
    html += '            <div class="row">';
    html += '                <div class="col-md-6">';
    html += '                    <a href="#" class="btn-delete text-red">';
    html += '                        <i class="fa fa-trash"></i>';
    html += '                        Xóa</a>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '        <div class="overlay">';
    html += '          <i class="fa fa-refresh fa-spin"></i>';
    html += '          <p class="text-center">Đang tải lên...<span class="uploaded-percent">10</span>%</p>';
    html += '        </div>';
    html += '    </div>';
    html += '    <i class="fa fa-check-circle fa-2x text-green file-item-selected"></i>';
    html += '</div>';

    return html;
};
