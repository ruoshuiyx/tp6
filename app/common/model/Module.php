<?php
/**
 * +----------------------------------------------------------------------
 * | 模块列表模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/03/08
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

namespace app\common\model;

// 引入框架内置类
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;

class Module extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 一对多获取字段信息
    public function field()
    {
        return $this->hasMany('Field', 'module_id');
    }

    // 获取列表
    public static function getList($where, $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate(
                [
                    'query'     => Request::get(),
                    'list_rows' => $pageSize,
                ]
            )
            ->toArray();
        // 获取不可选中的信息
        $unMakeModule = MakeBuilder::unMakeModule();
        foreach ($list['data'] as $k => $v) {
            if (in_array($v['model_name'], $unMakeModule)) {
                $list['data'][$k]['checkbox_disabled'] = '1';
            }
        }
        return MakeBuilder::changeTableData($list, 'Module');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        return $list;
    }

    /**
     * 添加模块时创建表，并初始化主键字段、添加时间、修改时间等字段；如有表且符合要求，则直接添加字段
     * @param string $tableName 表名称
     * @return bool|string
     */
    public static function makeTable(string $tableName)
    {
        // 获取模块信息
        $module = self::where('table_name', $tableName)->find();
        if (!$module) {
            return '[module] 表中不存在 table_name 为' . $tableName . '的记录，无法继续';
        }
        $tableType = $module->getData('table_type'); // 表类型 1 cms 2 后台
        $pk        = $module->getData('pk');         // 表主键
        // 获取完整表名称
        $tableName = \think\facade\Config::get('database.connections.mysql.prefix') . $tableName;
        // 取得所有表名称
        $tables = \think\facade\Db::getTables();
        // 已有表则不再创建表，尝试维护字段信息
        if (in_array($tableName, $tables)) {
            // 检测是否包含需要的字段
            $requiredField = [$pk, 'create_time', 'update_time'];
            // 自动添加排序字段
            if ($module->is_sort) {
                $requiredField[] = 'sort';
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $requiredField[] = 'status';
            }
            // CMS模块字段[栏目ID、点击数、关键词、描述、模板、跳转地址]
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
                $requiredField[] = 'cate_id';
                $requiredField[] = 'hits';
                $requiredField[] = 'keywords';
                $requiredField[] = 'description';
                $requiredField[] = 'template';
                $requiredField[] = 'url';
            }
            // 获取当前表的字段信息
            $fields    = Db::getTableFields($tableName);
            $needField = [];
            foreach ($requiredField as &$field) {
                if (array_search($field, $fields) === false) {
                    $needField[] = $field;
                }
            }
            if ($needField) {
                return '请手动在 [' . $tableName . '] 表中创建如下字段：' . implode(',', $needField);
            }

            // 插入表记录
            $data = [
                ['module_id' => $module->id, 'field' => $pk, 'name' => '编号', 'type' => 'hidden', 'is_list' => '1', 'status' => '1', 'sort' => '1', 'remark' => '自增ID', 'setup' => "array ('default' => '0','extra_attr' => '','extra_class' => '','step' => '1','fieldtype' => 'int','group' => '')"],
                ['module_id' => $module->id, 'field' => 'create_time', 'name' => '创建时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '99', 'remark' => '创建时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
                ['module_id' => $module->id, 'field' => 'update_time', 'name' => '更新时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '100', 'remark' => '更新时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
            ];
            // 自动添加排序字段
            if ($module->is_sort) {
                $data[] = ['module_id' => $module->id, 'field' => 'sort', 'name' => '排序', 'required' => '1', 'maxlength' => '8', 'type' => 'number', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_sort' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '98', 'remark' => '', 'setup' => "array ('default' => '50', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int',)"];
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $data[] = ['module_id' => $module->id, 'field' => 'status', 'name' => '状态', 'required' => '1', 'maxlength' => '1', 'type' => 'radio', 'data_source' => '1', 'dict_code' => '1', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_search' => '1', 'is_sort' => '0', 'search_type' => '=', 'status' => '1', 'sort' => '97', 'remark' => '', 'setup' => "array ('default' => '1', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"];
            }

            // 添加CMS模块时自动增加[栏目ID、点击数、关键词、描述、模板、跳转地址]字段
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'cate_id',
                    'name'           => '栏目',
                    'required'       => '1',
                    'maxlength'      => '0',
                    'type'           => 'select',
                    'data_source'    => '2',
                    'relation_model' => 'Cate',
                    'relation_field' => 'cate_name',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '1',
                    'is_search'      => '1',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '2',
                    'remark'         => '栏目',
                    'setup'          => "array ('default' => '0', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'hits',
                    'name'           => '点击次数',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'number',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '1',
                    'is_search'      => '0',
                    'is_sort'        => '1',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '43',
                    'remark'         => '点击次数',
                    'setup'          => "array ('default' => '0', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'keywords',
                    'name'           => '关键词',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '44',
                    'remark'         => '关键词',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'description',
                    'name'           => '描述',
                    'required'       => '0',
                    'maxlength'      => '255',
                    'type'           => 'textarea',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '45',
                    'remark'         => '描述',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'template',
                    'name'           => '模板',
                    'tips'           => '单独设置此条记录的模板，如：article_show.html 或 article_show',
                    'required'       => '0',
                    'maxlength'      => '30',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '46',
                    'remark'         => '模板',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'url',
                    'name'           => '跳转地址',
                    'tips'           => '如需直接跳转，请填写完整的网站地址或相对地址',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '47',
                    'remark'         => '跳转地址',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '',
)"
                ];
            }

            // 尝试构建表中其他字段

            // 从数据库中获取表字段信息
            $sql        = "SELECT * FROM `information_schema`.`columns` WHERE TABLE_SCHEMA = :table_schema AND table_name = :table_name "
                . "ORDER BY ORDINAL_POSITION";
            $columnList = Db::query($sql, ['table_schema' => \think\facade\Config::get('database.connections.mysql.database'), 'table_name' => $tableName]);

            $priKey = ''; // 主键检查
            foreach ($columnList as $k => $v) {
                if ($v['COLUMN_KEY'] == 'PRI') {
                    $priKey = $v['COLUMN_NAME'];
                    break;
                }
            }
            if (!$priKey) {
                return '请设置 [' . $tableName . '] 表的主键';
            }
            // 循环所有字段,开始构造要入库的字段信息
            foreach ($columnList as $k => $v) {
                // 已初始化的字段直接跳过
                $continue = false;
                foreach ($data as $kk => $vv) {
                    if ($vv['field'] == $v['COLUMN_NAME']) {
                        $continue = true;
                        break;
                    }
                }
                if ($continue == true) {
                    continue;
                }

                // 获取字段类型
                $inputType = self::getFieldType($v);

                $maxlength = substr(substr($v['COLUMN_TYPE'], strripos($v['COLUMN_TYPE'], "(") + 1), 0, strrpos(substr($v['COLUMN_TYPE'], strripos($v['COLUMN_TYPE'], "(") + 1), ")")); // 字符长度
                $step      = $inputType == 'number' && $v['NUMERIC_SCALE'] > 0 ? "0." . str_repeat(0, $v['NUMERIC_SCALE'] - 1) . "1" : 1;

                $columnName    = $v['COLUMN_NAME'];                                          // 字段名称
                $columnComment = explode(':', $v['COLUMN_COMMENT'])[0] ?: $columnName;       // 字段别名
                $remark        = $columnComment;                                             // 字段备注
                $default       = $v['COLUMN_DEFAULT'];                                       // 默认值
                $maxlength     = $maxlength ?: 0;                                            // 字符长度
                $dataType      = $v['DATA_TYPE'];                                            // 字段类型
                $isAdd         = 1;                                                          // 添加状态
                $isEdit        = 1;                                                          // 修改状态
                $isList        = 1;                                                          // 列表状态
                $isSearch      = 1;                                                          // 搜索状态
                $isSort        = 1;                                                          // 排序状态
                $searchType    = '=';                                                        // 搜索类型


                // 部分类型的默认值为0
                if (in_array($dataType, ['tinyint', 'bigint', 'int', 'mediumint', 'smallint', 'decimal', 'double', 'float'])) {
                    $default = $default ?: 0;
                }

                if ($inputType == 'number') {
                    $isSearch = 0;
                    $setup    = "array ('default' => '{$default}', 'extra_attr' => '', 'extra_class' => '', 'step' => '{$step}', 'fieldtype' => '{$dataType}',)";
                    $data[]   = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                } elseif ($inputType == 'datetime') {
                    $isSearch = 0;
                    $setup    = "array ('default' => '{$default}', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => '{$dataType}',)";
                    $data[]   = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                } elseif (in_array($inputType, ['image', 'images', 'file', 'files'])) {
                    $isSearch = 0;
                    $isSort   = 0;
                    $setup    = "array ('default' => '{$default}', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => '{$dataType}',)";
                    $data[]   = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                } elseif ($inputType == 'editor') {
                    $isList   = 0;
                    $isSearch = 0;
                    $isSort   = 0;
                    $setup    = "array ('default' => '{$default}', 'extra_attr' => '', 'extra_class' => '', 'height' => '', 'fieldtype' => '{$dataType}',)";
                    $data[]   = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                } elseif ($inputType == 'password') {
                    $isList   = 0;
                    $isSearch = 0;
                    $isSort   = 0;
                    $isEdit   = 0;
                    $setup    = "array ('default' => '{$default}', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => '{$dataType}',)";
                    $data[]   = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                } else {
                    $setup  = "array ('default' => '{$default}', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => '{$dataType}', 'group' => '',)";
                    $data[] = [
                        'module_id'      => $module->id,
                        'field'          => $columnName,
                        'name'           => $columnComment,
                        'required'       => '0',
                        'maxlength'      => $maxlength,
                        'type'           => $inputType,
                        'data_source'    => '0',
                        'relation_model' => '',
                        'relation_field' => '',
                        'is_add'         => $isAdd,
                        'is_edit'        => $isEdit,
                        'is_list'        => $isList,
                        'is_search'      => $isSearch,
                        'is_sort'        => $isSort,
                        'search_type'    => $searchType,
                        'status'         => '1',
                        'sort'           => '50',
                        'remark'         => $remark,
                        'setup'          => $setup,
                    ];
                }
            }
            $fild = new Field();
            $fild->saveAll($data);
            return true;
        } else {
            $sqlStr = '`' . $pk . '` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT \'编号\',
              `create_time` int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'创建时间\',
              `update_time` int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'更新时间\',';
            // 自动添加排序字段
            if ($module->is_sort) {
                $sqlStr .= '`sort` mediumint(8) DEFAULT \'50\' COMMENT \'排序\',';
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $sqlStr .= '`status` tinyint(1) DEFAULT 1 COMMENT \'状态\',';
            }
            // 添加CMS模块时自动增加[栏目ID、点击数、关键词、描述、模板、跳转地址]字段
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
                $sqlStr .= '`cate_id` int(8) unsigned NOT NULL DEFAULT \'0\' COMMENT \'栏目\',';
                $sqlStr .= '`hits` int(8) unsigned NOT NULL DEFAULT \'0\' COMMENT \'点击次数\',';
                $sqlStr .= '`keywords` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'关键词\',';
                $sqlStr .= '`description` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'描述\',';
                $sqlStr .= '`template` varchar(30) NOT NULL DEFAULT \'\' COMMENT \'模板\',';
                $sqlStr .= '`url` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'跳转地址\',';
            }

            $sql = "CREATE TABLE `{$tableName}` (
              {$sqlStr}
              PRIMARY KEY (`{$pk}`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='{$module->table_comment}'";
            try {
                \think\facade\Db::execute($sql);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            // 插入表记录
            $data = [
                ['module_id' => $module->id, 'field' => $pk, 'name' => '编号', 'type' => 'hidden', 'is_list' => '1', 'status' => '1', 'sort' => '1', 'remark' => '自增ID', 'setup' => "array ('default' => '0','extra_attr' => '','extra_class' => '','step' => '1','fieldtype' => 'int','group' => '')"],
                ['module_id' => $module->id, 'field' => 'create_time', 'name' => '添加时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '99', 'remark' => '添加时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
                ['module_id' => $module->id, 'field' => 'update_time', 'name' => '更新时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '100', 'remark' => '更新时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
            ];
            // 自动添加排序字段
            if ($module->is_sort) {
                $data[] = ['module_id' => $module->id, 'field' => 'sort', 'name' => '排序', 'required' => '1', 'maxlength' => '8', 'type' => 'number', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_sort' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '98', 'remark' => '', 'setup' => "array ('default' => '50', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int',)"];
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $data[] = ['module_id' => $module->id, 'field' => 'status', 'name' => '状态', 'required' => '1', 'maxlength' => '1', 'type' => 'radio', 'data_source' => '1', 'dict_code' => '1', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_search' => '1', 'is_sort' => '0', 'search_type' => '=', 'status' => '1', 'sort' => '97', 'remark' => '', 'setup' => "array ('default' => '1', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"];
            }

            // 添加CMS模块时自动增加[栏目ID、点击数、关键词、描述、模板、跳转地址]字段
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'cate_id',
                    'name'           => '栏目',
                    'required'       => '1',
                    'maxlength'      => '0',
                    'type'           => 'select',
                    'data_source'    => '2',
                    'relation_model' => 'Cate',
                    'relation_field' => 'cate_name',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '1',
                    'is_search'      => '1',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '2',
                    'remark'         => '栏目',
                    'setup'          => "array ('default' => '0', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'hits',
                    'name'           => '点击次数',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'number',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '1',
                    'is_search'      => '0',
                    'is_sort'        => '1',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '43',
                    'remark'         => '点击次数',
                    'setup'          => "array ('default' => '0', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'keywords',
                    'name'           => '关键词',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '44',
                    'remark'         => '关键词',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'description',
                    'name'           => '描述',
                    'required'       => '0',
                    'maxlength'      => '255',
                    'type'           => 'textarea',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '45',
                    'remark'         => '描述',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'template',
                    'name'           => '模板',
                    'tips'           => '单独设置此条记录的模板，如：article_show.html 或 article_show',
                    'required'       => '0',
                    'maxlength'      => '30',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '46',
                    'remark'         => '模板',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '', )"
                ];
                $data[] = [
                    'module_id'      => $module->id,
                    'field'          => 'url',
                    'name'           => '跳转地址',
                    'tips'           => '如需直接跳转，请填写完整的网站地址或相对地址',
                    'required'       => '0',
                    'maxlength'      => '0',
                    'type'           => 'text',
                    'data_source'    => '0',
                    'relation_model' => '',
                    'relation_field' => '',
                    'is_add'         => '1',
                    'is_edit'        => '1',
                    'is_list'        => '0',
                    'is_search'      => '0',
                    'is_sort'        => '0',
                    'search_type'    => '=',
                    'status'         => '1',
                    'sort'           => '47',
                    'remark'         => '跳转地址',
                    'setup'          => "array ( 'default' => '', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'varchar', 'group' => '',
)"
                ];
            }

            $fild = new Field();
            $fild->saveAll($data);
            return true;
        }
    }

    /**
     * 编辑模块时修改表名称和主键
     * @param array $data
     * @return bool|string
     */
    public static function changeTable(array $data)
    {
        if ($data) {
            // 获取模块信息
            $module = self::find($data['id']);
            // 获取表前缀
            $prefix = \think\facade\Config::get('database.connections.mysql.prefix');
            if ($module['pk'] !== $data['pk']) {
                // 更改主键
                $sql = 'ALTER TABLE `' . $prefix . $module->table_name . '` CHANGE `' . $module['pk'] . '` `' . $data['pk'] . '` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT;';
                try {
                    \think\facade\Db::execute($sql);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                // 更改字段信息
                $fieldInfo = \app\common\model\Field::where('module_id', $module['id'])
                    ->where('field', '=', $module['pk'])
                    ->find();
                if ($fieldInfo) {
                    $fieldInfo->setAttr('field', $data['pk']);
                    $fieldInfo->save();
                }
            }
            if ($module->table_name !== $data['table_name']) {
                // 更改表名称
                $sql = 'RENAME TABLE `' . $prefix . $module->table_name . '` TO `' . $prefix . $data['table_name'] . '`';
                try {
                    \think\facade\Db::execute($sql);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return true;
    }

    /**
     * 根据字段信息获取字段类型
     * @param $field 字段信息
     * @return string
     */
    private static function getFieldType($field)
    {
        $inputType = 'text';
        switch ($field['DATA_TYPE']) {
            case 'bigint':
            case 'int':
            case 'mediumint':
            case 'smallint':
            case 'tinyint':
                $inputType = 'number';
                break;
            case 'enum':
            case 'set':
            case 'decimal':
            case 'double':
            case 'float':
                $inputType = 'number';
                break;
            case 'longtext':
            case 'text':
                $inputType = 'textarea';
                break;
            case 'mediumtext':
                $inputType = 'textarea';
                break;
            case 'smalltext':
            case 'tinytext':
            case 'year':
            case 'date':
            case 'time':
            case 'datetime':
            case 'timestamp':
            default:
                break;
        }
        $fieldsName = $field['COLUMN_NAME'];

        // 时间类型
        foreach (['time'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && $field['DATA_TYPE'] == 'int') {
                $inputType = 'datetime';
                break;
            }
        }

        // 单图片类型
        foreach (['image', 'avatar'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char', 'text', 'mediumtext'])) {
                $inputType = 'image';
                break;
            }
        }

        // 多图片类型
        foreach (['images', 'avatars'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char', 'text', 'mediumtext'])) {
                $inputType = 'images';
                break;
            }
        }

        // 单文件类型
        foreach (['file'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char', 'text', 'mediumtext'])) {
                $inputType = 'file';
                break;
            }
        }

        // 多文件类型
        foreach (['files'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char', 'text', 'mediumtext'])) {
                $inputType = 'files';
                break;
            }
        }

        // 编辑器类型
        foreach (['content'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char', 'text', 'mediumtext'])) {
                $inputType = 'editor';
                break;
            }
        }

        // 密码类型
        foreach (['password'] as $v) {
            if (preg_match("/{$v}$/i", $fieldsName) && in_array($field['DATA_TYPE'], ['varchar', 'char'])) {
                $inputType = 'password';
                break;
            }
        }

        return $inputType;
    }
}