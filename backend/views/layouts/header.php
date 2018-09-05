<?php

use common\components\services\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $orders */
/* @var $users */


$this->registerCss(".navbar-nav>.user-menu>.dropdown-menu>li.user-header{height: auto;}");
$countOrders = count($orders);
$countUsers = count($users);
Yii::$app->name = "ZapCase";
?>


<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', ['/'], ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
<!--                <li class="dropdown messages-menu">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                        <i class="fa fa-envelope-o"></i>-->
<!--                        <span class="label label-success">4</span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li class="header">You have 4 messages</li>-->
<!--                        <li>-->
<!--                            <!-- inner menu: contains the actual data -->
<!--                            <ul class="menu">-->
<!--                                <li><!-- start message -->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle"-->
<!--                                                 alt="User Image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            Support Team-->
<!--                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <!-- end message -->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user3-128x128.jpg" class="img-circle"-->
<!--                                                 alt="user image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            AdminLTE Design Team-->
<!--                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user4-128x128.jpg" class="img-circle"-->
<!--                                                 alt="user image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            Developers-->
<!--                                            <small><i class="fa fa-clock-o"></i> Today</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user3-128x128.jpg" class="img-circle"-->
<!--                                                 alt="user image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            Sales Department-->
<!--                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user4-128x128.jpg" class="img-circle"-->
<!--                                                 alt="user image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            Reviewers-->
<!--                                            <small><i class="fa fa-clock-o"></i> 2 days</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li class="footer"><a href="#">See All Messages</a></li>-->
<!--                    </ul>-->
<!--                </li>-->

                <li class="dropdown tasks-menu">
                    <a href="<?= Yii::getAlias('@fronturl') . '/' . $current_lang->url . '/' ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="label label-warning"><?=$countOrders?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?= Yii::t('backend_layouts', 'Новых заказов') ?>: <?=($countOrders) ? $countOrders : '0' ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach($orders as $k=>$v): ?>
                                    <li>
                                        <a href="<?= Yii::getAlias('@backurl') ?>/<?= Lang::getCurrent()->url ?>/orders/view/<?=$v->id?>">
                                            <i class="fa fa-shopping-cart text-green"></i>№ <?=$v->id . " - ". $v->total. " ₴ (".$v->user->username.") "?>
                                        </a>
                                    </li>

                                <?php endforeach;?>
                                <?php foreach($oldOrders as $k=>$v): ?>
                                    <li>
                                        <a href="<?= Yii::getAlias('@backurl') ?>/<?= Lang::getCurrent()->url ?>/orders/view/<?=$v->id?>">
                                            <i class="fa fa-shopping-cart text-yellow"></i>№ <?=$v->id . " - ". $v->total. " ₴ (".$v->user->username.") "?>
                                        </a>
                                    </li>

                                <?php endforeach;?>

                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-users"></i>
                        <span class="label label-danger"><?=$countUsers?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?= Yii::t('backend_layouts', 'Новых пользователей') ?>: <?=($countUsers) ? $countUsers : '0' ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach($users as $k=>$v): ?>
                                    <li>
                                        <a href="<?= Yii::getAlias('@backurl') ?>/<?= Lang::getCurrent()->url ?>/users/view/<?=$v->id?>">
                                            <i class="fa fa-user text-green"></i> <?=$v->username?>
                                        </a>
                                    </li>

                                <?php endforeach;?>
                                <?php foreach($oldUsers as $k=>$v): ?>
                                    <li>
                                        <a href="<?= Yii::getAlias('@backurl') ?>/<?= Lang::getCurrent()->url ?>/users/view/<?=$v->id?>">
                                            <i class="fa fa-user text-yellow"></i> <?=$v->username?>
                                        </a>
                                    </li>

                                <?php endforeach;?>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="height:50px;padding-top:13px;">
                        <?php if (is_null($current_lang->file)): ?>
                            <?php echo $current_lang->title ?>
                        <?php else: ?>
                            <?php echo Html::img(Yii::getAlias('@buploads').'/' . $current_lang->file->title, ['alt' => $current_lang->title, 'class' => 'current-lang-menu-img']); ?>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($avaliable_langs as $lang) { ?>
                            <li>
                                <a href="<?= Yii::getAlias('@backurl') ?>/<?= $lang->url . '/' . $url_to_lang_switch?>">
                                    <?php if (!is_null($lang->file)): ?>
                                        <?php echo Html::img(Yii::getAlias('@buploads').'/' . $lang->file->title, ['alt' => $lang->title, 'class' => 'lang-menu-img']); ?>
                                    <?php endif; ?>
                                    <?= $lang->title ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php $active_user =  \common\models\User::findOne(Yii::$app->user->identity->getId());?>
                        <span class="hidden-xs"><?= $active_user->username?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

                            <p>
                                <?= $active_user->username?> - Web Developer
                                <small><?= Yii::t('backend_layouts', 'Участник с') ?> <?php echo date('d.m.y',$active_user->created_at)?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    Yii::getAlias('@backurl').'/site/logout',
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
<!--                <li>-->
<!--                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--                </li>-->
            </ul>
        </div>
    </nav>
</header>
