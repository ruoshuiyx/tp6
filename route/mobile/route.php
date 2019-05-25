<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

//前台路由部分
$cate = \think\facade\Db::name('cate')
    ->alias('a')
    ->leftJoin('module m','a.moduleid = m.id')
    ->field('a.id,a.catname,a.catdir,m.title as modulename,m.name as moduleurl')
    ->order('a.sort ASC,a.id ASC')
    ->select();
foreach ($cate as $k=>$v){
    //只有设置了栏目目录的栏目才配置路由
    if($v['catdir']){
        if($v['moduleurl']=='page'){
            //单页模型
            //PC
            Route::any(''.$v['catdir'].'-<cate>', ''.$v['catdir'].'/index');
        }else{
            //列表+详情模型
            //PC
            Route::any(''.$v['catdir'].'-<cate>/<id>', $v['catdir'].'/info');
            Route::any(''.$v['catdir'].'-<cate>', $v['catdir'].'/index');
        }
    }
}