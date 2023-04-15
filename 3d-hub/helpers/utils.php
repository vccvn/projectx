<?php

define('__ARRAY__', 'array:<!--ARRAY--TYPE--BY ARRAY CHECK TYPE-->');
define('__NUMERIC__', 'numeric:<!--NUMERIC--TYPE--BY ARRAY CHECK TYPE-->');
define('__INT__', 'int:<!--INT--TYPE--BY ARRAY CHECK TYPE-->');
define('__INTEGER__', 'int:<!--INTEGER--TYPE--BY ARRAY CHECK TYPE-->');
define('__FLOAT__', 'float:<!--FLOAT--TYPE--BY ARRAY CHECK TYPE-->');
define('__BOOLEAN__', 'boolean:<!--BOOLEAN--TYPE--BY ARRAY CHECK TYPE-->');
define('__BOOL__', 'bool:<!--BOOL--TYPE--BY ARRAY CHECK TYPE-->');
define('__STRING__', 'string:<!--STRING--TYPE--BY ARRAY CHECK TYPE-->');
define('__OBJECT__', 'object:<!--OBJECT--TYPE--BY ARRAY CHECK TYPE-->');
define('__JSON__', 'json:<!--JSON--TYPE--BY ARRAY CHECK TYPE-->');
define('__ANY__', 'any:<!--ANY-TYPE--BY ARRAY CHECK TYPE-->');


if (!defined('ARRAY')) define('ARRAY', __ARRAY__);
if (!defined('NUMERIC')) define('NUMERIC', __NUMERIC__);
if (!defined('INT')) define('INT', __INT__);
if (!defined('INTEGER')) define('INTEGER', __INTEGER__);
if (!defined('FLOAT')) define('FLOAT', __FLOAT__);
if (!defined('BOOLEAN')) define('BOOLEAN', __BOOLEAN__);
if (!defined('BOOL')) define('BOOL', __BOOL__);
if (!defined('STRING')) define('STRING', __STRING__);
if (!defined('OBJECT')) define('OBJECT', __OBJECT__);
if (!defined('JSON')) define('JSON', __JSON__);
if (!defined('ANY')) define('ANY', __ANY__);

use Crazy\Helpers\Arr as CrazyArr;
use App\Jobs\CrazySendEmail;
use Carbon\Carbon;

if (!function_exists('queue_mail')) {
    /**
     * đưa mail vào hàng đợi. chờ gửi
     */
    function queue_mail($email)
    {
        $emailJob = (new CrazySendEmail($email))->delay(Carbon::now()->addMinutes(1));
        dispatch($emailJob);
    }
}

if (!function_exists('is_email')) {
    /**
     * kiểm tra giá trị nhập vào có phải email hay không
     *
     * @param string $str
     * @return boolean
     */
    function is_email($str)
    {
        if (filter_var($str, FILTER_VALIDATE_EMAIL)) return true;
        return false;
    }
}

if (!function_exists('crazy_arr')) {
    /**
     * tạo đối tượng Arr
     * @param mixed $array
     * @return CrazyArr
     */
    function crazy_arr($array = null)
    {
        return new CrazyArr($array);
    }
}

if (!function_exists('object_to_array')) {
    /**
     * convert object thành mảng
     * @param object $d
     * 
     * @return array
     */
    function object_to_array($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }
}


if (!function_exists('string_to_array')) {
    function string_to_array($s)
    {
        parse_str($s, $a);
        if ($a) return $a;

        return [];
    }
}

if (!function_exists('to_array_by_nl')) {
    function to_array_by_nl($string)
    {
        $a = explode("\r\n", $string);
        $b = [];
        if ($a) {
            foreach ($a as $v) {
                if ($c = trim($v)) {
                    $b[] = $c;
                }
            }
        }
        return $b;
    }
}

if (!function_exists('nl2array')) {
    function nl2array($string)
    {
        $b = [];
        if ($string) {
            if (count($a = explode("\r\n", $string))) {
                foreach ($a as $v) {
                    if ($c = trim($v)) {
                        $b[] = $c;
                    }
                }
            } elseif (count($d = explode("\n\r", $string))) {
                foreach ($d as $v) {
                    if ($c = trim($v)) {
                        $b[] = $c;
                    }
                }
            } else {
                $b = [$string];
            }
        } else {
            $b = [$string];
        }
        return $b;
    }
}



if (!function_exists('array_assign_value')) {
    function array_assign_value($array, $key, $value = null)
    {
        $a = is_array($array) ? $array : (is_object($array) ? object_to_array($array) : []);
        if (is_string($key) || is_numeric($key)) {
            if (is_object($value) || is_array($value)) {
                if (!array_key_exists($key, $a)) {
                    $a[$key] = $value;
                } elseif (is_array($a[$key])) {
                    $a[$key] = array_assign_value($a[$key], $value);
                } else {
                    $a[$key] = $value;
                }
            } else {
                $a[$key] = $value;
            }
        } elseif (is_array($key) || is_object($key)) {
            foreach ($key as $k => $vl) {
                if (!array_key_exists($k, $a)) {
                    $a[$k] = $vl;
                } elseif (is_array($a[$k])) {
                    if (is_object($vl) || is_array($vl)) {
                        $a[$k] = array_assign_value($a[$k], $vl);
                    } else {
                        $a[$k] = $vl;
                    }
                } else {
                    $a[$k] = $vl;
                }
            }
        }
        return $a;
    }
}

if (!function_exists('array_assign_structure_if_not_exists')) {
    function array_assign_structure_if_not_exists($array, $key, $value = null)
    {
        $a = is_array($array) ? $array : (is_object($array) ? object_to_array($array) : []);
        if (is_string($key) || is_numeric($key)) {
            if (is_array($value)) {
                if (!array_key_exists($key, $a)) {
                    $a[$key] = $value;
                } elseif (is_array($a[$key])) {
                    $a[$key] = array_assign_structure_if_not_exists($a[$key], $value);
                } else {
                    $a[$key] = $value;
                }
            } elseif (!array_key_exists($key, $a)) {
                $a[$key] = $value;
            }
        } elseif (is_array($key) || is_object($key)) {
            foreach ($key as $k => $vl) {
                if (!array_key_exists($k, $a)) {
                    $a[$k] = $vl;
                } elseif (is_array($a[$k])) {
                    if (is_array($vl)) {
                        $a[$k] = array_assign_structure_if_not_exists($a[$k], $vl);
                    } else {
                        $a[$k] = $vl;
                    }
                } elseif (is_array($vl)) {
                    $a[$k] = $vl;
                }
            }
        }
        return $a;
    }
}



if (!function_exists('array_check_value_type')) {

    /**
     * kiểm tra cấu trúc mảng
     *
     * @param mixed giá trị cần kiểm tra
     * @param mixed $type kiểu dữ liệu
     * @return boolean
     */
    function array_check_value_type($value, $type): bool
    {
        static $arrayTypes = [__ARRAY__, __NUMERIC__, __INT__, __INTEGER__, __FLOAT__, __BOOLEAN__, __BOOL__, __STRING__, __OBJECT__, __JSON__, __ANY__];
        if (in_array($type, $arrayTypes)) {
            $a = explode(':', $type);
            $t = $a[0];
            switch ($type) {
                case __INT__:
                case __INTEGER__:
                    if ((int) $value != $value) return false;
                    
                    break;
                case __NUMERIC__:
                case __FLOAT__:
                    if (!is_numeric($value)) return false;
                    break;
                case __BOOLEAN__:
                case __BOOL__:
                    if (!is_bool($value)) return false;
                    break;
                case __ANY__:
                    return true;
                    break;
                default:
                    return gettype($value) == $t;
                    break;
            }
            return true;
        } elseif (gettype($value) != gettype($type)) return false;
        elseif (is_array($value)) return array_check_structure($value, $type);
        return $value == $type;
    }
}

if (!function_exists('array_check_key_value_type')) {
    /**
     * kiểm tra cấu trúc mảng
     *
     * @param array $array mảng cần kiểm tra
     * @param string $key key cần kiểm tra
     * @param mixed $valueType
     * @return boolean
     */
    function array_check_key_value_type($array, $key, $valueType): bool
    {
        if ($key == '*') {
            foreach ($array as $k => $v) {
                $a = array_check_value_type($v, $valueType);
                if(!$a) return false;
            }
            return true;
        }

        $last = substr($key, strlen($key) - 1, 1);

        if (!array_key_exists($key, $array)) {
            if ($last != '?') return false;
            return true;
        }
        return array_check_value_type($array[$key], $valueType);
    }
}

if (!function_exists('array_check_structure')) {
    /**
     * kiểm tra cấu trúc mảng
     *
     * @param array $array mảng cần kiểm tra
     * @param array $structure mảng cấu trúc
     * @return boolean
     */
    function array_check_structure($array, $structure, $deepCheck = false): bool
    {
        if (!is_array($array) || !is_array($structure)) return false;
        foreach ($structure as $key => $type) {
            $a =  array_check_key_value_type($array, $key, $type);
            if(!$a) {
                return false;
            }
        }
        return true;
    }
}




if (!function_exists('get_video_from_url')) {
    /**
     * lây thong tin video từ url.
     * hỗ trợ youtube là chính =)))
     * @param string $url
     * 
     * @return Crazy\Helpers\Arr
     */
    function get_video_from_url($url = null)
    {
        if (!$url) return null;
        $a = [];
        if (preg_match_all('/.*youtu\.be\/(.*?)($|\?|#)/si', $url, $m)) {
            $a['id'] = $m[1][0];
            $a['server'] = 'youtube';
            $a['thumbnail'] = 'http://img.youtube.com/vi/' . $a['id'] . '/hqdefault.jpg';
            $a['embed_url'] = "http://www.youtube.com/embed/$a[id]";
        } elseif (preg_match_all('/youtube\.com\/watch\?.*v=(.*?)($|&|#)/si', $url, $m)) {
            $a['id'] = $m[1][0];
            $a['server'] = 'youtube';
            $a['thumbnail'] = 'http://img.youtube.com/vi/' . $a['id'] . '/hqdefault.jpg';
            $a['embed_url'] = "http://www.youtube.com/embed/$a[id]";
        } elseif (preg_match_all('/\.*vimeo.com\/(.*?)($|\?)/si', $url, $m)) {
            $v = explode('/', $m[1][0]);
            $a['id'] = $v[count($v) - 1];
            $a['server'] = 'vimeo';
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $a['id'] . ".php"));
            $a['thumbnail'] = $hash[0]['thumbnail_large'];
            $a['embed_url'] = "http://player.vimeo.com/video/$a[id]?wmode=opaque";
        } elseif (preg_match_all('/.*facebook.com\/(.*?)\/videos\/(.*?)\//si', $url, $m)) {
            $a['id'] = $m[2][0];
            $a['page_id'] = $m[1][0];
            $a['server'] = 'facebook';
            $a['thumbnail'] = null;
            $ac = urlencode(url('/'));
            $a['embed_url'] = "https://www.facebook.com/v2.0/plugins/video.php?allowfullscreen=true&container_width=620&href=$ac%2F$a[page_id]%2Fvideos%2Fvb.$a[page_id]%2F$a[id]%2F%3Ftype%3D3&locale=en_US&sdk=joey";
        }
        if (!$a) return null;
        $obj = new CrazyArr($a);
        return $obj;
    }
}

if (!function_exists('get_array_element')) {
    /**
     * lấy ra thông tin phần tử bao gồm key và value
     * @param mixed $needle
     * @param array $array
     * 
     * @return array
     */
    function get_array_element($needle = null, $array = [])
    {
        if (is_array($array)) {
            if ((is_string($needle) || is_numeric($needle)) && array_key_exists($needle, $array)) {
                return [
                    'key' => $needle,
                    'value' => $array[$needle]
                ];
            } else {
                foreach ($array as $key => $value) {
                    if ($needle == $value) return compact('key', 'value');
                }
            }
        }
        return [];
    }
}

if (!function_exists('array_contains')) {
    /**
     * kiểm tra một mảng có chứa các phần tử của mảng khác hay không
     *
     * @param array $wrapper Mảng chính
     * @param array $child mảng con
     * @return bool
     */
    function array_contains(array $wrapper = [], array $child = []): bool
    {
        return count(array_intersect($wrapper, $child)) == count($child);
    }
}

if (!function_exists('array_check_keys')) {
    /**
     * kiểm tra danh sách key có tồn tại trong mảng hay ko
     *
     * @param array $array
     * @param array $keys
     * @return bool
     */
    function array_check_keys(array $array = [], ...$keys): bool
    {
        if (isset($keys[0]) && is_array($keys[0])) {
            $check = $keys[0];
        } else {
            $check = $keys;
        }
        return array_contains(array_keys($array), $check);
    }
}


if (!function_exists('array_has_any')) {
    /**
     * kiểm tra danh sách key có tồn tại trong mảng hay ko
     *
     * @param array $array
     * @param array $keys
     * @return bool
     */
    function array_has_any(array $array = [], ...$keys): bool
    {
        if (isset($keys[0]) && is_array($keys[0])) {
            $check = $keys[0];
        } else {
            $check = $keys;
        }
        $a = count(array_intersect(array_keys($array), $check)) > 0;
        return $a;
    }
}


if (!function_exists('array_any_val')) {
    /**
     * kiểm tra danh sách giá trị có tồn tại trong mảng hay ko
     *
     * @param array $array
     * @param array $keys
     * @return bool
     */
    function array_any_val(array $array = [], ...$keys): bool
    {
        if (isset($keys[0]) && is_array($keys[0])) {
            $check = $keys[0];
        } else {
            $check = $keys;
        }
        $a = count(array_intersect(array_values($array), $check)) > 0;
        return $a;
    }
}


if (!function_exists('array_remove_key')) {
    /**
     * kiểm tra danh sách giá trị có tồn tại trong mảng hay ko
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    function array_remove_key(array $array = [], ...$keys): array
    {
        if (isset($keys[0]) && is_array($keys[0])) {
            $check = $keys[0];
        } else {
            $check = $keys;
        }
        if ($check) {
            foreach ($check as $key) {
                unset($array[$key]);
            }
        }
        return $array;
    }
}


if (!function_exists('array_copy')) {
    /**
     * lấy danh sách phần tử mảng ban đầu theo danh sách key đã cho. 
     * nếu key nào không có giá trị sẽ trả về null
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    function array_copy(array $array = [], ...$keys): array
    {
        if (isset($keys[0]) && is_array($keys[0])) {
            $list = $keys[0];
        } else {
            $list = $keys;
        }
        $newArray = [];
        foreach ($list as $key) {
            if (array_key_exists($key, $array)) {
                $newArray[$key] = $array[$key];
            } else {
                $newArray[$key] = null;
            }
        }
        return $newArray;
    }
}




if (!function_exists('str_eval')) {
    /**
     * dien chu vao doan
     * @param string $text
     * @param array $data
     * @param int $char_type
     * @param string $char_start
     */
    function str_eval($text = null, $data = null, $char_type = 0, $char_start = '$')
    {
        $type = [
            0 => ['start' => '{', 'end' => '}'],
            1 => ['start' => '[', 'end' => ']'],
            2 => ['start' => '(', 'end' => ')'],
            3 => ['start' => '/*', 'end' => '*/'],
            5 => ['start' => '<', 'end' => '>'],
        ];
        $chars = ['$', '@', '%', '', '*', 'sd:'];
        if (!is_string($text) && !is_array($data)) {
            return $text;
        }

        $start = '{';
        $end = '}';
        $char = '';
        if (is_array($char_type)) {
            if (count($char_type) == 2) {
                $start = $char_type[0];
                $end = $char_type[1];
            }
        } elseif (isset($type[$char_type])) {
            $ty = $type[$char_type];
            $start = $ty['start'];
            $end = $ty['end'];
        } elseif (is_string($char_type)) {
            $start = $char_type;
            if (strlen($char_type) > 1) {
                $end = '';
                $n = strlen($char_type) - 1;
                for ($i = $n; $i >= 0; $i--) {
                    $end .= substr($char_type, $i, 1);
                }
            } else {
                $end = $start;
            }
        }
        if (in_array($char_start, $chars)) {
            $char = $char_start;
        } elseif ($char_start && isset($chars[$char_start])) {
            $char = $chars[$char_start];
        } elseif ($char_start) {
            $char = $char_start;
        }
        $find = [];
        $replace = [];

        foreach ($data as $name => $val) {
            if (is_array($val)) {
                continue;
            }

            $find[] = $start . $char . $name . $end;
            $replace[] = $val;
        }

        $txt = str_replace($find, $replace, $text);
        $txt = preg_replace('/[^\{]\{\$[A-z0-9_]\}[^\}]/i', '', $txt);

        return $txt;
    }
}


if (!function_exists('str_rev_case')) {
    /**
     * dien chu vao doan
     * @param string $text
     */
    function str_rev_case($str)
    {
        $keyNumber = json_decode('{"A": 1,"a": -1,"B": 2,"b": -2, "C": 3,"c": -3,"D": 4, "d": -4, "E": 5, "e": -5, "F": 6, "f": -6, "G": 7, "g": -7, "H": 8, "h": -8, "I": 9, "i": -9, "J": 10, "j": -10, "K": 11, "k": -11, "L": 12, "l": -12, "M": 13, "m": -13, "N": 14, "n": -14, "O": 15, "o": -15, "P": 16, "p": -16, "Q": 17, "q": -17, "R": 18, "r": -18, "S": 19, "s": -19, "T": 20,"t": -20,"U": 21,"u": -21,"V": 22,"v": -22,"W": 23,"w": -23,"X": 24,"x": -24,"Y": 25,"y": -25,"Z": 26,"z": -26}', true);
        $a = array_flip($keyNumber);
        $vnKeyNumber = json_decode('{"À":1,"à":-1,"Á":2,"á":-2,"Ạ":3,"ạ":-3,"Ả":4,"ả":-4,"Ã":5,"ã":-5,"Â":6,"â":-6,"Ầ":7,"ầ":-7,"Ấ":8,"ấ":-8,"Ậ":9,"ậ":-9,"Ẩ":10,"ẩ":-10,"Ẫ":11,"ẫ":-11,"Ă":12,"ă":-12,"Ằ":13,"ằ":-13,"Ắ":14,"ắ":-14,"Ặ":15,"ặ":-15,"Ẳ":16,"ẳ":-16,"Ẵ":17,"ẵ":-17,"È":18,"è":-18,"É":19,"é":-19,"Ẹ":20,"ẹ":-20,"Ẻ":21,"ẻ":-21,"Ẽ":22,"ẽ":-22,"Ê":23,"ê":-23,"Ề":24,"ề":-24,"Ế":25,"ế":-25,"Ệ":26,"ệ":-26,"Ể":27,"ể":-27,"Ễ":28,"ễ":-28,"Ì":29,"ì":-29,"Í":30,"í":-30,"Ị":31,"ị":-31,"Ỉ":32,"ỉ":-32,"Ĩ":33,"ĩ":-33,"Ò":34,"ò":-34,"Ó":35,"ó":-35,"Ọ":36,"ọ":-36,"Ỏ":37,"ỏ":-37,"Õ":38,"õ":-38,"Ô":39,"ô":-39,"Ồ":40,"ồ":-40,"Ố":41,"ố":-41,"Ộ":42,"ộ":-42,"Ổ":43,"ổ":-43,"Ỗ":44,"ỗ":-44,"Ơ":45,"ơ":-45,"Ờ":46,"ờ":-46,"Ớ":47,"ớ":-47,"Ợ":48,"ợ":-48,"Ở":49,"ở":-49,"Ỡ":50,"ỡ":-50,"Ù":51,"ù":-51,"Ú":52,"ú":-52,"Ụ":53,"ụ":-53,"Ủ":54,"ủ":-54,"Ũ":55,"ũ":-55,"Ư":56,"ư":-56,"Ừ":57,"ừ":-57,"Ứ":58,"ứ":-58,"Ự":59,"ự":-59,"Ử":60,"ử":-60,"Ữ":61,"ữ":-61,"Ỳ":62,"ỳ":-62,"Ý":63,"ý":-63,"Ỵ":64,"ỵ":-64,"Ỷ":65,"ỷ":-65,"Ỹ":66,"ỹ":-66,"Đ":67,"đ":-67}', true);
        $b = array_flip($vnKeyNumber);
        $out = '';

        $t = strlen($str);
        for ($i = 0; $i < $t; $i++) {
            $s = substr($str, $i, 1);
            if (array_key_exists($s, $keyNumber)) {
                $out .= $a[-$keyNumber[$s]];
            } elseif (array_key_exists($s, $vnKeyNumber)) {
                $out .= $b[-$vnKeyNumber[$s]];
            } else {
                $out .= $s;
            }
        }
        return $out;
    }
}

if (!function_exists('number_th')) {
    /**
     * dien chu vao doan
     * @param string $number
     */
    function number_th($number)
    {
        $a = [
            '0' => ['`', ','],
            '1' => ['[', '|', '"'],
            '2' => ['/', '~'],
            '3' => [' ', ";"],
            '4' => ['.', '+'],
            '5' => ['<', '^'],
            '6' => ['-', ':', "'"],
            '7' => [')', '#', '_'],
            '8' => ['!', '}',],
            '9' => ['?', '{', ']']
        ];
        if (array_key_exists($number, $a)) {
            $n = $a[$number];
            return $n[rand(0, count($n) - 1)];
        }
        return $number;
    }
}
if (!function_exists('un_number_th')) {
    /**
     * dien chu vao doan
     * @param string $number
     */
    function un_number_th($s)
    {
        $a = [
            '0' => ['`', ','],
            '1' => ['[', '|', '"'],
            '2' => ['/', '~'],
            '3' => [' ', ";"],
            '4' => ['.', '+'],
            '5' => ['<', '^'],
            '6' => ['-', ':', "'"],
            '7' => [')', '#', '_'],
            '8' => ['!', '}',],
            '9' => ['?', '{', ']']
        ];

        foreach ($a as $n => $arr) {
            if (in_array($s, $arr)) return $n;
        }
        return $s;
    }
}


if (!function_exists('number_th_all')) {
    /**
     * dien chu vao doan
     * @param string $text
     */
    function number_th_all($str)
    {
        $out = '';
        $t = strlen($str);
        for ($i = 0; $i < $t; $i++) {
            $s = substr($str, $i, 1);
            $out .= number_th($s);
        }
        return $out;
    }
}

if (!function_exists('un_number_th_all')) {
    /**
     * dien chu vao doan
     * @param string $text
     */
    function un_number_th_all($str)
    {
        $out = '';
        $t = strlen($str);
        for ($i = 0; $i < $t; $i++) {
            $s = substr($str, $i, 1);
            $out .= un_number_th($s);
        }
        return $out;
    }
}




if (!function_exists('to_number')) {
    /**
     * chuan so
     * @param string $value
     */
    function to_number($value)
    {
        if (is_numeric($value)) {
            $number = (((int) $value) == $value) ? ((int) $value) : ((float) $value);
            return $number;
        }
        return 0;
    }
}







if (!function_exists('vnclean')) {
    /**
     * Chuyển tất cả các chữ cái trong chuỗi tiếng Việt về không dấu
     * @param string $string
     * @return string
     */
    function vnclean($string)
    {

        // tạm thời chưa có nên dùng tạm của php
        return \Crazy\Helpers\Str::clearVi($string);
    }
}

if (!function_exists('vntolower')) {
    /**
     * Chuyển tất cả các chữ cái trong chuỗi tiếng Việt về chữ viết thường
     * @param string $string
     * @return string
     */
    function vntolower($string)
    {

        // tạm thời chưa có nên dùng tạm của php
        return \Crazy\Helpers\Str::vnToLower($string);
    }
}


if (!function_exists('vntoupper')) {
    /**
     * Chuyển tất cả các chữ cái trong chuỗi tiếng Việt về chữ viết Hoa
     * @param string $string
     * @return string
     */
    function vntoupper($string)
    {

        // tạm thời chưa có nên dùng tạm của php
        return \Crazy\Helpers\Str::vnToUpper($string);
    }
}

if (!function_exists('vnucfirst')) {
    /**
     * Viết hoa chữ đầu dòng trong chuỗi tiếng Việt
     * @param string $string
     * @return string
     */
    function vnucfirst($string)
    {

        // tạm thời chưa có nên dùng tạm của php
        return ucfirst($string);
    }
}


if (!function_exists('vnucwords')) {
    /**
     * Viết hoa chữ đầu mỗi từ trong chuỗi tiếng Việt
     * @param string $string
     * @return string
     */
    function vnucwords($string)
    {

        // tạm thời chưa có nên dùng tạm của php
        return ucwords($string);
    }
}

if (!function_exists('str_slug')) {
    /**
     * lấy slug của một chuỗi
     * @param string $string
     * 
     * @return string
     */
    function str_slug(...$params)
    {

        // tạm thời chưa có nên dùng tạm của php
        return Str::slug(...$params);
    }
}
if (!function_exists('str_plural')) {
    /**
     * lấy chuỗi dạng số nhiều
     * @param string $string
     * 
     * @return string
     */
    function str_plural(...$params)
    {

        // tạm thời chưa có nên dùng tạm của php
        return Str::plural(...$params);
    }
}
if (!function_exists('str_limit')) {
    /**
     * sub string
     * @param string $string
     * 
     * @return string
     */
    function str_limit(...$params)
    {

        // tạm thời chưa có nên dùng tạm của php
        return Str::limit(...$params);
    }
}


if (!function_exists('get_validation_params')) {

    function get_validation_params(array $parameters = [])
    {
        $pars = [];
        foreach ($parameters as $p) {
            if ($par = trim($p)) {
                $pars[] = $par;
            }
        }
        return $pars;
    }
}


if (!function_exists('strtodate')) {
    function strtodate(string $string)
    {
        $string = trim($string);
        $y = 0;
        $m = 0;
        $d = 0;
        $k = null;
        $l = 0;
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/i', $string)) {
            $k = '/';
        } elseif (preg_match('/^\d{1,2}\-\d{1,2}\-\d{4}$/i', $string)) {
            $k = '-';
        } elseif (preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/i', $string)) {
            $k = '-';
            $l = 1;
        } elseif (preg_match('/^\d{1,2}\.\d{1,2}\.\d{4}$/i', $string)) {
            $k = '.';
            $l = 3;
        }

        if ($k) {
            $dd = explode($k, $string);
            if ($l == 1) {
                if (is_date($dd[2], $dd[1], $dd[0])) {
                    $y = $dd[0];
                    $m = $dd[1];
                    $d = $dd[2];
                }
            } elseif ($l == 3 || $k = '/') {
                if (is_date($dd[0], $dd[1], $dd[2])) {
                    $y = $dd[2];
                    $m = $dd[1];
                    $d = $dd[0];
                } elseif (is_date($dd[1], $dd[0], $dd[2])) {
                    $y = $dd[2];
                    $m = $dd[0];
                    $d = $dd[1];
                }
            } elseif (is_date($dd[0], $dd[1], $dd[2])) {
                $y = $dd[2];
                $m = $dd[1];
                $d = $dd[0];
            }
        }
        if ($y && $m && $d) return [
            'day' => $d,
            'month' => $m,
            'year' => $y
        ];
        return [];
    }
}

if (!function_exists('is_date')) {
    function is_date($day = 0, $month = 0, $year = 0)
    {
        if (!$day || !$month || !$year || !is_numeric($day) || !is_numeric($month) || !is_numeric($year) || $day < 1 || $day > 31 || $month < 1 || $month > 12) {
            return false;
        }
        $day = (int) $day;
        $month = (int) $month;
        $year = (int) $year;
        $status = false;
        switch ($month) {
            case '2':
                if ($day == 29) {
                    if ($year % 100 == 0) {
                        $year = $year / 100;
                    }
                    $status = ($year % 4 == 0);
                } elseif ($day > 29) $status =  false;
                else $status = true;

                break;
            case '4':
            case '6':
            case '9':
            case '11':
                $status = ($day < 31);
                break;
            default:
                $status = ($day < 32);
                break;
        }
        return $status;
    }
}


if (!function_exists('get_time_seconds')) {
    function get_time_seconds($time = null)
    {
        $xs = [1, 60, 3600];
        $time = $time ? $time : date('G:i:s');
        $times = explode(':', $time);
        $timeSeconds = 0;
        $c = count($times);
        if ($c <= 3) {
            $n = 0;
            for ($i = $c - 1; $i >= 0; $i--) {
                $nb = (int) $times[$i];
                $timeSeconds += $nb * $xs[$n];
                $n++;
            }
        }
        return $timeSeconds;
    }
}

if (!function_exists('check_time_format')) {
    function check_time_format($time = null)
    {
        if (!is_string($time) || !$time) return false;
        if (($t = count($arrTime = explode(':', $time))) >= 2) {
            if ($t > 3) return false;
            $arrMax = [23, 59, 59];
            $end = ($t > 3) ? 3 : $t;
            for ($i = 0; $i < $end; $i++) {
                if (!is_numeric($arrTime[$i])) return false;
                $s = (int) $arrTime[$i];
                if ($s < 0 || $s > $arrMax[$i]) return false;
            }
            return $t;
        }
        return false;
    }
}


if (!function_exists('get_working_hours')) {
    function get_working_hours($intTime = 0)
    {
        $time = to_number($intTime);
        $hours = floor($time / 3600);
        return $hours;
    }
}

if (!function_exists('get_date_time_array')) {
    function get_date_time_array($time = null)
    {
        if ($time) $dateTime = date("Y-m-d-H-i-s", $time);
        else $dateTime = date("Y-m-d-H-i-s");
        $dateKeys = ['year', 'month', 'day', 'hour', 'minute', 'second'];
        $data = [];
        $p = explode('-', $dateTime);
        foreach ($p as $key => $value) {
            $data[$dateKeys[$key]] = $value;
        }
        return $data;
    }
}

if (!function_exists('parse_date_time')) {
    function parse_date_time($dateTime = null)
    {
        if (!$dateTime) $dateTime = date("Y-m-d H:i:s");
        if (!is_string($dateTime)) return [];
        $dateKeys = ['year', 'month', 'day', 'hour', 'minute', 'second'];
        $dateKeyGroup = [['year', 'month', 'day'], ['hour', 'minute', 'second']];
        $data = ['year' => 1980, 'month' => '01', 'day' => '01', 'hour' => '00', 'minute' => '00', 'second' => '00'];

        $old = '';
        $p = explode(' ', trim($dateTime));
        $i = -1;
        $de = ['-', ':'];
        foreach ($p as $path) {
            if ($path) $i++;
            else continue;
            if ($i >= 2) break;
            $d = $de[$i];
            if ($d == $old) continue;
            if (count($time = explode($d, $path)) >= 1) {
                for ($j = 0; $j < 3; $j++) {
                    if (isset($time[$j])) {
                        $data[$dateKeyGroup[$i][$j]] = $time[$j];
                    }
                }
            }
        }
        return $i == 1 ? $data : [];
    }
}

if (!function_exists('get_date_range')) {
    /**
     * kiểm tra và lấy dữ liệu date range
     * @param string $string chuỗi chứa thời gian cần kiểm tra
     * @param string $split_char chuỗi ngăn cch1 2 vế
     * @return array Trả về mảng định dạng thời gian hoạc mảng rỗng
     */
    function get_date_range($string, $split_char = ' - ')
    {
        if (count($dates = explode($split_char, $string)) == 2) {
            if (($from = strtodate($dates[0])) && ($to = strtodate($dates[1]))) {
                return compact('from', 'to');
            }
        }
        return [];
    }
}


if (!function_exists('get_date_str')) {
    /**
     * Ham lay chuoi date
     */
    function get_date_str($string = null)
    {
        if (is_numeric($string)) {
            return date("Y-m-d", time() + $string * 3600 * 24);
        }
        if ($d = parse_date_time($string)) {
            return "$d[year]-$d[month]-$d[day]";
        }
        return null;
    }
}




if (!function_exists('get_year_options')) {
    /**
     * lấy option các năm cho thẻ select
     * @param string $lang
     * @param int|string $start năm bắt dầu [=năm hiện tại]
     * @param int|string $end $năm kết thúc
     * @return array
     */
    function get_year_options($lang = 'vi', $start = 'current', $end = 'current')
    {
        $l = strtolower($lang);
        $langs = [
            'en' => 'Year',
            'vi' => 'Năm'
        ];
        $label = $l ? (isset($langs[$l]) ? $langs[$l] : $lang) : 'Chọn một';
        $data = [$label];

        $current = to_number(date('Y'));
        $years = ['current' => $current, 'last' => $current - 1, 'next' => $current + 1];

        if (!is_numeric($start)) {
            if (is_string($start) && array_key_exists($sk = strtolower($start), $years)) $start = $years[$sk];
            else $start = $current;
        } elseif ($start < 0) {
            $start = $current + $start;
        }
        if (!is_numeric($end)) {
            if (is_string($end) && array_key_exists($ek = strtolower($end), $years)) $end = $years[$ek];
            else $end = $current;
        } elseif ($end < 0) {
            $end = $current + $end;
        }

        if ($end > $start) {
            for ($i = $start; $i <= $end; $i++) {
                $data[$i] = $i;
            }
        } else {
            for ($i = $start; $i >= $end; $i--) {
                $data[$i] = $i;
            }
        }
        return $data;
    }
}
if (!function_exists('get_month_options')) {
    /**
     * lấy option các tháng cho thẻ select
     * @param string $lang 
     * @param bool $increment Thứ tự tăng hay giảm
     * @return array
     */
    function get_month_options($lang = 'vi', $increment = true)
    {

        $en = [
            'Month', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $vi = ['Tháng'];
        for ($i = 1; $i < 13; $i++) {
            $vi[$i] = 'Tháng ' . $i;
        }
        $months = strtolower($lang) == 'en' ? $en : $vi;
        $data = [$months[0]];
        if (!$increment) {
            for ($i = 12; $i > 0; $i--) {
                $data[$i < 10 ? '0' . $i : $i . ''] = $months[$i];
            }
        } else {
            for ($i = 1; $i < 13; $i++) {
                $data[$i < 10 ? '0' . $i : $i . ''] = $months[$i];
            }
        }
        return $data;
    }
}

if (!function_exists('get_day_options')) {
    /**
     * lấy ngày cho option của select
     * @param string $lang
     * @param boolean $increment
     * 
     * @return array
     */
    function get_day_options($lang = 'vi', $increment = true)
    {
        $label = strtolower($lang) == 'en' ? 'Day' : 'Ngày';
        $data = [$label];
        if ($increment) {
            for ($i = 1; $i < 32; $i++) {
                $data[$i < 10 ? '0' . $i : $i] = $i;
            }
        } else {
            for ($i = 31; $i > 0; $i--) {
                $data[$i < 10 ? '0' . $i : $i] = $i;
            }
        }
        return $data;
    }
}



if (!function_exists('get_number_options')) {
    /**
     * option cho day so
     * @param int $start so bat dau
     * @param int $end so ket thuc
     * @param string $first_text gia tri dau tien
     * @param string|int|float|double $first_value
     * @return array
     */
    function get_number_options($start = 0, $end = 10, $first_text = null, $first_value = null)
    {
        $data = [];
        if ($first_value || $first_text) {
            if ($first_value) {
                if ($first_text) {
                    $data[$first_value] = $first_text;
                } else {
                    $first_value = $first_value;
                }
            } else {
                $data[""] = $first_text;
            }
        }
        if ($start < $end) {
            $a = $start;
            $b = $end;
        } else {
            $a = $end;
            $b = $start;
        }
        for ($i = $a; $i <= $b; $i++) {
            $data[$i] = $i;
        }
        return $data;
    }
}

if (!function_exists('get_folder_size')) {
    function get_folder_size($path, $unit = 'k')
    {
        $f = $path;
        $size = -1;
        if (!in_array($unit, ['k', 'g', 'b', 'm', 't'])) $unit = 'b';
        try {
            $io = popen('/usr/bin/du -s' . $unit . ' ' . $f, 'r');
            $size = fgets($io, 4096);
            $size = substr($size, 0, strpos($size, "\t"));
            pclose($io);
        } catch (Exception $th) {
            //throw $th;
        }

        return $size;
    }
}




if (!function_exists('get_mime_type')) {
    function get_mime_type($type)
    {
        $mimes = get_mime_support();
        $s = strtolower($type);
        if (isset($mimes[$s])) {
            return new CrazyArr([
                'ext' => $s,
                'type' => $mimes[$s]
            ]);
        } else {
            foreach ($mimes as $ext => $mime) {
                if ($s == $mime) {
                    return new CrazyArr([
                        'ext' => $ext,
                        'type' => $mime
                    ]);
                }
            }
        }
        return null;
    }
}

if (!function_exists('get_base64_data')) {
    /**
     * lấy thông tin từ request, kiểm tra xem đúng hay ko
     * dúng trả về mảng
     * sai trả về null
     * @param string $str
     * @return CrazyArr|null
     */
    function get_base64_data($str)
    {
        $filename = null;
        if (count($fileinfo = explode('@', $str)) == 2) {
            $filename = $fileinfo[0];
            $str = $fileinfo[1];
        }
        if (preg_match_all('/^data\:([^;]*);base64,(.*)$/si', $str, $m)) {
            $type = $m[1][0];
            if ($info = get_mime_type($type)) {
                $data = $m[2][0];
                $ext  = $info->ext;
                $ctype = explode('/', $type);
                $filetype = $ctype[0];
                $mime = $ctype[1];
                return new CrazyArr(compact('type', 'data', 'ext', 'filetype', 'mime', 'filename'));
            }
        }
        return null;
    }
}


if (!function_exists('get_mime_support')) {
    /**
     * lấy danh sach kiểu file được hổ trợ
     */
    function get_mime_support()
    {
        return [
            '3gp' => 'video/3gpp',
            '7z' => 'application/x-7z-compressed',
            'aac' => 'audio/x-aac',
            'ai' => 'application/postscript',
            'avi' => 'video/x-msvideo',
            'bmp' => 'image/bmp',
            'css' => 'text/css',
            'csv' => 'text/csv',
            'doc' => 'application/msword',
            'docm' => 'application/vnd.ms-word.document.macroenabled.12',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dot' => 'application/msword',
            'dotm' => 'application/vnd.ms-word.template.macroenabled.12',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'exe' => 'application/x-msdownload',
            'flv' => 'video/x-flv',
            'gif' => 'image/gif',
            'h261' => 'video/h261',
            'h263' => 'video/h263',
            'h264' => 'video/h264',
            'html' => 'text/html',
            'htm' => 'text/html',
            'ico' => 'image/x-icon',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpgv' => 'video/jpeg',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'jsonml' => 'application/jsonml+json',
            'm4a' => 'audio/mp4',
            'mb' => 'application/mathematica',
            'mdb' => 'application/x-msaccess',
            'mka' => 'audio/x-matroska',
            'mkv' => 'video/x-matroska',
            'mp3' => 'audio/mpeg',
            'mp4' => 'video/mp4',
            'ogg' => 'audio/ogg',
            'ogv' => 'video/ogg',
            'ogx' => 'application/ogg',
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroenabled.12',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'psd' => 'image/vnd.adobe.photoshop',
            'ras' => 'image/x-cmu-raster',
            'rgb' => 'image/x-rgb',
            'rq' => 'application/sparql-query',
            'rs' => 'application/rls-services+xml',
            'rsd' => 'application/rsd+xml',
            'rss' => 'application/rss+xml',
            'rtf' => 'application/rtf',
            'rtx' => 'text/richtext',
            's' => 'text/x-asm',
            'ser' => 'application/java-serialized-object',
            'sid' => 'image/x-mrsid-image',
            'sql' => 'application/x-sql',
            'src' => 'application/x-wais-source',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'swf' => 'application/x-shockwave-flash',
            'txt' => 'text/plain',
            'text' => 'text/plain',
            'tpl' => 'application/vnd.groove-tool-template',
            'tpt' => 'application/vnd.trid.tpt',
            'tr' => 'text/troff',
            'ttf' => 'application/x-font-ttf',
            'wav' => 'audio/x-wav',
            'wbs' => 'application/vnd.criticaltools.wbs+xml',
            'weba' => 'audio/webm',
            'webm' => 'video/webm',
            'webp' => 'image/webp',
            'woff' => 'application/font-woff',
            'wri' => 'application/x-mswrite',
            'wrl' => 'model/vrml',
            'xhtml' => 'application/xhtml+xml',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlt' => 'application/vnd.ms-excel',
            'xltm' => 'application/vnd.ms-excel.template.macroenabled.12',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlw' => 'application/vnd.ms-excel',
            'xm' => 'audio/xm',
            'xml' => 'application/xml',
            'xsl' => 'application/xml',
            'xsm' => 'application/vnd.syncml+xml',
            'xyz' => 'chemical/x-xyz',
            'xz' => 'application/x-xz',
            'zip' => 'application/zip'
        ];
    }
}
