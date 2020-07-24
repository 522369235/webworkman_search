<?php

use Workerman\Worker;
use Workerman\Protocols\Http;
use WebWorker\Libs\Mredis;
use WebWorker\Libs\Mdb;
use WebWorker\Libs\Mmysqli;

require_once __DIR__ . '/../../vendor/autoload.php';

define("ENVIRONMENT", 'dev');

require_once __DIR__ . '/config/config_' . ENVIRONMENT . '.php';
require_once __DIR__ . '/front/search.php';


$app = new WebWorker\App("http://0.0.0.0:1215");

$app->name = "Demo1";

$app->count = 4;

$app->autoload = array(__DIR__ . "/controllers/", __DIR__ . "/libs/", __DIR__ . "/funcs/", __DIR__ . "/models/", __DIR__ . "/server/");

//设置监控
$app->statistic_server = "udp://127.0.0.1:55656";

//初始化redis和mysqli连接
$app->onAppStart = function ($app) use ($config) {
    $app->redis = Mredis::getInstance($config["redis"]);
    $app->db = Mdb::getInstance($config["db"]);
    //支持接受reload信号，这包含的文件修改不需要重启 
    WebWorker\autoload_dir($app->autoload);
};

//对所有接口做签名验证
$app->AddFunc("/", function () {
    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
        $this->ServerJson(array("ret" => 1, "error" => "禁止访问"));
        return true; //返回ture,中断执行后面的路由或中间件，直接返回给浏览器
    }
});

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
