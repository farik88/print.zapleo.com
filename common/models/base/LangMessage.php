<?php

namespace common\models\base;

use common\models\SourceLangMessage;
use Yii;

/**
 * This is the base model class for table "message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceLangMessage $id0
 */
class LangMessage extends \frontend\core\base\FrontendActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  'ID',
            'language' => Yii::t('backend_messages','Язык'),
            'translation' => Yii::t('backend_messages','Перевод'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceLangMessage::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageInfo()
    {
        return $this->hasOne(\backend\models\Languages::className(), ['iso_code' => 'language']);
    }
    
    public static function updateTranslationsFromArray($id, $translations_arr)
    {
        foreach ($translations_arr as $translation){
            $needle_message = LangMessage::findOne(['id' => $id, 'language' => $translation['lang_iso_code']]);
            if (!is_null($needle_message)) {
                $needle_message->translation = $translation['translation'];
                $needle_message->save();
            }else{
                $lang_message = new LangMessage();
                $lang_message->id = $id;
                $lang_message->language = $translation['lang_iso_code'];
                $lang_message->translation = $translation['translation'];
                $lang_message->save();
            }
        }
    }
}
