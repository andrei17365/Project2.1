<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Comments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>


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

									$sql = "SELECT comments.id as comments_id, comments.text as comments_text, comments.date as comments_date, comments.user_id as comments_user_id, comments.hide as comments_hide, users.id as users_id, users.name as users_name, users.email as users_email, users.password as users_password, users.image as users_image FROM comments LEFT JOIN users ON users.id=comments.user_id ORDER BY comments.id DESC";

									$statement = $pdo->prepare($sql);

									$statement->execute();

									$result = $statement->fetchAll(PDO::FETCH_ASSOC);

							?>


                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    	<?php foreach ($result as $comment): ?>

                                        <tr>
                                            <td>
                                                <img src="<?php echo 'img/'.$comment['users_image']; ?>" alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?php echo $comment['users_name']; ?></td>
                                            <td><?php echo date("d/m/Y", strtotime($comment['comments_date'])); ?></td>
                                            <td><?php echo $comment['comments_text']; ?></td>
                                            <td>
                                            	<? if ($comment['comments_hide'] == 1) { ?>
                                                    <a href="admin_hideoff.php?id=<? echo $comment['comments_id'] ?>" class="btn btn-success">Разрешить</a>
												<? } else { ?>
                                                    <a href="admin_hideon.php?id=<? echo $comment['comments_id'] ?>" class="btn btn-warning">Запретить</a>
												<? } ?>
                                                <a href="admin_del.php?id=<? echo $comment['comments_id'] ?>" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
										<?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
