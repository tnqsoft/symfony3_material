/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 04/2017
 */

var CropFile = function(api, options) {
    this.api = api;
    this.onCropSuccess = $.noop;
    this.onCropError = $.noop;
    // {
    //     title: 'Cắt tỉa ảnh',
    //     imgDefault: 'http://example.com/no-picture.jpg',
    //     btnOkText: 'Cắt ảnh và hoàn tất',
    //     btnCancelText: 'Bỏ qua',
    //     aspectRatio: 1
    // }
    this.options = options;

    this.init();
};

CropFile.prototype.init = function() {
    if ($('#modalUploadCrop').length > 0) {
        return false;
    }

    var html = '<div class="modal inmodal" id="modalUploadCrop" tabindex="-1" role="dialog" aria-hidden="true">';
    html += '<div class="modal-dialog modal-small">';
    html += '    <div class="modal-content animated flipInY">';
    html += '        <div class="modal-header">';
    html += '            <h4 class="modal-title">' + this.options.title + '</h4>';
    html += '        </div>';
    html += '        <div class="modal-body center">';
    // html += '            <img src="' + this.options.imgDefault + '" id="cropImg" alt="Jcrop Image" width="570"/>';
    html += '        </div>';
    html += '        <div class="modal-footer">';
    html += '          <button type="button" class="btn btn-success btn-confirm-crop">';
    html += '              <i class="fa fa-check"></i>' + this.options.btnOkText;
    html += '          </button>';
    html += '          <button type="button" class="btn btn-warning btn-cancel-crop">';
    html += '              <i class="fa fa-check"></i>' + this.options.btnCancelText;
    html += '          </button>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '</div>';

    $('body').append(html);
};

CropFile.prototype.showCropModal = function(img, w, h) {
    var _this = this;

    jQuery('#modalUploadCrop')
        .on('shown.bs.modal', function(event) {
            let cropImg = jQuery('<img src="' + _this.options.imgDefault + '" id="cropImg" alt="Jcrop Image" width="570"/>');
            $('#modalUploadCrop .modal-body').empty().append(cropImg);
            cropImg.attr('src', img).load(function() {
                jQuery('#modalUploadCrop').data('src', img);
                $(this).Jcrop({
                    bgFade: true,
                    bgOpacity: .4,
                    setSelect: [10, 10, 210, 210],
                    aspectRatio: _this.options.aspectRatio,
                    allowSelect: false,
                    allowMove: true,
                    trueSize: [w, h],
                    onSelect: function(cropBox) {
                        var data = {
                            x1: cropBox.x,
                            y1: cropBox.y,
                            x2: cropBox.x2,
                            y2: cropBox.y2
                        };
                        jQuery('#modalUploadCrop').data('crop', JSON.stringify(data));
                    }
                });
            });
        })
        .on('click', '.btn-confirm-crop', function() {
            _this.crop();
        })
        .on('click', '.btn-cancel-crop', function() {
            let data = {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 0
            };
            jQuery('#modalUploadCrop').data('crop', JSON.stringify(data));
            _this.crop();
        })
        .modal({
            backdrop: 'static',
            keyboard: false
        })
        .modal('show');
}

CropFile.prototype.setOnCropSuccess = function(onCropSuccess) {
    this.onCropSuccess = onCropSuccess;
};

CropFile.prototype.setOnCropError = function(onCropError) {
    this.onCropError = onCropError;
};

CropFile.prototype.crop = function() {
    var _this = this;
    var param = JSON.parse(jQuery('#modalUploadCrop').data('crop'));
    param.file = jQuery('#modalUploadCrop').data('src');
    $.ajax({
        type: "POST",
        url: _this.api,
        data: param,
        dataType: "json",
        cache: false,
        success: function(response) {
            if (response !== null) {
                _this.onCropSuccess(_this, response);
            }
            jQuery('#modalUploadCrop').modal('hide');
        },
        error: function(e) {
            _this.onCropError(_this, e);
        }
    });
}
