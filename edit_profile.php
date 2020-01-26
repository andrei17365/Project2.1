<?php
	session_start();

	include 'functions.php';
	$db = include 'database/start.php';


	unset($_SESSION['email_edit_err']);
	unset($_SESSION['name_edit_err']);
	unset($_SESSION['image_edit_err']);


	$name = $_SESSION['name_login'];
	$email = $_SESSION['email_login'];
	$id = $_SESSION['id_login'];
	$image = $_SESSION['image_login'];

	$new_name = $_POST['name'];
	$new_email = $_POST['email'];

	$result = $db->getOne(users, ['email' => $email]);

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
		$db->update(users, [
			'id' => $id,
			'name' => $new_name,
			'email' => $new_email,
			'image' => $new_image
		]);

		$_SESSION['email_login'] = $new_email;
		$_SESSION['name_login'] = $new_name;
		$_SESSION['image_login'] = $new_image;


		header('Location: /profile.php');
	}

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