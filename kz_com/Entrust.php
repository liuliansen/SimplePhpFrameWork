<?php
namespace kz_com;

use kz_com\Base;
use \Exception as Exception;
use kz_com\exception\RemoteReadException;

class Entrust extends Base
{

    protected $url = 'https://www.kuzhuanwang.com/Trade/upTrade.html';

    private $msg = '';

    public function entrust($price,$num,$paypassword,$type)
    {
        $params = 'price='.$price.'&num='.$num.'&paypassword='.$paypassword.'&market=xup_cny&type=1';
        $result = $this->curl(true,$params);
        if($result['http_code'] == 200) {
            $res = json_decode($result['response']);
            if(is_object($res)){
                if($res->status == 0) {
                    $this->msg = $res->info;
                    return false;
                }else{
                    return true;
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