<?php
/**
 * +----------------------------------------------------------------------
 * | 基础控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/03
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
use think\Controller;
use think\facade\Request;
use think\facade\Session;
use think\response\Redirect;

class Base extends Controller
{
    //初始化方法
    public function initialize()
    {
        $admin_id = Session::get('admin.id');

        //未登录用户跳转登录页
        if (empty($admin_id)){
            $this->redirect('login/index');
        }

        //定义方法白名单
        $allow = [
            'Index/index',      //首页
            'Index/main',       //右侧
            'Index/upload',     //上传文件
            'Index/wangEditor', //编辑器
            'Index/ckeditor',   //编辑器
            'Index/clear',      //清除缓存
            'Login/index',      //登录页面
            'Login/checkLogin', //校验登录
            'Login/captcha',    //登录验证码
            'Login/logout',     //退出登录
        ];

        //查找当前控制器和方法，控制器首字母大写，方法首字母小写 如：Index/index
        $route = Request::controller() . '/' . lcfirst(Request::action());

        //权限认证

        if(!in_array($route, $allow)){
            if($admin_id!=1){
                //开始认证
                $auth = new \Auth();
                $result = $auth->check($route,$admin_id);
                if(!$result){
                    $this->error('您无此操作权限');
                }
            }
        }
    }

}
