<?php
/**
 * +----------------------------------------------------------------------
 * | 权限管理控制器
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
namespace app\admin\controller;
use app\admin\model\Admin;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use think\Db;
use think\facade\Request;

class Auth extends Base
{
    /*-----------------------管理员管理----------------------*/

    //管理员列表
    public function adminList()
    {
        //条件筛选
        $username = Request::param('username');
        $this->view->assign('username',$username);
        //全局查询条件
        $where=[];
        if( !empty($username) ){
            $where[]=['a.username|a.nickname', 'like', '%'.$username.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : config('page_size');
        $this->view->assign('pageSize', page_size($pageSize));

        //查出所有数据
        $list = Db::name('admin')
            ->alias('a')
            ->leftJoin('auth_group_access ac','a.id = ac.uid')
            ->leftJoin('auth_group ag','ac.group_id = ag.id')
            ->field('a.*,ac.group_id,ag.title')
            ->where($where)
            ->paginate($pageSize,false,['query' => request()->param()]);
        $page = $list->render();
        $this->view->assign('page'  , $page);
        $this->view->assign('list'  , $list);
        $this->view->assign('empty' , empty_list(11));
        return $this->view->fetch();
    }

    //管理员添加
    public function adminAdd(){
        if(Request::isPost()){
            $data = Request::post();
            if(empty($data['group_id'])){
                $this->error('请选择用户组');
            }else{
                $group_id = $data['group_id'];
                unset($data['group_id']);
            }
            $check_user = Admin::where('username',$data['username'])->find();
            if ($check_user) {
                $this->error('用户名已存在');
            }
            //验证
            $msg = $this->validate($data,'app\admin\validate\Admin');
            if($msg!='true'){
                $this->error($msg);
            }

            //单独验证密码
            if (empty($data['password'])) {
                $this->error('密码不能为空');
            }

            $data['password'] = md5(trim($data['password']));
            $data['logintime'] = time();
            $data['loginip'] = Request::ip();
            $data['status'] = 1;
            //添加
            $result = Admin::create($data);
            if($result){
                AuthGroupAccess::create([
                    'uid'  =>  $result->id,
                    'group_id' =>  $group_id
                ]);
                $this->success('管理员添加成功', 'adminList');
            }else{
                $this->error('管理员添加失败');
            }
        }else{
            $auth_group = AuthGroup::where('status','=',1)->select();
            $this->view->assign('authGroup',$auth_group);
            $this->view->assign('info',null);
            return $this->view->fetch();
        }
    }

    //管理员删除
    public function adminDel(){
        $id = Request::post('id');
        if ($id >1){
            Admin::where('id','=',$id)->delete();
            return ['error'=>0,'msg'=>'删除成功!'];
        }else{
            return ['error'=>1,'msg'=>'超级管理员不可删除!'];
        }
    }

    //管理员批量删除
    public function adminSelectDel(){
        $id = Request::post('id');
        if($id){
            $ids = explode(',',$id);
        }
        if(in_array('1',$ids)){
            return $result = ['error'=>1,'msg'=>'超级管理员不可删除!'];
        }
        Admin::destroy($id);
        return $result = ['error'=>0,'msg'=>'删除成功!'];
    }

    //管理员状态修改
    public function adminState(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'用户ID不存在!'];
            }
            if ($id==1){
                return ['error'=>1,'msg'=>'超级管理员不可修改状态!'];
            }

            $admin = Admin::get($id);
            $status = $admin['status']==1?0:1;
            $admin->status = $status;
            $admin->save();
            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }

    //管理员修改
    public function adminEdit(){
        if(Request::isPost()){
            $data = Request::post();
            $password=$data['password'];
            $map[] = ['id','<>',$data['id']];
            $where['id'] = $data['id'];

            if ($password){
                $data['password']=input('post.password','','md5');
            }else{
                unset($data['password']);
            }

            if(empty($data['group_id'])){
                $this->error('请选择用户组');
            }else{
                $group_id = $data['group_id'];
                unset($data['group_id']);
            }

            $msg = $this->validate($data,'app\admin\validate\Admin');
            if($msg!='true'){
                $this->error($msg);
            }
            Admin::update($data,$where);
            AuthGroupAccess::update([
                'group_id' =>  $group_id
            ],['uid'=>$data['id']]);
            $this->success('管理员修改成功!','Auth/adminList');

        }else{
            if(Request::param('id')){
                $auth_group = AuthGroup::all();
                $this->assign('authGroup',$auth_group);

                $admin = Admin::get(Request::param('id'));
                $admin['group_id'] = AuthGroupAccess::where('uid',$admin['id'])->value('group_id');
                $this->view->assign('info',$admin);
                return $this->view->fetch('admin_add');
            }
        }
    }

    /*-----------------------用户组管理----------------------*/

    //用户组管理
    public function adminGroup(){
        //条件筛选
        $title = Request::param('title');
        $this->view->assign('title',$title);
        //全局查询条件
        $where=[];
        if($title){
            $where[]=['title', 'like', '%'.$title.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : config('page_size');
        $this->view->assign('pageSize', page_size($pageSize));

        //查出所有数据
        $list = AuthGroup::where($where)->paginate($pageSize,false,['query' => request()->param()]);
        $page = $list->render();
        $this->view->assign('page' , $page);
        $this->view->assign('list' ,$list);
        $this->view->assign('empty', empty_list(7));
        return $this->view->fetch();
    }

    //用户组删除
    public function groupDel(){
        $id = Request::post('id');
        if($id){
            AuthGroup::where('id','=',$id)
                ->delete();
            return ['error'=>0,'msg'=>'删除成功!'];
        }else{
            return ['error'=>1,'msg'=>'删除失败!'];
        }

    }

    //用户组添加
    public function groupAdd(){
        if(Request::isPost()){
            $data=Request::post();
            if(!$data['title']){
                $this->error('用户组不能为空');
            }
            if(AuthGroup::create($data)){
                $this->success('用户组添加成功', 'Auth/adminGroup');
            }else{
                $this->error('用户组添加失败');
            }
        }else{
            $this->view->assign('info',null);
            return $this->view->fetch();
        }
    }

    //用户组修改
    public function groupEdit(){
        if(request()->isPost()) {
            $data=Request::post();
            //防止重复
            if($data['title']){
                $map[] = ['id','<>',$data['id']];
                $map[] = ['title','=',$data['title']];
                $check_title = AuthGroup::where($map)->find();
                if ($check_title) {
                    $this->error('用户组名已存在!');
                }
            }else{
                $this->error('用户组名不能为空!');
            }

            $where['id'] = $data['id'];
            AuthGroup::update($data,$where);
            $this->success('管理员修改成功!','Auth/adminGroup');
        }else{
            $id = Request::param('id');
            $info = AuthGroup::get(['id'=>$id]);
            $this->assign('info', $info);
            return view('group_add');
        }
    }

    //用户组状态修改
    public function groupState(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = AuthGroup::get($id);
            $status = $info['status']==1?0:1;
            $info->status = $status;
            $info->save();
            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }

    //用户组批量删除
    public function groupSelectDel(){
        $id = Request::post('id');
        AuthGroup::destroy($id);
        return ['error'=>0,'msg'=>'删除成功!'];
    }

    //用户组显示权限
    public function groupAccess(){
        $admin_rule=Db::name('auth_rule')
            ->field('id,pid,title')
            ->order('sort asc')
            ->select();
        $rules = Db::name('auth_group')
            ->where('id',Request::param('id'))
            ->value('rules');
        $list = auth($admin_rule,$pid=0,$rules);
        $list[] = array(
            "id"=>0,
            "pid"=>0,
            "title"=>"全部",
            "open"=>true
        );
        $this->view->assign('list',$list);
        return $this->view->fetch();
    }

    //用户组保存权限
    public function groupSetaccess(){
        $rules = Request::post('rules');
        if(empty($rules)){
            return array('msg'=>'请选择权限!','error'=>1);
        }
        $data = Request::post();
        $where['id'] = $data['id'];
        if(AuthGroup::update($data,$where)){
            return array('msg'=>'权限配置成功!','url'=>url('adminGroup'),'error'=>0);
        }else{
            return array('msg'=>'保存错误','error'=>1);
        }
    }

    /********************************权限管理*******************************/

    //权限列表
    public function adminRule(){
        $list = Db::name('auth_rule')->order('sort ASC')->select();
        $list = tree($list);
        $this->view->assign('list', $list);
        return $this->view->fetch();
    }

    //权限菜单显示或者隐藏
    public function ruleState(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = AuthRule::get($id);
            $status = $info['status']==1?0:1;
            $info->status = $status;
            $info->save();

            return ['error'=>0,'msg'=>'修改成功'];
        }
    }

    //设置权限是否验证
    public function ruleOpen(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = AuthRule::get($id);
            $auth_open = $info['auth_open']==1?0:1;
            $info->auth_open = $auth_open;
            $info->save();

            return ['error'=>0,'msg'=>'修改成功'];
        }
    }

    //设置权限排序
    public function ruleSort(){
        if(Request::isPost()){
            $id = Request::post('id');
            $sort = Request::post('sort');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = AuthRule::get($id);
            $info->sort = $sort;
            $info->save();

            return ['error'=>0,'msg'=>'修改成功'];
        }
    }

    //权限删除
    public function ruleDel(){
        $id=Request::post('id');
        if ($id){
            AuthRule::where('id','=',input('id'))->delete();
            return ['error'=>0,'msg'=>'删除成功'];
        }
    }

    //权限批量删除
    public function ruleSelectDel(){
        $id=Request::post('id');
        if($id){
            AuthRule::destroy($id);
            return ['error'=>0,'msg'=>'删除成功'];
        }

    }

    //权限增加
    public function ruleAdd(){
        if(Request::isPost()){
            $data=Request::post();
            if(AuthRule::create($data)){
                $this->success('权限添加成功', 'Auth/adminRule');
            }else{
                $this->error('权限添加失败');
            }
        }else{
            $list = Db::name('auth_rule')
                ->order('sort ASC')
                ->select();
            $list = tree($list);
            $this->view->assign('ruleList', $list);

            $pid = Request::param('id') ? Request::param('id') : 0;
            $this->view->assign('pid',$pid);

            $this->view->assign('info',null);
            return $this->view->fetch();
        }
    }

    //权限修改
    public function ruleEdit(){
        if(request()->isPost()) {
            $data=Request::post();
            $where['id'] = $data['id'];
            AuthRule::update($data,$where);
            $this->success('权限修改成功!','Auth/adminRule');
        }else{
            $list = Db::name('auth_rule')
                ->order('sort ASC')
                ->select();
            $list = tree($list);
            $this->view->assign('ruleList', $list);

            $id = Request::param('id');
            $info = AuthRule::get(['id'=>$id]);
            $this->view->assign('info', $info);
            return $this->view->fetch('rule_add');
        }
    }


}
