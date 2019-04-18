<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员日志控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/04
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

use app\admin\model\AdminLog as M;

use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class AdminLog extends Base
{
    //列表
    public function index(){
        //条件筛选
        $keyword = Request::param('keyword');
        //全局查询条件
        $where=[];
        if(!empty($keyword)){
            $where[]=['username|title', 'like', '%'.$keyword.'%'];
        }
        //非超级管理员只能查看自己的日志
        if(Session::get('admin.id')>1){
            $where[]=['admin_id', '=', Session::get('admin.id')];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : Config::get('app.page_size');

        //调取列表
        $list = M::where($where)
            ->order('id DESC')
            ->paginate($pageSize,false,['query' => request()->param()]);
        foreach($list as $k=>$v){
            $useragent = explode('(',$v['useragent']);
            $list[$k]['useragent']=$useragent[0];
        }

        $view = [
            'keyword'=>$keyword,
            'pageSize' => page_size($pageSize,$list->total()),
            'page' => $list->render(),
            'list' => $list,
            'empty'=> empty_list(9),
        ];
        View::assign($view);
        return View::fetch();
    }

    //查看
    public function edit(){
        $id = Request::param('id');
        $info = M::find($id);
        $view =[
            'info'   => $info,
        ];
        View::assign($view);
        return View::fetch();
    }

    //删除
    public function del(){
        $id = Request::param('id');
        M::destroy($id);
        return json(['error'=>0,'msg'=>'删除成功!']);
    }

    //批量删除
    public function selectDel(){
        $id = Request::param('id');
        M::destroy($id);
        return json(['error'=>0,'msg'=>'删除成功!']);
    }


}
