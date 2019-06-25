<?php
/**
 * +----------------------------------------------------------------------
 * | 标签管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/06/25
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

use app\common\model\Module;
use app\common\model\Tags as M;

use think\facade\Request;
use think\facade\View;

class Tags extends Base
{
    // 列表
    public function index()
    {
        //全局查询条件
        $where = [];
        $keyword = Request::param('keyword');
        if (!empty($keyword)) {
            $where[] = ['name', 'like', '%' . $keyword . '%'];
        }
        $moduleId = Request::param('module_id');
        if (!empty($moduleId)) {
            $where[] = ['module_id', '=', $moduleId];
        }

        //获取列表
        $list = M::getList($where, $this->pageSize);

        //获取模型列表
        $module = Module::select();

        $view = [
            'keyword'  => $keyword,
            'moduleId' => $moduleId,
            'module'   => $module,
            'pageSize' => page_size($this->pageSize, $list->total()),
            'page'     => $list->render(),
            'list'     => $list,
            'empty'    => empty_list(6),
        ];
        View::assign($view);
        return View::fetch();
    }

    // 删除
    public function del()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            return M::del($id);
        }
    }

    // 批量删除
    public function selectDel()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            return M::selectDel($id);
        }
    }


}
