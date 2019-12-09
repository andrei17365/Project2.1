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




	$name = $_POST['name'];
	$email = $_POST['email'];
	$image = $_FILES['image'];
	$image_user = 'no-user.jpg';
		$sql = "SELECT * FROM users WHERE email = :email";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':email', $email);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$id = $result[0]['id'];

	if (empty($name)){
		$_SESSION['name_edit_err'] = 'Введите имя';
	}
	if (empty($email)){
		$_SESSION['email_edit_err'] = 'Введите адрес почтового ящика';
	}
	if (!empty($email)){
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_edit_err'] = 'Формат почтового ящика неправильный';
		} elseif ($email != $_SESSION['email_login']){
			$sql = "SELECT * FROM users WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (isset($result[0]['email'])){
				$_SESSION['email_edit_err'] = 'Этот почтовый ящик занят!';
			}
		}
	}

	if (empty($image)){
		$sql = "SELECT * FROM users WHERE email = :email";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':email', $email);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$image_user = $result[0]['image'];
	}
	elseif ($image!==$image_user) {
		if (can_upload_image($image) == true){
			$sql = "SELECT * FROM users WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			$img_del = $result[0]['image'];
			unlink('img/'.$img_del);
		}
	} else {
		can_upload_image($image);
	}



	if (!empty($_SESSION['name_edit_err']) or !empty($_SESSION['email_edit_err']) or !empty($_SESSION['image_edit_err'])){
		//header('Location: /profile.php');
	}
	else {
		$sql = "UPDATE users SET name=:name, email=:email, image=:image WHERE id=:id";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':id', $id);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':email', $email);
		$statement->bindParam(':image', $image_user);
		$statement->execute();

		setcookie('email_login', $email, time() + 3600);
		setcookie('name_login', $name, time() + 3600);

		//header('Location: /profile.php');
	}

	var_dump($_SESSION);
	var_dump($image);
	echo $image_user;


	function can_upload_image($file){
		/* если размер файла 0, значит его не пропустили настройки
		сервера из-за того, что он слишком большой */
		if($file['size'] == 0){
			$_SESSION['image_edit_err'] = 'Файл слишком большой.';
			return $_SESSION['image_edit_err'];
		}

		// разбиваем имя файла по точке и получаем массив
		$getMime = explode('.', $file['name']);
		// нас интересует последний элемент массива - расширение
		$mime = strtolower(end($getMime));
		// объявим массив допустимых расширений
		$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

		// если расширение не входит в список допустимых - return
		if(!in_array($mime, $types)){
			$_SESSION['image_edit_err'] = 'Недопустимый тип файла.';
			return $_SESSION['image_edit_err'];
		}

		return true;
	}

?>