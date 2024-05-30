<?php

/**
 * Convert String to Array
 * @param type $str
 * @param type $delimiter
 * @return type
 */
if (!function_exists('strToArr')) {

    function strToArr($str, $delimiter = ",")
    {
        $returns = array();
        $arr = explode($delimiter, $str);
        if ($arr) {
            foreach (array_unique($arr) as $value) {
                $_value = strtolower(trim($value));
                if ($_value && !in_array($_value, $returns)) {
                    $returns[] = $_value;
                }
            }
        }
        return $returns;
    }
}

/**
 * Get Client IP
 * @return type
 */
if (!function_exists('getClientIp')) {

    function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

/**
 *
 * @param type $limit
 * @return type
 */
if (!function_exists('buildPaginationData')) {

    function buildPaginationData($limit, $page = false)
    {
        $return['limit'] = $limit;
        if (!$page) {
            $return['page'] = core\Input::getInstance()->get('page') ? core\Input::getInstance()->get('page') : 1;
        } else {
            $return['page'] = $page;
        }
        $return['skip'] = ($return['page'] - 1) * $return['limit'];
        $return['start'] = $return['page'] * $return['limit'] - $return['limit'];
        $return['limit_string'] = "{$return['start']},{$return['limit']}";
        return $return;
    }
}

/**
 *
 * @param type $string
 * @param type $length
 * @return type
 */
// Cắt ngắn một chuỗi
if (!function_exists('truncate')) {

    function truncate($string, $length = 80)
    {
        $strlen = strlen(remove_unicode($string));
        if ($strlen <= $length) {
            return $string;
        } else {
            mb_internal_encoding("UTF-8");
            return mb_substr($string, 0, $length - 3) . "...";
        }
    }
}

/**
 *
 * @param type $url
 * @param type $timeout
 * @param type $referer
 * @param type $USERAGENT
 * @return type
 */
if (!function_exists('curlGet')) {

    function curlGet($url, $timeout = 3600, $referer = false, $USERAGENT = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($USERAGENT) {
            curl_setopt($curl, CURLOPT_USERAGENT, $USERAGENT);
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $dataReturn = curl_exec($curl);
        curl_close($curl);
        return $dataReturn;
    }
}

/**
 *
 * @param type $url
 * @param type $field
 * @param type $timeout
 * @param type $referer
 * @param type $USERAGENT
 * @return type
 */
if (!function_exists('curlPost')) {

    function curlPost($url, $field = array(), $timeout = 3600, $referer = false, $USERAGENT = false)
    {
        $post = $field ? http_build_query($field) : '';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($USERAGENT) {
            curl_setopt($curl, CURLOPT_USERAGENT, $USERAGENT);
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $dataReturn = curl_exec($curl);
        curl_close($curl);
        return $dataReturn;
    }
}

/**
 * Redirect
 * @param type $url
 */
if (!function_exists('redirect')) {

    function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}

/**
 * Get Current url
 * @return string
 */
if (!function_exists('current_url')) {

    function current_url($param = true)
    {
        $protocol = getProtocol();
        $pageURL = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        if ($param === true) {
            return $pageURL;
        } else {
            return preg_replace('/\?.*$/', '', $pageURL);
        }
    }
}

/**
 * getProtocol
 * @return type
 */
if (!function_exists('getProtocol')) {

    function getProtocol()
    {
        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $isSecure = true;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $isSecure = true;
        } elseif (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
            $isSecure = true;
        }
        return $isSecure ? 'https://' : 'http://';
    }
}

/**
 *
 * @param type $text
 * @return type
 */
if (!function_exists('build_slug')) {

    function build_slug($text)
    {

        $text = htmlspecialchars(trim(strip_tags($text)));

        $CLEAN_URL_REGEX = '*([\s$+,/:=\?@"\'<>%{}|\\^~[\]`\r\n\t\x00-\x1f\x7f]|(?(?<!&)#|#(?![0-9]+;))|&(?!#[0-9]+;)|(?<!&#\d|&#\d{2}|&#\d{3}|&#\d{4}|&#\d{5});)*s';
        $text = preg_replace($CLEAN_URL_REGEX, '-', strip_tags($text));
        $text = trim(preg_replace('#-+#', '-', $text), '-');

        $code_entities_match = array('\\', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '', ';', "'", ',', '.', '_', '/', '*', '+', '~', '`', '=', ' ', '---', '--', '--');
        $code_entities_replace = array('', '', '-', '-', '', '', '', '-', '-', '', '', '', '', '', '', '', '-', '', '', '', '', '', '', '', '', '', '-', '', '-', '-', '', '', '', '', '', '-', '-', '-', '-');
        $text = str_replace($code_entities_match, $code_entities_replace, $text);

        $chars = array("a", "A", "e", "E", "o", "O", "u", "U", "i", "I", "d", "D", "y", "Y");
        $uni[0] = array("á", "à", "ạ", "ả", "ã", "â", "ấ", "ầ", "ậ", "ẩ", "ẫ", "ă", "ắ", "ắ", "ặ", "ẳ", "� �", "ả", "á", "ặ", "ằ", "ẵ");
        $uni[1] = array("Á", "À", "Ạ", "Ả", "Ã", "Â", "Ấ", "Ầ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ắ", "ắ", "Ặ", "Ẳ", "� �", "Ằ", "Ẵ");
        $uni[2] = array("é", "è", "ẹ", "ẻ", "ẽ", "ê", "ế", "ề", "ệ", "ể", "ễ", "ệ");
        $uni[3] = array("É", "È", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ế", "Ề", "Ệ", "Ể", "Ễ");
        $uni[4] = array("ó", "ò", "ọ", "ỏ", "õ", "ô", "ố", "ồ", "ộ", "ổ", "ỗ", "ơ", "ớ", "ờ", "ợ", "ở", "� �", "ỡ");
        $uni[5] = array("Ó", "Ò", "Ọ", "Ỏ", "Õ", "Ô", "Ố", "Ồ", "Ộ", "Ổ", "Ỗ", "Ơ", "Ớ", "Ờ", "Ợ", "Ở", "� �", "Ỡ");
        $uni[6] = array("ú", "ù", "ụ", "ủ", "ũ", "ư", "ứ", "ừ", "ự", "ử", "ữ", "ù");
        $uni[7] = array("Ú", "Ù", "Ụ", "Ủ", "Ũ", "Ư", "Ứ", "Ừ", "Ự", "Ử", "Ữ");
        $uni[8] = array("í", "ì", "ị", "ỉ", "ĩ");
        $uni[9] = array("Í", "Ì", "Ị", "Ỉ", "Ĩ");
        $uni[10] = array("đ");
        $uni[11] = array("Đ");
        $uni[12] = array("ý", "ỳ", "ỵ", "ỷ", "ỹ");
        $uni[13] = array("Ý", "Ỳ", "Ỵ", "Ỷ", "Ỹ");

        for ($i = 0; $i <= 13; $i++) {
            $text = str_replace($uni[$i], $chars[$i], $text);
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz-';
        $textReturn = '';
        for ($i = 0; $i <= strlen($text); $i++) {
            if (isset($text[$i])) {
                //$text[$i] = strtolower($text[$i]);
                if (preg_match("/{$text[$i]}/i", $characters)) {
                    $textReturn .= $text[$i];
                }
            }
        }

        $textReturn = strtolower($textReturn);
        return $textReturn;
    }
}

/**
 *
 * @param type $_text
 * @return type
 */
if (!function_exists('remove_unicode')) {

    function remove_unicode($_text)
    {
        $text = htmlspecialchars(trim(strip_tags($_text)));
        $chars = array("a", "A", "e", "E", "o", "O", "u", "U", "i", "I", "d", "D", "y", "Y");
        $uni[0] = array("á", "à", "ạ", "ả", "ã", "â", "ấ", "ầ", "ậ", "ẩ", "ẫ", "ă", "ắ", "ằ", "ặ", "ẳ", "� �", "ả", "á", "ặ");
        $uni[1] = array("Á", "À", "Ạ", "Ả", "Ã", "Â", "Ấ", "Ầ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ắ", "Ằ", "Ặ", "Ẳ", "� �", "Ạ", "Á", "À", "Ã", "Ả");
        $uni[2] = array("é", "è", "ẹ", "ẻ", "ẽ", "ê", "ế", "ề", "ệ", "ể", "ễ", "ệ");
        $uni[3] = array("É", "È", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ế", "Ề", "Ệ", "Ể", "Ễ", "É", "Ẽ");
        $uni[4] = array("ó", "ò", "ọ", "ỏ", "õ", "ô", "ố", "ồ", "ộ", "ổ", "ỗ", "ơ", "ớ", "ờ", "ợ", "ở", "� �");
        $uni[5] = array("Ó", "Ò", "Ọ", "Ỏ", "Õ", "Ô", "Ố", "Ồ", "Ộ", "Ổ", "Ỗ", "Ơ", "Ớ", "Ờ", "Ợ", "Ở", "� �", "Ọ", "Õ");
        $uni[6] = array("ú", "ù", "ụ", "ủ", "ũ", "ư", "ứ", "ừ", "ự", "ử", "ữ", "ù");
        $uni[7] = array("Ú", "Ù", "Ụ", "Ủ", "Ũ", "Ư", "Ứ", "Ừ", "Ự", "Ử", "Ữ", "Ú", "Ũ");
        $uni[8] = array("í", "ì", "ị", "ỉ", "ĩ");
        $uni[9] = array("Í", "Ì", "Ị", "Ỉ", "Ĩ", "Ỉ", "Ì", "Ĩ", "Í", "Ị");
        $uni[10] = array("đ");
        $uni[11] = array("Đ");
        $uni[12] = array("ý", "ỳ", "ỵ", "ỷ", "ỹ");
        $uni[13] = array("Ý", "Ỳ", "Ỵ", "Ỷ", "Ỹ");
        for ($i = 0; $i <= 13; $i++) {
            $text = str_replace($uni[$i], $chars[$i], $text);
        }
        return $text;
    }
}

/**
 * Displays structured information about one or more expressions that includes its type and value.
 *
 * @param mixed $str Structure to display.
 * @return void
 */
if (!function_exists('dump')) {

    function dump($args)
    {
        include_once ROOT_PATH . '/cores/class.dumper.php';
        ob_start();
        @header('Content-Type: text/html; charset=utf-8');
        $args = func_get_args();
        foreach ($args as $arg) {
            Dumper::dump($arg);
        }
    }
}

if (!function_exists('escape_sequence_decode')) {

    function escape_sequence_decode($str)
    {
        for ($i = 0; $i < 10; $i++) {
            $str = str_replace("u" . $i, "\u" . $i, $str);
        }
        // [U+D800 - U+DBFF][U+DC00 - U+DFFF]|[U+0000 - U+FFFF]
        $regex = '/\\\u([dD][89abAB][\da-fA-F]{2})\\\u([dD][c-fC-F][\da-fA-F]{2})
	              |\\\u([\da-fA-F]{4})/sx';

        return preg_replace_callback($regex, function ($matches) {

            if (isset($matches[3])) {
                $cp = hexdec($matches[3]);
            } else {
                $lead = hexdec($matches[1]);
                $trail = hexdec($matches[2]);

                // http://unicode.org/faq/utf_bom.html#utf16-4
                $cp = ($lead << 10) + $trail + 0x10000 - (0xD800 << 10) - 0xDC00;
            }

            // https://tools.ietf.org/html/rfc3629#section-3
            // Characters between U+D800 and U+DFFF are not allowed in UTF-8
            if ($cp > 0xD7FF && 0xE000 > $cp) {
                $cp = 0xFFFD;
            }

            // https://github.com/php/php-src/blob/php-5.6.4/ext/standard/html.c#L471
            // php_utf32_utf8(unsigned char *buf, unsigned k)

            if ($cp < 0x80) {
                return chr($cp);
            } else if ($cp < 0xA0) {
                return chr(0xC0 | $cp >> 6) . chr(0x80 | $cp & 0x3F);
            }

            return html_entity_decode('&#' . $cp . ';');
        }, $str);
    }
}

if (!function_exists('isLocal')) {
    function isLocal()
    {
        $_file = __FILE__;
        if (strpos($_file, '\xampp\htdocs') !== false) {
            return true;
        }
        return false;
    }
}

// Edit
if (!function_exists('textSummary1')) {
    function textSummary1($text, $length = 140)
    {
        $text = trim($text);
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length - 3) . '...';
    }
}

if (!function_exists('textSummary')) {
    function textSummary($text, $length = 150)
    {
        $text = trim($text);
        if (strlen($text) <= $length) {
            return $text;
        }
        $text = substr($text, 0, $length - 2);
        $arr = explode(' ', $text);
        array_pop($arr);
        $rs = trim(implode(' ', $arr));
        if (substr($rs, -1) == '.') {
            return $rs . '..';
        } else {
            return $rs . '...';
        }
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($time = NULL, $format = 'd-m-Y')
    {
        if ($time === NULL || $time == '' || $time == '0000-00-00' || $time == '0000-00-00 00:00:00') {
            return '';
        }
        return date($format, strtotime($time));
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($time = NULL, $format = 'H:i:s d-m-Y')
    {
        if ($time === NULL || $time == '0000-00-00' || $time == '0000-00-00 00:00:00') {
            return '';
        }
        return date($format, strtotime($time));
    }
}

if (!function_exists('getTimeAgo')) {
    function getTimeAgo($time, $type = '')
    {
        if ($time == '' || $time == '0000-00-00' || $time == '0000-00-00 00:00:00') {
            return 'Chưa hoạt động';
        }
        if (preg_match('/[-:]/', $time)) {
            $time = strtotime($time);
        }
        $time_diff = time() - $time;
        $rs = '';
        $num = '';
        $unit = '';
        if ($time_diff <= 5) {
            return 'Vừa xong';
        } else if ($time_diff < 60) {
            $num = $time_diff;
            $unit = 's';
        } else if ($time_diff < 3600) {
            $num = floor($time_diff / 60);
            $unit = 'm';
        } else if ($time_diff < 3600 * 24) {
            $num = floor($time_diff / 3600);
            $unit = 'h';
        } else if ($time_diff < 30 * 3600 * 24) {
            $num = floor($time_diff / (3600 * 24));
            $unit = 'd';
        } else if ($time_diff < 365 * 3600 * 24) {
            $num = floor($time_diff / (30 * 3600 * 24));
            $unit = 'mo';
        } else {
            $num = floor($time_diff / (365 * 3600 * 24));
            $unit = 'y';
        }
        if ($type == '') {
            $rs = $num . $unit;
        } else {
            if ($unit == 's') {
                $unit = 'giây';
            } else if ($unit == 'm') {
                $unit = 'phút';
            } else if ($unit == 'h') {
                $unit = 'giờ';
            } else if ($unit == 'd') {
                $unit = 'ngày';
            } else if ($unit == 'mo') {
                $unit = 'tháng';
            } else if ($unit == 'y') {
                $unit = 'năm';
            }
            //			if ($num >= 2) {
            //				$unit = $unit . 's';
            //			}
            $rs = $num . ' ' . $unit . ' trước';
        }
        return $rs;
    }
}

if (!function_exists('getDayAgo')) {
    function getDayAgo($time)
    {
        if ($time == '0000-00-00 00:00:00' || $time == '') {
            return 0;
        }
        if (strpos($time, ':') !== false) {
            $time = strtotime($time);
        }
        $time_range = time() - $time;
        return (int)floor($time_range / (3600 * 24));
    }
}

if (!function_exists('getStar')) {
    function getStar($rating = 5)
    {
        if ($rating < 1 || $rating > 5) {
            $rating = 5;
        }
        $rating_floor = floor($rating);
        $rating_point = $rating - $rating_floor;
        $star_half = 0;
        if ($rating_point < 0.25) {
            $rating = $rating_floor;
        } else if ($rating_point >= 0.25 && $rating_point < 0.75) {
            $rating = $rating_floor + 0.5;
            $star_half = $rating_floor + 1;
        } else {
            $rating = $rating_floor + 1;
        }
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($star_half > 0 && $star_half == $i) {
                $html .= '<i class="fas fa-star-half-alt"></i>';
            } else if ($i <= $rating) {
                $html .= '<i class="fa fa-star"></i>';
            } else {
                $html .= '<i class="far fa-star"></i>';
            }
        }
        return $html;
    }
}

if (!function_exists('getRootUrl')) {
    function getRootUrl()
    {
        $http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
        return $http . $_SERVER["HTTP_HOST"];
    }
}

if (!function_exists('getRootPath')) {
    function getRootPath()
    {
        $root_path = '';
        if (!empty($_SERVER['SCRIPT_NAME'])) {
            $arr = explode('/', $_SERVER['SCRIPT_NAME']);
            $count = count($arr) - 2;
            for ($i = 1; $i <= $count; $i++) {
                $root_path .= '../';
            }
        }
        return $root_path;
    }
}

if (!function_exists('getFilePath')) {
    function getFilePath()
    {
        $file_path = getRootPath();
        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost') {
            $file_path = $file_path . '../files.dandautu.vn/public_html/';
        } else {
            $file_path = $file_path . 'files';
        }
        return $file_path;
    }
}

if (!function_exists('getNameRand')) {
    function getNameRand($id = '')
    {
        $arrs = ['Royal', 'Ellis', 'Audrey', 'Lily', 'Hazel', 'Everett', 'Scarlett', 'Edith', 'Jane', 'Sawyer'];
        if (!empty($id)) {
            $id = (int)$id;
            return $arrs[$id % 10];
        }
        return $arrs[random_int(0, 9)];
    }
}

if (!function_exists('getAvatar')) {
    function getAvatar($file_name, $name = '')
    {
        // $name = strtolower($name);
        // $name = preg_replace('/[^a-zA-Z]+/', '', $name);
        // return '/public/images/image-a-z/' . $name[0] . '.png';
        if (strpos($file_name, 'https') !== false) {
            return $file_name;
        } else if (preg_match('/upload/', $file_name) && $file_name != '/uploads/images_user/') {
            // return 'https://9wik.com' . $file_name;
            return $file_name;
        } else {
            $name = strtolower($name);
            $name = preg_replace('/[^a-zA-Z]+/', '', $name);
            if ($name == '') {
                return '/assets/images/avatar.png';
            } else {
                return '/public/images/image-a-z/' . $name[0] . '.png';
            }
        }
    }
}

if (!function_exists('getImage')) {
    function getImage($file_name)
    {
        if (empty($file_name)) {
            return '';
        }
        if (preg_match('/^https/', $file_name)) {
            return $file_name;
        } else {
            if (isLocal() || empty($_SERVER['HTTP_HOST'])) {
                return 'https://9wik.com' . $file_name;
            } else {
                return 'https://9wik.com' . $file_name;
            }
        }
    }
}

if (!function_exists('getCountLike')) {
    function getCountLike($count)
    {
        if (empty($count)) {
            return '';
        }
        $count = (int)$count;
        if ($count < 1000) {
            return $count;
        }
        if ($count < 1000000) {
            return number_format($count / 1000, 1) . 'K';
        }
        if ($count < 1000000000) {
            return number_format($count / 1000000, 1) . 'M';
        }
        if ($count < 1000000000000) {
            return number_format($count / 1000000000, 1) . 'B';
        }
    }
}
if (!function_exists('getLinkOrigin')) {
    function getLinkOrigin($link, $platform_id = 1)
    {
        // gag
        if ($platform_id == 1) {
            if (preg_match('/9gag/', $link)) {
                return $link;
            } else {
                return 'https://9gag.com/gag/' . 'a' . $link;
            }
        }
        // tiktok
        if ($platform_id == 2) {
            if (preg_match('/tiktok/', $link)) {
                return $link;
            } else {
                return 'https://www.tiktok.com/embed/v2/' . $link;
            }
        }
        // youtube
        if ($platform_id == 5) {
            if (preg_match('/youtube/', $link)) {
                return $link;
            } else {
                return 'https://www.youtube.com/embed/' . $link;
            }
        }
        // imgur
        if ($platform_id == 7) {
            if (preg_match('/imgur/', $link)) {
                return $link;
            } else {
                return 'https://imgur.com/gallery/' . $link;
            }
        }
        // instagram
        if ($platform_id == 8) {
            if (preg_match('/instagram/', $link)) {
                return $link;
            } else {
                $link = preg_replace('/^p/', '', $link);
                return 'https://www.instagram.com/p/' . $link;
            }
        }
        // pinterest
        if ($platform_id == 9) {
            if (preg_match('/pinterest/', $link)) {
                return $link;
            } else {
                $link = preg_replace('/^p/', '', $link);
                return 'https://www.pinterest.com/pin/' . $link;
            }
        }
        return $link;
    }
}


if (!function_exists('htmlActive')) {
    function htmlActive($status, $rule = '1')
    {
        $disabled = '';
        if ($rule != '1') {
            $disabled = 'disabled';
        }
        if ($status == 1) {
            return "<span class='badge bg-success btn_active' $disabled>Hiển thị</span>";
        } else {
            return "<span class='badge bg-danger btn_active' $disabled>Ẩn</span>";
        }
    }
}

if (!function_exists('getAlert')) {
    function getAlert()
    {
        if (!empty($_SESSION['error'])) {
            $error_text = $_SESSION['error'];
            echo '<button class="alert alert-danger">' . $error_text . '</button>';
            unset($_SESSION['error']);
        }
        if (!empty($_SESSION['success'])) {
            $success_text = $_SESSION['success'];
            echo '<button class="alert alert-success">' . $success_text . '</button>';
            unset($_SESSION['error']);
        }
    }
}

if (!function_exists('isEmail')) {
    function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('contentAddAds')) {
    function contentAddAds($text, $length = 800)
    {
        $arrs = explode('</p>', $text);
        $rs = '';
        $str_next = '';
        $str_store = '';
        $str_lengle = 0;
        foreach ($arrs as $item) {
            $str_next = $item;
            $str_lengle += strlen(strip_tags($item));
            $str_lengle += 500 * substr_count($item, '<img ');

            if ($str_lengle >= $length) {
                $str_next .= '</p><div class="ads_content"></div>';
                $str_lengle = 0;
            } else {
                $str_next .= '</p>';
            }
            $rs .= $str_next;
        }
        return $rs;
    }
}

// Use DB
if (!function_exists('getName')) {
    function getName($table, $id, $col = 'name')
    {
        if ((int)$id >= 1) {
            $item = DB::table($table)->select($col)->find($id);
            if ($item) {
                return $item->$col;
            }
        }
        return '';
    }
}

if (!function_exists('writeFile')) {
    function writeFile($content, $name = '')
    {
        if ($name == '') {
            $name = basename($_SERVER['PHP_SELF'], '.php');
            $name += '.txt';
        }
        $file_name = $name;
        $file = fopen($file_name, 'w');
        fwrite($file, $content);
        fclose($file);
        chmod($file_name, 0777);
        return true;
    }
}

if (!function_exists('generateCouponCode')) {
    function generateCouponCode($length = 6)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $couponCode = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $couponCode .= $characters[mt_rand(0, $max)];
        }
        return $couponCode;
    }
}

if (!function_exists('convertCurrency')) {
    function convertCurrency($amount, $currency_code, $to_currency_code = 'USD')
    {
        $rs = $amount;
        $res = file_get_contents(Path::root() . 'data/currencies.json');
        $res = json_decode($res);
        if (isset($res->rates->$currency_code)) {
            $rs = $amount / $res->rates->$currency_code;
            $rs = round($rs, 2);
        } else {
            $rs = 0;
        }
        return $rs;
    }
}

// Only web
if (!function_exists('getActiveHot')) {
    function getActiveHot($type = 'home')
    {
        $uri = '';
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            return '';
        }
        $rs = '';
        if ($type == 'home') {
            if ($uri == '/' || preg_match('/^\/home/', $uri) || preg_match('/^\/\?/', $uri)) {
                $rs = 'active';
            }
        }
        if ($type == 'top') {
            if (preg_match('/^\/top/', $uri)) {
                $rs = 'active';
            }
        }
        if ($type == 'trending') {
            if (preg_match('/^\/trending/', $uri)) {
                $rs = 'active';
            }
        }
        if ($type == 'fresh') {
            if (preg_match('/^\/fresh/', $uri)) {
                $rs = 'active';
            }
        }
        return $rs;
    }
}

if (!function_exists('getMedia')) {
    function getMedia($media, $medias)
    {
        // media: tring, medias: string
        $rs1 = $media;
        $rs2 = [];
        $rs2 = json_decode($medias);
        if (empty($rs2)) {
            $rs2 = [];
        }
        if (empty($media) && !empty($rs2)) {
            if (!empty($rs2[0])) {
                $rs1 = $rs2[0];
            }
        } else {
            $media = '';
        }
        return [$rs1, $rs2];
    }
}


if (!function_exists('format_vip')) {
    function format_vip($string_vip)
    {
        $number_vip = str_split($string_vip);
        // var_dump($number_vip); die;
        $str = $number_vip[0] . $number_vip[1] . $number_vip[2] . "-" . $number_vip[3] . $number_vip[4] . $number_vip[5] . "." . $number_vip[6] . $number_vip[7];
        return $str;
    }
}

if (!function_exists('clientGoogle')) {
    function clientGoogle(): Google_Client
    {
        $client = new Google_Client();
        // cấu hình app đăng nhập
        $client->setAuthConfig('client_secret.json');
        $client->setIncludeGrantedScopes(true);
        // cấu hình thông tin cần thiết muốn lấy
        $client->addScope("email");

        return $client;
    }
}

if (!function_exists('setDBConfig')) {
    function setDBConfig($config)
    {
        if (is_string($config)) {
            if (!file_exists($config)) {
                throw new InvalidArgumentException(sprintf('file "%s" does not exist', $config));
            }

            $json = file_get_contents($config);

            if (!$config = json_decode($json, true)) {
                throw new LogicException('invalid json for auth config');
            }
        }

        if (isset($config['DB'])) {
            DB::connect($config['DB']);
        } else {
            DB::connect($config);
        }
    }
}
if (!function_exists('balanceFormat')) {
    function balanceFormat($number, $decimals = 0): string
    {
        $number = number_format($number, $decimals, '.', ",");
        if (strpos($number, '.') !== false) {
            $number = rtrim($number, '0');
        }
        return rtrim($number, '.');
    }
}
if (!function_exists('parameterFromUrl')) {
    function parameterFromUrl($para, $number = true)
    {
        $para = $_GET[$para] ?? 0;
        if ($number) {
            $para = preg_match('/\D/', $para) ? 0 : $para;
            return $para ?? 0;
        }
        return $para ?? "";
    }
}

if (!function_exists('getLastStringUri')) {
    function getLastStringUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('/\?.*$/', '', $uri);
        return basename($uri);
    }
}

if (!function_exists('sendRedirect')) {
    function sendRedirect($url, $status = 'success', $id = 0, $other = '')
    {
        if ($id != 0) {
            if ($other != '') {
                redirect(root_base . $url . '?id=' . $id . '&status=' . $status . '&' . $other);
            } else {
                redirect(root_base . $url . '?id=' . $id . '&status=' . $status);
            }
        } else {
            redirect(root_base . $url . '?status=' . $status . $other);
        }
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '<pre>';
        die();
    }
}

if (!function_exists('getStatusCodeMessage')) {
    function getStatusCodeMessage($status): string
    {
        $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}

if (!function_exists('buildPagination')) {
    function buildPagination($uri, $page, $current_items, $total_pages, $total_items, $limit = 50)
    {
        echo '<div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">'
            . ($total_items == 0 ? 0 : ($page * $limit + 1) - $limit) . ' đến ' . ((($page - 1) * $limit) + $current_items) . ' <span class="text-body-tertiary"> Trong </span>' . $total_items
            . '</p>
                    </div>
                    <nav class="col-auto d-flex">
                        <ul class="mb-0 pagination justify-content-end">
                        <li class="page-item ' . ($page == 1 ? 'disabled' : '') . '"><a class="page-link ' . ($page == 1 ? 'disabled' : '') . '" ' . ($page == 1 ? 'disabled=""' : '') . ' href="' . ($uri . ($page - 1)) . '">
                        <span class="fas fa-chevron-left"></span></a></li>';

        if ($page - 3 > 1) {
            echo '<li class="page-item disabled"><a class="page-link" disabled="" type="button" href="javascript:">...</a>';
        }
        for ($i = $page - 3; $i <= $page + 3; $i++) {
            if ($i > 0 && $i <= $total_pages) {
                if ($i == $page) {
                    echo '<li class="page-item active"><a class="page-link" href="javascript:" type="button">' . $i . '</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" type="button" href="' . ($uri . $i) . '">' . $i . '</a></li>';
                }
            }
        }
        if ($page + 3 < $total_pages) {
            echo '<li class="page-item disabled"><a class="page-link" disabled="" type="button" href="javascript:">...</a></li>';
        }
        echo '
                <li class="page-item ' . ($page >= $total_pages ? 'disabled' : '') . '"><a class="page-link ' . ($page >= $total_pages ? 'disabled' : '') . '" ' . ($page >= $total_pages ? 'disabled=""' : '') . ' href="' . ($uri . ($page + 1)) . '">
                <span class="fas fa-chevron-right"></span>
                </a></li>
           </ul> 
        </nav>
    </div>';
    }
}
if (!function_exists('getDateStart2End')) {
    function getDateStart2End($dateRequest, $format = 'Y-m-d'): array
    {
        $start_date = '';
        $end_date = '';
        try {
            if (preg_match('# đến #ui', $dateRequest)) {
                $date = explode(' đến ', $dateRequest);
                $start_date = (new DateTime($date[0]))->format($format);
                $end_date = (new DateTime($date[1]))->format($format);
            } else {
                $start_date = (new DateTime($dateRequest))->format($format);
                $end_date = (new DateTime($dateRequest))->format($format);
            }
            return [
                'start_date' => $start_date,
                'end_date' => $end_date
            ];
        } catch (Exception $e) {
            return [];
        }
    }
}
if (!function_exists('userActiveLog')) {
    function userActiveLog($messages)
    {
        $user = $_SESSION['authentication'];
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');
        $data = [
            'user_id' => $user->id,
            'detail' => $user->name.'(#'.$user->id.'): '.$messages,
            'created_at' => $nowTime,
        ];
        $log = (new Model('user_active_logs'))->create($data);
        (new Model('users'))->update($user->id,[
            'last_active_id' => $log->id
        ]);
    }
}

if (!function_exists('checkRole')) {
    function checkRole($idRole)
    {
        $user = $_SESSION['authentication'];
        $roleAdmin = (new Model('user_role'))->where('user_id',$user->id)->where('role_id',1)->first();
        if($roleAdmin){
            return true;
        }
        $role = (new Model('user_role'))->where('user_id',$user->id)->where('role_id',$idRole)->first();
        if($role){
            return true;
        }
        return false;

    }
}