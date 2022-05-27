<?php
// +----------------------------------------------------------------------
// | 路由设置
// +----------------------------------------------------------------------

return [
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache_key'    => env('route.request_cache_key', false),

    // 请求缓存有效期（秒）
    'request_cache_expire' => env('route.request_cache_expire', 3600),

    // 请求缓存排除规则（不区分大小写）
    'request_cache_except' => [
        '/index/add',     // 留言/投稿
        '/index/captcha', // 验证码
        '/user/',         // 用户中心
    ],
];
