<?php

namespace frontend\core\widgets\langswitcher;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\components\services\Lang;

class LangSwitcher extends Widget{
    
    public $html;
    public $extra_class;
    public $current_lang;
    public $url_to_lang_switch;
    public $avaliable_langs;
    public $aval_langs_list_style_type;


    /**
     * CONFIG PARAMS
     * $extra_class - css class for switcher
     */
    public function init()
    {
        parent::init();
        $this->current_lang = Lang::getCurrent();
        $this->url_to_lang_switch = Lang::getLangSwitchUrl();
        $this->avaliable_langs = Lang::find()->where('active = 1')->where('id != :current_id', [':current_id' => $this->current_lang->id])->all();
        if($this->extra_class === null){
            $this->extra_class = Yii::$app->controller->id . '-' . Yii::$app->controller->action->id;
        }
        $this->html = $this->getTemplate();
    }
    
    public function getTemplate()
    {
        return $this->render('switcher', [
            'extra_class' => $this->extra_class,
            'current_lang' => $this->current_lang,
            'url_to_lang_switch' => $this->url_to_lang_switch,
            'avaliable_langs' => $this->avaliable_langs,
        ]);
    }

    public function run()
    {
        return Html::decode($this->html);
    }
    
}
