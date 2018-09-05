<div class="form-group" id="add-product-cover">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'ProductCover',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN],
        'cover_id' => [
            'label' => Yii::t('backend_covers','Чехол'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Covers::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'color_id' => [
            'label' => Yii::t('backend_covers','Цвет'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Colors::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'file_id' => [
            'label' => ' ',
            'type' => TabularForm::INPUT_HIDDEN,
//            'widgetClass' => \kartik\widgets\Select2::className(),
//            'options' => [
//                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Files::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
//                'options' => ['placeholder' => 'Choose Files'],
//            ],
//            'columnOptions' => ['width' => '200px']
        ],
        'img' => [
            'type' => TabularForm::INPUT_STATIC,
            'label' => Yii::t('backend_covers','Изображение'),
            'format' => ['image',['width'=>'180','height'=>'350']],
            'value'=>function($model){
                if($model){
                    $file = \backend\models\base\Files::findOne($model['file_id']);
                    if(empty($file)) {
                        echo "upload error: ".$model['file_id'];
                        return null;
                    }
                    return Yii::getAlias('@buploads').'/covers/'.$file->name.'.'.$file->ext;
                }
                return NULL;

            },
        ],
        'need_pole' => [
            'label' => Yii::t('backend_covers','Загрузить изображение'),
            'type'=> TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\FileInput::className(),
            'options' => [
                'name' => 'file',
                'language' => \Yii::$app->controller->current_lang->url,
                'options' => [
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to(['products/load-file-cover']),
                    'maxFileCount' => 10
                ],
                'pluginEvents' => [
                    'fileuploaded' => 'function(event, data, previewId, index) {
                    console.log(event["target"]["id"]);
                    var str = event["target"]["id"];
                    str = str.substr(0, str.length - 10);
                    console.log(str);
                    $("#"+str+"-file_id").val(data["response"]["file_id"]);
                    }'
                ]
            ],
        ],

        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowProductCover(' . $key . '); return false;', 'id' => 'product-cover-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('backend_form', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProductCover()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

