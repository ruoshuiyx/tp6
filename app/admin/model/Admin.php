<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员模型
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
namespace app\admin\model;

use think\facade\Db;
use think\facade\Request;
use think\facade\Session;

class Admin extends Base {

    /**
     * 管理员登录校验
     * @return array|\think\response\Json
     * @throws \think\Exception
     */
    public static function checkLogin()
    {
        $username = Request::param("username");
        $password = Request::param("password");
        $open_code = Db::name('system')->where('id',1)->value('code');
        if ($open_code){
            $code = Request::param("vercode");
            if( !captcha_check($code ))
            {
                $data = ['error' => '1', 'msg' => '验证码错误'];
                return json($data);
            }
        }
        $result = self::where(['username'=>$username,'password'=>md5($password)])->find();
        if(empty($result)){
            $data = ['error' => '1', 'msg' => '帐号或密码错误'];
            return json($data);
        }else{
            if ($result['status']==1){
                //更新登录IP和登录时间
                self::where('id', $result['id'])->update(['logintime' => time(),'loginip'=>request()->ip()]);

                $rules = Db::name('auth_group_access')
                    ->alias('a')
                    ->leftJoin('auth_group ag','a.group_id = ag.id')
                    ->field('a.group_id,ag.rules,ag.title')
                    ->where('uid',$result['id'])
                    ->find();
                Session::set('admin'         ,$result);
                Session::set('admin.group_id', $rules['group_id']);
                Session::set('admin.rules'   , explode(',',$rules['rules']));
                Session::set('admin.title'   , $rules['title']);

                $data = ['error' => '0','href' => url('Index/index'), 'msg' => '登录成功'];
                return json($data);
            }else{
                return json(['error' => 1, 'msg' => '用户已被禁用!']);
            }

        }
    }
}