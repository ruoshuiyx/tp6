<?php
/**
 * +----------------------------------------------------------------------
 * | 公共系统设置模型
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/04
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

use think\facade\Request;

class System extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 一对一获取所属分组
    public function systemGroup()
    {
        return $this->belongsTo('SystemGroup','group_id');
    }

    //格式化获取所有字段(后台列表)
    public static function getListField($order=['sort','id'=>'desc']){
        $list = self::order($order)
            ->select();
        foreach($list as $k=>$v){
            $v['type_name']  = self::getType($v['type']);
            $v['group_name'] = $v->systemGroup->getData('name');
        }
        return $list;
    }

    // 获取字段列表
    public static function getList($where=array(),$pageSize,$order=['sort','id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->paginate($pageSize,false,['query' => Request::get()]);
        foreach($list as $k=>$v){
            $v['type_name']  = self::getType($v['type']);
            $v['group_name'] = $v->systemGroup->getData('name');
        }
        return $list;
    }

    // 字段类型
    public static function getType($type=''){
        $arr=[
            'text'      => '单行文本',
            'textarea'  => '多行文本',
            'editor'    => '编辑器',
            'select'    => '下拉列表',
            'radio'     => '单选按钮',
            'checkbox'  => '复选框',
            'image'     => '单张图片',
            'file'      => '文件上传',
            'datetime'  => '日期和时间',
            'template'  => '选择模板',
        ];
        if($type){
            return $arr[$type];
        }else{
            return $arr;
        }
    }

}