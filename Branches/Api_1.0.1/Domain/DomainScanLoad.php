<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:21
 */
class DomainScanLoad extends FrameDomain {

    public function scanLoadInfo($download = FALSE) {
        $model = new ModelScanLoad();
        $scanLoadInfo = $model -> getScanLoadInfo();
        $configInfo = $model -> getConfigInfo();
        $url = $path = '';
        foreach($configInfo as $item => $value) {
            if((int)$value['type'] == 0) {
                $url .= trim($value['strvalue']);
                continue;
            }
            if((int)$value['type'] == 1) {
                $url .= trim($value['strvalue']);
                $path = trim($value['strvalue']);
                break;
            }
        }
        $reponse = array(
            'vc' => (int)$scanLoadInfo['version'],
            'vd' => trim($scanLoadInfo['desp']),
            'url' => trim($url).'/'.trim($scanLoadInfo['name']),
            't' => (int)$scanLoadInfo['type'],
        );
        if($download) {
            $reponse['name'] = trim($scanLoadInfo['name']);
            $reponse['path'] = $path;
        }
        return $reponse;
    }

}