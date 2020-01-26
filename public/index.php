<?php   

session_start();
include __DIR__.'/../functions.php';

$routes = [
	"/" => 'functions/homepage.php',
	"/homepage" => 'functions/homepage.php',
	"/about" => 'functions/about.php',
	"/login.php" => 'login.php',
	"/register.php" => 'register.php',
	"/login_user.php" => 'login_user.php',
	"/comments.php" => 'comments.php'
];

$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)){
	include __DIR__.'/../'.$routes[$route]; exit;
} else {
	dd(404);
}

?>


