<?php
	session_start();

	include 'functions.php';
	$db = include 'database/start.php';



	$name = $_POST['name_new_user'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$pass_conf = $_POST['password_confirmation'];
	$image = 'no-user.jpg';



	if (empty($name)){
		$_SESSION['name_err'] = 'Введите имя';
	}
	if (empty($email)){
		$_SESSION['email_err'] = 'Введите адрес почтового ящика';
	}
	if (!empty($email)){
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_err'] = 'Формат почтового ящика неправильный';
		} else {
			$result = $db->getOne(users, ['email' => $email]);
			if (isset($result['email'])){
				$_SESSION['email_err'] = 'Почтовый ящик с таким именем занят';
			}
		}
	}
	if (empty($password)){
		$_SESSION['pass_err'] = 'Введите пароль';
	}
	if (!empty($_POST['password']) & strlen($_POST['password'])<6){
		$_SESSION['pass_err'] = 'Длина пароля должна быть не менее 6-ти символов';
	}
	if (empty($pass_conf)){
		$_SESSION['passconf_err'] = 'Подтвердите пароль';
	}
	if (!empty($pass_conf)){
		if (!(password_verify($pass_conf, $password))){
			$_SESSION['passconf_err'] = 'Пароли не совпадают';
		}
	}


	if ((!empty($_SESSION['name_err'])) or (!empty($_SESSION['email_err'])) or (!empty($_SESSION['pass_err'])) or (!empty($_SESSION['passconf_err']))){
		header('Location: /register.php');
	}
	else {
		$db->create(users, [
			'name' => $name,
			'email' => $email,
			'password' => $password,
			'image' => $image
		]);

		
		header('Location: /index.php');
	}
//	var_dump($result);

//	var_dump($_SESSION);
?>