<?php

namespace frontend\core\widgets\langswitcher\assets;

use yii\web\AssetBundle;

class SwitcherAsset extends AssetBundle
{
    public $sourcePath = '@app/core/widgets/langswitcher';
    public function init() {
        $this->publishOptions['forceCopy'] = (YII_ENV_DEV) ? true : false;
        parent::init();
    }
    public $css = [
        'css/switcher-widget.css',
    ];
    public $js = [
        'js/switcher-script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
