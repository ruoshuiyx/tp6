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
use think\facade\Route;
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
        'page_title'         => '',       // 页面标题
        'page_tips'          => '',       // 页面提示
        'tips_type'          => '',       // 提示类型
        'extra_js'           => '',       // 额外JS代码
        'extra_css'          => '',       // 额外CSS代码
        'columns'            => [],       // 表格列集合
        'row_list'           => [],       // 表格数据列表
        'page'               => '',       // 分页数据
        'page_size'          => '',       // 分页信息
        'empty_tips'         => '暂无数据',// 空数据提示信息
        'hide_checkbox'      => false,    // 是否隐藏第一列多选
        'extra_html'         => '',       // 额外HTML代码
        'right_buttons'      => [],       // 表格右侧按钮
        'primary_key'        => 'id',     // 表格主键名称




        'order_columns'      => [],       // 需要排序的列表头
        'filter_columns'     => [],       // 需要筛选功能的列表头
        'filter_map'         => [],       // 字段筛选的排序条件
        '_field_display'     => [],       // 字段筛选的默认选项
        '_filter_content'    => [],       // 字段筛选的默认选中值
        '_filter'            => [],       // 字段筛选的默认字段名
        'top_buttons'        => [],       // 顶部栏按钮

        'search'             => [],       // 搜索参数
        'search_button'      => false,    // 搜索按钮


        '_table'             => '',       // 表名
        'js_list'            => [],       // js文件名
        'css_list'           => [],       // css文件名
        'validate'           => '',       // 快速编辑的验证器名
        '_js_files'          => [],       // js文件
        '_css_files'         => [],       // css文件
        '_select_list'       => [],       // 顶部下拉菜单列表
        '_filter_time'       => [],       // 时间段筛选

        '_search_area'       => [],       // 搜索区域
        '_search_area_url'   => '',       // 搜索区域url
        '_search_area_op'    => '',       // 搜索区域匹配方式
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
    public function fetch(string $template = '', bool $renderContent = false)
    {

        // 编译表格数据row_list的值
        $this->compileRows();

        // 单独设置模板
        if ($template != '') {
            $this->_template = $template;
        }
        View::assign($this->_vars);

        return View::fetch($this->_template, $renderContent);
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
            $pos != '' && $pos = '_'.$pos;
            $this->_vars['extra_html'.$pos] = $extra_html;
        }
        return $this;
    }

    /**
     * 添加一列
     * @param string $name    字段名称
     * @param string $title   字段别名
     * @param string $type    单元格类型
     * @param string $default 默认值
     * @param string $param   额外参数
     * @param string $class   css类名
     * @return $this
     */
    public function addColumn($name = '', $title = '', $type = '', $default = '', $param = '', $class = 't_c')
    {
        $column = [
            'name'    => $name,
            'title'   => $title,
            'type'    => $type,
            'default' => $default,
            'param'   => $param,
            'class'   => $class,
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
     * 设置表格数据列表
     * @param array|object $row_list 表格数据
     * @return $this
     */
    public function setRowList($row_list = null)
    {
        if ($row_list !== null) {
            // 转为数组后的表格数据
            $this->_vars['row_list'] = $row_list;

            if (is_object($row_list)) {
                // 设置分页左侧信息
                $this->setPages($row_list->render());
                // 设置分页右侧信息
                $this->_vars['page_size'] = page_size(10, $row_list->total());
            }
        }
        return $this;
    }

    /**
     * 设置分页
     * @param string $pages 分页数据
     * @return $this
     */
    public function setPages($pages = '')
    {
        if ($pages != '') {
            $this->_vars['page'] = $pages;
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
                    'title' => '编辑',
                    'icon'  => 'fa fa-edit',
                    'class' => 'btn btn-flat btn-info btn-xs',
                    'href'  => url('edit', ['id' => '__id__']),
                    'target' => '_self'
                ];
                break;

            // 删除按钮(不可恢复)
            case 'delete':
                // 默认属性
                $btn_attribute = [
                    'title' => '删除',
                    'icon'  => 'fa fa-trash-o',
                    'class' => 'btn btn-flat btn-warning btn-xs confirm',
                    'href'  => url('del', ['id' => '__id__']),
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
                    $this->addRightButton($key, $value);
                }
            }
        }
        return $this;
    }

    /**
     * 编译表格数据row_list的值(根据type类型设置不同显示样式)
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


}
