<?php
	session_start();

	include 'functions.php';
	$db = include 'database/start.php';



	$id = $_SESSION['id_login'];
	$current_password = $_POST['current'];
	$new_password = $_POST['password'];
	$new_password_conf = $_POST['password_confirmation'];

	$result = $db->getOne(users, ['id' => $id]);

	$hash = $result[0]['password'];


	if (empty($current_password)){
		$_SESSION['current_pass_err'] = 'Введите пароль';
	}
	if (!(password_verify($current_password, $hash))){
		$_SESSION['current_pass_err'] = 'Вы ввели неверный пароль';
	}

	if (empty($new_password)){
		$_SESSION['new_pass_err'] = 'Введите новый пароль';
	}
	if (!empty($new_password) & strlen($new_password)<6){
		$_SESSION['new_pass_err'] = 'Длина пароля должна быть не менее 6-ти символов';
	}

	if (empty($new_password_conf)){
		$_SESSION['new_pass_conf_err'] = 'Подтвердите пароль';
	}
	if (!empty($new_password_conf)){
		if ($new_password!=$new_password_conf)
			$_SESSION['new_pass_conf_err'] = 'Пароли не совпадают';
	}


	if ((!empty($_SESSION['current_pass_err'])) or (!empty($_SESSION['new_pass_err'])) or (!empty($_SESSION['new_pass_conf_err'])) ){
		header('Location: /profile.php');
	}
	else {
		$newpass = password_hash($new_password,PASSWORD_DEFAULT);
		$db->update(users, ['id' => $id, 'password' => $newpass]);
		header('Location: /profile.php');
	}

?>