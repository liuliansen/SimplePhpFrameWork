<?php

namespace kz_com;

use kz_com\exception\CookieCreateException;

class GetCookie
{
    /**
     * @param $response
     * @return array
     * @throws CookieCreateException
     */
    static public function getCookie($response)
    {
        $args = [];
        preg_match('/setTimeout\(\".*\((\d+)\)\"/',$response,$s);
        if($s[1]) $args[] = $s[1];

        preg_match_all('/"\w+\s*=\s*(\d+)\s*;\s*do{.*>>\s*(\d+).*<<\s*(\d+).*-(\d+).*while\(--qo>=2\);"/',$response,$do);
        array_shift($do);
        foreach($do as $k => $v){
            if( $v[0])  $args[] = $v[0];
        }

        preg_match_all('/\(\(\(\(\(\(.*\+\s*(\d+).*\+\s*(\d+).*<<\s*(\d+).*\|.*>>\s*(\d+)/',$response,$for);
        array_shift($for);
        foreach($for as $k => $v){
            if( $v[0])  $args[] = $v[0];
        }

        preg_match('/\(\w+\s*\%\s*(\d+)\s*\)/',$response,$m);
        if($m[1]) {
            $args[] = $m[1];
        }

        preg_match('/\w+\s*=\s*\[(.*)\]/',$response,$ox);
        if($ox[1]) {
            $args[] = explode(',',$ox[1]);
        }
        if(count($args) == 11) {
            return static::createCookie($args);
        }else{
            throw new CookieCreateException('参数长度不合法');
        }

    }

    /**
     * @param $args
     * @return array
     * @throws CookieCreateException
     */
    static private function createCookie($args)
    {
        $qo =  $args[1];
        $oo = $args[10];
        do {
            $oo[$qo] = (-$oo[$qo]) & 0xff;
            $oo[$qo] = ((($oo[$qo] >> $args[2]) | (($oo[$qo] << $args[3]) & 0xff)) - $args[4]) & 0xff;
        } while (--$qo >= 2);
        $qo = $args[1]-1;
        do {
            $oo[$qo] = ($oo[$qo] - $oo[$qo - 1]) & 0xff;
        } while (--$qo >= 3);
        $qo = 1;
        for (; ;) {
            if ($qo > $args[1]-1) break;
            $oo[$qo] = (((((($oo[$qo] + $args[5]) & 0xff) + $args[6]) & 0xff) << $args[7]) & 0xff) | ((((($oo[$qo] + $args[5]) & 0xff) + $args[6]) & 0xff) >> $args[8]);
            $qo++;
        }

        $po = "";
        for ($qo = 1; $qo < count($oo) - 1; $qo++) {
            if ($qo % $args[9]) $po .= utf8_encode(chr($oo[$qo] ^ $args[0]));
        }
        preg_match('/\'(.*)\'/',$po,$ckInfo);
        if($ckInfo[1]) {
            return static::cookieStr2Array($ckInfo[1]);
        }else{
            throw new CookieCreateException('Cookie生成失败');
        }
    }

    /**
     * @param $ckStr
     * @param array $oriCookieArray
     * @return array
     */
    static public function cookieStr2Array($ckStr, $oriCookieArray = array())
    {
        $cookies = [];
        $arr = explode(';',$ckStr);
        foreach ($arr as $ck){
            if(trim($ck)) {
                $cookie = explode('=',$ck);
                $cookies[trim($cookie[0])] = trim($cookie[1]);
            }
        }
        return array_merge($oriCookieArray,$cookies);
    }


    /**
     * @param $ckArray
     * @return string
     */
    static public function cookieArray2Str($ckArray)
    {
        $cookieStr = '';
        foreach ($ckArray as $k => $v){
            if($k && $v) {
                $cookieStr .= "{$k}={$v}; ";
            }
        }
        return substr($cookieStr,0,strlen($cookieStr)-1);
    }
}