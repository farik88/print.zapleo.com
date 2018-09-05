<?php

/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.01.17
 * Time: 1:18
 */

namespace frontend\core\exceptions;

class FolderCannotCreateException extends BaseException
{
    protected $message = 'Folder cannot be created';
}