<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 13.05.17
 * Time: 13:52
 */

namespace frontend\models;


use common\components\base\BaseModel;
use common\traits\SimpleYiiTrait;
use frontend\core\exceptions\UploadFailureException;
use frontend\core\helpers\FileUploader;
use Yii;
use yii\web\UploadedFile;

class ImageUploadForm extends BaseModel
{
    use SimpleYiiTrait;
    const FORM_NAME = "file";
    public $fileId;
    public $ext;
    public $name;
    /**
     * @var UploadedFile
     */
    public $fileObj;
    public $path;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ext', 'path'], 'string'],
            [['fileObj'], 'file', 'skipOnEmpty' => false,'message'=>Yii::t('frontend_image_upload','Файл не того расширения'), 'extensions' => 'png, gif, jpg, bmp, jpeg', 'maxSize' => 10*1024*1024,],
        ];
    }
    
    /**
     * @return string
     * @throws UploadFailureException
     */
    public function save() {
        if (! $this->validate()) {
            throw new UploadFailureException("", $this->getErrors());
        }
        $this->name = (new FileUploader($this->path, $this->ext))->generFilePath(true);
        $fullName = $this->name . '.' . $this->ext;
        $filePath = $this->path . '/' . $fullName;
        $this->fileObj->saveAs($filePath);
        chmod($filePath, 0644);
        return $fullName;
    }
    
}
