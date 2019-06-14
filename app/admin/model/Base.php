<?php
namespace app\admin\model;

use think\facade\Session;
use think\Model;

class Base extends Model
{
    // 获取左侧主菜单
    public static function getMenus()
    {
        $authRule = AuthRule::where('status', 1)
            ->order('sort asc')
            ->select()
            ->toArray();

        $menus = array();
        foreach ($authRule as $key => $val) {
            $authRule[$key]['href'] = url($val['name']);
            if ($val['pid'] == 0) {
                if (Session::get('admin.id') != 1) {
                    if (in_array($val['id'], Session::get('admin.rules', []))) {
                        $menus[] = $val;
                    }
                } else {
                    $menus[] = $val;
                }
            }
        }
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = [];
            foreach ($authRule as $kk => $vv) {
                if ($v['id'] == $vv['pid']) {
                    if (Session::get('admin.id') != 1) {
                        if (in_array($vv['id'], Session::get('admin.rules'))) {
                            $menus[$k]['children'][] = $vv;
                        }
                    } else {
                        $menus[$k]['children'][] = $vv;
                    }
                }
            }
        }
        return $menus;
    }
}