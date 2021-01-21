<?php
/**
 * +----------------------------------------------------------------------
 * | 演示/测试控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/11/19
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
use think\facade\Request;

// 引入表格和表单构建器
use app\common\facade\MakeBuilder;
use app\common\builder\FormBuilder;
use app\common\builder\TableBuilder;

class Test extends Base
{
    // 表单构建器：添加页面演示
    public function add()
    {
        $color  = ['green' => '绿色', 'red' => '红色', 'yellow' => '黄色'];
        $images = [
            [
                'image' => '图片地址一',
                'title' => '第一张图'
            ],
            [
                'image' => '图片地址二',
                'title' => '第二张图'
            ],
        ];
        $btn    = [
            'icon'      => 'fa fa-plus-circle',
            'target'    => '_blank',
            'href'      => url('add'),
            'class'     => 'btn-success',
            'disabled'  => '',
            'id'        => 'newid',
            'data-url'  => 'http://siyucms.com',
            'data-url2' => 'http://siyucms.com',
        ];
        // 额外js
        $js        = '<script type="text/javascript">
                $(function(){
                    alert("额外js...");
                })
            </script>';
        // 页面标题
        $pageTitle = '<div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">自定义标题<small>副标题</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">自定义</a></li>
                </ol>
            </div>
        </div>';

        return FormBuilder::getInstance()
            ->addText('title', '单行文本', '提示信息', '默认值', ['<i class="fa fa-user"></i>', '元'], 'extra_attr', 'extra_class', 'placeholder', true)
            ->addTextarea('remarks', '多行文本', '提示信息', '默认值', 'extra_attr', 'extra_class', 'placeholder', true)
            ->addCode('codes', '编辑器', '提示信息', '', 'extra_attr', 'extra_class', true)
            ->addRadio('color', '单选', '提示信息', $color, 'red', 'extra_attr', 'extra_class', true)
            ->addCheckbox('colors', '多选', '提示信息', $color, 'red,yellow', 'extra_attr', 'extra_class', true)
            ->addDate('visit_date', '日期', '提示信息', '0', '', 'extra_attr', 'extra_class', '请选择或输入', true)
            ->addTime('visit_time', '时间', '提示信息', '0', '', 'extra_attr', 'extra_class', '请选择或输入', true)
            ->addDatetime('visit_date_time', '日期时间', '提示信息', '', '', 'extra_attr', 'extra_class', '请选择或输入', true)
            ->addDaterange('visit_range', '日期范围', '提示信息', '', '', 'extra_attr', 'extra_class', true)
            ->addTag('tags', '标签', '提示信息', '阿斯頓法定,fff', 'extra_attr', 'extra_class', true)
            ->addNumber('goods_number', '数字框', '提示信息', '333', '300', '400', '1', 'extra_attr', 'extra_class', true)
            ->addPassword('user_password', '密码框', '提示信息', '默认值', 'extra_attr', 'extra_class', '请填写用户密码', true)
            ->addSelect('user_color', '下拉菜单', '提示信息', $color, 'red', 'extra_attr', 'extra_class', '请选择颜色', true)
            ->addSelect2('my_color', 'select2下拉', '提示信息', $color, 'red', '', 'extra_class', '请选择颜色', true, '')
            ->addImage('pic', '单图上传', '提示信息', '', '', 'extra_class', '', true)
            ->addImages('pics', '多图上传', '提示信息', $images, '', 'extra_class', '', true)
            ->addFile('download', '单文件上传', '提示信息', '', '', 'extra_class', '', true)
            ->addFiles('downloads', '多文件上传', '提示信息', '', '', 'extra_class', '', true)
            ->addEditor('content', '内容', '提示信息', '', '', '', 'extra_class', true)
            ->addButton('test', '自定义')
            ->addButton('test_a', '自定义', $btn, 'a')
            ->addHidden('hide_id', '13', 'extra_attr', 'extra_class')
            ->addColor('color', '请选择颜色', '', '', 'extra_attr', 'extra_class', '请选择', true)
            ->addHtml('<img src="https://www.baidu.com/img/bd_logo1.png">')
            ->setFormData(['visit_date' => '2020-12-10'])
            ->setPageTitle($pageTitle)
            ->setPageTips('这是页面提示信息', 'warning', 'top')
            ->setFormUrl(url('addSave'))
            ->setBtnTitle(['submit' => '确定', 'back' => '返回上一页'])
            ->addBtn('<button type="button" class="btn btn-flat btn-default">额外按钮1</button>')
            ->addBtn('<button type="button" class="btn btn-flat btn-default">额外按钮2</button>')
            ->setExtraHtml('<p>这是页面底部的一段文字</p>', 'content_bottom')
            ->setExtraJs($js)
            ->submitConfirm()
            ->fetch();
    }

    // 表单构建器：添加页面分组演示
    public function addGroup()
    {
        $groups = [
            '分组一' => [
                ['text', 'title', '单行文本1', '提示信息', '默认值', ['<i class="fa fa-user"></i>', '元'], 'extra_attr', 'extra_class', 'placeholder', true],
                ['textarea', 'remarks', '多行文本1', '提示信息', '默认值', 'extra_attr', 'extra_class', 'placeholder', true]

            ],
            '分组二' => [
                ['text', 'title2', '单行文本2', '提示信息', '默认值', ['<i class="fa fa-user"></i>', '元'], 'extra_attr', 'extra_class', 'placeholder', true],
                ['textarea', 'remarks2', '多行文本2', '提示信息', '默认值', 'extra_attr', 'extra_class', 'placeholder', true]
            ]
        ];

        return FormBuilder::getInstance()
            ->addGroup($groups)
            ->fetch();
    }

    // 表格构建器：列表页面演示
    public function list()
    {
        $pageTitle = '<div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">自定义标题<small>副标题</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">自定义</a></li>
                </ol>
            </div>
        </div>';
        $js        = '<script type="text/javascript">
                $(function(){
                    alert("额外js...");
                })
            </script>';
        $css       = '<style>.alert-success {color: #fff;background-color: #F44336;border-color: #F44336;}</style>';
        $html      = '<p>这是页面头部的一段文字</p>';

        // 获取搜索数据
        $search = MakeBuilder::getListSearch('users');

        $searchArr = [
            [
                0 => "text",
                1 => "name",
                2 => "广告名称",
                3 => "LIKE",
                4 => "",
                5 => [],
                6 => 0,
                7 => "",
                8 => "",
                9 => 110
            ],
            [
                "radio",
                "status",
                "状态",
                "=",
                "",
                [
                    1 => "显示",
                    0 => "隐藏",
                ],
                1,
                "",
                "",
                108
            ],
        ];

        return TableBuilder::getInstance()
            ->setUniqueId('id')
            ->setPageTitle($pageTitle)
            ->setPageTips('这是页面提示信息', 'success', 'bottom')
            //->setExtraJs($js)
            ->setExtraCss($css)
            ->setExtraHtml($html, 'content_top')
            ->setDataUrl(url('ad/index', ['getList' => '1']))
            ->addColumn('id', '编号')
            ->addColumn('type_id', '广告位')
            ->addColumn('name', '广告名称')
            ->addColumn('email', '邮箱账号', 'link', url('user', ['id' => '__id__','email' => '__email__']),'','','true')
            ->addTopButtons(['add' => [
                'title'       => '增加',
                'icon'        => 'fa fa-lightbulb',
                'class'       => 'btn btn-danger',
                'href'        => 'http://www.siyucms.com',
                'target'      => '_blank',
                'onclick'     => ''
            ], 'edit', 'del'])
            ->addTopButton('default', [
                'title'       => '去看看',
                'icon'        => 'fa fa-lightbulb',
                'class'       => 'btn btn-danger',
                'href'        => 'http://www.siyucms.com',
                'target'      => '_blank',
                'onclick'     => ''
            ]) // 自定义按钮
            ->setSearch($searchArr)
            ->fetch();
    }

    // 生成器
    public function make()
    {
        // 获取主键
        $pk = MakeBuilder::getPrimarykey('users');

        // 获取某个表中所有的字段信息
        $fields = MakeBuilder::getFields('users');

        // 获取添加页面可展示的字段信息
        $coloumns = MakeBuilder::getAddColumns('users');

        // 获取搜索数据
        $search = MakeBuilder::getListSearch('ad');
        halt($search);
    }

    // 日志查看
    public function log()
    {
        $file = root_path() . 'runtime' . DIRECTORY_SEPARATOR . 'log';
        $temp = scandir($file);
        // 遍历文件夹
        $result    = [];
        $resultAll = [];
        foreach ($temp as $v) {
            $log = $file . DIRECTORY_SEPARATOR . $v;
            if (file_exists($log) && $v !== '.' && $v !== '..') {
                // 读取文件内容
                $info = fopen($log, "r");
                // 输出文本中所有的行，直到文件结束为止。
                while (!feof($info)) {
                    // fgets()函数从文件指针中读取一行
                    $itemStr = fgets($info);
                    // 判断是否包含index.js
                    if (strpos($itemStr, 'ad.js') !== false) {
                        preg_match("/(http|https):\/\/([\w\d\-_]+[\.\w\d\-_]+)[:\d+]?([\/]?[\w\/\.]+)/i", $itemStr, $domain);
                        if (isset($domain[2])) {
                            // 放入数组，方便计算,去除重复
                            $a = $result[$v] ?? [];
                            // 记录到当前数组
                            if (!in_array($domain[2], $a)) {
                                $result[$v][] = $domain[2];
                            }
                            if (!in_array($domain[2], $resultAll)) {
                                $resultAll[] = $domain[2];
                            }
                        }
                    }
                }
                fclose($info);
            }
        }
        dump($result, $resultAll);
    }

    // 生成网站地图
    public function siteMap()
    {
        // 参数设置
        $config = [
            'index_changefreq' => ''
        ];

        $filename = public_path() . "sitemap.xml";

        $xml_wrapper = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
</urlset>
XML;

        if (function_exists('simplexml_load_string')) {
            $xml = @simplexml_load_string($xml_wrapper);
        } else if (class_exists('SimpleXMLElement')) {
            $xml = new SimpleXMLElement($xml_wrapper);
        }

        for ($i = 1; $i < 10; $i++) {
            $item = $xml->addChild('url'); // 使用addChild添加节点
            $item->addChild('loc', 'https://123.com'); // URL链接地址
            $item->addChild('lastmod', '2009-12-14'); //  该链接的最后更新时间
            $item->addChild('changefreq', '2009-12-14'); //  更新频率[always ，hourly ，daily ，weekly ，monthly ，yearly ，never]
            $item->addChild('priority', '0.8'); // 优先权比值，此值定于0.0-1.0之间
        }

        $content = $xml->asXML(); //用asXML方法输出xml，默认只构造不输出。
        @file_put_contents($filename, $content);
        exit;


        /*所有栏目*/
        foreach ($result_arctype as $sub) {
            if (is_array($sub)) {
                $item = $xml->addChild('url'); //使用addChild添加节点
                foreach ($sub as $key => $row) {
                    if (in_array($key, array('loc', 'lastmod', 'changefreq', 'priority'))) {
                        if ($key == 'loc') {
                            if ($sub['is_part'] == 1) {
                                $row = $sub['typelink'];
                            } else {
                                $row = get_typeurl($sub, false);
                            }
                            $row = str_replace('&amp;', '&', $row);
                            $row = str_replace('&', '&amp;', $row);
                        } else if ($key == 'lastmod') {
                            $row = date('Y-m-d');
                        } else if ($key == 'changefreq') {
                            $row = $sitemap_changefreq_list;
                        } else if ($key == 'priority') {
                            $row = $sitemap_priority_list;
                        }
                        try {
                            $node = $item->addChild($key, $row);
                        } catch (\Exception $e) {
                        }
                        if (isset($attribute_array[$key]) && is_array($attribute_array[$key])) {
                            foreach ($attribute_array[$key] as $akey => $aval) {//设置属性值，我这里为空
                                $node->addAttribute($akey, $aval);
                            }
                        }
                    }
                }
            }
        }
        /*--end*/

        /*所有文档*/
        foreach ($result_archives as $val) {
            if (is_array($val) && isset($result_arctype[$val['typeid']])) {
                $item = $xml->addChild('url'); //使用addChild添加节点
                $val  = array_merge($result_arctype[$val['typeid']], $val);
                foreach ($val as $key => $row) {
                    if (in_array($key, array('loc', 'lastmod', 'changefreq', 'priority'))) {
                        if ($key == 'loc') {
                            if ($val['is_jump'] == 1) {
                                $row = $val['jumplinks'];
                            } else {
                                $row = get_arcurl($val, false);
                            }
                            $row = str_replace('&amp;', '&', $row);
                            $row = str_replace('&', '&amp;', $row);
                        } else if ($key == 'lastmod') {
                            $lastmod_time = empty($val['update_time']) ? $val['add_time'] : $val['update_time'];
                            $row          = date('Y-m-d', $lastmod_time);
                        } else if ($key == 'changefreq') {
                            $row = $sitemap_changefreq_view;
                        } else if ($key == 'priority') {
                            $row = $sitemap_priority_view;
                        }
                        try {
                            $node = $item->addChild($key, $row);
                        } catch (\Exception $e) {
                        }
                        if (isset($attribute_array[$key]) && is_array($attribute_array[$key])) {
                            foreach ($attribute_array[$key] as $akey => $aval) {//设置属性值，我这里为空
                                $node->addAttribute($akey, $aval);
                            }
                        }
                    }
                }
            }
        }
        /*--end*/

        $content = $xml->asXML(); //用asXML方法输出xml，默认只构造不输出。
        @file_put_contents($filename, $content);
    }

    // 批量插入数据
    public function addList()
    {
        $adType = new \app\common\model\AdType();

        $list = [];
        for ($i = 1; $i < 50000; $i++) {
            $list[] = [
                'create_time' => '1580372431',
                'update_time' => '1580372431',
                'name'        => $i,
                'description' => '',
                'sort'        => 50,
                'status'      => 1,
            ];
        }

        $adType->saveAll($list);
    }


}
