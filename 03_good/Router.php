<?php

namespace app;
error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING | E_DEPRECATED ) );
class Router{

    public array $getRoutes = [];
    public array $postRoutes = [];
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function resolve()
    {
        // var_dump($_SERVER);
        // echo json_encode($_SERVER['REMOTE_PORT']);
        // exit;
        // $currentUrl = $_SERVER['PATH_INFO'] ?: '/';
        // $currentUrl = $_SERVER['PHP_SELF'] ?: '/';
        // if(!empty($_SERVER['PATH_INFO']))
        // {
        //     $currentUrl = $_SERVER['PATH_INFO'];
        // }else{
        //     $currentUrl = '/';
        // }
        $currentUrl = $_SERVER['REQUEST_URI'] ?: '/';
        if(strpos($currentUrl, '?') !== false)
        {
            $currentUrl = substr($currentUrl, 0, strpos($currentUrl, '?'));
        }
        // var_dump($currentUrl);
        // exit;
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET'){
            $fn = $this->getRoutes[$currentUrl] ?: null;
        }else{
            $fn = $this->postRoutes[$currentUrl] ?: null;
        }

        // var_dump($fn);

        if ($fn){
            call_user_func($fn, $this); // call_user_func is a special function, whenever you pass a 
            // function in it, it will execute this function.
        }else{
            echo "Page not found";
        }
    }

    public function renderView($view, $params = [])  
    {
        foreach($params as $key => $value) {
            $$key = $value;
        }
        ob_start(); // start buffer of the output.
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean(); // Store the contents of an output buffer in a variable
        // and then deletes the contents from the buffer.
        include_once __DIR__.'/views/_layout.php';
    }
    
}