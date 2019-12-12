<?php session_start();
	session_destroy();?>
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action="register_new_user.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                        <?php if (isset($_SESSION['name_err'])){?>
										<div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name_new_user" autofocus>

                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $_SESSION['name_err']; ?></strong>
                                                </span>
                                        </div>
                                        <?php unset($_SESSION['name_err']); } else {?>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name_new_user" value="<?php $_POST['name_new_user'] ?>" autofocus>
                                        </div>
                                        <?php } ?>
                                    </div>


                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

										 <?php if (isset($_SESSION['email_err'])){?>
										<div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autofocus>

                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $_SESSION['email_err']; ?></strong>
                                                </span>
                                        </div>
                                        <?php unset($_SESSION['email_err']); } else {?>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" >
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

										<?php if (isset($_SESSION['pass_err'])){?>
										<div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autofocus>

                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $_SESSION['pass_err']; ?></strong>
                                                </span>
                                        </div>
                                        <?php unset($_SESSION['pass_err']); } else {?>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                        <?php if (isset($_SESSION['passconf_err'])){?>
										<div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" autofocus>

                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $_SESSION['passconf_err']; ?></strong>
                                                </span>
                                        </div>
                                        <?php unset($_SESSION['passconf_err']); } else {?>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<? //var_dump($_SESSION); ?>
