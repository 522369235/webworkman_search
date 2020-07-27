<?php
/*
 * @Date : 2020-07-20 16:32:35
 * @LastEditors  : lim
 * @LastEditTime : 2020-07-27 14:50:12
 * @Descripttion :
*/

use TeamTNT\TNTSearch\TNTSearch;

class TNTSearchService
{
    // protected $indexName = "title";
    protected $indexName = "user";

    protected $tnt;

    private static $_instance;

    private function __construct($options = [])
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

    public static function getInstance($options = [])
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
    public function createIndex()
    {
        $indexer = $this->tnt->createIndex($this->indexName);
        $indexer->setPrimaryKey('user_id');
        $indexer->query('SELECT user_id, nickname FROM mx_user;');
        $indexer->setTokenizer($this->getToken());
        $indexer->inMemory = false;
        $indexer->run();
    }

    /**
     * 搜索
     * @param $keyword
     * @return array
     * @throws \TeamTNT\TNTSearch\Exceptions\IndexNotFoundException
     */
    public function search($keyword)
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

    // public function __clone()
    // {
    //     //E_USER_ERROR只能通过trigger_error($msg, E_USER_ERROR)手动触发。E_USER_ERROR是用户自定义错误类型，可以被set_error_handler错误处理函数捕获，允许程序继续运行。E_ERROR是系统错误，不能被set_error_handler错误处理函数捕获，程序会退出运行
    //     trigger_error('Clone is not allow!', E_USER_ERROR);
    // }
}
