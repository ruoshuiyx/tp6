<?php
/**
 * +----------------------------------------------------------------------
 * | 模块管理验证器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2019/05/25
 *             '::::::::::::'
 *                .::::::::::
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 * +----------------------------------------------------------------------
 */
namespace app\admin\validate;

use think\Validate;

class Module extends Validate
{
    protected $rule = [
        'module_name|模块名称' => [
            'require' => 'require',
            'max'     => '100',
        ],
        'table_name|表名称' => [
            'require' => 'require',
            'max'     => '50',
        ],
        'model_name|模型名称' => [
            'require' => 'require',
            'max'     => '50',
        ],
        'table_comment|表描述' => [
            'max'     => '200',
        ],
        'table_type|表类型' => [
            'require' => 'require',
            'max'     => '10',
        ],
        'pk|主键' => [
            'require' => 'require',
            'max'     => '50',
        ],
        'sort|排序' => [
            'require' => 'require',
            'number'  => 'number',
            'max'     => '3',
        ]
    ];

}