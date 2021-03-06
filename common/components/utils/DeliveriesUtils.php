<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 28.04.17
 * Time: 11:38
 */

namespace common\components\utils;


use backend\models\base\Files;
use yii\web\UploadedFile;

class DeliveriesUtils extends BaseUtils
{

    /**
     * Load img in deliveries
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadFile(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_file = new Files();
        $db_file->name = $file->baseName.'M'.$new_name;
        $db_file->ext  = $file->extension;
        $db_file->title = $db_file->name.'.'.$db_file->ext;
        $db_file->save();

        return  $db_file->id;
    }
}