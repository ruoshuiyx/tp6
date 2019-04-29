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

use think\App;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use think\response\Redirect;

use think\facade\Config;
use think\facade\Request;
use think\facade\Session;




class Base
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 验证失败是否抛出异常
     * @var bool
     */
    protected $failException = false;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = ['app\admin\middleware\Admin'];
    /**
     * 分页数量
     * @var array
     */
    protected $pageSize = '';
    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    //初始化方法
    public function initialize()
    {
        //每页显示数据量
        $this->pageSize = Request::param('page_size',Config::get('app.page_size'));

        //获取当前用户
        $admin_id = Session::get('admin.id');

        if(empty($admin_id)){
            $this->redirect('Login/index');
        }

        //定义方法白名单
        $allow = [
            'Index/index',      //首页
            'Index/main',       //右侧
            'Index/upload',     //上传文件
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
                    if(Request::isAjax()){
                        exit(json_encode(['error'=>1,'msg'=>'您无此操作权限']))  ;
                    }else{
                        error('您无此操作权限');
                    }
                }
            }
        }
    }

    /**
     * 设置验证失败后是否抛出异常
     * @access protected
     * @param  bool $fail 是否抛出异常
     * @return $this
     */
    protected function validateFailException(bool $fail = true)
    {
        $this->failException = $fail;

        return $this;
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        if (!$v->check($data)) {
            if ($this->failException) {
                throw new ValidateException($v->getError());
            }
            return $v->getError();
        }

        return true;
    }

    /**
     * URL重定向
     * @access protected
     * @param  string         $url 跳转的URL表达式
     * @param  array|integer  $params 其它URL参数
     * @param  integer        $code http code
     * @param  array          $with 隐式传参
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        $response = Response::create($url, 'redirect');

        if (is_integer($params)) {
            $code   = $params;
            $params = [];
        }

        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }

}
