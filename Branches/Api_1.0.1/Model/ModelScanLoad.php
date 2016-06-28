<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 16:45
 */

class ModelScanLoad extends FrameModel {

    public function getConfigInfo() {
        return self :: $DB -> get_all("SELECT * FROM `config`");
    }

    public function getScanLoadInfo() {
        return self :: $DB -> get_one("SELECT * FROM `p_info` WHERE `enable` = '1' ORDER BY `version` DESC");
    }

}