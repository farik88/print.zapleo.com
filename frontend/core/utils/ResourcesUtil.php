<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 25.05.17
 * Time: 12:28
 */

namespace frontend\core\utils;
use common\models\Resources;

/**
 * Class ResourcesUtil
 * @package frontend\core\utils
 */
class ResourcesUtil extends BaseUtil
{
    /**
     * @param $id int folder id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getResourcesByFolder($id) {
        return Resources::find()
            ->with('folder')
            ->where(['folder_id'=>$id])
            ->asArray()
            ->all();
    }
}