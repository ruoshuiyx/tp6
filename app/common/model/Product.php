<?php
/**
 * +----------------------------------------------------------------------
 * | 产品模块模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2021/06/23
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

class Product extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    
    
    public function cate()
    {
        return $this->belongsTo('Cate', 'cate_id');
    }
    public function usersType()
    {
        return $this->belongsTo('UsersType', 'view_auth');
    }
    

    // 获取列表
    public static function getList($where, $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query'     => Request::get(),
                'list_rows' => $pageSize,
            ]);
        foreach ($list as $k => $v) {
            if ($list[$k]['cate_id']) {
                $v['cate_id'] = $v->cate->getData('cate_name');
            }
            if ($list[$k]['view_auth']) {
                $v['view_auth'] = $v->usersType->getData('name');
            }
            
        }
        return MakeBuilder::changeTableData($list, 'Product');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            if ($list[$k]['cate_id']) {
                $v['cate_id'] = $v->cate->getData('cate_name');
            }
            if ($list[$k]['view_auth']) {
                $v['view_auth'] = $v->usersType->getData('name');
            }
            
        }
        return MakeBuilder::changeTableData($list, 'Product');
    }

}