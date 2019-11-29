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



	$email = $_POST['email'];
	$password = $_POST['password'];

	if (empty($email)){
		$_SESSION['email_login_err'] = 'Введите адрес почтового ящика';
	}
	if (!empty($email)){
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_login_err'] = 'Формат почтового ящика неправильный';
		}
		else {
			$sql = "SELECT * FROM users WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if ($result==null){
				$_SESSION['email_login_err'] = 'Пользователя с таким почтовым ящиком не зарегистрировано';
			}
			else {
				if (empty($password)){
					$_SESSION['pass_login_err'] = 'Введите пароль';
				}
				elseif (!(password_verify($password, $result[0]['password']))){
					$_SESSION['pass_login_err'] = 'Пароль не совпадает';
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