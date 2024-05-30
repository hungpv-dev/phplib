<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
libxml_use_internal_errors(true);


if (strpos(__FILE__, 'xampp\htdocs') !== false) {
    if (!defined('root_base')) {
        define('root_base', '');
    }
}else{
    if (!defined('root_base')) {
        define('root_base', '');
    }
}

if (!defined('folder_base')) {
	define('folder_base', '');
}
include 'DB.php';
include 'functions.php';
include 'vendor/autoload.php';
include 'Responses.php';
include 'LIB.php';
include 'Model.php';

if (strpos(__FILE__, '\xampp\htdocs') !== false) {
    $config = [
        'db_host' => 'localhost',
        'db_port' => '3306',
        'db_user' => 'root',
        'db_pass' => '',
        'db_name' => 'php_lib',
        'charset' => 'utf8mb4'
    ];
    DB::connect($config);
}else {
    setDBConfig('config.json');
}

const security_key = "QnlrXQ";
