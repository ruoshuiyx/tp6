<?php
/**
 * +----------------------------------------------------------------------
 * | 内容管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/05/20
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
namespace app\admin\controller;

use app\common\model\Cate;
use app\common\model\Module;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Content extends Base
{
    //内容首页
    public function index(){
        //默认信息
        if(Request::param('type')=='main'){
            //查询栏目数量
            $cateNum = Cate::count();
            //查询模型数量
            $moduleNum = Module::count();
            //查询文章模型内容数量
            $articleNum = Db::name('article')->count();
            //查询产品模型内容数量
            $productNum = Db::name('product')->count();

            $view = [
                'cateNum' => $cateNum,
                'moduleNum' => $moduleNum,
                'articleNum' => $articleNum,
                'productNum' => $productNum,
            ];
            View::assign($view);

            return View::fetch('main');
        }

        //获取栏目列表
        $cate = Cate::getList([],$this->pageSize);
        $cate = tree_cate($cate);
        //halt($cate);
        $view = [
            'list' => $cate,
            'empty'=> empty_list(8),
        ];
        View::assign($view);
        return View::fetch();
    }

}
