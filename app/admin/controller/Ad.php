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
 *                .::::::::::               | DATETIME: 2019/03/07
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
use think\facade\Db;
use think\facade\Request;

//实例化默认模型
use think\facade\View;

class Ad extends Base
{
    protected $validate = 'Ad';

    //列表
    public function index(){
        //条件筛选
        $keyword = Request::param('keyword');
        //全局查询条件
        $where=[];
        if(!empty($keyword)){
            $where[]=['a.name|a.description', 'like', '%'.$keyword.'%'];
        }
        //显示数量
        $pageSize = Request::param('page_size') ? Request::param('page_size') : config('page_size');
        //调取列表
        $list = Db::name('ad')
            ->alias('a')
            ->leftJoin('ad_type at','a.type_id = at.id')
            ->field('a.*,at.name as type_name')
            ->order('a.sort ASC,a.id DESC')
            ->where($where)
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
        $data = Request::except(['file']);
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        }else{
            $m = new M();
            $result =  $m->addPost($data);
            if($result['error']){
                $this->error($result['msg']);
            }else{
                $this->success($result['msg'],'index');
            }
        }
    }

    //修改
    public function edit(){
        $m = new M();
        $id = Request::param('id');
        if( empty($id) ){
            return ['error'=>1,'msg'=>'ID不存在'];
        }
        $info = $m->edit($id);
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
        $data = Request::except(['file']);
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        }else{
            $m = new M();
            $result = $m->editPost($data);
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
            if( empty($id) ){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->del($id);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::param('id');
            if (empty($id)) {
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->selectDel($id);
        }
    }

    //排序
    public function sort(){
        if(Request::isPost()){
            $data = Request::param();
            if (empty($data['id'])){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->sort($data);
        }
    }

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::param('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            $m = new M();
            return $m->state($id);
        }
    }

}
