<?php
session_start();
include("includes/conn.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = "لطفاً نام کاربری و رمز عبور را وارد کنید.";
    } else {

        // اول چک کن آیا ادمین است (بهتره ادمین هم در دیتابیس باشه، ولی فعلاً اینجوری)
        if ($username === "admin" && $password === "admin") { // بعداً این رو هم هش کن!
            $_SESSION['username'] = "admin";
            $_SESSION['role'] = "admin";
            header("Location: AdminPanel.php");
            exit;
        }

        // جستجوی کاربر عادی در دیتابیس
        $stmt = $mysqli->prepare("SELECT * FROM students WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // این خط خیلی مهمه!

        if ($user) {
            // حتماً رمز عبور در دیتابیس با password_hash ذخیره شده باشه!
            if ($password== $user['password']) {
                // لاگین موفق
                $_SESSION['username']    = $user['username'];
                $_SESSION['name']        = $user['name'];
                $_SESSION['family']      = $user['family'];
                $_SESSION['student_id']  = $user['student_id'];
                $_SESSION['roll']        = $user['roll'] ?? '';
                $_SESSION['phone']       = $user['phone'] ?? '';
                $_SESSION['logged_in']   = true;

                header("Location: index.php");
                exit;
            } else {
                $message = "رمز عبور اشتباه است.";
            }
        } else {
            $message = "نام کاربری یافت نشد.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | دانشگاه فناوری نئون</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Vazirmatn',sans-serif;
            background:linear-gradient(135deg,#0f0c29 0%,#1a1a2e 50%,#302b63 100%);
            min-height:100vh; display:flex; justify-content:center; align-items:center;
            padding:20px; position:relative; color:#e0f7ff;
        }
        body::before{
            content:''; position:absolute; inset:0; z-index:-1;
            background:radial-gradient(circle at 30% 20%,rgba(0,212,255,0.15),transparent 60%),
            radial-gradient(circle at 70% 80%,rgba(0,255,255,0.1),transparent 60%);
            animation:pulse 8s infinite alternate;
        }
        @keyframes pulse{0%{opacity:0.6}100%{opacity:1}}

        .login-box{
            background:rgba(15,12,41,0.9); backdrop-filter:blur(20px);
            padding:50px 40px; border-radius:25px; width:100%; max-width:420px;
            box-shadow:0 20px 60px rgba(0,0,0,0.6), 0 0 50px rgba(0,212,255,0.3);
            border:1px solid rgba(0,212,255,0.4); text-align:center;
        }
        h2{
            color:#00ffff; font-size:2.4rem; margin-bottom:30px;
            text-shadow:0 0 20px rgba(0,255,255,0.6);
        }
        input{
            width:100%; padding:16px 20px; margin:12px 0; border-radius:12px;
            border:1px solid rgba(0,212,255,0.5); background:rgba(15,12,41,0.7);
            color:#e0f7ff; font-size:1.1rem; transition:.3s;
        }
        input:focus{
            outline:none; border-color:#00ffff; box-shadow:0 0 15px rgba(0,255,255,0.4);
        }
        button{
            width:100%; padding:16px; background:linear-gradient(135deg,#00d4ff,#0099ff);
            color:#0f0c29; border:none; border-radius:12px; font-size:1.2rem; font-weight:700;
            cursor:pointer; margin-top:20px; transition:.4s;
            box-shadow:0 6px 20px rgba(0,212,255,0.4);
        }
        button:hover{
            background:linear-gradient(135deg,#00ffff,#00ccff);
            transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,212,255,0.6);
        }
        .error-message{
            background:rgba(255,50,50,0.15); border:1px solid rgba(255,100,100,0.4);
            color:#ff6666; padding:16px; border-radius:14px; margin:20px 0;
            display:flex; align-items:center; justify-content:center; gap:12px;
            animation:shake 0.6s, fadeIn 0.5s;
        }
        @keyframes shake{
            0%,100%{transform:translateX(0)}
            10%,30%,50%,70%,90%{transform:translateX(-8px)}
            20%,40%,60%,80%{transform:translateX(8px)}
        }
        @keyframes fadeIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
    </style>
</head>
<body>

<div class="login-box">
    <h2>ورود به حساب کاربری</h2>

    <?php if ($message): ?>
        <div class="error-message">
            <svg width="24" height="24" fill="#ff6666" viewBox="0 0 24 24">
                <path d="M12 8l-1.4 1.4L15.2 14H8.8l4.6-4.6L12 8zm0-6c5.5 0 10 4.5 10 10s-4.5 10-10 10S2 17.5 2 12 6.5 2 12 2m0-2C6.48 0 2 4.48 2 10s4.48 10 10 10 10-4.48 10-10S17.52 0 12 0z"/>
            </svg>
            <span><?= htmlspecialchars($message) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="نام کاربری" required autofocus>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <button type="submit">ورود</button>
    </form>

    <p style="margin-top:25px; color:#a0faff;">
        حساب ندارید؟ <a href="register.php" style="color:#00ffff; text-decoration:none;">ثبت‌نام کنید</a>
    </p>
</div>

</body>
</html>