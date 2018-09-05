<?php
/**
 * Created by PhpStorm.
 * User: zapleo
 * Date: 15.01.18
 * Time: 11:36
 */

namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public function field($model, $attribute, $options = [])
    {
        $field = parent::field($model, $attribute, $options);
        $field->inputOptions['placeholder'] = $model->getAttributeLabel($attribute);
        return $field;
    }
}