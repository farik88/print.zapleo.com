<?php
namespace frontend\core\base;
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.05.17
 * Time: 9:16
 */
abstract class FrontendController extends \common\components\base\BaseController
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

}