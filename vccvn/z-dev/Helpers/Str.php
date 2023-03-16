<?php

/**
 * @author DoanLN
 * @date 2019-04-28
 * @description 
 * 
 */

// namespace Crazy\Helpers;

// use Crazy\Files\Filemanager;

define('CRAZY_LANGUAGE_PATH', dirname(dirname(__FILE__)).'/language');

class Str {
    protected static $lang = 'vi';
    protected static $langData = null;
    /**
     * set language
     * @param string $lang
     */
    public static function setLang($lang = null){
        if(($lang && $lang != static::$lang) || !static::$langData){

            if($lang) static::$lang = $lang;
            $file = new Filemanager(CRAZY_LANGUAGE_PATH);
            
            $data = $file->getJson(static::$lang, true);
            if($data){
                static::$langData = $data;
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * kiểm ta xem xem dc set hay chua
     */
    public static function checkLang()
    {
        if(!static::$langData) return static::setLang(static::$lang);
        return true;
    }

    /**
     * xoa dau tieng viec
     * @param string $string
     * @return string
     */
    public static function clearVi(string $string)
    {
        if(static::checkLang()){
            return str_replace(static::$langData->vi, static::$langData->en, $string);
        }
        return $string;
    }

    /**
     * viet thuong chu 
     * @param string $string
     * @return string
     */
    public static function vnToLower(string $string)
    {
        if(static::checkLang()){
            return str_replace(static::$langData->upper, static::$langData->lower, $string);
        }
        return $string;
    }

    /**
     * viet hoa chu 
     * @param string $string
     * @return string
     */
    public static function vnToUpper(string $string)
    {
        if(static::checkLang()){
            return str_replace(static::$langData->lower, static::$langData->upper, $string);
        }
        return $string;
    }

    /**
     * chuan so
     * @param string $value
     */
    public static function toNumber($value)
    {
        if (is_numeric($value)) {
            $number = (((Int) $value) == $value) ? ((Int) $value) : ((float) $value);
            return $number;
        }
        return 0;
    }

    
    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int     $count
     * @return string
     */
    public static function plural($value, $count = 2)
    {
        return Pluralizer::plural($value, $count);
    }

    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int     $count
     * @return string
     */
    public static function pluralStudly($value, $count = 2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts).self::plural($lastWord, $count);
    }

    
    /**
     * xoa dau tieng viec
     * @param string $string
     * @return string
     */
    public static function jsonVi(string $string)
    {
        if(static::checkLang()){
            return str_replace(static::$langData->jsc, static::$langData->vi, $string);
        }
        return $string;
    }

    

    /**
     * Get the singular form of an English word.
     *
     * @param  string  $value
     * @return string
     */
    public static function singular($value)
    {
        return Pluralizer::singular($value);
    }

    public static function tableName($value)
    {
        return Inflector::tableize(static::plural($value));
    }

    public static function __callStatic($name, $arguments)
    {
        
    }
}