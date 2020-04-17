<?php
namespace app\common\facade;

use think\Facade;

class User extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\service\User';
    }
}