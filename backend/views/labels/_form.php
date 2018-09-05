<?php

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Labels */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'CouponLabel', 
        'relID' => 'coupon-label', 
        'value' => \yii\helpers\Json::encode($model->couponLabels),
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
        'class' => 'ProductLabel', 
        'relID' => 'product-label', 
        'value' => \yii\helpers\Json::encode($model->productLabels),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="labels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    $translation_data_pack = array();
    foreach ($langs as $key => $lang){
        $have_translation = false;
        foreach ($model_msg->messages as $message){
            if($message->language === $lang->iso_code){
                $have_translation = $message;
            }
        }
        $translation_data_pack[$key]['lang_title'] = $lang->title;
        $translation_data_pack[$key]['lang_img'] = $lang->file->title;
        $translation_data_pack[$key]['lang_iso_code'] = $lang->iso_code;
        $translation_data_pack[$key]['translation'] = $have_translation ? $have_translation->translation : '';
    }
    $dataProvider = new ArrayDataProvider([
        'allModels' => $translation_data_pack,
        'pagination' => [
            'pageSize' => -1,
        ],
    ]);
    echo TabularForm::widget([
        'dataProvider'=>$dataProvider,
        'formName'=>'translations[name]',
        'actionColumn'=>false,
        'checkboxColumn' => false,
        'attributeDefaults'=>[
            'type'=>TabularForm::INPUT_TEXT,
        ],
        'attributes'=>[
            'lang_title' => [
                'type'=>TabularForm::INPUT_RAW,
                'label' => Yii::t('backend_source-langs', 'Язык'),
                'value' => function($m) {
                    return Html::img(Yii::getAlias('@buploads').'/'.$m['lang_img'], ['style' => 'width:35px;height:35px;border-radius:50%;margin: 0 20px 0 0;display:inline-block;']) .  $m['lang_title'];
                }
            ],
            'lang_iso_code' => [
                'label' => '',
                'type'=>TabularForm::INPUT_HIDDEN
            ],
            'translation' => [
                'label' => Yii::t('backend_source-langs', 'Перевод')
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before'=>false,
                'after' => false,
                'heading'=>'<h3 class="panel-title"><i class="fa fa-commenting-o"></i> ' . Yii::t('backend_source-langs', 'Переводы') . '</h3>',
                'footer'=>false,
            ],
        ]
    ]); ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Купоны'),
            'content' => $this->render('_formCouponLabel', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->couponLabels),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Скидки'),
            'content' => $this->render('_formLabelSale', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->labelSales),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Товары'),
            'content' => $this->render('_formProductLabel', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productLabels),
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
