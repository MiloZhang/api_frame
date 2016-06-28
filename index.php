<?php
/**
 * 入口文件
 */
error_reporting(E_ERROR);
define("REQUEST_TRACKING", TRUE);
require_once 'Drivers/init.php';
$frameCore = new FrameCore();
$frameCore -> run();