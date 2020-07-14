<?php
/**
 * +----------------------------------------------------------------------
 * | 后台登录控制制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/04/03
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

use think\captcha\facade\Captcha;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Login
{
    // 登录页面
    public function index()
    {
        // 已登录自动跳转
        if (Session::has('admin')) {
            return redirect((string)url('Index/index'));
        }
        // 查找系统设置
        $system = \app\common\model\System::find(1);

        $view['mobile'] = Request::isMobile();
        $view['system'] = $system;
        View::assign($view);
        return View::fetch();
    }

    // 校验登录
    public function checkLogin(){
        return \app\common\model\Admin::checkLogin();
    }

    // 验证码
    public function captcha(){
        return Captcha::create();
    }

    // 退出登录
    public function logout(){
        Session::delete('admin');
        return redirect('index');
    }
}
