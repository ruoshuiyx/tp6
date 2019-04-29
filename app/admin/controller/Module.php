<?php
/**
 * +----------------------------------------------------------------------
 * | 模型管理控制器
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
use app\common\model\module as M;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class module extends Base
{
    protected $table;
    function initialize()
    {
        parent::initialize();
        $this->table=Db::name('module');
    }

    //模型列表
    public function index(){

        //全局查询条件
        $where=[];
        $title=Request::param('title');
        if($title){
            $where[]=['title|name', 'like', '%'.$title.'%'];
        }
        //获取列表
        $list = M::getList($where,$this->pageSize);

        $view = [
            'title'=>$title,
            'pageSize' => page_size($this->pageSize,$list->total()),
            'page' => $list->render(),
            'list' => $list,
            'empty'=> empty_list(7),
        ];
        View::assign($view);
        return View::fetch();
    }

    //模型状态
    public function moduleState(){
        if(Request::isPost()){
            $id = Request::param('id');

            $status = M::where('id='.$id)
                ->value('status');
            $status = $status==1?0:1;
            if(M::where('id='.$id)->update(['status'=>$status])!==false){
                return json(['error'=>0,'msg'=>'修改成功!']);
            }else{
                return json(['error'=>1,'msg'=>'修改失败!']);
            }
        }
    }

    //模型删除
    public function del(){
        if(Request::isPost()) {
            $id = Request::post('id');
            M::where('id','=',$id)
                ->delete();
            return json(['error'=>0,'msg'=>'删除成功!']);
        }
    }

    //批量删除
    public function selectDel(){
        if(Request::isPost()) {
            $id = Request::post('id');
            M::destroy($id);
            return json(['error'=>0,'msg'=>'删除成功!']);

        }
    }

    //模型添加
    public function add(){
        $view =[
            'info'   => null
        ];
        View::assign($view);
        return View::fetch('');
    }

    //模型添加保存
    public function addPost(){
        if(Request::isPost()){
            //获取数据库所有表名
            $tables = Db::getConnection()->getTables();
            //组装表名
            $prefix = Config::get('database.prefix');
            $tablename = $prefix.Request::param('name');
            //判断表名是否已经存在
            if(in_array($tablename,$tables)){
                error('该表已经存在！');
            }
            //$name = ucfirst(Request::post('name'));

            $data = Request::except(['emptytable']);
            $data['type'] = 1;

            $moduleid = $this->table->insert($data);
            $moduleid = $this->table->where('title','=',$data['title'])->field('id')->find();
            $moduleid = $moduleid['id'];

            if(empty($moduleid)){
                error('添加模型失败！');
            }
            //暂时只提供文章模型
            $emptytable = Request::post('emptytable');

            if($emptytable=='1'){

                Db::execute("CREATE TABLE `".$tablename."` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
			  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '标题',
			  `title_style` varchar(225) NOT NULL DEFAULT '' COMMENT '标题样式',
			  `thumb` varchar(225) NOT NULL DEFAULT '' COMMENT '缩略图',
			  `keywords` varchar(120) NOT NULL DEFAULT '' COMMENT '关键词',
			  `description` mediumtext NOT NULL COMMENT '描述',
			  `content` mediumtext NOT NULL  COMMENT '内容',
			  `template` varchar(40) NOT NULL DEFAULT '' COMMENT '模板',
			  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
			  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
			  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击',
			  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
			  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
			  PRIMARY KEY (`id`),
			  KEY `status` (`id`,`status`,`sort`),
			  KEY `catid` (`id`,`catid`,`status`),
			  KEY `sort` (`id`,`catid`,`status`,`sort`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8");
                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'catid', '栏目', '', '1', '1', '6', '', '必须选择一个栏目', '', 'catid', '','1','', '1', '1', '1')");

                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'title', '标题', '', '1', '1', '80', '', '标题必须为1-80个字符', '', 'title', '','1','',  '2', '1', '1')");

                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'keywords', '关键词', '', '0', '0', '80', '', '', '', 'text', 'array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','1','',  '3', '1', '1')");
                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'description', 'SEO简介', '', '0', '0', '0', '', '', '', 'textarea', 'array (\n  \'fieldtype\' => \'mediumtext\',\n  \'rows\' => \'4\',\n  \'cols\' => \'55\',\n  \'default\' => \'\',\n)','1','',  '4', '1', '1')");
                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'content', '内容', '', '0', '0', '0', '', '', '', 'editor', 'array (\n  \'edittype\' => \'wangEditor\',\n)','1','',  '5', '1', '1')");
                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'create_time', '发布时间', '', '1', '0', '0', 'date', '', 'createtime', 'datetime', '','1','',  '6', '1', '1')");
                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'status', '状态', '', '0', '0', '0', '', '', '', 'radio', 'array (\n  \'options\' => \'发布|1\r\n定时发布|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'75\',\n  \'default\' => \'1\',\n)','1','','7', '1', '1')");

                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'hits', '点击次数', '', '0', '0', '8', '', '', '', 'number', 'array (\n  \'size\' => \'10\',\n  \'numbertype\' => \'1\',\n  \'decimaldigits\' => \'0\',\n  \'default\' => \'0\',\n)','1','',  '10', '1', '1')");

                Db::execute("INSERT INTO `".$prefix."field` (`moduleid`,`field`,`name`,`tips`,`required`,`minlength`,`maxlength`,`pattern`,`errormsg`,`class`,`type`,`setup`,`ispost`,`unpostgroup`,`sort`,`status`,`issystem`) VALUES ( '".$moduleid."', 'template', '模板', '', '0', '0', '0', '', '', '', 'template', '','1','', '13', '1', '1')");

            }

            if ($moduleid !==false) {
                success('添加模型成功', 'index');
            }else{
                error('添加模型失败');
            }
        }
    }

    //模型修改
    public function edit(){
        $where['id'] = input('id');
        $info = Db::name('module')
            ->field('id,title,name,description,listfields')
            ->where($where)
            ->find();
        $view = [
            'info'   => $info
        ];
        View::assign($view);
        return View::fetch('add');
    }

    //模型修改保存
    public function editPost(){
        if(Request::isPost()){
            $data = Request::except(['name']);
            if(Db::name('module')->update($data)!==false){
                success('修改成功!', 'index');
            }else{
                error('修改失败！');
            }
        }
    }

    /****************************模型字段******************************/

    //字段列表
    public function field(){
        $nodostatus = array('catid','title','status','create_time');
        $sysfield = array('catid','title','thumb','keywords','description','status','create_time','url','template');

        $list = Db::name('field')
            ->where("moduleid",'=',Request::param('id'))
            ->order('sort asc,id asc')
            ->select();
        foreach ($list as $k=>$v){
            if($v['status']==1){
                if(in_array($v['field'],$nodostatus)){
                    $list[$k]['disable']=2;//状态不可变更
                }else{
                    $list[$k]['disable']=0;//已启用
                }
            }else{
                $list[$k]['disable']=1;//已禁用
            }

            if(in_array($v['field'],$sysfield)){
                $list[$k]['delStatus']=1;//不可删除
            }else{
                $list[$k]['delStatus']=0;//可删除
            }
        }

        $view = [
            'list' => $list,
            'moduleid'   => Request::param('id')
        ];
        View::assign($view);
        return View::fetch();
    }

    //字段排序
    public function fieldSort(){
        $data = Request::post();
        if(Db::name('field')->update($data)!==false){
            return json(['error' => 0,'msg' => '操作成功！']);
        }else{
            return json(['error'=>1,'msg'=>'操作失败！']);
        }
    }

    //字段状态
    public function fieldState(){
        if(Request::isPost()){
            $id = Request::param('id');
            $status = Db::name('field')
                ->where('id','=',$id)
                ->value('status');
            $status = $status==1?0:1;
            if(Db::name('field')->where('id','=',$id)->update(['status'=>$status])!==false){
                return json(['error'=>0,'msg'=>'设置成功!']);
            }else{
                return json(['error'=>1,'msg'=>'设置失败!']);
            }
        }
    }

    //添加字段
    public function fieldAdd(){
        $view = [
            'moduleid'  => Request::param('moduleid'),
            'info'      => null,
            'fieldInfo' => null,
        ];
        View::assign($view);
        return View::fetch('field_add');
    }

    //添加字段保存
    public function fieldAddPost(){
        if(Request::isPost()){
            if(Request::param('isajax')) {
                //调用字段设置模版
                View::assign(Request::param());
                //根据name取值
                if(Request::param('name')){
                    $fieldInfo = Db::name('field')
                        ->where('moduleid','=',Request::param('moduleid'))
                        ->where('field','=',Request::param('name'))
                        ->find();
                    $fieldInfo['setup'] = string2array($fieldInfo['setup']);
                }else{
                    $fieldInfo = null;
                }
                $view = [
                    'fieldInfo'  => $fieldInfo,
                ];
                View::assign($view);
                return View::fetch('fieldAddType');

            }else{
                $data = Request::post();
                $fieldName = $data['field'];
                $prefix = Config::get('database.prefix');
                $name = Db::name('module')
                    ->where('id','=',$data['moduleid'])
                    ->value('name');
                $tablename=$prefix.$name;
                $Fields=Db::getTableFields($tablename);
                if(in_array($fieldName,$Fields)){
                    error('字段名已经存在！');
                }
                if(empty($data['type']))
                    error('请选择字段类型！');
                if(empty($data['field']))
                    error('请填写字段名！');
                if(empty($data['name']))
                    error('请填写别名！');
                $addfieldsql =$this->get_tablesql($data,'add');
                if(isset($data['setup'])) {
                    $data['setup'] = array2string($data['setup']);
                }
                $data['status'] =1;
                $model = Db::name('field');
                if ($model->insert($data) !==false) {
                    if(is_array($addfieldsql)){
                        foreach($addfieldsql as $sql){
                            $model->execute($sql);
                        }
                    }else{
                        $model->execute($addfieldsql);
                    }
                    success('添加成功！', url('field',array('id'=>input('post.moduleid'))));
                } else {
                    error('添加失败！');
                }
            }
        }
    }

    //编辑字段
    public function fieldEdit(){
        $model = Db::name('field');
        $id = Request::param('id');
        $fieldInfo = $model
            ->where('id','=',$id)
            ->find();
        if($fieldInfo['setup'])
            $fieldInfo['setup']=string2array($fieldInfo['setup']);

        $view = [
            'moduleid'  => Request::param('moduleid'),
            'info'      => $fieldInfo
        ];
        View::assign($view);
        return View::fetch('field_add');
    }

    //编辑字段保存
    public function fieldEditPost(){
        if(Request::isPost()){
            $data = Request::except(['oldfield']);
            $oldfield = Request::param('oldfield');
            $fieldName = $data['field'];
            $name = Db::name('module')
                ->where('id' , '=' ,$data['moduleid'])
                ->value('name');
            $prefix = Config::get('database.prefix');
            if($this->_iset_field($prefix.$name,$fieldName) && $oldfield!=$fieldName){
                error('字段名重复！');
            }

            $editfieldsql =$this->get_tablesql(Request::post(),'edit');

            if(array_key_exists ("setup",$data)&&$data['setup']){
                $data['setup']=array2string($data['setup']);
            }
            $model = Db::name('field');

            if (false !== $model->update($data)) {
                if(is_array($editfieldsql)){
                    foreach($editfieldsql as $sql){
                        $model->execute($sql);
                    }
                }else{
                    $model->execute($editfieldsql);
                }
                success('修改成功！',url('field',array('id'=>Request::post('moduleid'))));
            } else {
                error('修改失败！');
            }
        }
    }

    //删除字段
    public function fieldDel() {
        $id = Request::param('id');
        $r  = Db::name('field')->find($id);
        Db::name('field')->delete($id);

        $moduleid = $r['moduleid'];
        $field    = $r['field'];

        $prefix = Config::get('database.prefix');
        $name   = Db::name('module')
            ->where('id','=',$moduleid)
            ->value('name');
        $tablename = $prefix.$name;

        Db::name('field')
            ->execute("ALTER TABLE `$tablename` DROP `$field`");
        return json(['error'=>0,'msg'=>'删除成功！']);
    }

    protected function get_tablesql($info,$do){
        $comment = $info['name'];
        $fieldtype = $info['type'];

        if(isset($info['setup']['fieldtype'])){
            $fieldtype=$info['setup']['fieldtype'];
        }
        $moduleid = $info['moduleid'];
        $default = '';
        if(isset($info['setup']['default'])){
            $default=$info['setup']['default'];
        }
        $field = $info['field'];
        $prefix = Config::get('database.prefix');
        $name = Db::name('module')
            ->where('id',$moduleid)
            ->value('name');
        $tablename=$prefix.$name;
        $maxlength = intval($info['maxlength']);
        $minlength = intval($info['minlength']);
        $numbertype = '';
        if(isset($info['setup']['numbertype'])){
            $numbertype=$info['setup']['numbertype'];
        }
        if($do=='add'){
            $do = ' ADD ';
        }else{
            $oldfield = $info['oldfield'];
            $do =  " CHANGE `".$oldfield."` ";
        }
        switch($fieldtype) {
            case 'varchar':
                if(!$maxlength){$maxlength = 255;}
                $maxlength = min($maxlength, 255);
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";
                break;
            case 'title':
                if(!$maxlength){$maxlength = 255;}
                $maxlength = min($maxlength, 255);
                $sql[] = "ALTER TABLE `$tablename` $do `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default' COMMENT '$comment'";

                break;
            case 'catid':
                $sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '$comment'";
                break;

            case 'number':
                $decimaldigits = $info['setup']['decimaldigits'];
                $default = $decimaldigits == 0 ? intval($default) : floatval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` ".($decimaldigits == 0 ? 'INT' : 'decimal( 10,'.$decimaldigits.' )')." ".($numbertype ==1 ? 'UNSIGNED' : '')."  NOT NULL DEFAULT '$default'  COMMENT '$comment'";
                break;

            case 'tinyint':
                if(!$maxlength) $maxlength = 3;
                $maxlength = min($maxlength,3);
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` TINYINT( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default'  COMMENT '$comment'";
                break;


            case 'smallint':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                break;

            case 'int':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` INT ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                break;

            case 'mediumint':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` INT ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default' COMMENT '$comment'";
                break;

            case 'mediumtext':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL COMMENT '$comment'";
                break;

            case 'text':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL COMMENT '$comment'";
                break;

            //case 'typeid':
            //$sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0'";
            //break;

            case 'datetime':
                $sql = "ALTER TABLE `$tablename` $do `$field` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '$comment'";
                break;

            case 'editor':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL COMMENT '$comment'";
                break;

            case 'image':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT '' COMMENT '$comment'";
                break;

            case 'images':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL COMMENT '$comment'";
                break;

            case 'file':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT '' COMMENT '$comment'";
                break;

            case 'files':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL COMMENT '$comment'";
                break;
            case 'template':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT '' COMMENT '$comment'";
                break;
            case 'linkage':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT '' COMMENT '$comment'";
                break;
        }
        return $sql;
    }
    protected function _iset_field($table,$field){
        $fields = Db::getTableFields($table);
        return array_search($field,$fields);
    }


}
