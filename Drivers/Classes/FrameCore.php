<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 11:41
 */

class FrameCore extends Frame{

    /**
     * 执行方法入口
     */
    public function run() {
        self :: _execute();
    }

    /**
     * 开始执行方法
     * @param $service
     */
    private static function _execute() {
        #读取配置文件,判断请求方式是否为流形势
        if(trim(RC('transfer_config', 'input_type')) == 'STREAM') {
            self :: _parseStreamParam();
        }
        #读取配置文件,判断是否开启加密
        if(RC('encrypt_config', 'params_encrypt')) {
            self :: _decryptParams();
        }
        $service = get('service');
        if(!$service) {
            FrameJson :: printJson(ERROR_CODE, '缺少必要参数service');
        }
        list($api, $method) = explode('.', $service);
        try {
            $apiSource = new $api;
        } catch (Exception $e){
            FrameJson :: printJson($e -> getCode(), $e -> getMessage());
        }
        if(false == method_exists($apiSource, $method)) {
            FrameJson :: printJson(ERROR_CODE, 'Method not exist');
        }
        #执行检测参数
        self :: _checkParams($apiSource, $method);
        try {
            $result = $apiSource -> $method();
        } catch (Exception $e){
            FrameJson :: printJson($e -> getCode(), $e -> getMessage());
        }
        FrameJson:: printJson(SUCCESS_CODE, '', $result);
    }

    /**
     * 校验参数,赋值给类元素
     * @param $apiSource
     * @param $method
     * @return bool
     */
    private static function _checkParams($apiSource, $method) {

        try {
            $rule = $apiSource -> paramRule();
        }catch (Exception $e) {
            return false;
        }
        if(!$rule[$method]) {
            return true;
        }
        foreach($rule[$method] as $item => $val) {

            $val['type'] = trim($val['type']) == 'int' ? 'int' : 'string';
            if($val['must']) {
                if(false == get($val['key'], $_REQUEST, $val['type'])) {
                    FrameJson :: printJson(ERROR_CODE, '缺少必要参数'.$val['key']);
                }
                $apiSource ->$item =  get($val['key'], $_REQUEST, $val['type']);
            } else {
                $apiSource ->$item =  get($val['key'], $_REQUEST, $val['type']) ? get($val['key'], $_REQUEST, $val['type']) : $val['default'];
            }
        }
    }

    /**
     * 参数解密
     */
    private static function _decryptParams() {
        #加密后的参数key为p
        $p = get('p');
        if(!$p) {
            FrameJson :: printJson(ERROR_CODE, '缺少必要参数p');
        }
        #获取加密方式
        $encryptType = strtoupper(trim(RC('encrypt_config', 'encrypt_type')));
        try {
            #3DES加密
            if($encryptType == '3DES') {
                $strParam = Driver3Des ::decrypt($p);
            } else if($encryptType == 'ENCRYPT') { #普通加密
                $strParam = DriverEncrypt ::decrypt($p);
            }
        } catch (Exception $e) {
            FrameJson :: printJson(ERROR_CODE, '解密失败,请确认加密方式');
        }
        self :: _setParamIntoRequest($strParam);
    }

    /**
     * 处理流参数
     */
    private static function _parseStreamParam() {
        $paramString = file_get_contents("php://input");
        if(!$paramString) {
            throw new Exception("Params error", ERROR_CODE);
        }
        self :: _setParamIntoRequest($paramString);
    }

    /**
     * set param into request
     */
    private static function _setParamIntoRequest($paramString = '') {
        $param = explode('&', $paramString);
        foreach($param as $item => $value) {
            $data = explode('=', $value);
            $_REQUEST[$data[0]] = trim($data[1]);
        }
    }
}