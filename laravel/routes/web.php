<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//后台首页
Route::any('admin','Admin\AdminController@admin');
//后台登录页
Route::any('login','Admin\LoginController@login');
//录入权限
Route::any('entering_permission','Admin\PermissionController@entering_permission');
//权限的添加
Route::any('permission_add','Admin\PermissionController@permission_add');
//左侧菜单的循环
Route::any('left','Admin\CommonController@construct');
// 角色添加页面
Route::any('role_add','Admin\RoleController@role_add');
//执行角色添加
Route::any('role_do','Admin\RoleController@role_do');
//管理员添加的视图页面
Route::any('administrator_add','Admin\AdministratorController@administrator_add');
//执行管理员添加
Route::any('administrator_do','Admin\AdministratorController@administrator_do');
//执行管理员登录
Route::any('login_do','Admin\LoginController@login_do');
//后台用户展示
Route::any('administrator_list','Admin\AdministratorController@administrator_list');
//后台用户的删除
Route::any('administrator_del','Admin\AdministratorController@administrator_del');
//角色展示
Route::any('role_list','Admin\RoleController@role_list');
//退出
Route::any('quit','Admin\LoginController@quit');
//角色的删除
Route::any('role_del','Admin\RoleController@role_del');
//用户的添加视图
Route::any('user_add','Admin\UserController@user_add');
//用户添加的地址
Route::any('user_address','Admin\UserController@user_address');
//用户执行添加
Route::any('user_add_do','Admin\UserController@user_add_do');
//角色批量删除
Route::any('role_delete','Admin\RoleController@role_delete');


