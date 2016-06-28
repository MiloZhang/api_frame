<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 * class name ApiSl == ApiScanLoad
 */
class ApiSl extends FrameApi{

    public function paramRule() {
        return array(
            /*下发最新ScanLoad模块信息接口*/
            'info' => array(
                'username' => array('key' => 'username', 'must' => true, 'type' => 'string'),
                'password' => array('key' => 'password', 'default' => '123', 'type' => 'int'),
            ),
        );
    }

    /**
     * 下发最新ScanLoad模块信息接口
     * @return mixed
     */
    public function info() {
        $domainScanLoad = new DomainScanLoad();
        $return = $domainScanLoad -> scanLoadInfo();
        FrameLogs :: log($return, 'api_scanLoad_info');
        return $return;
    }

    /**
     * 下发最新的ScanLoad模块接口
     * @throws Exception
     */
    public function get() {
        $domainScanLoad = new DomainScanLoad();
        $response = $domainScanLoad -> scanLoadInfo(TRUE);
        $filePath = '/Applications/XAMPP/xamppfiles/htdocs/BaiduYun_2.4.3.dmg';#trim($response['path']);
        $response['name'] = 'BaiduYun_2.4.3.dmg';
        FrameLogs :: log(array(), 'api_scanLoad_get');
        #执行下载
        DriverDownLoad :: _file($filePath, $response['name']);
    }
}