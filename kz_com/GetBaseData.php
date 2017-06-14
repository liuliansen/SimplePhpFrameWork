<?php
namespace kz_com;

use kz_com\Base;
use \Exception as Exception;
use kz_com\exception\RemoteReadException;

class GetBaseData extends Base
{

    protected $url = '';
    private $url1 ='https://www.kuzhuanwang.com/Ajax/getDepth?market=xup_cny&trade_moshi=1&t=0.7458992127349735';
    private $url3 ='https://www.kuzhuanwang.com/Ajax/getDepth?market=xup_cny&trade_moshi=3&t=0.7458992127349735';
    private $url4 ='https://www.kuzhuanwang.com/Ajax/getDepth?market=xup_cny&trade_moshi=4&t=0.7458992127349735';


    public function __construct($type,$cookies)
    {
        parent::__construct($cookies);
        $url = 'url'.$type;
        $this->url = $this->$url;
    }

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