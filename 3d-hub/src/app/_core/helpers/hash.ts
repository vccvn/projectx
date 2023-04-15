import { base64_decode, base64_encode } from "./base64";
import { getArguments, getType, inArray, Num, objectHasKey, Str } from "./utils";


export class Hash
{
    protected _key = null;
    constructor(key:string = '')
    {
        this._key = base64_encode(key);
    }

    crypt(value = null)
    {
        var type = getType(value);
        var input = '';
        var outType = type;
        switch (type) {
            case 'object':
                input = JSON.stringify(value)
                break;
            case 'array':
                input = JSON.stringify(value)
                break;
            case 'boolean':
                input = value ? '1' : '0';
            case 'number':
                input = ""+value;
                break;
            default: 
                outType = 'string';
                input = str_rev_case(value);
        }
        var a = base64_encode(input);
        
        a = base64_encode(substr(Str.rand(), 10, 8)+ this._key + strrev(a));
        
        a = str_rev_case(a);
        
        a = strrev(substr(a, 0, 10)) + strrev(substr(a, 10)) + substr(Str.rand("jhjghhjfghgfcghfserw5567856"), Num.rand(0, 14), 16);
        
        
        a = number_th_all(a);
        
        
        a = '$'+ base64_encode(outType + ' : '+ a);
        a = str_rev_case(a);
        a = base64_encode(strrev(a));
        a = '$'+ number_th_all(a);
        a = str_rev_case(a);
        a = base64_encode(strrev(a));
        // $a = '$'. number_th_all($a);
        
        return a;
    }


    decrypt(str:string)
    {
        var $a = str;
        $a = strrev(base64_decode($a));
        $a = str_rev_case($a);
        $a = substr($a, 1);
        $a = un_number_th_all($a);
        $a = strrev(base64_decode($a));

        // $a = substr($a, 1);
        // $a = un_number_th_all($a);
        // $a = strrev(base64_decode($a));
        
        $a = str_rev_case($a);
        $a = base64_decode(substr($a, 1));

        // return un_number_th_all($a);
        var $arr = $a.split(' : ');
        if($arr.length < 2) return null;
        var $type = $arr[0];
        $a = $arr[1];
        
        $a = un_number_th_all($a);
        // echo $a;
        
        $a = strrev(substr($a, 0, 10)) + strrev(substr($a, 10, strlen($a)-26));
        
        $a = str_rev_case($a);
        
        $a = strrev(substr(base64_decode($a), strlen(this._key) + 8));
        var $raw = base64_decode($a);
        // echo $raw;
        var $out = null;
        switch ($type) {
            case 'object':
                $out = JSON.parse($raw)
                break;
            case 'array':
                $out = JSON.parse($raw)
                break;
            case 'boolean':
                $out = $raw == '1'? true: false;
            case 'number':
                $out = Number($raw);
                break;
            default: 
                $out = str_rev_case($raw);
        }
        return $out;
        
    }

    protected static $instances = [];
    /**
     * get instance of Crazy Has
     * @param string $key Chuỗi khóa
     * @return CrazyHashEngine
     */
    public static getInstance($key = null): Hash
    {
        if($key){
            if(array_key_exists($key, this.$instances)){
                return this.$instances[$key];
            }
            this.$instances[$key] = new Hash($key);
            return this.$instances[$key];
        }
        if(this.$instances.length){
            for (const key in this.$instances) {
                if (Object.prototype.hasOwnProperty.call(this.$instances, key)) {
                    const instance = this.$instances[key];
                    return instance;
                }
            }
        }
        $key = 'default';
        this.$instances[$key] = new Hash($key);
        return this.$instances[$key];
    }
        /**
     * get instance of Crazy Has
     * @param string $key Chuỗi khóa
     * @return CrazyHashEngine
     */
    public static setKey($key):Hash
    {
        if($key){
            if(array_key_exists($key, Hash.$instances)){
                return Hash.$instances[$key];
            }
            Hash.$instances[$key] = new Hash($key);
            return Hash.$instances[$key];
        }
    }

    public static crypt(input, key = null):string
    {
        return Hash.getInstance(key).crypt(input);
    }
    public static decrypt(input, key = null):any
    {
        return Hash.getInstance(key).decrypt(input);
    }
}


function array_flip(arr){
    var b: any = {};
    for (const key in arr) {
        if (Object.prototype.hasOwnProperty.call(arr, key)) {
            const v = arr[key];
            b[v] = key;
        }
    }
    return b;
}

function array_key_exists(key:any, arr:any){
    return objectHasKey(arr, key);
}

function substr(str, ...args:any[]){
    return String.prototype.substr.apply(str, args);
}
function strlen(str){
    return String(str).length;
}
/**
     * dien chu vao doan
     * @param string $text
     */
function str_rev_case($str) {
    var $keyNumber = { "A": 1, "a": -1, "B": 2, "b": -2, "C": 3, "c": -3, "D": 4, "d": -4, "E": 5, "e": -5, "F": 6, "f": -6, "G": 7, "g": -7, "H": 8, "h": -8, "I": 9, "i": -9, "J": 10, "j": -10, "K": 11, "k": -11, "L": 12, "l": -12, "M": 13, "m": -13, "N": 14, "n": -14, "O": 15, "o": -15, "P": 16, "p": -16, "Q": 17, "q": -17, "R": 18, "r": -18, "S": 19, "s": -19, "T": 20, "t": -20, "U": 21, "u": -21, "V": 22, "v": -22, "W": 23, "w": -23, "X": 24, "x": -24, "Y": 25, "y": -25, "Z": 26, "z": -26 };
    var $a = array_flip($keyNumber);
    var $vnKeyNumber = { "À": 1, "à": -1, "Á": 2, "á": -2, "Ạ": 3, "ạ": -3, "Ả": 4, "ả": -4, "Ã": 5, "ã": -5, "Â": 6, "â": -6, "Ầ": 7, "ầ": -7, "Ấ": 8, "ấ": -8, "Ậ": 9, "ậ": -9, "Ẩ": 10, "ẩ": -10, "Ẫ": 11, "ẫ": -11, "Ă": 12, "ă": -12, "Ằ": 13, "ằ": -13, "Ắ": 14, "ắ": -14, "Ặ": 15, "ặ": -15, "Ẳ": 16, "ẳ": -16, "Ẵ": 17, "ẵ": -17, "È": 18, "è": -18, "É": 19, "é": -19, "Ẹ": 20, "ẹ": -20, "Ẻ": 21, "ẻ": -21, "Ẽ": 22, "ẽ": -22, "Ê": 23, "ê": -23, "Ề": 24, "ề": -24, "Ế": 25, "ế": -25, "Ệ": 26, "ệ": -26, "Ể": 27, "ể": -27, "Ễ": 28, "ễ": -28, "Ì": 29, "ì": -29, "Í": 30, "í": -30, "Ị": 31, "ị": -31, "Ỉ": 32, "ỉ": -32, "Ĩ": 33, "ĩ": -33, "Ò": 34, "ò": -34, "Ó": 35, "ó": -35, "Ọ": 36, "ọ": -36, "Ỏ": 37, "ỏ": -37, "Õ": 38, "õ": -38, "Ô": 39, "ô": -39, "Ồ": 40, "ồ": -40, "Ố": 41, "ố": -41, "Ộ": 42, "ộ": -42, "Ổ": 43, "ổ": -43, "Ỗ": 44, "ỗ": -44, "Ơ": 45, "ơ": -45, "Ờ": 46, "ờ": -46, "Ớ": 47, "ớ": -47, "Ợ": 48, "ợ": -48, "Ở": 49, "ở": -49, "Ỡ": 50, "ỡ": -50, "Ù": 51, "ù": -51, "Ú": 52, "ú": -52, "Ụ": 53, "ụ": -53, "Ủ": 54, "ủ": -54, "Ũ": 55, "ũ": -55, "Ư": 56, "ư": -56, "Ừ": 57, "ừ": -57, "Ứ": 58, "ứ": -58, "Ự": 59, "ự": -59, "Ử": 60, "ử": -60, "Ữ": 61, "ữ": -61, "Ỳ": 62, "ỳ": -62, "Ý": 63, "ý": -63, "Ỵ": 64, "ỵ": -64, "Ỷ": 65, "ỷ": -65, "Ỹ": 66, "ỹ": -66, "Đ": 67, "đ": -67 };
    var $b = array_flip($vnKeyNumber);
    var $out = '';

    var $t = strlen($str);
    for (var $i = 0; $i < $t; $i++) {
        let $s = substr($str, $i, 1);
        if (array_key_exists($s, $keyNumber)) {
            $out+= $a[-$keyNumber[$s]];
        } else if(array_key_exists($s, $vnKeyNumber)) {
            $out+= $b[-$vnKeyNumber[$s]];
        } else {
            $out+= $s;
        }
    }
    return $out;
}
/**
 * dien chu vao doan
 * @param string $number
 */
function number_th($number) {
    var $a = {
        '0': ['`', ','],
        '1': ['[', '|', '"'],
        '2': ['/', '~'],
        '3': [' ', ";"],
        '4': ['.', '+'],
        '5': ['<', '^'],
        '6': ['-', ':', "'"],
        '7': [')', '#', '_'],
        '8': ['!', '}'],
        '9': ['?', '{', ']']
    };
    if (array_key_exists($number, $a)) {
        let $n = $a[$number];
        return $n[Num.rand(0, $n.length - 1)];
    }
    return $number;
}

/**
 * dien chu vao doan
 * @param string $number
 */
function un_number_th($s) {
    var $a = [
        ['`', ','],
        ['[', '|', '"'],
        ['/', '~'],
        [' ', ";"],
        ['.', '+'],
        ['<', '^'],
        ['-', ':', "'"],
        [')', '#', '_'],
        ['!', '}'],
        ['?', '{', ']']
    ];

    for (let i = 0; i < $a.length; i++) {
        const arr = $a[i];
        if (inArray(arr, $s)) return i;
    }
    return $s;
}



/**
 * dien chu vao doan
 * @param string $text
 */
function number_th_all($str) {
    var str = String($str)
    var $out = '';
    for (var $i = 0; $i < str.length; $i++) {
        let $s = str[$i]
        $out+= number_th($s);
    }
    return $out;
}


/**
 * dien chu vao doan
 * @param string $text
 */
function un_number_th_all($str) {
    var str = String($str);
    var $out = '';
    for (var $i = 0; $i < str.length; $i++) {
        let $s = str[$i]
        $out+= un_number_th($s);
    }
    return $out;
}


function strrev(str:any){
    return String(str).split("").reverse().join("");
}