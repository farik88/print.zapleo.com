<?php

namespace backend\models;

use \backend\models\base\Files as BaseFiles;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "files".
 */
class Files extends BaseFiles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'ext'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'name', 'ext'], 'string', 'max' => 255]
        ]);
    }

    public function findModel($id)
    {
        if (($model = Deliveries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
