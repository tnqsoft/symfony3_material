/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 04/2017
 */

var B3Popup = function() {
    this.init();
};

B3Popup.prototype.confirmBox = function(yesCallback, showCallback, hiddenCallback) {
    var modalDelete = jQuery('#modalDelete');

    modalDelete
    .on('shown.bs.modal', function() {
        if (typeof showCallback === 'function') {
            showCallback();
        }
    })
    .on('hidden.bs.modal', function() {
        if (typeof hiddenCallback === 'function') {
            hiddenCallback();
        }
        modalDelete.remove();
    })
    .modal('show')
    .on('click', '.btn-confirm-delete', function() {
        if (typeof yesCallback === 'function') {
            yesCallback();
        }
        modalDelete.modal('hide');
    });
};

B3Popup.prototype.alertBox = function(type, msg, hiddenCallback) {
    var modalBox;
    if (type === 'info') {
        modalBox = jQuery('#modalAlertInfo');
    } else {
        modalBox = jQuery('#modalAlertError');
    }

    modalBox
    .on('shown.bs.modal', function() {
        jQuery('.alert-text', jQuery(this)).html(msg);
    })
    .on('hidden.bs.modal', function() {
        if (typeof hiddenCallback === 'function') {
            hiddenCallback();
        }
        modalBox.remove();
    })
    .modal('show')
    .on('click', '.btn-ok', function() {
        modalBox.modal('hide');
    });
};

B3Popup.prototype.init = function() {
    let html = '<div class="modal inmodal" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">';
    html += '    <div class="modal-dialog modal-small">';
    html += '        <div class="modal-content animated flipInY">';
    html += '            <div class="modal-header">';
    html += '                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Bỏ qua</span></button>';
    html += '                <h4 class="modal-title">Xác nhận xóa</h4>';
    html += '            </div>';
    html += '            <div class="modal-body">';
    html += '                <p class="text-center">';
    html += '                    <span class="fa-stack fa-2x">';
    html += '                        <i class="fa fa-circle fa-stack-2x text-aqua"></i>';
    html += '                        <i class="fa fa-question fa-stack-1x fa-inverse"></i>';
    html += '                    </span>';
    html += '                </p>';
    html += '                <p class="text-center text-red m-b-20"><strong>Bạn có muốn thực sự xóa không ?</strong></p>';
    html += '            </div>';
    html += '            <div class="modal-footer">';
    html += '                <div class="row">';
    html += '                    <div class="col-md-5">';
    html += '                        <button type="button" class="btn btn-white btn-block btn-flat" data-dismiss="modal">';
    html += '                            <i class="fa fa-times"></i>Bỏ qua';
    html += '                        </button>';
    html += '                    </div>';
    html += '                    <div class="col-md-5 col-md-offset-2">';
    html += '                        <button type="button" class="btn btn-danger btn-block btn-confirm-delete btn-flat">';
    html += '                            <i class="fa fa-check"></i>Đồng ý';
    html += '                        </button>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';

    if (jQuery('#modalDelete').length === 0) {
        jQuery('body').append(html);
    }

    html = '<div class="modal inmodal" id="modalAlertInfo" tabindex="-1" role="dialog" aria-hidden="true">';
    html += '    <div class="modal-dialog modal-sm">';
    html += '        <div class="modal-content animated flipInY">';
    html += '            <div class="modal-header">';
    html += '                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Bỏ qua</span></button>';
    html += '                <h4 class="modal-title">Thông báo</h4>';
    html += '            </div>';
    html += '            <div class="modal-body">';
    html += '                <p class="text-center">';
    html += '                    <i class="fa fa-info-circle fa-3x text-aqua"></i>';
    html += '                </p>';
    html += '                <p class="text-center text-aqua m-b-20 alert-text"></p>';
    html += '            </div>';
    html += '            <div class="modal-footer text-center">';
    html += '                <button type="button" class="btn btn-info btn-block btn-ok btn-flat">';
    html += '                    <i class="fa fa-check"></i>Đồng ý';
    html += '                </button>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';

    if (jQuery('#modalAlertInfo').length === 0) {
        jQuery('body').append(html);
    }

    html = '<div class="modal inmodal" id="modalAlertError" tabindex="-1" role="dialog" aria-hidden="true">';
    html += '    <div class="modal-dialog modal-sm">';
    html += '        <div class="modal-content animated flipInY">';
    html += '            <div class="modal-header">';
    html += '                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Bỏ qua</span></button>';
    html += '                <h4 class="modal-title">Thông báo</h4>';
    html += '            </div>';
    html += '            <div class="modal-body">';
    html += '                <p class="text-center">';
    html += '                    <i class="fa fa-times-circle fa-3x text-yellow"></i>';
    html += '                </p>';
    html += '                <p class="text-center text-yellow m-b-20 alert-text"></p>';
    html += '            </div>';
    html += '            <div class="modal-footer text-center">';
    html += '                <button type="button" class="btn btn-warning btn-block btn-ok btn-flat">';
    html += '                    <i class="fa fa-check"></i>Đồng ý';
    html += '                </button>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';

    if (jQuery('#modalAlertError').length === 0) {
        jQuery('body').append(html);
    }
};
