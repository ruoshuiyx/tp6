<?php
/**
 * +----------------------------------------------------------------------
 * | 模型字段模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | DATETIME: 2020/03/08
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
namespace app\common\model;

// 引入框架内置类
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;
class Field extends Base
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 一对一获取所属模块
    public function Module()
    {
        return $this->belongsTo('Module', 'module_id');
    }

    // 一对一获取所属字典
    public function DictionaryType()
    {
        return $this->belongsTo('DictionaryType', 'dict_code');
    }

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query' => Request::get(),
                'list_rows' => $pageSize,
            ]);
        foreach ($list as $k => $v) {
            $list[$k]['module_id'] = $v->Module->getData('module_name');
            if ($list[$k]['dict_code']) {
                $list[$k]['dict_code'] = $v->DictionaryType->getData('dict_name');
            }
        }
        return  MakeBuilder::changeTableData($list, 'Field');
    }

    // 获取模型对应的字段信息
    public static function getFieldList($moduleId, $order = ['sort' => 'asc', 'id' => 'asc'])
    {
        $list = self::where('module_id', $moduleId)
            ->order($order)
            ->select()
            ->toArray();
        // 格式化setup 字段
        $result = array();
        foreach ($list as $k => $v) {
            if (!empty($v['setup'])) {
                $list[$k]['setup'] = string2array($v['setup']);
                if (array_key_exists('options', $list[$k]['setup'])) {
                    $list[$k]['setup']['options'] = explode("\n", $list[$k]['setup']['options']);
                    foreach ($list[$k]['setup']['options'] as $kk => $vv) {
                        $list[$k]['setup']['options'][$kk] = trim_array_element(explode("|", $list[$k]['setup']['options'][$kk]));
                    }
                }
            }
            $result[$v['field']] = $list[$k];
        }
        return $result;
    }

}