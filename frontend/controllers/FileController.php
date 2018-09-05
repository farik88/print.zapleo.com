<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 12.05.17
 * Time: 9:16
 */

namespace frontend\controllers;

use frontend\core\exceptions\BaseException;
use frontend\core\utils\FilesUtil;
use \yii;
use frontend\core\base\FrontendController;
use yii\web\UploadedFile;

class FileController extends FrontendController
{
    /**
     * @return array
     */
    public function actionUploadTmpFile() {
        $files = UploadedFile::getInstancesByName("image");
        try {
            $links = (new FilesUtil(Yii::getAlias("@webroot/uploads")))->uploadTmpFiles($files);
        }
        catch (BaseException $e) {
            return $this->jsonBadResponseObj($e->getMessage(), $e->getErrors());
        }
        return $this->jsonResponseObj([
            'links'=>  $links
        ]);
    }
    
    public function actionClearTmpFile() {

    }

    /**
     * only for base64
     */
    public function actionSavePng() {
        $file  = Yii::$app->request->post('file');
        $id = (new FilesUtil(Yii::getAlias('@buploadsroot').'/print'))->base64PngUpload($file);
        return $this->jsonResponseObj(['id' => $id]);
    }
}
