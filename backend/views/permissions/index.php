<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backend_permissions', 'Права пользователей');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-permissions">
    
    <?php
    
        $confirm_message = Yii::t('backend_permissions', 'Вы точно хотите удалить эти права?');
        $delete_script = <<<HD
                $('.w0-action-del').on('click', function(){
                    var is_delete = confirm('{$confirm_message}');
                    if(is_delete){
                        window.location = $(this).attr('href');
                    }else{
                        return false;
                    }
                })
HD;
        $this->registerJs($delete_script);
    
        if($dataProvider){
            $columns = [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'name',
                    'label' => Yii::t('backend_permissions', 'Права')
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'description',
                    'label' => Yii::t('backend_permissions', 'Описание'),
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'buttons' => [
                        'delete' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['permissions/delete', 'name' => $model['name']]), ['class' => 'w0-action-del', 'title' => Yii::t('backend_permissions', 'Удалить')]);
                        },
                        'update' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['permissions/update', 'name' => $model['name']]), ['title' => Yii::t('backend_permissions', 'Изменить')]);
                        },
                    ],
                ],
            ];
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'responsive'=>true,
                'hover'=>true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="fa fa-id-card-o" aria-hidden="true"></i>  ' . Html::encode($this->title),
                    'before' => false,
                    'after' => Html::a(Yii::t('backend_permissions', 'Добавить права') . ' <i class="fa fa-plus" aria-hidden="true" style="margin: 0 0 0 11px;"></i>', Url::toRoute(['permissions/create']), ['class' => 'btn btn-success']),
                    'footer' => false,
                ],
            ]);
        }else{
            echo '<h1>' . Yii::t('backend_permissions', 'Не найдено прав') . '</h1>';
            echo '<div class="empty-space" style="height:100px;"></div>';
            echo Html::a(Yii::t('backend_permissions', 'Добавить права') . ' <i class="fa fa-plus" aria-hidden="true" style="margin: 0 0 0 11px;"></i>', Url::toRoute(['permissions/create']), ['class' => 'btn btn-success']);
        }
    ?>

</div>
