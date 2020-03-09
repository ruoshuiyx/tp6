<?php
/**
 * +----------------------------------------------------------------------
 * | 菜单规则模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/03/08
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
namespace app\common\model;

// 引入框架内置类
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;

class AuthRule extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select()
            ->toArray();
        $list = tree($list);
        foreach ($list as $k => $v) {
            $list[$k]['title'] = $v['ltitle'];
            $list[$k]['icon'] =  $v['icon'] ? "<i class=\"{$v['icon']}\"></i>" : '';
        }

        // 渲染输出
        $result = [
            'total' => count($list),
            'per_page' => 10000,
            'current_page' => 1,
            'last_page' => 1,
            'data' => $list,
        ];
        return MakeBuilder::changeTableData($result, 'AuthRule');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            
        }
        return MakeBuilder::changeTableData($list, 'AuthRule');
    }

    // 获取父ID选项信息
    public static function getPidOptions($order = ['sort', 'id' => 'desc'])
    {
        $list = self::order($order)
            ->select()
            ->toArray();
        $list = tree($list);
        $result = [];
        foreach ($list as $k => $v) {
            $result[$v['id']] = $v['ltitle'];
        }
        return $result;
    }

}