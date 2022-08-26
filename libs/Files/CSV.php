<?php

namespace app\libs\Files;

use app\libs\interfaces\Files as FilesInterface;

class CSV implements FilesInterface
{
    public function readContent($file)
    {
        $open = fopen($file, "r");
        while (($data = fgetcsv($open, 1000, ",")) !== false) {
            $content[] = $data;
        }
        fclose($open);
        $result = [];
        $titles = $content[0];
        for ($I = 1; $I <= count($content); ++$I) {
            for ($J = 0; $J <= count($titles); ++$J) {
                if (array_key_exists($J, $titles) && ! is_null($titles[$J])) {
                    try {
                        $result[$I - 1][$titles[$J]] = $content[$I][$J];
                    }
                    catch (\Exception $exception) {

                    }
                }
            }
        }

        return $result;
    }
}