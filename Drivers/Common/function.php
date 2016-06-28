<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 12:00
 */

/**
 * 获取参数
 * param key
 * param source array
 * param type /int/string
 */
function get($key, $array, $type = 'string') {
    $array = count((array)$array) > 0 ? $array : $_REQUEST;
    $result = '';
    if($array[$key]) {
        $result = $array[$key];
    }
    switch ($type) {
        case 'int':
            $result = (int)$result;
        break;
        case 'string':
            $result = trim($result);
        break;
        default:
            $result = trim($result);
    }
    return $result;
}

/**
 * read config
 * param key,没有key的话,返回所有配置
 */
function RC($key = '', $childKey = '') {
    $config = require CONFIG_PATH.'config.php';
    $conf = '';
    if($key) {
        $conf = $config[$key] ? $config[$key] : FALSE;
    }
    if($childKey) {
        $conf = trim($conf[$childKey]);
    }
    return $conf;
}

/**
 * 获取当前时间 微秒单位
 */
function microtimeFloat() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

