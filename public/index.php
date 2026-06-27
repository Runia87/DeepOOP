<?php
 use \Tamtamchik\SimpleFlash\Flash;
use function Tamtamchik\SimpleFlash\flash;
use DI\ContainerBuilder;
require '../code/vendor/autoload.php';
$containerBuilder = new ContainerBuilder();
$container=$containerBuilder->build();

if( !session_id() ) {
    session_start();
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\controllers\homeController','index']);
   // $r->addRoute('GET', '/about/{amount:\d+}', ['App\controllers\homeController','about']);
    $r->addRoute('GET', '/about', ['App\controllers\homeController','about']);
    $r->addRoute('GET', '/verification', ['App\controllers\homeController','email_verification']);
    $r->addRoute('GET', '/login', ['App\controllers\homeController','login']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}',['App\controllers\homeController','index']);
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        d($container->call($routeInfo[1],$routeInfo[2]));die;
        //d($handler,$vars); exit;
        $controller=new $handler[0];
        call_user_func([$controller,$handler[1]],$vars);
        //$controller->about($vars);
        //d([$controller,$handler[1]],$vars);
    //d($handler[0]); exit;
        // ... call $handler with $vars
        break;
}

function get_user_handler($vars){
d($vars['id']);
}

// if(true){

//     flash()->message('Hot!');
// }

// echo flash()->display();


// Start a Session


// use App\QueryBuilder;
// $db=new QueryBuilder;


// d($db);

// Create new Plates instance
// $templates = new League\Plates\Engine('../code/app/views');

// //var_dump($templates); die;

// // Render a template
// echo $templates->render('about', ['title' => 'Jonathan']);


// if($_SERVER['REQUEST_URI']=='/home'){
// require '../code/app/controllers/homepage.php';

// }

// exit;

?>
