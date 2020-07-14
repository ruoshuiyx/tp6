<?php
/**
 * +----------------------------------------------------------------------
 * | 通用内容控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/03/28
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
namespace app\mobile\controller;

use app\common\facade\Cms;
use app\common\model\Cate;
use app\common\model\Field;
use app\common\model\Module;

use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Error extends Base
{
    protected $moduleId;  // 当前模型ID
    protected $tableName; // 当前模型对应的数据表

    public function initialize()
    {
        parent::initialize();
        if (Request::param('cate')) {
            // 当前模型ID
            $this->moduleId = Cate::where('id', '=', Request::param('cate'))->value('module_id');
        } else {
            // 当前模型ID
            $this->moduleId = Cate::where('cate_folder', '=', Request::controller())->value('module_id');
        }
        // 当前表名称
        $this->tableName = Module::where('id', '=', $this->moduleId)->value('table_name');
        // 当前模型字段列表
        $this->fields = Field::getFieldList($this->moduleId);
    }

    // 列表
    public function index()
    {
        // 获取栏目ID
        $catId = getCateId();
        if (empty($catId)) {
            $this->error('未找到对应栏目');
        }
        // 获取栏目信息
        $cate = Cms::getCateInfo($catId);
        // tdk
        $tdk = Cms::getListTdk($cate, $this->system);
        // 模板
        $template = Cms::getListView($cate, $this->tableName);
        // 单页模块
        if ($this->tableName == 'page') {
            $info = Db::name($this->tableName)
                ->where('cate_id', '=', $cate['id'])
                ->find();
            View::assign(['info' => $info]);//单页内容
        }

        $view = [
            'cate'        => $cate,         // 栏目信息
            'fields'      => $this->fields, // 字段列表
            'system'      => $this->system, // 系统信息
            'public'      => $this->public, // 公共目录
            'title'       => $tdk['title'],
            'keywords'    => $tdk['keywords'],
            'description' => $tdk['description'],
        ];

        View::assign($view);
        return View::fetch($template);
    }

    // 详情
    public function info(string $id){
        // 获取栏目ID
        $catId = getCateId();
        if (empty($catId)) {
            $this->error('未找到对应栏目');
        }
        // 获取栏目信息
        $cate = Cms::getCateInfo($catId);
        // 更新点击数
        Cms::addHits($id, $this->tableName);
        // 查找内容详情
        $info = Cms::getInfo($id, $this->tableName);
        // 跳转
        if (isset($info['url']) && !empty($info['url'])) {
            return redirect($info['url']);
        }
        // 当前地址
        $info['url'] = getShowUrl($info);
        // tdk
        $tdk = Cms::getInfoTdk($info, $cate, $this->system);
        // 模板
        $template = Cms::getInfoView($info, $cate, $this->tableName);

        $view = [
            'cate'        => $cate,         // 栏目信息
            'fields'      => $this->fields, // 字段列表
            'info'        => $info,         // 详情信息
            'system'      => $this->system, // 系统信息
            'public'      => $this->public, // 公共目录
            'title'       => $tdk['title'],
            'keywords'    => $tdk['keywords'],
            'description' => $tdk['description'],
        ];

        View::assign($view);
        return View::fetch($template);
    }

}
