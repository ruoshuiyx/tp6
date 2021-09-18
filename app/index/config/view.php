<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

// 查找所有系统设置表数据
$system = \app\common\model\System::find(1);

return [
    // 模板路径
    'view_path'       => public_path() . 'template' . DIRECTORY_SEPARATOR . $system['template'] . DIRECTORY_SEPARATOR . app('http')->getName() . DIRECTORY_SEPARATOR . $system['html'] . DIRECTORY_SEPARATOR,
    // 模板文件名分隔符
    'view_depr'       => '_',
    // 自定义标签库
    'taglib_pre_load' => 'app\common\taglib\Tp',
];
