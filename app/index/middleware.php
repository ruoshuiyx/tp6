<?php
// 应用中间件定义文件

if (env('route.request_cache_key', false) !== false) {
    return [
        // 应用请求缓存
        \think\middleware\CheckRequestCache::class,
    ];
} else {
    return [];
}
