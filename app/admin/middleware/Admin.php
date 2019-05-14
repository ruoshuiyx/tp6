<?php
/**
 * +----------------------------------------------------------------------
 * | 后台中间件
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/17
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
namespace app\admin\middleware;

use think\facade\Session;
use think\facade\Request;
use think\Response;
use think\exception\HttpResponseException;

class Admin
{
    public function handle($request, \Closure $next)
    {
        //获取当前用户
        $admin_id = Session::get('admin.id');

        if(empty($admin_id)){
            return redirect('Login/index');
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
                    $this->error('您无此操作权限!');
                }
            }
        }

        //进行操作日志的记录
        \app\admin\model\AdminLog::record();

        //中间件handle方法的返回值必须是一个Response对象。
        return $next($request);
    }

    /**
     * 操作错误跳转
     * @param  mixed   $msg 提示信息
     * @param  string  $url 跳转的URL地址
     * @param  mixed   $data 返回的数据
     * @param  integer $wait 跳转等待时间
     * @param  array   $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = []): Response
    {
        if (is_null($url)) {
            $url = request()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = (request()->isJson() || request()->isAjax()) ? 'json' : 'html';
        if ('html' == strtolower($type)) {
            $type = 'jump';
        }

        $response = Response::create($result, $type)->header($header)->options(['jump_template' => app('config')->get('app.dispatch_error_tmpl')]);

        throw new HttpResponseException($response);
    }
}
