<?php 
    echo "Logged out successfully";

    session_start();
    session_destroy();
    setcookie(session_id(),time()-1);
?>
<?php 


session_start();
$_SESSION = [];
session_unset();
session_destroy();

echo "<script>
alert('User Berhasil Logout.')
location = 'index.php?page=login';
</script>";

exit;

?>