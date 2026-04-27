<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "pengunjung");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama = $_POST['nama'];
$email = $_POST['email'];
$komentar = $_POST['komentar'];

$query = "INSERT INTO bukutamu (nama, email, komentar) VALUES ('$nama', '$email', '$komentar')";
if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php?pesan=Data berhasil disimpan");
} else {
    header("Location: dashboard.php?pesan=Gagal menyimpan data");
}
mysqli_close($conn);
?>