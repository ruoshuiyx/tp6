<?php
/**
 * +----------------------------------------------------------------------
 * | 公共模型基类
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/02
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

class Base extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    //通用修改数据
    public static function edit($id){
        $info = self::find($id);
        return $info;
    }

    //通用修改保存
    public static function editPost($data)
    {
        $result = self::where('id',$data['id'])
            ->update($data);
        if ($result) {
            return ['error' => 0, 'msg' => '修改成功'];
        } else {
            return ['error' => 1, 'msg' => '修改失败'];
        }
    }

    //通用添加保存
    public static function addPost($data){
        $result = self::create($data);
        if ($result) {
            return ['error' => 0, 'msg' => '添加成功'];
        } else {
            return ['error' => 1, 'msg' => '添加失败'];
        }
    }

    //删除
    public static function del($id){
        self::destroy($id);
        return json(['error'=>0,'msg'=>'删除成功!']);
    }

    //批量删除
    public static function selectDel($id){
        self::destroy($id);
        return json(['error'=>0,'msg'=>'删除成功!']);
    }

    //排序修改
    public static function sort($data){
        self::where('id',$data['id'])
            ->update($data);
        return json(['error'=>0,'msg'=>'修改成功!']);

    }

    //状态修改
    public static function state($id){
        $data = self::find($id);
        $data->status = $data['status']==1 ? 0 : 1;
        $data -> save();
        return json(['error'=>0,'msg'=>'修改成功!']);
    }


}