<div class="form-group" id="add-resources">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;
$appAsset = 'frontend\assets\AppAsset';
$this->registerJs('$(\'.kv-align-middle>a\').each(function () {
        console.log($(this).html());
        $(this).on(\'click\',function (e) {
            e.preventDefault();
            if (confirm(\''.Yii::t('backend_folders','Вы действительно хотите удалить ресурс?').'\')){
                $.ajax({
                    method: "post",
                    url: apiPoint +\'/resources/dresource/\'+$(this).data(\'resources-id\')

                });
            }
        })
    });',Yii\web\View::POS_LOAD);

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ],
]);


    echo \kartik\file\FileInput::widget([
        'name' => 'file',
        'language' => \Yii::$app->controller->current_lang->url,
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['folders/load-resources']).'/'.$_GET['id'],
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, previewId, index) {
                location.reload();
            }'
        ]

    ]);
    echo '<br>';


echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Resources',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        //'id' => ['type' => TabularForm::INPUT_HIDDEN],


        'img' => [
            'type' => TabularForm::INPUT_STATIC,
            'label' => Yii::t('backend_folders','Изображение'),
            'format' => ['image',['width'=>'180','height'=>'350']],
            'value'=>function($model){
                if($model){
                    $folder_name = \backend\models\base\Folders::findOne($model['folder_id']);
                    if($folder_name->type_id == 2){
                        return Yii::getAlias('@buploads').'/resources/background/'.$folder_name->name.'/'.$model['name'].'.'.$model['ext'];
                    }else if ($folder_name->type_id == 0){
                        return Yii::getAlias('@buploads').'/resources/emoji/'.$folder_name->name.'/'.$model['name'].'.'.$model['ext'];
                    }
                }
            },
        ],

//        'type_id' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '/resources/dresource/'.$model['id'],['title' =>  'Delete', 'data-folder-id' => $model['folder_id'],'data-resources-id' => $model['id'],'id' => 'resources-del-btn']);
            },
        ],
    ],
//    'gridSettings' => [
//        'panel' => [
//            'heading' => false,
//            'type' => GridView::TYPE_DEFAULT,
//            'before' => false,
//            'footer' => false,
//            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Добавить ресурс', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowResources()']),
//        ]
//    ]
]);
echo  "    </div>\n\n";

?>

