<?php
/**
 * +----------------------------------------------------------------------
 * | 栏目管理控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/02/05
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
use app\common\facade\MakeBuilder;
use app\common\builder\FormBuilder;
use app\common\builder\TableBuilder;

class Cate extends Base
{
    // 验证器
    protected $validate = 'Cate';

    // 当前主表
    protected $tableName = 'cate';

    // 当前主模型
    protected $modelName = 'Cate';

    // 列表
    public function index()
    {
        // 获取主键
        $pk = MakeBuilder::getPrimarykey($this->tableName);
        // 获取列表数据
        $columns = MakeBuilder::getListColumns($this->tableName);
        // 获取搜索数据
        $search = MakeBuilder::getListSearch($this->tableName);
        // 获取当前模块信息
        $model  = '\app\common\model\\' . $this->modelName;
        $module = \app\common\model\Module::where('table_name', $this->tableName)->find();
        // 检测单页模式
        $isSingle = MakeBuilder::checkSingle($this->modelName);
        if ($isSingle) {
            return redirect($isSingle);
        }
        // 搜索
        if (Request::param('getList') == 1) {
            return $model::getList();
        }
        // 判断是否是弹出窗口，添加要打开的地址
        $layer_open = \think\facade\Config::get('builder.layer_open', false);
        if($layer_open){
            $add_url = '$.modal.open("添加", "'.url('Cate/add', ['_layer' => 1, 'parentId' => '__id__']).'");';
        } else {
            $add_url = '$.common.jump("'.url('Cate/add', ['parentId' => '__id__']).'");';
        }
        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                              // 设置主键
            ->addColumns($columns)                          // 添加列表字段数据
            ->setSearch($search)                            // 添加头部搜索
            ->addColumn('right_button', '操作', 'btn')      // 启用右侧操作列
            ->addRightButton('info', [                      // 添加额外按钮
                'title' => '添加',
                'icon'  => 'fa fa-plus',
                'class' => 'btn btn-success btn-xs',
                'href'  => '',
                'onclick' => $add_url
            ])
            ->addRightButtons($module->right_button)        // 设置右侧操作列
            ->addTopButtons($module->top_button)            // 设置顶部按钮组
            ->addTopButton('default', [
                'title'   => '展开/折叠',
                'icon'    => 'fas fa-exchange-alt',
                'class'   => 'btn btn-info treeStatus',
                'href'    => '',
                'onclick' => '$.operate.treeStatus()'
            ]) // 自定义按钮
            ->addTopButton('default', [
                'title'   => '批量新增',
                'icon'    => 'fa fa-plus',
                'class'   => 'btn btn-success',
                'href'    => '',
                'onclick' => '$.operate.batchAdd(\'' . url('batchAdd') . '\')'
            ]) // 自定义按钮
            ->setPagination('false')                        // 关闭分页显示
            ->setParentIdField('parent_id')                 // 设置列表树父id
            ->fetch();
    }

    // 添加
    public function add(string $parentId = '')
    {
        // 获取字段信息
        $columns = MakeBuilder::getAddColumns($this->tableName);
        // 重置`所属模块`和`上级栏目`的选项
        foreach ($columns as $k => $coloumn) {
            if ($coloumn[1] == 'module_id') {
                $columns[$k][4] = $this->getModuleIds();
            }
            if ($coloumn[1] == 'parent_id') {
                $model          = '\app\common\model\\' . $this->modelName;
                $pidOptions     = $model::getPidOptions();
                $columns[$k][4] = $pidOptions;
                // 设置父ID默认值
                if ($parentId) {
                    $columns[$k][5] = $parentId;
                }
            }
        }
        // 获取分组后的字段信息
        $groups = MakeBuilder::getAddGroups($this->modelName, $this->tableName, $columns);
        // 构建页面
        $builder = FormBuilder::getInstance();

        $groups ? $builder->addGroup($groups) : $builder->addFormItems($columns);
        return $builder->fetch();
    }

    // 添加保存
    public function addPost()
    {
        if (Request::isPost()) {
            $data   = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model  = '\app\common\model\\' . $this->modelName;
                $result = $model::addPost($data);
                if ($result['error']) {
                    $this->error($result['msg']);
                } else {
                    $this->singleCateInit($data);
                    $this->success($result['msg'], 'index');
                }
            }
        }
    }

    // 修改
    public function edit(string $id)
    {
        $model = '\app\common\model\\' . $this->modelName;
        $info  = $model::edit($id)->toArray();
        // 获取字段信息
        $columns = MakeBuilder::getAddColumns($this->tableName, $info);

        // 重置`所属模块`和`上级栏目`的选项
        foreach ($columns as $k => $coloumn) {
            if ($coloumn[1] == 'module_id') {
                $columns[$k][4] = $this->getModuleIds();
            }
            if ($coloumn[1] == 'parent_id') {
                $model          = '\app\common\model\\' . $this->modelName;
                $pidOptions     = $model::getPidOptions();
                $columns[$k][4] = $pidOptions;
                // 设置父ID默认值
                if ($info['parent_id']) {
                    $columns[$k][5] = $info['parent_id'];
                }
            }
        }

        // 获取分组后的字段信息
        $groups = MakeBuilder::getAddGroups($this->modelName, $this->tableName, $columns);

        // 构建页面
        $builder = FormBuilder::getInstance();
        $groups ? $builder->addGroup($groups) : $builder->addFormItems($columns);
        return $builder->fetch();
    }

    // 修改保存
    public function editPost()
    {
        if (Request::isPost()) {
            $data = MakeBuilder::changeFormData(Request::except(['file'], 'post'), $this->tableName);
            if ($data['id'] == $data['parent_id']) {
                $this->error('上级栏目不可以为当前栏目');
            }
            $result = $this->validate($data, $this->validate);
            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $model  = '\app\common\model\\' . $this->modelName;
                $result = $model::editPost($data);
                // 修改为单页模块时尝试对当前栏目进行初始化
                $this->editSingleCateInit($data);
                if ($result['error']) {
                    $this->error($result['msg']);
                } else {
                    $this->success($result['msg'], 'index');
                }
            }
        }
    }

    // 删除
    public function del(string $id)
    {
        if (Request::isPost()) {
            // 删除子分类
            $this->delChildsCate($id);
            if (strpos($id, ',') !== false) {
                return $this->selectDel($id);
            }
            $model = '\app\common\model\\' . $this->modelName;
            return $model::del($id);
        }
    }

    // 批量添加
    public function batchAdd()
    {
        // 额外CSS
        $css = '<style>
                    .form_builder .form-group{margin-bottom: 0}
                    .form_builder .col-form-label{padding-right: 5px;}
                    .form_builder .form-control{padding-left: 0.5rem; padding-right: 0.5rem}
                    .form_builder .js_cates_content .col-form-label{display: none}
                    .form_builder .js_cates button{display: none}
                    .form_builder .js_cates_content button{margin-top: 4px}
                </style>';

        // 额外js
        $js = '<script type="text/javascript">
                // 增加一行
                $(document).on("click", \'.js_add_row\', function () {                    
                    var html = $(\'.js_cates\').html();
                    // 获取最后一行的信息
                    var lastSortValue = $("form :input[name=\'sort[]\']").last().val();
                    var lastModuleId = $("form :input[name=\'module_id[]\']").last().val();
                    var lastParentId = $("form :input[name=\'parent_id[]\']").last().val();
                    // 追加
                    $(\'.js_cates_content\').append(html);
                    // 设置新的一行的默认信息
                    $("form :input[name=\'sort[]\']").last().val(lastSortValue * 1 + 1);
                    if (lastModuleId * 1 > 0){
                        $("form :input[name=\'module_id[]\']").last().val(lastModuleId);
                    }
                    if (lastParentId * 1 > 0){
                        $("form :input[name=\'parent_id[]\']").last().val(lastParentId);
                    }
                })
                // 刪除一行
                $(document).on("click", \'.js_del_row\', function () {
                    $(this).parent().parent().remove();
                })
                
            </script>';

        // 添加按钮
        $html = '<div class="row dd_input_group"><button type="button" class="btn btn-success btn-sm js_add_row"><i class="fa fa-plus"></i> 增加一行</button></div>';

        // 所属模块
        $modules    = $this->getModuleIds();
        $modulesStr = '';
        foreach ($modules as $k => $v) {
            $modulesStr .= '<option value="' . $k . '">' . $v . '</option>';
        }
        $html .= '<div class="js_cates">
                    <div class="row dd_input_group">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="col-form-label is-required">所属模块</label>
                                <select class="form-control" name="module_id[]"><option value="">请选择</option>' . $modulesStr . '</select>
                            </div>
                        </div>';
        // 上级栏目
        $model         = '\app\common\model\\' . $this->modelName;
        $pidOptions    = $model::getPidOptions();
        $pidOptionsStr = '';
        foreach ($pidOptions as $k => $v) {
            $pidOptionsStr .= '<option value="' . $k . '">' . $v . '</option>';
        }
        $html .= '<div class="col-2">
                     <div class="form-group">
                        <label class="col-form-label">上级栏目</label>
                        <select class="form-control" name="parent_id[]"><option value="">请选择</option>' . $pidOptionsStr . '</select>
                     </div>    
                  </div>';

        // 栏目名称
        $html .= '<div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label is-required">栏目名称</label>
                        <input class="form-control" type="text" name="cate_name[]" placeholder="请输入栏目名称">
                    </div>
                  </div>';

        // 英文名称
        $html .= '<div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label">英文名称</label>
                        <input class="form-control" type="text" name="en_name[]" placeholder="请输入英文名称">
                    </div>
                  </div>';

        // 栏目目录
        $html .= '<div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label">栏目目录</label>
                        <input class="form-control" type="text" name="cate_folder[]" placeholder="请输入栏目目录">
                    </div>
                  </div>';

        // 排序
        $html .= '<div class="col-1">
                    <div class="form-group">
                        <label class="col-form-label is-required">排序</label>
                        <input class="form-control" type="number" name="sort[]" value="50" step="1">
                    </div>
                  </div>';

        // 删除行
        $html .= '<div class="col-1">
                    <button type="button" class="btn btn-success btn-sm js_del_row"><i class="fa fa-times"></i></button>
                  </div>';

        $html .= '</div></div><div class="js_cates_content"></div>';

        // 构建页面
        $builder = FormBuilder::getInstance();
        $builder->setExtraCss($css)
            ->setExtraJs($js)
            ->addHtml($html);
        return $builder->fetch();
    }

    // 批量添加保存
    public function batchAddPost()
    {
        if (Request::isPost()) {
            $data = Request::except(['file'], 'post');
            if ($data) {
                $dataNew = [];
                for ($i = 0; $i < count($data['module_id']); $i++) {
                    if (empty($data['module_id'][$i]) || empty($data['cate_name'][$i]) || empty($data['sort'][$i])) {
                        $this->error('所属模块、栏目名称和排序不可为空');
                    }
                    $dataNew[] = [
                        'module_id'   => $data['module_id'][$i],
                        'parent_id'   => $data['parent_id'][$i],
                        'cate_name'   => $data['cate_name'][$i],
                        'en_name'     => $data['en_name'][$i],
                        'cate_folder' => $data['cate_folder'][$i],
                        'sort'        => $data['sort'][$i],
                        'status'      => 1,
                        'summary'     => '',
                    ];
                }
                foreach ($dataNew as $k => $v) {
                    $result = $this->validate($v, $this->validate);
                    if (true !== $result) {
                        // 验证失败 输出错误信息
                        $this->error($result);
                    } else {
                        $model  = '\app\common\model\\' . $this->modelName;
                        $result = $model::addPost($v);
                        if ($result['error']) {
                            $this->error($result['msg']);
                        } else {
                            $this->singleCateInit($v);
                        }
                    }
                }
                $this->success($result['msg'], 'index');
            }
        }
    }

    // =====================

    // 获取CMS模块
    private function getModuleIds()
    {
        $modules = \app\common\model\Module::where('table_type', 1)
            ->field('id,module_name')
            ->select()
            ->toArray();
        $result  = [];
        foreach ($modules as &$module) {
            $result[$module['id']] = $module['module_name'];
        }
        return $result;
    }

    /**
     * 删除分类时删除子分类和子分类的数据
     * @param string $id
     * @throws \Exception
     */
    private function delChildsCate(string $id)
    {
        // 多选时重新调用
        if (strpos($id, ',') !== false) {
            $idArr = explode(',', $id);
            foreach ($idArr as $k => $v) {
                $this->delChildsCate($v);
            }
        }
        // 查找当前分类的所有子分类
        $cate = \app\common\model\Cate::select()->toArray();
        $ids  = getChildsId($cate, $id);
        foreach ($ids as $k => $v) {
            // 删除一个分类的内容
            $this->delCateContent($v['id'], $v['module_id']);
            // 删除一个分类
            \app\common\model\Cate::where('id', '=', $v['id'])->delete();
        }
        // 查找当前分类信息并尝试删除
        $cateOn = \app\common\model\Cate::find($id);
        if ($cateOn) {
            // 删除一个分类的内容
            $this->delCateContent($cateOn['id'], $cateOn['module_id']);
        }
    }

    /**
     * 删除某个分类的内容
     * @param string $cateId
     * @param string $moduleId
     * @return bool
     */
    private function delCateContent(string $cateId, string $moduleId)
    {
        $module = \app\common\model\Module::find($moduleId);
        if ($module) {
            $model = '\app\common\model\\' . $module->model_name;
            return $model::where('cate_id', $cateId)->delete();
        } else {
            return false;
        }
    }

    /**
     * 单页模块栏目新增时初始化操作
     * @param array $data
     * @return bool
     */
    private function singleCateInit(array $data = [])
    {
        if ($data['module_id'] == '18') {
            $cate = \app\common\model\Cate::order('id', 'desc')->limit(1)->select()->toArray();
            if (count($cate) > 0) {
                $data = [
                    'sort'    => 50,
                    'status'  => 1,
                    'cate_id' => $cate[0]['id'],
                    'title'   => $cate[0]['cate_name'],
                    'content' => '',
                ];
                \app\common\model\Page::create($data);
                return true;
            }
        }
        return false;
    }

    /**
     * 修改为单页模块时尝试对当前栏目进行初始化
     * @param array $data
     * @return bool
     */
    private function editSingleCateInit(array $data = [])
    {
        if ($data['id'] && $data['module_id'] == '18') {
            // 查询当前栏目信息
            $cate = \app\common\model\Cate::where('id', $data['id'])->find();
            if ($cate) {
                // 查询栏目是否已在page表存在
                $pageNum = \app\common\model\Page::where('cate_id', $cate['id'])->count();
                if ($pageNum == 0) {
                    $data = [
                        'sort'    => 50,
                        'status'  => 1,
                        'cate_id' => $cate['id'],
                        'title'   => $cate['cate_name'],
                        'content' => '',
                    ];
                    \app\common\model\Page::create($data);
                    return true;
                }
            }
        }
        return false;
    }


}
