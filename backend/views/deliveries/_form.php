<?php

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveries */
/* @var $form yii\widgets\ActiveForm */

// \mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END,
//     'viewParams' => [
//         'class' => 'Orders',
//         'relID' => 'orders',
//         'value' => \yii\helpers\Json::encode($model->orders),
//         'isNewRecord' => ($model->isNewRecord) ? 1 : 0
//     ]
// ]);
?>

<div class="deliveries-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id',['template' => '{input}'])->textInput(['style' => 'display:none']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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
        'formName'=>'translations[title]',
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


    <?= $form->field($model, 'file_id')->textInput(['style' => 'display:none']) ?>

    <?php
    echo \kartik\file\FileInput::widget([
        'name' => 'file',
        'language' => \Yii::$app->controller->current_lang->url,
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['site/load-file']),
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, previewId, index) {
            console.log(data["response"]["file_id"]);
            $("#deliveries-file_id").val(data["response"]["file_id"]);
            }'
        ]

    ]);
    ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::DEL_ACTIVE => Yii::t('backend_deliveries','Активно'),
            $model::DEL_DISABLED => Yii::t('backend_deliveries','Не активно'),
        ]
    ]) ?>

    <?php
    // $forms = [
    //    [
    //        'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Orders'),
    //        'content' => $this->render('_formOrders', [
    //            'row' => \yii\helpers\ArrayHelper::toArray($model->orders),
    //        ]),
    //    ],
    // ];
    // echo kartik\tabs\TabsX::widget([
    //     'items' => $forms,
    //     'position' => kartik\tabs\TabsX::POS_ABOVE,
    //     'encodeLabels' => false,
    //     'pluginOptions' => [
    //         'bordered' => true,
    //         'sideways' => true,
    //         'enableCache' => false,
    //     ],
    // ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form','Создать') : Yii::t('backend_form','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
