<?php
namespace kz_com;

use kz_com\Base;
use \Exception as Exception;
use kz_com\exception\RemoteReadException;
use model\UserModel;
use kz_com\Login;

class GetEntrustAndUsercoin extends Base
{

    protected $url = 'https://kuzhuanwang.com/Ajax/getEntrustAndUsercoin?market=xup_cny&t=0.45780287644367157';

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        $result = $this->curl(true);
        if ($result['http_code'] == 200) {
            if ($result['response'] == '') {
                if($this->isLogin){
                    return $this->get();
                }else{
                    $model = new UserModel();
                    $user = $model->getByUser($_SESSION['user']);
                    $api = new Login($this->cookies);
                    $loginCookie = $api->login($user['kz_user'],$user['kz_password']);
                    if ($loginCookie) {
                        $this->cookies = array_merge($this->cookies, $loginCookie);
                        $this->isLogin = true;
                        return $this->get();
                    } else {
                        throw new RemoteReadException('登录酷赚网失败');
                    }
                }
            } else {
                $response = json_decode($result['response']);
                if(is_object($response)){
                    return $this->object2Array($response);
                }
                throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
            }

        }else{
            throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
        }
    }

}