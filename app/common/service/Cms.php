<?php
/**
 * +----------------------------------------------------------------------
 * | CMS前台相关业务处理
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | DATETIME: 2020/03/19
 *                 ..:::::::::::'
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

namespace app\common\service;

use app\common\facade\MakeBuilder;
use app\common\model\Cate;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;

class Cms
{
    /**
     * 获取栏目信息
     * @param string $cateId 栏目id
     * @return null|\think\Model
     */
    public function getCateInfo(string $cateId)
    {
        $cate = Cate::where('id', '=', $cateId)->find();
        // 设置顶级栏目，当顶级栏目不存在的时候顶级栏目为本身
        if ($cate) {
            $cate->topid  = getTopId($cateId);
            $cate->top_id = $cate->topid;
        }
        return $cate;
    }

    /**
     * 更新内容的点击数
     * @param string $id        内容id
     * @param string $tableName 表名称(含前缀)
     * @param string $file      点击数字段
     * @return bool
     */
    public function addHits(string $id, string $tableName, string $file = 'hits')
    {
        // 判断当前表是否存在要更新的字段
        if ($this->_iset_field(Config::get('database.connections.mysql.prefix') . $tableName, $file)) {
            Db::name($tableName)
                ->where('id', $id)
                ->inc($file)
                ->update();
            return true;
        }
        return false;
    }

    /**
     * 获取内容的详细信息
     * @param string $id
     * @param string $tableName
     */
    public function getInfo(string $id, string $tableName)
    {
        $modelName = $this->getModelName($tableName);
        if (empty($modelName)) {
            return false;
        }
        $model = '\app\common\model\\' . $modelName;
        $info  = $model::edit($id)->toArray();
        // 格式化详情页面的内容
        $info = $this->changeInfo($tableName, $info);
        return $info;
    }

    /**
     * 获取内容页面TDK
     * @param $info   内容
     * @param $cate   栏目
     * @param $system 系统
     * @return array
     */
    public function getInfoTdk($info, $cate, $system)
    {
        $result                = [];
        $result['title']       = $cate['cate_name'] ?: $cate['catname'];                           // 标题
        $result['keywords']    = isset($info['keywords']) && $info['keywords'] ? $info['keywords'] : ($cate['keywords'] ?: $system['key']);       // 关键词
        $result['description'] = isset($info['description']) && $info['description'] ? $info['description'] : ($cate['description'] ?: $system['des']); // 描述
        return $result;
    }

    /**
     * 获取内容页面模版
     * @param $info      内容
     * @param $cate      栏目
     * @param $tableName 表名称
     * @return mixed|string
     */
    public function getInfoView($info, $cate, string $tableName)
    {
        return isset($info['template']) && $info['template'] ? str_replace('.html', '', $info['template']) :
            ($cate['template_show'] ? str_replace('.html', '', $cate['template_show']) : $tableName . '_show');
    }

    /**
     * 获取列表页面TDK
     * @param $info   内容
     * @param $cate   栏目
     * @param $system 系统
     * @return array
     */
    public function getListTdk($cate, $system)
    {
        $result                = [];
        $result['title']       = $cate['title'] ?: $cate['cate_name'];   // 标题
        $result['keywords']    = $cate['keywords'] ?: $system['key'];    // 关键词
        $result['description'] = $cate['description'] ?: $system['des']; // 描述
        return $result;
    }

    /**
     * 获取列表页面模版
     * @param $info      内容
     * @param $cate      栏目
     * @param $tableName 表名称
     * @return mixed|string
     */
    public function getListView($cate, string $tableName)
    {
        return $cate['template_list'] ? str_replace('.html', '', $cate['template_list']) : $tableName . '_list';
    }

    /**
     * * 详情页检查用户阅读权限
     * @param array  $info  单篇文章信息，字段
     * @param string $field 需要验证权限的字段名称
     * @return array|bool
     */
    public function checkViewAuth(array $info, string $field = 'view_auth')
    {
        $callBack = urlencode(Request::url());
        if ($info) {
            if (isset($info[$field]) && !empty($info[$field])) {
                if (!Session::has('user')) {
                    return [
                        'code' => 1,
                        'msg'  => lang('need login'),
                        'url'  => url('user/login', ['callback' => $callBack])
                    ];
                } else {
                    $userType = 0;
                    foreach ($info[$field . '_array'] as $k => $v) {
                        if ($v['value'] == $info[$field]) {
                            $userType = $v['key'];
                            break;
                        }
                    }
                    if (Session::get('user.type_id') < $userType) {
                        return [
                            'code' => 2,
                            'msg'  => lang('user type not enough', [$info[$field]]),
                            'url'  => url('user/index')
                        ];
                    }
                }
            }
        }
        return true;
    }

    /**
     * 检测是否需要跳转mobile
     * @param int    $status  状态
     * @param string $appName 当前应用名称
     * @return bool|string
     */
    public function goToMobile(int $status = 0, string $appName = '')
    {
        if ($status == 1 && $appName == 'index' && Request::isMobile() === true) {
            // 判断mobile应用是否绑定了域名
            $domainBind = Config::get('app.domain_bind');
            if ($domainBind) {
                $domainBindKey = array_search('mobile', $domainBind);
                $mobileUrl     = Request::scheme() . '://' . $domainBindKey . '.' . Request::rootDomain() . '/';
            } else {
                $mobileUrl = 'mobile/index/index';
            }
            return $mobileUrl;
        }
        return false;
    }

    /**
     * 留言/投稿
     * @param $system
     * @return array
     */
    public function addMessage($system)
    {
        $result = ['error' => '', 'msg' => ''];
        if (Request::isPost()) {
            $data                = Request::post('', '', 'htmlspecialchars');
            $data['create_time'] = time();
            $data['status']      = 0;

            // 验证码判断
            if ($system['message_code'] == 1) {
                if (!captcha_check($data['message_code'])) {
                    $result['error'] = '1';
                    $result['msg']   = lang('captcha error');
                    return $result;
                } else {
                    unset($data['message_code']);
                }
            }

            // 查询模型id
            $moduleId = \app\common\model\Cate::where('id', Request::param('cate_id'))->value('module_id');

            // 查询该模型所有必填字段
            $fields = \app\common\model\Field::where('module_id', $moduleId)->select()->toArray();
            foreach ($fields as $k => $v) {
                // 必填项判断
                if (isset($data[$v['field']]) && $v['required'] == 1 && $data[$v['field']] === '') {
                    $result['error'] = '1';
                    $result['msg']   = lang('input required', [$v['name']]);
                }
                // 多选转换
                if ($v['type'] == 'checkbox') {
                    // 如填写则进行转换
                    if (isset($data[$v['field']])) {
                        $data[$v['field']] = implode(",", $data[$v['field']]);
                    }
                    // 多选必填项单独判断
                    if ($v['required'] == 1 && !isset($data[$v['field']])) {
                        $result['error'] = '1';
                        $result['msg']   = lang('need to check', [$v['name']]);
                    }
                }
            }

            if ($result['error'] !== '1') {
                $tableName = \app\common\model\Module::where('id', '=', $moduleId)->value('table_name');
                $id        = Db::name($tableName)->insertGetId($data);
                if ($id) {
                    $result['error'] = '0';
                    $result['msg']   = lang('message success');
                    // 邮件通知开始
                    if ($system['message_send_mail']) {
                        // 去除无用字段
                        unset($data['cate_id']);
                        unset($data['status']);
                        // 默认收件人为系统设置中的邮件
                        $email = $system['email'];
                        $title = lang('email title');
                        // 拼接内容
                        $fields  = \app\common\model\Field::where('module_id', $moduleId)->select();
                        $content = '';
                        foreach ($fields as $k => $v) {
                            if (isset($data[$v['field']])) {
                                if ($v['type'] == 'datetime') {
                                    $data[$v['field']] = date("Y-m-d H:i", $data[$v['field']]);
                                }
                                $content .= '<br>' . $v['name'] . ' : ' . $data[$v['field']];
                            }
                        }
                        $this->trySend($email, $title, $content);
                    }
                    // 邮件通知结束
                } else {
                    $result['error'] = '1';
                    $result['msg']   .= lang('message error');
                }
            }

        }
        return $result;
    }

    // ===================================================

    /**
     * 判断表中是否存在所选字段
     * @param $table 表全称
     * @param $field 字段名称
     * @return mixed
     */
    private function _iset_field($table, $field)
    {
        $fields = Db::getTableFields($table);
        if (array_search($field, $fields) === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 根据表名称查询模型名称
     * @param string $tableName [表名称，不含前缀]
     * @return mixed|string
     */
    private function getModelName(string $tableName)
    {
        $module = \app\common\model\Module::where('table_name', $tableName)->find();
        if ($module) {
            return $module->model_name;
        } else {
            // 查询不到模块信息，直接尝试转换[需遵循ThinkPHP命名规范]
            $tableName = explode('_', $tableName);
            $result    = '';
            foreach ($tableName as $k => $v) {
                $result .= ucfirst($v);
            }
            return $result;
        }
    }

    /**
     * 根据表名称查询模型ID
     * @param string $tableName [表名称，不含前缀]
     * @return mixed|string
     */
    private function getModelId(string $tableName)
    {
        $module = \app\common\model\Module::where('table_name', $tableName)->find();
        if ($module) {
            return $module->id;
        } else {
            return 0;
        }
    }

    /**
     * 格式化详情页面的内容
     * @param string $tableName
     * @param array  $info
     * @return array
     */
    private function changeInfo(string $tableName, array $info)
    {
        $fields = MakeBuilder::getFields($tableName);
        foreach ($fields as &$field) {
            // select等需要获取数据的字段
            $options = MakeBuilder::getFieldOptions($field);

            // 添加到返回数组中,注意form构建器和table构建器的不一致
            if ($field['type'] == 'text') {
                // 忽略
            } elseif ($field['type'] == 'textarea' || $field['type'] == 'password') {
                // 忽略
            } elseif ($field['type'] == 'radio' || $field['type'] == 'checkbox') {
                $info[$field['field'] . '_array'] = $this->changeOptionsValue($options, $info[$field['field']], true);
                $info[$field['field']]            = $this->changeOptionsValue($options, $info[$field['field']], false);
            } elseif ($field['type'] == 'select' || $field['type'] == 'select2') {
                if ($field['field'] !== 'cate_id') {
                    $info[$field['field'] . '_array'] = $this->changeOptionsValue($options, $info[$field['field']], true);
                    $info[$field['field']]            = $this->changeOptionsValue($options, $info[$field['field']], false);
                }
            } elseif ($field['type'] == 'number') {
            } elseif ($field['type'] == 'hidden') {
            } elseif ($field['type'] == 'date' || $field['type'] == 'time' || $field['type'] == 'datetime') {
            } elseif ($field['type'] == 'daterange') {
            } elseif ($field['type'] == 'tag') {
                if (!empty($info[$field['field']])) {
                    $tags = explode(',', $info[$field['field']]);
                    foreach ($tags as $k => $tag) {
                        $tags[$k] = [
                            'name' => $tag,
                            'url'  => \think\facade\Route::buildUrl('index/tag', ['module' => $this->getModelId($tableName), 't' => $tag])->__toString(),
                        ];
                    }
                    $info[$field['field']] = $tags;
                }
            } elseif ($field['type'] == 'images' || $field['type'] == 'files') {
                $info[$field['field']] = json_decode($info[$field['field']], true);
            } elseif ($field['type'] == 'editor') {
            } elseif ($field['type'] == 'color') {
            }
            // Button
        }
        return $info;
    }

    /**
     * 改变内容中有选项的值为可用数组
     * @param array  $options 选项
     * @param string $value   当前值
     * @param bool   $type    返回类型(true array/false string)，数组类型会返回全部数据
     * @return array/string
     */
    public function changeOptionsValue(array $options = [], string $value = '', bool $type = true)
    {
        $result = [];
        if ($type === false) {
            if (isset($value)) {
                $value = explode(',', $value);
                foreach ($value as $k => $v) {
                    if (isset($options[$v])) {
                        $result[] = $options[$v];
                    }
                }
            }
            $result = implode(" ", $result);
        } else {
            if (isset($value)) {
                $value = explode(',', $value);
            }
            foreach ($options as $k => $v) {
                $selected = false;
                if (is_array($value) && in_array($k, $value)) {
                    $selected = true;
                }
                $result[] = [
                    'key'      => $k,
                    'value'    => $v,
                    'selected' => $selected,
                ];
            }
        }
        return $result;
    }

    // 邮件发送
    private function trySend($email, $title, $content)
    {
        // 检查是否邮箱格式
        if (!is_email($email)) {
            return ['error' => 1, 'msg' => lang('email format error')];
        }
        $send = send_email($email, $title, $content);
        if ($send) {
            return ['error' => 0, 'msg' => lang('email send success')];
        } else {
            return ['error' => 1, 'msg' => lang('email send error')];
        }
    }

}
