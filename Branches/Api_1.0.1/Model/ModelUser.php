<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 */
class ModelUser extends FrameModel {

    public function getUser() {
        $data = self :: $DB -> get_one("SELECT * FROM config");
        return $data;
    }

    public function addUser() {
        $insertData = array(
            'name' => '里流',
            'sex' => 1,
            'age' => 12,
        );
        $insert = self :: $DB ->insert('b_test', $insertData);
    }

    public function getAllUser() {
        $data = self :: $DB -> get_all("SELECT * FROM config");
        return $data;
    }

}