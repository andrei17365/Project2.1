<?php
	$driver = 'mysql'; // тип базы данных, с которой мы будем работать

	$host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального

	$db_name = 'projectphp1'; // имя базы данных

	$db_user = 'root'; // имя пользователя для базы данных

	$db_password = ''; // пароль пользователя

	$charset = 'utf8'; // кодировка по умолчанию

	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений

	$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

	$pdo = new PDO($dsn, $db_user, $db_password, $options);

	$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

	$statement = $pdo->prepare($sql);

	$name = $_POST['name_new_user'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$statement->bindParam(':name', $name);
	$statement->bindParam(':email', $email);
	$statement->bindParam(':password', $password);
	$statement->execute();


	/*session_start();

	if (!empty($_POST['name']) && !empty($_POST['text'])){
		$_SESSION['newcomment'] = 'Ваш коментарий успешно добавлен';
		$statement->execute();
	} elseif (empty($_POST['name']) && empty($_POST['text'])) {
		$_SESSION['newcomment'] = 'Введите имя и сообщение';
	} elseif (empty($_POST['name'])) {
		$_SESSION['newcomment'] = 'Введите имя';
	} else {
		$_SESSION['newcomment'] = 'Введите сообщение';
	}*/
	header('Location: /index.php');
?>