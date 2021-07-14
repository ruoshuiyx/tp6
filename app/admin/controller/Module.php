<?php
/**
 * +----------------------------------------------------------------------
 * | 模块管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2021/04/16
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
use think\facade\Db;
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
    protected $modelName = 'Module';

    // 列表
    public function index()
    {
        // 获取主键
        $pk = MakeBuilder::getPrimarykey($this->tableName);
        // 获取列表数据
        $columns = MakeBuilder::getListColumns($this->tableName);
        // 获取搜索数据
        $search = MakeBuilder::getListSearch($this->tableName);
        // 搜索
        if (Request::param('getList') == 1) {
            $where         = MakeBuilder::getListWhere($this->tableName);
            $orderByColumn = Request::param('orderByColumn') ?? $pk;
            $isAsc         = Request::param('isAsc') ?? 'desc';
            $model         = '\app\common\model\\' . $this->modelName;
            return $model::getList($where, $this->pageSize, [$orderByColumn => $isAsc]);
        }
        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                                         // 设置主键
            ->addColumns($columns)                                     // 添加列表字段数据
            ->setSearch($search)                                       // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')                 // 启用右侧操作列
            ->addRightButtons(['edit', 'delete'])                      // 设置右侧操作列
            ->addTopButtons(['add', 'edit', 'del', 'export', 'build']) // 设置顶部按钮组
            ->addTopButton(
                'default', [
                             'title'   => '生成菜单规则',
                             'icon'    => 'fa fa-bars',
                             'class'   => 'btn btn-danger single disabled',
                             'href'    => '',
                             'onclick' => '$.operate.makeRule(\'' . url('makeRule') . '\')'
                         ]
            )                                                          // 自定义按钮
            ->fetch();
    }

    // 添加
    public function add()
    {
        // 获取字段信息
        $columns = MakeBuilder::getAddColumns($this->tableName);
        // 提示信息
        $pageTips = '1、没有表时会创建表和字段并插入至字段管理中;<br>2、已有表时会检测必要字段后插入至字段管理中;<br>3、已有表需包含的字段：主键、create_time、update_time、[sort 勾选排序字段时]、[status 勾选状态字段时]、[cate_id, hits, keywords, description, template, url 表类型为CMS时];';
        // 构建页面
        return FormBuilder::getInstance()
            ->addFormItems($columns)
            ->setPageTips($pageTips, 'warning')  // 提示信息
            ->setExtraJs($this->getAddExtraJs()) // 设置额外JS
            ->fetch();
    }

    // 添加保存
    public function addPost()
    {
        if (Request::isPost()) {
            $data   = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model = '\app\common\model\\' . $this->modelName;
                // 唯一判断
                $count = $model::where('table_name', $data['table_name'])->count();
                if ($count) {
                    $this->error('表名称 [' . $data['table_name'] . '] 已存在');
                }
                $result = $model::addPost($data);
                if ($result['error']) {
                    $this->error($result['msg']);
                } else {
                    $makeTable = \app\common\model\Module::makeTable($data['table_name']);
                    if ($makeTable === true) {
                        $this->success($result['msg'], 'index');
                    } else {
                        // 删除刚插入的数据
                        $model::where('table_name', $data['table_name'])->delete();
                        $this->error($makeTable);
                    }
                }
            }
        }
    }

    // 修改
    public function edit(string $id)
    {
        $model = '\app\common\model\\' . $this->modelName;
        $info  = $model::edit($id)->toArray();
        // 获取字段信息
        $columns = MakeBuilder::getAddColumns($this->tableName, $info);
        // 提示信息
        $pageTips = '1、主键发生变动时会更改数据库中的表结构，字段管理中的主键字段也会相应改变;<br>2、表名称发生变动时会更改数据库中的表名称，需要重新进行代码生成和菜单生成;';
        // 构建页面
        return FormBuilder::getInstance()
            ->addFormItems($columns)
            ->setPageTips($pageTips, 'warning')   // 提示信息
            ->setExtraJs($this->getEditExtraJs()) // 设置额外JS
            ->fetch();
    }

    // 修改保存
    public function editPost()
    {
        if (Request::isPost()) {
            $data   = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                // 尝试修改表名称和主键
                $result = \app\common\model\Module::changeTable($data);
                if ($result !== true) {
                    $this->error($result);
                }
                // 修改表记录信息
                $model  = '\app\common\model\\' . $this->modelName;
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
            $model = '\app\common\model\\' . $this->modelName;
            return $model::del($id);
        }
    }

    // 批量删除
    public function selectDel(string $id)
    {
        if (Request::isPost()) {
            $model = '\app\common\model\\' . $this->modelName;
            return $model::selectDel($id);
        }
    }

    // ==========================

    // 检查表信息
    public function checkTale(string $table_name = '')
    {
        if ($table_name) {
            try {
                // 获取模型名称
                $modelName   = '';
                $tableNameArr = explode('_', $table_name);
                foreach ($tableNameArr as $v) {
                    $modelName .= ucfirst($v);
                }
                // 获取完整表名称
                $tableName = \think\facade\Config::get('database.connections.mysql.prefix') . $table_name;
                // 获取表全部字段
                $fields = Db::getTableFields($tableName);
                // 从数据库中获取表字段信息
                $sql        = "SELECT * FROM `information_schema`.`columns` WHERE TABLE_SCHEMA = :table_schema AND table_name = :table_name "
                    . "ORDER BY ORDINAL_POSITION";
                $columnList = Db::query($sql, ['table_schema' => \think\facade\Config::get('database.connections.mysql.database'), 'table_name' => $tableName]);
                $priKey     = '';
                foreach ($columnList as $k => $v) {
                    if ($v['COLUMN_KEY'] == 'PRI') {
                        $priKey = $v['COLUMN_NAME'];
                        break;
                    }
                }
                if ( ! $priKey) {
                    return json(['error' => 1, 'msg' => '请设置 [' . $tableName . '] 表的主键']);
                }
                // 获取表基础信息
                $tableInfo = Db::query("SHOW TABLE STATUS LIKE '{$tableName}'");
                $tableInfo = $tableInfo[0];
                // 获取表类型
                $tableType = '2';
                if (in_array('cate_id', $fields) && in_array('hits', $fields) && in_array('keywords', $fields) && in_array('description', $fields) && in_array('template', $fields) && in_array('url', $fields)) {
                    $tableType = '1';
                }
                // 自动时间戳
                if (in_array('create_time', $fields) && in_array('update_time', $fields)) {
                    $autoTimestamp = '1';
                }

                // 返回信息
                $data = [
                    'module_name'    => $tableInfo['Comment'] ?: $table_name,    // 模块名称
                    'model_name'     => $modelName,                             // 模型名称
                    'table_comment'  => $tableInfo['Comment'],                   // 表描述
                    'pk'             => $priKey,                                 // 主键
                    'table_type'     => $tableType,                              // 表类型
                    'is_sort'        => in_array('sort', $fields) ? '1' : '0',   // 排序字段
                    'is_status'      => in_array('status', $fields) ? '1' : '0', // 状态字段
                    'remark'         => $tableInfo['Comment'],                   // 备注
                    'auto_timestamp' => $autoTimestamp ?? '0',                   // 自动写入时间戳
                    'add_param'      => $addParam ?? '',                         // 添加参数
                ];
                return json(['error' => 0, 'msg' => '数据表已存在，系统已自动补全其他字段', 'data' => $data]);
            } catch (\Exception $e) {
                return json(['error' => 2, 'msg' => $e->getMessage()]);
            }
        }
    }

    // 生成代码
    public function build(string $id, string $file = '')
    {
        return MakeBuilder::makeModule($id, $file);
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
     * @param  string  $id
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
                    // 切换表类型时显示/隐藏预览按钮，设置添加参数
                    $("select[name=\'table_type\']").change(function(){
                        var value = $(this).val();
                        if(value == \'1\'){
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    $(this).attr("checked",true);
                                    $(this).parent(\'.dd_radio_lable\').show();
                                }
                            });
                            $("input[name=\'add_param\']").val(\'cate_id\');
                        } else {
                            $("input[name=\'right_button[]\']").each(function(){
                                if($(this).val() == \'preview\'){
                                    $(this).attr("checked",false);
                                    $(this).parent(\'.dd_radio_lable\').hide();
                                }
                            });
                            $("input[name=\'add_param\']").val(\'\');
                        }
                    })
                    // 表名称添加完时尝试补充其他信息
                    $("input[name=\'table_name\']").change(function(){
                        var config = {
                            url: \'checkTale\',
                            dataType: \'json\',
                            data: {table_name:$("input[name=\'table_name\']").val()},
                            success: function(result) {
                                if(result.error == 1){
                                    toastr.success(result.msg);
                                } else if(result.error == 0) {
                                    $("input[name=\'module_name\']").val(result.data.module_name);
                                    $("input[name=\'model_name\']").val(result.data.model_name);
                                    $("input[name=\'table_comment\']").val(result.data.table_comment);
                                    $("input[name=\'pk\']").val(result.data.pk);
                                    $("select[name=\'table_type\']").val(result.data.table_type);
                                    if(result.data.is_sort == \'1\'){
                                        $("#is_sort1").attr(\'checked\', \'checked\');
                                    } else {
                                        $("#is_sort2").attr(\'checked\', \'checked\');
                                    }
                                    if(result.data.is_status == \'1\'){
                                        $("#is_status1").attr(\'checked\', \'checked\');
                                    } else {
                                        $("#is_status2").attr(\'checked\', \'checked\');
                                    }
                                    $("textarea[name=\'remark\']").text(result.data.remark);
                                    toastr.success(result.msg);
                                }
                            }
                        };
                        $.ajax(config)
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
