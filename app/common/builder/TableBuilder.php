<?php
/**
 * +----------------------------------------------------------------------
 * | 表格快速构造器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/08/05
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
        'page_title'         => '',        // 页面标题
        'page_tips'          => '',        // 页面提示
        'page_tips_top'      => '',        // 页面提示[top]
        'page_tips_search'   => '',        // 页面提示[search]
        'page_tips_bottom'   => '',        // 页面提示[bottom]
        'tips_type'          => '',        // 页面提示类型
        'extra_js'           => '',        // 额外JS代码
        'extra_css'          => '',        // 额外CSS代码
        'extra_html'         => '',        // 额外HTML代码
        'columns'            => [],        // 表格列集合
        'right_buttons'      => [],        // 表格右侧按钮
        'top_buttons'        => [],        // 顶部栏按钮组[toolbar]
        'unique_id'          => 'id',      // 表格主键名称，（默认为id，如表主键不为id必须设置主键）
        'data_url'           => '',        // 表格数据源
        'add_url'            => '',        // 默认的新增地址
        'edit_url'           => '',        // 默认的修改地址
        'del_url'            => '',        // 默认的删除地址
        'export_url'         => '',        // 默认的导出地址
        'sort_url'           => '',        // 默认的排序地址
        'search'             => [],        // 搜索参数
        'pagination'         => 'true',    // 是否进行分页
        'empty_tips'         => '暂无数据', // 空数据提示信息[待完善]
        'hide_checkbox'      => false,     // 是否隐藏第一列多选[待完善]

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
     * @param string $template       模板文件名或者内容
     * @param bool   $renderContent  是否渲染内容
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
            $this->_vars['tips_type'] = trim($type) ?? 'info';
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
     * @return $this
     */
    public function addColumn($name = '', $title = '', $type = '', $default = '', $param = '', $class = '', $sortable = 'false')
    {
        $column = [
            'name'    => $name,
            'title'   => $title,
            'type'    => $type,
            'default' => $default,
            'param'   => $param,
            'class'   => $class,
            'sortable'=> $sortable,
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
     * @param string $type       按钮类型：edit/delete/default
     * @param array $attribute   按钮属性
     * @param array $extra       扩展参数(待用)
     * @return $this
     */
    public function addRightButton($type = '', $attribute = [])
    {
        switch ($type) {
            // 编辑按钮
            case 'edit':
                // 默认属性
                $btn_attribute = [
                    'type'   => 'edit',
                    'title'  => '编辑',
                    'icon'   => 'fa fa-edit',
                    'class'  => 'btn btn-primary btn-xs',
                ];
                break;

            // 删除按钮(不可恢复)
            case 'delete':
                // 默认属性
                $btn_attribute = [
                    'type'  => 'delete',
                    'title' => '删除',
                    'icon'  => 'fa fa-trash-o',
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
     * 例如：
     * $builder->addRightButtons('edit');
     * $builder->addRightButtons('edit,delete');
     * $builder->addRightButtons(['edit', 'delete']);
     * $builder->addRightButtons(['edit' => ['title' => '查看'], 'delete']);
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
     * 编译表格数据row_list的值(根据type类型设置不同显示样式),已废弃
     */
    private function compileRows()
    {
        foreach ($this->_vars['row_list'] as $key => &$row) {
            // 编译右侧按钮
            if ($this->_vars['right_buttons']) {
                foreach ($this->_vars['right_buttons'] as $index => $button) {
                    // 处理主键变量值
                    $button['href'] = preg_replace(
                        '/__id__/i',
                        $row[$this->_vars['primary_key']],
                        $button['href']
                    );

                    // 替换其他字段值
                    if (preg_match_all('/__(.*?)__/', $button['href'], $matches)) {
                        // 要替换的字段名
                        $replace_to = [];
                        $pattern    = [];
                        foreach ($matches[1] as $match) {
                            $replace = in_array($match, $this->rawField) ? $this->getData($key, $match) : (isset($row[$match]) ? $row[$match] : '');
                            if (isset($row[$match])) {
                                $pattern[]    = '/__'. $match .'__/i';
                                $replace_to[] = $replace;
                            }
                        }
                        $button['href'] = preg_replace(
                            $pattern,
                            $replace_to,
                            $button['href']
                        );
                    }

                    // 编译按钮属性
                    $button['attribute'] = $this->compileHtmlAttr($button);
                    // 拼接按钮
                    $row['right_button'] .= '<a data-id="'.$row[$this->_vars['primary_key']].'" '.$button['attribute'].'">';
                    if ($button['icon']) {
                        $row['right_button'] .= '<i class="'.$button['icon'].'"></i> ';
                    }
                    $row['right_button'] .= $button['title'].'</a> ';
                }
                // 合并按钮并赋值给最后一行
                $row['right_button'] = '<div>'. $row['right_button'] .'</div>';
            }
            // 编译单元格数据类型
            if ($this->_vars['columns']) {
                // 另外拷贝一份主键值，以免将主键设置为快速编辑的时候解析出错
                $row['_primary_key_value'] = isset($row[$this->_vars['primary_key']]) ? $row[$this->_vars['primary_key']] : '';

                foreach ($this->_vars['columns'] as $column) {
                    switch ($column['type']) {
                        case 'text':
                        case 'status': // 状态
                            $status = $row[$column['name']];
                            // 定义默认状态值
                            $list_status = !empty($column['param']) ? $column['param'] : ['禁用:warning', '启用:success'];

                            if (isset($list_status[$status])) {
                                // 定义默认颜色
                                switch ($status) {
                                    case '0': $class = 'warning';break;
                                    case '1': $class = 'success';break;
                                    case '2': $class = 'primary';break;
                                    case '3': $class = 'info';break;
                                    default: $class  = 'default';
                                }
                                // 重置文案和颜色(通过:分割)
                                if (strpos($list_status[$status], ':')) {
                                    list($label, $class) = explode(':', $list_status[$status]);
                                } else {
                                    //默认文案
                                    $label = $list_status[$status];
                                }
                                // 定义新的字段用于接收值
                                $row[$column['name'].'__'.$column['type']] = '<span class="label label-'.$class.'">'.$label.'</span>';
                            }
                            break;
                        case 'yesno': // 是/否
                            switch ($row[$column['name']]) {
                                case '0': // 否
                                    $row[$column['name'].'__'.$column['type']] = '<i class="fa fa-ban text-danger"></i>';
                                    break;
                                case '1': // 是
                                    $row[$column['name'].'__'.$column['type']] = '<i class="fa fa-check text-success"></i>';
                                    break;
                            }
                            break;
                        case 'link': // 链接
                            // 链接不能为空
                            if ($column['default'] != '') {
                                // 要替换的字段名
                                $replace_to = [];
                                $pattern    = [];
                                $url        = $column['default'];
                                $target     = $column['param'] == '' ? '_self' : $column['param'];
                                // 传参替换
                                if (preg_match_all('/__(.*?)__/', $column['default'], $matches)) {
                                    foreach ($matches[1] as $match) {
                                        $pattern[]    = '/__'. $match .'__/i';
                                        $replace_to[] = $row[$match];
                                    }
                                    $url = preg_replace($pattern, $replace_to, $url);
                                }
                                $row[$column['name'].'__'.$column['type']] = '<a href="'. $url .'"
                                    title="'. $row[$column['name']] .'"
                                    class="'. $column['class'] .'"
                                    target="'.$target.'">'.$row[$column['name']].'</a>';
                            }
                            break;
                        case 'image': // 单张图片
                            $row[$column['name'].'__'.$column['type']] = '<a href="'.$row[$column['name']].'" target="_blank"><img class="image_preview" src="'.$row[$column['name']].'"></a>';
                            break;
                        default: // 默认

                    }
                }
            }
        }
    }

    /**
     * 编译HTML属性(用于组合A等元素的各个属性)
     * @param array $attr 要编译的数据
     * @return array|string
     */
    private function compileHtmlAttr($attr = []) {
        $result = [];
        if ($attr) {
            foreach ($attr as $key => &$value) {
                if ($key == 'title') {
                    $value = trim(htmlspecialchars(strip_tags(trim($value))));
                } else {
                    $value = htmlspecialchars($value);
                }
                array_push($result, "$key=\"$value\"");
            }
        }
        return implode(' ', $result);
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
     * 第四个参数：匹配方式（默认为“=”，也可以是“<>，>，>=，<，<=，LIKE”等等）
     * 第五个参数：默认值
     * 第六个参数：额外参数（不同类型，用途不同）
     */
    public function setSearch($items = [])
    {
        if (!empty($items)) {
            foreach ($items as &$item) {
                $item['type']    = $item[0]; // 字段类型
                $item['name']    = $item[1]; // 字段名称
                $item['title']   = $item[2]; // 字段别名
                $item['option']  = isset($item[3]) ? $item[3] : '='; // 匹配方式
                $item['default'] = isset($item[4]) ? $item[4] : '';  // 默认值
                $item['param']   = isset($item[5]) ? $item[5] : [];  // 额外参数
            }
            $this->_vars['search'] = $items;
        }
        return $this;
    }

    /**
     * 添加一个顶部按钮[目前只能新窗口打开，暂时不考虑弹出层]
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
                    'title'       => '修改',
                    'icon'        => 'fa fa-edit',
                    'class'       => 'btn btn-primary single disabled',
                    'href'        => '',
                    'onclick'     => '$.operate.edit()',
                ];
                break;

            // 删除按钮
            case 'del':
                // 默认属性
                $btn_attribute = [
                    'title'       => '删除',
                    'icon'        => 'fa fa-remove',
                    'class'       => 'btn btn-danger multiple disabled',
                    'href'        => '',
                    'onclick'     => '$.operate.removeAll()'
                ];
                break;

            // 导出按钮
            case 'export':
                // 默认属性
                $btn_attribute = [
                    'title'       => '导出',
                    'icon'        => 'fa fa-download',
                    'class'       => 'btn btn-warning',
                    'href'        => '',
                    'onclick'     => '$.table.export()'
                ];
                break;

            // 生成按钮
            case 'build':
                // 默认属性
                $btn_attribute = [
                    'title'       => '代码生成',
                    'icon'        => 'fa fa-file-code-o',
                    'class'       => 'btn btn-info single disabled',
                    'href'        => '',
                    'onclick'     => '$.operate.build(\'\', \''.url('module/build').'\')'
                ];
                break;

            // 自定义按钮
            default:
                // 默认属性
                $btn_attribute = [
                    'title'       => '自定义',
                    'icon'        => 'fa fa-lightbulb-o',
                    'class'       => 'btn btn-default',
                    'href'        => '',
                    'onclick'     => ''
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
     * 例如：
     * addTopButtons('add')
     * addTopButtons('add, edit, del')
     * addTopButtons(['add', 'del'])
     * addTopButtons(['add' => ['title' => '增加'], 'del'])
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

}
