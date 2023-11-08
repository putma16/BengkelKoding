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
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $konfirmasi_password = $_POST["konfirmasi_password"];

    // Cek apakah username sudah ada di database
    if (isUsernameTaken($mysqli, $username)) {
        echo "<script>alert('Username sudah terpakai. Silakan pilih username lain.')</script>";
    } elseif ($password !== $konfirmasi_password) {
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
</head>
<body>
    <h2>Form Register</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="konfirmasi_password">Konfirmasi Password:</label>
        <input type="password" name="konfirmasi_password" required>

        <button type="submit" name="register">Register</button>
    </form>

</body>
</html>
