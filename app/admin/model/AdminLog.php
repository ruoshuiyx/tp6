<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员日志模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/18
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

use think\facade\Request;
use think\facade\Session;

class AdminLog extends Base {

    //关闭自动时间戳
    protected $autoWriteTimestamp = false;

    //获取列表
    public static function getList($where=array(),$pageSize,$order=['sort','id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->paginate($pageSize,false,['query' => Request::get()]);
        foreach ($list as $k => $v) {
            $useragent = explode('(',$v['useragent']);
            $list[$k]['useragent']=$useragent[0];
        }
        return $list;
    }

    //获取下载列表
    public static function getDownList($where=array(),$order=['sort','id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['useragent_all']=$list[$k]['useragent'];
            $useragent = explode('(',$v['useragent']);
            $list[$k]['useragent']=$useragent[0];
        }
        return $list;
    }

    //管理员日志记录
    public static function record()
    {
        //入库信息
        $admin_id   = Session::get('admin.id',0);
        $username   = Session::get('admin.username','Unknown') ;
        $url        = Request::url();
        $title      = '';
        $content    = Request::except(['s','_pjax']); //s 变量为系统内置的变量，_pjax为js的变量，无记录的必要
        $ip         = Request::ip();
        $useragent  = Request::server('HTTP_USER_AGENT');
        $create_time = time();

        //标题处理
        $auth = new \Auth();
        $titleArr = $auth->getBreadCrumb();
        if (is_array($titleArr)) {
            foreach ($titleArr as $k => $v) {
                $title = '[' . $v['title'] . '] -> ' . $title;
            }
            $title = substr($title,0,strlen($title)-4);
        }

        //内容处理(过长的内容和涉及密码的内容不进行记录)
        if ($content) {
            foreach ($content as $k => $v)
            {
                if (is_string($v) && strlen($v) > 200 || stripos($k, 'password') !== false)
                {
                    unset($content[$k]);
                }
            }
        }

        //登录处理
        if (strpos($url,'login/checklogin') !== false) {
            $title = '登录成功';
            $content = '';
        }

        //插入数据
        if (!empty($title)) {
            //查询管理员上一条数据
            $result = self::where('admin_id' , '=' , $admin_id)
                ->order('id', 'desc')
                ->find();
            if ($result) {
                if ($result->url != $url) {
                    self::create([
                        'title'       => $title ? $title : '',
                        'content'     => !is_scalar($content) ? json_encode($content) : $content,
                        'url'         => $url,
                        'admin_id'    => $admin_id,
                        'username'    => $username,
                        'useragent'   => $useragent,
                        'ip'          => $ip,
                        'create_time' =>$create_time
                    ]);
                }
            } else {
                self::create([
                    'title'       => $title ? $title : '',
                    'content'     => !is_scalar($content) ? json_encode($content) : $content,
                    'url'         => $url,
                    'admin_id'    => $admin_id,
                    'username'    => $username,
                    'useragent'   => $useragent,
                    'ip'          => $ip,
                    'create_time' =>$create_time
                ]);
            }
        }
    }

}