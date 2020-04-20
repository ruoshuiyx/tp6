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
        $tables = \think\facade\Db::getConnection()->getTables();
        // 已有表则不再创建
        if (in_array($tableName, $tables)) {
            return '表已存在';
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
            // 添加CMS模块时自动增加栏目ID字段
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
               $sqlStr .= '`cate_id` tinyint(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'栏目\',';
            }

            $sql = "CREATE TABLE `{$tableName}` (
              {$sqlStr}
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='{$module->table_comment}'";
            self::execute($sql);
            // 插入表记录
            $data = [
                ['module_id' => $module->id, 'field' => 'id', 'name' => '编号', 'type' => 'hidden', 'is_list' => '1', 'status' => '1', 'sort' => '1', 'remark' => '自增ID', 'setup' => "array ('default' => '0','extra_attr' => '','extra_class' => '','step' => '1','fieldtype' => 'int','group' => '')"],
                ['module_id' => $module->id, 'field' => 'create_time', 'name' => '添加时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '50', 'remark' => '添加时间', 'setup' => "array ('default' => '0', 'format' => 'yyyy-mm-dd hh:ii:ss', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
                ['module_id' => $module->id, 'field' => 'update_time', 'name' => '更新时间', 'maxlength' => '11', 'type' => 'datetime', 'is_list' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '50', 'remark' => '更新时间', 'setup' => "array ('default' => '0', 'format' => 'yyyy-mm-dd hh:ii:ss', 'extra_attr' => '', 'extra_class' => '', 'placeholder' => '', 'fieldtype' => 'int',)"],
            ];
            // 自动添加排序字段
            if ($module->is_sort) {
                $data[] = ['module_id' => $module->id, 'field' => 'sort', 'name' => '排序', 'required' => '1', 'maxlength' => '8', 'type' => 'number', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_sort' => '1', 'search_type' => '=', 'status' => '1', 'sort' => '49', 'remark' => '', 'setup' => "array ('default' => '50', 'extra_attr' => '', 'extra_class' => '', 'step' => '1', 'fieldtype' => 'int',)"];
            }
            // 自动添加状态字段
            if ($module->is_status) {
                $data[] = ['module_id' => $module->id, 'field' => 'status', 'name' => '状态', 'required' => '1', 'maxlength' => '1', 'type' => 'radio', 'data_source' => '1', 'dict_code' => '1', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_search' => '1', 'is_sort' => '0', 'search_type' => '=', 'status' => '1', 'sort' => '48', 'remark' => '', 'setup' => "array ('default' => '1', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"];
            }

            // 添加CMS模块时自动增加栏目ID字段
            if ($tableType == 1 && Config::get('builder.add_cate_id')) {
                $data[] = ['module_id' => $module->id, 'field' => 'cate_id', 'name' => '栏目', 'required' => '1', 'maxlength' => '0', 'type' => 'select', 'data_source' => '2', 'relation_model' => 'Cate', 'relation_field' => 'cate_name', 'is_add' => '1', 'is_edit' => '1', 'is_list' => '1', 'is_search' => '1', 'is_sort' => '0', 'search_type' => '=', 'status' => '1', 'sort' => '2', 'remark' => '栏目', 'setup' => "array ('default' => '0', 'extra_attr' => '', 'extra_class' => '', 'fieldtype' => 'tinyint',)"];
            }

            $fild = new Field();
            $fild->saveAll($data);
            return true;
        }
    }

}