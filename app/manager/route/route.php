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
Route::rule('adminList', '/manager/admin/indexList');   #默认打开页面

// 角色路由
Route::rule('roleList', '/manager/role/indexList');   #默认打开页面

// test 页面路由
Route::rule('testList', '/manager/test/indexList');   #默认打开页面

// order 页面路由
Route::group(function () {
    Route::rule('orderList', '/manager/order/indexList');   #order
    Route::rule('orderNotifyList', '/manager/ordernotify/indexList');   #ordernotify
});

// category 页面路由
Route::group(function () {
    Route::rule('categoryList', '/manager/category/indexList');   #默认打开页面
});

// user 会员
Route::group(function () {
    Route::rule('userList', 'manager/user/indexList');
});

// goods 会员
Route::group(function () {
    Route::rule('goodsList', 'manager/goods/indexList');
});

// banner 轮播图
Route::group(function () {
    Route::rule('bannerList', 'manager/banner/indexList');
    Route::rule('bannerUpload', 'manager/banner/upload');
});

// banner 轮播图
Route::group(function () {
    Route::rule('articlecategory', 'articlecategory/indexList');
    Route::rule('articlelist', 'articlelist/indexList');
    Route::rule('articleadd', 'articlelist/addView');
    Route::rule('articleaddY', 'articlelist/addY');
    Route::rule('articleedit', 'articlelist/editView');
    Route::rule('articleeditY', 'articlelist/editY');
});

// 此模块全局 miss 路由
Route::miss(function() {
    return '404 Not Found!';
});
