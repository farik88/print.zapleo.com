<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Sales */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'CoverSale', 
        'relID' => 'cover-sale', 
        'value' => \yii\helpers\Json::encode($model->coverSales),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'LabelSale', 
        'relID' => 'label-sale', 
        'value' => \yii\helpers\Json::encode($model->labelSales),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ProductSale', 
        'relID' => 'product-sale', 
        'value' => \yii\helpers\Json::encode($model->productSales),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="sales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'data_start')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'displayFormat' => 'php:d-m-Y H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Data',
                'autoclose' => true,
            ]
        ],
    ]);?>

    <?= $form->field($model, 'data_end')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'displayFormat' => 'php:d-m-Y H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Data',
                'autoclose' => true,
            ]
        ],
    ]);?>

    <?= $form->field($model, 'type')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            $model::PERCENT=>'%',
            $model::CURRENCY=>'₴',
        ],
    ])?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            1 => Yii::t('backend_sales','Активные'),
            0 => Yii::t('backend_sales','Не активные'),
        ],
    ])?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Чехлы'),
            'content' => $this->render('_formCoverSale', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->coverSales),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Марки товаров'),
            'content' => $this->render('_formLabelSale', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->labelSales),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Товары'),
            'content' => $this->render('_formProductSale', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productSales),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form','Создать') : Yii::t('backend_form','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
