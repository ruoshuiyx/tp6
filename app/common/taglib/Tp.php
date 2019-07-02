<?php
/**
 * +----------------------------------------------------------------------
 * | 自定义标签
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/28
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
namespace app\common\taglib;

use think\template\TagLib;

class Tp extends TagLib {

    protected $tags = array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'close'     => ['attr' => 'time,format', 'close' => 0],                           //闭合标签，默认为不闭合
        'open'      => ['attr' => 'name,type', 'close' => 1],
        'nav'       => ['attr' => 'id,limit', 'close' => 1],                              //通用导航信息
        'cate'      => ['attr' => 'id,type','close' => 0],                                //通用栏目信息
        'position'  => ['attr' => 'name','close' => 1],                                   //通用位置信息
        'link'      => ['attr' => 'name','close' => 1],                                   //获取友情链接
        'ad'        => ['attr' => 'name,type,id','close' => 1],                           //获取广告信息
        'debris'    => ['attr' => 'name,type','close' => 0],                              //获取碎片信息
        'list'      => ['attr' => 'id,name,pagesize,where,limit,order','close' => 1],     //通用列表
        'search'    => ['attr' => 'search,table,name,pagesize,where,order','close' => 1], //通用搜索
        'tag'       => ['attr' => 'name,pagesize,order','close' => 1],                    //通用标签
        'prev'	    => ['attr'	=> 'len','close' => 0],                                   //上一篇
        'next'	    => ['attr'	=> 'len','close' => 0],                                   //下一篇
    );

    // 这是一个闭合标签的简单演示
    public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time   = empty($tag['time'])   ? time()        : $tag['time'];
        $parse  = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }

    // 这是一个非闭合标签的简单演示
    public function tagOpen($tag, $content)
    {
        $type   = empty($tag['type']) ? 0 : 1; // 这个type目的是为了区分类型，一般来源是数据库
        $name   = $tag['name']; // name是必填项，这里不做判断了
        $parse  = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 通用导航信息
    Public function tagNav($tag, $content)
    {
        $tag['limit'] = isset($tag['limit']) ? $tag['limit'] : '0';
        $tag['id']    = isset($tag['id'])    ? $tag['id']    : '';
        $name         = isset($tag['name'])  ? $tag['name']  : 'nav';

        if (!empty($tag['id'])) {
            $catestr  = '$__CATE__ = \think\facade\Db::name(\'cate\')->where(\'is_menu\',1)->order(\'sort ASC,id DESC\')->select();';
            $catestr .= '$__LIST__ = getChildsOn($__CATE__,' . $tag['id'] . ');';
        } else {
            $catestr  = '$__CATE__ = \think\facade\Db::name(\'cate\')->where(\'is_menu\',1)->order(\'sort ASC,id DESC\')->select();';
            $catestr .= '$__LIST__ = unlimitedForLayer($__CATE__);';
        }
        //提取前N条数据,因为sql的LIMIT避免不了子栏目的问题
        if (!empty($tag['limit'])) {
            $catestr .= '$__LIST__ = array_slice($__LIST__, 0,' . $tag['limit'] . ');';
        }
        $parse  = '<?php ';
        $parse .= $catestr;
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 通用栏目信息
    Public function tagCate($tag)
    {
        $id   = isset($tag['id']) ? $tag['id']   : getCateId();
        $type = $tag['type']      ? $tag['type'] : 'catname';

        $str  = '<?php ';
        $str .= '$__CATE__ = \think\facade\Db::name("cate")->where("id",' . $id . ')->find();';
        $str .= 'if (is_array($__CATE__)) { ';
        $str .= '$__CATE__[\'url\'] = getUrl($__CATE__);';
        $str .= 'echo $__CATE__[\'' . $type . '\'];';
        $str .= '}';
        $str .= '?>';
        return $str;
    }

    // 通用位置信息
    Public function tagPosition($tag, $content)
    {
        $name = $tag['name'] ? $tag['name'] : 'position';
        $parse  = '<?php ';
        $parse .= '$__CATE__   = \think\facade\Db::name(\'cate\')->select();';
        $parse .= '$__CATEID__ = getCateId();';
        $parse .= '$__LIST__   = getParents($__CATE__,$__CATEID__);';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= '<?php $' . $name . '[\'url\']=getUrl( $' . $name . '); ?>';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 获取友情链接
    Public function tagLink($tag, $content)
    {
        $name = $tag['name'] ? $tag['name'] : 'link';
        $parse = '<?php ';
        $parse .= '$__LIST__ = \think\facade\Db::name(\'link\')->where(\'status\',1)->order(\'sort ASC,id desc\')->select();';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 获取广告信息
    Public function tagAd($tag, $content)
    {
        $name = isset($tag['name']) ? $tag['name'] : 'ad';
        $type = isset($tag['type']) ? $tag['type'] : '';
        $id   = isset($tag['id'])   ? $tag['id']   : '';
        $parse = '<?php ';
        $parse .= '
            $__WHERE__ = array();
            if (!empty(\'' . $id . '\')) {
                $__WHERE__[] = [\'a.type_id\', \'=\', ' . $id . '];
            }
            if (!empty(\'' . $type . '\')) {
                $__WHERE__[] = [\'at.name\', \'=\', \'' . $type . '\'];
            }';
        $parse .= '
            $__LIST__ = \think\facade\Db::name(\'ad\')
            ->alias(\'a\')
            ->leftJoin(\'ad_type at\',\'a.type_id = at.id\')
            ->field(\'a.*,at.name as type_name\')
            ->where($__WHERE__)
            ->order(\'a.sort ASC,a.id desc\')
            ->select();';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 通用碎片信息
    Public function tagDebris($tag)
    {
        $name = $tag['name'] ? $tag['name'] : '';
        $type = $tag['type'] ? $tag['type'] : '';
        $str  = '<?php ';
        $str .= 'echo \think\facade\Db::name("debris")->where("name",\'' . $name . '\')->value("' . $type . '");';
        $str .= '?>';
        return $str;
    }

    // 通用列表
    Public function tagList($tag, $content)
    {
        $id       = isset($tag['id'])       ? $tag['id']                         : getCateId();             //可以为空
        $name     = isset($tag['name'])     ? $tag['name']                       : "list";                  //不可为空
        $order    = isset($tag['order'])    ? $tag['order']                      : 'sort ASC,id DESC';      //排序
        $limit    = isset($tag['limit'])    ? $tag['limit']                      : '0';                     //多少条数据,传递时不再进行分页
        $where    = isset($tag['where'])    ? $tag['where'] . ' AND status = 1 ' : 'status = 1';            //查询条件
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize']                   : config('app.page_size'); //每页数量
        $parse  = '<?php ';
        $parse .= '
            //查找栏目对应的表信息
            $__TABLE_=\think\facade\Db::name(\'cate\')
                ->alias(\'a\')
                ->leftJoin(\'module m\',\'a.moduleid = m.id\')
                ->field(\'a.id,a.moduleid,a.pagesize,a.catname,m.name as modulename,m.listfields\')
                ->where(\'a.id\',\'=\',' . $id . ')
                ->find();
            //获取表名称
            $__TABLENAME_ = $__TABLE_[\'modulename\'];
            //获取模型ID
            $__MODULEID__ = $__TABLE_[\'moduleid\'];
            //获取模型列表页字段
            $__LISTFIELDS__ = $__TABLE_[\'listfields\'];
            //查询子分类,列表要包含子分类内容
            $__ALLCATE__ = \think\facade\Db::name(\'cate\')
                ->field(\'id,parentid\')
                ->select();
            $__IDS__ = getChildsIdStr(getChildsId($__ALLCATE__,' . $id . '),' . $id . ');

            //表名称为空时（id不存在）直接返回空数组
            if (!empty($__TABLENAME_)) {
                //当传递limit时，不再进行分页
                if(' . $limit . '!=0){
                    $__LIST__ = \think\facade\Db::name($__TABLENAME_)
                        ->where("' . $where . '")
                        ->where(\'cate_id\', \'in\', $__IDS__)
                        ->field($__LISTFIELDS__)
                        ->order(\'' . $order . '\')
                        ->limit(\'' . $limit . '\')
                        ->select();
                    $page = \'\';
                }else{
                    $__TABLE_[\'pagesize\'] = empty($__TABLE_[\'pagesize\'])?' . $pagesize . ':$__TABLE_[\'pagesize\'];
                    $__LIST__ = \think\facade\Db::name($__TABLENAME_)
                        ->where("' . $where . '")
                        ->where(\'cate_id\', \'in\', $__IDS__)
                        ->field($__LISTFIELDS__)
                        ->order(\'' . $order . '\')
                        ->paginate($__TABLE_[\'pagesize\'], false, [\'query\' => request()->param()]);
                    $page = $__LIST__->render();
                }
                //处理数据（把列表中需要处理的字段转换成数组和对应的值）
                $__LIST__ = changeFields($__LIST__, $__MODULEID__);
            }else{
                $__LIST__ = [];
            }
            ';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 通用搜索
    Public function tagSearch($tag, $content)
    {
        $search   = isset($tag['search'])   ? $tag['search']                     : "";                      //关键字
        $table    = isset($tag['table'])    ? $tag['table']                      : "article";               //表名称
        $name     = isset($tag['name'])     ? $tag['name']                       : "list";                  //不可为空
        $order    = isset($tag['order'])    ? $tag['order']                      : 'sort ASC,id DESC';      //排序
        $where    = isset($tag['where'])    ? $tag['where'] . ' AND status = 1 ' : 'status = 1';            //查询条件
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize']                   : config('app.page_size'); //分页条数

        $parse  = '<?php ';
        $parse .= '
                $__MODULEID__ = \think\facade\Db::name("module")->where("name","' . $table . '")->value("id");
                $__LIST__ = \think\facade\Db::name("' . $table . '")
                    ->order("' . $order . '")
                    ->where("' . $where . '")
                    ->where("title", "like", "%' . $search . '%")
                    ->paginate("' . $pagesize . '",false,[\'query\' => request()->param()]);
                $page = $__LIST__->render();

                //处理数据（把列表中需要处理的字段转换成数组和对应的值）
                $__LIST__ = changeFields($__LIST__,$__MODULEID__);
            ';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 通用TAG标签
    Public function tagTag($tag, $content)
    {
        $name     = isset($tag['name'])     ? $tag['name']     : "list";                  //不可为空
        $order    = isset($tag['order'])    ? $tag['order']    : 'sort ASC,id DESC';      //排序
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize'] : config('app.page_size'); //分页条数

        $parse = '<?php ';
        $parse .= '
                //获取模型ID
                $__MODULEID__ = request()->param(\'module\');
                //获取搜索词
                $__T__ = request()->param(\'t\');
                //查询模型的表名称
                $__MODULENAME__ = \think\facade\Db::name(\'module\')
                    ->where(\'id\', $__MODULEID__)
                    ->value(\'name\');
                //查询搜索词对应的ID
                $__TAGID__ = \think\facade\Db::name(\'tags\')
                    ->where(\'module_id\', $__MODULEID__)
                    ->where(\'name\', $__T__)
                    ->value(\'id\');
                //查询tag字段名称
                $__TAGFIELD__ = \think\facade\Db::name(\'field\')
                    ->where(\'moduleid\', $__MODULEID__)
                    ->where(\'type\', \'tag\')
                    ->value(\'field\');

                $__LIST__ = \think\facade\Db::name($__MODULENAME__)
                ->order("' . $order . '")
                ->where($__TAGFIELD__, "find in set", $__TAGID__)
                ->paginate("' . $pagesize . '");
                $page = $__LIST__->render();

                //处理数据（把列表中需要处理的字段转换成数组和对应的值）
                $__LIST__ = changeFields($__LIST__,$__MODULEID__);
            ';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    // 详情上一篇
    Public function tagPrev($tag)
    {
        $len = $tag['len'] ? $tag['len'] : '500';
        $str = '<?php ';
        $str .= '
                $__CATEID__ = getCateId();
                //查找表名称
                $__TABLENAME__ = \think\facade\Db::name(\'cate\')
                    ->alias(\'c\')
                    ->leftJoin(\'module m\',\'c.moduleid = m.id\')
                    ->field(\'m.name as table_name\')
                    ->where(\'c.id\',$__CATEID__)
                    ->find();
                //根据ID查找上一篇的信息
                $__PREV__ = \think\facade\Db::name($__TABLENAME__[\'table_name\'])
                    ->where(\'cate_id\',$__CATEID__)
                    ->where(\'id\',\'<\',input(\'id\'))
                    ->where(\'status\',\'=\',1)
                    ->field(\'id,cate_id,title\')
                    ->order(\'sort ASC,id DESC\')
                    ->find();
                if($__PREV__){
                    //处理字数
                    if(' . $len . '<>500){
                       $__PREV__[\'title\'] = mb_substr($__PREV__[\'title\'],0,' . $len . ');
                    }
                    //处理上一篇中的URL
                    $__PREV__[\'url\'] = getShowUrl($__PREV__);
                    $__PREV__ = "<a class=\"prev\" title=\" ".$__PREV__[\'title\']." \" href=\" ".$__PREV__[\'url\']." \">".$__PREV__[\'title\']."</a>";
                }else{
                    $__PREV__ = "<a class=\"prev_no\" href=\"javascript:;\">暂无数据</a>";
                }
                echo $__PREV__;
                ';
        $str .= '?>';
        return $str;
    }

    // 详情下一篇
    Public function tagNext($tag)
    {
        $len = $tag['len'] ? $tag['len'] : '500';

        $str = '<?php ';
        $str .= '
                $__CATEID__ = getCateId();
                //查找表名称
                $__TABLENAME__ = \think\facade\Db::name(\'cate\')
                    ->alias(\'c\')
                    ->leftJoin(\'module m\',\'c.moduleid = m.id\')
                    ->field(\'m.name as table_name\')
                    ->where(\'c.id\',$__CATEID__)
                    ->find();
                //根据ID查找下一篇的信息
                $__PREV__ = \think\facade\Db::name($__TABLENAME__[\'table_name\'])
                    ->where(\'cate_id\',$__CATEID__)
                    ->where(\'id\',\'>\',input(\'id\'))
                    ->where(\'status\',\'=\',1)
                    ->field(\'id,cate_id,title\')
                    ->order(\'sort ASC,id DESC\')
                    ->find();
                if($__PREV__){
                    //处理字数
                    if(' . $len . '<>500){
                       $__PREV__[\'title\'] = mb_substr($__PREV__[\'title\'],0,' . $len . ');
                    }
                    //处理下一篇中的URL
                    $__PREV__[\'url\'] = getShowUrl($__PREV__);
                    $__PREV__ = "<a class=\"next\" title=\" ".$__PREV__[\'title\']." \" href=\" ".$__PREV__[\'url\']." \">".$__PREV__[\'title\']."</a>";
                }else{
                    $__PREV__ = "<a class=\"next_no\" href=\"javascript:;\">暂无数据</a>";
                }
                echo $__PREV__;
                ';
        $str .= '?>';
        return $str;
    }


}