<?php

namespace app\core;

class Request
{
    public function gtePath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];
        if ($_SERVER['HTTP_ACCEPT'] == 'application/json') {
            $inputs = (array)json_decode(file_get_contents('php://input'));
            foreach ($inputs as $key => $input) {
                $body[$key] = htmlspecialchars(strip_tags($input));
            }
        } else {
            if ($this->getMethod() == 'get') {
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            if ($this->getMethod() == 'post') {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }

        return $body;
    }
}