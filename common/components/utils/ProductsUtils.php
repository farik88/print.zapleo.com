<?php
namespace common\components\utils;
use backend\models\base\Files;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: max
 * Date: 24.04.17
 * Time: 12:45
 */
class ProductsUtils extends BaseUtils
{
    /**
     * Add photo cover in product
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadFileCover(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/covers/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_file = new Files();
        $db_file->name = $file->baseName .'M'.$new_name;
        $db_file->ext  = $file->extension;
        $db_file->title = $db_file->name.'.'.$db_file->ext;
        $db_file->save();

        return  $db_file->id;
    }

    /**
     * Add photo color in product
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadFileColor(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/colors/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_file = new Files;
        $db_file->name = $file->baseName.'M'.$new_name;
        $db_file->ext  = $file->extension;
        $db_file->title = $db_file->name.'.'.$db_file->ext;
        $db_file->save();

        return  $db_file->id;
    }

}