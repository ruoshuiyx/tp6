<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员日志模型
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
namespace app\common\model;

// 引入框架内置类
use think\facade\Request;
use think\facade\Session;

// 引入构建器
use app\common\facade\MakeBuilder;

class AdminLog extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id');
    }

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query'     => Request::get(),
                'list_rows' => $pageSize,
            ]);
        foreach ($list as $k => $v) {
            if ($list[$k]['admin_id']) {
                $v['admin_id'] = $v->admin->getData('username');
            }
            // 截取部分user_agent
            $userAgent = explode('(', $v['user_agent']);
            $v['user_agent'] = $userAgent[0];
        }
        return MakeBuilder::changeTableData($list, 'AdminLog');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            if ($list[$k]['admin_id']) {
                $v['admin_id'] = $v->admin->getData('username');
            }
        }
        return MakeBuilder::changeTableData($list, 'AdminLog');
    }

    // 管理员日志记录
    public static function record()
    {
        // 入库信息
        $adminId   = Session::get('admin.id',0);
        $url       = Request::url();
        $title     = '';
        $content   = Request::except(['s','_pjax']); //s 变量为系统内置的变量，_pjax为js的变量，无记录的必要
        $ip        = Request::ip();
        $userAgent = Request::server('HTTP_USER_AGENT');

        // 标题处理
        $auth = new \Auth();
        $titleArr = $auth->getBreadCrumb();
        if (is_array($titleArr)) {
            foreach ($titleArr as $k => $v) {
                $title = '[' . $v['title'] . '] -> ' . $title;
            }
            $title = substr($title, 0, strlen($title) - 4);
        }

        // 内容处理(过长的内容和涉及密码的内容不进行记录)
        if ($content) {
            foreach ($content as $k => $v) {
                if (is_string($v) && strlen($v) > 200 || stripos($k, 'password') !== false) {
                    unset($content[$k]);
                }
            }
        }

        // 登录处理
        if (strpos($url, 'Login/checkLogin') !== false) {
            $title = '[登录成功]';
            $content = '';
        }

        // 插入数据
        if (!empty($title)) {
            // 查询管理员上一条数据
            $result = self::where('admin_id', '=', $adminId)
                ->order('id', 'desc')
                ->find();
            if ($result) {
                if ($result->url != $url) {
                    self::create([
                        'title'       => $title ? $title : '',
                        'content'     => !is_scalar($content) ? json_encode($content) : $content,
                        'url'         => $url,
                        'admin_id'    => $adminId,
                        'user_agent'   => $userAgent,
                        'ip'          => $ip
                    ]);
                }
            } else {
                self::create([
                    'title'       => $title ? $title : '',
                    'content'     => !is_scalar($content) ? json_encode($content) : $content,
                    'url'         => $url,
                    'admin_id'    => $adminId,
                    'user_agent'   => $userAgent,
                    'ip'          => $ip
                ]);
            }
        }
    }
}