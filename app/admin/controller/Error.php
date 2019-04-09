<?php
/**
 * +----------------------------------------------------------------------
 * | 内容控制器
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

class Error extends Base
{
    public function initialize()
    {
        parent::initialize();
        //当前表
        $this->table = strtolower(Request::controller());
        //模型ID
        $this->moduleid = Db::name('cate')
            ->where('id','=',Request::param('catid'))
            ->value('moduleid');
    }
    //列表
    public function index(){
        if(Request::param('catid')){
            $catid = Request::param('catid');
            //单页直接跳转到单页修改页面，如无修改则先添加一条记录然后进行修改
            if($this->table == 'page'){
                //查找是否有记录
                $page_id=Db::name($this->table)
                    ->where('catid','=',$catid)
                    ->value('id');
                if(!$page_id){
                    $data['title'] = Db::name('cate')
                        ->where('id','=',$catid)
                        ->value('catname');
                    $data['catid'] = $catid;
                    $page_id = Db::name($this->table)
                        ->insertGetId($data);
                }
                //跳转编辑页
                $this->redirect($this->table.'/edit', ['catid' =>$catid,'id' => $page_id ]);
            }

            $where[]=['catid','=',$catid];
            if(Request::param('title')){
                $where[]=['title','like','%'.Request::param('title').'%'];
                $this->view->assign('title',Request::param('title'));
            }else{
                $this->view->assign('title',null);
            }

            //显示数量
            $pageSize=input('page_size')?input('page_size'):config('page_size');
            $this->view->assign('pageSize', page_size($pageSize));
            //查出所有内容数据
            $list = Db::name($this->table)
                ->field('id,title,catid,hits,sort,status,create_time')
                ->where($where)
                ->order('sort ASC,id DESC')
                ->paginate($pageSize);
            $page = $list->render();
            $this->view->assign('page' , $page);
            $this->view->assign('list' , $list);
            $this->view->assign('catid' ,$catid);
            $this->view->assign('empty', empty_list(8));

            //获取栏目列表
            $cate = Db::name('cate')
                ->field('id,catname,parentid')
                ->order('sort ASC,id ASC')
                ->select();
            $cate = tree_cate($cate);
            $this->view->assign('cate',$cate);
        }
        return $this->view->fetch('error/index');
    }

    //添加
    public function add(){
        if(Request::isPost()){
            //根据catid获取所有字段
            if(Request::post('catid')){
                $data = Request::post();
                //去除上传图片和文件的无用字段
                if(array_key_exists('file',$data)){
                    unset($data['file']);
                }
                //查找栏目相关数据
                $list = Db::name('cate')
                    ->alias('c')
                    ->leftJoin('module m','c.moduleid = m.id')
                    ->leftJoin('field f','c.moduleid = f.moduleid')
                    ->field('c.moduleid,m.name as m_table,f.*')
                    ->where('c.id','=',input('post.catid'))
                    ->order(['f.sort'=>'asc','f.id'=>'asc'])
                    ->select();
                //循环判断数据合法性
                foreach ($list as $k=>$v){
                    //判断是否必填
                    if($v['required']==1 ){
                        if(array_key_exists($v['field'],$data)){
                            if(!$data[$v['field']]){
                                $this->error($v['name'].'为必填项!');
                            }
                        }else{
                            $this->error($v['name'].'为必填项!');
                        }

                    }
                    $minlength = $v['minlength'];
                    $maxlength = $v['maxlength'];
                    switch ($v['type'])
                    {
                        case 'catid'://栏目
                            $maxlength = $maxlength ? min($maxlength, 5) : 5;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'title'://标题
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'text'://单行文本
                            $maxlength = $maxlength ? min($maxlength, 65535) : 65535;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'textarea'://多行文本
                            $v['setup'] = string2array($v['setup']);
                            $maxnum = $v['setup']['fieldtype']=='mediumtext' ? 16777215 : 65535;
                            $maxlength = $maxlength ? min($maxlength, $maxnum) : $maxnum;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'editor'://编辑器
                            $maxlength = $maxlength ? min($maxlength, 65535) : 65535;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'select'://下拉列表
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'radio'://单选按钮
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'checkbox'://复选框
                            if(array_key_exists($v['field'],$data)){
                                //dump($data[$v['field']]);exit;
                                $data[$v['field']] = is_array($data[$v['field']]) ? implode(",", $data[$v['field']]) : $data[$v['field']];
                                $maxlength = $maxlength ? min($maxlength, 255) : 255;
                                $length = strlen($data[$v['field']]);
                                //判断长度是否合法
                                if(! ($length>= $minlength && $length<=$maxlength) ){
                                    $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                                }
                            }

                            break;
                        case 'image'://单张图片
                            $maxlength = $maxlength ? min($maxlength, 80) : 80;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'images'://多张图片
                            $maxlength = $maxlength ? min($maxlength, 16777215) : 16777215;
                            if(array_key_exists($v['field'],$data)){
                                for ($i=0; $i<count($data[$v['field']]); $i++) {
                                    $images[$i]['image']=$data[$v['field']][$i];
                                    $images[$i]['title']=$data[$v['field'].'_title'][$i];
                                }
                                $data[$v['field']] = json_encode($images);
                                $length = strlen($data[$v['field']]);
                                //判断长度是否合法
                                if(! ($length>= $minlength && $length<=$maxlength) ){
                                    $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                                }
                                //去除上传图片和文件的无用字段
                                unset($data[$v['field'].'_title']);
                            }else{
                                $data[$v['field']] = '';
                            }
                            break;
                        case 'file'://文件上传
                            $maxlength = $maxlength ? min($maxlength, 80) : 80;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'number'://数字
                            $maxlength = $maxlength ? min($maxlength, 10) : 10;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'datetime'://时间
                            $data[$v['field']] = strtotime($data[$v['field']]);
                            $maxlength = $maxlength ? min($maxlength, 11) : 11;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        default:
                    }
                }
            }
            //入库操作
            if($data){
                $id = Db::name($this->table)->insertGetId($data);
                if($id){
                    $this->success('添加成功!',url('index', ['catid' => $data['catid']]));
                }else{
                    $this->error('添加失败!');
                }
            }
        }
        if(Request::param('catid')){
            //获取栏目列表
            $cate = Db::name('cate')
                ->field('id,catname,parentid,moduleid')
                ->order('sort ASC,id ASC')
                ->select();
            $cate = tree_cate($cate);
            $this->view->assign('cate',$cate);

            //获取模版列表
            $this->view->assign('template',getTemplate());

            //获取所有字段
            $field = Db::name('field')
                ->where('moduleid','=',$this->moduleid)
                ->order('sort ASC,id ASC')
                ->select();
            foreach ($field as $k=>$v){
                if($field[$k]['setup']){
                    $field[$k]['setup'] = string2array($v['setup']);
                    if(array_key_exists('options',$field[$k]['setup'])){
                        $field[$k]['setup']['options'] = explode("\n",$field[$k]['setup']['options']);
                        foreach ($field[$k]['setup']['options'] as $kk=>$vv){
                            $field[$k]['setup']['options'][$kk] = trim_array_element(explode("|",$field[$k]['setup']['options'][$kk]));

                        }
                    }
                }

            }
            //dump($field);
            $this->view->assign('field',$field);

            $this->view->assign('moduleid',$this->moduleid);
            $this->view->assign('catid',Request::param('catid'));

            $this->view->assign('info',null);
            $this->view->assign('time',date("Y-m-d H:i:s"));
            $this->view->assign('moduleid',$this->moduleid);
            return $this->view->fetch('error/add');
        }
    }

    //编辑
    public function edit(){
        if(Request::isPost()){
            //根据catid获取所有字段
            if(Request::post('catid')){
                $data = Request::post();
                //去除上传图片和文件的无用字段
                if(array_key_exists('file',$data)){
                    unset($data['file']);
                }
                //查找栏目相关数据
                $list = Db::name('cate')
                    ->alias('c')
                    ->leftJoin('module m','c.moduleid = m.id')
                    ->leftJoin('field f','c.moduleid = f.moduleid')
                    ->field('c.moduleid,m.name as m_table,f.*')
                    ->where('c.id','=',input('post.catid'))
                    ->order(['f.sort'=>'asc','f.id'=>'asc'])
                    ->select();
                //循环判断数据合法性
                foreach ($list as $k=>$v){
                    //判断是否必填
                    if($v['required']==1 ){
                        if(array_key_exists($v['field'],$data)){
                            if(!$data[$v['field']]){
                                $this->error($v['name'].'为必填项!');
                            }
                        }else{
                            $this->error($v['name'].'为必填项!');
                        }

                    }
                    $minlength = $v['minlength'];
                    $maxlength = $v['maxlength'];
                    switch ($v['type'])
                    {
                        case 'catid'://栏目
                            $maxlength = $maxlength ? min($maxlength, 5) : 5;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'title'://标题
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'text'://单行文本
                            $maxlength = $maxlength ? min($maxlength, 65535) : 65535;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'textarea'://多行文本
                            $v['setup'] = string2array($v['setup']);
                            $maxnum = $v['setup']['fieldtype']=='mediumtext' ? 16777215 : 65535;
                            $maxlength = $maxlength ? min($maxlength, $maxnum) : $maxnum;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'editor'://编辑器
                            $maxlength = $maxlength ? min($maxlength, 65535) : 65535;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'select'://下拉列表
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'radio'://单选按钮
                            $maxlength = $maxlength ? min($maxlength, 255) : 255;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'checkbox'://复选框
                            if(array_key_exists($v['field'],$data)){
                                //dump($data[$v['field']]);exit;
                                $data[$v['field']] = is_array($data[$v['field']]) ? implode(",", $data[$v['field']]) : $data[$v['field']];
                                $maxlength = $maxlength ? min($maxlength, 255) : 255;
                                $length = strlen($data[$v['field']]);
                                //判断长度是否合法
                                if(! ($length>= $minlength && $length<=$maxlength) ){
                                    $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                                }
                            }

                            break;
                        case 'image'://单张图片
                            $maxlength = $maxlength ? min($maxlength, 80) : 80;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'images'://多张图片
                            $maxlength = $maxlength ? min($maxlength, 16777215) : 16777215;
                            if(array_key_exists($v['field'],$data)){
                                for ($i=0; $i<count($data[$v['field']]); $i++) {
                                    $images[$i]['image']=$data[$v['field']][$i];
                                    $images[$i]['title']=$data[$v['field'].'_title'][$i];
                                }
                                $data[$v['field']] = json_encode($images);
                                $length = strlen($data[$v['field']]);
                                //判断长度是否合法
                                if(! ($length>= $minlength && $length<=$maxlength) ){
                                    $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                                }
                                //去除上传图片和文件的无用字段
                                unset($data[$v['field'].'_title']);
                            }else{
                                $data[$v['field']] = '';
                            }
                            break;
                        case 'file'://文件上传
                            $maxlength = $maxlength ? min($maxlength, 80) : 80;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'number'://数字
                            $maxlength = $maxlength ? min($maxlength, 10) : 10;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        case 'datetime'://时间
                            $data[$v['field']] = strtotime($data[$v['field']]);
                            $maxlength = $maxlength ? min($maxlength, 11) : 11;
                            $length = strlen($data[$v['field']]);
                            //判断长度是否合法
                            if(! ($length>= $minlength && $length<=$maxlength) ){
                                $this->error($v['name'].'长度超限，最多字符：'.$maxlength);
                            }
                            break;
                        default:
                    }
                }
            }
            //入库操作
            if($data){
                $result = Db::name($this->table)
                    ->where('id',$data['id'])
                    ->update($data);
                if($result){
                    $this->success('修改成功!',url('index', ['catid' => $data['catid']]));
                }else{
                    $this->error('修改失败!');
                }
            }
        }
        else{
            //展示数据
            if(Request::param('catid')){
                //获取栏目列表
                $cate = Db::name('cate')
                    ->field('id,catname,parentid,moduleid')
                    ->order('sort ASC,id ASC')
                    ->select();
                $cate = tree_cate($cate);
                $this->view->assign('cate',$cate);

                //获取模版列表
                $this->assign('template',getTemplate());

                //获取所有字段
                $field = Db::name('field')
                    ->where('moduleid','=',$this->moduleid)
                    ->order('sort ASC,id ASC')
                    ->select();
                foreach ($field as $k=>$v){
                    if($field[$k]['setup']){
                        $field[$k]['setup'] = string2array($v['setup']);
                        if(array_key_exists('options',$field[$k]['setup'])){
                            $field[$k]['setup']['options'] = explode("\n",$field[$k]['setup']['options']);
                            foreach ($field[$k]['setup']['options'] as $kk=>$vv){
                                $field[$k]['setup']['options'][$kk] = trim_array_element(explode("|",$field[$k]['setup']['options'][$kk]));

                            }
                        }
                    }

                }
                //dump($field);
                $this->view->assign('field',$field);
                $this->view->assign('moduleid',$this->moduleid);
                $this->view->assign('catid',Request::param('catid'));

                //调取内容
                $info = Db::name($this->table)
                    ->where('id',Request::param('id'))
                    ->find();

                //处理特殊字段
                foreach ($field as $k=>$v){
                    if(array_key_exists($v['field'],$info)){
                        if($info[$v['field']]){
                            if($v['type']=='images'){
                                //echo 1;exit;
                                $info[$v['field']] = json_decode($info[$v['field']],true);
                            }
                        }
                    }
                }

                //dump($info);exit;
                $this->view->assign('info',$info);
                $this->view->assign('time',date("Y-m-d H:i:s"));
                $this->view->assign('moduleid',$this->moduleid);
                return $this->view->fetch('error/add');
            }
        }
    }

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::post('id');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            //查找当前状态值
            $status = Db::name($this->table)
                ->where('id',$id)
                ->value('status');
            $status = $status==1?0:1;
            //更新
            Db::name($this->table)
                ->where('id', $id)
                ->update(['status' => $status]);

            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }

    //删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            Db::name($this->table)
                ->delete($id);
            return ['error'=>0,'msg'=>'删除成功!'];
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            Db::name($this->table)
                ->delete($id);
            return ['error'=>0,'msg'=>'删除成功!'];
        }
    }

    //批量移动
    public function selectMove(){
        //判断选择的模型是否一致
        if(Request::post('check')==true){
            $moduleid = Db::name('cate')
                ->where('id',Request::post('catid'))
                ->value('moduleid');
            $moduleidmove = Db::name('cate')
                ->where('id',Request::post('catidmove'))
                ->value('moduleid');
            if($moduleid==$moduleidmove){
                if(Request::post('id')){
                    //获取表名称
                    $table = Db::name('module')
                        ->where('id',$moduleid)
                        ->value('name');
                    //执行修改操作
                    $res = Db::name($table)
                        ->where('id', 'in' , Request::post('id'))
                        ->update(['catid' => Request::post('catidmove')]);
                    if($res){
                        $result['error'] = 0;
                        $result['msg'] = '移动完毕';
                    }else{
                        $result['error'] = 1;
                        $result['msg'] = '移动失败';
                    }
                }
            }else{
                $result['error'] = 1;
                $result['msg'] = '不同模型间不可移动';
            }
            return $result;
        }
    }

    //排序
    public function sort(){
        if(Request::isPost()){
            $id = Request::post('id');
            $sort = Request::post('sort');
            if (empty($id)){
                return ['error'=>1,'msg'=>'ID不存在'];
            }
            Db::name($this->table)
                ->where('id',$id)
                ->setField('sort', $sort);
            return ['error'=>0,'msg'=>'修改成功!'];
        }
    }
}
