<?php
/**
 * +----------------------------------------------------------------------
 * | 用户中心控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/28
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
namespace app\index\controller;
use app\common\model\Users;

use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class User extends Base
{
    public function initialize()
    {
        parent::initialize();
        View::assign([
            'cate'        => null,
            'system'      => $this->system, //系统信息
            'public'      => $this->public, //公共目录
            'title'       => $this->system['title'] ? $this->system['title'] : $this->system['name'], //seo信息
            'keywords'    => $this->system['key'],   //seo信息
            'description' => $this->system['des'],   //seo信息
        ]);
    }

    //用户中心首页
    public function index()
    {
        if(!Session::has('user.id')){
            return redirect('login');
        }
        $user = Db::name('users')
            ->alias('u')
            ->leftJoin('users_type ut','u.type_id = ut.id')
            ->field('u.*,ut.name as type_name')
            ->where('u.id',session('user.id'))
            ->find();
        $view = [
            'user' => $user,
        ];
        View::assign($view);
        return View::fetch();
    }

    //登录
    public function login(){
        if(Request::isPost()){
            $result=['error'=>'','msg'=>''];
            //登录提交
            $username = trim(Request::post('username'));
            $password = trim(Request::post('password'));
            //检查是否开启了验证码
            $message_code = Db::name('system')->where('id',1)->value('message_code');
            if($message_code){
                if( !captcha_check(Request::post("message_code")))
                {
                    $result['error']  = '1';
                    $result['msg']  .= '验证码错误';
                    $this->error($result['msg']);
                }
            }
            //校验用户名密码
            $user = Users::
                where('email|mobile',$username)
                ->where('password',md5($password))
                ->find();
            if(empty($user)){
                $result['error']  = '1';
                $result['msg']  .= '帐号或密码错误';
                $this->error($result['msg']);
            }else{
                if ($user['status']==1){
                    Session::set('user',[
                        'id' =>$user['id'],
                        'email' => $user['email'],
                        'type_id' => $user['type_id'],
                        'status' => $user['status'],
                    ]);
                    //更新信息
                    Users::where('id', $user['id'])
                        ->update(['last_login_time' => time(),'last_login_ip' =>Request::ip()]);

                    $result['error']  = '0';
                    $result['msg']  .= '登录成功';
                    $this->success($result['msg'],'index');
                }else{
                    $result['error']  = '1';
                    $result['msg']  .= '用户已被禁用';
                    $this->error($result['msg']);
                }
            }

        }else{
            if(Session::has('user.id')){
                return redirect('index');
            }
            return View::fetch();
        }
    }

    //注册
    public function register(){
        if(Request::isPost()){
            $result=['error'=>'','msg'=>''];
            //登录提交
            $email = trim(Request::post("email"));
            $password = trim(Request::post("password"));
            $password2 = trim(Request::post("password2"));

            //密码长度不能低于6位
            if(strlen($password)<6){
                $this->error('密码长度不能低于6位');
            }

            //非空判断
            if(empty($email) || empty($password) || empty($password2)){
                $result['error'] = '1';
                $result['msg']   = '请输入邮箱、密码和确认密码';
                $this->error($result['msg']);
            }
            //邮箱合法性判断
            if(!is_email($email)){
                $result['error']= '1';
                $result['msg']  = '邮箱格式错误';
                $this->error($result['msg']);
            }
            //确认密码
            if($password != $password2){
                $result['error']  = '1';
                $result['msg']    = '两次密码输入不一致';
                $this->error($result['msg']);
            }

            //检查是否开启了验证码
            $message_code = Db::name('system')->where('id',1)->value('message_code');
            if($message_code){
                if( !captcha_check(input("post.message_code")))
                {
                    $result['error'] = '1';
                    $result['msg']   = '验证码错误';
                    $this->error($result['msg']);
                }
            }
            //防止重复
            $id = Db::name('users')->where('email|mobile','=',$email)->find();
            if($id){
                $result['error'] = '1';
                $result['msg']   = '邮箱已被注册';
                $this->error($result['msg']);
            }
            //注册入库
            $data = [];
            $data['email'] = $email;
            $data['password'] = md5($password);
            $data['last_login_time'] = $data['create_time'] = time();
            $data['create_ip'] = $data['last_login_ip']=Request::ip();
            $data['status'] = 1;
            $data['type_id'] = 1;
            $data['sex'] = Request::post('sex') ? Request::post('sex') : 0;
            $id = Db::name('users')->insertGetId($data);
            if($id){
                $this->success('注册成功!','login');
            }else{
                $this->error('注册失败!');
            }
        }else{
            if(Session::has('user.id')){
                return redirect('index');
            }
            return View::fetch();
        }
    }

    //用户中心设置页
    public function set(){
        if(!Session::has('user.id')){
            return redirect('login');
        }
        if(Request::isPost()){
            $data=[];
            //修改密码
            if(Request::post("password") && Request::post("password2")){
                //密码长度不能低于6位
                if(strlen(trim(Request::post("password")))<6){
                    $this->error('密码长度不能低于6位');
                }
                //查看原密码是否正确
                if(Request::post("nowpassword")){
                    $id = Users::
                        where('id',session('user.id'))
                        ->where('password',md5(trim(Request::post("nowpassword"))))
                        ->find();
                    if(!$id){
                        $this->error('原密码输入有误');
                    }
                }else{
                    $this->error('请输入原密码');
                }
                if(Request::post("password") == Request::post("password2")){
                    $data['password'] = md5(trim(Request::post("password")));
                }else{
                    $this->error('两次输入的密码不一致');
                }
                //更新信息
                db('users')
                    ->where('id', session('user.id'))
                    ->data($data)
                    ->update();
                $this->success('密码修改成功');
            }
            //修改资料
            $data['sex'] = input("post.sex");
            $data['qq'] = input("post.qq");
            $data['mobile'] = input("post.mobile");
            if($data['mobile']){
                //不可和其他用户的一致
                $id = Users::
                    where('mobile',$data['mobile'])
                    ->where('id','<>',session('user.id'))
                    ->find();
                if($id){
                    $this->error('手机号已存在');
                }
            }

            //更新信息
            Users::where('id', session('user.id'))
                ->update($data);
            $this->success('修改成功');

        }else{
            $user = Db::name('users')
                ->alias('u')
                ->leftJoin('users_type ut','u.type_id = ut.id')
                ->field('u.*,ut.name as type_name')
                ->where('u.id',session('user.id'))
                ->find();
            $view = [
                'user'=>$user,
            ];
            View::assign($view);
            return View::fetch();
        }

    }

    //退出
    public function logout(){
        Session::delete('user');
        return redirect('login');
    }

}
