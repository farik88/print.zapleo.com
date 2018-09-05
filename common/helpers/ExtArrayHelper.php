<?php

/**
 * Created by PhpStorm.
 * User: decadal
 */

namespace common\helpers;

/**
 * Class ExtArrayHelper
 * @package common\components\helpers
 */
class ExtArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * @param $element
     * @param array $keysForBody
     * @return array
     */
    protected static function getBody($element, $keysForBody = []) {
        if($keysForBody[0] === '*') {
            return $element;
        }
        $value = [];
        //many keys in result from array
        for($i = 0, $size = count($keysForBody); $i < $size; $i++) {
            $valuesKey = $keysForBody[$i];
            //then each result value saving his key
            $value[$valuesKey] = static::getValue($element, $valuesKey);
        }
        return $value;
    }
    /**
     * @inheritdoc
     *
     * ALSO, attention: 
     * 
     *  $array = [
     *     ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
     *     ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
     *     ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
     * ];
     *
     * $result = ArrayHelper::map($array, 'id', ['name', 'class']);
     * // the result is:
     * // [
     * //     '123' => ['name'=>'aaa', 'class' => 'x'],
     * //     '124' => ['name'=>'bbb', 'class' => 'x']
     * //     '345' => ['name'=>'ccc', 'class' => 'y']
     * // ]
     *  
     * also, ['*'] select all keys in array
     * 
     *  $result = ArrayHelper::map($array, 'id', ['*']);
     * // the result is:
     * // [
     * //     '123' => ['name'=>'aaa', 'class' => 'x'],
     * //     '124' => ['name'=>'bbb', 'class' => 'x']
     * //     '345' => ['name'=>'ccc', 'class' => 'y']
     * // ]
     * 
     * @param array $array
     * @param \Closure|string $from
     * @param \Closure|string|array $to
     * @param null $group
     * @return array
     */
    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key = static::getValue($element, $from);
            $value = (is_array($to)) 
                ? self::getBody($element, $to) 
                : static::getValue($element, $to);

            if ($group !== null) {
                $result[static::getValue($element, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /** Если в массиве или объекте $arr есть ключ $key и он задан, то вернёт $arr[$key], иначе вернёт $default.
     *  If array or object $arr has key $key and he is isset, then will be return $arr[$key], $default otherwise
     * @param $key string
     * @param $arr array|object
     * @param $default mixed
     * @return mixed
     */
    public static function getByIssetKey($key, $arr, $default = null) {
        if( !is_array( $arr ) && !is_object( $arr ) ) {
            return $default;
        }
        $arr = (array) $arr;
        return ( isset( $arr[$key] ) )
            ? $arr[$key]
            : $default;
    }

    /** Если в массиве или объекте $arr существует ключ $key, то вернёт $arr[$key], иначе вернёт $default.
     *  If array or object $arr has existing key $key, then will be return $arr[$key], $default otherwise
     * @param $key string
     * @param $arr array|object
     * @param $default mixed
     * @return mixed
     */
    public static function getByExistKey($key, $arr, $default = null) {
        if( !is_array( $arr ) && !is_object( $arr ) ) {
            return $default;
        }
        $arr = (array) $arr;
        return ( array_key_exists( $key, $arr ) )
            ? $arr[$key]
            : $default;
    }

    /**
     * @param $data array, example : [ ['id' => 1, 'caption' => 'capt', 'position' => 'pos' ] ]
     * @param string $key main key, example: 'id'
     * @param array $fields, example: ['caption']
     * @return array, example: [ 1 => ['caption' => 'capt ] ]
     */
    public static function mapDataArray($data, $key = "id", $fields = []) {
        if (empty($fields)) {
            $fields = ['*'];
        }
        return self::map($data, $key, $fields);
    }
}