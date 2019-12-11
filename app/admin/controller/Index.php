<?php
/**
 * +----------------------------------------------------------------------
 * | 首页控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/04/03
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

use app\common\model\Cate;
use app\common\model\Module;
use app\common\model\Users;

use think\facade\App;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Index extends Base
{
    //上传验证规则
    protected $uploadValidate = ['file' => [
        // 限制文件大小(单位b)，这里限制为4M
        //'fileSize' => 4 * 1024 * 1024,
        // 限制文件后缀，多个后缀以英文逗号分割
        'fileExt'  => 'jpg,png,gif,jpeg,rar,zip,avi,rmvb,3gp,flv,mp3,txt,doc,xls,ppt,pdf,xls,docx,xlsx,doc'
        // 更多规则请看“上传验证”的规则，文档地址https://www.kancloud.cn/manual/thinkphp6_0/1037629#_444
    ]];

    // 首页
    public function index()
    {
        //系统信息
        $version = Db::query('SELECT VERSION() AS ver');
        $config = [
            'url' => $_SERVER['HTTP_HOST'],
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'server_os' => PHP_OS,
            'server_port' => $_SERVER['SERVER_PORT'],
            'server_ip' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '',
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'mysql_version' => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize'),
            'version' => App::version(),
            'siyu_version' => Config::get('app.siyu_version'),
        ];

        //查找一周内注册用户信息
        $user = Users::where('create_time', '>', time() - 60 * 60 * 24 * 7)->count();

        //查找待处理留言信息
        $message = Db::name('message')->where('status', '0')->count();

        //查找是否有在线留言的模型id
        $messageModuleId = Module::where('name', 'message')->value('id');
        $messageCatUrl = url('category/index');
        if ($messageModuleId) {
            //查询采用该模型的第一个栏目ID
            $messageCatId = Cate::where('moduleid', $messageModuleId)->value('id');
            if (!is_null($messageCatId)) {
                //生成URL
                $messageCatUrl = url('message/index', ['cate' => $messageCatId]);
            }
        }
        $view = [
            'config' => $config,
            'user' => $user,
            'message' => $message,
            'messageCatUrl' => $messageCatUrl,
        ];
        View::assign($view);
        return View::fetch();
    }

    // 上传文件 [待完善]
    public function upload()
    {
        if (Request::param('from') == 'ckeditor') {
            //获取上传文件表单字段名
            $fileKey = array_keys(request()->file());
            for ($i = 0; $i < count($fileKey); $i++) {
                //获取表单上传文件
                $file = request()->file($fileKey[$i]);
                try {
                    validate($this->uploadValidate)
                        ->check(['file' => $file]);
                    $savename = \think\facade\Filesystem::disk('public')->putFile('uploads', $file);
                    $path[] = '/' . $savename;
                } catch (think\exception\ValidateException $e) {
                    $path = '';
                    $error = $e->getMessage();
                }
            }

            if ($path) {
                $result['uploaded'] = true;
                //分辨是否截图上传，截图上传只能上传一个，非截图上传可以上传多个
                if (Request::param('responseType') == 'json') {
                    $result["url"] = $path[0];
                } else {
                    $result["url"] = $path;
                }
                return json_encode($result);
            } else {
                //上传失败获取错误信息
                $result['uploaded'] = false;
                $result['url'] = '';
                $result['message'] = $error;
                return json_encode($result, true);
            }
        } else {
            //webupload [file是webloader固定写入的隐藏文本名称]
            $file = request()->file('file');
            try {
                validate($this->uploadValidate)
                    ->check(['file' => $file]);
                $savename = \think\facade\Filesystem::disk('public')->putFile('uploads', $file);
                return '/' . $savename;
            } catch (think\exception\ValidateException $e) {
                return $e->getMessage();
            }
        }

    }

    // 清除缓存
    public function clear()
    {
        $path = App::getRootPath() . 'runtime' . DIRECTORY_SEPARATOR;
        if ($this->_deleteDir($path)) {
            $result['msg'] = '清除缓存成功!';
            $result['error'] = 0;
        } else {
            $result['msg'] = '清除缓存失败!';
            $result['error'] = 1;
        }
        $result['url'] = url('admin/login/index');
        return json($result);
    }

    // 执行删除
    private function _deleteDir($R)
    {
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            if ($item != '.' and $item != '..') {
                if (is_dir($R . DIRECTORY_SEPARATOR . $item)) {
                    $this->_deleteDir($R . DIRECTORY_SEPARATOR . $item);
                } else {
                    if ($item != '.gitignore' && $item != 'services.php') {
                        if (!unlink($R . DIRECTORY_SEPARATOR . $item)) {
                            return false;
                        }
                    }
                }
            }
        }
        closedir($handle);
        return true;
        //return rmdir($R); //删除空的目录
    }


}
