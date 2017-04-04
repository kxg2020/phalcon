/**
 * Created by Administrator on 2017/4/2.
 */
$(function(){
    var url = location.protocol+'//'+window.location.host+'/backend/image/list';
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
                                        $('#tBody').append('<tr>'+
                                            '<td style="vertical-align:'+ 'middle">'+ v.id+'</td>'+
                                        '<td style="vertical-align: middle">' +
                                            '<img src="'+ v.image_url+'"></td>'+ '<td style="vertical-align: middle">'+
                                            '<img src="/public/images/xuanmaomao/'+ v.type+'.png" style="height: 30px;width: 30px"></td>'+
                            '<td  style="vertical-align: middle"><strong>'+ v.date+'</strong> &nbsp;</td>'+
                    '<td class="hidden-xs" style="vertical-align: middle">'+ '<input type="text" value="'+ v.sort+'" class="form-control parsley-validated" name="sort"'+ 'style="width: 30px;"> </td>'+
                    '<td style="vertical-align: middle" >'+ '<li class="'+ v.icon+' change" style="cursor: pointer" data-id="'+ v.id+'" ></li>' +
                        '</td>'+
                '<td class="hidden-xs" style="vertical-align: middle"><button class="btn btn-sm btn-primary" data-id="'+ v.id+'"> 编辑 </button>&nbsp;'+
                '<a href="#myModal" data-toggle="modal" > <button data-toggle="button" class="btn btn-sm btn-warning delete" data-id="'+ v.id+'"> 删除'+ '</button></a></td></tr>'
                                        );
                                    });
                                }
                            });
                        }
                    }
                });
            });

    $('body').on('click','.change',function(){
        //>> 获取属性值
        var s = $(this).attr('class');
        //>> 获取编号
        var id = $(this).attr('data-id');

        //>> 匹配当前的状态
        var result = s.match(/^[icon-].*\s/);
            result = $.trim(result[0]);
        //>> 判断状态
        if(result == "icon-ok"){
            status = 0;
            $(this).removeClass();
            $(this).addClass('icon-remove change');
            AjaxRequest(id,status);
        }
        if(result == 'icon-remove'){
             status = 1;
            $(this).removeClass();
            $(this).addClass('icon-ok change');
            AjaxRequest(id,status);
        }

        //>> 修改后台
        function AjaxRequest(id,status){
            var url = location.protocol+'//'+window.location.host+'/backend/image/change';
            $.ajax({
                'type':'post',
                'dataType':'json',
                'url':url,
                'data':{
                    'id':id,
                    'is_active':status
                }
                ,
                success:function(result){
                    if(result.status == 1){

                        layer.msg('(*^__^*),你很棒棒哦');
                    }else{

                        layer.msg('（＋﹏＋）,伦家做不到');
                    }
                }
            });
        }
    });

    /**
     * 删除图片
     */
    $('body').on('click','.delete',function(){
         id = $(this).attr('data-id');
        //>> 将id传递给模态框
        $('.deleteTrue').attr({'data-id':id});
        //>> 确认删除
    });
    $('.deleteTrue').click(function(){
        id = $(this).attr('data-id');

        var url = location.protocol+'//'+window.location.host+'/backend/image/delete';
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':url,
            'data':{
                'id':id
            },
            success:function(result){
                location.reload();
            }
        });
    });
});