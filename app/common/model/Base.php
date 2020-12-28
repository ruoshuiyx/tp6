<?php
/**
 * +----------------------------------------------------------------------
 * | 公共模型基类
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/04/02
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
namespace app\common\model;
use think\Model;

// 引入导出的命名空间
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Base extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 通用修改数据
    public static function edit($id){
        $info = self::find($id);
        return $info;
    }

    // 通用修改保存
    public static function editPost($data)
    {
        if ($data) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $data[$k] = implode(',', $v);
                }
            }
        }

        $result = self::update($data);
        if ($result) {
            return ['error' => 0, 'msg' => '修改成功'];
        } else {
            return ['error' => 1, 'msg' => '修改失败'];
        }
    }

    // 通用添加保存
    public static function addPost($data){
        if ($data) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $data[$k] = implode(',', $v);
                }
            }
        }
        $result = self::create($data);
        if ($result) {
            return ['error' => 0, 'msg' => '添加成功'];
        } else {
            return ['error' => 1, 'msg' => '添加失败'];
        }
    }

    // 删除
    public static function del($id){
        self::destroy($id);
        return json(['error'=>0,'msg'=>'删除成功!']);
    }

    // 批量删除
    public static function selectDel($id){
        if ($id) {
            $ids = explode(',',$id);
            self::destroy($ids);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        }else{
            return ['error' => 1, 'msg' => '删除失败'];
        }
    }

    // 排序修改
    public static function sort($data)
    {
        $info = self::find($data['id']);
        if ($info->sort != $data['sort']) {
            $info->sort = $data['sort'];
            $info->save();
            return json(['error' => 0, 'msg' => '修改成功!']);
        }
    }

    // 状态修改
    public static function state($id){
        $info = self::find($id);
        $info->status = $info['status'] == 1 ? 0 : 1;
        $info->save();
        return json(['error'=>0, 'msg'=>'修改成功!']);
    }

    // 导出
    public static function export($tableNam, $moduleName){
        // 获取主键
        $pk = \app\common\facade\MakeBuilder::getPrimarykey($tableNam);
        // 获取列表数据
        $coloumns = \app\common\facade\MakeBuilder::getListColumns($tableNam);
        // 搜索
        $where = \app\common\facade\MakeBuilder::getListWhere($tableNam);
        $orderByColumn = \think\facade\Request::param('orderByColumn') ?? $pk;
        $isAsc = \think\facade\Request::param('isAsc') ?? 'desc';
        $model = '\app\common\model\\' . $moduleName;
        // 获取要导出的数据
        $list = $model::getExport($where, [$orderByColumn => $isAsc]);
        // 初始化表头数组
        $str = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($coloumns as $k => $v) {
            $sheet->setCellValue($str[$k] . '1', $v['1']);
        }
        foreach ($list as $key => $value) {
            foreach ($coloumns as $k => $v) {
                // 修正字典数据
                if (isset($v[4]) && is_array($v[4]) && !empty($v[4])) {
                    $value[$v['0']] = $v[4][$value[$v['0']]];
                }
                $sheet->setCellValue($str[$k].($key+2),$value[$v['0']]);
            }
        }
        $moduleName = \app\common\model\Module::where('table_name', $tableNam)->value('module_name');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $moduleName . '导出' . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

}