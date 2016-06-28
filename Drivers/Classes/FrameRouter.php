<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/27
 * Time: 10:35
 */
class FrameRouter extends Frame {

    public static function parse() {
        self :: _execute();
    }

    private static function _setParam($key , $value) {
        $_REQUEST[$key] = $value;
    }

    private static function _execute() {
        #读取配置文件,看看是哪种路由配置
        $routerModel = (int)RC("router_config");
        #开始解析
        switch ($routerModel) {
            /*0 默认路由方式,请求规则为:?&service=something.thing*/
            case 0:
                break;
            /*1 自定义路由方式,请求规则为:?&action=something&method=thing*/
            case 1:
                self :: _parseUrl(1);
                break;
            /*2 自定义路由方式,请求规则为:?&service/something.thing/参数key/参数value*/
            case 2:
                self :: _parseUrl(2);
                break;
            default :
                self :: _parseUrl(1);
                break;
        }
    }

    /**
     * 解析url,返回数组
     * @param $type [1, 2]:对应config.router_config值
     */
    private static function _parseUrl($type = 1) {
        if($type == 1) {
            $action = get('action');
            $method = get('method');
            $service = $action.$method;
            self :: _setParam('service', $service);
        } else if($type == 2){

        }
    }


}