<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/24
 * Time: 17:56
 */
header("Content-type:text/html;charset=utf-8");
class DriverDownLoad extends Driver {

    /**
     * header跳转
     * @param $url
     * @param int $type
     */
    public static function _header($url, $type = 302) {
        if((int)$type == 301) {
            header("http/1.1 301 moved permanently");
        }
        header($url);
    }

    /**
     * desc 文件下载,文件流形势
     * @param $url
     */
    public static function _file($filePath = '', $file_name = '') {
        $fp = @fopen($filePath,"r");
        if(!$fp){
            FrameLogs :: warningLog('File not exists:'.$filePath);
            throw new Exception("File not found", ERROR_CODE);
        }
        $file_size = filesize($filePath);
        #下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);
        $buffer = 1024;
        $file_count = 0;
        #向请求方返回数据
        while(!feof($fp) && $file_count < $file_size){
            $file_con = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_con;
        }
        fclose($fp);
    }

}