<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!defined('tinymce_space')) {
    define('tinymce_space', '<p> </p>
<p> </p>
<p> </p>
');
}

if (!defined('resize_w')) {
    define('resize_w', 2000);
}

if (!class_exists('Post')) {
    class Post
    {
        function __construct()
        {
            foreach ($_POST as $k => $v) {
                if (is_string($v)) {
                    $this->$k = trim($v);
                } else {
                    $this->$k = $v;
                }
            }
        }
    }
}
if (!class_exists('Get')) {
    class Get
    {
        function __construct()
        {
            foreach ($_GET as $k => $v) {
                if (is_string($v)) {
                    $this->$k = trim($v);
                } else {
                    $this->$k = $v;
                }
            }
        }
    }
}

if (!class_exists('Res')) {
    class Res
    {
        public $status = 400;
        public $data = null;
        public string $message = 'Please check the information again';
        public string $errorMessage = '';
        public string $successMessage = '';

        function __construct($status = 400)
        {
            $this->status = $status;
            // $this->message = '';
        }

        public function getProperties()
        {
            $properties = get_object_vars($this);
            $result = [];
            foreach ($properties as $k => $v) {
                $result[$k] = $v;
            }
            return $result;
        }

        public function success($status = 200,$message ='')
        {
            $this->status = $status;
            $this->message = getStatusCodeMessage($this->status);
            if ($message) {
                $this->successMessage = $message;
            }
            echo json_encode($this->getProperties());
            exit;
        }

        public function exit($status = '',$message ='')
        {
            if ($status) {
                $this->status = $status;
            }
            $this->message = getStatusCodeMessage($this->status);
            if ($message) {
                $this->errorMessage = $message;
            }
            echo json_encode($this->getProperties());
            exit;
        }
    }
}

if (!class_exists('buildPagination')) {
    class buildPagination
    {
        public $data = null;
        public $from = 0;
        public $to = 0;
        public $total = 0;
        public $total_pages = 0;
        public $current_page = 0;
        public $url = null;
        public $current_url = null;
        public $params = null;
        function __construct()
        {
        }
        public function build($data, $total, $page, $limit, $url, $params)
        {
            $this->data = $data;
            $this->from =  $total == 0 ? 0 : ($page - 1) * $limit + 1;
            $this->to = ($page - 1) * $limit + sizeof($data);
            $this->total = $total;
            $this->total_pages = ceil($total / $limit);
            $this->current_page = $page;
            $this->url = $url;
            $this->current_url = $url . $params . $page;
            $this->params = $params;
        }
    }
}

if (!class_exists('buildPagination2')) {
    class buildPagination2
    {
        public $data = null;
        public $from = 0;
        public $to = 0;
        public $total = 0;
        public $total_pages = 0;
        public $current_page = 0;
        public $url = null;
        public $current_url = null;
        public $params = null;
        public $show = false;
        function __construct()
        {
        }
        public function build($model, $offset, $page, $limit, $url, $params, $show = false)
        {
            if($show == "true"){
                $this->data = $model->get();
                $this->total = $model->count();
                $limit = $this->total;
            }else{
                $this->data = $model->limit($limit)->offset($offset)->get();
                $this->total = $model->count();
            }
            $this->from =  $this->total == 0 ? 0 : ($page - 1) * $limit + 1;
            $this->to = ($page - 1) * $limit + sizeof($this->data);
            $this->total_pages = ceil($this->total / $limit);
            $this->current_page = $page;
            $this->url = $url;
            $this->current_url = $url . $params . $page;
            $this->params = $params;
            $this->show = $show;
        }

        public function setData($resource){
            foreach($resource as $key => $value){
                $this->data = array_map(function($item) use ($key,$value){
                    if($key == 'datetime'){
                        foreach($value as $k => $v){
                            $item->$k = (new DateTime($item->$k))->format($v);
                        }
                    }
                    return $item;
                },$this->data);
            }
        }
    }
}

if (!class_exists('Session')) {
    class Session
    {

        public static function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        public static function get($key)
        {
            if (!empty($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return '';
            }
        }

        public static function forget($key)
        {
            unset($_SESSION[$key]);
        }

        public static function delete($key)
        {
            unset($_SESSION[$key]);
        }

        public static function remove($key)
        {
            unset($_SESSION[$key]);
        }

        public static function flush()
        {
            unset($_SESSION);
        }
    }
}

if (!class_exists('URL')) {
    class URL
    {

        public static function root()
        {
            // return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            if (strpos(__FILE__, '\xampp\htdocs') !== false) {
                return "http" . "://$_SERVER[HTTP_HOST]";
            } else {
                return "https" . "://$_SERVER[HTTP_HOST]";
            }
        }

        public static function current()
        {
            if (strpos(__FILE__, '\xampp\htdocs') !== false) {
                return "http" . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            } else {
                return "https" . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }
        }

        public static function previous()
        {
            return isset($_SESSION['prev']) ? $_SESSION['prev'] : '';
        }

        public static function file()
        {
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $res = 'https://files.dandautu.vn';
            } else {
                $res = static::root() . '/public';
            }
            return $res;
        }

        public static function image()
        {
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $res = 'https://files.dandautu.vn/images';
            } else {
                $res = static::root() . '/public/images';
            }
            return $res;
        }

        public static function image360()
        {
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $res = 'https://files.dandautu.vn/360';
            } else {
                $res = static::root() . '/public/360';
            }
            return $res;
        }
    }
}

if (!class_exists('PATH')) {
    class PATH
    {

        public static function root()
        {
            $root_path = '';
            if (!empty($_SERVER['SCRIPT_NAME'])) {
                $arr = explode('/', $_SERVER['SCRIPT_NAME']);
                $count = count($arr) - 2;
                for ($i = 1; $i <= $count; $i++) {
                    $root_path .= '../';
                }
            }
            $root_path = preg_replace('/^..\//', '', $root_path);
            if (!LIB::isLocal()) {
                $root_path = $root_path . folder_base;
            }
            return $root_path;
        }

        public static function image()
        {
            $file_path = static::root();
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $file_path = $file_path . '../../files.dandautu.vn/public_html/images/';
            } else {
                $file_path = $file_path . 'public/images/';
            }
            return $file_path;
        }

        public static function image360()
        {
            $file_path = static::root();
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $file_path = $file_path . '../../files.dandautu.vn/public_html/360/';
            } else {
                $file_path = $file_path . 'public/360/';
            }
            return $file_path;
        }

        public static function file()
        {
            $file_path = static::root();
            if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
                $file_path = $file_path . '../../files.dandautu.vn/public_html/';
            } else {
                $file_path = $file_path . 'public/';
            }
            return $file_path;
        }
    }
}


if (!class_exists('DOM')) {
    class DOM
    {

        public static function getAttrsByTagName($html, $tag_name, $attr)
        {
            $res = [];
            if (!empty($html)) {
                $dom = new DOMDocument();
                // $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
                $html = htmlentities(html_entity_decode($html));
                $dom->loadHtml($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                foreach ($dom->getElementsByTagName($tag_name) as $item) {
                    $res[] = html_entity_decode($item->getAttribute($attr));
                }
            }
            return $res;
        }
    }
}

if (!class_exists('Image')) {
    class Image
    {

        public static function resizeUpload($file_link, $target_file, $resize_w = '')
        {
            if ($resize_w == '') {
                $resize_w = resize_w;
            }
            $image_info = getimagesizefromstring(file_get_contents($file_link));
            $rs = false;
            if (isset($image_info['mime'])) {
                if ($image_info[0] > resize_w) {
                    $resize = new Resize($file_link, 'text');
                    $resize->resizeImage(resize_w, 80, 'landscape');
                    $rs = $resize->saveImage($target_file);
                } else {
                    $rs = file_put_contents($target_file, file_get_contents($file_link));
                }
            }
            return $rs;
        }
    }
}

if (!class_exists('Str')) {
    class Str
    {
        public static function random($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public static function ucwords($str)
        {
            return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
        }
    }
}

if (!class_exists('Minify')) {
    class Minify
    {
        public static function css($css)
        {
            $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
            $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
            return $css;
        }

        public static function js($js)
        {
            $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js);
            $js = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $js);
            $js = preg_replace('/([^;{}]+)(})/', '$1;$2', $js);
            return $js;
        }
    }
}

if (!class_exists('LIB')) {

    class LIB
    {

        /*
         * Hàm Sử Lý login bằng google
         */
        public static function login($client)
        {
            $service = new Google_Service_Oauth2($client);
            // Lấy thông tin người dùng từ google
            $userLogin = $service->userinfo->get();
            // Lấy thông tin người dùng từ DB
            $user = DB::table('users')->whereRaw(" email  LIKE '" . $userLogin->email . "' ")->first('object');
            if ($user) {
                // Kiểm tra tài khoản có bị khoá không
                if ($user->status == 0) {
                    $payload = array(
                        'user_id' => $user->id,
                        'role_id' => $user->role_id,
                        'email' => $user->email,
                        "exp" => time() + 3600 * 24 * 7
                    );
                    // Tạo token đăng nhập
                    $jwt = JWT::encode($payload, security_key, 'HS256');
                    self::setCookieUser($jwt, $user->id);
                    self::saveLogLogin($jwt, $user->id);
                    redirect(root_base . '/');
                }
                return 'USER-ERR-03';
            }
            return 'USER-ERR-06';
        }

        /*
         *  Lưu log khi đăng nhập
         */
        public static function saveLogLogin($token, $user_id)
        {
            $data = [
                'user_id' => $user_id,
                'token' => $token,
                'ip' => static::getRealIPAddress(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('user_login_logs')->insert($data);
        }

        /*
         *  Lưu thông tin đăng nhập vào cookie
         */
        public static function setCookieUser($token, $user_id)
        {
            setcookie('lbt_token', $token, time() + 3600 * 24 * 7, '/');
            setcookie('lbt_token', $token, time() + 3600 * 24 * 7, '/', '.lbt.chutin.vn');
        }

        // Xoá token đăng nhập ra khoỏi cookie
        public static function logoutCookie()
        {
            setcookie('lbt_token', '', time() - 1000, '/', 'phplib.com');
            setcookie('lbt_token', '', time() - 1000, '/', '.lbt.chutin.vn');
        }

        /*
         * Hàm xủ lý đăng nhập khi có token từ cookie
         */
        public static function checkLogin()
        {
            //            if (empty($_SESSION['user']) && !empty($_COOKIE['lbt_token']) && !empty($_COOKIE['lbt_user_id'])) {
            if (empty($_SESSION['authentication']) && !empty($_COOKIE['lbt_token'])) {
                self::loginCookie();
            } else {
                if (!empty($_SESSION['authentication'])) {
                    $user = (object)$_SESSION['authentication'];
                    $user = DB::table('users')->where('id', $user->id)->first();
                    if ($user && $user->status == 1) {
                        unset($_SESSION['authentication']);
                        static::logoutCookie();
                    }
                }
            }
        }

        /**
         * @return void
         */
        public static function loginCookie(): void
        {
            $token = $_COOKIE['lbt_token'];
            //            $user_id = $_COOKIE['lbt_user_id'];
            try {
                // Giải mã token lấy thông tin, kiểm tra tính xác thực, thời gian token
                $payload = (array)JWT::decode($token, new Key(security_key, 'HS256'));
                // kiểm tra token có trong DB không nếu không thì xóa cookie
                $log = (new Model('user_login_logs'))->where('token',$token)->where('user_id', $payload['id'])->first();
                if ($log) {
                    $user =(new Model('users'))
                        ->where('id', $payload['id'])
                        ->where('email',$payload['email'])->first();
                    if ($user && $user->status == 0) {
                        $_SESSION['authentication'] = $user;
                        self::updateLoginCookie($payload, $user->id, $token);
                    } else {
                        dd('zdo');
                        static::logoutCookie();
                    }
                } else {
                    static::logoutCookie();
                }
            } catch (Exception $e) {
                static::logoutCookie();
            }
        }

        /**0
         * @param array $payload
         * @param $user_id
         * @param $token
         * @return void
         */
        public static function updateLoginCookie(array $payload, $user_id, $token): void
        {
            $payload["exp"] = time() + 3600 * 24 * 7;
            $jwt = JWT::encode($payload, security_key, 'HS256');
            static::saveLastActive($user_id);
            DB::table('log_login')->where('token', 'like', $token)->update(array('token' => $jwt));
            static::setCookieUser($jwt, $user_id);
        }

        public static function saveLastActive($user_id)
        {
            $time = new DateTime();
            $time = $time->format('Y-m-d H:i:s');
            DB::table('users')->where('id', $user_id)->update(['last_active' => $time]);
        }

        public static function getRealIPAddress()
        {
            $ip = '';
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }

        public static function priceToText($price)
        {
            $price == '' ? 0 : $price;
            $rs = '';
            $price_text = '';
            $price_unit = '';
            if ($price >= 1000000000) {
                $price_text = number_format($price / 1000000000, 0);
                $price_unit = 'tỷ';
            } else if ($price >= 1000000) {
                $price_text = number_format($price / 1000000, 0);
                $price_unit = 'triệu';
            } else if ($price >= 1000) {
                $price_text = number_format($price / 1000, 0);
                $price_unit = 'nghìn';
            } else {
                $price_text = number_format($price, 0);
            }
            $price_unit = $price_unit == '' ? '' : ' ' . $price_unit;
            return $price_text . $price_unit;
        }


        public static function getIds($list, $col = 'id')
        {
            $list = json_decode(json_encode($list));
            if (empty($list)) {
                return [];
            }
            $ids = [];
            foreach ($list as $item) {
                if (!empty($item->$col)) {
                    $ids[] = $item->$col;
                }
            }
            return $ids;
        }

        public static function isLocal()
        {
            $_file = __FILE__;
            if (strpos($_file, '\xampp\htdocs') !== false) {
                return true;
            }
            return false;
            // if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
            //     return false;
            // }
            // return true;
        }

        public static function isImage($url)
        {
            try {
                $content = file_get_contents($url);
                $info = getimagesizefromstring($content);
                if ($info) {
                    $w = $info[0];
                    $mime = $info['mime'];
                    $array_image = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/png', 'image/gif'];
                    if (in_array($mime, $array_image)) {
                        $info['content'] = $content;
                        return $info;
                    }
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
            return false;
        }

        /*
            - $folder_path: ../../name
            - $folder_src: https://name.com/folder
            - $img_name_first: content-id-
        */
        public static function move_uploaded_file($file_link, $target_file, $resize_w = '')
        {
            if ($resize_w == '') {
                $resize_w = resize_w;
            }
            $image_info = getimagesizefromstring(file_get_contents($file_link));
            $rs = false;
            if (isset($image_info['mime'])) {
                if ($image_info[0] > $resize_w) {
                    $resize = new Resize($file_link, 'text');
                    $resize->resizeImage($resize_w, 80, 'landscape');
                    $rs = $resize->saveImage($target_file);
                } else {
                    if (move_uploaded_file($file_link, $target_file)) {
                        $rs = true;
                    }
                }
            }
            return $rs;
        }

        public static function upLoadImage($files, $folder_path, $folder_src, $name_start)
        {
            $res = [];
            foreach ($files['size'] as $k => $image_size) {
                $image_type = $files['type'][$k];
                if ($image_type == 'image/jpeg') {
                    $image_type = 'image/jpg';
                }
                $image_tmp_name = $files['tmp_name'][$k];

                if ($image_size > 0 && $image_size < image_max_size && in_array($image_type, image_types)) {
                    $image_name = $name_start . time() . '-' . Str::random() . '.jpg';
                    $target_file = $folder_path . '/' . $image_name;
                    $image = $folder_src . '/' . $image_name;
                    if (static::move_uploaded_file($image_tmp_name, $target_file)) {
                        $res[] = $image;
                    }
                }
            }
            return $res;
        }

        public static function removeSpace($text)
        {
            // $text = trim(preg_replace("/" . tinymce_space . "/", '', $text));
            $text = trim(str_replace(tinymce_space, '', $text));
            $str = "<p> </p><p> </p><p> </p>";
            $text = trim(str_replace($str, '', $text));
            $text = trim($text);
            $text = trim(preg_replace("/^<p> <p>/", '<p>', $text));
            $text = trim(preg_replace("/<\/p><\/p>$/", '</p>', $text));

            for ($i = 0; $i <= 5; $i++) {
                // $text = trim(preg_replace("/^<p> <p> <\/p>/", '<p> ', $text));
                $text = trim(preg_replace("/^<p> <\/p>/", '', $text));
            }
            for ($i = 0; $i <= 15; $i++) {
                // $text = trim(preg_replace("/<p> <\/p><\/p>$/", '</p>', $text));
                $text = trim(preg_replace("/<p> <\/p>$/", '', $text));
            }
            return $text;
        }

        public static function addImagesFromHtml($html, $folder_path, $folder_src, $img_name_first)
        {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $dom->loadHtml($html, LIBXML_HTML_NODEFDTD);
            foreach ($dom->getElementsByTagName('img') as $img) {
                $img_src = $img->getAttribute('src');
                if (strpos($img_src, URL::image()) === false) {
                    $img_name = $img_name_first . time() . '-' . rand(1000, 9000) . '.jpg';
                    $target_file = $folder_path . '/' . $img_name;
                    // $save_img = file_put_contents($target_file, file_get_contents($img_src));
                    $save_img = Image::resizeUpload($img_src, $target_file, resize_w);
                    if ($save_img) {
                        $img_src = $folder_src . '/' . $img_name;
                        $img->setAttribute('src', $img_src);
                    }
                }
            }
            $rs = html_entity_decode($dom->saveHTML());
            $rs = trim(preg_replace("/^<html><body>/", '', $rs));
            $rs = trim(preg_replace("/<\/body><\/html>$/", '', $rs));
            return static::removeSpace($rs);
        }

        public static function deleteImagesFromHtml($html_new, $html_old)
        {
            if ($html_old) {
                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                $html = mb_convert_encoding($html_old, 'HTML-ENTITIES', 'UTF-8');
                $dom->loadHtml($html, LIBXML_HTML_NODEFDTD);
                foreach ($dom->getElementsByTagName('img') as $img) {
                    $image_old = $img->getAttribute('src');
                    if (strpos($html_new, $image_old) === false) {
                        $file_path = str_replace(URL::image() . '/', PATH::image(), $image_old);
                        if (file_exists($file_path)) {
                            $folder_path = dirname($file_path);
                            unlink($file_path);
                        }
                    }
                }
            }
        }

        public static function saveUserLog($user_id, $detail)
        {
            $data = array(
                'user_id' => $user_id,
                'detail' => $detail
            );
            DB::table('user_logs')->insert($data);
        }
    }
}
