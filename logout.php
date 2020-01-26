<?php
	session_start();

	setcookie('email_login', '', time());
	setcookie('pass_login', '', time());
	setcookie('name_login', '', time());
	setcookie('id_login', '', time());
	$_SESSION['authorization'] = false;

	header('Location: /index.php');

?>