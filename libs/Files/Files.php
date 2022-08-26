<?php

namespace app\libs\Files;

class Files
{
    private $filesAddress = __DIR__."/../../public/files";
    public array $filesArray;
    public $activeFile;
    private array $allowdExtentions = ['CSV', 'JSON'];

    public function __construct()
    {
        $this->filesArray = array_diff(scandir($this->filesAddress), ['.', '..']);
    }

    public function fileContent()
    {
        $contents = [];
        foreach ($this->filesArray as $file) {
            $ext = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $this->allowdExtentions)) {
                $fileObject = new ('app\\libs\\Files\\'.$ext)();
                $contents[] = $fileObject->readContent($this->filesAddress.'/'.$file);
            }
        }

        return $contents;
    }
}