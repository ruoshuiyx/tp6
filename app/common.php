<?php
// 应用公共文件

// 获取列表链接地址
function getUrl($v)
{
    // 判断是否外部链接
    if (trim($v['url']) == '') {
        // 判断是否跳转到下级栏目
        if ($v['is_next'] == 1) {
            $is_next = \app\common\model\Cate::where('parent_id', $v['id'])
                ->order('sort asc,id desc')
                ->find();
            if ($is_next) {
                $v['url'] = getUrl($is_next);
            }
        } else {
            if ($v['cate_folder']) {
                $v['url'] = (string)\think\facade\Route::buildUrl($v['cate_folder'] . '/index')->domain('');
            } else {
                $moduleName = \app\common\model\Module::where('id', $v['module_id'])
                    ->value('model_name');
                $v['url'] = (string)\think\facade\Route::buildUrl($moduleName . '/index', ['cate' => $v['id']])->domain('');
            }
        }
    }
    return $v['url'];
}

// 获取详情URL
function getShowUrl($v)
{
    if ($v) {
        if (isset($v['url']) && !empty($v['url'])) {
            return $v['url'];
        }
        if (isset($v['cate_id']) && !empty($v['cate_id'])) {
            $cate = \app\common\model\Cate::field('id,cate_folder,module_id')
                ->where('id', $v['cate_id'])
                ->find();
            if ($cate['cate_folder']) {
                $url = (string)\think\facade\Route::buildUrl($cate['cate_folder'] . '/info', ['id' => $v['id']])->domain('');
            } else {
                $moduleName = \app\common\model\Module::where('id', $cate['module_id'])
                    ->value('model_name');
                $url        = (string)\think\facade\Route::buildUrl($moduleName . '/info', ['cate' => $cate['id'], 'id' => $v['id']])->domain('');
            }
        }
    }
    return $url ?? '';
}

/***
 * 处理数据（把列表中需要处理的字段转换成数组和对应的值,用于自定义标签文件中）
 * @param $list      列表
 * @param $moduleid  模型ID
 * @return array
 */
function changeFields($list, $moduleid)
{
    $info = [];
    foreach ($list as $k => $v) {
        $url = getShowUrl($v);
        $list[$k] = changeField($v, $moduleid);
        $info[$k] = $list[$k];//定义中间变量防止报错
        $info[$k]['url'] = $url;
    }
    return $info;
}

/***
 * 处理数据（用于详情页中数据转换）
 * @param $info      内容详情
 * @param $moduleid  模型ID
 * @return array
 */
function changefield($info, $moduleId)
{
    $fields = \app\common\model\Field::where('module_id', '=', $moduleId)
        ->select()
        ->toArray();
    foreach ($fields as $k => $v) {
        // select等需要获取数据的字段
        $options = \app\common\facade\MakeBuilder::getFieldOptions($v);
        if (isset($info[$v['field']])) {
            if ($v['type'] == 'text') {
                // 忽略
            } elseif ($v['type'] == 'textarea' || $v['type'] == 'password') {
                // 忽略
            } elseif ($v['type'] == 'radio' || $v['type'] == 'checkbox') {

                $info[$v['field'] . '_array'] = \app\common\facade\Cms::changeOptionsValue($options, $info[$v['field']], true);
                $info[$v['field']]            = \app\common\facade\Cms::changeOptionsValue($options, $info[$v['field']], false);
            } elseif ($v['type'] == 'select' || $v['type'] == 'select2') {
                if ($v['field'] !== 'cate_id') {
                    $info[$v['field'] . '_array'] = \app\common\facade\Cms::changeOptionsValue($options, $info[$v['field']], true);
                    $info[$v['field']]            = \app\common\facade\Cms::changeOptionsValue($options, $info[$v['field']], false);
                }
            } elseif ($v['type'] == 'number') {
            } elseif ($v['type'] == 'hidden') {
            } elseif ($v['type'] == 'date' || $v['type'] == 'time' || $v['type'] == 'datetime') {

            } elseif ($v['type'] == 'daterange') {
            } elseif ($v['type'] == 'tag') {
                if (!empty($info[$v['field']])) {
                    $tags = explode(',', $info[$v['field']]);
                    foreach ($tags as $k => $tag) {
                        $tags[$k] = [
                            'name' => $tag,
                            'url'  => \think\facade\Route::buildUrl('index/tag', ['module' => $moduleId, 't' => $tag])->__toString(),
                        ];
                    }
                    $info[$v['field']] = $tags;
                }
            } elseif ($v['type'] == 'images' || $v['type'] == 'files') {
                $info[$v['field']] = json_decode($info[$v['field']], true);
            } elseif ($v['type'] == 'editor') {

            } elseif ($v['type'] == 'color') {

            }
        }
    }
    return $info;
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject 邮件标题
 * @param string $content 邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to, $subject = '', $content = '')
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $arr = \think\facade\Db::name('config')
        ->where('inc_type', 'smtp')
        ->select();
    $config = convert_arr_kv($arr, 'name', 'value');

    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
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
    $mail->setFrom($config['smtp_user'], $config['email_id']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if (is_array($to)) {
        foreach ($to as $v) {
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
function trim_array_element($array)
{
    if (!is_array($array))
        return trim($array);
    return array_map('trim_array_element', $array);
}

/**
 * 将数据库中查出的列表以指定的 值作为数组的键名，并以另一个值作为键值
 * @param $arr
 * @param $key_name
 * @return array
 */
function convert_arr_kv($arr, $key_name, $value)
{
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$val[$key_name]] = $val[$value];
    }
    return $arr2;
}

function string2array($info)
{
    if ($info == '') return array();
    eval("\$r = $info;");
    return $r;
}

function array2string($info)
{
    //删除空格，某些情况下字段的设置会出现换行和空格的情况
    if (is_array($info)) {
        if (array_key_exists('options', $info)) {
            $info['options'] = trim($info['options']);
        }
    }
    if ($info == '') return '';
    if (!is_array($info)) {
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
function textareaBr($info)
{
    $info = str_replace("\r\n", "<br />", $info);
    $info = str_replace("\n", "<br />", $info);
    $info = str_replace("\r", "<br />", $info);
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
function tree_cate($cate, $leftHtml = '|— ', $pid = 0, $lvl = 0)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parent_id'] == $pid) {
            $v['lvl'] = $lvl + 1;
            $v['left_html'] = str_repeat($leftHtml, $lvl);
            $v['l_cate_name'] = $v['left_html'] . $v['cate_name'];
            $arr[] = $v;
            $arr = array_merge($arr, tree_cate($cate, $leftHtml, $v['id'], $lvl + 1));
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
function unlimitedForLayer($cate, $name = 'sub', $pid = 0)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parent_id'] == $pid) {
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
function getChildsOn($cate, $pid)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parent_id'] == $pid) {
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
function getChilds($cate, $pid)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['parent_id'] == $pid) {
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
function getChildsId($cate, $pid)
{
    $arr = [];
    foreach ($cate as $v) {
        if ($v['parent_id'] == $pid) {
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
function getChildsIdStr($ids, $pid = '')
{
    $result = '';
    foreach ($ids as $k => $v) {
        $result .= $v['id'] . ',';
    }
    if ($pid) {
        $result = $pid . ',' . $result;
    }
    $result = rtrim($result, ',');
    return $result;
}

/**
 * 传递一个子分类ID返回所有的父级分类[前台栏目]
 * @param $cate
 * @param $id
 * @return array
 */
function getParents($cate, $id)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['id'] == $id) {
            $arr[] = $v;
            $arr = array_merge(getParents($cate, $v['parent_id']), $arr);
        }
    }
    return $arr;
}

/**
 * 查找一个分类id的顶级分类id
 * @param $id
 * @return string
 */
function getTopId($id)
{
    $cate = \app\common\model\Cate::field('id,parent_id')->select()->toArray();
    $cateArr = [];
    if ($cate) {
        foreach ($cate as $k => $v) {
            $cateArr[$v['id']] = $v['parent_id'] ?: "0";
        }
    }
    while ($cateArr[$id]) {
        $id = $cateArr[$id];
    }
    return $id;
}

/**
 * 获取文件目录列表
 * @param string $pathname 路径
 * @param integer $fileFlag 文件列表 0所有文件列表,1只读文件夹,2是只读文件(不包含文件夹)
 * @param string $pathname 路径
 * @return array
 */
function get_file_folder_List($pathname, $fileFlag = 0, $pattern = '*')
{
    $fileArray = array();
    $pathname = rtrim($pathname, '/') . '/';
    $list = glob($pathname . $pattern);
    foreach ($list as $i => $file) {
        switch ($fileFlag) {
            case 0:
                $fileArray[] = basename($file);
                break;
            case 1:
                if (is_dir($file)) {
                    $fileArray[] = basename($file);
                }
                break;

            case 2:
                if (is_file($file)) {
                    $fileArray[] = basename($file);
                }
                break;

            default:
                break;
        }
    }

    if (empty($fileArray)) $fileArray = NULL;
    return $fileArray;
}

/**
 * 获取所有模版
 * @return mixed
 */
function getTemplate()
{
    // 查找所有系统设置表数据
    $system = \app\common\model\System::find(1);

    $path = './template/' . $system['template'] . '/index/' . $system['html'] . '/';
    $tpl['list'] = get_file_folder_List($path, 2, '*_list*');
    $tpl['show'] = get_file_folder_List($path, 2, '*_show*');
    return $tpl;
}

/**
 * 传递一个父级分类ID返回所有子分类
 * @param $cate
 * @param $pid
 * @return array
 */
function getChildsRule($rules, $pid)
{
    $arr = [];
    foreach ($rules as $v) {
        if ($v['pid'] == $pid) {
            $arr[] = $v;
            $arr = array_merge($arr, getChildsRule($rules, $v['id']));
        }
    }
    return $arr;
}

/***
 * 对象转数组
 * @param $object
 * @return array
 */
function object2array($object)
{
    $array = array();
    if (is_object($object)) {
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
    } else {
        $array = $object;
    }
    return $array;
}

/***
 * 获取当前栏目ID
 * @return mixed
 */
function getCateId()
{
    if (\think\facade\Request::has('cate')) {
        $result = (int)\think\facade\Request::param('cate');
    } else {
        $result = \app\common\model\Cate::where('cate_folder', '=', \think\facade\Request::controller())
            ->value('id');
    }
    return $result;
}

/**
 * 改变前台字典数据标签取得的数据
 * @param array $list
 * @return array
 */
function changeDict(array $list, string $field, string $all="全部")
{
    $get = \think\facade\Request::except(['page'], 'get');
    foreach ($list as $k => $v) {
        $url = $get;
        $url[$field] = $v['dict_value'];
        $list[$k]['url'] = (string)url(\think\facade\Request::controller() . '/' . \think\facade\Request::action(), $url);
        $param = \think\facade\Request::param('', '', 'htmlspecialchars');
        // 高亮显示
        $list[$k]['current'] = 0;
        if (!empty($param)) {
            foreach ($param as $kk => $vv) {
                if ($kk == $field) {
                    if (strpos($vv, '|') !== false) {
                        // 多选
                        $paramArr = explode("|", $vv);
                        foreach ($paramArr as $kkk => $vvv) {
                            if ($vvv == $v['dict_value']) {
                                $list[$k]['current'] = 1;
                                break;
                            }
                        }
                    } else {
                        // 单选
                        if ($vv == $v['dict_value']) {
                            $list[$k]['current'] = 1;
                        }
                    }
                }
            }
        }
        $list[$k]['param'] = $param;
    }

    // 添加[全部]字段在第一位
    if (isset($get[$field])) {
        unset($get[$field]);
    } else {
        $hover = 1;
    }
    $url = (string)url(\think\facade\Request::controller() . '/' . \think\facade\Request::action(), $get);

    $all = [
        'dict_label' => $all,
        'dict_value' => 0,
        'url'        => $url,
        'current'    => $hover ?? 0,
    ];
    array_unshift($list, $all);

    return $list;
}

/**
 * 改变模版标签中分类字段传递
 * @param string $field 需要分类查询的字段，通过,分割或|分割
 * @return string
 */
function getSearchField(string $field)
{
    $sql = '';
    if ($field) {
        $field = str_replace('|', ',', $field);
        $fieldArr = explode(',', $field);
        foreach ($fieldArr as $k => $v) {
            if (!empty($v)) {
                // 查询浏览器参数是否包含此参数
                if (\think\facade\Request::has($v, 'get')) {
                    $str = \think\facade\Request::get($v, '', 'htmlspecialchars');
                    if (strpos($str, '|') !== false) {
                        $sql = ' AND (';
                        $strArr = explode("|", $str);
                        foreach ($strArr as &$strAr) {
                            // 检测是否存在
                            $dictCount = \app\common\model\Dictionary::where('dict_value', $strAr)->count();
                            if ($dictCount) {
                                $sql .= ' FIND_IN_SET(\'' . $strAr . '\', ' . $v . ') OR';
                            }
                        }
                        // 去除最后一个or
                        $sql = substr($sql, 0, strlen($sql) - 2);
                        $sql .= ') ';
                    } else {
                        // 检测是否存在
                        $dictCount = \app\common\model\Dictionary::where('dict_value', $str)->count();
                        if ($dictCount) {
                            $sql .= ' AND FIND_IN_SET(\'' . $str . '\', ' . $v . ') ';
                        }
                    }
                }
            }
        }
    }
    return $sql;
}

/**
 * 无限分类-权限
 * @param $cate            栏目
 * @param string $lefthtml 分隔符
 * @param int $pid         父ID
 * @param int $lvl         层级
 * @return array
 */
function tree($cate , $lefthtml = '|— ' , $pid = 0 , $lvl = 0 ){
    $arr = array();
    foreach ($cate as $v){
        if ($v['pid'] == $pid) {
            $v['lvl']      = $lvl + 1;
            $v['lefthtml'] = str_repeat($lefthtml,$lvl);
            $v['ltitle']   = $v['lefthtml'].$v['title'];
            $arr[] = $v;
            $arr = array_merge($arr, tree($cate, $lefthtml, $v['id'], $lvl+1));
        }
    }
    return $arr;
}

/**
 * 无限分类-权限
 * @param $cate            栏目
 * @param string $lefthtml 分隔符
 * @param int $pid         父ID
 * @param int $lvl         层级
 * @return array
 */
function tree_three($cate , $lefthtml = '|— ' , $pid = 0 , $lvl = 0 ){
    $arr = array();
    foreach ($cate as $v){
        $keys = array_keys($v);
        if (end($v) == $pid) {
            $v['lvl']      = $lvl + 1;
            $v['lefthtml'] = str_repeat($lefthtml,$lvl);
            $v[$keys[1]] = $v['lefthtml'] . $v[$keys[1]];
            $arr[] = $v;
            $arr = array_merge($arr, tree_three($cate, $lefthtml, $v[$keys[0]], $lvl+1));
        }
    }
    return $arr;
}

/**
 * 标签云数据处理
 * @param $list
 * @return array
 */
function get_tagcloud($list, $moduleId, $limit = 10)
{
    $result = [];
    if ($list) {
        foreach ($list as $k => $v) {
            if ($v['tags']) {
                $arr = explode(',', $v['tags']);
                foreach ($arr as $ar) {
                    if (!empty($ar)) {
                        $result[] = $ar;
                    }
                }
            }
        }
    }
    // 截取
    if ($result) {
        $arr = array_count_values($result); // 统计数组中所有的值出现的次数
        arsort($arr); // 降序排序
        $arr = array_slice($arr, 0, $limit); // 截取前N条数据
        $result = [];
        foreach ($arr as $k => $v) {
            $result[] = [
                'name'  => $k,
                'count' => $v,
                'url'   => \think\facade\Route::buildUrl('index/tag', ['module' => $moduleId, 't' => $k])->__toString(),
            ];
        }
    }
    return $result;
}

/**
 * 获取前一页地址中设置的返回url
 * @return array
 */
function get_back_url()
{
    if (isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])) {
        $queryStr = explode('?', $_SERVER["HTTP_REFERER"]);
        if (count($queryStr) == 2) {
            parse_str($queryStr[1], $queryArr);
            if (isset($queryArr['back_url']) && !empty($queryArr['back_url'])) {
                $backUrl = explode("&", urldecode($queryArr['back_url']));
                foreach ($backUrl as $k => $v) {
                    $v = explode("=", $v);
                    if (isset($v[1]) && !empty($v[1])) {
                        $backArr[$v[0]] = $v[1];
                    }
                }
            }
        }
    }
    return $backArr ?? [];
}

/**
 * 转换moment格式为php可用格式[废弃]
 * @param $format
 * @return string
 */
function convert_moment_format_to_php(string $format = '')
{
    $replacements = [
        'DD'   => 'd',
        'ddd'  => 'D',
        'D'    => 'j',
        'dddd' => 'l',
        'E'    => 'N',
        'o'    => 'S',
        'e'    => 'w',
        'DDD'  => 'z',
        'W'    => 'W',
        'MMMM' => 'F',
        'MM'   => 'm',
        'MMM'  => 'M',
        'M'    => 'n',
        'YYYY' => 'Y',
        'YY'   => 'y',
        'a'    => 'a',
        'A'    => 'A',
        'h'    => 'g',
        'H'    => 'G',
        'hh'   => 'h',
        'HH'   => 'H',
        'mm'   => 'i',
        'ss'   => 's',
        'SSS'  => 'u',
        'zz'   => 'e',
        'X'    => 'U',
    ];
    $phpFormat = strtr($format, $replacements);
    return $phpFormat;
}

/**
 * 转换php格式为moment可用格式
 * @param $format
 * @return string
 */
function convert_php_to_moment_format(string $format = '')
{
    $replacements = [
        'd' => 'DD',
        'D' => 'ddd',
        'j' => 'D',
        'l' => 'dddd',
        'N' => 'E',
        'S' => 'o',
        'w' => 'e',
        'z' => 'DDD',
        'W' => 'W',
        'F' => 'MMMM',
        'm' => 'MM',
        'M' => 'MMM',
        'n' => 'M',
        't' => '', // no equivalent
        'L' => '', // no equivalent
        'o' => 'YYYY',
        'Y' => 'YYYY',
        'y' => 'YY',
        'a' => 'a',
        'A' => 'A',
        'B' => '', // no equivalent
        'g' => 'h',
        'G' => 'H',
        'h' => 'hh',
        'H' => 'HH',
        'i' => 'mm',
        's' => 'ss',
        'u' => 'SSS',
        'e' => 'zz', // deprecated since version 1.6.0 of moment.js
        'I' => '', // no equivalent
        'O' => '', // no equivalent
        'P' => '', // no equivalent
        'T' => '', // no equivalent
        'Z' => '', // no equivalent
        'c' => '', // no equivalent
        'r' => '', // no equivalent
        'U' => 'X',
    ];
    $momentFormat = strtr($format, $replacements);
    return $momentFormat;
}