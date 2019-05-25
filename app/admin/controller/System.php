<?php
/**
 * +----------------------------------------------------------------------
 * | 系统设置控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/06
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

use app\common\model\SystemGroup;
use app\common\model\System as M;

use think\facade\App;
use think\facade\Request;
use think\facade\View;

class System extends Base
{
    protected $validate = 'System';

    //系统设置字段列表
    public function index(){
        //全局查询条件
        $where = [];
        $keyword = Request::param('keyword');
        if (!empty($keyword)) {
            $where[] = ['name|field', 'like', '%'.$keyword.'%'];
        }
        $groupId  = Request::param('group_id');
        if (!empty($groupId)) {
            $where[] = ['group_id', '=', $groupId];
        }
        $dateran = Request::param('dateran');
        if (!empty($dateran)) {
            $getDateran = get_dateran($dateran);
            $where[] = ['create_time', 'between', $getDateran];
        }

        //获取列表
        $list = M::getList($where, $this->pageSize);

        //获取系统设置分组列表
        $systemGroup = SystemGroup::select();

        $view = [
            'keyword'    => $keyword,
            'groupId'    => $groupId,
            'dateran'    => $dateran,
            'systemGroup'=> $systemGroup,
            'pageSize'   => page_size($this->pageSize, $list->total()),
            'page'       => $list->render(),
            'list'       => $list,
            'empty'      => empty_list(12),
        ];
        View::assign($view);
        return View::fetch();
    }

    // 系统设置字段添加
    public function add(){
        if (Request::param('isajax')) {
            //调用字段设置模版
            View::assign(Request::param());
            //根据name取值
            if (Request::param('name')) {
                $fieldInfo = M::where('field','=',Request::param('name'))
                    ->find();
                $fieldInfo['setup'] = string2array($fieldInfo['setup']);
            } else {
                $fieldInfo = null;
            }
            $view = [
                'fieldInfo'  => $fieldInfo,
            ];
            View::assign($view);
            return View::fetch('fieldAddType');
        }
        //分组获取
        $systemGroup = SystemGroup::where('status',1)->select();
        //字段类型获取
        $fildType = M::getType();
        if (!count($systemGroup)) {
            $this->error('请先添加系统设置分组');
        }
        $view = [
            'systemGroup' => $systemGroup,
            'fildType'    => $fildType,
            'info'        => null
        ];
        View::assign($view);
        return View::fetch();
    }

    // 系统设置字段添加保存
    public function addPost(){
        $data = Request::except(['file'], 'post');
        $result = $this->validate($data, $this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        } else {
            //特殊处理配置信息
            if (isset($data['setup'])) {
                $data['setup'] = array2string($data['setup']);
            }
            if (M::create($data) !==false) {
                $this->success('添加成功','index');
            } else {
                $this->error('添加失败','index');
            }
        }
    }

    // 系统设置字段修改
    public function edit(){
        $id = Request::param('id');
        $info = M::edit($id);
        //分组获取
        $systemGroup = SystemGroup::select();
        //字段类型获取
        $fildType = M::getType();
        $view =[
            'systemGroup' => $systemGroup,
            'fildType'    => $fildType,
            'info'        => $info,
        ];
        View::assign($view);
        return View::fetch('add');
    }

    // 系统设置字段修改保存
    public function editPost(){
        $data = Request::except(['file'], 'post');
        $result = $this->validate($data,$this->validate);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->error($result);
        } else {
            //特殊处理配置信息
            if (isset($data['setup'])) {
                $data['setup'] = array2string($data['setup']);
            }
            if (M::update($data) !==false) {
                $this->success('修改成功', 'index');
            } else {
                $this->error('修改失败', 'index');
            }
        }
    }

    // 系统设置字段删除
    public function del(){
        if (Request::isPost()) {
            $id = Request::param('id');
            return M::del($id);
        }
    }

    // 系统设置字段批量删除
    public function selectDel(){
        if (Request::isPost()) {
            $id = Request::param('id');
            return M::selectDel($id);
        }
    }

    // 系统设置字段排序
    public function sort(){
        if (Request::isPost()) {
            $data = Request::post();
            return M::sort($data);
        }
    }

    // 系统设置字段状态
    public function state(){
        if (Request::isPost()) {
            $id = Request::param('id');
            return M::state($id);
        }
    }

    // 系统设置查看
    public function system(){
        //查找所有模版
        $dir = App::getRootPath() . 'public' .DIRECTORY_SEPARATOR. 'template';
        $template = get_dir($dir);
        //查找所有数据
        $system = M::getListField()->toArray();
        //格式化设置字段
        $system = sysgem_setup($system);
        //将数据重新分组
        $system = array_group($system,'group_id');

        //查找所有分组名称
        $systemGroup = SystemGroup::where(['status'=>1])
            ->select();
        $view = [
            'template'    => $template,
            'system'      => $system,
            'systemGroup' => $systemGroup,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 系统设置保存
    public function systemPost(){
        if (Request::isPost()) {
            $data = Request::except(['file'], 'post');

            //查找所有显示的数据（隐藏的数据无法修改，不再显示）
            $list = M::where([
                'status' => 1,
            ])->select();

            //循环判断数据合法性
            foreach ($list as $k => $v) {
                $systemGroupStatus = SystemGroup::where(['id'=>$v['group_id']])
                    ->field('status')
                    ->find();
                if ($systemGroupStatus['status'] == 0) {
                    continue;// 当分组为隐藏状态时，不再进行修改
                }
                //判断是否必填
                if ($v['required']==1) {
                    if (array_key_exists($v['field'],$data)) {
                        if (!$data[$v['field']]) {
                            $this->error($v['name'].'为必填项!');
                        }
                    } else {
                        $this->error($v['name'].'为必填项!');
                    }
                }
                //数据处理
                switch ($v['type']){
                    case 'checkbox'://复选框
                        if (array_key_exists($v['field'],$data)) {
                            //dump($data[$v['field']]);exit;
                            $data[$v['field']] = is_array($data[$v['field']]) ? implode(",", $data[$v['field']]) : $data[$v['field']];
                        }
                        break;
                    case 'datetime'://时间
                        $data[$v['field']] = strtotime($data[$v['field']]);
                        break;
                }
            }

            foreach ($data as $k => $v) {
                //查找并进行修改
                $info = \app\common\model\System::where(['field'=>$k])->find();
                if ($info) {
                    $info -> value = $v;
                    $info -> save();
                }
            }

            $this->success('修改成功', 'system');
        }
    }

    // 邮箱配置
    public function email(){
        $smtp = \app\common\model\Config::where('inc_type','=','smtp')
            ->select();
        $info = convert_arr_kv($smtp,'name','value');
        $view = [
            'info'=>$info,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 邮箱配置保存
    public function emailPost(){
        if (Request::isPost()) {
            $data = Request::post();
            foreach ($data as $k => $v){
                $result =  \app\common\model\Config::where([['name','=',$k],['inc_type','=','smtp']])->find();
                $result -> value = $v;
                $result->save();
            }
            $this->success('修改成功', 'email');
        }
    }

    // 测试邮件发送
    public function trySend(){
        $sender = Request::param('email');
        //检查是否邮箱格式
        if (!is_email($sender)) {
            return json(['error' => 1, 'msg' => '测试邮箱码格式有误']);
        }
        $data = \app\common\model\Config::where('inc_type','smtp')
            ->select();
        $config = convert_arr_kv($data,'name','value');
        $content = $config['test_eamil_info'];
        //所有项目必须填写
        if (empty($config['smtp_server']) || empty($config['smtp_port']) || empty($config['smtp_user']) || empty($config['smtp_pwd'])) {
            return json(['error' => 1, 'msg' => '请完善邮件配置信息！']);
        }

        $send = send_email($sender, '测试邮件',$content);
        if ($send) {
            return ['error' => 0, 'msg' => '邮件发送成功！'];
        } else {
            return ['error' => 1, 'msg' => '邮件发送失败！'];
        }
    }

    // 短信配置
    public function sms(){
        $sms = \app\common\model\Config::where('inc_type','sms')->select();
        $info = convert_arr_kv($sms,'name','value');
        $view = [
            'info' => $info,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 短信配置保存
    public function smsPost(){
        if (Request::isPost()) {
            $data = Request::post();
            foreach ($data as $k => $v){
                \app\common\model\Config::where([
                    ['name','=',$k],['inc_type','=','sms']
                ])
                    ->update(['value'=>$v]);
            }
            $this->success('保存成功', 'sms');
        }
    }

    // 测试短信发送
    public function trySms(){
        $mobile = input('mobile');
        $data = \app\common\model\Config::where('inc_type','sms')->select();
        $config = convert_arr_kv($data,'name','value');

        //生成验证码
        $code = rand ( 1000, 9999 );
        //发送短信
        $sms = new \Sms($config);
        //短信验证码
        $status = $sms->send_verify($mobile, $code);
        if (!$status) {
            return json(['error' => 1, 'msg' => $sms->error]);
        } else {
            return json(['error' => 0, 'msg' => '短信发送成功！']);
        }
    }
}
