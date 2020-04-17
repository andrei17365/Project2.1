<?php

require '../vendor/autoload.php';

// Create new Plates instance
$templates = new League\Plates\Engine('../app/views');

// Render a template
echo $templates->render('homepage', ['name' => 'Jonathan']);





/*if($_SERVER['REQUEST_URI'] == '/home'){
	require '../app/controllers/homepage.php';
}

exit;*/

