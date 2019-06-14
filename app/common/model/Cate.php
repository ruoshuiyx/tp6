<?php
/**
 * +----------------------------------------------------------------------
 * | 栏目模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/27
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

class Cate extends Base
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 一对一获取所属模型
    public function module()
    {
        return $this->belongsTo('Module','moduleid');
    }

    // 获取列表
    public static function getList($where = array(), $order = ['sort', 'id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            $v['modulename'] = $v->module->getData('title');
            $v['moduleurl']  = $v->module->getData('name');
        }
        return $list;
    }
}