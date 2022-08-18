<?php
use think\facade\Route;

// 登陆路由
Route::group(function () {
    Route::rule("/login","manager/login/index");
    Route::rule("/asyncLogin","manager/login/login");
    Route::rule("/asyncLogout","manager/login/logout");
});


// 首页路由
Route::group(function () {
    Route::rule("/index","manager/index/index");
    Route::rule("/layuiTree","manager/index/layuiTree");
    Route::rule("/home","manager/index/home");
});

// 菜单路由
Route::rule("/menu","manager/node/menuJson");

// 管理员路由
Route::rule('adminList', 'manager/admin/indexList');   #默认打开页面


// 角色路由
Route::rule('roleList', 'manager/role/indexList');   #默认打开页面


// test 页面路由
Route::rule('testList', 'manager/test/indexList');   #默认打开页面


// 此模块全局 miss 路由
Route::miss(function() {
    return '404 Not Found!';
});
