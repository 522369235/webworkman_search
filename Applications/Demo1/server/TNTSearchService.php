<?php
/*
 * @Date : 2020-07-20 16:32:35
 * @LastEditors  : lim
 * @LastEditTime : 2020-07-27 16:29:37
 * @Descripttion :
*/

declare(strict_types=1);

use TeamTNT\TNTSearch\TNTSearch;

class TNTSearchService
{
    // protected $indexName = "title";
    protected $indexName = "user";

    protected $tnt;

    private static $_instance;

    private function __construct(array $options = [])
    {
        $config = [
            'driver'    => 'mysql',
            'host'      => $options['host'],
            'database'  => $options['db'],
            'username'  => $options['user'],
            'password'  => $options['password'],
            'storage'   => APP_PATH . '/public/tntsearch/examples/',
            'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class //optional
        ];
        $this->tnt = new TNTSearch;
        $this->tnt->loadConfig($config);
    }

    public static function getInstance(array $options = []): self
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

    /**
     * 创建索引
     * @param $token
     *
     */
    public function createIndex(): void
    {
        $indexer = $this->tnt->createIndex($this->indexName);
        $indexer->setPrimaryKey('user_id');
        $indexer->query('SELECT user_id, nickname FROM mx_user;');
        $indexer->setTokenizer($this->getToken());
        $indexer->inMemory = false;
        $indexer->run();
    }
    public function updateIndex(array $data = [], int $type = 1)
    {
        $this->tnt->selectIndex($this->indexName);
        $index = $this->tnt->getIndex();
        $index->setPrimaryKey('user_id');
        $index->setTokenizer($this->getToken());

        if ($type == 1) {
            //to insert a new document to the index
            $index->insert(['user_id' => '999999', 'nickname' => '哦哦哦哦']);
        }

        if ($type == 2) {
            //to update an existing document
            $index->update(999999, ['user_id' => '999998', 'nickname' => '哇哇哇哇哇']);
        }

        if ($type == 3) {
            //to delete the document from index
            $index->delete(999999);
        }
    }
    /**
     * 搜索
     * @param $keyword
     * @return array
     * @throws \TeamTNT\TNTSearch\Exceptions\IndexNotFoundException
     */
    public function search(String $keyword): array
    {
        $tnt = $this->tnt;
        $tnt->selectIndex($this->indexName);
        $tnt->fuzziness = true;
        $tnt->setTokenizer($this->getToken());
        return $tnt->search($keyword);
    }



    public function getToken()
    {
        return new JiebaTokenizer();
    }

    public function __clone()
    { }
}
