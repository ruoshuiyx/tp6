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
use think\Db;
use think\facade\Request;

//实例化默认模型
use app\common\model\Cate as C;
use app\common\model\Module as M;

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
        $this->view->assign('list'  , $cate);
        $this->view->assign('empty' , empty_list(8));
        return $this->view->fetch();
    }

    //添加栏目
    public function add(){
        //获取模型列表
        $module = M::field('id,title,name')
            ->where('status','=','1')
            ->select();
        $this->view->assign('module',$module);

        //获取栏目列表
        $cate = C::field('id,catname,parentid')
            ->order('sort ASC,id ASC')
            ->select();
        $cate = tree_cate($cate);
        $this->view->assign('cate',$cate);

        //获取所有模版
        $template = getTemplate();
        $this->view->assign('template',$template);

        //获取默认上级
        $id = Request::param('id') ? Request::param('id') : 0;
        $this->view->assign('id',$id);

        //获取默认模型
        $moduleid = Request::param('moduleid') ? Request::param('moduleid') : 0;
        $this->view->assign('moduleid',$moduleid);

        $this->view->assign('info',null);
        return $this->view->fetch();
    }

    //添加保存
    public function addPost(){
        if(Request::isPost()){
            $data = Request::except('file');
            $result = $this->validate($data,$this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            }else{
                $result = C::create($data);
                if($result->id){
                    $this->success('添加成功!','index');
                }else{
                    $this->error('添加失败!');
                }
            }
        }
    }

    //修改栏目
    public function edit(){
        //获取模型列表
        $module = M::field('id,title,name')
            ->where('status','=','1')
            ->select();
        $this->view->assign('module',$module);

        //获取栏目列表
        $cate = C::field('id,catname,parentid')
            ->order('sort ASC,id ASC')
            ->select();
        $cate = tree_cate($cate);
        $this->view->assign('cate',$cate);

        //获取所有模版
        $template = getTemplate();
        $this->view->assign('template',$template);

        $id = Request::param('id');
        $info = C::where('id',$id)
            ->find();
        $this->view->assign('info', $info);
        $this->view->assign('id',$info['parentid']);
        $this->view->assign('moduleid','');
        return $this->view->fetch('add');
    }

    //修改保存
    public function editPost(){
        if(Request::isPost()) {
            $data = Request::except('file');
            $result = C::where('id' ,'=', $data['id'])
                ->update($data);
            if($result){
                $this->success('修改成功!','index');
            }else{
                $this->error('修改失败!');
            }
        }
    }

    //删除栏目
    public function del(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if( empty($id) ){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            C::destroy($id);
            return ['error'=>0,'msg'=>'删除成功!'];
        }
    }

    //批量删除栏目
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if( empty($id) ){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            C::destroy($id);
            return ['error'=>0,'msg'=>'删除成功!'];
        }
    }

    //栏目排序
    public function sort(){
        if(Request::isPost()){
            $id = Request::param('id');
            $sort = Request::param('sort');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            C::where('id',$id)
                ->setField('sort', $sort);
            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }

    //设置导航显示
    public function isMenu(){
        if(Request::isPost()){
            $id = Request::param('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = C::get($id);
            $is_menu = $info['is_menu']==1?0:1;

            C::where('id',$id)
                ->setField('is_menu', $is_menu);

            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }

    //设置跳转下级
    public function isNext(){
        if(Request::isPost()){
            $id = Request::param('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }

            $info = C::get($id);
            $is_next = $info['is_next']==1?0:1;

            C::where('id',$id)
                ->setField('is_next', $is_next);

            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }
}
