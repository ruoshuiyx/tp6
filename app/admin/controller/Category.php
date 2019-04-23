<?php
/**
 * +----------------------------------------------------------------------
 * | 栏目管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/27
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

use app\common\model\Cate as M;
use app\common\model\Module as MM;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Category extends Base
{
    protected $validate = 'Cate';

    //栏目列表
    public function index(){
        //调取栏目列表，需关联模型表
        $cate = Db::name('cate')
            ->alias('a')
            ->leftJoin('module m','a.moduleid = m.id')
            ->field('a.id,a.catname,a.sort,a.is_menu,a.is_next,a.parentid,a.moduleid,m.title as modulename,m.name as moduleurl')
            ->order('a.sort ASC,a.id ASC')
            ->select();
        $cate = tree_cate($cate);
        $view = [
            'list' => $cate,
            'empty'=> empty_list(8),
        ];
        View::assign($view);
        return View::fetch();
    }

    //添加栏目
    public function add(){
        //获取模型列表
        $module = MM::field('id,title,name')
            ->where('status','=','1')
            ->select();

        //获取栏目列表
        $cate = M::field('id,catname,parentid')
            ->order('sort ASC,id ASC')
            ->select();
        $cate = tree_cate($cate);

        //获取所有模版
        $template = getTemplate();

        //获取默认上级
        $id = Request::param('id') ? Request::param('id') : 0;

        //获取默认模型
        $moduleid = Request::param('moduleid') ? Request::param('moduleid') : 0;

        $view = [
            'module'=>$module,
            'cate' => $cate,
            'template' => $template,
            'id' => $id,
            'moduleid' => $moduleid,
            'info' => null
        ];
        View::assign($view);
        return View::fetch();
    }

    //添加保存
    public function addPost(){
        if(Request::isPost()){
            $data = Request::except(['file'], 'post');
            $result = $this->validate($data,$this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            }else{
                $result =  M::addPost($data);
                if($result['error']){
                    $this->error($result['msg']);
                }else{
                    $this->success($result['msg'],'index');
                }
            }
        }
    }

    //修改栏目
    public function edit(){
        //获取模型列表
        $module = MM::field('id,title,name')
            ->where('status','=','1')
            ->select();

        //获取栏目列表
        $cate = M::field('id,catname,parentid')
            ->order('sort ASC,id ASC')
            ->select();
        $cate = tree_cate($cate);

        //获取所有模版
        $template = getTemplate();

        $id = Request::param('id');
        $info = M::where('id',$id)
            ->find();
        $view = [
            'module'=>$module,
            'cate' => $cate,
            'template' => $template,
            'id' => $info['parentid'],
            'moduleid' => '',
            'info' => $info
        ];
        View::assign($view);
        return View::fetch('add');
    }

    //修改保存
    public function editPost(){
        $data = Request::except(['file'], 'post');
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        }else{
            $result = M::editPost($data);
            if($result['error']){
                $this->error($result['msg']);
            }else{
                $this->success($result['msg'],'index');
            }
        }
    }

    //删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::param('id');
            return M::del($id);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::param('id');
            return M::selectDel($id);
        }
    }

    //排序
    public function sort(){
        if(Request::isPost()){
            $data = Request::post();
            return M::sort($data);
        }
    }

    //设置导航显示
    public function isMenu(){
        if(Request::isPost()){
            $id = Request::param('id');
            $data = M::find($id);
            $status = $data['is_menu']==1?0:1;
            M::where('id',$data['id'])
                ->update(['is_menu'=>$status]);
            $data -> save();
            return json(['error'=>0,'msg'=>'修改成功!']);
        }
    }

    //设置跳转下级
    public function isNext(){
        if(Request::isPost()){
            $id = Request::param('id');
            $data = M::find($id);
            $status = $data['is_next']==1?0:1;
            M::where('id',$data['id'])
                ->update(['is_next'=>$status]);
            $data -> save();
            return json(['error'=>0,'msg'=>'修改成功!']);
        }
    }
}
