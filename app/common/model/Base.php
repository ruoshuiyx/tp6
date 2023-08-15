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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Base extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 获取列表
    public static function getList(array $where = [], int $pageSize = 0, array $order = ['sort', 'id' => 'desc'])
    {
        $model = new static();
        $model = $model->alias($model->getName());

        // 获取with关联
        $moduleId  = \app\common\model\Module::where('model_name', $model->getName())->value('id');
        $fileds    = \app\common\model\Field::where('module_id', $moduleId)
            ->select()
            ->toArray();
        $listInfo  = [];  // 字段根据关联信息重新赋值
        $withInfo  = [];  // 模型关联信息(用于设置关联预载入)
        $fieldInfo = [];  // 字段包含.的时候从关联模型中获取数据
        foreach ($fileds as $filed) {
            // 数据源为模型数据时设置关联信息
            if ($filed['data_source'] == 2) {
                $listInfo[] = [
                    'field'          => $filed['field'],                   // 字段名称
                    'relation_model' => lcfirst($filed['relation_model']), // 关联模型
                    'relation_field' => $filed['relation_field'],          // 展示字段
                    'type'           => $filed['type'],                    // 字段类型
                    'setup'          => string2array($filed['setup']),     // 字段其他设置
                ];
                $withInfo[] = lcfirst($filed['relation_model']);
            }
            // 字段包含.的时候从关联模型中获取数据
            if (strpos($filed['field'], '.') !== false) {
                // 拆分字段名称为数组
                $filedArr    = explode('.', $filed['field']);
                $fieldInfo[] = [
                    'field'          => $filed['field'],       // 字段名称
                    'relation_model' => lcfirst($filedArr[0]), // 关联模型
                    'relation_field' => $filedArr[1],          // 展示字段
                    'type'           => $filed['type'],        // 字段类型
                ];
            }
        }

        // 关联预载入
        if ($withInfo) {
            $model = $model->with($withInfo);
        }

        // 筛选条件
        if ($where) {
            $whereNew = [];
            $whereHas = [];
            foreach ($where as $v) {
                if (strpos($v[0], '.') === false) {
                    $whereNew[] = $v;
                } else {
                    // 关联模型搜索
                    $filedArr = explode('.', $v[0]);

                    $whereHas[lcfirst($filedArr[0])][] = [
                        'field'        => $filedArr[1],
                        'field_option' => $v[1],
                        'field_value'  => $v[2],
                    ];
                }
            }
            // 关联模型搜索
            if ($whereHas) {
                foreach ($whereHas as $k => $v) {
                    $model = $model->hasWhere($k, function ($query) use ($v) {
                        foreach ($v as $vv) {
                            $query->where($vv['field'], $vv['field_option'], $vv['field_value']);
                        }
                    });
                }
            }
            // 当前模型搜索
            if ($whereNew) {
                $model = $model->where($where);
            }
        }

        // 查询/分页查询
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
        foreach ($list as $k => $v) {
            // 字段根据关联信息重新赋值(多级联动需另行处理)
            foreach ($listInfo as $vv) {
                if ($vv['type'] == 'linkage') {
                    // 拆分字段其他设置为数组
                    $setupFields = explode(',', $vv['setup']['fields']);
                    // 根据末级ID获取每级的联动数据
                    $levelData = getLinkageListData(ucfirst($vv['relation_model']), $v[$vv['field']], $setupFields[0], $setupFields[1], $setupFields[2]);
                    $levelData = array_reverse($levelData); // 以相反的元素顺序返回数组
                    $str       = '';                        // 要转换成的数据
                    foreach ($levelData as $level) {
                        $str .= $level[$setupFields[1]] . '-';
                    }
                    $list[$k][$vv['field']] = rtrim($str, '-');
                } else {
                    // 多选情况
                    if (strpos($v[$vv['field']], ',') !== false) {
                        $hasManyModel = '\app\common\model\\' . $vv['relation_model'];
                        $hasManyPk    = (new $hasManyModel())->getPk();
                        $hasManys     = $hasManyModel::where($hasManyPk, 'in', $v[$vv['field']])->column($vv['relation_field']);
                        if ($hasManys) {
                            $list[$k][$vv['field']] = implode(',', $hasManys);
                        }
                    } else {
                        $list[$k][$vv['field']] = !empty($v->{$vv['relation_model']}) ? $v->{$vv['relation_model']}->getData($vv['relation_field']) : '';
                    }
                }
            }
            // 字段包含.的时候从关联模型中获取数据
            foreach ($fieldInfo as $vv) {
                $list[$k][$vv['field']] = !empty($v->{$vv['relation_model']}) ? $v->{$vv['relation_model']}->getData($vv['relation_field']) : '';
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
        try {
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
        } catch (\Exception $e) {
            return ['error' => 1, 'msg' => $e->getMessage()];
        }
    }

    // 通用添加保存
    public static function addPost($data)
    {
        try {
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
        } catch (\Exception $e) {
            return ['error' => 1, 'msg' => $e->getMessage()];
        }
    }

    // 删除
    public static function del($id)
    {
        try {
            self::destroy($id);
            return json(['error' => 0, 'msg' => '删除成功!']);
        } catch (\Exception $e) {
            return json(['error' => 1, 'msg' => $e->getMessage()]);
        }
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
        try {
            $info = self::find($data['id']);
            if ($info->sort != $data['sort']) {
                $info->sort = $data['sort'];
                $info->save();
                return json(['error' => 0, 'msg' => '修改成功!']);
            }
        } catch (\Exception $e) {
            return json(['error' => 1, 'msg' => $e->getMessage()]);
        }
    }

    // 状态修改
    public static function state($id)
    {
        try {
            $info         = self::find($id);
            $info->status = $info['status'] == 1 ? 0 : 1;
            $info->save();
            return json(['error' => 0, 'msg' => '修改成功!']);
        } catch (\Exception $e) {
            return json(['error' => 1, 'msg' => $e->getMessage()]);
        }
    }

    // 导出
    public static function export($tableNam, $moduleName)
    {
        ob_end_clean();
        // 获取主键
        $pk = \app\common\facade\MakeBuilder::getPrimarykey($tableNam);
        // 获取列表数据
        $columns = \app\common\facade\MakeBuilder::getListColumns($tableNam);
        // 搜索
        $where         = \app\common\facade\MakeBuilder::getListWhere($tableNam);
        $orderByColumn = \think\facade\Request::param('orderByColumn') ?? $pk;
        $isAsc         = \think\facade\Request::param('isAsc') ?? 'desc';
        $model         = '\app\common\model\\' . $moduleName;
        // 获取要导出的数据
        $list = $model::getList($where, 0, [$orderByColumn => $isAsc]);
        // 初始化表头数组
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        foreach ($columns as $k => $v) {
            $column = Coordinate::stringFromColumnIndex($k+1);
            $sheet->setCellValue($column . '1', $v['1']);
        }
        $list = isset($list['total']) && isset($list['per_page']) && isset($list['data']) ? $list['data'] : $list;
        foreach ($list as $key => $value) {
            foreach ($columns as $k => $v) {
                // 修正字典数据
                if (isset($v[4]) && is_array($v[4]) && !empty($v[4])) {
                    // 将$value[$v['0']]中的字符串分割成数组，数组去重
                    $uniqueKeys = array_unique(explode(',', trim($value[$v['0']], ',')));
                    // 初始化一个空字符串用于连接结果
                    $str = '';

                    // 遍历$aaArray中的每个元素
                    foreach($uniqueKeys as $val){
                        // 查找对应值在$bb中的对应项
                        if(array_key_exists($val, $v[4])){
                            // 将找到的对应项连接到结果字符串中
                            $str .= $v[4][$val] . ',';
                        }
                    }

                    // 去掉最后一个逗号
                    $str = rtrim($str, ',');
                    $value[$v['0']] = $str;
                    // $value[$v['0']] = $v[4][$value[$v['0']]];
                }
                $column = Coordinate::stringFromColumnIndex($k+1);
                $sheet->setCellValue($column . ($key + 2), $value[$v['0']]);
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