<?php
namespace app\common\facade;

use think\Facade;

class Cms extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\service\Cms';
    }
}