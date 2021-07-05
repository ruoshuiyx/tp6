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

// 引入框架内置类
use think\Model;
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;

// 引入导出的命名空间
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Base extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 获取列表
    public static function getList(array $where = [], int $pageSize = 0, array $order = ['sort', 'id' => 'desc'])
    {
        $model = new static();
        // 获取with关联
        $moduleId = \app\common\model\Module::where('model_name', $model->getName())->value('id');
        $fileds   = \app\common\model\Field::where('module_id', $moduleId)
            ->where('data_source', 2)
            ->select()
            ->toArray();
        $listInfo = [];
        $withInfo = [];
        foreach ($fileds as &$filed) {
            $listInfo[] = [
                'field'          => $filed['field'],
                'relation_model' => lcfirst($filed['relation_model']),
                'relation_field' => $filed['relation_field'],
            ];
            $withInfo[] = lcfirst($filed['relation_model']);
        }
        if ($withInfo) {
            $model = $model->with($withInfo);
        }
        if ($where) {
            $model = $model->where($where);
        }
        if ($pageSize) {
            $list = $model->order($order)
                ->paginate([
                    'query'     => Request::get(),
                    'list_rows' => $pageSize,
                ]);
        } else {
            $list = $model->order($order)
                ->select();
        }

        foreach ($list as $v) {
            foreach ($listInfo as $vv) {
                $v[$vv['field']] = ! empty($v->{$vv['relation_model']}) ? $v->{$vv['relation_model']}->getData($vv['relation_field']) : '';
            }
        }
        return MakeBuilder::changeTableData($list, $model->getName());
    }

    // 通用修改数据
    public static function edit($id)
    {
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
    public static function addPost($data)
    {
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
    public static function del($id)
    {
        self::destroy($id);
        return json(['error' => 0, 'msg' => '删除成功!']);
    }

    // 批量删除
    public static function selectDel($id)
    {
        if ($id) {
            $ids = explode(',', $id);
            self::destroy($ids);
            return json(['error' => 0, 'msg' => '删除成功!']);
        } else {
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
    public static function state($id)
    {
        $info         = self::find($id);
        $info->status = $info['status'] == 1 ? 0 : 1;
        $info->save();
        return json(['error' => 0, 'msg' => '修改成功!']);
    }

    // 导出
    public static function export($tableNam, $moduleName)
    {
        // 获取主键
        $pk = \app\common\facade\MakeBuilder::getPrimarykey($tableNam);
        // 获取列表数据
        $coloumns = \app\common\facade\MakeBuilder::getListColumns($tableNam);
        // 搜索
        $where         = \app\common\facade\MakeBuilder::getListWhere($tableNam);
        $orderByColumn = \think\facade\Request::param('orderByColumn') ?? $pk;
        $isAsc         = \think\facade\Request::param('isAsc') ?? 'desc';
        $model         = '\app\common\model\\' . $moduleName;
        // 获取要导出的数据
        $list = $model::getList($where, 0, [$orderByColumn => $isAsc]);
        // 初始化表头数组
        $str         = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        foreach ($coloumns as $k => $v) {
            $sheet->setCellValue($str[$k] . '1', $v['1']);
        }
        $list = isset($list['total']) && isset($list['per_page']) && isset($list['data']) ? $list['data'] : $list;
        foreach ($list as $key => $value) {
            foreach ($coloumns as $k => $v) {
                // 修正字典数据
                if (isset($v[4]) && is_array($v[4]) && ! empty($v[4])) {
                    $value[$v['0']] = $v[4][$value[$v['0']]];
                }
                $sheet->setCellValue($str[$k] . ($key + 2), $value[$v['0']]);
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