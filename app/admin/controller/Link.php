<?php
/**
 * +----------------------------------------------------------------------
 * | 友情链接控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/04
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

use app\common\model\Link as M;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Link extends Base
{
    protected $validate = 'Link';

    //列表
    public function index(){
        //条件筛选
        $keyword = Request::param('keyword');
        //全局查询条件
        $where=[];
        if($keyword){
            $where[]=['name|url', 'like', '%'.$keyword.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : Config::get('app.page_size');

        //调取列表
        $list = M::where($where)
            ->order('sort ASC,id DESC')
            ->paginate($pageSize,false,['query' => request()->param()]);
        $page = $list->render();
        $view = [
            'keyword'=>$keyword,
            'pageSize' => page_size($pageSize),
            'page' => $page,
            'list' => $list,
            'empty'=> empty_list(12),
        ];
        View::assign($view);
        return View::fetch();
    }

    //添加
    public function add(){
        $view = [
            'info'   => null
        ];
        View::assign($view);
        return View::fetch();
    }

    //添加保存
    public function addPost(){
        $data = Request::except(['file']);
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

    //修改
    public function edit(){
        $id = Request::param('id');
        $info = M::edit($id);
        $view =[
            'info'   => $info,
        ];
        View::assign($view);
        return View::fetch('add');
    }

    //修改保存
    public function editPost(){
        $data = Request::except(['file']);
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
            $data = Request::param();
            return M::sort($data);
        }
    }

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::param('id');
            return M::state($id);
        }
    }

}
