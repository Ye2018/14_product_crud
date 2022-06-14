<?php
// Router is used to handle the request and return the response
namespace app;
error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING | E_DEPRECATED ) );
class Router{

    public array $getRoutes = []; // class Router need 3 attributs. The first two are 
    public array $postRoutes = []; // from the get() and post() methods, the third is
    public Database $db;           // from construct.

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

    public function resolve() // resovle will detect what the current router is and execute the
    // corresponding function
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
        // From the following code, we need to learn how to use the super global $_SERVER
        // to obtain the information we need. 
        // One thing I need to mention here is for some unknown reason, 
        // $currentUrl = $_SERVER['PATH_INFO'] ?: '/'; cannot always be executed sucessfully.
        // Therefore, I have to get the $currentUrl from $_SERVER['REQUEST_URI']
        $currentUrl = $_SERVER['REQUEST_URI'] ?: '/';
        // However, $currentUrl obtained from the sentence above may contain extra information
        // we don't want. Fortunately, this extra information happens behind '?'.
        // For this reason, we have the following if-block.
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
            // The reason we have the second parameter $this is $this here donte the Router itself, 
            // and by doing so, we can let ProductController to establish a relationship to Router.
        }else{
            echo "Page not found";
        }
    }

    public function renderView($view, $params = [])  
    {
        foreach($params as $key => $value) {
            $$key = $value; // The reason we use 2 $ symbols here is $key itself equal to product, then 
            // $$key amounts to $products. Therefore, this sentence means the $value is assigned to $products
        }
        ob_start(); // start buffer of the output.
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean(); // Store the contents of an output buffer in a variable
        // and then deletes the contents from the buffer.
        include_once __DIR__.'/views/_layout.php';
    }
    
}