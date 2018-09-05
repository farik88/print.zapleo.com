<?php
use Yii;
use yii\helpers\Html;
use frontend\core\widgets\langswitcher\assets\SwitcherAsset;
?>

<div id="lang-switcher-widget" class="closed<?php echo $extra_class ? ' ' . $extra_class : ''; ?>">
    <?= Html::button($current_lang->url, ['class' => 'current-lang', 'title' => $current_lang->title]) ?>
    <ul class="aval-langs-list <?= 'count-'.count($avaliable_langs); ?>">
        <?php foreach ($avaliable_langs as $lang) { ?>
            <li>
                <?= Html::a(
                        Html::button($lang->url, ['class' => 'lang-menu-btn', 'title' => $lang->title]),    //content
                        '/' . $lang->url . '/' . $url_to_lang_switch                                        //url
                        )
                ?>
            </li>
        <?php } ?>
    </ul>
</div>

<?php SwitcherAsset::register($this); ?>