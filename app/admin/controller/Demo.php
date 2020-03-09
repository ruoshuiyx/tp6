<?php
/**
 * +----------------------------------------------------------------------
 * | 演示控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/02/09
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
namespace app\admin\controller;


use think\facade\Request;
use think\facade\View;

class Demo extends Base
{
    // 按钮
    public function button()
    {
        return View::fetch();
    }

    // 图标
    public function icons()
    {
        return View::fetch();
    }

    // 常规
    public function general()
    {
        return View::fetch();
    }

    // 模态框
    public function modals()
    {
        return View::fetch();
    }

    // 时间轴
    public function timeline()
    {
        return View::fetch();
    }

    // 弹层
    public function layer()
    {
        return View::fetch();
    }

    // layer表单
    public function layerForm()
    {
        return View::fetch();
    }

    // 模拟提交
    public function addPost()
    {
        $this->success('提交成功', 'layer');
    }

}
