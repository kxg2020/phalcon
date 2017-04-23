/**
 * Created by Administrator on 2017/4/16.
 */
$(function(){
    $('button[type = button]').click(function(){
        //>>  获取用户名和密码
        username = $('input[name = username]').val();
        password = $('input[name = password]').val();
        remember = $('input[name = remember]:checked').val();
        if(username == ''){
            layer.tips('用户名不能为空','input[name = username]');
            return false;
        }
        if(password == ''){
            layer.tips('密码不能为空','input[name = password]');
            return false;
        }
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':location.protocol+'//'+window.location.host+'/backend/index/check',
            'data':{
                'username':username,
                'password':password,
                'remember':remember,
            },
            success:function(r){

                if(r.status == 1){
                    window.location.href = location.protocol+'//'+window.location.host+'/backend/index/index'
                }else{

                    layer.msg(r.errmsg);
                }
            }
        });
    });
});