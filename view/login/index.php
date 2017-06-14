<?php
use includes\App;
$title='登陆';
include App::getConf('rootPath').'/view/head.php';
?>
<link rel="stylesheet" href="<?=App::getConf('httpRoot')?>/resource/css/login.css">
<h1>Welcome</h1>
<div class="app-cam">
    <form>
        <input type="text" class="text" value="" id="user" />
        <input type="password" value="" id="password"/>

        <input type="button" class="submit" value="Sign in" id="login" />

        <div class="clear"></div>
        <div class="new">
            <p><a href="#">Forgot Password</a></p>
            <p class="sign"><a href="<?=$httpRoot?>/index.php?<?=$rq?>=register"> Sign Up</a></p>
            <div class="clear"></div>
        </div>
    </form>
</div>
<script src="<?=$httpRoot?>/resource/js/sha1.js"></script>
<script src="<?=$httpRoot?>/resource/js/common.js"></script>
<script>
    $('#login').click(function(){
        loging();
        $.post(JsHelper.buildUrl(host, rq,'login' ,'login'),{
            user:$.trim($('#user').val()),
            password:CryptoJS.SHA1($.trim($('#password').val())).toString(),
        },function(res){
            loginBack();
            var data = JsHelper.parseJSON(res);
            if((typeof data) == 'string') {
                alert(data);
            }else if(data.success){
                window.location = host;
            }else{
                alert(data.msg);
            }
        });
    });

    /**
     *
     */
    function loging()
    {
        $('#login').attr('disabled',true).removeClass('submit').addClass('disabled').val('Logging...');
    }

    /**
     *
     */
    function loginBack()
    {
        $('#login').removeAttr('disabled').removeClass('disabled').addClass('submit').val('Sign in');
    }

</script>


<?php
include App::getConf('rootPath').'/view/foot.php';
?>