<?php
/**
 * +----------------------------------------------------------------------
 * | 插件服务类
 * +----------------------------------------------------------------------
 * test // 插件名称
 * ├── app           // 此文件夹中所有文件会覆盖到根目录的/app文件夹
 * ├── public        // 此文件夹中所有文件会覆盖到根目录的/public文件夹
 * ├── controller    // 此文件夹为插件控制器目录
 * ├── model         // 此文件夹为插件模型目录
 * ├── view          // 此文件夹为插件视图目录
 * ├── Plugin.php    // 此文件为插件核心安装卸载控制器,必需存在,且名称不可以变动
 * ├── config.php    // 插件配置文件,后台插件管理中配置中读取和保存的就是这个文件，必须存在，且名称不可以变动
 * ├── config.html   // 插件配置模板文件，优先获取此文件，不存在则调用表单构建器[可选]
 * ├── LICENSE       // 版权文件
 * ├── info.ini      // 插件信息文件,用于保存插件基本信息，不存在则读取Plugin中的配置
 * └── install.sql   // 插件数据库安装文件,此文件仅在插件安装时会进行导入，如重复安装可能会导致报错
 */
namespace app\admin\service;

use think\Facade;
use think\facade\Config;
use think\facade\Db;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ThinkAddons
{
    // 插件目录
    protected $addonsPath = '';

    // 插件安装需要复制的文件夹
    protected $copyDirs = [];

    // 构造方法
    public function __construct()
    {
        $this->addonsPath = app()->getRootPath() . 'addons';
        $this->copyDirs = [
            'app',    // 此文件夹中所有文件会覆盖到根目录的/app文件夹
            'public', // 此文件夹中所有文件会覆盖到根目录的/public文件夹
        ];
    }

    // 获得本地插件列表 [目前只获取本地插件，后期会扩展为获取线上插件]
    public function localAddons()
    {
        $plugins = scandir($this->addonsPath);
        $list = [];
        foreach ($plugins as $name) {
            if ($name === '.' or $name === '..')
                continue;
            if (is_file($this->addonsPath . DIRECTORY_SEPARATOR . $name))
                continue;
            $addonDir = $this->addonsPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
            if (!is_dir($addonDir))
                continue;

            $object = $this->getInstance($name);
            if ($object) {
                // 获取插件基础信息
                $info = $object->getInfo();

                // 增加右侧按钮组
                $str = '';
                if ($info['install'] == 1) {
                    // 已安装，增加配置按钮
                    $str .= '<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="$.operate.edit(\''.$name.'\')"><i class="fa fa-edit"></i> 配置</a> ';
                    $str .= '<a class="btn btn-danger btn-xs confirm" href="javascript:void(0)" onclick="$.operate.pluginUninstall(\'' . $name . '\')"><i class="fa fa-edit"></i> 卸载</a> ';
                } else {
                    // 未安装，增加安装按钮
                    $str = '<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="$.operate.pluginInstall(\'' . $name . '\')"><i class="fa fa-edit"></i> 安装</a>';
                }

                $info['button'] = $str;

                $list[] = $info;
            }
        }
        return $list;
    }

    // 获取插件信息
    public function config(string $name)
    {
        $check = $this->check($name);
        if ($check !== true) {
            return [
                'code' => 0,
                'msg' => $check
            ];
        }
        return $this->getConfig($name);
    }

    // 保存插件信息
    public function configPost(array $data = [])
    {
        $check = $this->check($data['id']);
        if ($check !== true) {
            return [
                'code' => 0,
                'msg' => $check
            ];
        }
        // 实例化插件
        $object = $this->getInstance($data['id']);
        if ($object) {

            // 获取插件配置信息
            $config = $this->getConfig($data['id']);
            // 判断是否分组
            $group = $this->checkConfigGroup($config);
            if ($data) {
                if ($group) {
                    // 开启分组
                    foreach ($config as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            if (isset($data[$kk])) {
                                $value = is_array($data[$kk]) ? implode(',', $data[$kk]) : ($data[$kk] ?? $vv['value']);
                                $config[$k][$kk]['value'] = $value;
                            }
                        }
                    }
                } else {
                    // 未开启分组
                    foreach ($config as $k => $v) {
                        if (isset($data[$k])) {
                            $value = is_array($data[$k]) ? implode(',', $data[$k]) : ($data[$k] ?? $v['value']);
                            $config[$k]['value'] = $value;
                        }
                    }
                }
            }
            // 更新配置文件
            $result = $this->setPluginConfig($data['id'], $config);
            if ($result['code'] == 1) {
                return [
                    'code' => 1,
                    'msg'  => '保存成功!'
                ];
            } else {
                return [
                    'code' => 0,
                    'msg'  => $result['msg']
                ];
            }
        } else {
            return [
                'code' => 0,
                'msg' => '插件实例化失败'
            ];
        }
    }

    // 启用插件或禁用插件
    public function state(string $name)
    {
        $check = $this->check($name);
        if ($check !== true) {
            return [
                'code' => 0,
                'msg' => $check
            ];
        }
        // 实例化插件
        $object = $this->getInstance($name);
        // 获取插件基础信息
        $info = $object->getInfo();
        if (!$info) {
            return [
                'code' => 0,
                'msg'  => '未找到该插件的信息'
            ];
        } else {
            // 请先安装
            if ($info['install'] != 1) {
                return [
                    'code' => 0,
                    'msg'  => '请先安装该插件',
                ];
            } else {
                return $this->changeStatus($name);
            }
        }
    }

    // 安装插件
    public function install(string $name)
    {
        // 实例化插件
        $object = $this->getInstance($name);
        // 获取插件基础信息
        $info = $object->getInfo();

        if (false !== $object->install()) {
            $info['status'] = 1;
            $info['install'] = 1;
            try {
                // 更新或创建插件的ini文件
                $result = $this->setPluginIni($name, $info);
                if ($result['code'] == 0) {
                    return [
                        'code' => 1,
                        'msg'  => $result['msg'],
                    ];
                }
                // 复制文件
                $this->copyDir($name);
                // 导入SQL
                $this->importsql($name);
            } catch (\Exception $e) {
                return [
                    'code' => 0,
                    'msg'  => '安装失败：' . $e->getMessage(),
                ];
            }
        } else {
            return [
                'code' => 0,
                'msg'  => '插件实例化失败',
            ];
        }
        return [
            'code' => 1,
            'msg'  => '插件安装成功',
        ];
    }

    // 卸载插件
    public function uninstall(string $name)
    {
        // 实例化插件
        $object = $this->getInstance($name);
        // 获取插件基础信息
        $info = $object->getInfo();

        if (false !== $object->install()) {
            $info['status'] = 0;
            $info['install'] = 0;
            // 更新或创建插件的ini文件
            $result = $this->setPluginIni($name, $info);
            if ($result['code'] == 0) {
                return [
                    'code' => 0,
                    'msg'  => $result['msg'],
                ];
            } else {
                return [
                    'code' => 1,
                    'msg'  => '插件卸载成功',
                ];
            }
        } else {
            return [
                'code' => 0,
                'msg'  => '插件实例化失败',
            ];
        }
    }

    // 启用/禁用插件
    public function changeStatus(string $name)
    {
        // 实例化插件
        $object = $this->getInstance($name);
        // 获取插件基础信息
        $info = $object->getInfo();

        if (false !== $object->install()) {
            $info['status'] = $info['status'] == 1 ? 0 : 1;
            try {
                // 更新或创建插件的ini文件
                $result = $this->setPluginIni($name, $info);
                if ($result['code'] == 0) {
                    return [
                        'code' => 1,
                        'msg'  => $result['msg'],
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'code' => 0,
                    'msg'  => '状态变动失败：' . $e->getMessage(),
                ];
            }
        } else {
            return [
                'code' => 0,
                'msg'  => '插件实例化失败',
            ];
        }
        return [
            'code' => 1,
            'msg'  => '状态变动成功',
        ];
    }

    // 判断插件配置文件是否进行了分组
    public function checkConfigGroup(array $config)
    {
        // 获取第一个元素
        $arrayShift = array_shift($config);
        if (array_key_exists('title', $arrayShift) && array_key_exists('type', $arrayShift)) {
            // 未开启分组
            return false;
        } else {
            // 开启分组
            return true;
        }
    }
    // ===========================================

    // 验证插件是否完整
    private function check(string $name)
    {
        if (!is_dir($this->addonsPath . DIRECTORY_SEPARATOR . $name)) {
            return '未发现该插件,请先下载并放入到addons目录中';
        }
        return true;
    }

    // 获取插件实例
    private function getInstance(string $file)
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

    /**
     * 更新插件的配置文件
     * @param string $name 插件名
     * @param array $array
     * @return boolean
     * @throws Exception
     */
    private function setPluginConfig(string $name, array $array = [])
    {
        $file = $this->addonsPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'config.php';
        if (!$this->checkFileWritable($file)) {
            return [
                'code' => 0,
                'msg' => '文件没有写入权限',
            ];
        }
        if ($handle = fopen($file, 'w')) {
            fwrite($handle, "<?php\n\n" . "return " . var_export($array, TRUE) . ";\n");
            fclose($handle);
        } else {
            return [
                'code' => 0,
                'msg'  => '文件没有写入权限',
            ];
        }
        return [
            'code' => 1,
            'msg' => '文件写入完毕',
        ];
    }

    /**
     * 更新插件的ini文件
     * @param string $name 插件名
     * @param array $array
     * @return boolean
     * @throws Exception
     */
    private function setPluginIni(string $name, array $array = [])
    {
        $file = $this->addonsPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'info.ini';
        if (!$this->checkFileWritable($file)) {
            return [
                'code' => 0,
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
                'code' => 0,
                'msg'  => '文件没有写入权限',
            ];
        }
        return [
            'code' => 1,
            'msg' => '文件写入完毕',
        ];
    }

    /**
     * 判断文件或目录是否可写
     * @param    string $file 文件或目录
     * @return    bool
     */
    private function checkFileWritable(string $file)
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

    // 导入SQL
    private function importsql(string $name)
    {
        $sqlFile = $this->addonsPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'install.sql';
        if (is_file($sqlFile)) {
            $lines = file($sqlFile);
            $templine = '';
            foreach ($lines as $line) {
                if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 2) == '/*')
                    continue;

                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    // 不区分大小写替换前缀
                    $templine = str_ireplace('__PREFIX__', Config::get('database.connections.mysql.prefix'), $templine);
                    // 忽略数据库中已经存在的数据
                    $templine = str_ireplace('INSERT INTO ', 'INSERT IGNORE INTO ', $templine);
                    try {
                        Db::execute($templine);
                    } catch (\PDOException $e) {
                        //$e->getMessage();
                    }
                    $templine = '';
                }
            }
        }
        return true;
    }

    // 安装时复制文件
    private function copyDir(string $name)
    {
        $addonDir = $this->addonsPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
        foreach ($this->copyDirs as $k => $dir) {
            if (is_dir($addonDir . $dir)) {
                $this->copydirs($addonDir . $dir, app()->getRootPath() . $dir);
            }
        }
    }

    /**
     * 复制文件夹到另一个文件夹
     * @param string $source 源文件夹
     * @param string $dest   目标文件夹
     */
    private function copydirs($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            ) as $item
        ) {
            if ($item->isDir()) {
                $sontDir = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
                if (!is_dir($sontDir)) {
                    mkdir($sontDir, 0755, true);
                }
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
    }
}