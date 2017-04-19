/*
 *   @author: Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *   @created: 03/2017
 */

// Class ApiCrud
var ApiCrud = function(urlList, urlAdd, urlEdit, urlDelete) {
    this.urlList = urlList;
    this.urlAdd = urlAdd;
    this.urlEdit = urlEdit;
    this.urlDelete = urlDelete;
    this.debug = false;
};

ApiCrud.prototype.getList = function(data) {
    var _this = this;
    return jQuery.ajax({
        type: "GET",
        url: _this.urlList,
        data: data,
        dataType: "json",
        cache: false
    });
};

ApiCrud.prototype.doAdd = function(data) {
    var _this = this;
    return jQuery.ajax({
        type: "POST",
        url: _this.urlAdd,
        data: data,
        dataType: "json",
        cache: false
    });
};

ApiCrud.prototype.doEdit = function(id, data) {
    var _this = this;
    return jQuery.ajax({
        type: "PUT",
        url: _this.urlEdit.replace('/0', '/'+ id),
        data: data,
        dataType: "json",
        cache: false
    });
};

ApiCrud.prototype.doDelete = function(id) {
    var _this = this;
    return jQuery.ajax({
        type: "DELETE",
        url: _this.urlDelete.replace('/0', '/'+ id),
        data: {},
        dataType: "json",
        cache: false
    });
};
