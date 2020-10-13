<?php
/**
 * +----------------------------------------------------------------------
 * | 后台中间件
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/03/08
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
namespace app\admin\middleware;

use think\facade\Session;
use think\facade\Request;
use think\Response;
use think\exception\HttpResponseException;

class Admin
{
    public function handle($request, \Closure $next)
    {
        // 获取当前用户
        $admin_id = Session::get('admin.id');
        if (empty($admin_id)) {
            return redirect((string)url('Login/index'));
        }

        // 定义方法白名单
        $allow = [
            'Index/index',      // 首页
            'Index/clear',      // 清除缓存
            'Index/preview',    // 预览
            'Index/select2',    // ajax select2
            'Upload/index',     // 上传文件
            'Login/index',      // 登录页面
            'Login/checkLogin', // 校验登录
            'Login/captcha',    // 登录验证码
            'Login/logout',     // 退出登录
        ];

        // 查询所有不验证的方法并放入白名单
        $authOpen = \app\common\model\AuthRule::where('auth_open', '=', '0')
            ->select();
        $authRole = \app\common\model\AuthRule::select();
        $authOpens = [];
        foreach ($authOpen as $k => $v) {
            // 转换方法名为小写
            $ruleName = explode('/', $v['name']);
            if ($ruleName[1]) {
                $ruleName[1] = strtolower($ruleName[1]);
            }
            // 转换控制器首字母大写
            $ruleName = trim(implode('/', $ruleName));
            $authOpens[] = ucfirst($ruleName);
            // 查询所有下级权限
            $ids = getChildsRule($authRole, $v['id']);
            foreach ($ids as $kk => $vv) {
                // 转换方法名为小写
                $ruleName = explode('/', $vv['name']);
                if ($ruleName[1]) {
                    $ruleName[1] = strtolower($ruleName[1]);
                }
                // 转换控制器首字母大写
                $ruleName = trim(implode('/', $ruleName));
                $authOpens[] = ucfirst($ruleName);
            }
        }
        $allow = array_merge($allow, $authOpens);

        // 查找当前控制器和方法，控制器首字母大写，方法名首字母小写 如：Index/index
        $route = Request::controller() . '/' . lcfirst(Request::action());

        // 权限认证
        if (!in_array($route, $allow)) {
            if ($admin_id != 1) {
                //开始认证
                $auth = new \Auth();

                $result = $auth->check($route, $admin_id);
                if (!$result) {
                    $this->error('您无此操作权限!');
                }
            }
        }

        // 进行操作日志的记录
        \app\common\model\AdminLog::record();

        // 当url中有ref=tab时表示刷新当前页(用于后台tab模式刷新)
        if (Request::get("ref") == 'tab') {

            // 去除url中ref参数
            $url = preg_replace_callback("/([\?|&]+)ref=tab(&?)/i", function ($matches) {
                return $matches[2] == '&' ? $matches[1] : '';
            }, Request::url());

            // 重定向隐式传值使用的是Session闪存数据隐式传值，并且仅在下一次请求有效，再次访问重定向地址的时候无效
            return redirect('Index/index')->with('referer', $url);
        }

        // 中间件handle方法的返回值必须是一个Response对象。
        return $next($request);
    }

    /**
     * 操作错误跳转
     * @param  mixed $msg 提示信息
     * @param  string $url 跳转的URL地址
     * @param  mixed $data 返回的数据
     * @param  integer $wait 跳转等待时间
     * @param  array $header 发送的Header信息
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
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = (request()->isJson() || request()->isAjax()) ? 'json' : 'html';

        // 所有form返回的都必须是json，所有A链接返回的都必须是Html
        $type = request()->isGet() ? 'html' : $type;

        if ($type == 'html') {
            $response = view(app('config')->get('app.dispatch_error_tmpl'), $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }
}
