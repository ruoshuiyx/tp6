<?php
/**
 * +----------------------------------------------------------------------
 * | 字段控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/01/21
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

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

// 引入构建器
use app\common\builder\TableBuilder;
use app\common\facade\MakeBuilder;

class Field extends Base
{
    // 验证器
    protected $validate = 'field';

    // 当前主表
    protected $tableName = 'field';

    // 当前主模型
    protected $moduleName = 'Field';

    // 字段列表
    public function index()
    {
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
            ->setUniqueId($pk)                              // 设置主键
            ->addColumns($coloumns)                         // 添加列表字段数据
            ->setSearch($search)                            // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')       // 启用右侧操作列
            ->addRightButtons(['edit', 'delete'])           // 设置右侧操作列
            ->addTopButtons(['add', 'edit', 'del'])         // 设置顶部按钮组
            ->setExtraJs($this->getIndexExtraJs())          // 设置额外JS
            ->fetch();
    }

    /**
     * 添加字段
     * @param  int    $moduleId 模块（表）ID
     * @return string
     */
    public function add(int $moduleId = 0)
    {
        // 获取所有模块
        $modules = \app\common\model\Module::field('id,module_name,table_name,table_comment')
            ->select();
        // 获取所有字典类型
        $dictTypes = \app\common\model\DictionaryType::field('id,dict_name, remark')
            ->where('status', 1)
            ->order('sort asc, id desc')
            ->select();

        $view = [
            'module_id' => $moduleId,
            'info'      => null,
            'fieldInfo' => null,
            'modules'   => $modules,
            'dictTypes' => $dictTypes,
            'groups'    => [],
        ];

        View::assign($view);
        return View::fetch();
    }

    /**
     * 添加/修改时字段变更后重新加载配置信息
     * @param  int    $moduleId 模块（表）ID
     * @param  string $type     类型
     * @param  string $field    字段（编辑字段时需传递该参数）
     * @return string
     */
    public function changeType(int $moduleId, string $type, string $field = '')
    {
        if (Request::isPost()) {
            if (Request::param('isajax')) {
                // 调用字段设置模版
                View::assign(Request::param());
                // 传递field说明是编辑字段,编辑字段需要调取当前字段的配置信息
                if (!empty($field)) {
                    $fieldInfo = \app\common\model\Field::where('module_id', $moduleId)
                        ->where('field', '=', $field)
                        ->find();
                    $fieldInfo['setup'] = string2array($fieldInfo['setup']);
                } else {
                    $fieldInfo = null;
                }
                $view = [
                    'fieldInfo' => $fieldInfo,
                ];
                View::assign($view);
                return View::fetch('changeType');
            }
        }
    }

    /**
     * 添加字段保存
     */
    public function addPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            // 验证数据
            $result = $this->validate($data, 'field');
            if (true !== $result) {
                $this->error($result);
            }
            // 查询字段是否已录入
            $hasIn = \app\common\model\Field::where('field', $data['field'])->where('module_id', $data['module_id'])->count();
            if ($hasIn) {
                $this->error('该模块中已存在字段' . $data['field']);
            }

            // 查询字段是否已在表中存在
            $name = \app\common\model\Module::where('id', '=', $data['module_id'])->value('table_name');
            $tablename = Config::get('database.connections.mysql.prefix') . $name;
            if ($this->_iset_field($tablename, $data['field'])) {
                //$this->error($tablename . '表已存在[' . $data['field'] . ']字段');
            } else {
                // 获取字段sql
                $addfieldsql = $this->get_tablesql($data, 'add');
            }
            if (isset($data['setup'])) {
                $data['setup'] = array2string($data['setup']);
            }
            $model = Db::name('field');
            if ($model->insert($data) !== false) {
                // 数据库已存在字段时不再执行字段操作
                if (isset($addfieldsql) && !empty($addfieldsql)) {
                    if (is_array($addfieldsql)) {
                        foreach ($addfieldsql as $sql) {
                            try {
                                Db::execute($sql);
                            } catch (\Exception $e) {
                                $this->error($e->getMessage() . '<br><br>[SQL]: ' . $sql);
                            }
                        }
                    } else {
                        try {
                            Db::execute($addfieldsql);
                        } catch (\Exception $e) {
                            $this->error($e->getMessage() . '<br><br>[SQL]: ' . $addfieldsql);
                        }
                    }
                }
                $this->success('添加成功！', url('index', array('module_id' => $data['module_id'])));
            } else {
                $this->error('添加失败！');
            }
        }
    }

    /**
     * 编辑字段
     * @param int $id id
     * @return string
     */
    public function edit(int $id){
        // 获取所有模块
        $modules = \app\common\model\Module::field('id,module_name,table_name,table_comment')
            ->select()->toArray();
        // 获取所有字典类型
        $dictTypes = \app\common\model\DictionaryType::field('id,dict_name, remark')
            ->order('sort asc, id desc')
            ->select();
        // 获取所有字段分组
        $groups = \app\common\model\FieldGroup::where('status',1)
            ->order('sort asc,id desc')
            ->select()
            ->toArray();
        // 格式化字段分组中的分组名称,避免重复展示
        foreach ($groups as $k => $v) {
            foreach ($modules as $kk => $vv) {
                if ($vv['id'] == $v['module_id']) {
                    $v['group_name'] = $vv['module_name'] . ' - ' . $v['group_name'];
                    break;
                }
            }
            $groups[$k]['group_name'] = $v['group_name'];
        }

        $fieldInfo = \app\common\model\Field::where('id', '=', $id)->find();
        if ($fieldInfo['setup'])
            $fieldInfo['setup'] = string2array($fieldInfo['setup']);
        $view = [
            'module_id' => $fieldInfo['module_id'],
            'info'      => $fieldInfo,
            'modules'   => $modules,
            'dictTypes' => $dictTypes,
            'groups'    => $groups,
        ];
        View::assign($view);
        return View::fetch('add');
    }

    /**
     * 编辑字段保存
     */
    public function editPost(){
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['old_field']), $this->tableName);
            $oldfield = Request::param('old_field');

            // 验证数据
            $result = $this->validate($data, 'field');
            if (true !== $result) {
                $this->error($result);
            }

            $data['is_list']   = $data['is_list'] ?? 0;
            $data['is_add']    = $data['is_add'] ?? 0;
            $data['is_edit']   = $data['is_edit'] ?? 0;
            $data['is_search'] = $data['is_search'] ?? 0;
            $data['is_sort']   = $data['is_sort'] ?? 0;

            // 查询字段是否已在表中存在
            $name = \app\common\model\Module::where('id', '=', $data['module_id'])->value('table_name');
            $tablename = Config::get('database.connections.mysql.prefix') . $name;
            // 新的字段已被存在于表中
            if ($this->_iset_field($tablename, $data['field']) && $oldfield != $data['field']) {
                $this->error($tablename . '表已存在[' . $data['field'] . ']字段');
            }
            // 旧的字段不存在于表中
            if ($this->_iset_field($tablename, $oldfield) == false) {
                $this->error($tablename . '表不存在[' . $oldfield . ']字段');
            }

            $editfieldsql = $this->get_tablesql(Request::post(), 'edit');

            if (array_key_exists("setup", $data) && $data['setup']) {
                $data['setup'] = array2string($data['setup']);
            }
            $model = Db::name('field');

            if (false !== $model->update($data)) {
                if (is_array($editfieldsql)) {
                    foreach ($editfieldsql as $sql) {
                        try {
                            Db::execute($sql);
                        } catch (\Exception $e) {
                            $this->error($e->getMessage() . '<br><br>[SQL]: ' . $sql);
                        }
                    }
                } else {
                    try {
                        Db::execute($editfieldsql);
                    } catch (\Exception $e) {
                        $this->error($e->getMessage() . '<br><br>[SQL]: ' . $editfieldsql);
                    }
                }
                $this->success('修改成功！', 'index');
            } else {
                $this->error('修改失败！');
            }
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
    public function state(string $id, string $field = '')
    {
        if (Request::isPost()) {
            // 其他字段变更
            if ($field) {
                $alowField = ['is_add', 'is_edit', 'is_list', 'is_search', 'is_sort', 'required'];
                if (in_array($field, $alowField)) {
                    $model = '\app\common\model\\' . $this->moduleName;
                    $info = $model::find($id);
                    $value = $info[$field] == 1 ? 0 : 1;
                    $info[$field] = $value;
                    $info->save();
                    return json(['error' => 0, 'msg' => '修改成功!']);
                }
            }
            $model = '\app\common\model\\' . $this->moduleName;
            return $model::state($id);
        }
    }

    // 删除字段
    public function del(string $id)
    {
        if (Request::isPost()) {
            if (strpos($id, ',') !== false) {
                return $this->selectDel($id);
            }
            $r = Db::name('field')->find($id);
            if ($r) {
                //删除字段表中的记录
                Db::name('field')->delete($id);
            }

            $moduleId = $r['module_id'];
            $field = $r['field'];

            $prefix = Config::get('database.connections.mysql.prefix');
            $name = Db::name('module')
                ->where('id', '=', $moduleId)
                ->value('table_name');
            $tableName = $prefix . $name;

            //实际查询表中是否有该字段
            if ($this->_iset_field($tableName, $field)) {
                Db::execute("ALTER TABLE `{$tableName}` DROP `$field`");
            }
            return json(['error' => 0, 'msg' => '删除成功！']);
        }
    }

    // 批量删除
    public function selectDel(string $id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $k => $v) {
            $r = Db::name('field')->find($v);
            if ($r) {
                // 删除字段表中的记录
                Db::name('field')->delete($r['id']);
            }

            $moduleId = $r['module_id'];
            $field = $r['field'];

            $prefix = Config::get('database.connections.mysql.prefix');
            $name = Db::name('module')
                ->where('id', '=', $moduleId)
                ->value('table_name');
            $tableName = $prefix . $name;

            // 实际查询表中是否有该字段
            if ($this->_iset_field($tableName, $field)) {
                Db::execute("ALTER TABLE `{$tableName}` DROP `$field`");
            }
        }
        return json(['error' => 0, 'msg' => '删除成功！']);
    }

    //============================================

    /**
     * 获取要执行的sql
     * @param array  $info 字段信息
     * @param string $do   操作类型[add/edit]
     * @return array|string
     */
    protected function get_tablesql(array $info, string $do = 'add')
    {
        $comment = $info['name'];
        $type = $info['type'];

        if (isset($info['setup']['fieldtype'])) {
            $fieldtype = strtoupper($info['setup']['fieldtype']);
        }
        $moduleid = $info['module_id'];
        $default = $info['setup']['default'] ?? '';
        $field = $info['field'];

        $module = \app\common\model\Module::find($moduleid);
        $name = $module->table_name;
        $pk = $module->pk ?: 'id';

        $tablename = Config::get('database.connections.mysql.prefix') . $name;
        $maxlength = intval($info['maxlength']);
        $minlength = intval($info['minlength']);
        $numbertype = $info['setup']['numbertype'] ?? '1'; // 是否包含负数
        if ($do == 'add') {
            $do = ' ADD ';
        } else {
            $oldfield = $info['old_field'];
            $do = " CHANGE `" . $oldfield . "` ";
        }
        // text,textarea,radio,checkbox,date,time,datetime,daterange,tag,number,password,select,select2,image,images,file,files,editor,hidden,color
        switch ($type) {
            case 'text':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'textarea':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'radio':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $default = $default ?? 0;
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                }
                break;
            case 'checkbox':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                }
                break;
            case 'date':
                $fieldtype = $fieldtype ?? 'INT';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                }
                break;
            case 'time':
                $fieldtype = $fieldtype ?? 'INT';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                }
                break;
            case 'datetime':
                $fieldtype = $fieldtype ?? 'INT';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                }
                break;
            case 'daterange':
                if (!$maxlength)
                    $maxlength = 50;
                $maxlength = min($maxlength, 255);
                $fieldtype = $fieldtype ?? 'VARCHAR';
                $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                break;
            case 'tag':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'number':
                $fieldtype = $fieldtype ?? 'INT';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $default = $default ?? intval($default);
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT {$default} COMMENT '$comment'";
                }
                break;
            case 'password':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'select':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } elseif ($fieldtype == 'INT' || $fieldtype == 'TINYINT') {
                    $default = $default ?? intval($default);
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT {$default} COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'select2':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } elseif ($fieldtype == 'INT' || $fieldtype == 'TINYINT') {
                    $default = $default ?? intval($default);
                    if (!$maxlength)
                        $maxlength = 10;
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT {$default} COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'image':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 80;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'images':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'file':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 80;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'files':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'editor':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 255;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
            case 'hidden':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength)
                        $maxlength = 255;
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    if (!$maxlength)
                        $maxlength = 10;
                    // 主键字段自增
                    if ($pk == $field) {
                        $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL AUTO_INCREMENT COMMENT '$comment'";
                    } else {
                        $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT '$default' COMMENT '$comment'";
                    }
                }
                break;
            case 'color':
                $fieldtype = $fieldtype ?? 'VARCHAR';
                if ($fieldtype == 'VARCHAR' || $fieldtype == 'CHAR') {
                    if (!$maxlength) {
                        $maxlength = 10;
                    }
                    $maxlength = min($maxlength, 255);
                    $sql = "ALTER TABLE `$tablename` $do `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                } else {
                    $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NULL COMMENT '$comment'";
                }
                break;
        }
        return $sql;
    }

    /**
     * 判断表中是否存在所选字段
     * @param $table 表全称
     * @param $field 字段名称
     * @return mixed
     */
    protected function _iset_field($table, $field)
    {
        $fields = Db::getTableFields($table);
        if (array_search($field, $fields) === false) {
            return false;
        } else {
            return true;
        }
    }

    // 列表页额外JS
    private function getIndexExtraJs()
    {
        $url = url('state');
        $js = '<script type="text/javascript">
            $(document).ready(function() {
                //避免pjax重复加载js导致事件重复绑定
                if (typeof (fieldIndexExtraJs) != "undefined") {
                    return;
                }   
                $(document).on("click", \'.js_is_add\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'is_add\'});
                    }
                })
                $(document).on("click", \'.js_is_edit\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'is_edit\'});
                    }
                })
                $(document).on("click", \'.js_is_list\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'is_list\'});
                    }
                })
                $(document).on("click", \'.js_is_search\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'is_search\'});
                    }
                })
                $(document).on("click", \'.js_is_sort\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'is_sort\'});
                    }
                })
                $(document).on("click", \'.js_required\', function () {
                    var id = $(this).parent(\'tr\').data(\'uniqueid\');
                    if(id){
                        $.operate.submit(\'' . $url . '\', "post", "json", {"id": id,"field": \'required\'});
                    }
                })
                fieldIndexExtraJs = true;
            })
            </script>';
        return $js;
    }
}
