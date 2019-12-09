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

	$sql = "INSERT INTO comments (text, user_id) VALUES (:text, :user_id)";

	$user_id = $_SESSION['id_login'];
	$text = $_POST['text'];

	$statement = $pdo->prepare($sql);

	$statement->bindParam(':user_id', $user_id);
	$statement->bindParam(':text', $text);





	if (!empty($_POST['text'])){
		$_SESSION['newcomment'] = 'Ваш коментарий успешно добавлен';
		$statement->execute();
	} else {
		$_SESSION['newcomment'] = 'Введите сообщение';
	}
	header('Location: /index.php');

?>