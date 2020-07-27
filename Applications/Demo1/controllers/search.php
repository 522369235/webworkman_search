<?php

$app->HandleFunc('/search/add', function () use ($config) {

    TNTSearchService::getInstance($config['db'])->createIndex();

    return $this->ServerJson(['索引创建成功']);
});

$app->HandleFunc('/search/query', function () use ($config) {

    $res = TNTSearchService::getInstance($config['db'])->search($_GET['a'] ?? '无');

    return $this->ServerJson($res);
});
