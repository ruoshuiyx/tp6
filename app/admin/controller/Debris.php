<?php
/**
 * +----------------------------------------------------------------------
 * | 碎片管理控制器
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

use app\common\model\Debris as M;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Debris extends Base
{
    protected $validate = 'Debris';

    //列表
    public function index(){

        //全局查询条件
        $where=[];
        $keyword = Request::param('keyword');
        if($keyword){
            $where[]=['name|title', 'like', '%'.$keyword.'%'];
        }
        $dateran = Request::param('dateran');
        if(!empty($dateran)){
            $getDateran = get_dateran($dateran);
            $where[]=['create_time', 'between', $getDateran];
        }

        //获取列表
        $list = M::getList($where,$this->pageSize);

        $view = [
            'keyword'=>$keyword,
            'dateran'=> $dateran,
            'pageSize' => page_size($this->pageSize,$list->total()),
            'page' => $list->render(),
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
        $data = Request::except(['file'], 'post');
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            error($result);
        }else{
            $result =  M::addPost($data);
            if($result['error']){
                error($result['msg']);
            }else{
                success($result['msg'],'index');
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
        $data = Request::except(['file'], 'post');
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            error($result);
        }else{
            $result = M::editPost($data);
            if($result['error']){
                error($result['msg']);
            }else{
                success($result['msg'],'index');
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

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::param('id');
            return M::state($id);
        }
    }


}
