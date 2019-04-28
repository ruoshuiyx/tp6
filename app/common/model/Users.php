<?php
/**
 * +----------------------------------------------------------------------
 * | 公共会员列表模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/04
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

class Users extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 一对一获取所属用户组
    public function usersType()
    {
        return $this->belongsTo('UsersType','type_id');
    }

    // 获取列表
    public static function getList($where=array(),$pageSize,$order=['sort','id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->paginate($pageSize,false,['query' => Request::param()]);
        foreach($list as $k=>$v){
            $v['type_name'] = $v->usersType['name'];
        }
        return $list;
    }

}