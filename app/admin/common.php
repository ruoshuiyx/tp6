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
function get_dateran($dateran)
{
    if ($dateran) {
        $dateran = explode(" 至 ", $dateran);
    }
    if (is_array($dateran) && count($dateran) == 2) {
        $dateran[0] = strtotime($dateran[0]);
        $dateran[1] = strtotime($dateran[1]) + 24 * 60 * 60 - 1;
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

    // 内容管理重构数组
    $controller = \think\facade\Request::controller();
    $module = \app\common\model\Module::where('model_name', $controller)->find();

    if ($module && $module->table_type == 1) {
        // 判断当前方法是添加、修改、列表
        $action = \think\facade\Request::action();
        if ($action == 'add') {
            $action = '添加';
        } else if ($action == 'edit') {
            $action = '修改';
        } else {
            $action = '列表';
        }

        // 内容管理
        $cateId = \think\facade\Request::param('cate_id');
        if (empty($cateId)) {
            $model = '\app\common\model\\' . $module->model_name;
            if ($module['pk'] && \think\facade\Request::param('id')) {
                $cateId = $model::where($module['pk'], \think\facade\Request::param('id'))->value('cate_id');
            }
        }

        // 调用当前栏目名称
        if ($cateId) {
            $cateName = \app\common\model\Cate::where('id', $cateId)->value('cate_name');
            if ($module->is_single) {
                $url = 'edit?id=' . \think\facade\Request::param('id');
            } else {
                $url = 'index?cate_id=' . $cateId;
            }
            $result['right'] = [
                'url'   => $url,
                'title' => $cateName,
                'icon'  => '',
            ];
            $result['left'][0] = $cateName;
            $result['left'][1] = $action;
        }

    }

    return $result;
}
