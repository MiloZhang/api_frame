<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 */
class DriverMysql extends Driver {

    private static $_instance;

    private function __construct() {

    }


    private function __clone() {

    }

    public function connectDB($host, $username, $password, $database, $dbcharset) {
        $dbLink = new mysqli($host, $username, $password,$database);
        if (mysqli_connect_errno()){
            //注意mysqli_connect_error()新特性
            throw new Exception('Unable to connect!'.mysqli_connect_error(), ERROR_CODE);
        }
        $dbLink->set_charset("utf8");
        return $dbLink;
    }

    public static function getInstance() {
        if(!(self :: $_instance instanceof self)) {
            self :: $_instance = new self;
            FrameLogs::sql("DriverMysql:getInstance 实例次数", 'instance_mysql');
        }
        return self :: $_instance;
    }
}
