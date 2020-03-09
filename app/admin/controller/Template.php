<?php
/**
 * +----------------------------------------------------------------------
 * | 模板控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/06
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

use think\facade\Request;
use think\facade\View;

// 引入表格构建器
use app\common\builder\TableBuilder;

class Template extends Base
{
    protected $public,$template_path,$template_html,$template_css,$template_js,$template_img,$upload_path;

    // 默认开启备份功能
    protected $templateOpening = true;

    function initialize()
    {
        parent::initialize();
        // 查找所有系统设置表数据
        $system = \app\common\model\System::find(1);
        $this->public       = '/template/' .
            $system['template'] .
            '/' .
            'index' .
            '/';
        $this->template_path =
            '.'.$this->public;
        $this->template_html = $system['html'];
        $this->template_css  = 'css';
        $this->template_js   = 'js';
        $this->template_img  = 'img';

        $initialize = [
            'html' => $this->template_html, // 自定义html目录
            'css'  => $this->template_css,  // 自定义css目录
            'js'   => $this->template_js,   // 自定义js目录
            'img'  => $this->template_img,  // 自定义媒体文件目录
        ];
        View::assign($initialize);

        // 查找是否开启了模板修改备份功能
        $this->templateOpening = $system['template_opening'];
    }

    // 列表
    public function index(string $type = 'html'){
        if ($type == 'html') {
            $path = $this->template_path . $this->template_html . DIRECTORY_SEPARATOR;
        } else {
            $path = $this->template_path . $type . DIRECTORY_SEPARATOR;
        }

        // 设置主键
        $pk = 'id';
        // 字段信息
        $coloumns = [
            ['id'  , '文件名称'],
            ['filepath'  , '目录'],
            ['filesize'  , '文件大小'],
            ['filemtime' , '更新时间', '', '', '', '', 'true'],
            ['ext', '后缀'],
        ];
        $files = dir_list($path, $type);
        $list = [];
        foreach ($files as $key => $file){
            $filename = basename($file);
            //$list[$key]['value']     = substr($filename, 0, strrpos($filename, '.'));
            $list[$key]['id']  = $filename;
            $list[$key]['filepath']  = $file;
            $list[$key]['filesize']  = format_bytes(filesize($file));
            $list[$key]['filemtime'] = date('Y-m-d H:i:s', filemtime($file));
            $list[$key]['ext']       = strtolower(substr($filename, strrpos($filename, '.') - strlen($filename)));
        }
        // 搜索
        if (Request::param('getList') == 1) {
            // 排序规则
            $orderByColumn = Request::param('orderByColumn') ?? $pk;
            $isAsc = Request::param('isAsc') ?? 'desc';
            $isAsc = $isAsc == 'desc' ? SORT_DESC : SORT_ASC;
            // 排序处理
            $date = array_column($list, $orderByColumn);
            array_multisort($date, $isAsc, $list);
            // 渲染输出
            $result = [
                'total'        => count($list),
                'per_page'     => 1000,
                'current_page' => 1,
                'last_page'    => 1,
                'data'         => $list,
            ];
            return $result;
        }

        // 获取头部切换按钮
        $pageTips = $this->getPageTips($type);

        // 构建页面
        return TableBuilder::getInstance()
            ->setUniqueId($pk)                              // 设置主键
            ->addColumns($coloumns)                         // 添加列表字段数据
            ->setPageTips($pageTips, 'success', 'search')   // 提示信息
            ->setPagination('false')                        // 关闭分页显示
            ->addColumn('right_button', '操作', 'btn')
            ->addRightButton('edit', ['href'  => (string)url('edit', ['id' => '__id__','type' => $type])])
            ->addRightButton('delete')
            ->addTopButtons(['add', 'edit', 'del'])         // 设置顶部按钮组
            ->setEditUrl((string)url('edit', ['id' => '__id__','type' => $type]))
            ->setDelUrl((string)url('del', ['id' => '__id__','type' => $type]))
            ->setDataUrl(url('index', ['getList' => '1', 'type' => $type]))
            ->fetch();
    }

    // 添加
    public function add(){
        $type=  Request::param('type') ? Request::param('type') : 'html';

        $view = [
            'type'  => $type,        //当前显示的类型
            'info'  => null,         //加载数据
        ];
        View::assign($view);
        return View::fetch();
    }

    // 添加保存
    public function addPost(){
        if (Request::isPost()) {
             $filename = $this->checkFilename(Request::post('filename'));
            $type     = Request::param('type') ? Request::param('type') : 'html';
            if ($type == 'html') {
                $path = $this->template_path.$this->template_html.'/';
            } else {
                $path = $this->template_path.$type.'/';
            }
            $file = $path.$filename.'.'.$type;
            if (file_exists($file)) {
                $this->error('文件已经存在!');
            } else {
                file_put_contents($file,stripslashes(input('post.content')));
                if ($type=='html') {
                    $this->success('添加成功!',url('index', ['type' => 'html']));
                } else {
                    $this->success('添加成功!',url('index', ['type' => $type]));
                }
            }
        }
    }

    // 修改
    public function edit(string $id){
        $type     = Request::param('type') ? Request::param('type') : 'html';
        if ($type == 'html') {
            $path = $this->template_path.$this->template_html.'/';
        } else {
            $path = $this->template_path.$type.'/';
        }
        $file = $path.$id;
        if (file_exists($file)) {
            $file = iconv('gb2312','utf-8',$file);
            $content = file_get_contents($file);
            $info = [
                'filename' => $id,
                'file'     => $file,
                'content'  => $content,
                'type'     => $type
            ];
        } else {
            $this->error('文件不存在！');
        }
        $view = [
            'info' => $info,
            'type' => $type,//当前显示的类型
        ];
        View::assign($view);
        return View::fetch('add');
    }

    // 修改保存
    public function editPost(){
        if (Request::isPost()) {
             $filename = $this->checkFilename(Request::post('filename'));
            $type     = Request::param('type') ? Request::param('type') : 'html';
            if ($type == 'html') {
                $path = $this->template_path.$this->template_html.'/';
            } else {
                $path = $this->template_path.$type.'/';
            }
            $file = $path . $filename;
            if (file_exists($file)) {
                //判断是否有写入权限
                if (!is_writable($file)) {
                    $this->error('无写入权限!');
                }

                //备份文件(防止出错)
                if ($this->templateOpening) {
                    //设置备份文件名
                    $newFile = $path . str_replace('.' ,'_back-'.date("Y-m-d_H-i-s").'.', $filename);
                    //执行复制操作
                    copy($file,$newFile);
                }

                if (false !== file_put_contents($file,stripslashes(input('content')))){
                    if ($type == 'html') {
                        $this->success('修改成功!',url('index', ['type' => 'html']));
                    } else {
                        $this->success('修改成功!',url('index', ['type' => $type]));
                    }
                }else{
                    $this->error('修改失败!');
                }
            } else {
                $this->error('文件不存在!');
            }
        }
    }

    // 删除
    public function del(string $id, string $type)
    {
        $id = $this->checkFilename($id);
        if (strpos($id, ',') !== false) {
            return $this->selectDel($id, $type);
        }
        //删除文件
        if ($type == 'html') {
            $path = $this->template_path . $this->template_html . '/';
        } else {
            $path = $this->template_path . $type . '/';
        }
        $file = $path . $id;
        if (file_exists($file)) {
            unlink($file);
            return ['error'=>0,'msg'=>'删除成功!'];
        } else {
            return ['error'=>1,'msg'=>'删除失败!'];
        }
    }

    // 批量删除
    public function selectDel(string $id, string $type)
    {
        $type = $this->checkFilename($type);
        if (Request::isPost()) {
            $ids = explode(',', $id);
            if ($type == 'html') {
                $path = $this->template_path . $this->template_html . '/';
            } else {
                $path = $this->template_path . $type . '/';
            }
            foreach ($ids as $k => $v) {
                $v = $this->checkFilename($v);
                //删除文件
                $file = $path . $v;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            return ['error'=>0,'msg'=>'删除成功!'];
        }
    }

    // 媒体文件
    public function img(){
        $path = $this->template_path.$this->template_img.'/'.Request::param('folder');
        $folder = Request::param('folder') ? Request::param('folder') : '';
        $uppath = explode('/',Request::param('folder'));
        $leve = count($uppath)-1;
        unset($uppath[$leve]);
        if ($leve>1) {
            unset($uppath[$leve-1]);
            $uppath = implode('/',$uppath).'/';
        } else {
            $uppath = '';
        }

        $files = glob($path.'*');
        $folders = $templates = array();
        foreach ($files as $key => $file) {
            $filename = basename($file);
            if (is_dir($file)) {
                $folders[$key]['filename'] = $filename;
                $folders[$key]['filepath'] = $file;
                $folders[$key]['ext']      = 'folder';
            } else {
                $templates[$key]['filename'] = $filename;
                $templates[$key]['filepath'] = ltrim($file,'.') ;
                $templates[$key]['ext']      = strtolower(substr($filename,strrpos($filename, '.')-strlen($filename)+1));
                if (!in_array($templates[$key]['ext'], array('gif','jpg','png','bmp'))) {
                    $templates[$key]['ico'] =1;
                }
            }
        }
        $view = [
            'folder'  => $folder,
            'leve'    => $leve,
            'uppath'  => $uppath,
            'path'    => $path,               //路径
            'folders' => $folders,            //文件夹
            'files'   => $templates,          //文件
            'type'    => $this->template_img, //当前显示的类型
        ];
        View::assign($view);
        return View::fetch();
    }

    // 媒体文件删除
    public function imgDel(){
        $path = $this->template_path . $this->template_img . '/' . Request::post('folder');
        $file = $path . $this->checkFilename(Request::post('filename'));

        if (file_exists($file)) {
            is_dir($file) ? dir_delete($file) : unlink($file);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        } else {
            return json(['error'=>1, 'msg'=>'文件不存在!']);
        }
    }

    /**
     * 获取头部切换按钮
     * @param string $type
     * @return string
     */
    private function getPageTips(string $type)
    {
        $html = $type == 'html' ? 'btn-warning' : '';
        $css  = $type == 'css'  ? 'btn-warning' : '';
        $js   = $type == 'js'   ? 'btn-warning' : '';
        $img  = $type == 'img'  ? 'btn-warning' : '';

        $pageTips = '
            <a class="btn btn-flat btn-primary m_l_0 ' . $html . '" href="/admin/Template/index.html?type=html">html</a>
            <a class="btn btn-flat btn-primary m_10 ' . $css . '" href="/admin/Template/index.html?type=css">css</a>
            <a class="btn btn-flat btn-primary m_10 ' . $js . '" href="/admin/Template/index.html?type=js">js</a>
            <a class="btn btn-flat btn-primary m_10 ' . $img . '" href="/admin/Template/img.html?type=img\'">媒体文件</a>
        ';
        return $pageTips;
    }

    // 过滤文件名
    private function checkFilename($fileName)
    {
        $fileName = str_replace("/", "", $fileName);
        $fileName = str_replace("..", "", $fileName);
        $fileName = str_ireplace(".php", ".html", $fileName);
        return $fileName;
    }
}
