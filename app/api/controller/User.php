<?php
/**
 * +----------------------------------------------------------------------
 * | 用户中心控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/07/19
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
namespace app\api\controller;


use app\api\service\JwtAuth;
use app\common\model\Users;
use think\facade\Db;
use think\facade\Request;

class User extends Base
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
    protected $middleware = [
        'app\api\middleware\Api' => ['except' => ['login', 'register']],
    ];

    /**
     * @api {post} /User/login 01、会员登录
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription 系统登录接口，返回 token 用于操作需验证身份的接口

     * @apiParam (请求参数：) {string}     		username 登录用户名
     * @apiParam (请求参数：) {string}     		password 登录密码

     * @apiParam (响应字段：) {string}     		token    Token

     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"登录成功","time":1563525780,"data":{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkuc2l5dWNtcy5jb20iLCJhdWQiOiJzaXl1Y21zX2FwcCIsImlhdCI6MTU2MzUyNTc4MCwiZXhwIjoxNTYzNTI5MzgwLCJ1aWQiOjEzfQ.prQbqT00DEUbvsA5M14HpNoUqm31aj2JEaWD7ilqXjw"}}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"帐号或密码错误","time":1563525638,"data":[]}
     */
    public function login(string $username, string $password)
    {
        // 校验用户名密码
        $user = Users::where('email|mobile', $username)
            ->where('password', md5($password))
            ->find();
        if (empty($user)) {
            $this->result([], 0, '帐号或密码错误');
        } else {
            if ($user['status'] == 1) {
                //获取jwt的句柄
                $jwtAuth = JwtAuth::getInstance();
                $token = $jwtAuth->setUid($user['id'])->encode()->getToken();
                //更新信息
                Users::where('id', $user['id'])
                    ->update(['last_login_time' => time(), 'last_login_ip' => Request::ip()]);
                $this->result(['token' => $token], 1, '登录成功');
            } else {
                $this->result([], 0, '用户已被禁用');
            }
        }
    }

    /**
     * @api {post} /User/register 02、会员注册
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  系统注册接口，返回是否成功的提示，需再次登录

     * @apiParam (请求参数：) {string}     		email 邮箱
     * @apiParam (请求参数：) {string}     		password 密码

     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"注册成功","time":1563526721,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"邮箱已被注册","time":1563526693,"data":[]}
     */
    public function register(string $email, string $password){
        // 密码长度不能低于6位
        if (strlen($password) < 6) {
            $this->result([], 0, '密码长度不能低于6位');
        }

        // 邮箱合法性判断
        if (!is_email($email)) {
            $this->result([], 0, '邮箱格式错误');
        }

        // 防止重复
        $id = Db::name('users')->where('email|mobile', '=', $email)->find();
        if ($id) {
            $this->result([], 0, '邮箱已被注册');
        }

        // 注册入库
        $data = [];
        $data['email']           = $email;
        $data['password']        = md5($password);
        $data['last_login_time'] = $data['create_time'] = time();
        $data['create_ip']       = $data['last_login_ip'] = Request::ip();
        $data['status']          = 1;
        $data['type_id']         = 1;
        $data['sex']             = Request::post('sex') ? Request::post('sex') : 0;
        $id = Db::name('users')->insertGetId($data);
        if ($id) {
            $this->result([], 1, '注册成功');
        } else {
            $this->result([], 0, '注册失败');
        }
    }

    /**
     * @api {post} /User/index 03、会员中心首页
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  会员中心首页，返回用户个人信息

     * @apiParam (请求参数：) {string}     		token Token

     * @apiSuccessExample {json} 响应数据样例
     * {"code":1,"msg":"","time":1563517637,"data":{"id":13,"email":"test110@qq.com","password":"e10adc3949ba59abbe56e057f20f883e","sex":1,"last_login_time":1563517503,"last_login_ip":"127.0.0.1","qq":"123455","mobile":"","mobile_validated":0,"email_validated":0,"type_id":1,"status":1,"create_ip":"127.0.0.1","update_time":1563507130,"create_time":1563503991,"type_name":"注册会员"}}
     */
    public function index()
    {
        $user = Db::name('users')
            ->alias('u')
            ->leftJoin('users_type ut', 'u.type_id = ut.id')
            ->field('u.*,ut.name as type_name')
            ->where('u.id', $this->getUid())
            ->find();
        return $this->result($user, 1, '');
    }

    /**
     * @api {post} /User/editPwd 04、修改密码
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  修改会员密码，返回成功或失败提示

     * @apiParam (请求参数：) {string}     		token Token
     * @apiParam (请求参数：) {string}     		oldPassword 原密码
     * @apiParam (请求参数：) {string}     		newPassword 新密码

     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"密码修改成功","time":1563527107,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"token已过期","time":1563527082,"data":[]}
     */
    public function editPwd(string $oldPassword, string $newPassword){
        // 密码长度不能低于6位
        if (strlen($newPassword) < 6) {
            $this->result([], 0, '密码长度不能低于6位');
        }

        // 查看原密码是否正确
        $user = Users::where('id', $this->getUid())
            ->where('password', md5($oldPassword))
            ->find();
        if (!$user) {
            $this->result([], 0, '原密码输入有误');
        }

        //更新信息
        $user = Users::find($this->getUid());
        $user->password = md5($newPassword);
        $user->save();
        $this->result([], 1, '密码修改成功');
    }

    /**
     * @api {post} /User/editInfo 05、修改信息
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  修改用户信息，返回成功或失败提示

     * @apiParam (请求参数：) {string}     		token Token
     * @apiParam (请求参数：) {string}     		sex 性别 [1男/0女]
     * @apiParam (请求参数：) {string}     		qq  qq
     * @apiParam (请求参数：) {string}     		mobile  手机号

     * @apiSuccessExample {json} 成功示例
     * {"code":0,"msg":"修改成功","time":1563507660,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"token已过期","time":1563527082,"data":[]}
     */
    public function editInfo(){
        $data['sex']    = trim(Request::param("sex"));
        $data['qq']     = trim(Request::param("qq"));
        $data['mobile'] = trim(Request::param("mobile"));
        if ($data['mobile']) {
            // 不可和其他用户的一致
            $id = Users::
                where('mobile', $data['mobile'])
                ->where('id', '<>', $this->getUid())
                ->find();
            if ($id) {
                $this->result([], 0, '手机号已存在');
            }
        }
        // 更新信息
        Users::where('id', $this->getUid())
            ->update($data);
        $this->result([], 0, '修改成功');
    }

    /**
     * 获取用户id
     * @return mixed
     */
    protected function getUid(){
        $jwtAuth = JwtAuth::getInstance();
        return $jwtAuth->getUid();
    }
}
