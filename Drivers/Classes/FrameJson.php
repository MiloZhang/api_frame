<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 13:13
 */
class FrameJson extends Frame {

    /**
     * Json输出类
     * @param int $code
     * @param string $message
     * @param array $data
     * @param array $extra
     */
    public static function printJson($code = 0, $message='', $data = array(),  $extra = array()) {
        $outPrint = array();
        $outPrint[RESPONSE_STATUS] = (int)$code;
        #判断是否开启参数加密
        if(RC("encrypt_config", 'response_encrypt')) {
            #获取加密方式
            $encryptType = strtoupper(trim(RC('encrypt_config', 'encrypt_type')));
            #3DES加密
            if($encryptType == '3DES') {
                $data = Driver3Des :: encrypt(json_decode($data));
            } else if($encryptType == 'ENCRYPT') { #普通加密
                $data = DriverEncrypt :: encrypt(json_decode($data));
            }
        }
        $outPrint[RESPONSE_DATA] = (array)$data;
        $outPrint[RESPONSE_MESSAGE] = trim($message);
        count($extra) > 0 ? $outPrint[RESPONSE_EXTRA] = $extra : '';
        $outPrint = json_encode($outPrint);
        #读取配置文件,判断请求方式是否为流形势
        if(trim(RC('transfer_config', 'output_type')) == 'STREAM') {
            self :: _returnStream($outPrint);
        } else {
            echo $outPrint;
        }
        #记录程序执行时间
        self :: _logRunTime();
        die;
    }

    /**
     * 记录程序运行时间
     */
    private static function _logRunTime() {
        global $requestTimeStart;
        $endTime = microtimeFloat();
        $runTime = round(($endTime - $requestTimeStart),4);
        $content = 'service='.get('service').';runtimes:'.$runTime.'s';
        FrameLogs :: stat($content);
    }

    /**
     * 以流形势,输出返回内容
     */
    private static function _returnStream($response) {
        file_put_contents("php://output", $response);
    }

}