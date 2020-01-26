<?php
	session_start();
		
	include 'functions.php';
	$db = include 'database/start.php';
	
	$db->update(comments, [
	'hide' => '1'
	], 
	$_GET['id']);

	header('Location: /admin.php');

?>