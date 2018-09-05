<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

?>
<div class="orders-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->id) ?></h2>
        </div>
    </div>

    <div class="row">
<?php
    $gridColumn = [
        'id',
        [
            'attribute' => 'delivery.title',
            'label' => 'Delivery',
        ],
        [
            'attribute' => 'payment.title',
            'label' => 'Payment',
        ],
        [
            'attribute' => 'coupon.id',
            'label' => 'Coupon',
        ],
        [
            'attribute' => 'user.username',
            'label' => 'User',
        ],
        'total',
        'comment:ntext',
        'status_payment',
        'status_delivery',
        'data',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
</div>