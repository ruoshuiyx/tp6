<?php
/**
 * +----------------------------------------------------------------------
 * | 配置信息控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/01/21
 *             '::::::::::::'
 *                .::::::::::
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

// 引入框架内置类
use think\facade\Request;
// 引入表格和表单构建器
use app\common\builder\FormBuilder;
// 引入阿里云SDK
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Config extends Base
{
    // 邮件配置
    public function email(){
        $smtp = \app\common\model\Config::where('inc_type','=','smtp')
            ->select();
        $info = convert_arr_kv($smtp,'name','value');

        return FormBuilder::getInstance()
            ->addText('smtp_server', '服务器')
            ->addText('smtp_port', 'SMTP端口')
            ->addText('email_id', '发件人')
            ->addText('smtp_user', '发件邮箱')
            ->addPassword('smtp_pwd', '身份验证码')
            ->addText('regis_smtp_enable', '标题')
            ->addText('test_eamil', '测试邮箱')
            ->addEditor('test_eamil_info', '测试邮件内容', '', '', '100')
            ->setFormData($info)
            ->setFormUrl(url('emailPost'))
            ->hideBtn('back')
            ->addBtn('<button type="button" id="test_email" class="btn btn-flat btn-info ">测试发送</button>')
            ->setExtraHtml($this->getEmailExtraHtml(), 'content_bottom')
            ->setPageTips('<div style="line-height: 32px;float: left">系统采用SMTP方式发送邮件</div>', 'success', 'search')
            ->hideShowAll()
            ->fetch();
    }

    // 邮件配置保存
    public function emailPost()
    {
        if (Request::isPost()) {
            $data = Request::post();
            foreach ($data as $k => $v) {
                $result = \app\common\model\Config::where([['name', '=', $k], ['inc_type', '=', 'smtp']])->find();
                if ($k == 'smtp_pwd') {
                    if (!empty($v)) {
                        $result->value = $v;
                    }
                } else {
                    $result->value = $v;
                }
                $result->save();
            }
            $this->success('修改成功', 'email');
        }
    }

    // 测试邮件发送
    public function emailSend(){
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

    // 获取邮件配置额外HTML
    private function getEmailExtraHtml()
    {
        $str = '<script type="text/javascript">
                $("#test_email").click(function () {
                    var url = "' . url('emailSend') . '";
                    var email = $("input[name=\'test_eamil\']").val();
                    $.modal.confirm(\'确定要发送吗？\', function () {
                        $.post(url,{email:email},function(result){
                            if(result.error == 0){
                                $.modal.alertSuccess(result.msg);
                            }else{
                                $.modal.alertError(result.msg);
                            }
                          },\'json\');
                    })

                })
            </script>
            ';
        return $str;
    }

    // ==========================================

    // 短信配置
    public function sms(){
        $smtp = \app\common\model\Config::where('inc_type','=','sms')
            ->select();
        $info = convert_arr_kv($smtp,'name','value');

        return FormBuilder::getInstance()
            ->addText('accessKeyId', 'AccessKey ID', '
                <a href="https://help.aliyun.com/document_detail/53045.html" target="_blank">【创建】</a>
                <a href="https://usercenter.console.aliyun.com/#/manage/ak" target="_blank">【查看】</a>')
            ->addText('accessKeySecret', '密钥secret')
            ->addText('signName', '签名名称', '
                <a href="https://help.aliyun.com/document_detail/108072.html" target="_blank">【签名简介】</a>
                <a href="https://dysms.console.aliyun.com/dysms.htm#/domestic/text/sign" target="_blank">【查看签名】</a>')
            ->addText('templateCode', '模版CODE', '
                <a href="https://dysms.console.aliyun.com/dysms.htm#/domestic/text/template" target="_blank">【查看模版】</a>')
            ->addText('test_mobile', '测试手机')
            ->setFormData($info)
            ->setFormUrl(url('smsPost'))
            ->hideBtn('back')
            ->addBtn('<button type="button" id="test_sms" class="btn btn-flat btn-info ">测试发送</button>')
            ->setExtraHtml($this->getSmsExtraHtml(), 'content_bottom')
            ->setPageTips('<div style="line-height: 32px;float: left">系统采用阿里云短信服务发送短信 <a class="btn btn-flat btn-primary m-r-10" href="https://help.aliyun.com/document_detail/101346.html" target="_blank">查看错误码</a><a class="btn btn-flat btn-primary" href="https://help.aliyun.com/document_detail/59210.html" target="_blank">使用指引</a></div>', 'success', 'search')
            ->hideShowAll()
            ->fetch();
    }

    // 短信配置保存
    public function smsPost()
    {
        if (Request::isPost()) {
            $data = Request::post();
            foreach ($data as $k => $v) {
                \app\common\model\Config::where([
                    ['name', '=', $k], ['inc_type', '=', 'sms']
                ])
                    ->update(['value' => $v]);
            }
            $this->success('保存成功', 'sms');
        }
    }

    // 测试短信发送
    public function smsSend()
    {
        $data = \app\common\model\Config::where('inc_type', 'sms')->select();
        $config = convert_arr_kv($data, 'name', 'value');

        // 生成验证码
        $code = json_encode(['code' => rand(1000, 9999)]);

        // 新版发送
        AlibabaCloud::accessKeyClient($config['accessKeyId'], $config['accessKeySecret'])
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId'      => "cn-hangzhou",
                        'PhoneNumbers'  => $config['test_mobile'],
                        'SignName'      => $config['signName'],
                        'TemplateCode'  => $config['templateCode'],
                        'TemplateParam' => $code,
                    ],
                ])
                ->request();
            $resultArr = $result->toArray();
            if ($resultArr['Code'] == 'OK') {
                return json(['error' => 0, 'msg' => '发送成功']);
            } else {
                return json(['error' => 1, 'msg' => $resultArr['Message']]);
            }
        } catch (ClientException $e) {
            return json(['error' => 1, 'msg' => $e->getErrorMessage()]);
        } catch (ServerException $e) {
            return json(['error' => 1, 'msg' => $e->getErrorMessage()]);
        }
    }

    // 获取短信配置额外HTML
    private function getSmsExtraHtml(){
        $str = '<script type="text/javascript">
                $("#test_sms").click(function () {
                    var url = "' . url('smsSend') . '";
                    var mobile = $("input[name=\'mobile\']").val();
                    $.modal.confirm(\'确定要发送吗？如有修改请先提交保存！\', function () {
                        $.post(url,{mobile:mobile},function(result){
                        if(result.error == 0){
                            $.modal.alertSuccess(result.msg);
                        }else{
                            $.modal.alertError(result.msg);
                        }
                      },\'json\');
                    })
                })
            </script>
            ';
        return $str;
    }

}
