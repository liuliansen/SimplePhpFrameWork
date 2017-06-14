<?php
namespace kz_com;

use includes\Logger;
use kz_com\Base;
use \Exception as Exception;
use kz_com\exception\RemoteReadException;
use includes\includes;
use includes\App;

class Login extends Base
{
    protected $url = 'https://kuzhuanwang.com/Login/submit.html';

    private $msg = '';

    public function login($username, $password)
    {
        $params =  http_build_query(['username'=>$username,'password' => $password]);
        $result = $this->curl(true,$params);
        if($result['http_code'] == 200) {
            $res = json_decode($result['response']);
            if(is_object($res)){
                if($res->status == 0) {
                    $this->msg = $res->info;
                    return false;
                }else{
                    $this->isLogin = true;
                    return $this->cookies;
                }
            }else{
                throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
            }
        }else{
            throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
        }
    }

    public function getLastErrorMsg()
    {
        return $this->msg;
    }
}