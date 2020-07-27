search-demo
========
基于[WebWorker](https://github.com/xtgxiso/WebWorker)上写的搜索引擎demo

引用
========

[WebWorker](https://github.com/xtgxiso/WebWorker)

[结巴中文分词](https://github.com/fukuball/jieba-php)

[TNTSearch](https://github.com/teamtnt/tntsearch)

命令
========

```
php start.php start     //以调试模块启动 
php start.php start -d  //以守护进程启动
php start.php stop      //停止进程
php start.php reload    //重新加载onAppStart中的包含文件
php start.php restart   //重新启动
php start.php status    //查看进程情况
```

测试
========

创建索引 表('SELECT user_id, nickname FROM mx_user;')
http://127.0.0.1:1215/search/add
查询
http://127.0.0.1:1215/search/query?a=ABCD

