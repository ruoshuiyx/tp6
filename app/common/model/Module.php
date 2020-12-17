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
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;

class Module extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query'     => Request::get(),
                'list_rows' => $pageSize,
            ])
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

    // 添加模块时创建表，并初始化主键字段、添加时间、修改时间等字段
    public static function makeModule(string $tableName, int $tableType = 2)
    {
        // 获取模块信息
        $module = self::where('table_name', $tableName)->find();
        // 获取表前缀
        $tableName = \think\facade\Config::get('database.connections.mysql.prefix') . $tableName;
        // 取得所有表名称
        $tables = \think\facade\Db::getTables();
        // 已有表则不再创建
        if (in_array($tableName, $tables)) {
            return '表已存在，请先手动删除[' . $tableName.']';
        } else {
            $sqlStr = '`id` int(8) unsigned NOT NULL AUTO_INCREMENT,
              `create_time` int(11) NOT NULL,
              `update_time` int(11) NOT NULL,';
            // 自动添加排序字段
            if ($module->is_sort) {
                $sqlStr .= '`sort` mediumint(8) DEFAULT \'50\' COMMENT \'排序\',';
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $sqlStr .= '`status` tinyint(1) DEFAULT NULL COMMENT \'状态\',';
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
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='{$module->table_comment}'";
            \think\facade\Db::execute($sql);
            // 插入表记录
            $data = [
                ['module_id' => $module->id, 'field' => 'id', 'name' => '编号', 'type' => 'hidden', 'is_list' => '1', 'status' => '1', 'sort' => '1', 'remark' => '自增ID', 'setup' => "array ('default' => '0','extra_attr' => '','extra_class' => '','step' => '1','fieldtype' => 'int','group' => '')"],
                ['module_id' => $module->id, 'field' => 'create_time', 'name' => '添加时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '50', 'remark' => '添加时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
                ['module_id' => $module->id, 'field' => 'update_time', 'name' => '更新时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '50', 'remark' => '更新时间', 'setup' => "array ('default' => '0', 'format' => 'Y-m-d H:i:s', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
            ];
            // 自动添加排序字段
            if ($module->is_sort) {
                $data[] = ['module_id' => $module->id, 'field' => 'sort', 'name' => '排序', 'required' => '1', 'maxlength' => '8', 'type' => 'number', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_sort' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '49', 'remark' => '', 'setup' => "array ('default' => '50', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int',)"];
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $data[] = ['module_id' => $module->id, 'field' => 'status', 'name' => '状态', 'required' => '1', 'maxlength' => '1', 'type' => 'radio', 'data_source' => '1', 'dict_code' => '1', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_search' => '1', 'is_sort' => '0', 'search_type' => '=', 'status' => '1', 'sort' => '48', 'remark' => '', 'setup' => "array ('default' => '1', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"];
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

}