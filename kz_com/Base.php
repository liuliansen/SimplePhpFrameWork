<?php
namespace kz_com;

use includes\App;
use \Exception as Exception;
use includes\DbHelper;
use model\KZCookieModel;
use kz_com\exception\CookieCreateException;
use kz_com\exception\RemoteReadException;
use kz_com\GetCookie;

class Base
{
    protected $url = '';
    protected $cookies = [];

    protected $_cookieIsChange = false;

    protected $curlDebug = false;

    protected $isLogin = false;

    public function __construct($cookies)
    {
        if($cookies) {
            if (is_string($cookies)) {
                $cookies = GetCookie::cookieStr2Array($cookies);
            }
            $this->cookies = $cookies;
        }
    }

    public function cookieIsChange()
    {
        return $this->_cookieIsChange;
    }

    public function getCookieArray()
    {
        return $this->cookies;
    }

    /**
     * @param bool $setHeaders
     * @param string $params
     * @param int $timeout
     * @return array
     * @throws RemoteReadException
     */
    public function curl($setHeaders = false, $params = '', $timeout = 30){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        if($setHeaders) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept	: application/json, text/javascript, */*; q=0.01',
                'Referer: https://www.kuzhuanwang.com/Trade/index/market/xup_cny',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0',
                'X-Requested-With: XMLHttpRequest',
            ]);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $cookie = GetCookie::cookieArray2Str($this->cookies);
        if($cookie) {
            curl_setopt($ch,CURLOPT_COOKIE,$cookie);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($params) {
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        }
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        preg_match('/\r\n\r\n([.\s\S]*)$/',$ret,$mm);
        if(!isset($mm[1])) throw new RemoteReadException('酷赚网数据读取失败');
        if($this->curlDebug){
            var_dump('===========================');
            var_dump($cookie);
            var_dump($ret);
            var_dump('===========================');
        }
        if($info['http_code'] === 521) {
            try{
                $this->cookies = GetCookie::getCookie($mm[1],$this->cookies);
            }catch (CookieCreateException $ex){}
            return $this->curl($setHeaders, $params, $timeout);
        }else{
            preg_match('/Set-Cookie: (.*)\n/',$ret,$cm);
            if(isset($cm[1])){
                $this->cookies = GetCookie::cookieStr2Array($cm[1],$this->cookies);
                $this->_cookieIsChange = true;
                $model = new KZCookieModel();
                $model->save(APP::$model == 'web'?$_SESSION['user_id']:App::getConf('cli')['user_id'], $this->cookies);
            }
            return array_merge(['response'=>$mm[1]],$info);
        }
    }




    /**
     * @param $obj
     * @return array
     * @throws Exception
     */
    public function object2Array($obj)
    {
        $arr = [];
        if(is_array($obj) || is_object($obj)) {
            foreach($obj as $k => $v){
                if(is_array($v) || is_object($v)) {
                    $arr[$k] = $this->object2Array($v);
                }else{
                    $arr[$k] = $v;
                }
            }
        }else{
            throw new Exception('object2Array函数的参数必须是一个可以迭代的类型');
        }
        return $arr;
    }


}