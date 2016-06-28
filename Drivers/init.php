<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 11:44
 */
defined('REQUEST_TRACKING') or die("403");
require_once 'Common/function.php';
global $BV;
$BV = get('bv', $_REQUEST) ? get('bv', $_REQUEST) : '1.0.1';#默认版本号
global $requestTimeStart;
$requestTimeStart = microtimeFloat();
require_once 'Common/define.php';
require_once 'Common/defineResponseCode.php';
require_once 'Classes/FrameAutoLoad.php';
