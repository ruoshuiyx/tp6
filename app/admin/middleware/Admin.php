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
}
