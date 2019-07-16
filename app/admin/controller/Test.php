<?php

namespace app\admin\controller;

use app\common\model\Tags;
use think\facade\Db;

class Test
{

    //列表
    public function index()
    {
        $sql = 'INSERT INTO `tp_article` (`id`, `cate_id`, `title`, `title_style`, `thumb`, `keywords`, `description`, `content`, `template`, `status`, `sort`, `hits`, `create_time`, `update_time`, `image`, `images`, `download`, `author`, `source`, `summary`, `tags`) VALUES (NULL, \'13\', \'PHP是什么\', \'\', \'\', \'\', \'\', \'<p>PHP（外文名:PHP: Hypertext Preprocessor，中文名：&ldquo;超文本预处理器&rdquo;）是一种通用开源脚本语言。语法吸收了C语言、Java和Perl的特点，利于学习，使用广泛，主要适用于Web开发领域。</p>\r\n\r\n<p>用PHP做出的动态页面与其他的编程语言相比，PHP是将程序嵌入到HTML（标准通用标记语言下的一个应用）文档中去执行，执行效率比完全生成HTML标记的CGI要高许多；PHP还可以执行编译后代码，编译可以达到加密和优化代码运行，使代码运行更快。</p>\r\n\r\n<p>全球市场分析</p>\r\n\r\n<p>目前PHP在全球网页市场、手机网页市场还有为手机提供API（程序接口）排名第一。</p>\r\n\r\n<p>在中国微信开发大量使用PHP来进行开发。</p>\r\n\r\n<p>北京、上海的用人需求</p>\r\n\r\n<p style=\"text-align: center;\">上海2016年11月份中某一天用人低峰的招聘量：</p>\r\n\r\n<p style=\"text-align: center;\"><img alt=\"2.png\" src=\"/uploads/ueditor/image/20181224/1545620471.png\" title=\"1545620471.png\" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align: center;\">北京2016年11月份中某一天用人低峰的招聘量：</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align: center;\"><img alt=\"1.png\" src=\"/uploads/ueditor/image/20181224/1545620478.png\" title=\"1545620478.png\" /></p>\r\n\', \'\', \'1\', \'100\', \'52\', \'1540451280\', \'0\', \'/uploads/20181224/fc3112ab0fab9f255726674dc1fd0d17.jpg\', \'[{\"image\":\"\\/uploads\\/20181025\\/0138d7987d3e56758ab4d49c57002401.jpg\",\"title\":\"3.jpg\"}]\', \'\', \'未知\', \'php中文网\', \'PHP（外文名:PHP: Hypertext Preprocessor，中文名：“超文本预处理器”）是一种通用开源脚本语言。语法吸收了C语言、Java和Perl的特点，利于学习，使用广泛，主要适用于Web开发领域。\', \'1\')';

        for ($i = 0; $i < 200000; $i++) {
            Db::execute($sql);
        }


        return 'ok';
        //exit;




        $a = url('index/index/tag', ['module'=>2, 't'=>'钢笔'])->__toString();
        halt($a);

        $arr = Tags::where('id', 'IN', '5,6,7')
            ->select()->toArray();
        dump($arr);

        /*$

        Tags::where('module_id', $list[0]['moduleid'])
                            ->where('id', 'IN', $tagsInsertStr)
                            ->inc('num')
                            ->fetchSql(true)
                            ->update();

        dump($arr);*/


        //$result = make_html_add('title', 'title', '标题', 1, '注意最多字数', '');
        //return $result;
    }


}
