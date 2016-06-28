<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 */
class ApiExe extends FrameApi{

    public function paramRule() {
        return array(
            /*detail方法参数区*/
            'detail' => array(
                'username' => array('key' => 'username', 'must' => true, 'type' => 'string'),
                'password' => array('key' => 'password', 'default' => '123', 'type' => 'int'),
            ),
        );
    }

    public function detail() {
        $domainUser = new DomainUser();
        $return = $domainUser -> getUser();
        FrameLogs :: log($return, 'detail');
        return $return;
    }

    public function test() {
        throw new Exception('params error', ERROR_CODE);
    }
}