<?php
session_start();
include 'lib/config.php';

$current_url = current_url();


// Use this namespace
use Steampixel\Route;

include 'lib/Route.php';


$uri = $_SERVER['REQUEST_URI'];
/*
 *
 * kiểm tra xem người dùng đã đăng nhập chưa
 */
LIB::checkLogin();
if (!isset($_SESSION['authentication']) || empty($_SESSION['authentication'])) {
    if (!preg_match('#^/login#iu', $uri)) {
        redirect(root_base . '/login');
    }
} else {
    define("current_user", $_SESSION['authentication']);
}

define('BASEPATH', '/');



Route::add(root_base . '/login', function () {
    include 'pages/login.php';
});
Route::add(root_base . '/', function () {
    include 'home.php';
});

// Quản lý phòng ban
Route::add(root_base . '/quan-ly-phong-ban', function () {
    include './pages/users/departments.php';
});

Route::add(root_base . '/quan-ly-phong-ban/([0-9]*)', function () {
    include './pages/users/department.php';
});


// Quản lý nhân viên
Route::add(root_base . '/quan-ly-nhan-vien', function () {
    include './pages/users/users.php';
});
Route::add(root_base . '/quan-ly-nhan-vien/([0-9]*)', function () {
    include './pages/users/user.php';
});

// Quản lý nhà cung cấp
Route::add(root_base . '/quan-ly-nha-cung-cap', function () {
    include './pages/suppliers/suppliers.php';
});
// Quản lý công nợ nhà cung cấp
Route::add(root_base . '/quan-ly-nha-cung-cap/cong-no/([0-9]*)', function () {
    include './pages/suppliers/supplier-amounts.php';
});

// Quản lý khách hàng
Route::add(root_base . '/quan-ly-khach-hang', function () {
    include './pages/customers/customers.php';
});
// Quản lý báo giá
Route::add(root_base . '/quan-ly-bao-gia/([0-9]*)', function () {
    include './pages/customers/quotes.php';
});
// Quản lý chi tiết báo giá
Route::add(root_base . '/quan-ly-chi-tiet-bao-gia/([0-9]*)', function () {
    include './pages/customers/quote_details.php';
});
// Bảng chi tiết báo giá
Route::add(root_base . '/chi-tiet-bao-gia/([0-9]*)', function () {
    include './pages/customers/quote_info.php';
});

// Quản lý loại vật tư
Route::add(root_base . '/quan-ly-loai-vat-tu', function () {
    include './pages/vattu/loaivattu.php';
});
// Quản lý loại vật tư
Route::add(root_base . '/quan-ly-don-vi-tinh', function () {
    include './pages/units/units.php';
});

// quản lý sản phẩm và dịch vụ
Route::add(root_base . '/quan-ly-san-pham-dich-vu', function () {
    include './pages/products/products.php';
});


// quản lý sản phẩm và dịch vụ
Route::add(root_base . '/quan-ly-vat-tu', function () {
    include './pages/vattu/vattu.php';
});

















Route::add(root_base . '/404', function () {
    include 'pages/404.php';
});

Route::add(root_base . '/403', function () {
    include 'pages/403.php';
});

Route::pathNotFound(function () {
    redirect(root_base . '/404');
});

Route::run(BASEPATH, true, false, true);
