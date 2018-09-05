<?php
namespace common\components\services;
use common\models\base\SettingRecord;

/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 18.05.17
 * Time: 15:33
 */
class Settings
{
    /**
     * @var null| SettingRecord
     */
    private $_ar = null;

    /**
     * @param $key
     * @return mixed
     */
    public function get($key) {
        if( is_null($this->_ar)) {
            $this->_ar = new SettingRecord();
        }
        return $this->_ar->find()->where(["key" => $key])->asArray()->one()['value'];
    }
}