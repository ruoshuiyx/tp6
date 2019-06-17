<?php

/**
 * 生成页码跳转
 * @param int $page_size 每页显示的数量
 * @return string
 */
function page_size($page_size = 0, $total = 0){
    $str  = '<select class="form-control page_size">';
    for ($i = 10; $i <= 100; $i += 10) {
        $selected = $page_size==$i? 'selected':'';
        $str .= '<option value="'.$i.'" '.$selected.' >'.$i.' 条/页</option>';
    }
    $str .= '</select>';
    if ($total > 0) {
        $str .= '<span class="form-control page_total">总共 '.$total.' 条记录</span>';
    }
    return $str;
}

/**
 * 空数据提示
 * @param int $num
 * @return string
 */
function empty_list($num = 10){
    $empty = "<tr><td colspan='".$num."' align='center'>暂无数据</td></tr>";
    return $empty;
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
 * 权限设置选中状态
 * @param $cate  栏目
 * @param int $pid 父ID
 * @param $rules 规则
 * @return array
 */
function auth($cate , $pid = 0,$rules){
    $arr = array();
    $rulesArr = explode(',',$rules);
    foreach ($cate as $v){
        if ($v['pid'] == $pid) {
            if (in_array($v['id'], $rulesArr)) {
                $v['checked'] = true;
            }
            $v['open'] = true;
            $arr[]=$v;
            $arr = array_merge($arr, auth($cate, $v['id'], $rules));
        }
    }
    return $arr;
}

/**
 * PHP格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 获取目录里的文件，不包括下级文件夹
 * @param string $dir  路径
 * @return array
 */
function get_dir($dir){
    $file = @ scandir($dir);
    foreach ($file as $key){
        if ( $key != ".." && $key != "." ){
            $files[] = $key;
        }
    }
    return $files;
}

/**
 * 获取文件夹中的文件,含目录
 * @param $path
 * @param string $exts
 * @param array $list
 * @return array
 */
function dir_list($path, $exts = '', $list= array()) {
    $path = dir_path($path);
    $files = glob($path.'*');
    foreach ($files as $v) {
        $fileext = fileext($v);
        if (!$exts || preg_match("/\.($exts)/i", $v)) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            }
        }
    }
    return $list;
}

/**
 * 补齐目录后的/
 * @param $path 目录
 * @return string
 */
function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/') $path = $path.'/';
    return $path;
}

/**
 * 查找文件后缀
 * @param $filename 文件名称
 * @return string 后缀名称（如：html）
 */
function fileext($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/**
 * 删除目录及文件
 * @param $dir
 * @return bool
 */
function dir_delete($dir) {
    $dir = dir_path($dir);
    if (!is_dir($dir)) return FALSE;
    $list = glob($dir.'*');
    foreach ($list as $v) {
        is_dir($v) ? dir_delete($v) : @unlink($v);
    }
    return @rmdir($dir);
}

/**
 * 生成不同的编辑器(目前只支持ckeditor)
 * @param string $name     字段名称
 * @param string $conetnt  内容
 * @param string $editor   编辑器
 * @param string $height   高度
 * @param string $width    宽度
 * @return string
 */
function make_editor($name, $conetnt = '', $editor = '' ,$height = '400px', $width ='' ){
    $result = '<textarea name="'.$name.'" id="'.$name.'">'.$conetnt.'</textarea><script>CKEDITOR.replace(\''.$name.'\', { height: \''.$height.'\', width: \''.$width.'\' });</script>';
    return $result;
}

/***
 * 日期筛选格式化
 * @param $dateran
 * @return array
 */
function get_dateran($dateran){
    if ($dateran) {
        $dateran = explode(" 至 ",$dateran);
    }
    if (is_array($dateran) && count($dateran) == 2) {
        $dateran[0] = strtotime($dateran[0]);
        $dateran[1] = strtotime($dateran[1])+24*60*60-1;
    }
    return $dateran;
}

/**
 * 根据数组中某个字段重新分组
 * @param {dataArr:需要分组的数据；keyStr:分组依据}
 * @return: array
 */
function array_group(array $dataArr, string $keyStr)   :array
{
    $newArr=[];
    foreach ($dataArr as $k => $val) {
        $newArr[$val[$keyStr]][] = $val;
    }
    return $newArr;
}

/***
 * 格式化面包导航(用户后台面包导航)
 * @param $data
 * @return array
 */
function format_bread_crumb($data)
{
    $result = array();
    if (!empty($data)) {
        $data = array_reverse($data);
        if (count($data) == 4) {
            //非常规 添加或修改
            $result['right'] = $data[1];
            $result['left'][0] = $data[1]['title'];
            //查看是添加还是修改
            $result['left'][1] = $data[2]['title'] . '-' . str_replace('操作-', '', $data[3]['title']);
        } else if (count($data) == 3) {
            //常规 添加或修改
            $result['right'] = $data[1];
            $result['left'][0] = $data[1]['title'];
            //查看是添加还是修改
            $result['left'][1] = str_replace('操作-', '', $data[2]['title']);
        } else if (count($data) == 2) {
            //常规 列表
            $result['right'] = $data[1];
            $result['left'][0] = $data[1]['title'];
            $result['left'][1] = '列表';
        } else {
            //单独定义
            $result['right'] = $data[0];
            $result['left'][0] = $data[0]['title'];
            $result['left'][1] = '';
        }
    }

    //内容管理重构数组
    if (\think\facade\Request::has('cate')) {
        //判断当前方法是添加、修改、列表
        $action = \think\facade\Request::action();
        if ($action == 'add') {
            $action = '添加';
        } else if ($action == 'edit') {
            $action = '修改';
        } else {
            $action = '列表';
        }
        //内容管理
        $cate = \think\facade\Request::param('cate');
        //调用当前栏目名称
        $catname = \app\common\model\Cate::where('id', $cate)->value('catname');
        $result['right'] = [
            'url' => '',
            'title' => $catname,
            'icon' => '',
        ];
        $result['left'][0] = $catname;
        $result['left'][1] = $action;
    }

    return $result;
}

/***
 * 根据字段信息生成通用Html
 * @param $type     字段类型   必填
 * @param $field    字段名称   必填
 * @param $name     字段别名   必填
 * @param $required 是否必填   选填
 * @param $tips     提示语     选填
 * @param $value    字段的值   选填
 * @param $moduleid 当前模型   选填 [栏目字段需要]
 * @param $cate     栏目列表   选填 [栏目字段需要]
 * @param $cateId   当前栏目   选填 [栏目字段需要]
 * @param $setup    选项      选填 [下拉、单选、多选需要]
 * @param $template 模板      选填 [内容控制器需要]
 *
 *
 * cate     栏目
 * title    标题
 * text     单行文本
 * textarea 多行文本
 * editor   编辑器
 * select   下拉列表
 * radio    单选按钮
 * checkbox 复选框
 * image    单张图片
 * images   多张图片
 * file     文件上传
 * number   数字
 * datetime 日期和时间
 * template 模版
 *
 */
function make_html_add($type, $field, $name, $required, $tips, $value = null, $moduleid = null, $cate = null, $cateId = null, $setup = [], $template = [])
{
    $result = '';
    $requiredHtml = $required ? ' *' : '';
    $tipsHtml = $tips ? ' ' . $tips : '';
    switch ($type) {
        case 'cate':
            $selctHtml = '';
            foreach ($cate as $k => $v) {
                $selected = $cateId == $v['id'] ? 'selected' : '';
                $disabledOption = $moduleid !== $v['moduleid'] ? ' disabled ' : '';
                $disabledSelect = $moduleid == 1 ? ' disabled ' : '';
                $selctHtml .= '<option ' . $selected . ' ' . $disabledOption . ' value="' . $v['id'] . '">' . $v['lcatname'] . '</option>';
            }

            $selctHtml = '<select name="' . $field . '" class="form-control" ' . $disabledSelect . '>
                    ' . $selctHtml . '
                    </select>';
            $pageInput = $moduleid == 1 ? '<input type="hidden" name="' . $field . '" value="' . $cateId . '"/>' : '';
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                  <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                  ' . $selctHtml . '
                  ' . $pageInput . '
                  </div>
                  <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>
                  ';
            break;
        case 'title':
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                    <input type="text" name="' . $field . '" class="form-control" placeholder="请输入' . $name . '" value="' . $value . '">
                </div>
                <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'text':
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
               <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
               <input type="text" name="' . $field . '" class="form-control" placeholder="请输入' . $name . '" value="' . $value . '">
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'textarea':
            $result = '<div class="col-xs-11 col-sm-8 col-md-6 col-lg-5">
               <label class="text-lable">' . $name . '</label>
               <textarea class="form-control" name="' . $field . '" rows="3" placeholder="请输入' . $name . '">' . $value . '</textarea>
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'editor':
            $editorHtml = make_editor($field, $value);
            $result = '<div class="col-xs-12 col-sm-11 col-md-10 col-lg-8">
                    <label class="text-lable">' . $name . '</label>
                    ' . $editorHtml . '
                </div>';
            break;
        case 'select':
            $options = $setup['options'] ? $setup['options'] : []; //需考虑传入数据是否直接可用
            $selctHtml = '';
            foreach ($options as $k => $v) {
                $selected = $value == trim($v[1]) ? 'selected' : '';
                $selctHtml .= '<option ' . $selected . '  value="' . $v[1] . '">' . $v[0] . '</option>';
            }
            $selctHtml = '<select name="' . $field . '" class="form-control" >
                    ' . $selctHtml . '
                    </select>';

            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
               <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
               '.$selctHtml.'
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'radio':
            $options = $setup['options'] ? $setup['options'] : []; //需考虑传入数据是否直接可用
            $radioHtml = '';
            foreach ($options as $k => $v) {
                if ($value) {
                    $checked = $value == trim($v[1]) ? 'checked' : '';
                } else {
                    $checked = $setup['default'] == trim($v[1]) ? 'checked' : '';
                }
                $radioHtml .= '<label class="dd_radio_lable"><input type="radio" name="' . $field . '" value="' . $v[1] . '" class="dd_radio" ' . $checked . '><span>' . $v[0] . '</span></label>';
            }
            $radioHtml = '<div class="dd_radio_lable_left">
                    ' . $radioHtml . '
                    </div>';

            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
               <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
               '.$radioHtml.'
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'checkbox':
            $options = $setup['options'] ? $setup['options'] : []; //需考虑传入数据是否直接可用
            $checkboxHtml = '';
            foreach ($options as $k => $v) {
                if ($value) {
                    $checked = in_array(trim($v[1]),explode(',',$value))  ? 'checked' : '';
                } else {
                    $checked = in_array(trim($v[1]),explode(',',$setup['default']))  ? 'checked' : '';
                }
                $checkboxHtml .= '<label class="dd_radio_lable"><input type="checkbox" name="' . $field . '[]" value="' . $v[1] . '" class="dd_radio" '.$checked.'><span>' . $v[0] . '</span></label>';
            }
            $checkboxHtml = '<div class="dd_radio_lable_left">
                    ' . $checkboxHtml . '
                    </div>';

            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
               <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
               '.$checkboxHtml.'
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'image':
            $images = $value ? $value : '/static/admin/images/nopic.png';
            $requiredHtml = $required ? '<span class="image_preview"> *</span>' : '';
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                  <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                    <input type="text" name="' . $field . '" class="form-control" placeholder="请点击按钮上传或手动输入地址" value="' . $value . '">
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 dd_ts">
                    <!--上传图片-->
                    <!--用来存放item-->
                    <div id="fileList_image' . $field . '" class="uploader-list">
                    </div>
                    <div id="filePicker_image' . $field . '"><i class="fa fa-upload m-r-10"></i>选择图片</div>
                    <img class="image_preview" src="' . $images . '" id="image_preview' . $field . '">
                    <!--上传图片-->
                    ' . $requiredHtml . '
                  </div>
                  <script>webupload(\'fileList_image' . $field . '\',\'filePicker_image' . $field . '\',\'image_preview' . $field . '\',\'' . $field . '\',false ,\'' . $setup['upload_allowext'] . '\');	</script>';
            break;
        case 'images':
            $imagesHtml = '';
            $requiredHtml = $required ? '<span class="image_preview"> *</span>' : '';
            if ($value) {
                foreach ($value as $k => $v) {
                    $imagesHtml .= ' <div class="row"><div class="col-xs-6"><input type="text" name="' . $field . '[]" value="' . $v['image'] . '" class="form-control"></div> <div class="col-xs-3"><input class="form-control input-sm" type="text" name="' . $field . '_title[]" value="' . $v['title'] . '"></div> <div class="col-xs-3"><button type="button" class="btn btn-block btn-warning remove_images">移除</button></div></div>';
                }
            }

            $result = '<div class="col-xs-11 col-sm-8 col-md-6 col-lg-5">
                  <label class="text-lable">' . $name . '</label>
                    <div class="more_images dd_ts">
                        <div id="more_images_' . $field . '">
                            <!---->
                            ' . $imagesHtml . '
                            <!---->
                        </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 dd_ts">
                        <!--上传图片-->
                        <!--用来存放item-->
                        <div id="fileList_image' . $field . '" class="uploader-list"></div>
                        <div id="filePicker_image' . $field . '"><i class="fa fa-upload m-r-10"></i>选择图片</div>
                        <!--上传图片-->
                        <script>webupload(\'fileList_image' . $field . '\',\'filePicker_image' . $field . '\',\'image_preview' . $field . '\',\'' . $field . '\',true ,\'' . $setup['upload_allowext'] . '\');	</script>
                       ' . $requiredHtml . '
                  </div>';
            break;
        case 'file':
            $images = $value ? $value : '/static/admin/images/nopic.png';
            $requiredHtml = $required ? '<span class="image_preview"> *</span>' : '';
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                  <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                    <input type="text" name="' . $field . '" class="form-control" placeholder="请点击按钮上传或手动输入地址" value="' . $value . '">
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 dd_ts">
                    <!--上传图片-->
                    <!--用来存放item-->
                    <div id="fileList_image' . $field . '" class="uploader-list">
                    </div>
                    <div id="filePicker_image' . $field . '"><i class="fa fa-upload m-r-10"></i>选择图片</div>
                    <!--上传图片-->
                    ' . $requiredHtml . '
                  </div>
                  <script>webupload(\'fileList_image' . $field . '\',\'filePicker_image' . $field . '\',\'image_preview' . $field . '\',\'' . $field . '\',false ,\'' . $setup['upload_allowext'] . '\');	</script>';
            break;
        case 'number':
            $value = $value ? $value : $setup['default'];
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                    <input type="number" name="' . $field . '" class="form-control" placeholder="请输入' . $name . '" value="' . $value . '">
                </div>
                <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
        case 'datetime':
            $value = $value ? date("Y-m-d H:i", $value) : date("Y-m-d H:i", time());
            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
                <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
                    <input type="text" name="' . $field . '" class="form-control" placeholder="请输入' . $name . '" value="' . $value . '" id="datepicker_' . $field . '">
                </div>
                <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>
                <script>
                $(function(){
                    $(\'#datepicker_' . $field . '\').datetimepicker({
                      autoclose: 1,
                      format:"yyyy-mm-dd hh:ii:ss",
                      language: "zh-CN",
                      todayHighlight: 1,//今天高亮
                    })
                })
                </script>
                ';
            break;
        case 'template':
            $templateHtml = '';
            $template = $template['show'] ? $template['show'] : $template;
            foreach ($template as $k => $v) {
                $selected = $value == trim($v) ? 'selected' : '';
                $templateHtml .= '<option ' . $selected . '  value="' . $v . '">' . $v . '</option>';
            }
            $templateHtml = '<select name="' . $field . '" class="form-control" >
                    <option value="">请选择</option>
                    ' . $templateHtml . '
                    </select>';

            $result = '<label class="col-xs-4 col-sm-2 col-md-2 col-lg-1 control-label dd_input_l">' . $name . '</label>
               <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4">
               '.$templateHtml.'
               </div>
               <div class="col-xs-1 col-sm-4 col-md-6 col-lg-6 dd_ts">' . $requiredHtml . $tipsHtml . '</div>';
            break;
    }

    //拼接公共Html
    $result = '
        <div class="row dd_input_group">
            <div class="form-group">
            ' . $result . '
            </div>
        </div>';



    return $result;
}
