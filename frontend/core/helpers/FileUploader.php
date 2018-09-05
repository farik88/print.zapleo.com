<?php

namespace frontend\core\helpers;
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 17.05.17
 * Time: 12:52
 */
class FileUploader
{
    private $_path;
    private $_ext; 
    
    public function __construct($path = null, $ext = null)
    {
        $this->_path = $path;
        $this->_ext = $ext;
        
    }

    /**
     * @param bool $nameOnly
     * @param int $countTries
     * @return string path or filename with random name
     * @throws \Exception
     */
    public function generFilePath($nameOnly = false, $countTries = 5)
    {
        if(!$this->_path || !$this->_ext) {
            throw new \Exception; //todo make good exception
        }
        $i = 0;
        do {
            if($i++ > $countTries){
                throw new \Exception;
            }
            $name = md5(microtime() . rand(0, 9999));
            $filePath = $this->_path . DIRECTORY_SEPARATOR. $name . "." .  $this->_ext;
        }
        while (file_exists($filePath));
        return (!$nameOnly)
            ? $filePath
            : $name;
    }
    

}