<?php
/**
 * +----------------------------------------------------------------------
 * | 权限管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/03/27
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
namespace app\admin\controller;

use app\admin\model\Admin;
use app\common\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Auth extends Base
{
    /*-----------------------管理员管理----------------------*/
        // 管理员列表
    public function adminList()
    {
        //全局查询条件
        $where = [];

        $username = Request::param('username');
        if (!empty($username)) {
            $where[] = ['a.username|a.nickname', 'like', '%'.$username.'%'];
        }

        //显示数量
        $pageSize = Request::param('page_size', Config::get('app.page_size'));

        //查出所有数据
        $list = Db::name('admin')
            ->alias('a')
            ->leftJoin('auth_group_access ac', 'a.id = ac.uid')
            ->leftJoin('auth_group ag', 'ac.group_id = ag.id')
            ->field('a.*, ac.group_id, ag.title')
            ->where($where)
            ->paginate($pageSize, false, ['query' => request()->get()]);

        $view = [
            'username' => $username,
            'pageSize' => page_size($pageSize, $list->total()),
            'page'     => $list->render(),
            'list'     => $list,
            'empty'    => empty_list(11),
        ];
        View::assign($view);
        return View::fetch('admin_list');
    }

        // 管理员添加
    public function adminAdd(){
        if(Request::isPost()){
            $data = Request::post();
            if (empty($data['group_id'])) {
                $this->error('请选择用户组');
            } else {
                $group_id = $data['group_id'];
                unset($data['group_id']);
            }
            //单独验证密码
            if (empty($data['password'])) {
                $this->error('密码不能为空');
            }
            //验证
            $result = $this->validate($data, 'Admin');
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            }

            $data['password']   = md5(trim($data['password']));
            $data['login_time'] = time();
            $data['login_ip']   = Request::ip();
            //添加
            $result = Admin::create($data);
            if ($result) {
                AuthGroupAccess::create([
                    'uid'      =>  $result->id,
                    'group_id' =>  $group_id
                ]);
                $this->success('管理员添加成功', 'adminList');
            } else {
                $this->error('管理员添加失败');
            }
        } else {
            $auth_group = AuthGroup::where('status','=',1)
                ->select();
            $view = [
                'authGroup' => $auth_group,
                'info'      => null
            ];
            View::assign($view);
            return View::fetch('admin_add');
        }
    }

       // 管理员删除
    public function adminDel(){
        $id = Request::post('id');
        if ($id >1) {
            Admin::destroy($id);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        } else {
            return json(['error'=>1, 'msg'=>'超级管理员不可删除!']);
        }
    }

       // 管理员批量删除
    public function adminSelectDel(){
        $id = Request::post('id');
        if ($id) {
            $ids = explode(',', $id);
        }
        if (in_array('1',$ids)) {
            return json(['error'=>1, 'msg'=>'超级管理员不可删除!']);
        }
        Admin::destroy($id);
        return json(['error'=>0, 'msg'=>'删除成功!']);
    }

    // 管理员状态修改
    public function adminState(){
        if (Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                return json(['error'=>1, 'msg'=>'用户ID不存在!']);
            }
            if ($id==1) {
                return json(['error'=>1, 'msg'=>'超级管理员不可修改状态!']);
            }

            $admin = Admin::find($id);
            $status = $admin['status'] == 1 ? 0 : 1;
            $admin->status = $status;
            $admin->save();
            return json(['error'=>0, 'msg'=>'修改成功!']);
        }
    }

        // 管理员修改
    public function adminEdit(){
        if (Request::isPost()) {
            $data = Request::post();
            $password = $data['password'];
            $map[] = ['id','<>',$data['id']];
            $where['id'] = $data['id'];

            $group_id = $data['group_id'];
            unset($data['group_id']);

            $result = $this->validate($data,'Admin');
            if (true !== $result) {
                $this->error($result);
            }

            if ($password) {
                $data['password'] = input('post.password','','md5');
            }else{
                unset($data['password']);
            }

            Admin::update($data, $where);
            AuthGroupAccess::update([
                'group_id' =>  $group_id
            ], ['uid'=>$data['id']]);
            $this->success('管理员修改成功!', 'Auth/adminList');

        } else {
            if (Request::param('id')) {
                $auth_group = AuthGroup::select();
                $admin = Admin::find(Request::param('id'));
                $admin['group_id'] = AuthGroupAccess::where('uid', $admin['id'])
                    ->value('group_id');

                $view = [
                    'info'      => $admin,
                    'authGroup' => $auth_group,
                ];
                View::assign($view);
                return View::fetch('admin_add');
            }
        }
    }

    /*-----------------------用户组管理----------------------*/

        // 用户组管理
    public function adminGroup(){

        //条件筛选
        $title = Request::param('title');
        //全局查询条件
        $where = [];
        if ($title) {
            $where[] = ['title', 'like', '%'.$title.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size', Config::get('app.page_size'));

        //查出所有数据
        $list = AuthGroup::where($where)
            ->paginate($pageSize, false, ['query' => request()->get()]);

        $view = [
            'title'    => $title,
            'pageSize' => page_size($pageSize, $list->total()),
            'page'     => $list->render(),
            'list'     => $list,
            'empty'    => empty_list(7),
        ];
        View::assign($view);
        return View::fetch('admin_group');

    }

        // 用户组删除
    public function groupDel(){
        $id = Request::post('id');
        if ($id>1) {
            AuthGroup::destroy($id);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        }else{
            return json(['error'=>1, 'msg'=>'超级管理员组不可删除!']);
        }

    }

        // 用户组添加
    public function groupAdd(){
        if (Request::isPost()) {
            $data = Request::post();
            $result = $this->validate($data, 'AuthGroup');
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $result = AuthGroup::create($data);
                if ($result) {
                    $this->success('用户组添加成功', 'Auth/adminGroup');
                } else {
                    $this->error('用户组添加失败');
                }
            }
        } else {
            $view = [
                'info' => null
            ];
            View::assign($view);
            return View::fetch('group_add');
        }
    }

        // 用户组修改
    public function groupEdit(){
        if (Request::isPost()) {
            $data = Request::post();
            $result = $this->validate($data, 'AuthGroup');
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $where['id'] = $data['id'];
                AuthGroup::update($data, $where);
                $this->success('修改成功!', 'Auth/adminGroup');
            }
        } else {
            $id = Request::param('id');
            $info = AuthGroup::find(['id'=>$id]);
            $view = [
                'info' => $info
            ];
            View::assign($view);
            return View::fetch('group_add');
        }
    }

        // 用户组状态修改
    public function groupState(){
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthGroup::find($id);
            $info->status = $info['status'] == 1 ? 0 : 1;
            $info->save();
            return json(['error'=>0, 'msg'=>'修改成功!']);
        }
    }

        // 用户组批量删除
    public function groupSelectDel(){
        $id = Request::post('id');
        if ($id>1) {
            AuthGroup::destroy($id);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        } else {
            return json(['error'=>1, 'msg'=>'超级管理员组不可删除!']);
        }
    }




    /********************************权限管理*******************************/
        // 权限列表
    public function adminRule(){
        $list = Db::name('auth_rule')
            ->order('sort asc')
            ->select();
        $list = tree($list);
        $view = [
            'list' => $list
        ];
        View::assign($view);
        return View::fetch('admin_rule');
    }

    // 权限菜单显示或者隐藏
    public function ruleState(){
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthRule::find($id);
            $info->status = $info['status'] == 1 ? 0 : 1;
            $info->save();
            return json(['error'=>0, 'msg'=>'修改成功']);
        }
    }

    // 设置权限是否验证
    public function ruleOpen(){
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthRule::find($id);
            $info->auth_open = $info['auth_open'] == 1 ? 0 : 1;
            $info->save();
            return json(['error'=>0, 'msg'=>'修改成功']);
        }
    }

    // 设置权限排序
    public function ruleSort(){
        if (Request::isPost()) {
            $id = Request::param('id');
            $sort = Request::param('sort');
            $info = AuthRule::find($id);
            $info->sort = $sort;
            $info->save();
            return json(['error'=>0, 'msg'=>'修改成功']);
        }
    }

    // 权限删除
    public function ruleDel(){
        $id = Request::param('id');
        if ($id) {
            AuthRule::destroy($id);
            return json(['error'=>0, 'msg'=>'删除成功']);
        }
    }

    // 权限批量删除
    public function ruleSelectDel(){
        $id = Request::param('id');
        if ($id) {
            AuthRule::destroy($id);
            return json(['error'=>0, 'msg'=>'删除成功']);
        }

    }

    // 权限增加
    public function ruleAdd(){
        if (Request::isPost()) {
            $data = Request::post();
            if (empty($data['title'])) {
                $this->error('权限名称不可为空');
            }
            if (empty($data['sort'])) {
                $this->error('排序不可为空');
            }
            if (AuthRule::create($data)) {
                $this->success('权限添加成功', 'Auth/adminRule');
            } else {
                $this->error('权限添加失败');
            }
        } else {
            $list = Db::name('auth_rule')
                ->order('sort ASC')
                ->select();
            $list = tree($list);
            $pid = Request::param('id') ? Request::param('id') : 0;
            $view =[
                'info'     => null,
                'pid'      => $pid,
                'ruleList' => $list
            ];
            View::assign($view);
            return View::fetch('rule_add');
        }
    }

    //权限修改
    public function ruleEdit(){
        if (request()->isPost()) {
            $data = Request::param();
            $where['id'] = $data['id'];
            AuthRule::update($data, $where);
            $this->success('修改成功!','Auth/adminRule');
        } else {
            $list = Db::name('auth_rule')
                ->order('sort asc')
                ->select();
            $list = tree($list);
            $id = Request::param('id');
            $info = AuthRule::find($id);
            $view = [
                'info'     => $info,
                'ruleList' => $list,
            ];
            View::assign($view);
            return View::fetch('rule_add');
        }
    }


}
