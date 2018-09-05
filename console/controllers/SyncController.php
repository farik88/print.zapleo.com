<?php
namespace console\controllers;

use common\models\Covers;
use common\models\Deliveries;
use common\models\Files;
use common\models\Languages;
use common\models\Payments;
use common\models\ProductColor;
use common\models\ProductCover;
use common\models\Products;
use Yii;
use yii\console\Controller;

class SyncController extends Controller
{
    public function actionInit()
    {
        $base_files = $this->dataBaseFiles();
        $files_base = $this->filesDataBase();
        $files = $this->filesClear();
        $files_server = $this->filesClearServer();

        echo 'Done!'.PHP_EOL;
        echo 'Base files delete:'.PHP_EOL;
        echo ' - color '.$base_files['color'].PHP_EOL;
        echo ' - cover '.$base_files['cover'].PHP_EOL;
        echo PHP_EOL.'Files base delete:'.PHP_EOL;
        echo ' - color '.$files_base['color'].PHP_EOL;
        echo ' - cover '.$files_base['cover'].PHP_EOL;
        echo PHP_EOL.'Files clear: '.$files;
        echo PHP_EOL.'Files clear server: '.$files_server;
    }

    public function dataBaseFiles()
    {
        $product_colors = ProductColor::find()->all();
        $product_covers = ProductCover::find()->all();

        $color_i = 0;
        $cover_i = 0;

        foreach ($product_colors as $product_color) {
            $file = Files::findOne($product_color->file_id);

            if (!file_exists(Yii::getAlias('@backend').'/web/uploads/colors/'.$file->title)) {
                $product_color->delete();
                $color_i += 1;
            }
        }

        foreach ($product_covers as $product_cover) {
            $file = Files::findOne($product_cover->file_id);

            if (!file_exists(Yii::getAlias('@backend').'/web/uploads/covers/'.$file->title)) {
                $product_cover->delete();
                $cover_i += 1;
            }
        }

        return ['color' => $color_i, 'cover' => $cover_i];
    }

    public function filesDataBase()
    {
        $scanned_directory_colors = Yii::getAlias('@backend').'/web/uploads/colors';
        $scanned_directory_covers = Yii::getAlias('@backend').'/web/uploads/covers';

        $dir_colors = array_diff(scandir($scanned_directory_colors), array('..', '.'));
        $dir_covers = array_diff(scandir($scanned_directory_covers), array('..', '.'));

        $color_i = 0;
        $cover_i = 0;

        foreach ($dir_colors as $color) {
            $file = Files::findOne(['title' => $color]);
            $product_color = ProductColor::findOne(['file_id' => $file->id]);

            if (empty($product_color->id)) {
                unlink(Yii::getAlias('@backend').'/web/uploads/colors/'.$color);
                $file->delete();
                $color_i += 1;
            }
        }

        foreach ($dir_covers as $cover) {
            $file = Files::findOne(['title' => $cover]);
            $product_cover = ProductCover::findOne(['file_id' => $file->id]);

            if (empty($product_cover->id)) {
                unlink(Yii::getAlias('@backend').'/web/uploads/covers/'.$cover);
                $file->delete();
                $cover_i += 1;
            }
        }

        return ['color' => $color_i, 'cover' => $cover_i];
    }

    public function filesClear()
    {
        $product_colors = ProductColor::find()->select('file_id')->asArray()->column();
        $product_covers = ProductCover::find()->select('file_id')->asArray()->column();
        $deliveries = Deliveries::find()->select('file_id')->asArray()->column();
        $payments = Payments::find()->select('file_id')->asArray()->column();
        $languages = Languages::find()->select('file_id')->asArray()->column();
        $products = Products::find()->select('file_id')->asArray()->column();
        $covers = Covers::find()->select('file_id')->asArray()->column();

        $file_i = 0;

        $files = Files::find()
            ->select(['id', 'title'])
            ->where(['not in', 'id', $product_colors])
            ->andWhere(['not in', 'id', $product_covers])
            ->andWhere(['not in', 'id', $deliveries])
            ->andWhere(['not in', 'id', $payments])
            ->andWhere(['not in', 'id', $languages])
            ->andWhere(['not in', 'id', $products])
            ->andWhere(['not in', 'id', $covers])
            ->all();

        foreach ($files as $file) {
            unlink(Yii::getAlias('@backend').'/web/uploads/'.$file->title);
            $file->delete();
            $file_i += 1;
        }

        return $file_i;
    }

    public function filesClearServer()
    {
        $scanned_directory_uploads = Yii::getAlias('@backend').'/web/uploads';

        $dir_uploads = array_diff(scandir($scanned_directory_uploads), array('..', '.'));

        foreach ($dir_uploads as $i => $upload) {
            if (!strripos($upload, '.'))
                unset($dir_uploads[$i]);
        }

        $files_i = 0;

        foreach ($dir_uploads as $upload) {
            $file = Files::findOne(['title' => $upload]);

            if (empty($file->id)) {
                unlink(Yii::getAlias('@backend').'/web/uploads/'.$upload);
                $files_i += 1;
            }
        }
        return $files_i;
    }
}