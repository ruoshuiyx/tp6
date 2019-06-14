<?php

namespace app\admin\controller;

use app\admin\model\Admin;

class Test
{

    //列表
    public function index()
    {
        $sql = Admin::where('username','=','ADMIN')->fetchSql(true)->find();
        echo $sql.'<br>';

        $result = Admin::where('username','=','ADMIN')->find()->toArray();
        dump($result);
        //halt(Request::param());
    }


}
