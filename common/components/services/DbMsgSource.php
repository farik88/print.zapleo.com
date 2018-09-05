<?php
/**
 * Created by PhpStorm.
 * User: valeks
 * Date: 04.01.18
 * Time: 12:58
 */

namespace common\components\services;

use common\models\SourceLangMessage;
use yii\i18n\DbMessageSource;

class DbMsgSource extends DbMessageSource
{
    public function translate($category, $message, $language)
    {
       // if ($category == 'frontend_site') {
       //     $msg = SourceLangMessage::findOne(['category' => $category, 'message' => $message]);
       //
       //     if (is_null($msg)) {
       //         $sm = new SourceLangMessage();
       //         $sm->category = $category;
       //         $sm->message = $message;
       //         $sm->save();
       //     }
       // }

        return parent::translate($category, $message, $language);
    }
}