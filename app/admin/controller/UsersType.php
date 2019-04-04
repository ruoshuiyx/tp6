<?php
/**
 * +----------------------------------------------------------------------
 * | 会员组控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/06
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
use think\facade\Request;

//实例化默认模型
use app\common\model\UsersType as M;

class UsersType extends Base
{
    protected $validate = 'UsersType';

    //列表
    public function index()
    {
        //条件筛选
        $keyword = Request::param('keyword');
        $this->view->assign('keyword',$keyword);
        //全局查询条件
        $where=[];
        if(!empty($keyword)){
            $where[]=['name|description', 'like', '%'.$keyword.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : config('page_size');
        $this->view->assign('pageSize', page_size($pageSize));
        //调取列表
        $list = M::where($where)->order('sort ASC,id DESC')->paginate($pageSize,false,['query' => request()->param()]);
        $page = $list->render();
        $this->view->assign('page', $page);
        $this->view->assign('list',$list);

        $empty = empty_list(9);
        $this->view->assign('empty', $empty);
        return $this->view->fetch();
    }

    //添加
    public function add(){
        $this->view->assign('info',null);
        return $this->view->fetch();
    }

    //添加保存
    public function addPost(){
        $data = Request::param();
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        }else{
            $m = new M();
            $result =  $m->addPost($data);
            if($result['error']){
                $this->error($result['msg']);
            }else{
                $this->success($result['msg'],'index');
            }
        }
    }

    //修改
    public function edit(){
        $id = Request::param('id');
        if( empty($id) ){
            return ['error'=>1,'msg'=>'ID不存在'];
        }
        $m = new M();
        $info = $m->edit($id);
        $this->view->assign('info', $info);
        return $this->view->fetch('add');
    }

    //修改保存
    public function editPost(){
        $data = Request::param();
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        }else{
            $m = new M();
            $result =  $m->editPost($data);
            if($result['error']){
                $this->error($result['msg']);
            }else{
                $this->success($result['msg'],'index');
            }
        }
    }

    //删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if( empty($id) ){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->del($id);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->selectDel($id);
        }

    }

    //排序
    public function sort(){
        if(Request::isPost()){
            $data = Request::param();
            if (empty($data['id'])){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->sort($data);
        }
    }

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->state($id);
        }


    }

}
