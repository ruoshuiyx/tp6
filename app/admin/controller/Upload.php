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
            $path    = [];
            for ($i = 0; $i < count($fileKey); $i++) {
                // 获取表单上传文件并执行上传操作
                $uploadFile = $this->uploadFile($fileKey[$i]);
                if ($uploadFile['code'] == 1) {
                    $path[] = $uploadFile['url'];
                } else {
                    $path  = [];
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
                $result['url']      = '';
                $result['message']  = $error;
                return json($result);
            }
        } else if ((Request::param('from') == 'ueditor')) {
            return $this->ueIndex();
        } else {
            if ($this->uploadType == 'tp') {
                // webupload [file是webloader固定写入的隐藏文本名称]
                return json($this->uploadFile('file'));
            } else {
                try {
                    return json($this->bigUpload());
                } catch (\Exception $e) {
                    return json([
                        'code' => 0,
                        'msg'  => 'ERROR:' . $e->getMessage(),
                        'url'  => ''
                    ]);
                }
            }
        }
    }

    // 上传验证规则
    private function uploadVal()
    {
        $file = [];
        if (Request::param('upload_type') == 'file' || Request::param('action') == 'upload_video' | Request::param('action') == 'upload_file') {
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
            $savename = '/' . str_replace('\\', '/', $savename);
            // 上传驱动
            $savename = $this->uploadDriver($savename);
            if (is_array($savename)) {
                return [
                    'code' => 0,
                    'msg'  => $savename['msg'],
                    'url'  => '',
                ];
            }
            return [
                'code' => 1,
                'msg'  => '上传成功',
                'url'  => $savename
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
        $oldName  = $fileName;
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
        $chunk  = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
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
        $done  = true;
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
            // 上传驱动
            $uploadPath = $this->uploadDriver($uploadPath);
            if (is_array($uploadPath)) {
                return [
                    'code' => 0,
                    'msg'  => $uploadPath['msg'],
                    'url'  => '',
                ];
            }
            return [
                'code'     => 1,
                'msg'      => '上传完毕',
                'url'      => $uploadPath,
                'title'    => $_FILES["file"]['name'],
                'original' => $_FILES["file"]['name'],
                'state'    => 'SUCCESS',
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

    // 上传驱动
    private function uploadDriver(string $fineName = '')
    {
        if ($fineName) {
            $uploadDriver = \app\common\model\System::where('id', 1)->value('upload_driver');
            if ($uploadDriver == '1') {
                return $fineName;
            } else if ($uploadDriver == '2') {
                // 阿里云
                $urlArr = hook('aliyunOssHook', ['url' => $fineName]);
                $urlArr = json_decode($urlArr, true);
                if (isset($urlArr['error']) && $urlArr['error'] == 0) {
                    return $urlArr['data'];
                } else {
                    return $urlArr;
                }
            } else if ($uploadDriver == '3') {
                // 七牛云
                $urlArr = hook('qiniuOssHook', ['url' => $fineName]);
                $urlArr = json_decode($urlArr, true);
                if (isset($urlArr['error']) && $urlArr['error'] == 0) {
                    return $urlArr['data'];
                } else {
                    return $urlArr;
                }
            }
        }
    }

    // ===================================Ueditor===================================

    // 配置信息，部分信息会重新赋值，仅做参考
    private $ueConfig = [
        /* 上传图片配置项 */
        "imageActionName"         => "upload_image", /* 执行上传图片的action名称 */
        "imageFieldName"          => "file", /* 提交的图片表单名称 */
        "imageMaxSize"            => 10485760, /* 上传大小限制，单位B  102400=100KB, 512000=500KB,1048576=1M */
        "imageAllowFiles"         => [".png", ".jpg", ".jpeg", ".gif", ".bmp", ".webp"], /* 上传图片格式显示 */
        "imageCompressEnable"     => true, /* 是否压缩图片,默认是true */
        "imageCompressBorder"     => 1600, /* 图片压缩最长边限制 */
        "imageInsertAlign"        => "none", /* 插入的图片浮动方式 */
        "imageUrlPrefix"          => "", /* 图片访问路径前缀 */
        "imagePathFormat"         => "",

        /* 截图工具上传 */
        "snapscreenActionName"    => "upload_image", /* 执行上传截图的action名称 */
        "snapscreenPathFormat"    => "", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "snapscreenUrlPrefix"     => "", /* 图片访问路径前缀 */
        "snapscreenInsertAlign"   => "none", /* 插入的图片浮动方式 */

        /* 抓取远程图片配置 */
        "catcherLocalDomain"      => ["127.0.0.1", "localhost", "img.baidu.com"],
        "catcherActionName"       => "catch_image", /* 执行抓取远程图片的action名称 */
        "catcherFieldName"        => "file", /* 提交的图片列表表单名称 */
        "catcherPathFormat"       => "", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "catcherUrlPrefix"        => "", /* 图片访问路径前缀 */
        "catcherMaxSize"          => 10485760, /* 上传大小限制，单位B 102400=100KB, 512000=500KB,1048576=1M */
        "catcherAllowFiles"       => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 抓取图片格式显示 */

        /* 上传视频配置 */
        "videoActionName"         => "upload_video", /* 执行上传视频的action名称 */
        "videoFieldName"          => "file", /* 提交的视频表单名称 */
        "videoPathFormat"         => "./upload/ueditor/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "videoUrlPrefix"          => "", /* 视频访问路径前缀 */
        "videoMaxSize"            => 104857600, /* 上传大小限制，单位B，默认100MB */
        "videoAllowFiles"         => [
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"
        ], /* 上传视频格式显示 */

        /* 上传文件配置 */
        "fileActionName"          => "upload_file", /* controller里,执行上传视频的action名称 */
        "fileFieldName"           => "file", /* 提交的文件表单名称 */
        "filePathFormat"          => "", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "fileUrlPrefix"           => "", /* 文件访问路径前缀 */
        "fileMaxSize"             => 51200000, /* 上传大小限制，单位B，默认50MB */
        "fileAllowFiles"          => [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml",
        ], /* 上传文件格式显示 */

        /* 列出指定目录下的图片 */
        "imageManagerActionName"  => "list_image", /* 执行图片管理的action名称 */
        "imageManagerListPath"    => "", /* 指定要列出图片的目录 */
        "imageManagerListSize"    => 20, /* 每次列出文件数量 */
        "imageManagerUrlPrefix"   => "", /* 图片访问路径前缀 */
        "imageManagerInsertAlign" => "none", /* 插入的图片浮动方式 */
        "imageManagerAllowFiles"  => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 列出的文件类型 */

        /* 列出指定目录下的文件 */
        "fileManagerActionName"   => "list_file", /* 执行文件管理的action名称 */
        "fileManagerListPath"     => "", /* 指定要列出文件的目录 */
        "fileManagerUrlPrefix"    => "", /* 文件访问路径前缀 */
        "fileManagerListSize"     => 20, /* 每次列出文件数量 */
        "fileManagerAllowFiles"   => [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml",
        ], /* 列出的文件类型 */
    ];

    // 针对ueditor的请求链接进行分发
    private function ueIndex()
    {
        $action = Request::param('action', '');
        switch ($action) {
            case 'config':
                return json($this->ueConfig);
                break;

            /* 上传图片 */
            case 'upload_image':
                return json($this->bigUpload());
                break;

            /* 上传视频 */
            case 'upload_video':
                return json($this->bigUpload());
                break;

            /* 上传文件 */
            case 'upload_file':
                return json($this->bigUpload());
                break;

            /* 列出图片 */
            case 'list_image':
                $allowFiles = $this->system['upload_image_ext'];
                $listSize   = $this->ueConfig['imageManagerListSize'];
                $path       = public_path() . 'uploads';
                $get        = Request::param();
                $result     = $this->fileList($allowFiles, $listSize, $path, $get);
                break;

            /* 列出文件 */
            case 'list_file':
                $allowFiles = $this->system['upload_file_ext'];
                $listSize   = $this->ueConfig['imageManagerListSize'];
                $path       = public_path() . 'uploads';
                $get        = Request::param();
                $result     = $this->fileList($allowFiles, $listSize, $path, $get);
                break;

            /* 抓取远程文件 */
            case 'catch_image':
                $config = [
                    "maxSize"    => $this->system['upload_image_size'],
                    "allowFiles" => $this->system['upload_image_ext'] ? explode(',', $this->system['upload_image_ext']) : [],
                    "oriName"    => "remote.png",
                ];

                /* 抓取远程图片 */
                $list     = [];
                $failList = []; //错误的列表
                $source   = Request::param('file');
                if (empty($source)) {
                    return $this->error('参数错误');
                }

                foreach ($source as $imgUrl) {
                    $remoteResult = $this->saveRemote($config, $imgUrl);
                    if (is_array($remoteResult) && $remoteResult['code'] == 1) {
                        array_push($list, [
                            "state"    => $remoteResult["state"],
                            "url"      => $remoteResult["url"],
                            "size"     => $remoteResult["size"],
                            "title"    => htmlspecialchars($remoteResult["title"]),
                            "original" => htmlspecialchars($remoteResult["original"]),
                            "source"   => htmlspecialchars($imgUrl),
                        ]);
                    } else {
                        array_push($failList, [
                            "state"  => 'ERROR',
                            "source" => htmlspecialchars($imgUrl),
                        ]);
                    }
                }

                $result = [
                    'state'     => count($list) ? 'SUCCESS' : 'ERROR',
                    'list'      => $list,
                    'fail_list' => $failList,
                ];
                break;

            default:
                return $this->error('请求地址出错');
                break;
        }

        return json($result);
    }

    /**
     * 文件列表
     * @param string $allowFiles 指定的文件后缀
     * @param int    $listSize   列表分页数量
     * @param string $path       文件目录
     * @param array  $get        ['size'=>xxx,'start'=>xxx]
     * @return array
     */
    private function fileList($allowFiles, $listSize, $path, $get)
    {
        $dirname    = $path;
        $allowFiles = substr(str_replace(",", "|", $allowFiles), 0);

        /* 获取参数 */
        $size  = isset($get['size']) ? htmlspecialchars($get['size']) : $listSize;
        $start = isset($get['start']) ? htmlspecialchars($get['start']) : 0;
        $end   = $start + $size;

        /* 获取文件列表 */
        $files = $this->getFiles($dirname, $allowFiles);
        if (!count($files)) {
            return [
                "code"  => 0,
                "state" => "no match file",
                "list"  => [],
                "start" => $start,
                "total" => count($files),
            ];
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }

        /* 返回数据 */
        $result = [
            "code"  => 1,
            "state" => "SUCCESS",
            "list"  => $list,
            "start" => $start,
            "total" => count($files),
        ];

        return $result;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param string $path       文件路径
     * @param string $allowFiles 指定的文件后缀,以|分隔的文本
     * @param array  $files      文件数组
     * @return array
     */
    private function getFiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) {
            return [];
        }
        if (substr($path, strlen($path) - 1) != '/') {
            $path .= '/';
        }

        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getFiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                        $files[] = array(
                            'url'   => preg_replace('/(.*)upload/i', '/upload', $path2),
                            'mtime' => filemtime($path2),
                        );
                    }
                }
            }
        }

        return $files;
    }

    /**
     * 拉取远程图片
     * @return mixed
     */
    private function saveRemote($config, $fieldName)
    {
        $imgUrl = htmlspecialchars($fieldName);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);

        // http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            return [
                'code' => 0,
                'msg'  => '链接不是http|https链接',
                'url'  => '',
            ];
        }
        // 获取请求头并检测死链
        $heads = get_headers($imgUrl, true);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            return [
                'code' => 0,
                'msg'  => '链接不可用',
                'url'  => '',
            ];
        }
        // 格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr(strrchr($imgUrl, '/'), '.'));
        $fileType = ltrim($fileType, '.');
        // img链接后缀可能为空,Content-Type须为image
        if ((!empty($fileType) && !in_array($fileType, $config['allowFiles'])) || stristr($heads['Content-Type'], "image") === -1) {
            return [
                'code' => 0,
                'msg'  => '链接contentType不正确',
                'url'  => '',
            ];
        }

        // 解析出域名作为http_referer
        $urlArr      = explode('/', $imgUrl);
        $protocol    = str_replace(':', '', $urlArr[0]);
        $httpReferer = $protocol . ':' . '//' . $urlArr[2];

        // 打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create([
            'http' => array(
                //'header' => "Referer:$httpReferer",  //突破防盗链,不可用
                'user_agent'      => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', //突破防盗链
                'follow_location' => false,                                                                                                                // don't follow redirects
            ),
        ]);
        $res     = false;
        $message = '';
        try {
            $res = readfile($imgUrl, false, $context);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $img = ob_get_contents();
        ob_end_clean();

        if ($res === false) {
            return [
                'code' => 0,
                'msg'  => $message,
                'url'  => '',
            ];
        }

        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $fileName);

        $dirname          = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . date('Ymd') . DIRECTORY_SEPARATOR;
        $file['oriName']  = $fileName ? $fileName[1] : "";
        $file['filesize'] = strlen($img);
        $file['ext']      = strtolower(strrchr($config['oriName'], '.'));
        $file['name']     = uniqid() . $file['ext'];
        $file['fullName'] = $dirname . $file['name'];
        $fullName         = $file['fullName'];

        // 检查文件大小是否超出限制
        if ($config["maxSize"] > 0 && $file['filesize'] >= $config["maxSize"] * 1024) {
            return [
                'code' => 0,
                'msg'  => '文件大小超出网站限制',
                'url'  => '',
            ];
        }

        // 创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            return [
                'code' => 0,
                'msg'  => '目录创建失败',
                'url'  => '',
            ];
        } else if (!is_writeable($dirname)) {
            return [
                'code' => 0,
                'msg'  => '目录没有写权限',
                'url'  => '',
            ];
        }

        // 移动文件
        if (!(file_put_contents($fullName, $img) && file_exists($fullName))) {
            return [
                'code' => 0,
                'msg'  => '写入文件内容错误',
                'url'  => '',
            ];
        }
        // 移动成功
        $data = array(
            'code'     => 1,
            'state'    => 'SUCCESS',
            'url'      => '/uploads/' . date('Ymd') . '/' . $file['name'],
            'title'    => $file['name'],
            'original' => $file['oriName'],
            'type'     => $file['ext'],
            'size'     => $file['filesize'],
        );
        return $data;
    }

}
