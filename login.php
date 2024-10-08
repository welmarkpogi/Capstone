<?php
session_start();

if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/header.php"; ?>

    <title>Login - Barangay Poblacion Profiling System</title>

    <style>
        label.placeholder {
            background: transparent;
            cursor: auto;
            
        }

        .login {
            background: url('assets/img/Logo.png');
            background-repeat: no-repeat;
            background-position: center;
            height: 80vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="login">
    <?php include "templates/loading_screen.php"; ?>
    <div class="wrapper wrapper-login">
        <div class="container-login animated fadeIn bg-transparent b-5  shadow-lg p-4 rounded">
            <?php include "templates/alert.php"; ?>

            <h2 class="text-center text-dark">Mag-sign Dinhi</h2>
            <div class="login-form">
                <form method="POST" action="model/login.php" autocomplete="off">
                    <div class="form-group form-floating-label">
                        <input id="username" name="username" type="text" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder"><h3>Username</h3></label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder"><h3>Password</h3></label>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-action mb-3 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-primary btn-block fw-bold ">Sign In</button>
                        <a href="resident-register.php" class="btn btn-info btn-block  fw-bold">Create New Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "templates/footer.php"; ?>
</body>

</html>
