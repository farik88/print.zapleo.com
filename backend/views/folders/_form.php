<?php

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Folders */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Resources',
        'relID' => 'resources',
        'value' => \yii\helpers\Json::encode($model->resources),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="folders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id',['template' => '{input}'])->textInput(['style' => 'display:none']) ?>

    <?= $form->field($model, 'parent_folder',['template' => '{input}'])->textInput(['style' => 'display:none']) ?>

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

    <?= $form->field($model, 'type_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            $model::TYPE_EMOJI=>Yii::t('backend_layouts','Emoji'),
            $model::TYPE_FONTS=>Yii::t('backend_layouts','Шрифты'),
            $model::TYPE_BACKGROUND=>Yii::t('backend_layouts','Фоны')
        ],
        'options' => ['placeholder' => Yii::t('backend_layouts','Выберите тип файла')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?php
    if(array_key_exists('id', $_GET)){
        $forms = [
            [
                'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_folders','Ресурсы'),
                'content' => $this->render('_formResources', [
                    'row' => \yii\helpers\ArrayHelper::toArray($model->resources),
                ]),
            ],
        ];
    }else{
        $forms = [
//            [
//                'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Ресурсы'),
//                'content' => $this->render('_formResources', [
//                    'row' => \yii\helpers\ArrayHelper::toArray($model->resources),
//                ]),
//            ],
        ];
    }

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
