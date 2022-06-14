<?php
use think\facade\Route;
use app\home\middleware\Access;

Route::rule("/","/home/index/index");
Route::rule("/category/:id","/home/category/index");
Route::rule("/goods/:id","/home/goods/index");

Route::rule("/signup","/home/signup/index");
Route::rule("/signin","/home/signin/index");
Route::rule("/signout","/home/signin/signOut");

Route::rule("/cart","/home/cart/index");

Route::group(function() {
    Route::rule("/user","/home/user/index");
    Route::rule("/info","/home/user/info");
    Route::rule("/done","/home/cart/done");
    Route::rule("/order","/home/order/index");
})->middleware(Access::class);

Route::rule("/t", "/home/test/index");


// 此模块全局 miss 路由
Route::miss(function() {
    return '404 Not Found!';
});

