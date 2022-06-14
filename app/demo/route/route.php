<?php
use think\facade\Route;


// 测试路由
Route::group(function () {
    Route::rule("notify","test/testNotify");
    Route::rule("test","test/index");
    Route::rule("caiji","test/caiji");
    Route::rule("jctest","jctest/index");
    Route::rule("delay","jctest/delay");
});


// 此模块全局 miss 路由
Route::miss(function() {
    return '404 Not Found!';
});
