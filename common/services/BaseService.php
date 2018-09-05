<?php
namespace common\services;
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 10.05.17
 * Time: 10:06
 */
use common\traits\SessionTrait;
use common\traits\SimpleYiiTrait;
class BaseService
{
    use SimpleYiiTrait, SessionTrait;
    const PARAMS_KEY = '';
    const PARAMS_SECRET = '';


    /**
     * @return mixed
     */
    protected function getKey() {
        return $this->getParams(static::PARAMS_KEY);
    }

    /**
     * @return mixed
     */
    protected function getSecret() {
        return $this->getParams(static::PARAMS_SECRET);
    }

}