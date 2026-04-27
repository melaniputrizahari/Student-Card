<?php
session_start();
if(isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Student Card</title>
    <style>
        body {
            font-family: Arial;
            background-color: pink;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }
        .card {
            width: 350px;
            background: white;
            border-radius: 8px;
            border: 1px solid #ddd;
            overflow: hidden;
            transition: background 0.3s;
        }
        .card-header {
            background: #4b4f8a;
            color: white;
            padding: 12px;
            font-weight: bold;
            text-align: center;
        }
        .card-body {
            padding: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background: #5c8f5f;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            margin-top: 5px;
        }
        .btn-tema {
            background: #e67e22;
            margin-top: 10px;
        }
        .info {
            font-size: 12px;
            margin-top: 15px;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }
        body.dark .info {
            background: #3a3a3a;
            color: #ddd;
        }

        body.dark {
            background-color: #1e1e1e;
            color: white;
        }
        body.dark .card {
            background: #2c2c2c;
            border-color: #555;
        }
        body.dark input {
            background: #3a3a3a;
            color: white;
            border-color: #555;
        }
        body.dark .card-header {
            background: #2c2c2c;
            border-bottom: 1px solid #555;
        }
    </style>
</head>
<body id="loginBody">
<div class="card">
    <div class="card-header">Login</div>
    <div class="card-body">
        <form method="post" action="cek_login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <button class="btn-tema" onclick="toggleTheme()">🌓 Ubah Tema</button>
        
        <div class="info">
            <strong>Gunakan</strong><br>
            Username: admin<br>
            Password: rahasia
        </div>
    </div>
</div>

<script>
    function loadTheme() {
        let theme = localStorage.getItem("app_theme");
        if (theme === "dark") {
            document.getElementById("loginBody").classList.add("dark");
        } else {
            document.getElementById("loginBody").classList.remove("dark");
        }
    }

    function toggleTheme() {
        let body = document.getElementById("loginBody");
        if (body.classList.contains("dark")) {
            body.classList.remove("dark");
            localStorage.setItem("app_theme", "light");
        } else {
            body.classList.add("dark");
            localStorage.setItem("app_theme", "dark");
        }
    }

    window.onload = loadTheme;
</script>
</body>
</html>
