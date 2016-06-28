<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 12:52
 */
class FrameModel extends Frame {

    protected static $DB = NULL;

    public function __construct(){
        if(!self :: $DB) {
            self :: DBMysql();
        }
    }

    protected function DBMysql() {
         self :: $DB = new FrameMysql();
    }
}