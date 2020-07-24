<?php
ini_set('display_errors', 'on');
use Workerman\Worker;

require_once 'vendor/autoload.php';

// 标记是全局启动
define('GLOBAL_START', 1);

// 加载所有Applications/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/Applications/*/start*.php') as $start_file)
{
    require_once $start_file;
}

// 运行所有服务
Worker::runAll();
