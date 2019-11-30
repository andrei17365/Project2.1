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

	if(isset($_COOKIE['email_login']) & isset($_COOKIE['pass_login'])){
		$email = $_COOKIE['email_login'];
		$password = $_COOKIE['pass_login'];
		$_POST['remember'] = 1;
	} else {
		$email = $_POST['email'];
		$password = $_POST['password'];
	}
	if ($_POST['remember'] == 1) {
			setcookie('email_login', $email, time() + 3600);
			setcookie('pass_login', $password, time() + 3600);
		} else {
			setcookie('email_login', '', time());
			setcookie('pass_login', '', time());
		}

	if (empty($email)){
		$_SESSION['email_login_err'] = 'Введите адрес почтового ящика';
		setcookie('email_login', '', time());
		setcookie('pass_login', '', time());
	}
	if (!empty($email)){
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_login_err'] = 'Формат почтового ящика неправильный';
			setcookie('email_login', '', time());
			setcookie('pass_login', '', time());
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
			}
			else {
				if (empty($password)){
					$_SESSION['pass_login_err'] = 'Введите пароль';
					setcookie('email_login', '', time());
					setcookie('pass_login', '', time());
				}
				elseif (!(password_verify($password, $result[0]['password']))){
					$_SESSION['pass_login_err'] = 'Пароль не совпадает';
					setcookie('email_login', '', time());
					setcookie('pass_login', '', time());
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
		header('Location: /index.php');
	}

?>