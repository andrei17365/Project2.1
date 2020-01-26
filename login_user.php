<?php
	session_start();

	//include 'functions.php';
	$db = include 'database/start.php';

	$_SESSION['authorization'] = false;

	if(isset($_COOKIE['email_login']) & isset($_COOKIE['pass_login']) & isset($_COOKIE['name_login']) & isset($_COOKIE['id_login']) & isset($_COOKIE['image_login'])){
		$email = $_COOKIE['email_login'];
		$password = $_COOKIE['pass_login'];
		$name = $_COOKIE['name_login'];
		$id = $_COOKIE['id_login'];
		$image = $_COOKIE['image_login'];

		$_POST['remember'] = 1;
	} else {
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$result = $db->getOne(users, ['email' => $email]);
		$name = $result['name'];
		$id = $result['id'];
		$image = $result['image'];
	}
	if ($_POST['remember'] == 1) {
			setcookie('email_login', $email, time() + 3600);
			setcookie('pass_login', $password, time() + 3600);
			setcookie('name_login', $name, time() + 3600);
			setcookie('id_login', $id, time() + 3600);
			setcookie('image_login', $id, time() + 3600);
		} else {
			setcookie('email_login', '', time());
			setcookie('pass_login', '', time());
			setcookie('name_login', '', time());
			setcookie('id_login', '', time());
			setcookie('image_login', '', time());
		}

	if (empty($email)){
		$_SESSION['email_login_err'] = 'Введите адрес почтового ящика';
		setcookie('email_login', '', time());
		setcookie('pass_login', '', time());
		setcookie('name_login', '', time());
		setcookie('id_login', '', time());
		setcookie('image_login', '', time());
	}
	if (!empty($email)){
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_login_err'] = 'Формат почтового ящика неправильный';
			setcookie('email_login', '', time());
			setcookie('pass_login', '', time());
			setcookie('name_login', '', time());
			setcookie('id_login', '', time());
			setcookie('image_login', '', time());
		}
		else {
			$result = $db->getOne(users, ['email' => $email]);
			if ($result==null){
				$_SESSION['email_login_err'] = 'Пользователя с таким почтовым ящиком не зарегистрировано';
				setcookie('email_login', '', time());
				setcookie('pass_login', '', time());
				setcookie('name_login', '', time());
				setcookie('id_login', '', time());
				setcookie('image_login', '', time());
			}
			else {
				if (empty($password)){
					$_SESSION['pass_login_err'] = 'Введите пароль';
					setcookie('email_login', '', time());
					setcookie('pass_login', '', time());
					setcookie('name_login', '', time());
					setcookie('id_login', '', time());
					setcookie('image_login', '', time());
				}
				elseif (!(password_verify($password, $result[0]['password']))){
					$_SESSION['pass_login_err'] = 'Пароль не совпадает';
					setcookie('email_login', '', time());
					setcookie('pass_login', '', time());
					setcookie('name_login', '', time());
					setcookie('id_login', '', time());
					setcookie('image_login', '', time());
				}
			}
		}
	}

	if (!empty($_SESSION['email_login_err']) or !empty($_SESSION['pass_login_err'])){
		header('Location: /login.php');
	}
	else {
		$_SESSION['email_login'] = $email;
		$_SESSION['pass_login'] = $password;
		$_SESSION['authorization'] = true;
		$_SESSION['name_login'] = $name;
		$_SESSION['id_login'] = $id;
		$_SESSION['image_login'] = $image;

		
		header('Location: /');
		
	}

?>