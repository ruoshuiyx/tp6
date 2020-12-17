<?php
/**
 * +----------------------------------------------------------------------
 * | 上传控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | DATETIME: 2019/04/03
 *                .::::::::::
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

use think\App;
use think\facade\Request;

class Upload extends Base
{

    // 上传方式 [chunk 大文件分片上传, tp 沿用TP上传]
    private $uploadType = "";

    // 上传验证规则
    protected $uploadValidate = [];

    // 构造方法
    public function __construct(App $app)
    {
        parent::__construct($app);
        // 默认上传方式
        $this->uploadType = "chunk";

        // 验证规则
        $this->uploadValidate = [
            'file' => $this->uploadVal()
        ];
    }

    // 上传文件
    public function index()
    {
        if (Request::param('from') == 'ckeditor') {
            // 获取上传文件表单字段名
            $fileKey = array_keys(request()->file());
            $path = [];
            for ($i = 0; $i < count($fileKey); $i++) {
                // 获取表单上传文件并执行上传操作
                $uploadFile = $this->uploadFile($fileKey[$i]);
                if ($uploadFile['code'] == 1) {
                    $path[] = $uploadFile['url'];
                } else {
                    $path = [];
                    $error = $uploadFile['msg'];
                }
            }

            if ($path) {
                $result['uploaded'] = true;
                // 分辨是否截图上传，截图上传只能上传一个，非截图上传可以上传多个
                if (Request::param('responseType') == 'json') {
                    $result["url"] = $path[0];
                } else {
                    $result["url"] = $path;
                }
                return json($result);
            } else {
                // 上传失败
                $result['uploaded'] = false;
                $result['url'] = '';
                $result['message'] = $error;
                return json($result);
            }
        } else {
            if ($this->uploadType == 'tp') {
                // webupload [file是webloader固定写入的隐藏文本名称]
                return json($this->uploadFile('file'));
            } else {
                return json($this->bigUpload());
            }
        }
    }

    // 上传验证规则
    private function uploadVal()
    {
        $file = [];
        if (Request::param('upload_type') == 'file') {
            // 文件限制
            if ($this->system['upload_file_ext']) {
                $file['fileExt'] = $this->removeExt($this->system['upload_file_ext']);
            } else {
                $file['fileExt'] = 'rar,zip,avi,rmvb,3gp,flv,mp3,mp4,txt,doc,xls,ppt,pdf,xls,docx,xlsx,doc';
            }
            // 限制文件大小(单位b)
            if ($this->system['upload_file_size']) {
                $file['fileSize'] = $this->system['upload_file_size'] * 1024;
            }
        } else {
            // 图片限制
            if ($this->system['upload_image_ext']) {
                $file['fileExt'] = $this->removeExt($this->system['upload_image_ext']);
            } else {
                $file['fileExt'] = 'jpg,png,gif,jpeg';
            }
            // 限制图片大小(单位b)
            if ($this->system['upload_image_size']) {
                $file['fileSize'] = $this->system['upload_image_size'] * 1024;
            }
        }
        return $file;
    }

    // tp上传文件
    private function uploadFile(string $fileName)
    {
        $file = request()->file($fileName);
        try {
            validate($this->uploadValidate)
                ->check(['file' => $file]);
            $savename = \think\facade\Filesystem::disk('public')->putFile('uploads', $file);
            // windows系统中路径反斜杠处理
            $savename = str_replace('\\', '/', $savename);
            return [
                'code' => 1,
                'msg'  => '上传成功',
                'url'  => '/' . $savename
            ];
        } catch (\Exception $e) { // think\exception\ValidateException  取消验证异常捕获
            return [
                'code' => 0,
                'msg'  => 'ERROR:' . $e->getMessage(),
                'url'  => ''
            ];
        }
    }

    // 大文件切片上传
    private function bigUpload()
    {
        // 验证
        $file = request()->file('file');
        try {
            validate($this->uploadValidate)
                ->check(['file' => $file]);
        } catch (\Exception $e) { // think\exception\ValidateException  取消验证异常捕获
            return [
                'code' => 0,
                'msg'  => 'ERROR:' . $e->getMessage(),
                'url'  => ''
            ];
        }

        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // 跨域支持
        // header("Access-Control-Allow-Origin: *");
        // other CORS headers if any...
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }

        if (!empty($_REQUEST['debug'])) {
            $random = rand(0, intval($_REQUEST['debug']));
            if ($random === 0) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

        // 页面执行时间不限制
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);

        // Settings
        // $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        // 设置临时上传目录
        $targetDir = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp';
        // 设置上传目录
        $uploadDir = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . date('Ymd');
        // 上传完后清空临时目录
        $cleanupTargetDir = true;
        // 临时文件期限
        $maxFileAge = 5 * 3600;

        // 创建临时目录
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // 创建上传目录
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

        // 获取上传文件名称
        $fileName = $file->getOriginalName();
        $oldName = $fileName;
        $fileName = iconv('UTF-8', 'gb2312', $fileName);

        // 临时上传完整目录信息
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // 定义命名规则
        $pathInfo = pathinfo($fileName);
        // md5
        $fileName = md5(time() . $pathInfo['basename']) . '.' . $pathInfo['extension'];

        // 正式上传完整目录信息
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

        // 清空临时目录
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                return [
                    'code' => 0,
                    'msg'  => 'Failed to open temp directory.',
                    'url'  => ''
                ];
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // 如果临时文件是当前文件，则转到下一个
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // 如果临时文件早于最大使用期限并且不是当前文件，则将其删除
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // 打开临时文件
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            return [
                'code' => 0,
                'msg'  => 'Failed to open output stream.',
                'url'  => ''
            ];
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                return [
                    'code' => 0,
                    'msg'  => 'Failed to move uploaded file.',
                    'url'  => ''
                ];
            }

            // 读取二进制输入流并将其附加到临时文件
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                return [
                    'code' => 0,
                    'msg'  => 'Failed to open input stream.',
                    'url'  => ''
                ];
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                return [
                    'code' => 0,
                    'msg'  => 'Failed to open input stream.',
                    'url'  => ''
                ];
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for ($index = 0; $index < $chunks; $index++) {
            if (!file_exists("{$filePath}_{$index}.part")) {
                $done = false;
                break;
            }
        }
        if ($done) {
            if (!$out = @fopen($uploadPath, "wb")) {
                return [
                    'code' => 0,
                    'msg'  => 'Failed to open output stream.',
                    'url'  => ''
                ];
            }

            if (flock($out, LOCK_EX)) {
                for ($index = 0; $index < $chunks; $index++) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);

            // 输出
            // 移除public目录
            $uploadPath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $uploadPath);
            // windows系统中路径反斜杠处理
            $uploadPath = '/' . str_replace('\\', '/', $uploadPath);
            return [
                'code' => 1,
                'msg'  => '上传完毕',
                'url'  => $uploadPath,
            ];

            /*$response = [
                'success'=>true,
                'oldName'=>$oldName,
                'filePaht'=>$uploadPath,
                'fileSize'=>$data['size'],
                'fileSuffixes'=>$pathInfo['extension'],
                'file_id'=>$data['id'],
            ];

            die(json_encode($response));*/
        }

        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    // 移除上传危险后缀
    private function removeExt(string $ext = '')
    {
        $ext = strtolower($ext);
        if (strpos($ext, 'php') !== false) {
            $ext = str_ireplace("php", "", $ext);
            return $this->removeExt($ext);
        }
        if (strpos($ext, 'asp') !== false) {
            $ext = str_ireplace("asp", "", $ext);
            return $this->removeExt($ext);
        }
        return $ext;
    }
}
