<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerJs('var apiPoint='.json_encode(Yii::getAlias('@backurl')).';',Yii\web\View::POS_HEAD);

if (Yii::$app->controller->action->id === 'login') {
/**
 * Do not use this code in your template. Remove it.
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    backend\assets\AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?= $this->render(
            'header.php',
        [
            'orders' => isset(Yii::$app->controller->orders) ? Yii::$app->controller->orders : [],
            'users' => isset(Yii::$app->controller->users) ? Yii::$app->controller->users : [],
            'oldUsers' => isset(Yii::$app->controller->oldUsers) ? Yii::$app->controller->oldUsers: [],
            'oldOrders' => isset(Yii::$app->controller->oldOrders) ? Yii::$app->controller->oldOrders : [],
            'avaliable_langs' => isset(Yii::$app->controller->avaliable_langs) ? Yii::$app->controller->avaliable_langs : [],
            'url_to_lang_switch' => isset(Yii::$app->controller->url_to_lang_switch) ? Yii::$app->controller->url_to_lang_switch : [],
            'current_lang' => isset(Yii::$app->controller->current_lang) ? Yii::$app->controller->current_lang : []
        ]

//            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
