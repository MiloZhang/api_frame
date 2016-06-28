<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 */
class DomainUser extends FrameDomain {

    public function getUser() {
        $model = new ModelUser();
        return $model ->getAllUser();
    }

}