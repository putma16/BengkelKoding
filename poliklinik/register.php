<?php
// Include file koneksi ke database
include_once("koneksi.php");

// Fungsi untuk memeriksa kesamaan username di database
function isUsernameTaken($mysqli, $username) {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($mysqli, $query);
    return (mysqli_num_rows($result) > 0);
}

if (isset($_POST['register'])) {
    //mengambil nilai dari formulir
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    // Cek apakah username sudah ada di database
    if (isUsernameTaken($mysqli, $username)) {
        echo "<script>alert('Username sudah terpakai. Silakan pilih username lain.')</script>";
    } elseif ($password !== $confirm) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok.')</script>";
    } else {
        // Hash password sebelum menyimpannya ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data user baru ke database
        $insert_query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
        $insert_result = mysqli_query($mysqli, $insert_query);

        if ($insert_result) {
            echo "<script>
            alert('User Berhasil Ditambahkan. Silakan login.')
            location = 'index.php?page=login';
            </script>";
        } else {
            echo "<script>
            alert('Terjadi kesalahan saat mendaftar. Silakan coba lagi.')
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <title>Register</title>   <!-- Judul Halaman -->
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="register.php">
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
                                <label for="confirm" class="control-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm your Password" />
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" name="register" class="btn btn-primary btn-lg btn-block login-button">Register</button>
                            </div>
                            <div class="login-register mt-3">
                                <p class="text-register">Anda sudah punya akun? Silahkan
                                <a href="index.php?page=login">Login</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

