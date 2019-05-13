<?php
/**
 * +----------------------------------------------------------------------
 * | 广告管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/04
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

use app\common\model\AdType;
use app\common\model\Ad as M;

use think\facade\Request;
use think\facade\View;

class Ad extends Base
{
    protected $validate = 'Ad';

    //列表
    public function index(){

        //全局查询条件
        $where=[];
        $keyword = Request::param('keyword');
        if(!empty($keyword)){
            $where[]=['name|description', 'like', '%'.$keyword.'%'];
        }
        $typeId  = Request::param('type_id');
        if(!empty($typeId)){
            $where[]=['type_id', '=', $typeId];
        }
        $dateran = Request::param('dateran');
        if(!empty($dateran)){
            $getDateran = get_dateran($dateran);
            $where[]=['create_time', 'between', $getDateran];
        }

        //获取列表
        $list = M::getList($where,$this->pageSize);
        //获取广告位列表
        $adType = AdType::select();

        $view = [
            'keyword'=>$keyword,
            'typeId' => $typeId,
            'dateran'=> $dateran,
            'adType'=> $adType,
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
        $adType = AdType::where('status',1)->select();
        if(!count($adType)){
            $this->error('请先添加广告位');
        }
        $view = [
            'adType' => $adType,
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
        $adType = AdType::where('status',1)->select();
        $view =[
            'info'   => $info,
            'adType' => $adType,
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

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::param('id');
            return M::state($id);
        }
    }

}
