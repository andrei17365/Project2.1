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



	$id = $_SESSION['id_login'];
	$current_password = $_POST['current'];
	$new_password = $_POST['password'];
	$new_password_conf = $_POST['password_confirmation'];

	$sql = "SELECT * FROM users WHERE id = :id";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':id', $id);
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

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
		$sql = "UPDATE users SET password=:password WHERE id = :id";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':password', $newpass);
		$statement->bindParam(':id', $id);
		$statement->execute();
		header('Location: /profile.php');
	}

?>