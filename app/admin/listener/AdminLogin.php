<?php

namespace app\admin\listener;

use app\common\model\AdminLog;

class AdminLogin
{
    public function handle($admin)
    {
        // 事件监听处理
        AdminLog::record();
    }
}