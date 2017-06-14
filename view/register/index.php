<?php
use includes\App;
$title='注册';
include App::getConf('rootPath').'/view/head.php';
?>
<style>
    .form-group{
        margin-top: 30px;
    }
</style>
<div class="container" style="margin-top:100px;">
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">用&#12288;&#12288;户</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="user" placeholder="必须以字母开始。可以字母、数字和下划线，不能小于6位" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">密&#12288;&#12288;码</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="password" placeholder="字母和数字(不能小于6位)" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">密码确认</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="pw-confirm" placeholder="再次输入上面的密码"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">邮&#12288;&#12288;箱</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="email" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">手&#12288;&#12288;机</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="phone" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="button" class="btn btn-lg btn-success" id="login">注册</button>
                <button type="button" class="btn btn-lg btn-default" id="back" style="float: right;">返回</button>
            </div>
        </div>
    </form>
</div>
<script src="<?=$httpRoot?>/resource/js/common.js"></script>
<script>
    $('#back').click(function(){
       window.history.back();
    });

    $('#login').click(function(){
        disabled();
        $.post(JsHelper.buildUrl(host, rq, 'register', 'register'), getRegisterInfo(), function (res) {
            enabled();
            var data = JsHelper.parseJSON(res);
            if((typeof data) == 'string') {
                alert(data);
            }else if(data.success){
                alert('注册成功')
                window.location = JsHelper.buildUrl(host, rq,'index');
            }else{
                alert(data.msg);
            }
        });
    });

    function getRegisterInfo()
    {
        var info = {};
        info.user     = $.trim($('#user').val());
        info.password = $.trim($('#password').val());
        info.confirm  = $.trim($('#pw-confirm').val());
        info.email    = $.trim($('#email').val());
        info.phone    = $.trim($('#phone').val());
        info.password = $.trim($('#password').val());
        return info;
    }

    function disabled()
    {
        $('#login').attr('disabled',true);
        $('#back').attr('disabled',true);
    }

    function enabled()
    {
        $('#login').removeAttr('disabled');
        $('#back').removeAttr('disabled');
    }

</script>

<?php
include App::getConf('rootPath').'/view/foot.php';
?>