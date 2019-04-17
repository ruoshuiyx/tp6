<?php
/**
 * +----------------------------------------------------------------------
 * | 通用内容控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/28
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
use app\common\model\Cate;
use app\common\model\Module;

use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Error extends Base
{
    protected $moduleId;  //当前模型ID
    protected $tableName; //当前模型对应的数据表
    public function initialize()
    {
        parent::initialize();
        $this->moduleId = Cate::where('id','=',Request::param('catId'))
            ->value('moduleid');
        $this->tableName = Module::where('id','=',$this->moduleId)
            ->value('name');
    }

    //列表
    public function index(){
        //栏目ID
        $catId = Request::param('catId');

        //设置顶级栏目，当顶级栏目不存在的时候顶级栏目为本身
        if($catId){
            $cate = Cate::where('id','=',Request::param('catId'))
                ->find();
            $cate['topid'] = $cate['parentid'] ? $cate['parentid'] : $cate['id'];
        }

        //tdk
        $title       = $cate['title']       ? $cate['title']       : $cate['catname'];     //标题
        $keywords    = $cate['keywords']    ? $cate['keywords']    : $this->system['key']; //关键词
        $description = $cate['description'] ? $cate['description'] : $this->system['des']; //描述

        //单页模型
        if($this->tableName=='page'){
            $info = Db::name($this->tableName)
                ->where('catid','=',Request::param('catId'))
                ->find();
            View::assign(['info'=>$info]);//单页内容
        }

        $view = [
            'cate'        => $cate,         //栏目信息
            'system'      => $this->system, //系统信息
            'public'      => $this->public, //公共目录
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
        ];

        $template = $cate['template_list'] ? str_replace('.html', '', $cate['template_list']) : $this->tableName.'_list';
        View::assign($view);
        return View::fetch($template);
    }

    //详情
    public function info(){
        $id    = Request::param('id');
        $catId = Request::param('catId');

        //更新点击数
        if($id){
            Db::name($this->tableName)
                ->where('id',$id)
                ->inc('hits')
                ->update();
        }
        //设置顶级栏目，当顶级栏目不存在的时候顶级栏目为本身
        if($catId){
            $cate = Cate::where('id',$catId)
                ->find();
            $cate['topid'] = $cate['parentid'] ? $cate['parentid'] : $cate['id'];
        }

        //查找详情信息
        $info = Db::name($this->tableName)
            ->where('id',$id)
            ->find();
        $info = changefield($info,$this->moduleId);
        $info['url'] = getShowUrl($info);

        //tdk
        $title       = $cate['title']       ? $cate['title']       : $cate['catname']; //标题
        $keywords    = $info['keywords']    ? $info['keywords']    :
            ($cate['keywords']    ? $cate['keywords']    : $this->system['key']);      //关键词
        $description = $info['description'] ? $info['description'] :
            ($cate['description'] ? $cate['description'] : $this->system['des']);      //描述

        $view = [
            'cate'        => $cate,         //栏目信息
            'info'        => $info,         //详情信息
            'system'      => $this->system, //系统信息
            'public'      => $this->public, //公共目录
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
        ];

        $template=$info['template'] ? $info['template'] :
            ( $cate['template_show'] ? str_replace('.html', '', $cate['template_show']) : $this->tableName.'_show');
        View::assign($view);
        return View::fetch($template);
    }

}
