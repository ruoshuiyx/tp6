<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员日志控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/04
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

use app\admin\model\AdminLog as M;

use think\facade\Request;
use think\facade\Session;
use think\facade\View;

use PHPExcel_IOFactory;
use PHPExcel;

class AdminLog extends Base
{
    // 列表
    public function index(){

        //全局查询条件
        $where = [];
        $keyword = Request::param('keyword');
        if (!empty($keyword)) {
            $where[] = ['username|title', 'like', '%'.$keyword.'%'];
        }
        //非超级管理员只能查看自己的日志
        if (Session::get('admin.id')>1) {
            $where[]=['admin_id', '=', Session::get('admin.id')];
        }
        $dateran = Request::param('dateran');
        if (!empty($dateran)) {
            $getDateran = get_dateran($dateran);
            $where[]=['create_time', 'between', $getDateran];
        }

        //调取列表
        $list = M::getList($where, $this->pageSize, ['id'=>'desc']);

        $view = [
            'keyword'  => $keyword,
            'dateran'  => $dateran,
            'pageSize' => page_size($this->pageSize, $list->total()),
            'page'     => $list->render(),
            'list'     => $list,
            'empty'    => empty_list(9),
        ];
        View::assign($view);
        return View::fetch();
    }

    // 查看
    public function edit(){
        $id   = Request::param('id');
        $info = M::find($id);
        $view = [
            'info' => $info,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 删除
    public function del(){
        $id = Request::param('id');
        M::destroy($id);
        return json(['error'=>0, 'msg'=>'删除成功!']);
    }

    // 批量删除
    public function selectDel(){
        $id = Request::param('id');
        M::destroy($id);
        return json(['error'=>0, 'msg'=>'删除成功!']);
    }

    // 下载
    public function download(){
        $PHPExcel = new PHPExcel(); //实例化PHPExcel类
        $PHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $PHPSheet = $PHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
        $PHPSheet->setTitle('用户列表'); //给当前活动sheet设置名称

        $PHPSheet
            ->setCellValue('A1','ID')
            ->setCellValue('B1','管理员ID')
            ->setCellValue('C1','管理员')
            ->setCellValue('D1','URL')
            ->setCellValue('E1','标题')
            ->setCellValue('F1','内容')
            ->setCellValue('G1','IP')
            ->setCellValue('H1','浏览器')
            ->setCellValue('I1','浏览器全部')
            ->setCellValue('J1','添加时间')
        ;

        //调取列表
        //全局查询条件
        $where = [];
        $keyword = Request::param('keyword');
        if (!empty($keyword)) {
            $where[] = ['username|title', 'like', '%'.$keyword.'%'];
        }
        //非超级管理员只能查看自己的日志
        if (Session::get('admin.id')>1) {
            $where[] = ['admin_id', '=', Session::get('admin.id')];
        }
        $dateran = Request::param('dateran');
        if (!empty($dateran)) {
            $getDateran = get_dateran($dateran);
            $where[] = ['create_time', 'between', $getDateran];
        }

        //调取列表
        $list = M::getDownList($where,['id'=>'desc']);
        foreach ($list as $k => $v) {
            $v['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $PHPSheet
                ->setCellValue('A'.($k+2),$v['id'])
                ->setCellValue('B'.($k+2),$v['admin_id'])
                ->setCellValue('C'.($k+2),$v['username'])
                ->setCellValue('D'.($k+2),$v['url'])
                ->setCellValue('E'.($k+2),$v['title'])
                ->setCellValue('F'.($k+2),$v['content'])
                ->setCellValue('G'.($k+2),$v['ip'])
                ->setCellValue('H'.($k+2),$v['useragent'])
                ->setCellValue('I'.($k+2),$v['useragent_all'])
                ->setCellValue('J'.($k+2),$v['create_time'])
            ;
        }

        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel,'Excel2007');//按照指定格式生成Excel文件，‘Excel2007’表示生成2007版本的xlsx，

        //ob_end_clean();
        header('Content-Disposition: attachment;filename="管理员日志.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output");
    }

}
