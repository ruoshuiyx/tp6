<?php
/**
 * +----------------------------------------------------------------------
 * | 标签列表模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/06/21
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

use think\facade\Request;

class Tags extends Base
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 一对一获取所属模型
    public function module()
    {
        return $this->belongsTo('module', 'module_id');
    }

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate($pageSize, false, ['query' => Request::get()]);
        foreach ($list as $k => $v) {
            $v['module_name'] = $v->module->getData('name');
            $v['module_title'] = $v->module->getData('title');
        }
        return $list;
    }

}