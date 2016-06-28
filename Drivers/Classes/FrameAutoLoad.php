<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/21
 * Time: 14:46
 */
class FrameAutoLoad {

    static $RuleMap = array(
        'Frame' => CLASS_PATH,
        'Driver' => CLASS_PATH,
        'Api' => BRANCHES_PATH,
        'Domain' => BRANCHES_PATH,
        'Model' => BRANCHES_PATH,
    );

    /**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class) {
        global $BV;
        $name = $class;
        if(false !== strpos($name,'\\')){
            $name = strstr($class, '\\', true);
        }
        $filename = '';
        foreach(self :: $RuleMap as $item => $value) {
            if(strpos($name , $item) !== false) {
                if(in_array($item, array('Api', 'Domain', 'Model'))) {
                    $filename = $value.'Api_'.$BV.'/'.$item.'/'.$class.".php";
                } else {
                    $filename = $value.$name.".php";
                }
                break;
            }
        }
        if(is_file($filename)) {
            include $filename;
            return;
        } else {
            throw new Exception("Class {$name} not fond", ERROR_CODE);
        }
    }
}

spl_autoload_register('FrameAutoLoad::autoload');