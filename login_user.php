<?php
	session_start();

	$driver = 'mysql'; // тип базы данных, с которой мы будем работать

	$host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального

	$db_name = 'projectphp1'; // имя базы данных

	$db_user = 'root'; // имя пользователя для базы данных

	$db_password = ''; // пароль пользователя

	$charset = 'utf8'; // кодировка по умолчанию

	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений

	$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

	$pdo = new PDO($dsn, $db_user, $db_password, $options);

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

		$sql = "SELECT * FROM users WHERE email = :email";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':email', $email);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		$name = $result[0]['name'];
		$id = $result[0]['id'];
		$image = $result[0]['image'];
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
			$sql = "SELECT * FROM users WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
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

		//setcookie('email_login', $email, time() + 3600);
		//setcookie('pass_login', $password, time() + 3600);
		//setcookie('name_login', $name, time() + 3600);
		//setcookie('id_login', $id, time() + 3600);
		header('Location: /index.php');
		//var_dump($_SESSION);
		//var_dump($_COOKIE);
	}

?>