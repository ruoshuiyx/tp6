<?php
/**
 * +----------------------------------------------------------------------
 * | 栏目管理模型
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

class Cate extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    public function module()
    {
        return $this->belongsTo('Module', 'module_id');
    }

    // 获取列表
    public static function getList($order = ['sort', 'id' => 'desc'])
    {
        $list = self::order($order)
            ->select();
        foreach ($list as $k => $v) {
            if ($list[$k]['module_id']) {
                $v['module_id'] = $v->module->getData('module_name');
            }
        }
        $list = tree_cate($list->toArray());
        // 重设栏目名称
        foreach($list as &$ls){
            $ls['cate_name'] = $ls['l_cate_name'];
        }
        // 渲染输出
        $result = [
            'total' => count($list),
            'per_page' => 10000,
            'current_page' => 1,
            'last_page' => 1,
            'data' => $list,
        ];
        return MakeBuilder::changeTableData($result, 'Cate');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            if ($list[$k]['module_id']) {
                $v['module_id'] = $v->module->getData('module_name');
            }
        }
        return MakeBuilder::changeTableData($list, 'Cate');
    }

    // 获取父ID选项信息
    public static function getPidOptions($order = ['sort', 'id' => 'desc'])
    {
        $list = self::order($order)
            ->select()
            ->toArray();
        $list = tree_cate($list);
        $result = [];
        foreach ($list as $k => $v) {
            $result[$v['id']] = $v['l_cate_name'];
        }
        return $result;
    }
}