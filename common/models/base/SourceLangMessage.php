<?php

namespace common\models\base;

use common\components\base\BaseActiveRecord;
use common\models\LangMessage as LM;
use yii;

/**
 * This is the base model class for table "source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 * @property integer $owner_id
 *
 * @property LM[] $messages
 */
class SourceLangMessage extends BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public static $categories = [
        'backend_accesses' => 'Права доступа',
        'backend_colors' => 'Цвета',
        'backend_colors_name' => 'Цвета(название)',
        'backend_coupons' => 'Купоны',
        'backend_covers' => 'Чехлы',
        'backend_covers_name' => 'Чехлы(название)',
        'backend_deliveries' => 'Методы оставки',
        'backend_emails' => 'Рассылка',
        'backend_folders' => 'Папки',
        'backend_folders_name' => 'Ресурсы(название папок)',
        'backend_form' => 'Кнопки',
        'backend_images' => 'Изображения',
        'backend_labels' => 'Марки товаров',
        'backend_labels_name' => 'Марки товаров(название)',
        'backend_languages' => 'Языки',
        'backend_layouts' => 'Разделы меню',
        'backend_markings' => 'Разметки',
        'backend_messages' => 'Переводы(сообщения)',
        'backend_ordercart' => 'Товары в заказе',
        'backend_orders' => 'Заказы',
        'backend_payments' => 'Методы оплаты',
        'backend_permissions' => 'Права',
        'backend_products' => 'Товары',
        'backend_products_name' => 'Товары(названия)',
        'backend_resources' => 'Ресурсы',
        'backend_roles' => 'Роли',
        'backend_sales' => 'Акции',
        'backend_settings' => 'Параметры приложения',
        'backend_site' => 'Главная страница',
        'backend_source-langs' => 'Исходные сообщения',
        'backend_source-messages' => 'Исходные сообщения(переводы)',
        'backend_translations' => 'Переводы',
        'backend_users' => 'Пользователи',
        'frontend_button' => 'Кнопки(конструктор)',
        'frontend_cart' => 'Корзина',
        'frontend_create' => 'Конструктор',
        'frontend_image_upload' => 'Изображения(конструктор)',
        'frontend_login' => 'Вход',
        'frontend_order' => 'Оформление заказа',
        'frontend_profile' => 'Профиль',
        'frontend_signup' => 'Регистрация',
        'frontend_site' => 'Главная страница(конструктор)',
        'backend_payments_title' => 'Методы оплаты(названия)',
        'backend_deliveries_title' => 'Методы доставки(названия)',
    ];
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
            [['owner_id'], 'integer'],
            [['message', 'category'], 'required']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('backend_source-messages', 'ID'),
            'category' => Yii::t('backend_source-messages', 'Категория'),
            'message' =>  Yii::t('backend_source-messages', 'Сообщение'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(LM::className(), ['id' => 'id']);
    }
    
    public function getTranslateStatus() {
        $has_translations = intval(LM::find()->where(['id' => $this->id])->andWhere(['not', ['translation' => '']])->andWhere(['not', ['translation' => NULL]])->count());
        $langs_need_to_translate = intval(Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->count());
        $translation_status = 'red';
        if($has_translations>0){
            if($has_translations<$langs_need_to_translate){
                $translation_status = 'yellow';
            }
            if($has_translations >= $langs_need_to_translate){
                $translation_status = 'green';
            }
        }
        $status_text = Yii::t('backend_source-messages', 'Нет переводов');
        if($translation_status === 'yellow'){
            $status_text = Yii::t('backend_source-messages', 'Не все переведено');
        }
        if($translation_status === 'green'){
            $status_text = Yii::t('backend_source-messages', 'Переведено');
        }
        $col_html = '<div class="table-status-marker ' . $translation_status . '" title="' . $status_text . '"></div>';
        return $col_html;
    }
}
