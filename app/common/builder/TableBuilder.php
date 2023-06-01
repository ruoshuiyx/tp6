<?php
/**
 * +----------------------------------------------------------------------
 * | 表格快速构造器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/08/05
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

namespace app\common\builder;

use think\facade\Request;
use think\facade\View;

class TableBuilder
{
    /**
     * @var array 列名
     */
    private $_field_name = [];

    /**
     * @var string 模板路径(默认使用系统内置路径，无需设置)
     */
    private $_template = '';

    /**
     * @var array 模板变量
     */
    private $_vars = [
        'page_title'       => '',          // 页面标题
        'page_tips'        => '',          // 页面提示
        'page_tips_top'    => '',          // 页面提示[top]
        'page_tips_search' => '',          // 页面提示[search]
        'page_tips_bottom' => '',          // 页面提示[bottom]
        'page_size'        => '',          // 每页显示的行数
        'tips_type'        => '',          // 页面提示类型
        'extra_js'         => '',          // 额外JS代码
        'extra_css'        => '',          // 额外CSS代码
        'extra_html'       => '',          // 额外HTML代码
        'columns'          => [],          // 表格列集合
        'right_buttons'    => [],          // 表格右侧按钮
        'top_buttons'      => [],          // 顶部栏按钮组[toolbar]
        'unique_id'        => 'id',        // 表格主键名称（默认为id，如表主键不为id必须设置主键）
        'sort_name'        => 'id',        // 表格排序字段名称（默认为id，如表排序字段名称不为id必须设置排序字段名称）
        'sort_order'       => 'desc',      // 表格默认排序方式（默认为desc）
        'data_url'         => '',          // 表格数据源
        'add_url'          => '',          // 默认的新增地址
        'edit_url'         => '',          // 默认的修改地址
        'del_url'          => '',          // 默认的删除地址
        'export_url'       => '',          // 默认的导出地址
        'sort_url'         => '',          // 默认的排序地址
        'search'           => [],          // 搜索参数
        'pagination'       => 'true',      // 是否进行分页
        'parent_id_field'  => '',          // 列表树模式需传递父id
        'empty_tips'       => '没有找到匹配的记录', // 空数据提示信息
        'hide_checkbox'    => false,       // 是否隐藏第一列多选[待完善]
        'layer_open'       => true,        // 添加/编辑等页启用layer弹层加载
        'fixed_left'       => 0,           // 左侧固定列数
        'fixed_right'      => 1,           // 右侧固定列数
    ];

    /**
     * @var 单例模式句柄
     */
    private static $instance;

    /**
     * 获取句柄
     * @return FormBuilder
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 私有化构造函数
     */
    private function __construct()
    {
        // 初始化
        $this->initialize();
    }

    /**
     * 初始化
     */
    protected function initialize()
    {
        // 每页显示的行数
        $this->_vars['page_size'] = \think\facade\Config::get('app.page_size', '10');
        // layer弹层
        $this->_vars['layer_open'] = \think\facade\Config::get('builder.layer_open', false);

        // 设置默认模版
        $this->_template = 'table_builder/layout';

        // 设置默认URL
        $this->_vars['data_url']   = Request::baseUrl() . '?getList=1';
        $this->_vars['add_url']    = url('add');
        $this->_vars['edit_url']   = url('edit', ['id' => '__id__']);
        $this->_vars['del_url']    = url('del');
        $this->_vars['export_url'] = url('export');
        $this->_vars['sort_url']   = url('sort');
    }

    /**
     * 私有化clone函数
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 渲染模版
     * @param string $template 模板文件名
     * @return string
     * @throws \Exception
     */
    public function fetch(string $template = '')
    {
        // 单独设置模板
        if ($template != '') {
            $this->_template = $template;
        }
        View::assign($this->_vars);
        return View::fetch($this->_template);
    }

    /**
     * 设置表格主键
     * @param string $key 主键名称
     * @return $this
     */
    public function setUniqueId($key = '')
    {
        if ($key != '') {
            $this->_vars['unique_id'] = $key;
            # 可以省略主键非id时，需要设置排序字段，如果已经setSortName设置排序字段非id，则不修改
            $this->_vars['sort_name'] = $this->_vars['sort_name'] != 'id' ? $this->_vars['sort_name'] : $key; 
        }
        return $this;
    }

    /**
     * 设置排序字段
     * @param string $sort_name 排序字段名
     * @return $this
     */
    public function setSortName($sort_name = '')
    {
        if ($sort_name != '') {
            $this->_vars['sort_name'] = $sort_name;
        }
        return $this;
    }

    /**
     * 设置排序方式
     * @param string $sort_order 排序方式asc desc
     * @return $this
     */
    public function setSortOrder($sort_order = '')
    {
        if ($sort_order != '') {
            $this->_vars['sort_order'] = $sort_order;
        }
        return $this;
    }

    /**
     * 设置页面标题
     * @param string $title 页面标题
     * @return $this
     */
    public function setPageTitle($title = '')
    {
        if ($title != '') {
            $this->_vars['page_title'] = trim($title);
        }
        return $this;
    }

    /**
     * 设置表单页提示信息
     * @param string $tips 提示信息
     * @param string $type 提示类型：danger,info,warning,success
     * @param string $pos  提示位置：top,search,bottom
     * @return $this
     */
    public function setPageTips($tips = '', $type = 'info', $pos = 'top')
    {
        if ($tips != '') {
            $this->_vars['page_tips_' . $pos] = $tips;
            $this->_vars['tips_type']         = trim($type);
        }
        return $this;
    }

    /**
     * 设置额外JS代码
     * @param string $extra_js 额外JS代码
     * @return $this
     */
    public function setExtraJs($extra_js = '')
    {
        if ($extra_js != '') {
            $this->_vars['extra_js'] = $extra_js;
        }
        return $this;
    }

    /**
     * 设置额外CSS代码
     * @param string $extra_css 额外CSS代码
     * @return $this
     */
    public function setExtraCss($extra_css = '')
    {
        if ($extra_css != '') {
            $this->_vars['extra_css'] = $extra_css;
        }
        return $this;
    }

    /**
     * 设置额外HTML代码
     * @param string $extra_html 额外HTML代码
     * @param string $pos        位置 [top和bottom]
     * @return $this
     */
    public function setExtraHtml($extra_html = '', $pos = '')
    {
        if ($extra_html != '') {
            $pos != '' && $pos = '_' . $pos;
            $this->_vars['extra_html' . $pos] = $extra_html;
        }
        return $this;
    }

    /**
     * 添加一列
     * @param string $name     字段名称
     * @param string $title    字段别名
     * @param string $type     单元格类型
     * @param string $default  默认值
     * @param string $param    额外参数
     * @param string $class    css类名
     * @param string $sortable 是否排序
     * @param int    $with     列宽
     * @return $this
     */
    public function addColumn($name = '', $title = '', $type = '', $default = '', $param = '', $class = '', $sortable = 'false', $width = 0)
    {
        $column = [
            'name'     => $name,     // 字段名称
            'title'    => $title,    // 字段别名
            'type'     => $type,     // 单元格类型
            'default'  => $default,  // 默认值
            'param'    => $param,    // 额外参数
            'class'    => $class,    // css类名
            'sortable' => $sortable, // 是否排序
            'width'    => $width,    // 列宽
        ];

        $this->_vars['columns'][] = $column;
        $this->_field_name[$name] = $title;
        return $this;
    }

    /**
     * 一次性添加多列
     * @param array $columns 数据列
     * @return $this
     */
    public function addColumns($columns = [])
    {
        if (!empty($columns)) {
            foreach ($columns as $column) {
                call_user_func_array([$this, 'addColumn'], $column);
            }
        }
        return $this;
    }

    /**
     * 设置是否显示分页
     * @param string $value 是否显示分页 true|false
     * @return $this
     */
    public function setPagination($value = '')
    {
        if ($value != '') {
            $this->_vars['pagination'] = $value;
        }
        return $this;
    }

    /**
     * 设置列表树父ID
     * @param string $value 字段
     * @return $this
     */
    public function setParentIdField($value = '')
    {
        if ($value != '') {
            $this->_vars['parent_id_field'] = $value;
        }
        return $this;
    }

    /**
     * 设置空数据提示信息
     * @param string $value 字段
     * @return $this
     */
    public function setEmptyTips($value = '')
    {
        if ($value != '') {
            $this->_vars['empty_tips'] = $value;
        }
        return $this;
    }

    /**
     * 设置每页显示的行数
     * @param string $value 数量
     * @return $this
     */
    public function setPageSize($value = '')
    {
        if ($value != '') {
            $this->_vars['page_size'] = $value;
        }
        return $this;
    }

    /**
     * 隐藏第一列多选框(默认显示,多选列多用于批量删除等操作)
     * @return $this
     */
    public function hideCheckbox()
    {
        $this->_vars['hide_checkbox'] = true;
        return $this;
    }

    /**
     * 添加一个右侧按钮
     * @param string $type      按钮类型：edit/delete/default
     * @param array  $attribute 按钮属性
     * @param array  $extra     扩展参数(待用)
     * @return $this
     */
    public function addRightButton($type = '', $attribute = [])
    {
        switch ($type) {
            // 预览按钮
            case 'preview':
                // 默认属性
                $btn_attribute = [
                    'type'   => 'preview',
                    'title'  => '预览',
                    'icon'   => 'fa fa-eye',
                    'class'  => 'btn btn-success btn-xs',
                    'href'   => url('index/preview', ['module' => Request::controller(), 'id' => '__id__']),
                    'target' => '_blank'
                ];
                break;

            // 编辑按钮
            case 'edit':
                // 默认属性
                $btn_attribute = [
                    'type'  => 'edit',
                    'title' => '编辑',
                    'icon'  => 'fa fa-edit',
                    'class' => 'btn btn-primary btn-xs',
                ];
                break;

            // 删除按钮(不可恢复)
            case 'delete':
                // 默认属性
                $btn_attribute = [
                    'type'  => 'delete',
                    'title' => '删除',
                    'icon'  => 'far fa-trash-alt',
                    'class' => 'btn btn-danger btn-xs confirm',
                ];
                break;

            // 自定义按钮
            default:
                // 默认属性
                $btn_attribute = [
                    'title' => '自定义按钮',
                    'icon'  => 'fa fa-smile-o',
                    'class' => 'btn btn-flat btn-default btn-xs',
                    'href'  => 'javascript:void(0);'
                ];
                break;
        }
        // 合并自定义属性
        if ($attribute && is_array($attribute)) {
            $btn_attribute = array_merge($btn_attribute, $attribute);
        }

        $this->_vars['right_buttons'][] = $btn_attribute;
        return $this;
    }

    /**
     * 添加多个右侧按钮
     * @param array|string $buttons 按钮类型
     *                              例如：
     *                              $builder->addRightButtons('edit');
     *                              $builder->addRightButtons('edit,delete');
     *                              $builder->addRightButtons(['edit', 'delete']);
     *                              $builder->addRightButtons(['edit' => ['title' => '查看'], 'delete']);
     * @return $this
     */
    public function addRightButtons($buttons = [])
    {
        if (!empty($buttons)) {
            $buttons = is_array($buttons) ? $buttons : explode(',', $buttons);
            foreach ($buttons as $key => $value) {
                if (is_numeric($key)) {
                    $this->addRightButton($value);
                } else {
                    $this->addRightButton(trim($key), $value);
                }
            }
        }
        return $this;
    }

    /**
     * 设置表格URL
     * @param string $url url地址
     * @return $this
     */
    public function setDataUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['data_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置表格默认的新增地址
     * @param string $url url地址
     * @return $this
     */
    public function setAddUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['add_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置表格默认的修改地址
     * @param string $url url地址
     * @return $this
     */
    public function setEditUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['edit_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置表格默认的删除地址
     * @param string $url url地址
     * @return $this
     */
    public function setDelUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['del_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置表格默认的导出地址
     * @param string $url url地址
     * @return $this
     */
    public function setExportUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['export_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置表格默认的更改排序地址
     * @param string $url url地址
     * @return $this
     */
    public function setSortUrl($url = '')
    {
        if ($url != '') {
            $this->_vars['sort_url'] = $url;
        }
        return $this;
    }

    /**
     * 设置搜索参数
     * @param array $items
     * @return $this
     * 第一个参数：类型
     * 第二个参数：字段名称
     * 第三个参数：字段别名
     * 第四个参数：匹配方式（默认为'='，也可以是'<>，>，>=，<，<=，LIKE'等等）
     * 第五个参数：默认值
     * 第六个参数：额外参数（不同类型，用途不同）
     */
    public function setSearch($items = [])
    {
        if (!empty($items)) {
            foreach ($items as &$item) {
                $item['type']           = $item[0] ?? '';  // 字段类型
                $item['name']           = $item[1] ?? '';  // 字段名称
                $item['title']          = $item[2] ?? '';  // 字段别名
                $item['option']         = $item[3] ?? '='; // 匹配方式
                $item['default']        = $item[4] ?? '';  // 默认值
                $item['param']          = $item[5] ?? [];  // 额外参数
                $item['data_source']    = $item[6] ?? 0;   // 数据源 [0 字段本身, 1 系统字典, 2 模型数据]
                $item['relation_model'] = $item[7] ?? '';  // 模型关联
                $item['relation_field'] = $item[8] ?? '';  // 关联字段
                $item['field_id']       = $item[9] ?? 0;   // 字段编号
            }
            $this->_vars['search'] = $items;
        }
        return $this;
    }

    /**
     * 添加一个顶部按钮
     * @param string $type      按钮类型：add/edit/del/export/build/default
     * @param array  $attribute 按钮属性
     * @return $this
     */
    public function addTopButton($type = '', $attribute = [])
    {
        switch ($type) {

            // 新增按钮
            case 'add':
                // 默认属性
                $btn_attribute = [
                    'title'   => '新增',
                    'icon'    => 'fa fa-plus',
                    'class'   => 'btn btn-success',
                    'href'    => '',
                    'onclick' => '$.operate.add()',
                ];
                break;

            // 修改按钮
            case 'edit':
                // 默认属性
                $btn_attribute = [
                    'title'   => '修改',
                    'icon'    => 'fa fa-edit',
                    'class'   => 'btn btn-primary single disabled',
                    'href'    => '',
                    'onclick' => '$.operate.edit()',
                ];
                break;

            // 删除按钮
            case 'del':
                // 默认属性
                $btn_attribute = [
                    'title'   => '删除',
                    'icon'    => 'fa fa-times',
                    'class'   => 'btn btn-danger multiple disabled',
                    'href'    => '',
                    'onclick' => '$.operate.removeAll()'
                ];
                break;

            // 导出按钮
            case 'export':
                // 默认属性
                $btn_attribute = [
                    'title'   => '导出',
                    'icon'    => 'fa fa-download',
                    'class'   => 'btn btn-warning',
                    'href'    => '',
                    'onclick' => '$.table.export()'
                ];
                break;

            // 生成按钮
            case 'build':
                // 默认属性
                $btn_attribute = [
                    'title'   => '代码生成',
                    'icon'    => 'fa fa-code',
                    'class'   => 'btn btn-info single disabled',
                    'href'    => '',
                    'onclick' => '$.operate.build(\'\', \'' . url('module/build') . '\')',
                    'group'   => [
                        'class' => 'btn-info single disabled', // 下拉分组组样式
                        'menus' => [                           // 下拉分组数据（内容同按钮一样）
                            [
                                'title'   => '生成验证器',
                                'icon'    => '',
                                'class'   => 'btn btn-info',
                                'href'    => '',
                                'onclick' => '$.operate.build(\'\', \'' . url('module/build', ['file' => 'validate']) . '\')',
                            ],
                            [
                                'title'   => '生成模型',
                                'icon'    => '',
                                'class'   => 'btn btn-info',
                                'href'    => '',
                                'onclick' => '$.operate.build(\'\', \'' . url('module/build', ['file' => 'model']) . '\')',
                            ],
                            [
                                'title'   => '生成控制器',
                                'icon'    => '',
                                'class'   => 'btn btn-info',
                                'href'    => '',
                                'onclick' => '$.operate.build(\'\', \'' . url('module/build', ['file' => 'controller']) . '\')',
                            ],
                        ],
                    ]
                ];
                break;

            // 自定义按钮
            default:
                // 默认属性
                $btn_attribute = [
                    'title'   => '自定义',
                    'icon'    => 'fa fa-lightbulb',
                    'class'   => 'btn btn-default',
                    'href'    => '',
                    'onclick' => ''
                ];
                break;
        }

        // 合并自定义属性
        if ($attribute && is_array($attribute)) {
            $btn_attribute = array_merge($btn_attribute, $attribute);
        }
        $this->_vars['top_buttons'][] = $btn_attribute;
        return $this;
    }

    /**
     * 一次性添加多个顶部按钮
     * @param array|string $buttons 按钮组
     *                              例如：
     *                              addTopButtons('add')
     *                              addTopButtons('add, edit, del')
     *                              addTopButtons(['add', 'del'])
     *                              addTopButtons(['add' => ['title' => '增加'], 'del'])
     * @return $this
     */
    public function addTopButtons($buttons = [])
    {
        if (!empty($buttons)) {
            $buttons = is_array($buttons) ? $buttons : explode(',', $buttons);
            foreach ($buttons as $key => $value) {
                if (is_numeric($key)) {
                    // key为数字则直接添加一个按钮
                    $this->addTopButton($value);
                } else {
                    // key不为数字则需设置属性，去除前后空格
                    $this->addTopButton(trim($key), $value);
                }
            }
        }
        return $this;
    }

    /**
     * 设置是否在添加/编辑等页启用layer弹层加载
     * @param string $value 是否启用layer true|false
     * @return $this
     */
    public function setLayerOpen($value = true)
    {
        $this->_vars['layer_open'] = $value;
        return $this;
    }

    /**
     * 设置左侧固定列数
     * @param string $value 列数
     * @return $this
     */
    public function setFixedLeft($value = 1)
    {
        $this->_vars['fixed_left'] = $value;
        return $this;
    }

    /**
     * 设置右侧固定列数
     * @param string $value 列数
     * @return $this
     */
    public function setFixedRight($value = 1)
    {
        $this->_vars['fixed_right'] = $value;
        return $this;
    }
}
