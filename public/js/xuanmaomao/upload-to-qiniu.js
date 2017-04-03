/**
 * Created by Administrator on 2017/4/1.
 */
$(function(){
    var url = location.protocol+'//'+window.location.host+'/backend/image/upload';
    $("#file_upload").h5upload({
        url: url,
        fileObjName: 'image',
        fileTypeExts: 'jpg,png,gif,bmp,jpeg',
        multi: true,
        accept: '*/*',
        fileSizeLimit: 1024 * 1024 * 1024 * 1024,
        formData: {
            type: 'card_positive'
        },
        onUploadProgress: function (file, uploaded, total) {
            layer.msg('正在上传');
        },
        onUploadSuccess: function (file, data) {
            data = $.parseJSON(data);
            if (data.status == 0) {
                layer.msg(data.msg, {time: 1000})
            } else {
                $('#image_box').append('<a class="example-image-link" href="#"'+ 'data-lightbox="example-set" title="Click on the right side of the image to move'+ 'forward."> <img class="example-image" src="'+data.url+'" alt="Plants: image 1 0f 4 thumb"'+ 'width="150" height="150"></a>'
                );
            }
        },
        onUploadError: function (file) {
            layer.alert('上传失败');
        }
    });
});