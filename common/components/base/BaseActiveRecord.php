<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 15.02.17
 * Time: 15:03
 */
namespace common\components\base;

class BaseActiveRecord extends \yii\db\ActiveRecord
{

    use \common\traits\RelationTrait;
}