<?php

use common\models\SourceLangMessage;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\base\SourceLangMessage */
/* @var $form yii\widgets\ActiveForm */

// \mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END,
//     'viewParams' => [
//         'class' => 'Message',
//         'relID' => 'message',
//         'value' => \yii\helpers\Json::encode($model->messages),
//         'isNewRecord' => ($model->isNewRecord) ? 1 : 0
//     ]
// ]);

$field_options = [
    'maxlength' => true
];

if (!$model->isNewRecord)
    $field_options['readonly'] = 'readonly';

$categories = SourceLangMessage::find()->select('category')->groupBy('category')->orderBy('category')->asArray()->all();

foreach ($categories as $i => $category)
    $categories[$i]['category_name'] = (!empty(SourceLangMessage::$categories[$category['category']]) ? SourceLangMessage::$categories[$category['category']] : $category['category']);


?>

<div class="source-lang-message-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <?php
        if ($model->isNewRecord) {
            echo $form->field($model, 'category')->widget(\kartik\widgets\Select2::className(),[
                'data' => ArrayHelper::map($categories, 'category', 'category_name')
            ]);
        } else {
            echo $form->field($model, 'category')->textInput([
                'maxlength' => true,
                'name'  => 'category',
                'value' =>
                    (! empty(SourceLangMessage::$categories[$model->category]) ?
                        SourceLangMessage::$categories[$model->category] :
                        $model->category),
                'readonly' => 'readonly'
            ])->label(Yii::t('backend_source-messages', 'Категория сообщения'));
        }
    ?>
    <?= $form->field($model, 'message')->textInput($field_options)->label(Yii::t('backend_source-messages', 'Исходное сообщение')) ?>
    
    <?php
    $translation_data_pack = array();
    foreach ($langs as $key => $lang){
        $have_translation = false;
        foreach ($model->messages as $message){
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
        'formName'=>'translations',
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

    <div class="form-group">
        <?= (!$model->isNewRecord ? Html::checkbox('translate_all', true) . ' '.Yii::t('backend_source-messages','Перевести во всех категориях') : '') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form','Создать') : Yii::t('backend_form','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
