<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backend_roles', 'Роли пользователей');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-roles">
    
    <?php
    $confirm_message = Yii::t('backend_roles', 'Вы точно хотите удалить эту роль?');
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
                'label' => Yii::t('backend_roles', 'Роль')
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'is_default_role',
                'label' => Yii::t('backend_roles', 'По умолчанию'),
                'width' => '130px',
                'value' => function($model){
                    return $model['is_default_role'] ? '<i class="fa fa-check-square" aria-hidden="true" style="color: #3c8dbc;font-size:18px;"></i>' : '';
                },
                'format' => 'html',
                'hAlign' => 'center',
                'vAlign' => 'middle'
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['roles/delete', 'name' => $model['name']]), ['class' => 'w0-action-del', 'title' => Yii::t('backend_roles', 'Удалить')]);
                    },
                    'update' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['roles/update', 'name' => $model['name']]), ['title' => Yii::t('backend_roles', 'Изменить')]);
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
                'heading' => '<i class="fa fa-users" aria-hidden="true"></i>  ' . Html::encode($this->title),
                'before' => false,
                'after' => Html::a(Yii::t('backend_roles', 'Новая роль') . ' <i class="fa fa-plus" aria-hidden="true" style="margin: 0 0 0 11px;"></i>', Url::toRoute(['roles/create']), ['class' => 'btn btn-success']),
                'footer' => false,
            ],
        ]);
    }else {
        echo '<h1>' . Yii::t('backend_roles', 'Не найдено ролей') . '</h1>';
        echo '<div class="empty-space" style="height:100px;"></div>';
        echo Html::a(Yii::t('backend_roles', 'Новая роль') . ' <i class="fa fa-plus" aria-hidden="true" style="margin: 0 0 0 11px;"></i>', Url::toRoute(['roles/create']), ['class' => 'btn btn-success']);
    }
    ?>

</div>
