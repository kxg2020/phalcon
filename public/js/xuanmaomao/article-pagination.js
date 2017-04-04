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
                        '<td><img style="height: 30px;width: 30px" src="/public/images/xuanmaomao/article/'+ v.type+'.png"></td>'+
                '<td>'+ v.author+'</td>'+
            '<td>'+ v.date+'</td>'+
        '<td>'+
        '<input type="button" data-id="'+ v.id+'" class="btn edit  btn-primary" value="编辑">'+
        '&nbsp;'+'<a href="#myModal" data-toggle="modal" > '+
    '<input type="button" data-id="'+ v.id+'" class="btn  btn-danger delete" value="删除"></a>'+
        '</td>'+
        '</tr>');
                            });
                        }
                    });
                }
            }
        });
    });

    $('body').on('click','.delete',function(){

        id = $(this).attr('data-id');
        //>> 将id传递给modal
        $('.deleteTrue').attr('data-id',id);
    });
    $('body').on('click','.deleteTrue',function(){
        id = $(this).attr('data-id');
        url = location.protocol+'//'+window.location.host+'/backend/article/delete';
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':url,
            'data':{
                'id':id
            },
            success:function(result){

                if(result.status == 1){

                    location.reload();

                }else{

                    layer.msg('删除失败');
                }
            }
        });
    });
});