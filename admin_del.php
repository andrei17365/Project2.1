<?php
	session_start();
	
	include 'functions.php';
	$db = include 'database/start.php';

	$db->delete(comments, $_GET['id']);

	header('Location: /admin.php');

?>