<?php

namespace common\components\url;

use yii\web\UrlManager;
use common\components\services\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        $current_lang = Lang::getCurrent();

        $url = parent::createUrl($params);

        if ($current_lang->is_default) {
            return $url;
        } elseif (\Yii::$app->request->getBaseUrl() == '/admin') {
            // TODO: Переделать
            $url = substr($url, strlen(\Yii::$app->request->getBaseUrl()));
            return \Yii::getAlias('@backurl').'/'.$current_lang->url.$url;
        } else {
            return '/'.$current_lang->url.$url;
        }
    }
}
