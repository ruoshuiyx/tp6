<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

// 查找所有系统设置表数据
$system = \app\common\model\System::find(1);

return [
    // 模板路径
    'view_path'       => './template/' . $system['template'] . '/' . app('http')->getName() . '/' . $system['html'] . '/',
    // 模板文件名分隔符
    'view_depr'       => '_',
    // 自定义标签库
    'taglib_pre_load' => 'app\common\taglib\Tp',
];
