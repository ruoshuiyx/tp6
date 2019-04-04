<?php
/**
 * +----------------------------------------------------------------------
 * | 登录制器
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
use app\admin\model\Admin;
use app\common\model\System;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;
use think\response\Redirect;

class Login
{
    //登录页面
    public function index()
    {
        $view['mobile'] = Request::isMobile();
        $view['system'] = System::find(1);
        View::assign($view);
        return View::fetch();
    }

    //校验登录
    public function checkLogin(){
        return Admin::checkLogin();
    }

    //验证码
    public function captcha(){
        //验证码再等官方文档的更新，目前composer不到
    }

    //退出登录
    public function logout(){
        Session::set('admin',null);
        return Redirect::create('login/index');
    }

}
