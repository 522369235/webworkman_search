<?php

declare(strict_types=1);

$app->HandleFunc("/", function () {
    $data = array(
        "ret" => 0,
        "data" => "欢迎使用"
    );
    $this->ServerJson($data);
});

$app->HandleFunc("/hello", function () {
    $test_model = new Test_models($this);
    $data = $test_model->getall();
    $this->ServerJson($data);
});

$app->HandleFunc("/test", function () {

    $result = array();

    $sql = "select * from test limit 1";
    //取一行对象结果集
    $result['data1'] = $this->db->query($sql)->row();
    //取一行数组结果集
    $result['data2'] = $this->db->query($sql)->row_array();
    //取多行对象结果集
    $result['data3'] = $this->db->query($sql)->result();
    //取多行数组结果集
    $result['data4'] = $this->db->query($sql)->result_array();
    //取多行，自动转义参数
    $result['data5'] = $this->db->query("select * from test where id = ? or id =? ", array(1, 2))->result_array();
    //取表test中的一行数据
    $result['data6'] = $this->db->get("test", 0, 1)->row_array();
    //取表中id=22的一行数据
    $result['data7'] = $this->db->get_where("test", array("id" => 22), 0, 1)->row_array();
    //向表test插入数据
    $result['data8'] = $this->db->insert("test", array("name" => time()));
    //更新表test中的id=1的数据
    $result['data9'] = $this->db->update("test", array("name" => time()), array("id" => 1));
    //删除表test中的id=2的数据
    $result['data10'] = $this->db->delete("test", array("id" => 2));

    $this->ServerJson($result);
});

$app->on404  = function () {
    $this->ServerHtml("我的404");
};
