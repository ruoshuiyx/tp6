<?php
declare (strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Admin extends Command
{
    /**
     * 精简列表
     * ====文件和目录====
     * public/template/ 前台模板目录
     * public/uploads/  前台上传文件目录
     * app/api          前台api应用文件
     * app/index        前台index应用文件
     * app/mobile       前台mobile应用文件
     * ====删除的模块====
     * link,ad_type,ad,debris,page,article,cate,picture,product,download,team,message
     * 1、删除字段管理中的数据[field表，根据 module_id删除]
     * 2、删除菜单规则表中的数据[auth_rule表，根据 model_name 删除]
     * 3、删除模块表中的数据
     * 4、删除模块的控制器、模型、验证器[根据 model_name 删除]
     * 5、删除模块对应的表
     */
    protected function configure()
    {
        // 指令配置
        $this->setName('admin')
            ->setDescription('精简文件和数据库');
    }

    protected function execute(Input $input, Output $output)
    {
        try {
            $rootPath = app()->getRootPath();

            $this->dirDelete($rootPath . 'public' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR);
            $this->dirDelete($rootPath . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR, false);
            $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR);
            $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'index' . DIRECTORY_SEPARATOR);
            $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'mobile' . DIRECTORY_SEPARATOR);

            $tableName = ['link', 'ad_type', 'ad', 'debris', 'page', 'article', 'cate', 'picture', 'product', 'download', 'team', 'message'];
            $module    = \app\common\model\Module::where('table_name', 'in', $tableName)->select();
            if ($module) {
                $module = $module->toArray();
                $prefix = \think\facade\Config::get('database.connections.mysql.prefix');
                foreach ($module as $k => $v) {
                    \app\common\model\Field::where('module_id', $v['id'])->delete();
                    \app\common\model\AuthRule::where('name', $v['model_name'])->whereOr('name', 'like', $v['model_name'] . '/%')->delete();
                    \app\common\model\Module::where('table_name', 'in', $tableName)->delete();
                    $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $v['model_name'] . '.php');
                    $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $v['model_name'] . '.php');
                    $this->dirDelete($rootPath . 'app' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'validate' . DIRECTORY_SEPARATOR . $v['model_name'] . '.php');
                    $sql = 'DROP TABLE IF EXISTS `' . $prefix . $v['table_name'] . '`';
                    \think\facade\Db::query($sql);
                }
            }
            // 指令输出
            $output->writeln('END');
        } catch (\Exception $e) {
            // 指令输出
            $output->writeln('ERROR:' . $e->getMessage());
        }
    }

    /**
     * 删除目录及文件
     * @param string $path    要删除的目录
     * @param bool   $delSelf 是否删除当前目录
     * @return bool
     */
    private function dirDelete(string $path, bool $delSelf = true)
    {
        // 如果是目录则继续
        if (is_dir($path)) {
            // 扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach ($p as $val) {
                // 排除目录中的.和..
                if ($val != "." && $val != "..") {
                    // 如果是目录则递归子目录，继续操作
                    if (is_dir($path . $val)) {
                        // 子目录中操作删除文件夹和文件
                        $this->dirDelete($path . $val . DIRECTORY_SEPARATOR);
                        // 目录清空后删除空文件夹
                        @rmdir($path . $val . DIRECTORY_SEPARATOR);
                    } else {
                        // 如果是文件直接删除
                        unlink($path . $val);
                    }
                }
            }
            if ($delSelf) {
                // 刪除空文件夾
                @rmdir($path);
            }
        } else if (is_file($path)) {
            // 如果是文件直接删除
            unlink($path);
        }
    }
}
