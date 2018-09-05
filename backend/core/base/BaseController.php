<?php

namespace backend\core\base;

use common\models\Orders;
use common\models\Users;
use common\components\services\Lang;

/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 22.05.17
 * Time: 10:12
 */
class BaseController extends \common\components\base\BaseController
{
    public $orders;
    public $users;
    public $oldUsers;
    public $oldOrders;
    public $avaliable_langs;
    public $url_to_lang_switch;
    public $current_lang;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->on(self::EVENT_BEFORE_ACTION,[$this,"setStatistic"]);
    }

    public function setStatistic() {
        $this->orders = Orders::find()->where('is_old IS NULL')->orderBy("id desc")->all();
        $this->users = Users::find()->where('is_old IS NULL')->orderBy("id desc")->all();
        $this->oldOrders = Orders::find()->where('is_old IS NOT NULL')->orderBy("id desc")->limit(10)->all();
        $this->oldUsers = Users::find()->where('is_old IS NOT NULL')->orderBy("id desc")->limit(10)->all();
        $this->current_lang = Lang::getCurrent();
        $this->url_to_lang_switch = Lang::getLangSwitchUrl();
        $this->avaliable_langs = Lang::find()->where('active = 1')->where('id != :current_id', [':current_id' => $this->current_lang->id])->all();
    }
}