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

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Error extends Base
{
    public function initialize()
    {
        parent::initialize();
        //当前表
        $this->table = strtolower(Request::controller());
        //模型ID
        $this->moduleid = Db::name('cate')
            ->where('id','=',Request::param('cate'))
            ->value('moduleid');
    }
    //列表
    public function index(){
        if(Request::param('cate')){
            $cateId = Request::param('cate');
            //单页直接跳转到单页修改页面，如无修改则先添加一条记录然后进行修改
            if($this->table == 'page'){
                //查找是否有记录
                $page_id=Db::name($this->table)
                    ->where('cate_id','=',$cateId)
                    ->value('id');
                if(!$page_id){
                    $data['title'] = Db::name('cate')
                        ->where('id','=',$cateId)
                        ->value('catname');
                    $data['cate_id'] = $cateId;
                    $page_id = Db::name($this->table)
                        ->insertGetId($data);
                }
                //跳转编辑页
                return redirect($this->table.'/edit', ['cate' =>$cateId,'id' => $page_id ]);
            }

            $where[]=['cate_id','=',$cateId];
            if(Request::param('title')){
                $where[]=['title','like','%'.Request::param('title').'%'];
                $title = Request::param('title');
            }

            //查询是否包含图片字段,包含则展示
            $prefix = Config::get('database.prefix');
            $tablename=$prefix.$this->table;
            $Fields=Db::getTableFields($tablename);
            if(in_array('image',$Fields)){
                $image = ',a.image';
            }else{
                $image = '';
            }
            //查出所有内容数据
            $list = Db::name($this->table)
                ->alias('a')
                ->leftJoin('cate c','a.cate_id = c.id')
                ->field('a.id,a.title,a.cate_id,a.hits,a.sort,a.status,a.create_time'.$image.',c.catname')
                ->where($where)
                ->order('a.sort ASC,a.id DESC')
                ->paginate($this->pageSize,false,['query' => Request::get()]);

            //获取栏目列表
            $cate = Db::name('cate')
                ->field('id,catname,parentid')
                ->order('sort ASC,id ASC')
                ->select();
            $cate = tree_cate($cate);
        }
        $view = [
            'title'=> isset($title) ? $title : '',
            'pageSize' => page_size($this->pageSize,$list->total()),
            'page' => $list->render(),
            'list' => $list,
            'cateId'=> $cateId,
            'cate' => $cate,
            'empty'=> empty_list(9),
        ];
        View::assign($view);
        return View::fetch('error/index');

    }

    //添加
    public function add(){
        if(Request::isPost()){
            //根据cate_id获取所有字段
            if(Request::post('cate_id')){
                $data = Request::post();
                //去除上传图片和文件的无用字段
                if(array_key_exists('file',$data)){
                    unset($data['file']);
                }
                //查找栏目相关数据(已隐藏的数据不再做修改)
                $list = Db::name('cate')
                    ->alias('c')
                    ->leftJoin('module m','c.moduleid = m.id')
                    ->leftJoin('field f','c.moduleid = f.moduleid')
                    ->field('c.moduleid,m.name as m_table,f.*')
                    ->where('c.id','=',input('post.cate_id'))
                    ->where('f.status','=',1)
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
                        case 'cate'://栏目
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
                    $this->success('添加成功!',url('index', ['cate' => $data['cate_id']]));
                }else{
                    $this->error('添加失败!');
                }
            }
        }
        if(Request::param('cate')){
            //获取栏目列表
            $cate = Db::name('cate')
                ->field('id,catname,parentid,moduleid')
                ->order('sort ASC,id ASC')
                ->select();
            $cate = tree_cate($cate);

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

            $view = [
                'cate'     => $cate,
                'template' => getTemplate(),//获取模版列表
                'field'    => $field,
                'moduleid' => $this->moduleid,
                'cateId'    => Request::param('cate'),
                'info'     => null,
                'time'     => date("Y-m-d H:i:s"),
            ];
            View::assign($view);
            return View::fetch('error/add');
        }
    }

    //编辑
    public function edit(){
        if(Request::isPost()){
            //根据cate_id获取所有字段
            if(Request::post('cate_id')){
                $data = Request::post();
                //去除上传图片和文件的无用字段
                if(array_key_exists('file',$data)){
                    unset($data['file']);
                }
                //查找栏目相关数据(已隐藏的数据不再做修改)
                $list = Db::name('cate')
                    ->alias('c')
                    ->leftJoin('module m','c.moduleid = m.id')
                    ->leftJoin('field f','c.moduleid = f.moduleid')
                    ->field('c.moduleid,m.name as m_table,f.*')
                    ->where('c.id','=',input('post.cate_id'))
                    ->where('f.status','=',1)
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
                        case 'cate'://栏目
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
                    $this->success('修改成功!',url('index', ['cate' => $data['cate_id']]));
                }else{
                    $this->error('修改失败!');
                }
            }
        }
        else{
            //展示数据
            if(Request::param('cate')){
                //获取栏目列表
                $cate = Db::name('cate')
                    ->field('id,catname,parentid,moduleid')
                    ->order('sort ASC,id ASC')
                    ->select();
                $cate = tree_cate($cate);

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

                //调取内容
                $info = Db::name($this->table)
                    ->where('id',Request::param('id'))
                    ->find();

                //处理特殊字段
                foreach ($field as $k=>$v){
                    if(array_key_exists($v['field'],$info)){
                        if($info[$v['field']]){
                            if($v['type']=='images'){
                                $info[$v['field']] = json_decode($info[$v['field']],true);
                            }
                        }
                    }
                }

                $view = [
                    'cate'=>$cate,
                    'template'=>getTemplate(),
                    'field'=>$field,
                    'moduleid'=>$this->moduleid,
                    'cateId'=>Request::param('cate'),
                    'info'=>$info,
                    'time'=>date("Y-m-d H:i:s")
                ];
                View::assign($view);
                return View::fetch('error/add');
            }
        }
    }

    //状态
    public function state(){
        if(Request::isPost()){
            $id = Request::param('id');

            //查找当前状态值
            $status = Db::name($this->table)
                ->where('id',$id)
                ->value('status');
            $status = $status==1?0:1;
            //更新
            Db::name($this->table)
                ->where('id', $id)
                ->update(['status' => $status]);
            return json(['error'=>0,'msg'=>'修改成功!']);
        }
    }

    //删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::param('id');
            Db::name($this->table)
                ->delete($id);
            return json(['error'=>0,'msg'=>'删除成功!']);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            $ids = explode(',',$id);
            Db::name($this->table)
                ->delete($ids);
            return json(['error'=>0,'msg'=>'删除成功!']);
        }
    }

    //批量移动
    public function selectMove(){
        //判断选择的模型是否一致
        if(Request::post('check')==true){
            $moduleid = Db::name('cate')
                ->where('id',Request::post('cate'))
                ->value('moduleid');
            $moduleidmove = Db::name('cate')
                ->where('id',Request::post('cate_id_move'))
                ->value('moduleid');
            if($moduleid==$moduleidmove){
                if(Request::param('id')){
                    //获取表名称
                    $table = Db::name('module')
                        ->where('id',$moduleid)
                        ->value('name');
                    //执行修改操作
                    $res = Db::name($table)
                        ->where('id', 'in' , Request::post('id'))
                        ->update(['cate_id' => Request::post('cate_id_move')]);
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
            return json($result);
        }
    }

    //排序
    public function sort(){
        if(Request::isPost()){
            $id = Request::post('id');
            $sort = Request::post('sort');

            Db::name($this->table)
                ->where('id',$id)
                ->update(['sort'=>$sort]);
            return json(['error'=>0,'msg'=>'修改成功!']);
        }
    }
}
