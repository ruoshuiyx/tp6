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
 *                .::::::::::               | DATETIME: 2019/03/29
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
use think\Db;
use think\facade\Request;
//实例化默认模型
use app\admin\model\AdminLog as M;
use think\facade\Session;

class AdminLog extends Base
{
    //列表
    public function index(){
        //条件筛选
        $keyword = Request::param('keyword');
        $this->view->assign('keyword',$keyword);
        //全局查询条件
        $where=[];
        if(!empty($keyword)){
            $where[]=['username|url', 'like', '%'.$keyword.'%'];
        }
        //非超级管理员只能查看自己的日志
        if(Session::get('admin.id')>1){
            $where[]=['admin_id', '=', Session::get('admin.id')];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : config('page_size');
        $this->view->assign('pageSize', page_size($pageSize));

        //调取列表
        $list = M::where($where)
            ->order('id DESC')
            ->paginate($pageSize,false,['query' => request()->param()]);
        foreach($list as $k=>$v){
            $useragent = explode('(',$v['useragent']);
            $list[$k]['useragent']=$useragent[0];
        }
        $page = $list->render();
        $this->view->assign('page' , $page);
        $this->view->assign('list' , $list);
        $this->view->assign('empty', empty_list(9));
        return $this->view->fetch();
    }

    //查看
    public function edit(){
        $id = Request::param('id');
        if( empty($id) ){
            return ['error'=>1,'msg'=>'ID不存在'];
        }
        $info = M::get($id);
        $this->view->assign('info', $info);
        return $this->view->fetch();
    }

    //删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if( empty($id) ){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            return M::del($id);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            return M::selectDel($id);
        }
    }


}
