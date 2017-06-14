<?php
namespace kz_com;

use kz_com\Base;
use \Exception as Exception;
use kz_com\exception\RemoteReadException;

class GetTopInfo extends Base
{

    protected $url = 'https://kuzhuanwang.com/Ajax/getJsonTop?market=xup_cny&t=0.7398413740570681&id=1';

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        $result = $this->curl();
        if($result['http_code'] == 200) {
            $response = json_decode($result['response']);
            if(is_object($response)){
                return $this->object2Array($response);
            }
            throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
        }else{
            throw new RemoteReadException('请求酷赚数据失败,请检查cookie是否有误');
        }
    }

}