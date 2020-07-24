<?php

$app->HandleFunc('/search/add', function () use ($config) {

    TNTSearchService::getInstance($config['db'])->createIndex();

    return $this->ServerJson(['索引创建成功']);
});

$app->HandleFunc('/search/query', function () use ($config) {

    $a = $_GET['a'] ?? '无';

    $res = TNTSearchService::getInstance($config['db'])->search($a);

    return $this->ServerJson($res);
});
