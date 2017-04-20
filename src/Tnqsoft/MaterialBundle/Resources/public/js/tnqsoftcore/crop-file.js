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
    this.cropImgApi = null;

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
    html += '            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Bỏ qua</span></button>';
    html += '            <h4 class="modal-title">' + this.options.title + '</h4>';
    html += '        </div>';
    html += '        <div class="modal-body center">';
    // html += '            <img src="' + this.options.imgDefault + '" id="cropImg" alt="Jcrop Image" width="570"/>';
    html += '        </div>';
    html += '        <div class="modal-footer">';
    html += '           <div class="row">';
    html += '               <div class="col-xs-6 text-left">';
    html += '                   Tỷ lệ: <select class="txt-ratio">';
    html += '                       <option value="free">Tự do</option>';
    html += '                       <option value="square">Vuông</option>';
    html += '                       <option value="tv">Chữ nhật</option>';
    html += '                       <option value="wide">Rộng</option>';
    html += '                       <option value="cinema">Cực rộng</option>';
    html += '                   </select>';
    html += '               </div>';
    html += '               <div class="col-xs-6">';
    html += '                   <button type="button" class="btn btn-success btn-confirm-crop">';
    html += '                       <i class="fa fa-check"></i>' + this.options.btnOkText;
    html += '                   </button>';
    html += '               </div>';
    html += '           </div>';
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
            cropImg.attr('src', img + '?rnd=' + getUnixTimestamp()).load(function() {
                jQuery('#modalUploadCrop').data('src', img);
                _this.cropImgApi = $.Jcrop('#cropImg', {
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
        .on('hidden.bs.modal', function(event) {
            $(this).remove();
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
        .on('change', '.txt-ratio', function(){
            _this.changeRatio($(this).val());
        })
        .modal({
            backdrop: 'static',
            keyboard: false
        })
        .modal('show');
}

CropFile.prototype.changeRatio = function(ratioType) {
    let ratio = null;
    switch(ratioType) {
      case 'square':
        ratio = 1;
        break;
      case 'tv':
        ratio = 4/3;
        break;
      case 'wide':
        ratio = 16/9;
        break;
      case 'cinema':
        ratio = 21/9;
        break;
      default:
        ratio = null;
        break;
    }
    console.log(this.cropImgApi);
    this.cropImgApi.setOptions({
      aspectRatio: ratio
    });
};

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
        type: "PUT",
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
