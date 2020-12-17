<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 默认分页显示数量
    'page_size'             => 10,
    // 版本信息
    'siyu_version'          => '6.1.6',
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl' => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'   => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
];
