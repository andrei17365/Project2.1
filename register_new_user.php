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



	$name = $_POST['name_new_user'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$pass_conf = $_POST['password_confirmation'];
	$image = 'no-user';



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
			$sql = "SELECT * FROM users WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (isset($result[0]['email'])){
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
		$sql = "INSERT INTO users (name, email, password, image) VALUES (:name, :email, :password, :image)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':email', $email);
		$statement->bindParam(':password', $password);
		$statement->bindParam(':image', $image);
		$statement->execute();
		header('Location: /index.php');
	}
//	var_dump($result);

//	var_dump($_SESSION);
?>