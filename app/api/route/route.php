<?php
use think\facade\Route;


// index
Route::group(function () {
    Route::rule("banner","index/getBanner");
    Route::rule("hotGoods","index/hotGoods");
    Route::rule("killGoods","index/killGoods");
    Route::rule("goodsDetail","index/goodsDetail");
    Route::rule("goodsList","index/goodsList");
    Route::rule("cart","index/cart");
    Route::rule("addCart","index/addCart");
    Route::rule("updateCart","index/updateCart");
    Route::rule("deleteCart","index/deleteCart");
    Route::rule("cartToOrder","index/cartToOrder");
    Route::rule("signin","index/signin");
    Route::rule("signup","index/signup");
    Route::rule("user","index/user");
    Route::rule("editUser","index/editUser");
    Route::rule("order","index/order");    
    Route::rule("orderDetail","index/orderDetail");
    Route::rule("address","index/address");
    Route::rule("getAddress","index/getAddress");
    Route::rule("addAddress","index/addAddress");
    Route::rule("editAddress","index/editAddress");
    Route::rule("category","index/category");
    Route::rule("categoryGoods","index/categoryGoods");
    Route::rule("notify","index/notify");
    Route::rule("pay","alipay/pay");
    Route::rule("ypay","ypay/index");
    Route::rule("ypayNotify","ypay/notify");
})->allowCrossDomain();

Route::rule("jwt","index/jwt");
Route::rule("test","index/test");



// 此模块全局 miss 路由
Route::miss(function() {
    return '404 Not Found!';
});
