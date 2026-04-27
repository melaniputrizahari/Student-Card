<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$conn = mysqli_connect("localhost", "root", "", "pengunjung");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $_SESSION['user'] = $username;
    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='login.php';</script>";
}

mysqli_close($conn);
?>