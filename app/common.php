<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 获取列表链接地址
function getUrl($v){
    //判断是否直接跳转
    if (trim($v['url']) == '') {
        //判断是否跳转到下级栏目
        if ($v['is_next'] == 1) {
            $is_next = \think\facade\Db::name('cate')
                ->where('parentid',$v['id'])
                ->order('sort asc,id desc')
                ->find();
            if ($is_next) {
                $v['url'] = getUrl($is_next);
            }
        } else {
            $moduleurl = \think\facade\Db::name('module')
                ->where('id',$v['moduleid'])
                ->value('name');
            if ($v['catdir']) {
                $v['url'] = url($v['catdir'].'/index', ['cate'=>$v['id']]);
            } else {
                $v['url'] = url($moduleurl.'/index', ['cate'=>$v['id']]);
            }
        }
    }
    return $v['url'];
}

// 获取详情URL
function getShowUrl($v){
    if ($v) {
        //$home_rote[''.$v['catdir'].'-:cat/:id'] = 'home/'.$v['catdir'].'/index';
        $cate = \think\facade\Db::name('cate')
            ->field('id,catdir,moduleid')
            ->where('id',$v['cate_id'])
            ->find();
        $moduleurl = \think\facade\Db::name('module')
            ->where('id',$cate['moduleid'])
            ->value('name');
        if ($cate['catdir']) {
            $url = url($cate['catdir'].'/info', ['cate'=>$cate['id'],'id'=>$v['id']]);
        } else {
            $url = url($moduleurl.'/info', ['cate'=>$cate['id'],'id'=>$v['id']] );
        }
    }
    return $url;
}

function changeFields($list, $moduleid){
    $info = [];
    foreach ($list as $k => $v){
        $url = getShowUrl($v);
        $list[$k] = changeField($v,$moduleid);
        $info[$k] = $list[$k];//定义中间变量防止报错
        $info[$k]['url'] = $url;
    }
    return $info;
}

function changefield($info, $moduleid){
    $fields = \think\facade\Db::name('field')
        ->where('moduleid','=',$moduleid)
        ->select();
    foreach ($fields as $k => $v) {
        $field = $v['field'];
        if ($info[$field]) {
            switch ($v['type']){
                case 'textarea'://多行文本
                    break;
                case 'editor'://编辑器
                    $info[$field] = $info[$field];
                    break;
                case 'select'://下拉列表
                    break;
                case 'radio'://单选按钮
                    break;
                case 'checkbox'://复选框
                    $info[$field] = explode(',',$info[$field]);
                    break;
                case 'images'://多张图片
                    $info[$field] = json_decode($info[$field], true);
                    break;
                default:
            }
        }

    }
    return $info;
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $arr = \think\facade\Db::name('config')
        ->where('inc_type','smtp')
        ->select();
    $config = convert_arr_kv($arr,'name','value');

    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];

    if ($mail->Port == '465') {
        $mail->SMTPSecure = 'ssl';
    }// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //发送邮箱
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user'],$config['email_id']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if (is_array($to)) {
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    } else {
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    return $mail->send();
}

/**
 * 验证输入的邮件地址是否合法
 * @param $user_email 邮箱
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) {
        if (preg_match($chars, $user_email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 验证输入的手机号码是否合法
 * @param $mobile_phone 手机号
 * @return bool
 */
function is_mobile_phone($mobile_phone)
{
    $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
    if (preg_match($chars, $mobile_phone)) {
        return true;
    }
    return false;
}

/**
 * 过滤数组元素前后空格 (支持多维数组)
 * @param $array 要过滤的数组
 * @return array|string
 */
function trim_array_element($array){
    if (!is_array($array))
        return trim($array);
    return array_map('trim_array_element',$array);
}

/**
 * 将数据库中查出的列表以指定的 值作为数组的键名，并以另一个值作为键值
 * @param $arr
 * @param $key_name
 * @return array
 */
function convert_arr_kv($arr,$key_name,$value){
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$val[$key_name]] = $val[$value];
    }
    return $arr2;
}

function string2array($info) {
    if ($info == '') return array();
    eval("\$r = $info;");
    return $r;
}

function array2string($info) {
    //删除空格，某些情况下字段的设置会出现换行和空格的情况
    if (is_array($info)) {
        if (array_key_exists('options', $info)) {
            $info['options'] = trim($info['options']);
        }
    }
    if ($info == '') return '';
    if (!is_array($info)){
        //删除反斜杠
        $string = stripslashes($info);
    }
    foreach ($info as $key => $val) {
        $string[$key] = stripslashes($val);
    }
    $setup = var_export($string, TRUE);
    return $setup;
}

/**
 * 文本域中换行标签输出
 * @param $info 内容
 * @return mixed
 */
function textareaBr($info) {
    $info = str_replace("\r\n","<br />",$info);
    return $info;
}

/**
 * 无限分类-栏目
 * @param $cate
 * @param string $lefthtml
 * @param int $pid
 * @param int $lvl
 * @return array
 */
function tree_cate($cate , $lefthtml = '|— ' , $pid=0 , $lvl=0 ){
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parentid'] == $pid) {
            $v['lvl'] = $lvl + 1;
            $v['lefthtml'] = str_repeat($lefthtml,$lvl);
            $v['lcatname'] = $v['lefthtml'].$v['catname'];
            $arr[] = $v;
            $arr = array_merge($arr, tree_cate($cate, $lefthtml, $v['id'], $lvl+1));
        }
    }
    return $arr;
}

/**
 * 组合多维数组
 * @param $cate
 * @param string $name
 * @param int $pid
 * @return array
 */
function unlimitedForLayer($cate, $name = 'sub', $pid = 0){
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parentid'] == $pid) {
            $v[$name] = unlimitedForLayer($cate, $name, $v['id']);
            $v['url'] = getUrl($v);
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * 传递一个父级分类ID返回当前子分类
 * @param $cate
 * @param $pid
 * @return array
 */
function getChildsOn($cate, $pid){
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parentid'] == $pid) {
            $v['sub'] = getChilds($cate, $v['id']);
            $v['url'] = getUrl($v);
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * 传递一个父级分类ID返回所有子分类
 * @param $cate
 * @param $pid
 * @return array
 */
function getChilds($cate, $pid){
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parentid'] == $pid) {
            $v['url'] = getUrl($v);
            $arr[] = $v;
            $arr = array_merge($arr, getChilds($cate, $v['id']));
        }
    }
    return $arr;
}

/**
 * 传递一个父级分类ID返回所有子分类ID
 * @param $cate
 * @param $pid
 * @return array
 */
function getChildsId($cate, $pid){
    $arr = [];
    foreach ($cate as $v) {
        if ($v['parentid'] == $pid) {
            $arr[] = $v;
            $arr = array_merge($arr, getChildsId($cate, $v['id']));
        }
    }
    return $arr;
}

/**
 * 格式化分类数组为字符串
 * @param $ids
 * @param string $pid
 * @return string
 */
function getChildsIdStr($ids, $pid = ''){
    $result='';
    foreach ($ids as $k => $v) {
        $result .= $v['id'].',';
    }
    if ($pid) {
        $result = $pid.','.$result;
    }
    $result = rtrim($result,',');
    return $result;
}

/**
 * 传递一个子分类ID返回所有的父级分类
 * @param $cate
 * @param $id
 * @return array
 */
function getParents ($cate, $id) {
    $arr = array();
    foreach ($cate as $v) {
        if ($v['id'] == $id) {
            $arr[] = $v;
            $arr = array_merge(getParents($cate, $v['parentid']), $arr);
        }
    }
    return $arr;
}

/**
 * 获取文件目录列表
 * @param string $pathname 路径
 * @param integer $fileFlag 文件列表 0所有文件列表,1只读文件夹,2是只读文件(不包含文件夹)
 * @param string $pathname 路径
 * @return array
 */
function get_file_folder_List($pathname,$fileFlag = 0, $pattern='*') {
    $fileArray = array();
    $pathname = rtrim($pathname,'/') . '/';
    $list   =   glob($pathname.$pattern);
    foreach ($list  as $i => $file) {
        switch ($fileFlag) {
            case 0:
                $fileArray[]=basename($file);
                break;
            case 1:
                if (is_dir($file)) {
                    $fileArray[]=basename($file);
                }
                break;

            case 2:
                if (is_file($file)) {
                    $fileArray[]=basename($file);
                }
                break;

            default:
                break;
        }
    }

    if(empty($fileArray)) $fileArray = NULL;
    return $fileArray;
}

/**
 * 获取所有模版
 * @return mixed
 */
function getTemplate(){
    //查找系统设置
    $system = \think\facade\Db::name('system')->select();
    $systemArr = [];
    foreach ($system as $k => $v) {
        $systemArr[$v['field']] = $v['value'];
    }

    $path = './template/'.$systemArr['template'].'/index/'.$systemArr['html'].'/';
    $tpl['list'] = get_file_folder_List($path , 2, '*_list*');
    $tpl['show'] = get_file_folder_List($path , 2, '*_show*');
    return $tpl;
}

/**
 * 格式化系统设置表中的setup数据
 * @param $system
 * @return mixed
 */
function sysgem_setup($system){
    foreach ($system as $k => $v) {
        if ($system[$k]['setup']) {
            $system[$k]['setup'] = string2array($v['setup']);
            if (array_key_exists('options',$system[$k]['setup'])) {
                $system[$k]['setup']['options'] = explode("\n",$system[$k]['setup']['options']);
                foreach ($system[$k]['setup']['options'] as $kk => $vv) {
                    $system[$k]['setup']['options'][$kk] = trim_array_element(explode("|",$system[$k]['setup']['options'][$kk]));

                }
            }
        }
    }
    return $system;
}

/**
 * 传递一个父级分类ID返回所有子分类
 * @param $cate
 * @param $pid
 * @return array
 */
function getChildsRule($rules, $pid){
    $arr = [];
    foreach ($rules as $v) {
        if ($v['pid'] == $pid) {
            $arr[] = $v;
            $arr = array_merge($arr, getChildsRule($rules, $v['id']));
        }
    }
    return $arr;
}