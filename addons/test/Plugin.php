<?php
// 注意命名空间规范
namespace addons\test;

use think\Addons;

/**
 * 插件测试
 * 注意名字不可以修改，只能为Plugin
 */
class Plugin extends Addons
{
    // 该插件的基础信息，系统优先获取info.ini中的配置信息
    public $info = [
        'name'        => 'test',            // 插件标识
        'title'       => '插件测试',         // 插件名称
        'description' => 'thinkph6插件测试', // 插件简介
        'status'      => 0,                 // 状态[1 启用，0 禁用]
        'install'     => 0,                 // 是否已安装[1 已安装，0 未安装]
        'author'      => 'SIYUCMS',         // 作者
        'version'     => '1.0',             // 版本
    ];

    // 插件的安装 [添加文件、执行sql等]
    public function install()
    {
        return true;
    }

    // 插件的卸载 [移除文件、执行sql等]
    public function uninstall()
    {
        return true;
    }

    /**
     * 实现的testhook钩子方法
     * @param $param 调用钩子时候的参数信息
     * @return false|mixed|string
     *
     * 用法：
     * 模版中调用：<div>{:hook('testhook', ['id'=>1])}</div>
     * PHP中调用：hook('testhook', ['id'=>1]);
     */
    public function testhook($param)
    {
        // 当前插件的基础信息，系统优先获取info.ini中的配置信息
        $info = $this->getInfo();

        // 插件禁用后不再进行任何输出
        if($info['status'] == 0){
            return false;
        }

        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中
        $config = $this->getConfig();


        // 打印调用钩子时候的参数信息和当前参加的配置信息
        dump($param, $info, $config);

        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        return $this->fetch('info');
    }

}