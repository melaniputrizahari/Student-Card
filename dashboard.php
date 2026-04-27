<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "pengunjung");
if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

$pesan = "";
$sapaan = "";
$error = "";

if(isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $komentar = trim($_POST['komentar']);

    $check_query = "SELECT * FROM bukutamu 
                    WHERE LOWER(nama) = LOWER('$nama') 
                       OR LOWER(email) = LOWER('$email')";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $error = "Nama atau Email sudah pernah digunakan! Tidak boleh duplikasi.";
    } else {
        $query = "INSERT INTO bukutamu (nama, email, komentar) VALUES ('$nama', '$email', '$komentar')";
        if(mysqli_query($conn, $query)) {
            $pesan = "Data berhasil disimpan!";
            $sapaan = "Halo " . htmlspecialchars($nama);
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

$result_data = mysqli_query($conn, "SELECT * FROM bukutamu ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Student Card - Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background-color: pink;
            display: flex;
            justify-content: center;
            padding: 20px;
            transition: background-color 0.3s, color 0.3s;
        }
        .card {
            background: white;
            border-radius: 8px;
            width: 950px;
            max-width: 100%;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: background 0.3s;
        }
        .card-header {
            background: #4b4f8a;
            color: white;
            padding: 12px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            font-size: 20px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            background: #5c8f5f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-logout {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #4b4f8a;
            color: white;
        }
        hr {
            margin: 20px 0;
        }
        .sapaan {
            font-size: 18px;
            font-weight: bold;
            color: #4b4f8a;
            margin: 10px 0;
        }
        .error-msg {
            color: red;
            font-weight: bold;
        }
        body.dark {
            background-color: #1e1e1e;
            color: white;
        }
        body.dark .card {
            background: #2c2c2c;
        }
        body.dark input, body.dark textarea {
            background: #3a3a3a;
            color: white;
            border-color: #555;
        }
        body.dark th {
            background: #2c2c2c;
        }
        body.dark td {
            border-color: #555;
        }
        body.dark .card-header {
            background: #2c2c2c;
            border-bottom: 1px solid #555;
        }
        body.dark .sapaan {
            color: #e67e22;
        }
    </style>
</head>
<body id="dashboardBody">
<div class="card">
    <div class="card-header">Student Card</div>
    
    <h3>Input Data ke Database</h3>
    <form method="post">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="komentar" rows="3" placeholder="Komentar"></textarea>
        <button type="submit" name="simpan">Simpan ke Database</button>
    </form>

    <?php if(!empty($pesan)): ?>
        <p style="color:green"><?php echo $pesan; ?></p>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <p class="error-msg"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if(!empty($sapaan)): ?>
        <div class="sapaan"><?php echo $sapaan; ?></div>
    <?php endif; ?>

    <hr>
    <h3>Data Buku Mahasiswa</h3>
    <table>
        <thead>
            <tr><th>Nama</th><th>Email</th><th>Komentar</th></tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result_data)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['komentar']); ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($result_data) == 0): ?>
            <tr><td colspan="3">Belum ada数据</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 30px;">
        <a href="logout.php" class="btn-logout">🚪 Logout</a>
    </div>
</div>

<script>
    function loadThemeDashboard() {
        let theme = localStorage.getItem("app_theme");
        let body = document.getElementById("dashboardBody");
        if (theme === "dark") {
            body.classList.add("dark");
        } else {
            body.classList.remove("dark");
        }
    }
    window.onload = loadThemeDashboard;
</script>
</body>
</html>
<?php mysqli_close($conn); ?>