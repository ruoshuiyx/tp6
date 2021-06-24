<?php
/**
 * +----------------------------------------------------------------------
 * | 角色组管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/02/02
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
use think\facade\View;

class AuthGroup extends Base
{
    // 验证器
    protected $validate = 'AuthGroup';

    // 当前主表
    protected $tableName = 'auth_group';

    // 当前主模型
    protected $modelName = 'AuthGroup';

    // 列表
    public function index()
    {
        // 获取主键
        $pk = MakeBuilder::getPrimarykey($this->tableName);
        // 获取列表数据
        $coloumns = MakeBuilder::getListColumns($this->tableName);
        // 获取搜索数据
        $search = MakeBuilder::getListSearch($this->tableName);
        // 获取当前模块信息
        $model  = '\app\common\model\\' . $this->modelName;
        $module = \app\common\model\Module::where('table_name', $this->tableName)->find();
        // 搜索
        if (Request::param('getList') == 1) {
            $where         = MakeBuilder::getListWhere($this->tableName);
            $orderByColumn = Request::param('orderByColumn') ?? $pk;
            $isAsc         = Request::param('isAsc') ?? 'desc';
            return $model::getList($where, $this->pageSize, [$orderByColumn => $isAsc]);
        }
        // 检测单页模式
        $isSingle = MakeBuilder::checkSingle($this->modelName);
        if ($isSingle) {
            return $this->jump($isSingle);
        }
        // 获取新增地址
        $addUlr = MakeBuilder::getAddUrl($this->tableName);
        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                              // 设置主键
            ->addColumns($coloumns)                         // 添加列表字段数据
            ->setSearch($search)                            // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')      // 启用右侧操作列
            ->addRightButton('info', [
                'title' => '权限',
                'icon'  => 'far fa-check-square',
                'class' => 'btn btn-warning btn-xs confirm',
                'href'  => url('access', ['id' => '__id__'])
            ]) // 添加额外按钮
            ->addRightButtons($module->right_button)        // 设置右侧操作列
            ->addTopButtons($module->top_button)            // 设置顶部按钮组
            ->setAddUrl($addUlr)                            // 设置新增地址
            ->fetch();
    }

    //===================================

    // 权限
    public function access(string $id)
    {
        // 获取菜单规则
        $authRule = \app\common\model\AuthRule::field('id, pid, title')
            ->order('sort asc')
            ->select()
            ->toArray();
        // 获取当前组权限并格式化
        $rules  = \app\common\model\AuthGroup::where('id', $id)->value('rules');
        $list   = auth($authRule, 0, $rules);
        $list[] = array(
            "id"    => 0,
            "pid"   => 0,
            "title" => "全部",
            "open"  => true
        );
        $view   = [
            'list' => $list
        ];
        View::assign($view);
        return View::fetch('auth/group_access');
    }

    // 权限保存
    public function accessPost()
    {
        $rules = Request::post('rules');
        if (empty($rules)) {
            return json(['msg' => '请选择权限!', 'error' => 1]);
        }
        $data        = Request::post();
        $where['id'] = $data['id'];
        if (\app\common\model\AuthGroup::update($data, $where)) {
            return json(['msg' => '修改成功!', 'url' => url('index')->__toString(), 'error' => 0]);
        } else {
            return json(['msg' => '修改失败', 'error' => 1]);
        }
    }
}
