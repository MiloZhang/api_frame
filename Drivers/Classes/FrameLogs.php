<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 16:58
 */
class FrameLogs extends Frame {

    private static $LogPath;

    private static $FilePrefix = 'log_';

    private static $FileSuffix = '.txt';

    public static function log($response, $name = 'log') {
        $content = '[time:'.date("H:i:s").']-[request:'.json_encode($_REQUEST).']-[response:'.json_encode($response).']';
        self :: write($content, $name);
    }

    public static function errorLog($errorInfo, $name = 'error') {
        $content = '[time:'.date("H:i:s").']-[request:'.json_encode($_REQUEST).']-[error:'.json_encode($errorInfo).']';
        self :: write($content, $name, '_'.$name);
    }

    public static function warningLog($warningInfo, $name = 'warning') {
        $content = '[time:'.date("H:i:s").']-[request:'.json_encode($_REQUEST).']-[warning:'.json_encode($warningInfo).']';
        self :: write($content, $name, '_'.$name);
    }

    public static function sql($sql, $name='sql') {
        $content = '[time:'.date("H:i:s").']-[sql:'.$sql.']';
        self :: write($content, $name, '_sql');
    }

    public static function stat($string, $name='stat') {
        $content = '[time:'.date("H:i:s").']-[stat:'.$string.']';
        self :: write($content, $name, '_stat');
    }

    private static function makeFile($dir) {
        global $BV;
        self :: $LogPath = LOG_PATH.'version_'.$BV.'/'.date("Ym") . $dir;
        if(!is_dir(self :: $LogPath)) {
            try {
                mkdir(self :: $LogPath, 0777);
            } catch (Exception $e) {
                throw new Exception($e -> getMessage());
            }
        }
        return true;
    }

    private static function write($content, $name, $dir) {
        if(!RC('log_config','write_log')) {
            return true;
        }
        try {
            self :: makeFile($dir);
        } catch (Exception $e) {
            #TODO
        }
        $logFileName = self :: $LogPath . '/'. self :: $FilePrefix . $name . '_' . date("d"). self :: $FileSuffix;
        #写文件
        try {
            $fileSource = fopen($logFileName, 'a+');
        } catch (Exception $e) {
            throw new Exception($e -> getMessage());
        }
        if (!$fileSource) {
            throw new Exception('Could not open file for writing . '.$logFileName);
        }
        if (!flock($fileSource, LOCK_EX)) {
            throw new Exception('Could not lock file');
        }

        fwrite($fileSource, $content . "\n");
        flock($fileSource, LOCK_UN);
        fclose($fileSource);
    }

}