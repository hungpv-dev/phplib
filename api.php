<?php
session_start();
include 'lib/config.php';

$current_url = current_url();

// Use this namespace
use Steampixel\Route;

include 'lib/Route.php';


$uri = $_SERVER['REQUEST_URI'];

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json ; charset=UTF-8');
/*
 *
 * kiểm tra xem người dùng đã đăng nhập chưa
 */
// LIB::checkLogin();

// if (empty($_SESSION['authentication'])) {
//     $res = new Res();
//     $res->exit(403);
// } else {
//     define("current_user", $_SESSION['authentication']);
// }

define('BASEPATH', '/');


// user
Route::add(root_base . '/api/users', function () {
    include 'api/users/users.php';
}, ['GET', 'PUT']);

Route::add(root_base . '/api/users/([0-9]*)', function () {
    include 'api/users/user.php';
}, ['GET', 'PUT']);
// Role
Route::add(root_base . '/api/roles/([0-9]*)', function () {
    include 'api/roles/role.php';
}, ['GET', 'PUT']);

// Quản lý phòng ban
Route::add(root_base . '/api/departments', function () {
    include 'api/departments/departments.php';
}, ['GET', 'PUT']);
Route::add(root_base . '/api/departments/([0-9]*)', function () {
    include 'api/departments/department.php';
}, ['GET', 'PUT' ,'DELETE']);


// Quản lý nhà cung cấp
Route::add(root_base . '/api/suppliers', function () {
    include 'api/suppliers/suppliers.php';
}, ['GET', 'PUT']);
Route::add(root_base . '/api/suppliers/([0-9]*)', function () {
    include 'api/suppliers/supplier.php';
},['GET', 'PUT']);

// Công nợ nhà cung cấp
Route::add(root_base . '/api/suppliers/amounts/([0-9]*)', function () {
    include 'api/suppliers/supplier-amounts.php';
}, ['GET', 'PUT']);


// Quản lý khách hàng
Route::add(root_base . '/api/customers', function () {
    include 'api/customers/customers.php';
}, ['GET', 'PUT']);
Route::add(root_base . '/api/customers/([0-9]*)', function () {
    include 'api/customers/customer.php';
}, ['GET', 'PUT']);

Route::pathNotFound(function () {
    $res = new Res();
    $res->exit(404);
});
Route::methodNotAllowed(function () {
    $res = new Res();
    $res->exit(405);
});


Route::run(BASEPATH, true, false, true);
