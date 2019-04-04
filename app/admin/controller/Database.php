<?php
namespace app\admin\controller;
use think\facade\Request;
use \tp5er\Backup;
class Database extends Base
{
    protected $db = '', $datadir;
    function initialize(){
        parent::initialize();
        $this->config=array(
            'path'     => './Data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );
        $this->db = new Backup($this->config);
    }

    //数据列表
    public function database(){

        $list = $this->db->dataList();
        $total = 0;
        foreach ($list as $k => $v) {
            $list[$k]['size'] = format_bytes($v['data_length']);
            $total += $v['data_length'];
        }
        $result = ['data'=>$list,'total'=>format_bytes($total),'tableNum'=>count($list)];
        $this->view->assign('result',$result);
        return $this->view->fetch();
    }

    //优化
    public function optimize() {
        $tables = Request::param('id');
        if (empty($tables)) {
            return ['error'=>1,'msg'=>'请选择要优化的表！'];
        }
        $tables = explode(',',$tables);
        if($this->db->optimize($tables)){
            return ['error'=>0,'msg'=>'数据表优化成功！'];
        }else{
            return ['error'=>1,'msg'=>'数据表优化出错请重试！'];
        }
    }

    //修复
    public function repair() {
        $tables = Request::param('id');
        if (empty($tables)) {
            return ['error'=>1,'msg'=>'请选择要修复的表！'];
        }
        $tables = explode(',',$tables);
        if($this->db->repair($tables)){
            return ['error'=>0,'msg'=>'数据表修复成功！'];
        }else{
            return ['error'=>1,'msg'=>'数据表修复出错请重试！'];
        }
    }

    //备份
    public function backup(){
        $tables = Request::param('id');
        if (!empty($tables)) {
            $tables = explode(',',$tables);
            foreach ($tables as $table) {
                $this->db->setFile()->backup($table, 0);
            }
            return ['error'=>0,'msg'=>'备份成功！'];
        } else {
            return ['error'=>1,'msg'=>'请选择要备份的表！'];
        }
    }

    //备份列表
    public function restore(){
        $list =  $this->db->fileList();
        $total = 0;
        foreach ($list as $k => $v) {
            $total += substr($v['size'],0,strlen($v['size'])-2);
            $list[$k]['size'] = format_bytes($v['size']);
        }
        $statistics=['total'=>format_bytes($total),'count'=>count($list)];
        $this->view->assign('statistics',$statistics);

        $this->view->assign('list',$list);
        $this->assign('empty', empty_list(4));
        return $this->view->fetch();
    }

    //执行还原数据库操作
    public function import($time) {
        $list  = $this->db->getFile('timeverif',$time);
        $this->db->setFile($list)->import(1);
        return ['error'=>0,'msg'=>'还原成功！'];
    }

    //下载
    public function downFile($time) {
        $this->db->downloadFile($time);
    }
    //删除sql文件
    public function delSqlFiles() {
        $time = input('time');
        if($this->db->delFile($time)){
            return ['error'=>0,'msg'=>"备份文件删除成功！"];
        }else{
            return ['error'=>1,'msg'=>"备份文件删除失败，请检查权限！"];
        }
    }
}