<?php
/**
 * +----------------------------------------------------------------------
 * | 公共广告位模型
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

class Ad extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    //一对一获取所属广告位
    public function adType()
    {
        return $this->belongsTo('AdType','type_id');
    }

    //获取广告列表
    public static function getList($where=array(),$pageSize){
        $list = self::where($where)
            ->paginate($pageSize,false,['query' => Request::param()]);
        foreach($list as $k=>$v){

            $list[$k]['type_name']=$v->adType->name;
            //dump($v->adType);
            //dump($v->adType->description);
            //halt($v->adType->name);
        }

        return $list;
    }

}