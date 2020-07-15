<?php
/**
 * +----------------------------------------------------------------------
 * | 模型管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2020/01/16
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
            ->setExtraJs($this->getAddExtraJs()) // 设置额外JS
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
                    $makeModule = \app\common\model\Module::makeModule($data['table_name'], $data['table_type']);
                    if($makeModule === true){
                        $this->success($result['msg'], 'index');
                    } else {
                        $this->error($makeModule);
                    }
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
            ->setExtraJs($this->getEditExtraJs()) // 设置额外JS
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
            // 当有栏目使用该模块时不可删除
            if ($this->checkCate($id) == false) {
                return ['error' => 1, 'msg' => '删除失败，请先删除已使用该模块的栏目'];
            }
            // 模块删除的同时删除字段管理中对应的数据
            $this->delModuleField($id);
            // 是否清空表[不删除]
            // 是否删除模型、控制器、验证器文件[不删除]

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

    /**
     * 删除模块时判断是否已有栏目在应用[兼容多选和单选]
     * @param $id 模块id
     * @return bool false 不可删除，true 可删除
     */
    private function checkCate(string $id)
    {
        strpos($id, ',') !== false ? $op = 'in' : $op = '=';
        $count = \app\common\model\Cate::where('module_id', $op, $id)->count();
        if ($count) {
            return false;
        }
        return true;
    }

    /**
     * 删除模型时删除当前模型的所有字段数据[兼容多选和单选]
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    private function delModuleField(string $id)
    {
        strpos($id, ',') !== false ? $op = 'in' : $op = '=';
        return \app\common\model\Field::where('module_id', $op, $id)->delete();
    }

    // 添加页额外JS
    private function getAddExtraJs()
    {
        $js = '<script type="text/javascript">
                $(function () {
                    // 添加默认隐藏预览按钮
                    $("input[name=\'right_button[]\']").each(function(){
                        var value = $(this).val();
                        if(value == \'preview\'){
                            $(this).parent(\'.dd_radio_lable\').hide();
                        }
                    });
                    // 切换表类型为CMS时显示预览按钮
                    $("select[name=\'table_type\']").change(function(){
                        var value = $(this).val();
                        if(value == \'1\'){
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    $(this).attr("checked",true);
                                    $(this).parent(\'.dd_radio_lable\').show();
                                }
                            });
                        } else {
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    $(this).attr("checked",false);
                                    $(this).parent(\'.dd_radio_lable\').hide();
                                }
                            });
                        }
                    })
                })
            </script>';
        return $js;
    }

    // 编辑页额外JS
    private function getEditExtraJs()
    {
        $js = '<script type="text/javascript">
                $(function () {
                    // 添加默认隐藏预览按钮
                    if($("select[name=\'table_type\']").val() != "1"){
                        $("input[name=\'right_button[]\']").each(function(){
                            var value = $(this).val();
                            if(value == \'preview\'){
                                $(this).parent(\'.dd_radio_lable\').hide();
                            }
                        });
                    }

                    // 切换表类型为CMS时显示预览按钮
                    $("select[name=\'table_type\']").change(function(){
                        var value = $(this).val();
                        if(value == \'1\'){
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    //$(this).attr("checked",true);
                                    $(this).parent(\'.dd_radio_lable\').show();
                                }
                            });
                        } else {
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    $(this).attr("checked",false);
                                    $(this).parent(\'.dd_radio_lable\').hide();
                                }
                            });
                        }
                    })
                })
            </script>';
        return $js;
    }

}
