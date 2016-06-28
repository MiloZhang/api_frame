<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/27
 * Time: 15:37
 * 普通加密类
 */
class DriverEncrypt extends Driver{

    static $Prefix = '.';

    static $UsefulLife = 2; #单位秒

    /**
     * 字符串加密
     * @param $string
     * @param string $prefix
     * @return string
     */
    public static function encrypt($string, $prefix) {
        $prefix = trim($prefix) ? trim($prefix) : self :: $Prefix;
        #把每一个字符进行base64_encode加密
        $strlen = strlen($string);
        $stringBase64 = '';
        while ($i < $strlen) {
            $stringBase64 .= base64_encode($string{$i}).$prefix;
            $i++;
        }

        #把base64处理完成的内容,进行= 替换为:的操作
        $stringBase64 = str_replace('=', ':', $stringBase64);
        #反转字符串
        $stringStrrev = strrev($stringBase64);

        #加入有效时间
        $stringJoinTime = json_encode(array('s' => $stringStrrev, 't' => time() + self :: $UsefulLife));

        #最后把处理完成的字符串先urlencode处理,然后再base64处理
        $finalString = base64_encode(urlencode($stringJoinTime));

        return $finalString;
    }

    /**
     * 解密
     * @param $string
     * @param $prefix
     */
    public static function decrypt($string, $prefix) {
        $prefix = trim($prefix) ? trim($prefix) : self :: $Prefix;
        #先解密最外层base64,然后解密urlencode
        $string = urldecode(base64_decode($string));

        #校验时间是否过期
        $arrayFull = json_decode($string, true);
        if((int)$arrayFull['t'] < time()) {
            #过期处理
            throw new Exception("Verify failed, the time has gone", ERROR_CODE);
        }
        $string = trim($arrayFull['s']);

        #反转字符串
        $stringStrrev = strrev($string);
        #把拿到的内容,进行: 替换为=的操作
        $stringBase64 = str_replace(':', '=', $stringStrrev);

        #根据标示,去分割字符串
        $arrBase64 = explode($prefix, $stringBase64);

        $finalString = '';

        foreach ($arrBase64 as $item => $value) {
            $finalString .= base64_decode($value);
        }
        return $finalString;
    }



}