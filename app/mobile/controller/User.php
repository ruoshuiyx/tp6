<?php
/**
 * +----------------------------------------------------------------------
 * | 用户中心控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2019/03/28
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
namespace app\mobile\controller;

use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class User extends Base
{
    // 用户ID
    protected $userId;

    // 初始化
    public function initialize()
    {
        parent::initialize();
        $this->userId = Session::get('user.id');
        View::assign([
            'cate'        => null,
            'system'      => $this->system, //系统信息
            'public'      => $this->public, //公共目录
            'title'       => $this->system['title'] ? $this->system['title'] : $this->system['name'], //seo信息
            'keywords'    => $this->system['key'],   //seo信息
            'description' => $this->system['des'],   //seo信息
        ]);
    }

    // 用户中心首页
    public function index()
    {
        if (!Session::has('user.id')) {
            return redirect('login');
        }
        $user = \app\common\facade\User::getUser($this->userId);
        $view = [
            'user' => $user,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 登录
    public function login(){
        if (Session::has('user.id')) {
            return redirect('index');
        }
        // 登录提交
        if (Request::isPost()) {
            return $this->checkLogin();
        }
        return View::fetch();
    }

    // 注册
    public function register(){
        if (Session::has('user.id')) {
            return redirect('index');
        }
        if (Request::isPost()) {
            return $this->checkRegister();
        }
        return View::fetch();
    }

    // 用户中心设置页
    public function set(){
        if (!Session::has('user.id')) {
            return redirect('login');
        }
        if (Request::isPost()) {
            if (Request::post("password") && Request::post("password2")) {
                // 修改密码
                return $this->changePassword();
            }else{
                // 修改信息
                return $this->changeInfo();
            }
        } else {
            $user = \app\common\facade\User::getUser($this->userId);
            $view = [
                'user'=>$user,
            ];
            View::assign($view);
            return View::fetch();
        }

    }

    // 退出
    public function logout(){
        Session::delete('user');
        return redirect('login');
    }

    // ==========================

    // 校验登录
    private function checkLogin()
    {
        $username = trim(Request::post('username'));
        $password = trim(Request::post('password'));
        // 检查是否开启了验证码
        $message_code = $this->system['message_code'];
        if ($message_code) {
            if (!captcha_check(Request::post("message_code"))) {
                $this->error('验证码错误');
            }
        }
        // 校验用户名密码
        $result = \app\common\facade\User::login($username, $password);
        if ($result['error'] == 1) {
            $this->error($result['msg']);
        }else{
            $this->success($result['msg'], 'index');
        }
    }

    // 校验注册
    private function checkRegister()
    {
        $email     = trim(Request::post("email"));
        $password  = trim(Request::post("password"));
        $password2 = trim(Request::post("password2"));

        // 非空判断
        if (empty($email) || empty($password) || empty($password2)) {
            $this->error('请输入邮箱、密码和确认密码');
        }

        // 验证码
        $message_code = $this->system['message_code'];
        if ($message_code) {
            if (!captcha_check(input("post.message_code"))) {
                $this->error('验证码错误');
            }
        }
        $result = \app\common\facade\User::register($email, $password, $password2);
        if ($result['error'] == 1) {
            $this->error($result['msg']);
        } else {
            $this->success($result['msg'], 'index');
        }
    }

    // 修改密码
    private function changePassword()
    {
        $oldPassword = trim(Request::post('nowpassword'));
        $newPassword = trim(Request::post('password'));
        $confirmPassword = trim(Request::post('password2'));
        $result = \app\common\facade\User::changePassword($this->userId, $oldPassword, $newPassword, $confirmPassword);
        if ($result['error'] == 1) {
            $this->error($result['msg']);
        } else {
            $this->success($result['msg'], 'index');
        }
    }

    // 修改信息
    private function changeInfo(){
        $result = \app\common\facade\User::changeInfo($this->userId);
        if ($result['error'] == 1) {
            $this->error($result['msg']);
        } else {
            $this->success($result['msg'], 'index');
        }
    }
}
