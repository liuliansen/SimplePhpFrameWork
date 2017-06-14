<?php
namespace controller;
use controller\Base;
use includes\App;

class Login extends Base
{
    public function indexAction()
    {
        $this->display('index');
    }

    /**
     *
     */
    public function loginAction()
    {
        $model = $this->getModel('User');
        $r = $model->getByUser(App::$request->get('user'));
        if($r && $r['password'] == App::$request->get('password')) {
            $_SESSION['user_id'] = $r['id'];
            $_SESSION['user'] = $r['user'];
            App::sendBack();
        }else {
            App::sendBack(false,'账号或密码错误');
        }
    }
}