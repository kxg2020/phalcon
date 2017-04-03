/**
 * Created by Administrator on 2017/4/3.
 */
$(function(){
    var url = location.protocol+'//'+window.location.host+'/backend/article/list';
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage,layer = layui.layer;
        laypage({
            cont: 'demo7'
            ,pages: $('input[name = pages]').val()
            ,jump: function(obj, first){
                if(!first){
                    $.ajax({
                        'type':'post',
                        'dataType':'json',
                        'url':url,
                        'data':{
                            'pgNum':obj.curr,
                            'pgSize':6,
                        },
                        success:function(result){
                            $('#tBody').html('');
                            $.each(result.data.list,function(k,v){
                                $('#tBody').append(' <tr>'+
                                    '<td>'+ v.id+'</td>'+
                                '<td>'+ v.title+'</td>'+
                        '<td>'+ v.type+'</td>'+
                '<td>'+ v.author+'</td>'+
            '<td>'+ v.date+'</td>'+
        '<td>'+
        '<input type="button" data-id="'+ v.id+'" class="btn  btn-primary" value="编辑">'+
        '&nbsp;'+
    '<input type="button" data-id="'+ v.id+'" class="btn  btn-danger" value="删除">'+
        '</td>'+
        '</tr>');
                            });
                        }
                    });
                }
            }
        });
    });
});