<?php

namespace app\libs;
use \app\libs\interfaces\Files as FilesInterface;
class Files implements FilesInterface
{
    private $filesAddress = __DIR__ . "/../public/files";
    public array $filesArray;
    public $activeFile;
    public function __construct()
    {
        $this->filesArray = array_diff(scandir($this->filesAddress), ['.', '..']);
    }
    public function fileContent()
    {
        foreach ($this->filesArray as $file) {

        }
    }
}