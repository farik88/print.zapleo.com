<?php

/* @var $this yii\web\View */
$this->title = Yii::t('backend_site', 'Статистика');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js',['depends'=>\backend\assets\AppAsset::className(),'position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/index.js',['depends'=>\backend\assets\AppAsset::className()]);
$this->registerCssFile('@web/css/index.css',['depends'=>\backend\assets\AppAsset::className()]);

$this->registerJs('var label_text7 = "'.Yii::t('backend_site', 'График заказов за 7 дней').'";', Yii\web\View::POS_HEAD);
$this->registerJs('var label_text30 = "'.Yii::t('backend_site', 'График заказов за 30 дней').'";', Yii\web\View::POS_HEAD);
$this->registerJs('var label_text365 = "'.Yii::t('backend_site', 'График заказов за 365 дней').'";', Yii\web\View::POS_HEAD);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('backend_site', 'График заказов') ?></h3>
        <ul class="days">
            <li>
                <button class="btn btn-info search-button active days_7"><?= Yii::t('backend_site', '7 дней') ?></button>
            </li >
            <li>
                <button class="btn btn-info search-button days_30"><?= Yii::t('backend_site', '30 дней') ?></button>
            </li>
            <li>
                <button class="btn btn-info search-button days_365"><?= Yii::t('backend_site', '365 дней') ?></button>
            </li>
        </ul>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="chart">
            <canvas id="myChart7"style="height: 243px; width: 579px;" height="243" width="579" ></canvas>
            <canvas id="myChart30" width="100" height="100" style="display: none" ></canvas>
            <canvas id="myChart365" width="100" height="100" style="display: none"></canvas>
        </div>
    </div>
    <!-- /.box-body -->
</div>

<script>
    var graph = <?= json_encode($graph);?>;
</script>
