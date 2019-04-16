<?php
/**
 * +----------------------------------------------------------------------
 * | 首页控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/12
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
namespace app\index\controller;

use app\common\model\System;
use think\captcha\facade\Captcha;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Index extends Base
{
    //首页
    public function index()
    {
        //后台开启手机端的时候自动跳转
        if($this->system['mobile']=='1'){
            if(Request::isMobile()){
                return redirect('mobile/index/index');
            }
        }

        $view = [
            'cate'        => null,
            'system'      => $this->system, //系统信息
            'public'      => $this->public, //公共目录
            'title'       => $this->system['title'], //seo信息
            'keywords'    => $this->system['key'],   //seo信息
            'description' => $this->system['des'],   //seo信息
        ];

        $template = $this->template.'index.html';
        View::assign($view);
        return View::fetch($template);
    }

    //留言表单提交
    public function add(){
        $result = ['error'=>'','msg'=>''];
        if(Request::isPost()){
            $data = Request::post();
            $data['create_time'] = time();
            $data['catid'] = $data['catId'];
            $data['status'] = 0;
            unset($data['catId']);

            //是否开启验证码
            if($this->system['message_code']){
                if( !captcha_check($data['message_code'] ))
                {
                    return json(['error' => '1', 'msg' => '验证码错误']);
                }else{
                    unset($data['message_code']);
                }
            }

            //查询当前提交的模型id
            $moduleId = Db::name('cate')
                ->where('id','=',Request::param('catid'))
                ->value('moduleid');

            //查询该模型所有必填字段
            $fields = Db::name('field')
                ->where('moduleid',$moduleId)
                ->where('required',1)
                ->field('field,name,errormsg')
                ->select();
            foreach($fields as $k=>$v){
                if(isset($data[$v['field']]) && empty($data[$v['field']]) ){
                    $result['error']  = '1';
                    $result['msg']  = $v['name'].'为必填项';
                }
            }

            if($result['error']  !== '1'){
                $tableName = Db::name('module')
                    ->where('id','=',$moduleId)
                    ->value('name');
                $id = Db::name($tableName)
                    ->insertGetId($data);
                if($id){
                    $result['error']  = '0';
                    $result['msg']  = '留言成功';
                    //邮件通知开始
                    if(System::where('id',1)->value('message_send_mail')){
                        //去除无用字段
                        unset($data['catid']);
                        unset($data['status']);
                        //默认收件人为系统设置中的邮件
                        $email = $this->system['email'];
                        $title = 'SIYUCMS提醒：您的网站有新的留言';
                        //拼接内容
                        $fields = Db::name('field')
                            ->where('moduleid',$this->moduleid)
                            ->field('field,name,type')
                            ->select();
                        $content = '';
                        foreach($fields as $k=>$v){
                            if(isset($data[$v['field']]) ){
                                if($v['type']=='datetime'){
                                    $data[$v['field']] = date("Y-m-d H:i",$data[$v['field']]);
                                }
                                $content .= '<br>'.$v['name'].' : '.$data[$v['field']];
                            }
                        }
                        $this->trySend($email,$title,$content);
                    }
                    //邮件通知结束
                    $this->success($result['msg']);
                }else{
                    $result['error']  = '1';
                    $result['msg']  .= '留言失败;';
                    $this->error($result['msg']);
                }
            }else{
                $this->error($result['msg']);
            }

        }
    }

    //验证码
    public function captcha(){
        return Captcha::create();
    }

    //邮件发送
    private function trySend($email,$title,$content){
        //检查是否邮箱格式
        if (!is_email($email)) {
            return ['error' => 1, 'msg' => '邮箱码格式有误'];
        }
        $send = send_email($email, $title,$content);
        if ($send) {
            return ['error' => 0, 'msg' => '邮件发送成功！'];
        } else {
            return ['error' => 1, 'msg' => '邮件发送失败！'];
        }
    }
}
