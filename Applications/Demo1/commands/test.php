<?php

use Workerman\Worker;
use Workerman\Protocols\Http;
use WebWorker\Libs\Mredis;
use WebWorker\Libs\Mdb;
use WebWorker\Libs\Mmysqli;

require_once __DIR__ . '/../../../vendor/autoload.php';

//加载配置文件
define("ENVIRONMENT", 'dev');

require_once __DIR__ . '/config/config_' . ENVIRONMENT . '.php';


$redis = Mredis::getInstance($config["redis"]);
$db = Mdb::getInstance($config["db"]);

var_dump($redis->get("test"));
