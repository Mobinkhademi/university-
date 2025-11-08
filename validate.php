<?php
session_start();
include("includes/conn.php");
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
$result = mysqli_query($mysqli, $sql);

if ($username == "admin" && $password == "admin") {
    header("Location: AdminPanel.php");
    exit();
} elseif (mysqli_num_rows($result) > 0) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
} else {
    // فقط اینجا خروجی میدیم
    echo '<div class="error-message">
            <i class="error-icon" data-feather="alert-triangle"></i>
            <span>نام کاربری یا رمز عبور صحیح نمی‌باشد.</span>
          </div>';
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #302b63 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(0, 212, 255, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 70% 80%, rgba(0, 255, 255, 0.1) 0%, transparent 60%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }
        /* استایل شما کاملاً درسته */
        .error-message {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: rgba(255, 50, 50, 0.15);
            border: 1px solid rgba(255, 100, 100, 0.4);
            color: #ff6666;
            padding: 16px 20px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
            max-width: 400px;
            margin: 20px auto;
            box-shadow: 0 6px 20px rgba(255, 50, 50, 0.2),
            0 0 20px rgba(255, 100, 100, 0.15);
            backdrop-filter: blur(8px);
            animation: shake 0.6s ease-out, fadeIn 0.5s ease-out;
            text-shadow: 0 0 8px rgba(255, 100, 100, 0.3);
        }
        .error-icon { width: 22px; height: 22px; color: #ff6666; filter: drop-shadow(0 0 6px rgba(255, 100, 100, 0.5)); }
        .error-message:hover { border-color: #ff6666; box-shadow: 0 8px 25px rgba(255, 50, 50, 0.3), 0 0 30px rgba(255, 100, 100, 0.25); transform: translateY(-2px); }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); } 20%, 40%, 60%, 80% { transform: translateX(6px); } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 480px) { .error-message { font-size: 0.95rem; padding: 14px 16px; gap: 10px; } .error-icon { width: 20px; height: 20px; } }
    </style>
</head>
<body>


<script src="https://unpkg.com/feather-icons"></script>
<script>feather.replace();</script>
</body>
</html>