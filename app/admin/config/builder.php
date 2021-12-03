<?php
// +----------------------------------------------------------------------
// | 构建器设置
// +----------------------------------------------------------------------

return [
    // CMS模块添加字段时是否需要自动增加栏目ID等字段
    'add_cate_id'    => true,
    // select2 插件是否启用ajax分页
    'select2_ajax'   => true,
    // 添加/编辑等页启用layer弹层加载
    'layer_open'     => env('builder.layer_open', true),
    // 不可生成的模块[内置模块][模型名称]
    'un_make_module' => [
        'Field',     // 字段
        'Module',    // 模型
        'AuthGroup', // 角色组
        'Admin',     // 管理员
        'AuthRule',  // 菜单规则
        'AdminLog',  // 管理员日志
        'Cate',      // 栏目管理
    ],
];
