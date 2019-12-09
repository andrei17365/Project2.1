<?php session_start(); ?>

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
                <a class="navbar-brand" href="index.php">
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
                            <?php if(isset($_SESSION['authorization']) & $_SESSION['authorization']) {?>
							<li class="nav-item">
                                <a class="nav-link" href="profile.php">Редактировать профиль</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="logout.php">Выйти</a>
                            </li>
                            <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                            <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>

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

									$sql = "SELECT comments.id as comments_id, comments.text as comments_text, comments.date as comments_date, comments.user_id as comments_user_id, users.id as users_id, users.name as users_name, users.email as users_email, users.password as users_password FROM comments LEFT JOIN users ON users.id=comments.user_id ORDER BY comments.id DESC";

									$statement = $pdo->prepare($sql);

									$statement->execute();

									$result = $statement->fetchAll(PDO::FETCH_ASSOC);

							?>

                            <div class="card-body">

                            <?php if (isset($_SESSION['newcomment'])){?>
                              <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['newcomment']; ?>
                              </div>
                            <?php unset($_SESSION['newcomment']); }?>


                              <?php foreach ($result as $comment): ?>
                                <div class="media">
                                  <img src="<?php echo 'img/no-user.jpg'; ?>" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"><?php echo $comment['users_name']; ?></h5>
                                    <span><small><?php echo date("d/m/Y", strtotime($comment['comments_date'])); ?></small></span>
                                    <p>
                                        <?php echo $comment['comments_text']; ?>
                                    </p>
                                  </div>
                                </div>
							   <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                    <?php if(isset($_SESSION['authorization']) & $_SESSION['authorization']) {?>
					<div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="comments.php" method="post">
                                 <!--   <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="name" class="form-control" id="exampleFormControlTextarea1" />
                                  	</div> -->
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                  </div>
                                  <button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php } else { ?>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Вы не можете оставлять комментарии</h3></div>
								<div class="card-body">
									<li class="nav-item">
	                                <a class="nav-link" href="login.php">Login</a>
	                            	</li>
	                            	<li class="nav-item">
	                                <a class="nav-link" href="register.php">Register</a>
	                            	</li>
                            	</div>
                        </div>
                    </div>
					<?php } ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
