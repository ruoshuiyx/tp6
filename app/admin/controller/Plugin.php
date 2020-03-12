<?php
/**
 * +----------------------------------------------------------------------
 * | 插件管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2020/03/11
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

use think\facade\Request;
use think\facade\View;

// 表单和表格构建器
use app\common\builder\FormBuilder;
use app\common\builder\TableBuilder;


class Plugin extends Base
{
    // 列表
    public function index()
    {
        // 搜索
        if (Request::param('getList') == 1) {
            // 获取插件列表
            $list = $this->getPlugins();
            // 渲染输出
            $result = [
                'total'        => count($list),
                'per_page'     => 1000,
                'current_page' => 1,
                'last_page'    => 1,
                'data'         => $list,
            ];
            return $result;
        }
        return TableBuilder::getInstance()
            ->addColumns([ // 批量添加列
                ['name', '编号'],
                ['title', '插件名称'],
                ['description', '插件介绍'],
                ['status', '状态(安装/卸载)', 'status', '0',[
                    ['0' => '未安装'],
                    ['1' => '已安装']
                ]],
                ['author', '作者'],
                ['version', '版本'],
                ['right_button', '操作', 'btn']
            ])
            ->setUniqueId('name')
            ->addRightButton('edit', ['title' => '配置'])
            ->setEditUrl(url('config', ['name' => '__id__']))
            ->addTopButtons([])            // 设置顶部按钮组
            ->fetch();
    }

    // 插件配置信息预览
    public function config(string $name)
    {
        $path = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name;
        if (!is_dir($path)) {
            $this->error('未发现该插件，请先安装');
        }
        // 实例化插件
        $object = $this->getInstance($name);
        if ($object) {
            // 获取插件基础信息
            $info = $object->getInfo();
            if (!$info) {
                $this->error('未找到该插件的信息');
            }
            // 获取插件配置信息
            $config = $this->getConfig($name);

            // 如果插件自带配置模版的话加载插件自带的，否则调用表单构建器
            $file = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'config.html';
            if (file_exists($file)) {
                View::assign([
                    'plugin' => $info,
                    'config' => $config
                ]);
                return View::fetch($file);
            } else {
                $columns = $this->makeAddColumns($config);
                return FormBuilder::getInstance()
                    ->setFormUrl(url('configSave'))
                    ->addHidden('id', $name)
                    ->addFormItems($columns)
                    ->fetch();
            }
        } else {
            $this->error('插件实例化失败');
        }
    }

    // 插件配置信息保存
    public function configSave()
    {
        if (Request::isPost()) {
            $data = Request::except(['file'], 'post');
            $path = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $data['id'];
            if (!is_dir($path)) {
                $this->error('未发现该插件，请先安装');
            }
            // 实例化插件
            $object = $this->getInstance($data['id']);
            if ($object) {
                // 获取插件基础信息
                $info = $object->getInfo();
                if (!$info) {
                    $this->error('未找到该插件的基础信息');
                }
                // 获取插件配置信息
                $config = $this->getConfig($data['id']);
                if ($data) {
                    foreach ($config as $k => $v) {
                        if (isset($data[$k])) {
                            $value = is_array($data[$k]) ? implode(',', $data[$k]) : ($data[$k] ?? $v['value']);
                            $config[$k]['value'] = $value;
                        }
                    }
                }
                // 更新配置文件
                $result = $this->setPluginConfig($data['id'], $config);
                if ($result['code'] == 0) {
                    $this->success('插件信息保存成功!', 'index');
                } else {
                    $this->error($result['code']);
                }
            }

        }

    }

    // 更改插件状态 [安装/卸载]
    public function state(string $id)
    {
        $path = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $id;
        if (!is_dir($path)) {
            $this->error('未发现该插件');
        }
        // 实例化插件
        $object = $this->getInstance($id);
        // 获取插件基础信息
        $info = $object->getInfo();
        if (!$info) {
            $this->error('未找到该插件的信息');
        }
        if ($info['status'] == 1) {
            // 卸载
            if (false !== $object->uninstall()) {
                $info['status'] = 0;
                $result = $this->setPluginIni($id, $info);
                if ($result['code'] == 0) {
                    $this->success('卸载成功!');
                } else {
                    $this->error($result['code']);
                }
            } else {
                $this->error('插件卸载失败');
            }
        } else {
            // 安装
            /*// 读取插件基类的方法
            $base = get_class_methods("\\think\\Addons");
            // 读取出当前插件的方法
            $methods = (array)get_class_methods($object);
            // 跟插件基类方法做比对，得到差异结果
            $hooks = array_diff($methods, $base);*/
            if (false !== $object->install()) {
                $info['status'] = 1;
                $result = $this->setPluginIni($id, $info);
                if ($result['code'] == 0) {
                    $this->success('安装成功!');
                } else {
                    $this->error($result['msg']);
                }
            } else {
                $this->error('插件安装失败');
            }
        }
    }

    // =========================================

    // 获取插件实例
    private function getInstance($file)
    {
        $class = "\\addons\\{$file}\\Plugin";
        if (class_exists($class)) {
            // 容器类的工作由think\Container类完成，但大多数情况我们只需要通过app助手函数或者think\App类即可容器操作
            return app($class);
        }
        return false;
    }

    // 获取完整配置列表[config.php]
    private function getConfig(string $name)
    {
        $file = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'config.php';
        if (file_exists($file)) {
            return include $file;
        } else {
            return false;
        }
    }

    // 生成表单信息
    private function makeAddColumns(array $config)
    {
        $columns = [];
        foreach ($config as $k => $field) {
            // 初始化
            $field['name'] = $field['name'] ?? $field['title'];
            $field['field'] = $k;
            $field['tips'] = $field['tips'] ?? '';
            $field['required'] = $field['required'] ?? 0;
            $field['group'] = $field['group'] ?? '';
            if (!isset($field['setup'])) {
                $field['setup'] = [
                    'default' => $field['value'] ?? '',
                    'extra_attr' => $field['extra_attr'] ?? '',
                    'extra_attr' => $field['extra_attr'] ?? '',
                    'extra_class' => $field['extra_class'] ?? '',
                    'placeholder' => $field['placeholder'] ?? '',
                ];
            }

            if ($field['type'] == 'text') {
                $columns[] = [
                    $field['type'],                // 类型
                    $field['field'],               // 字段名称
                    $field['name'],                // 字段别名
                    $field['tips'],                // 提示信息
                    $field['setup']['default'],    // 默认值
                    $field['group'],               // 标签组，可以在文本框前后添加按钮或者文字
                    $field['setup']['extra_attr'], // 额外属性
                    $field['setup']['extra_class'],// 额外CSS
                    $field['setup']['placeholder'],// 占位符
                    $field['required'],            // 是否必填
                ];
            }
            elseif ($field['type'] == 'textarea' || $field['type'] == 'password') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['extra_attr'],        // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['setup']['placeholder'] ?? '', // 占位符
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'radio' || $field['type'] == 'checkbox') {
                $columns[] = [
                    $field['type'],                // 类型
                    $field['field'],               // 字段名称
                    $field['name'],                // 字段别名
                    $field['tips'],                // 提示信息
                    $field['options'],             // 选项（数组）
                    $field['setup']['default'],    // 默认值
                    $field['setup']['extra_attr'], // 额外属性 extra_attr
                    '',                            // 额外CSS extra_class
                    $field['required'],            // 是否必填
                ];
            }
            elseif ($field['type'] == 'select' || $field['type'] == 'select2' ) {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['options'],                    // 选项（数组）
                    $field['setup']['default'],           // 默认值
                    $field['setup']['extra_attr'],        // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['setup']['placeholder'] ?? '', // 占位符
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'number') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    '',                                   // 最小值
                    '',                                   // 最大值
                    $field['setup']['step'],              // 步进值
                    $field['setup']['extra_attr'],        // 额外属性
                    $field['setup']['extra_class'],       // 额外CSS
                    $field['setup']['placeholder'] ?? '', // 占位符
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'hidden') {
                $columns[] = [
                    $field['type'],                      // 类型
                    $field['field'],                     // 字段名称
                    $field['setup']['default'] ?? '',    // 默认值
                    $field['setup']['extra_attr'] ?? '', // 额外属性 extra_attr
                ];
            }
            elseif ($field['type'] == 'date' || $field['type'] == 'time' || $field['type'] == 'datetime') {
                // 使用每个字段设定的格式
                if ($field['type'] == 'time') {
                    $field['setup']['format'] = str_replace("HH", "h", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("mm", "i", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("ss", "s", $field['setup']['format']);
                    $format = $field['setup']['format'] ?? 'H:i:s';
                } else {
                    $field['setup']['format'] = str_replace("yyyy", "Y", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("mm", "m", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("dd", "d", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("hh", "h", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("ii", "i", $field['setup']['format']);
                    $field['setup']['format'] = str_replace("ss", "s", $field['setup']['format']);
                    $format = $field['setup']['format'] ?? 'Y-m-d H:i:s';
                }
                $field['setup']['default'] = $field['setup']['default'] > 0 ? date($format, $field['setup']['default']) : '';
                $columns[] = [
                    $field['type'],                // 类型
                    $field['field'],               // 字段名称
                    $field['name'],                // 字段别名
                    $field['tips'],                // 提示信息
                    $field['setup']['default'],    // 默认值
                    $field['setup']['format'],     // 日期格式
                    $field['setup']['extra_attr'], // 额外属性 extra_attr
                    '',                            // 额外CSS extra_class
                    $field['setup']['placeholder'],// 占位符
                    $field['required'],            // 是否必填
                ];
            }
            elseif ($field['type'] == 'daterange') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['format'],            // 日期格式
                    $field['setup']['extra_attr'] ?? '',  // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'tag') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['extra_attr'] ?? '',  // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'image' || $field['type'] == 'images' || $field['type'] == 'file' || $field['type'] == 'files') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['size'],              // 限制大小（单位kb）
                    $field['setup']['ext'],               // 文件后缀
                    $field['setup']['extra_attr'] ?? '',  // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['setup']['placeholder'] ?? '', // 占位符
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'editor') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['heidht'] ?? 0,       // 高度
                    $field['setup']['extra_attr'] ?? '',  // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['required'],                   // 是否必填
                ];
            }
            elseif ($field['type'] == 'color') {
                $columns[] = [
                    $field['type'],                       // 类型
                    $field['field'],                      // 字段名称
                    $field['name'],                       // 字段别名
                    $field['tips'],                       // 提示信息
                    $field['setup']['default'],           // 默认值
                    $field['setup']['extra_attr'] ?? '',  // 额外属性
                    $field['setup']['extra_class'] ?? '', // 额外CSS
                    $field['setup']['placeholder'] ?? '', // 占位符
                    $field['required'],                   // 是否必填
                ];
            }
        }
        return $columns;
    }

    /**
     * 获得本地插件列表
     * 目前只获取本地插件，后期会扩展为获取线上插件，然后通过比对的方式判断是否需要在安装的时候先下载插件
     * @return array
     */
    private function getPlugins()
    {
        $plugins = scandir(app()->getRootPath() . 'addons');
        $list = [];
        foreach ($plugins as $name) {
            if ($name === '.' or $name === '..')
                continue;
            if (is_file(app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name))
                continue;
            $addonDir = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
            if (!is_dir($addonDir))
                continue;

            $object = $this->getInstance($name);
            if ($object) {
                // 获取插件基础信息
                $info = $object->getInfo();
                $list[] = $info;
            }
        }
        return $list;
    }

    /**
     * 更新插件的ini文件
     * @param string $name 插件名
     * @param array $array
     * @return boolean
     * @throws Exception
     */
    private function setPluginIni($name, $array)
    {
        $file = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'info.ini';
        if (!$this->checkFileWritable($file)) {
            return [
                'code' => 1,
                'msg' => '文件没有写入权限',
            ];
        }
        // 拼接要写入的数据
        $str = '';
        foreach ($array as $k => $v) {
            $str .= $k . " = " . $v . "\n";
        }
        if ($handle = fopen($file, 'w')) {
            fwrite($handle, $str);
            fclose($handle);
        } else {
            return [
                'code' => 1,
                'msg'  => '文件没有写入权限',
            ];
        }
        return [
            'code' => 0,
            'msg' => '文件写入完毕',
        ];
    }

    /**
     * 更新插件的配置文件
     * @param string $name 插件名
     * @param array $array
     * @return boolean
     * @throws Exception
     */
    private function setPluginConfig($name, $array)
    {
        $file = app()->getRootPath() . 'addons' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'config.php';
        if (!$this->checkFileWritable($file)) {
            return [
                'code' => 1,
                'msg' => '文件没有写入权限',
            ];
        }
        if ($handle = fopen($file, 'w')) {
            fwrite($handle, "<?php\n\n" . "return " . var_export($array, TRUE) . ";\n");
            fclose($handle);
        } else {
            return [
                'code' => 1,
                'msg'  => '文件没有写入权限',
            ];
        }
        return [
            'code' => 0,
            'msg' => '文件写入完毕',
        ];
    }

    /**
     * 判断文件或目录是否可写
     * @param    string $file 文件或目录
     * @return    bool
     */
    private function checkFileWritable($file)
    {
        if (is_dir($file)) {
            // 判断目录是否可写
            return is_writable($file);
        } elseif (file_exists($file)) {
            // 文件存在则判断文件是否可写
            return is_writable($file);
        } else {
            // 文件不存在则判断当前目录是否可写
            $file = pathinfo($file, PATHINFO_DIRNAME);
            return is_writable($file);
        }
    }
}
