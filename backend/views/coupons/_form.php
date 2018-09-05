<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'CouponCover', 
        'relID' => 'coupon-cover', 
        'value' => \yii\helpers\Json::encode($model->couponCovers),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
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
        'class' => 'Orders', 
        'relID' => 'orders', 
        'value' => \yii\helpers\Json::encode($model->orders),
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
?>

<div class="coupons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'hash')->textInput(['value'=>Yii::$app->security->generateRandomString(8),'maxlength' => true]) ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'discount_type')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::TYPE_PERCENT=>'%',
            $model::TYPE_CURRENCY=>'₴',
        ]
    ])?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::ACTIVE => Yii::t('backend_coupons','Активно'),
            $model::DISABLED => Yii::t('backend_coupons','Не активно'),
        ]
    ])?>

    <?= $form->field($model, 'type')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::TYPE_PRODUCT => Yii::t('backend_coupons','Продукт'),
            $model::TYPE_LABEL => Yii::t('backend_coupons','Марки'),
            $model::TYPE_COVER => Yii::t('backend_coupons','Чехлы'),
        ]
    ]) ?>

    <?php
    if($model->type !== null){
        if($model->type == $model::TYPE_PRODUCT){
            $forms = [
                [
                    'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Товары'),
                    'content' => $this->render('_formProductCoupon', [
                        'row' => \yii\helpers\ArrayHelper::toArray($model->productCoupons),
                    ]),
                ],
            ];
        }else if($model->type == $model::TYPE_LABEL){
            $forms = [
                [
                    'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Марки товаров'),
                    'content' => $this->render('_formCouponLabel', [
                        'row' => \yii\helpers\ArrayHelper::toArray($model->couponLabels),
                    ]),
                ],
            ];
        }else if($model->type == $model::TYPE_COVER){
            $forms = [
                [
                    'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_layouts','Чехлы'),
                    'content' => $this->render('_formCouponCover', [
                        'row' => \yii\helpers\ArrayHelper::toArray($model->couponCovers),
                    ]),
                ],
            ];
        }
    }else{
        $forms = [];
    }

//    $forms = [
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('CouponCover'),
//            'content' => $this->render('_formCouponCover', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->couponCovers),
//            ]),
//        ],
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('CouponLabel'),
//            'content' => $this->render('_formCouponLabel', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->couponLabels),
//            ]),
//        ],
////        [
////            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Orders'),
////            'content' => $this->render('_formOrders', [
////                'row' => \yii\helpers\ArrayHelper::toArray($model->orders),
////            ]),
////        ],
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('ProductCoupon'),
//            'content' => $this->render('_formProductCoupon', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->productCoupons),
//            ]),
//        ],
//    ];
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
