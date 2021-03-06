<?php

declare(strict_types=1);

$app->HandleFunc('/search/add', function () use ($config) {

    TNTSearchService::getInstance($config['db'])->createIndex();

    return $this->ServerJson(['索引创建成功']);
});

$app->HandleFunc('/search/query', function () use ($config) {

    $res = TNTSearchService::getInstance($config['db'])->search($_GET['a'] ?? '无');

    return $this->ServerJson($res);
});

$app->HandleFunc('/search/update', function () use ($config) {

    TNTSearchService::getInstance($config['db'])->updateIndex([], intval($_GET['a'] ?? 1));

    return $this->ServerJson(['update success']);
});
