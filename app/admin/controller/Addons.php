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
 *                .::::::::::               | DATETIME: 2019/03/08
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
use think\facade\App;
use think\facade\Request;

class Addons extends Base
{
    //插件列表
    public function index(){
        //目前只获取本地插件，后期会扩展为获取线上插件，然后通过比对的方式判断是否需要在安装的时候先下载插件
        //获取插件列表
        $addons = get_addon_list();

        //判断插件是否需要配置
        foreach($addons as $k=>$v){

            $object = $this->getInstance($v['name']);
            $config = $object->getFullConfig();
            if(is_array($config) && !empty($config)){
                $addons[$k]['haveConfig']=true;//需要配置
            }else{
                $addons[$k]['haveConfig']=false;//不需要配置
            }

        }
        $this->view->assign('list' ,$addons);
        $this->view->assign('empty', empty_list(8));
        $viewFile = App::getModulePath().'view'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'index.html';
        return $this->view->fetch($viewFile);
    }

    //安装插件
    public function install(){
        $name = input('name', '');
        if (!$name) {
            return ['code'=>0,'msg'=>'参数错误!'];
        }
        //实例化要安装的插件
        $object = $this->getInstance($name);
        if ($object) {
            //获取插件信息
            $data = $object->getInfo();
            $data['setting'] = $object->getConfig();
            //判断当前插件是否已存在或安装过

            // 读取插件目录及钩子列表
            $base = get_class_methods("\\think\\Addons");

            // 读取出所有公共方法
            $methods = (array)get_class_methods($object);
            // 跟插件基类方法做比对，得到差异结果
            $hooks = array_diff($methods, $base);
            // 查询钩子信息

            //安装钩子
            if (false !== $object->install()) {
                //更新插件安装状态
                $data['install']=1;
                unset($data['setting']);
                //更新ini配置文件
                if(set_addon_fullini($name,$data)){
                    $this->success('安装成功!');
                }else{
                    $this->error('安装失败!');
                }
            }else{
                $this->error('安装异常!');
            }
        }
        $this->error('插件实例化失败!');
    }

    //卸载插件
    public function uninstall(){
        $name = Request::param('id');
        if (!$name) {
            $this->error('参数错误');
        }
        //实例化要安装的插件
        $object = $this->getInstance($name);
        if ($object) {
            if (false !== $object->uninstall()) {
                $data = $object->getInfo();
                //更新插件安装状态
                $data['install']=0;
                $data['status']=0;
                //更新ini配置文件
                if(set_addon_fullini($name,$data)){
                    return ['error'=>0,'msg'=>'卸载成功!'];
                }else{
                    return ['error'=>1,'msg'=>'卸载失败!'];
                }
            }else{
                return ['error'=>1,'msg'=>'卸载异常!'];
            }
        }
        return ['error'=>1,'msg'=>'加载异常!'];
    }

    //插件配置
    public function config(){
        $name = Request::param('name');
        if (!$name) {
            $this->error('参数错误');
        }
        if (!is_dir(ADDON_PATH . $name)) {
            $this->error('未发现该插件');
        }
        //实例化要安装的插件
        $object = $this->getInstance($name);
        if ($object) {
            //获取插件信息
            $info = $object->getInfo();
            //获取全部配置信息
            //$config = $object->getConfig();
            $config = $object->getFullConfig();

            if (!$info)
                $this->error('未找到该插件的信息');
            $this->assign("addon", ['info' => $info, 'config' => $config]);

            /*dump($info);
            dump($config);
            dump($tips);*/
            //如果插件自带配置模版的话加载插件自带的，否则加载系统设定好的模版
            $configFile = ADDON_PATH . $name . DIRECTORY_SEPARATOR . 'config.html';

            $viewFile = is_file($configFile) ? $configFile : App::getModulePath().'view'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'config.html';
            return $this->view->fetch($viewFile);
        }else{
            $this->error('插件实例化失败');
        }

    }

    //插件配置保存
    public function configPost(){
        $name = Request::param('name');
        if (!$name) {
            $this->error('参数错误');
        }
        if (!is_dir(ADDON_PATH . $name)) {
            $this->error('未发现该插件');
        }
        //实例化要安装的插件
        $object = $this->getInstance($name);
        if ($object) {
            //获取插件信息
            $info = $object->getInfo();
            //获取全部配置信息
            //$config = $object->getConfig();
            $config = $object->getFullConfig();

            if (!$info)
                $this->error('未找到该插件的信息');

            //进行插件的更新
            $data = Request::param();
            //dump($data);exit;
            if($data){
                foreach ($config as $k => $v) {
                    //dump($v);exit;
                    //存在该参数
                    if (isset($data['row'][$k])) {
                        $value = is_array($data['row'][$k]) ? implode(',', $data['row'][$k]) : $data['row'][$k];
                        $config[$k]['value'] = $value;
                    }
                }
            }
            try {
                //更新配置文件
                set_addon_fullconfig($name, $config);
            } catch (Exception $e) {
                $this->error(__($e->getMessage()));
            }
            $this->success('修改成功','index');

        }else{
            $this->error('插件实例化失败');
        }

    }

    //更改插件状态
    public function state(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            //设置状态

            //读取现在的状态
            //实例化要安装的插件
            $object = $this->getInstance($id);
            if ($object) {
                //获取插件信息
                $data = $object->getInfo();
            }
            $data['status'] = $data['status']==0 ? 1: 0;

            //未安装插件需先安装
            if($data['install']==0){
                return ['error'=>1,'msg'=>'请先安装插件'];
            }else{
                //重新写入配置文件
                try {
                    //更新ini配置文件
                    set_addon_fullini($id,$data);
                } catch (Exception $e) {
                    return ['error'=>1,'msg'=>($e->getMessage())];
                }
                return ['error'=>0,'msg'=>'修改成功'];
            }

        }
    }

    /**
     * 获取插件实例
     * @param $file
     * @return bool|object
     */
    protected function getInstance($file)
    {
        $class = "\\addons\\{$file}\\" . ucfirst($file);
        if (class_exists($class)) {
            //容器类的工作由think\Container类完成，但大多数情况我们只需要通过app助手函数即可完成大部分操作。
            //在ThinkPHP的设计中，think\App类虽然自身不是容器，但却是一个容器管理类，可以完成容器的所有操作。
            return app($class);
            //return Container::get($class);
        }
        return false;
    }


}
