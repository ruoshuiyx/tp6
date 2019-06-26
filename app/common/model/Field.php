<?php
/**
 * +----------------------------------------------------------------------
 * | 模型字段模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/05/25
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

class Field extends Base
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 获取模型对应的字段信息
    public static function getFieldList($moduleId, $order = ['sort' => 'asc', 'id' => 'asc'])
    {
        $list = self::where('moduleid', $moduleId)
            ->order($order)
            ->select()
            ->toArray();
        //格式化setup 字段
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