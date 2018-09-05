<?php

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'OrderCart', 
        'relID' => 'order-cart', 
        'value' => \yii\helpers\Json::encode($model->orderCarts),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ProductColor', 
        'relID' => 'product-color', 
        'value' => \yii\helpers\Json::encode($model->productColors),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ProductCoupon', 
        'relID' => 'product-coupon', 
        'value' => \yii\helpers\Json::encode($model->productCoupons),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ProductCover', 
        'relID' => 'product-cover', 
        'value' => \yii\helpers\Json::encode($model->productCovers),
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
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ProductMarking', 
        'relID' => 'product-marking', 
        'value' => \yii\helpers\Json::encode($model->productMarkings),
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

<div class="products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'file_id')->textInput(['style' => 'display:none']) ?>

    <?php
    echo \kartik\file\FileInput::widget([
        'name' => 'file',
        'language' => \Yii::$app->controller->current_lang->url,
        'options'=>[
            'multiple' => true
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['site/load-file']),
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, previewId, index) {
            console.log(data["response"]["file_id"]);
            $("#products-file_id").val(data["response"]["file_id"]);
            }'
        ]

    ]);
    ?>
    <?= $form->field($model, 'wspace_width') ?>

    <?= $form->field($model, 'wspace_height') ?>

    <?= $form->field($model, 'wspace_width3d') ?>

    <?= $form->field($model, 'wspace_height3d') ?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::PROD_ACTIVE => Yii::t('backend_form','Активно'),
            $model::PROD_DISABLED => Yii::t('backend_form','Не активно'),
        ]
    ])  ?>

    <?= $form->field($model, 'position') ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products', 'Чехлы'),
            'content' => $this->render('_formProductCover', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productCovers),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Разметки'),
            'content' => $this->render('_formProductMarking', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productMarkings),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Цвета'),
            'content' => $this->render('_formProductColor', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productColors),
            ]),
        ],
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Заказы'),
//            'content' => $this->render('_formOrderProduct', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->orderProducts),
//            ]),
//        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Марки'),
            'content' => $this->render('_formProductLabel', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productLabels),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_products','Купоны'),
            'content' => $this->render('_formProductCoupon', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->productCoupons),
            ]),
        ],
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Скидки'),
//            'content' => $this->render('_formProductSale', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->productSales),
//            ]),
//        ],
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form', 'Создать') : Yii::t('backend_form', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
