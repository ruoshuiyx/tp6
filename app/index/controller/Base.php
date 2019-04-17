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
 *                .::::::::::               | DATETIME: 2019/04/12
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

use app\common\model\System;

use think\Controller;
use think\facade\Request;


class Base extends Controller
{
    protected $appName;        //当前应用名称
    protected $controllerName; //获取当前的控制器名
    protected $system;         //系统信息
    protected $public;         //公共目录
    protected $template;       //模板目录
    public function initialize()
    {
        $this->appName        = strtolower(Request::app());
        $this->controllerName = strtolower(Request::controller());
        $this->system         = System::where('id',1)->find();
        $this->public         = '/template/'.
            $this->system['template'].
            '/'.
            $this->appName.
            '/';
        $this->template       = '.'.$this->public.$this->system['html'].'/';
    }

}
