<?php
/**
 * +----------------------------------------------------------------------
 * | 模型管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2020/01/16
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

class Module extends Base
{
    // 验证器
    protected $validate = 'Module';

    // 当前主表
    protected $tableName = 'module';

    // 当前主模型
    protected $moduleName = 'Module';

    // 列表
    public function index(){
        // 获取主键
        $pk = MakeBuilder::getPrimarykey($this->tableName);
        // 获取列表数据
        $coloumns = MakeBuilder::getListColumns($this->tableName);
        // 获取搜索数据
        $search = MakeBuilder::getListSearch($this->tableName);
        // 搜索
        if (Request::param('getList') == 1) {
            $where = MakeBuilder::getListWhere($this->tableName);
            $orderByColumn = Request::param('orderByColumn') ?? $pk;
            $isAsc = Request::param('isAsc') ?? 'desc';
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::getList($where, $this->pageSize, [$orderByColumn => $isAsc]);
        }
        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                                         // 设置主键
            ->addColumns($coloumns)                                    // 添加列表字段数据
            ->setSearch($search)                                       // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')                 // 启用右侧操作列
            ->addRightButtons(['edit', 'delete'])                      // 设置右侧操作列
            ->addTopButtons(['add', 'edit', 'del', 'export', 'build']) // 设置顶部按钮组
            ->addTopButton('default', [
                'title'       => '生成菜单规则',
                'icon'        => 'fa fa-bars',
                'class'       => 'btn btn-danger single disabled',
                'href'        => '',
                'onclick'     => '$.operate.makeRule(\'' . url('makeRule') . '\')'
            ]) // 自定义按钮
            ->fetch();
    }

    // 添加
    public function add()
    {
        // 获取字段信息
        $coloumns = MakeBuilder::getAddColumns($this->tableName);
        // 构建页面
        return FormBuilder::getInstance()
            ->addFormItems($coloumns)
            ->fetch();
    }

    // 添加保存
    public function addPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model = '\app\common\model\\' . $this->moduleName;
                $result = $model::addPost($data);
                if ($result['error']) {
                    $this->error($result['msg']);
                } else {
                    \app\common\model\Module::makeModule($data['table_name']);
                    $this->success($result['msg'], 'index');
                }
            }
        }
    }

    // 修改
    public function edit(string $id)
    {
        $model = '\app\common\model\\' . $this->moduleName;
        $info = $model::edit($id)->toArray();
        // 获取字段信息
        $coloumns = MakeBuilder::getAddColumns($this->tableName, $info);
        // 构建页面
        return FormBuilder::getInstance()
            ->addFormItems($coloumns)
            ->fetch();
    }

    // 修改保存
    public function editPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model = '\app\common\model\\' . $this->moduleName;
                $result = $model::editPost($data);
                if ($result['error']) {
                    $this->error($result['msg']);
                } else {
                    $this->success($result['msg'], 'index');
                }
            }
        }
    }

    // 删除
    public function del(string $id)
    {
        if (Request::isPost()) {
            if (strpos($id, ',') !== false) {
                return $this->selectDel($id);
            }
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::del($id);
        }
    }

    // 批量删除
    public function selectDel(string $id){
        if (Request::isPost()) {
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::selectDel($id);
        }
    }

    // 排序
    public function sort()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::sort($data);
        }
    }

    // 状态变更
    public function state(string $id)
    {
        if (Request::isPost()) {
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::state($id);
        }
    }

    // 导出
    public function export()
    {
        \app\common\model\Base::export($this->tableName, $this->moduleName);
    }

    // ==========================

    // 生成代码
    public function build(string $id)
    {
        return MakeBuilder::makeModule($id);
    }

    // 生成菜单
    public function makeRule(string $id)
    {
        return MakeBuilder::makeRule($id);
    }

}
