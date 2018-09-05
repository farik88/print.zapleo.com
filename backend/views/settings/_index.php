<?php 
use \yii\helpers\Html;
use yii\widgets\DetailView;
?>

<div class="row">
    <div class="col-sm-9">
        <h2><?= Html::a(Html::encode($model->value), ['view', 'id' => $model->id]) ?></h2>
    </div>
    <div class="col-sm-3" style="margin-top: 15px">
        <?= Html::a(Yii::t('backend_form','Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend_form','Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </div>
    <?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'key',
        'value',
        'description:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
    ?>
</div>


