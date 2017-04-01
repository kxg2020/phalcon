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
            //layer.msg('正在上传');
        },
        onUploadSuccess: function (file, data) {
            data = $.parseJSON(data);
            if (data.status == 0) {
                layer.alert(data.msg, {time: 1000})
            } else {
                $('#image_box').html('');
                $('#image_box').append('<div class="col-lg-4" >'+
                '<div class="panel terques-chart">'+
                    '<div class="panel-body chart-texture" style="height: 295px;background-image: '+data.url+'">'+
                    '<div class="chart">'+
                    '<div class="heading"> <span>Friday</span> <strong>$ 48,00 | 13%</strong> </div>'+
                '<div class="sparkline" data-type="line" data-resize="true" data-height="90" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"><canvas width="422" height="90" style="display: inline-block; width: 422px; height: 90px; vertical-align: top;"></canvas></div>'+
                '</div>'+
                '</div>'+
                '<div class="chart-tittle"> <span class="title">New Earning</span> <span class="value-pie">'+
                '<a href="#" class="active">Market</a> | <a href="#">Referal</a> | <a href="#">Online</a> </span> </div>'+
                '</div>'+
                '</div>');
            }
        },
        onUploadError: function (file) {
            layer.alert('上传失败');
        }
    });

});