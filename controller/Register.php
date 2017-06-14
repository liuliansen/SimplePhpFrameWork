<?php

namespace controller;
use controller\Base;
use includes\App;
use \Exception as Exception;

class Register extends Base
{
    public function __construct()
    {

    }

    public function indexAction()
    {
        $this->display('index');
    }

    public function registerAction()
    {
        $user = App::$request->get('user',1,'');
        if ($user == '') {
            App::sendBack(false,'用户未填写');
        } elseif (strlen($user) < 6 || !preg_match('/^[a-zA-Z][a-zA-Z0-9_]+$/',$user)) {
            App::sendBack(false,'账号不符合规范');
        }

        $password = App::$request->get('password',1,'');
        if ($password == '') {
            App::sendBack(false,'密码未填写');
        } elseif (strlen($password) < 6 || !preg_match('/^[a-zA-Z0-9_@\#\$\%\^\&\*]+$/',$password)) {
            App::sendBack(false,'密码不符合规范');
        }

        $confirm = App::$request->get('confirm',1,'');
        if ($password == '') {
            App::sendBack(false,'未填写确认密码');
        } elseif ($confirm != $password) {
            App::sendBack(false,'密码输入不一致');
        }

        $email = App::$request->get('email',1,'');
        if ($email != '' && !preg_match('/^.*\@.*\.[a-zA-Z]{2,3}$/',$email)) {
            App::sendBack(false,'邮箱不符合规范');
        }

        $phone = App::$request->get('phone',1,'');
        if ($phone != '' && !preg_match('/^1[3-9]\d{9}$/',$phone)) {
            App::sendBack(false,'电话不符合规范');
        }
        try {
            $model = $this->getModel('User');
            $r = $model->getByUser($user);
            if($r) {
                throw new Exception('用户名已被占用');
            }
            $r = $model->getByPhone($phone);
            if($r) {
                throw new Exception('电话已被占用');
            }
            $id = $model->add([
                'user' => $user,
                'password' => sha1($password),
                'email' => $email,
                'phone' => $phone,
            ]);
            if($id) {
                App::sendBack();
            }else {
                throw new Exception('注册失败');
            }
        }catch (Exception $ex) {
            App::sendBack(false,$ex->getMessage());
        }
    }
}