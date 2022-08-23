<?php

namespace app\core;

class Application
{
    public Request $request;
    public Router $router;
    public Response $response;
    public DotEnv $env;
    public Database $db;
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->env = new DotEnv();
        $this->env->load();
        $this->db = new Database();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}