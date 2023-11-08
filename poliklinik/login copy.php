<?php
// Include file koneksi ke database
include_once("koneksi.php");

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($mysqli, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if(mysqli_num_rows($result) === 1){
        
        //cek password
        $row = mysqli_fetch_array($result);
        if(password_verify($password, $row["password"])){
            echo "<script>
            window.location = 'index.php';
            </script>";
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="#">
                        <?php if( isset($error) ) : ?>
                            <p style="color: red; font-style: italic;">username / password salah!</p>
                        <?php endif; ?>
                        
                            <div class="form-group mt-3">
                                <label for="username" class="control-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Username" />
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password" class="control-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password" />
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" name="login" class="btn btn-primary btn-lg btn-block login-button">Login</button>
                            </div>
                            <div class="login-register mt-3">
                                <a href="index.php?page=register">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>