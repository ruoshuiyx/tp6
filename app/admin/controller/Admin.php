<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员列表控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/02/03
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
namespace app\admin\controller;

// 引入框架内置类
use think\facade\Request;

// 引入表格和表单构建器
use app\common\facade\MakeBuilder;
use app\common\builder\FormBuilder;
use app\common\builder\TableBuilder;
use think\facade\Session;

class Admin extends Base
{
    // 验证器
    protected $validate = 'Admin';

    // 当前主表
    protected $tableName = 'admin';

    // 当前主模型
    protected $modelName = 'Admin';

    // 列表
    public function index(){
        // 获取主键
        $pk = MakeBuilder::getPrimarykey($this->tableName);
        // 获取列表数据
        $coloumns = MakeBuilder::getListColumns($this->tableName);
        // 插入`角色组`字段到第1个元素
        array_splice($coloumns, 1, 0, [['group_name','角色组','text','',[],'','false']]);
        // 获取搜索数据
        $search = MakeBuilder::getListSearch($this->tableName);
        // 获取当前模块信息
        $model = '\app\common\model\\' . $this->modelName;
        $module = \app\common\model\Module::where('table_name', $this->tableName)->find();
        // 搜索
        if (Request::param('getList') == 1) {
            $where = MakeBuilder::getListWhere($this->tableName);
            $orderByColumn = Request::param('orderByColumn') ?? $pk;
            $isAsc = Request::param('isAsc') ?? 'desc';
            return $model::getList($where, $this->pageSize, [$orderByColumn => $isAsc]);
        }
        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                              // 设置主键
            ->addColumns($coloumns)                         // 添加列表字段数据
            ->setSearch($search)                            // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')      // 启用右侧操作列
            ->addRightButtons($module->right_button)        // 设置右侧操作列
            ->addTopButtons($module->top_button)            // 设置顶部按钮组
            ->fetch();
    }

    // 添加
    public function add()
    {
        // 获取字段信息
        $coloumns = MakeBuilder::getAddColumns($this->tableName);
        // 获取分组后的字段信息
        $groups = MakeBuilder::getgetAddGroups($this->modelName, $this->tableName, $coloumns);

        // 构建页面
        $builder = FormBuilder::getInstance();
        $builder->addSelect('group_id', '角色组', '', $this->getAuthGroupOptions(), '', '', '', '', true);
        $groups ? $builder->addGroup($groups) : $builder->addFormItems($coloumns);
        return $builder->fetch();
    }

    // 添加保存
    public function addPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $data['group_id'] = Request::param('group_id');
            // 单独校验并去除角色组
            if (empty($data['group_id'])) {
                $this->error('请选择角色组');
            } else {
                $groupId = $data['group_id'];
                unset($data['group_id']);
            }
            //单独验证密码
            if (empty($data['password'])) {
                $this->error('密码不能为空');
            }
            $result = $this->validate($data, $this->validate);
            $data['login_time'] = time();
            $data['login_ip']   = Request::ip();
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model = '\app\common\model\\' . $this->modelName;
                $result = $model::create($data);
                \app\common\model\AuthGroupAccess::create([
                    'uid'      =>  $result->id,
                    'group_id' =>  $groupId
                ]);
                $this->success('添加成功', 'index');
            }
        }
    }

    // 修改
    public function edit(string $id)
    {
        $model = '\app\common\model\\' . $this->modelName;
        $info = $model::edit($id)->toArray();
        // 获取字段信息
        $coloumns = MakeBuilder::getAddColumns($this->tableName, $info);
        // 获取分组后的字段信息
        $groups = MakeBuilder::getgetAddGroups($this->modelName, $this->tableName, $coloumns);
        // 获取当前管理员的分组
        $groupId = \app\common\model\AuthGroupAccess::where('uid', $info['id'])
            ->value('group_id');

        // 构建页面
        $builder = FormBuilder::getInstance();
        $builder->addSelect('group_id', '角色组', '', $this->getAuthGroupOptions(), $groupId, '', '', '', true);
        $groups ? $builder->addGroup($groups) : $builder->addFormItems($coloumns);
        return $builder->fetch();
    }

    // 修改保存
    public function editPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $data['group_id'] = Request::param('group_id');
            if (!$data['group_id']) {
                $this->error('请选择角色组!');
            }

            if (Session::get('admin.group_id') != 1) {
                // 非管理员组不可修改他人信息
                if (Session::get('admin.id') != $data['id']) {
                    $this->error('非管理员组人员不可修改他人信息!', 'index');
                }
                // 非管理员组不可修改角色组
                if (Session::get('admin.group_id') != $data['group_id']) {
                    $this->error('非管理员组人员不可修改所属角色组!', 'index');
                }
            }

            $where['id'] = $data['id'];

            $group_id = $data['group_id'];
            unset($data['group_id']);

            $result = $this->validate($data,'Admin');
            if (true !== $result) {
                $this->error($result);
            }
            \app\common\model\Admin::update($data, $where);
            \app\common\model\AuthGroupAccess::update([
                'group_id' =>  $group_id
            ], ['uid'=>$data['id']]);
            $this->success('修改成功!', 'index');
        }
    }

    // 删除
    public function del(string $id)
    {
        if (Request::isPost()) {
            if ($id == 1) {
                return json(['error' => 1, 'msg' => '超级管理员不可删除!']);
            }
            if (strpos($id, ',') !== false) {
                return $this->selectDel($id);
            }
            $model = '\app\common\model\\' . $this->modelName;
            return $model::del($id);
        }
    }

    // 批量删除
    public function selectDel(string $id){
        if (Request::isPost()) {
            $ids = explode(',',$id);
            if (in_array(1, $ids)) {
                return json(['error' => 1, 'msg' => '超级管理员不可删除!']);
            }
            $model = '\app\common\model\\' . $this->modelName;
            return $model::selectDel($id);
        }
    }

    // 排序
    public function sort()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $model = '\app\common\model\\' . $this->modelName;
            return $model::sort($data);
        }
    }

    // 状态变更
    public function state(string $id)
    {
        if (Request::isPost()) {
            $model = '\app\common\model\\' . $this->modelName;
            return $model::state($id);
        }
    }

    // 导出
    public function export()
    {
        \app\common\model\Base::export($this->tableName, $this->modelName);
    }

    //===========================

    // 获取角色分组信息
    private function getAuthGroupOptions()
    {
        // 获取角色组
        $authGroup = \app\common\model\AuthGroup::where('status', '=', 1)
            ->select()
            ->toArray();
        $groupOptions = [];
        foreach ($authGroup as $k => $v) {
            $groupOptions[$v['id']] = $v['title'];
        }
        return $groupOptions;
    }

}
