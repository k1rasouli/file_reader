<?php

namespace app\libs\Files;

use app\libs\interfaces\Files as FilesInterface;

class JSON implements FilesInterface
{
    public function readContent($file)
    {
        $json = file_get_contents($file);
        $json_data = json_decode($json, true);

        return $json_data;
    }
}