<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 28.04.17
 * Time: 11:43
 */

namespace frontend\core\utils;


use backend\models\base\Files;
use backend\models\base\Images;
use backend\models\base\Markings;
use common\traits\SimpleYiiTrait;
use frontend\core\exceptions\FolderCannotCreateException;
use frontend\core\exceptions\UploadFailureException;
use frontend\core\helpers\FileUploader;
use frontend\models\ImageUploadForm;
use yii\helpers\Url;
use yii\web\UploadedFile;

class FilesUtil extends BaseUtil
{
    protected $_path = '';
    
    /**
     * FilesUtil constructor.
     * @param $basePath
     * @throws FolderCannotCreateException
     */
    public function __construct($basePath)
    {
        if (!$this->requireFolder($basePath)) {
            throw new FolderCannotCreateException();
        };
        $this->_path = $basePath;
    }

    /**
     * @param $files
     * @return array
     * @throws UploadFailureException
     */
    public function uploadTmpFiles($files) {
        if( !is_array($files) || !isset($files[0])) {
            $files = [$files];
        }
        $links = [];
        for($i = 0, $size = count($files); $i < $size; $i++) {
            $form = new ImageUploadForm();
            /** each of $files[$i] instance of UploadedFile */
            $form->fileObj = $files[$i];
            $form->path = $this->_path;
            $form->ext = $form->fileObj->extension;
            $links[] = trim(Url::to('@web/uploads/'.$form->save(), true));
        }
        return $links;
    }
    
    /**
     * @param $base64
     * @return bool
     * @throws \Exception
     */
    public function base64PngUpload($base64) {
        $file =  base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $fileName = (new FileUploader($this->_path, 'png'))->generFilePath(true);
        $fileRecord = new \common\models\Images();
        $fileRecord->name = $fileName;
        $fileRecord->ext = 'png';
        $fileRecord->title = $fileName.'.png';
        $filePath = $this->_path.'/'.$fileName . '.png';
        file_put_contents($filePath, $file);
        chmod($filePath, 0777);
        return ($fileRecord->save())
            ? $fileRecord->id
            : null;
    }
}