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

	unset($_SESSION['email_edit_err']);
	unset($_SESSION['name_edit_err']);
	unset($_SESSION['image_edit_err']);


	$name = $_SESSION['name_login'];
	$email = $_SESSION['email_login'];
	$id = $_SESSION['id_login'];
	$image = $_SESSION['image_login'];

	$new_name = $_POST['name'];
	$new_email = $_POST['email'];


	if (empty($new_name)){
		$_SESSION['name_edit_err'] = 'Введите имя';
	}
	if (empty($new_email)){
		$_SESSION['email_edit_err'] = 'Введите адрес почтового ящика';
	}
	if (!empty($new_email)){
		if(!(filter_var($new_email, FILTER_VALIDATE_EMAIL))){
			$_SESSION['email_edit_err'] = 'Формат почтового ящика неправильный';
		} elseif ($new_email != $email){
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

	if (empty($_FILES['image']['name'])){
		$new_image = $image;

//		echo $new_image.'<br>';
	}
	else {
		if (can_upload_image() == true){
			if(strcmp($image, 'no-user.jpg')==1){
				unlink('img/'.$image);
			}
			$new_image = uniqid().$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],'img/'.$new_image);

//			echo $new_image.'<br>';
		}
	}



	if (!empty($_SESSION['name_edit_err']) or !empty($_SESSION['email_edit_err']) or !empty($_SESSION['image_edit_err'])){
		header('Location: /profile.php');
	}
	else {
		$sql = "UPDATE users SET name=:name, email=:email, image=:image WHERE id=:id";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':id', $id);
		$statement->bindParam(':name', $new_name);
		$statement->bindParam(':email', $new_email);
		$statement->bindParam(':image', $new_image);
		$statement->execute();

//		setcookie('email_login', $new_email, time() + 3600);
//		setcookie('name_login', $new_name, time() + 3600);
//		setcookie('id_login', $id, time() + 3600);
//		setcookie('image_login', $new_image, time() + 3600);
		$_SESSION['email_login'] = $new_email;
		$_SESSION['name_login'] = $new_name;
		$_SESSION['image_login'] = $new_image;


		header('Location: /profile.php');
	}

//	echo $new_image;
//	echo '<br>';
//	echo $image;
//	echo '<br>';
//	var_dump($_FILES);
//	echo '<br>';
//	var_dump($_SESSION);
//	echo '<br>';
//	var_dump(can_upload_image());

	function can_upload_image(){
		$flag = false;
		/* если размер файла 0, значит его не пропустили настройки
		сервера из-за того, что он слишком большой */
		if($_FILES['image']['size'] == 0){
			$_SESSION['image_edit_err'] = 'Файл слишком большой.';
			$flag = false;
			return $flag;
		}

		// разбиваем имя файла по точке и получаем массив
		$getMime = explode('.', $_FILES['image']['name']);
		// нас интересует последний элемент массива - расширение
		$mime = strtolower(end($getMime));
		// объявим массив допустимых расширений
		$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

		// если расширение не входит в список допустимых - return
		if(!in_array($mime, $types)){
			$_SESSION['image_edit_err'] = 'Недопустимый тип файла.';
			$flag = false;
			return $flag;
		}

		$flag = true;
		return $flag;
	}

?>