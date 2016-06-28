<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 12:51
 */
abstract class FrameApi extends Frame{

    /**
     * 参数验证规则
     *
     * 例:
     *return array(
     *   'detail' => array(
     *       'username' => array('key' => 'username', 'must' => true, 'type' => 'string'),
     *       'password' => array('key' => 'password', 'default' => '123', 'type' => 'int'),
     *   ),
     *);
     * 外层username和password为类变量key;
     * 对应的数组元素有:
     * key 请求时传输的key值;
     * must 是否必传 true是 false或者不限制则为选择传输;
     * type 数据类型 int 和string;
     * default 默认值,当must为false时起作用
     * @return mixed
     */
    abstract function paramRule();

}