<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class ShepherdAsset extends AssetBundle{
    
    public $sourcePath = '@bower/tether-shepherd/dist';
    
    public $css = [
        'css/shepherd-theme-arrows.css',
    ];
    public $js = [
        'js/tether.js',
        'js/shepherd.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
