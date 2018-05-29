<?php
define('APP_PATH', realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */
$app     = new Yaf_Application(APP_PATH . '/conf/application.ini');
$request = new Yaf_Request_Simple('CLI', 'Index', 'Websocket', 'Index', ['para' => 2]);
$app->bootstrap()
    ->getDispatcher()
    ->dispatch($request);
