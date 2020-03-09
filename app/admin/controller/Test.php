<?php
/**
 * +----------------------------------------------------------------------
 * | 广告管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/04
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

use app\admin\validate\Users;
use app\common\builder\FormBuilder;
use app\common\builder\TableBuilder;
use app\common\model\AdType;
use app\common\model\UsersType;
use think\facade\Config;
use think\facade\Request;
use think\facade\View;

class Test extends Base
{

    public function list(){

        //获取用户组列表 ['1' => '【首页】顶部通栏', '2' => '【内页】顶部通栏']
        $userType = UsersType::select();
        $userTypes = [];
        foreach ($userType as $k => $v) {
            $userTypes[$v['id']] = $v['name'];
        }
       // halt($userTypes);

        // 可搜索的字段
        $search = [
            ['text', 'email', '邮箱', 'LIKE'],
            ['select', 'type_id', '用户名', '', '', $userTypes],
            ['daterange', 'create_time', '创建时间'],
        ];

        // 搜索
        if (Request::param('getList') == 1) {
            //全局查询条件
            $where = [];
            // 循环所有搜索字段，看是否有传递
            foreach ($search as $k => $v) {
                if (Request::param($v[1])){
                    // 判断字段类型
                    if (isset($v[3]) && !empty($v[3])) {
                        $option = $v[3];
                    } else {
                        $option = '=';
                    }
                    switch ($v[0]){
                        case 'text':
                            if (strtoupper($option) == 'LIKE') {
                                $where[] = [$v[1], $option, '%' . Request::param($v[1]) . '%'];
                            } else {
                                $where[] = [$v[1], $option, Request::param($v[1])];
                            }
                            break;
                        case 'select':
                            if (strtoupper($option) == 'LIKE') {
                                $where[] = [$v[1], $option, '%' . Request::param($v[1]) . '%'];
                            } else {
                                $where[] = [$v[1], $option, Request::param($v[1])];
                            }
                            break;
                        case 'daterange':
                            $getDateran = get_dateran(Request::param($v[1]));
                            $where[] = [$v[1], 'between', $getDateran];
                            break;
                    }
                }
            }

            $orderByColumn = Request::param('orderByColumn') ?? 'id';
            $isAsc = Request::param('isAsc') ?? 'desc';
            return \app\common\model\Users::getList($where, $this->pageSize, [$orderByColumn => $isAsc]);
        }

        //全局查询条件
        $where = [];
        $keyword = Request::param('keyword');
        if (!empty($keyword)) {
            $where[] = ['email|mobile', 'like', '%'.$keyword.'%'];
        }
        $typeId  = Request::param('type_id');
        if (!empty($typeId)) {
            $where[] = ['type_id', '=', $typeId];
        }
        $dateran = Request::param('dateran');
        if (!empty($dateran)) {
            $getDateran = get_dateran($dateran);
            $where[] = ['create_time', 'between', $getDateran];
        }

        $data_list = \app\common\model\Users::getList($where, $this->pageSize, ['id' => 'desc']);


        $btn_info = [
            'title' => '查看',
            'icon'  => 'fa fa-fw fa-info',
            'href'  => url('info', ['id' => '__id__','email' => '__email__'])
        ];

        return TableBuilder::getInstance()
            ->setPageTitle('<h1>自定义标题<small>小标题</small></h1><ol class="breadcrumb"><li><a href="/admin"><i class="fa fa-dashboard"></i> 首页</a></li></ol>')
            ->addColumns([ // 批量添加列
                ['id', 'ID', 'string', '', '', 'abc'],
                ['email', '邮箱账号', 'link', url('user', ['id' => '__id__','email' => '__email__']),'_blank','','false'],
                ['type_id', '会员组', 'select', '', $userTypes, '', 'true'],
                ['qq', 'QQ', 'image'],
                ['mobile', '电话'],
                ['create_time', '创建时间', ''],
                ['update_time', '修改时间', ''],
                ['status', '状态', 'yesno'],
                ['right_button', '操作','btn']
            ])
            ->addRightButtons(['edit' => ['title' => '编辑'], 'edit']) // 添加编辑和删除按钮，并重新定义编辑按钮的table属性
            //->setRowList($data_list) // 设置表格数据
            ->setDelUrl(url('Users/del'))
            ->addRightButton('info', $btn_info) // 添加额外按钮

            ->setSearch($search)



            ->addTopButtons(['add' => [
                'title'       => '增加',
                'icon'        => 'fa fa-lightbulb-o',
                'class'       => 'btn btn-danger',
                'href'        => 'http://www.siyucms.com',
                'target'      => '_blank',
                'onclick'     => ''
            ], 'edit', 'del'])


            /* ->addTopButton('default', [
                'title'       => '去看看',
                'icon'        => 'fa fa-lightbulb-o',
                'class'       => 'btn btn-danger',
                'href'        => 'http://www.siyucms.com',
                'target'      => '_blank',
                'onclick'     => ''
            ]) // 自定义按钮*/

            //->addTopButtons(['add' => ['title' => '增加'], 'del'])

            ->fetch();
    }

    public function index(){

        $str = '1 &nbsp;';
        $str = strip_tags(($str));
        echo $str;

        exit;

            return FormBuilder::getInstance()
                ->addText('title', '标题')
                ->addTextarea('summary', '概要')
                ->addEditor('content', '内容')
                ->setFormData(['title' => '我是标题', 'summary' => '我是概要', 'content' => '我是内容'])
                ->fetch();


        //单独设置
        $color = ['1' => '绿色', '2' => '红色', '3' => '黄色'];

        // 定义按钮属性
        $btn = [
            'icon' => 'fa fa-plus-circle',
            'class' => 'btn-success',
            'data-url' => 'http://siyucms.com'
        ];

        return FormBuilder::getInstance()
            ->setPageTitle('<h1>自定义标题<small>小标题</small></h1><ol class="breadcrumb"><li><a href="/admin"><i class="fa fa-dashboard"></i> 首页</a></li></ol>')
            ->setPageTips('<a class="btn btn-flat btn-primary m_10" href="'.url('index').'">显示全部</a>', 'danger', 'search')
            ->addColor('color', '请选择颜色', '', 'red', 'rgb')
            ->addDaterange('date', '日期范围', '', '', '', 'data-start-date=2017-05-05')
            /*->addHtml('<img src="https://www.baidu.com/img/bd_logo1.png">')
            ->addHidden('id', '123')
            ->addButton('test', '自定义', $btn)
            ->addEditor('content', '内容', '', '', '100')
            ->addFiles('pifc', '图片')
            ->addSelect2('33', '选择颜色', '', ['1' => '绿色', '2' => '红色', '3' => '黄色'], '1,2', 'multiple="multiple"', '', '请选择颜色')
            ->addPassword('psw', '密码')
            ->addNumber('num', '数量', '', '', '0','100')
            ->addTags('tags', 'TAG', '', ['php', 'net'])
            ->addCheckbox('city', '颜色', '', $color, '2,3')
            ->addText('price', '价格', '', '', ['<i class="fa fa-fw fa-yen"></i>', '.00'])
            ->addText('name', '姓名', '', '', ['<i class="fa fa-user"></i>'])
            ->addText('name', '字段别名', '提示信息', '123', [], '额外属性', 'asdf','321',true)
            ->addTextarea('remarks', '备注')
            ->addBtn('<button type="button" class="btn btn-flat btn-default">额外按钮1</button>')
            ->addBtn('<button type="button" class="btn btn-flat btn-default">额外按钮2</button>')
            ->setFormUrl(url('addSave'))
            ->addDatetime('create_t1ime', '发布时间' ,'提示信息' )*/
            ->addTime('create_time', '时间')
            ->submitConfirm()
            //->setExtraCss('<link rel="stylesheet" href="/static/plugins/AdminLTE/css/my.css">')*/
            ->fetch();

        // 通过item设置
        /*return FormBuilder::getInstance()
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->addFormItem('text', 'title', '标题', 'asdf', '', ['$','.00'], '', '', '33333', 1)
            ->fetch();*/

        //批量设置
        /* FormBuilder::getInstance()
            ->addFormItems([
                ['text', 'title', '标3题'],
                ['textarea', 'summary', '摘要'],
            ]);

        return FormBuilder::getInstance()
            ->addFormItems([
                ['text', 'title', '标题'],
                ['textarea', 'summary', '摘要'],
            ])
            ->fetch();*/

        //分组
        /*return FormBuilder::getInstance()
            ->setPageTips('这是页面提示信息', 'danger', 'search')
            ->setFormMethod('get')
            ->addGroup(
                [
                    '微信支付' =>[
                        ['text', 'wx_appid', 'APPID1', '请输入appid'],
                        ['text', 'wx_appkey', 'APPKEY', '请输入appkey']
                    ],
                    '支付宝支付' =>[
                        ['text', 'al_appid', 'APPID2', '请输入appid'],
                        ['text', 'al_appkey', 'APPKEY', '请输入appkey']
                    ]
                ]
            )->fetch();*/


        /*$result = FormBuilder::getInstance()
            ->addText('title', '标题', 'asdf', '', ['<span class="input-group-addon">$</span>','<span class="input-group-addon">.00</span>'], '', '', '33333', 1)
            ->addTextarea('title', '标题2')
            ->addText('title', '标题3')
            ->addText('title', '标题4')
            ->addText('title', '标题5')
            ->html();

        $view = [
            'result'  => $result,
        ];

        View::assign($view);
        return View::fetch();*/
    }

    /**
     * 测试所有项目
     */
    public function add(){

        //模拟表单取出的数据
        $data = [
            'title' => '我是单行文本的内容',
            'remarks' => '我是多行文本的内容',
            'color' => 'green',
            'colors' => 'red,green',
            'create_time' => '2019-08-02',
            'need_time' => '15:30:27'
        ];

        //数组(比如其他表取出的数据)
        $color = ['green' => '绿色', 'red' => '红色', 'yellow' => '黄色'];

        return FormBuilder::getInstance()
            ->addFormItems([
                ['text', 'title', '标题', '我是提示信息', '', '', '', '', '占位符', true],
                ['textarea', 'remarks', '备注', '提示信息', '', '', '','占位符', false],
                ['radio', 'color', '颜色', '', $color],
                ['checkbox', 'colors', '喜欢的颜色', '提示信息', $color, '', '', '', true],
                ['date', 'create_time', '添加日期']
            ])
            ->submitConfirm()
            ->setFormData($data)
            ->fetch();
    }

    // 根据文章模型批量补充字段到其他里边
    public function addColoumns(){
        $list = \app\common\model\Field::where('module_id', 19)->order('id asc')->select()->toArray();
        foreach ($list as $k => $v) {
            unset($list[$k]['id']);
            $list[$k]['module_id'] = 24;
        }
        $field = new \app\common\model\Field();
        $field->saveAll($list);
        halt($list);

    }

}
