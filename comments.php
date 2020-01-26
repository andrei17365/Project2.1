<?php
	session_start();
	//include 'functions.php';
	$db = include 'database/start.php';
	
	
	if (!empty($_POST['text'])){
		$_SESSION['newcomment'] = 'Ваш коментарий успешно добавлен';
		$db->create('comments',[
			'text' => $_POST['text'],
			'user_id' => $_SESSION['id_login']
		]);
	} else {
		$_SESSION['newcomment'] = 'Введите сообщение';
	}
	
	header('Location: /homepage');

?>