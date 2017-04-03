/**
 * Created by Administrator on 2017/4/3.
 */
var myEditor = CKEDITOR.replace('TextArea1');
$(function(){
    $('#ok').click(function(){
        var content = myEditor.document.getBody().getHtml();
        url = location.protocol+'//'+window.location.host+'/backend/article/add';
        //>> 验证标题是否为空
        title = $('input[name = title]').val();
        if(title.length == 0){
            layer.msg('亲,标题还没填哒');
            return;
        }

        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':url,
            'data':{
                'content':content,
                'title':title
            },
            success:function(result){
                if(result.status == 1){
                    layer.msg('喵,文章添加成功',function(){
                        window.location.href = '/backend/article/list';
                    });
                }else{
                    layer.msg('咦,文章添加失败',function(){
                        location.reload();
                    });
                }
            }
        });
    });
});