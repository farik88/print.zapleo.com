<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 28.04.17
 * Time: 11:43
 */

namespace common\components\utils;


use backend\models\base\Files;
use backend\models\base\Images;
use backend\models\base\Markings;
use yii\web\UploadedFile;

class SiteUtils extends BaseUtils
{

    /**
     * Load all files in project
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadFile(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/'. $file->baseName .'M'.$new_name.'.' . $file->extension);

        $db_file = new Files();
        $db_file->name = $file->baseName .'M'. $new_name;
        $db_file->ext  = $file->extension;
        $db_file->title = $file->baseName .'M'. $new_name.'.'.$db_file->ext;
        $db_file->save();

        return $db_file->id;
    }

    /**
     * Load resource in site (emoji,fonts,background)
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadResource(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/resources/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_file = new Files;
        $db_file->name = $file->baseName.'M'.$new_name;
        $db_file->ext  = $file->extension;
        $db_file->title = $db_file->name.'.'.$db_file->ext;
        $db_file->save();

        return $db_file->id;
    }

    /**
     * Load ready img for print
     *
     * @param UploadedFile $file
     * @return int
     */
    public function loadPrint(UploadedFile $file){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/print/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_image = new Images();
        $db_image->name = $file->baseName.'M'.$new_name;
        $db_image->ext  = $file->extension;
        $db_image->title = $db_image->name.'.'.$db_image->ext;
        $db_image->save();

        return $db_image->id;
    }

    /**
     * Load img marking to product
     *
     * @param UploadedFile $file
     * @param $id
     * @return int
     */
    public function loadMarkingProd(UploadedFile $file,$id){
        $new_name  = date("Y-m-d H:i:s");
        $new_name = md5($new_name);

        $file->saveAs('uploads/markings/'. $file->baseName .'M'.$new_name. '.' . $file->extension);

        $db_mark = new Markings();
        $db_mark->name = $file->baseName.'M'.$new_name.'.'.$file->extension;
        $db_mark->title = $db_mark->name;
        $db_mark->product_id = $id;
        $db_mark->save();

        return $db_mark->id;
    }

}