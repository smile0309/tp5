<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];

use think\Route;
//定义路由规则
//后台首页路由
Route::get("/","admin/index/index");
Route::get("top","admin/index/top");
Route::get("left","admin/index/left");
Route::get("main","admin/index/main");

//登录页
Route::any("login","admin/public/login");
//退出页
Route::get("logout","admin/public/logout");

//
Route::group('admin',function(){
	//新增分类路由
	Route::get("category/add","admin/category/add");
	Route::post("category/add","admin/category/add");
	//分类列表路由
	Route::get("category/index","admin/category/index");
	Route::post("category/index","admin/category/index");
	//分类列表编辑路由
	Route::get("category/upd","admin/category/upd");
	Route::post("category/upd","admin/category/upd");
	//ajax请求删除分类数据
	Route::get("category/ajaxDel","admin/category/ajaxDel");
	//添加文章路由
	Route::get("article/add","admin/article/add");
	Route::post("article/add","admin/article/add");
	//文章列表路由
	Route::get("article/index","admin/article/index");
	Route::post("article/index","admin/article/index");
	//文章列表编辑路由
	Route::get("article/upd","admin/article/upd");
	Route::post("article/upd","admin/article/upd");
	//ajax请求删除文章数据
	Route::get("article/ajaxDel","admin/article/ajaxDel");
});