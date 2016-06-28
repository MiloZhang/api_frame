<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:35
 */
return array(
    /**
     * mysql数据库配置
     */
    'db_config' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'charset' => 'UTF8',
        'database' => 'scanload',
    ),

    /**
     * 日志相关配置
     */
    'log_config' => array(
        #是否开启日志-总开关
        'write_log' => TRUE,
        #是否开启Mysql日志
        'write_sql_log' => TRUE,
    ),

    /**
     * 数据加密配置
     */
    'encrypt_config' => array(
        #请求参数是否开启3Des加密
        'params_encrypt' => FALSE,
        #返回结果是否开启3Des加密
        'response_encrypt' => TRUE,
        #加密类型 3DES 加密 和 ENCRYPT 普通加密
        'encrypt_type' => 'ENCRYPT',
        #3Des参数
        '3des_key' => 'abcd1234',
        '3des_iv' => '0123456',
        '3des_model' => 'cbc',
    ),

    /**
     * 请求方式,返回方式配置
     */
    'transfer_config' => array(
        #接收参数类型 POST GET REQUEST STREAM
        'input_type' => 'REQUEST',
        #返回参数类型 ECHO STREAM
        'output_type' => 'ECHO',
    )




);
