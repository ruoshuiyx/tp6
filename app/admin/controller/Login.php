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

use think\captcha\facade\Captcha;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Login
{
    // 登录页面
    public function index()
    {
        //查找所有系统设置表数据
        $system = System::getListField()->toArray();
        //格式化设置字段
        $system = sysgem_setup($system);
        $systemArr = [];
        foreach ($system as $k => $v) {
            $systemArr[$v['field']] = $v['value'];
        }
        $system = $systemArr;

        $view['mobile'] = Request::isMobile();
        $view['system'] = $system;
        View::assign($view);
        return View::fetch();
    }

    // 校验登录
    public function checkLogin(){
        return Admin::checkLogin();
    }

    // 验证码
    public function captcha(){
        return Captcha::create();
    }

    // 退出登录
    public function logout(){
        Session::delete('admin');
        return redirect('login/index');
    }
}
