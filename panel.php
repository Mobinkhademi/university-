<?php
session_start();
include("includes/conn.php");

// اگر لاگین نکرده باشه، ببرش به صفحه ورود
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$message = '';

// دریافت اطلاعات کاربر از دیتابیس (فرض: جدول users داری)
$stmt = $mysqli->prepare("SELECT * FROM students WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// ویرایش اطلاعات
if ($_POST && isset($_POST['update_profile'])) {
    $name       = trim($_POST['name']);
    $family     = trim($_POST['family']);
    $student_id = trim($_POST['student_id']);
    $phone      = trim($_POST['phone']);


    if (!empty($name) && !empty($family) && !empty($email)) {
        $update = $mysqli->prepare("UPDATE users SET name=?, family=?, student_id=?, phone=? WHERE username=?");
        $update->bind_param("ssssss", $name, $family, $student_id, $phone,  $username);

        if ($update->execute()) {
            $message = "<div class='success'>مشخصات شما با موفقیت به‌روزرسانی شد.</div>";
            // بروزرسانی مجدد اطلاعات برای نمایش
            $user['name'] = $name;
            $user['family'] = $family;
            $user['student_id'] = $student_id;
            $user['phone'] = $phone;

        } else {
            $message = "<div class='error'>خطا در به‌روزرسانی اطلاعات.</div>";
        }
        $update->close();
    } else {
        $message = "<div class='error'>نام، نام خانوادگی و ایمیل الزامی است.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل کاربری | دانشگاه فناوری نئون</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Vazirmatn',sans-serif;
            background:linear-gradient(135deg,#0f0c29 0%,#1a1a2e 50%,#302b63 100%);
            color:#e0f7ff; min-height:100vh; padding:40px 20px;
            position:relative;
        }
        body::before{
            content:''; position:absolute; inset:0; z-index:-1;
            background:radial-gradient(circle at 20% 30%,rgba(0,212,255,0.15),transparent 60%),
            radial-gradient(circle at 80% 70%,rgba(0,255,255,0.1),transparent 60%);
            animation:pulse 8s infinite alternate;
        }
        @keyframes pulse{0%{opacity:0.6}100%{opacity:1}}

        .container{
            max-width:900px; margin:0 auto; background:rgba(15,12,41,0.85);
            backdrop-filter:blur(20px); border-radius:25px; padding:40px;
            box-shadow:0 20px 60px rgba(0,0,0,0.6), 0 0 50px rgba(0,212,255,0.3);
            border:1px solid rgba(0,212,255,0.4); position:relative; overflow:hidden;
        }
        .container::before{
            content:''; position:absolute; top:0; left:0; right:0; height:5px;
            background:linear-gradient(90deg,#00d4ff,#00ffff,#00d4ff); background-size:200%;
            animation:glowLine 3s linear infinite;
        }
        @keyframes glowLine{0%{background-position:0}100%{background-position:200%}}

        h1{
            text-align:center; color:#00ffff; font-size:2.8rem; margin-bottom:20px;
            text-shadow:0 0 20px rgba(0,255,255,0.6);
        }
        .welcome{
            text-align:center; background:rgba(0,212,255,0.1); padding:20px; border-radius:15px;
            border:1px solid rgba(0,212,255,0.4); margin-bottom:40px; font-size:1.4rem;
        }
        .profile-card{
            background:rgba(26,26,46,0.7); padding:35px; border-radius:20px;
            border:1px solid rgba(0,212,255,0.4); margin-bottom:30px;
        }
        .form-group{
            margin-bottom:20px;
        }
        label{
            display:block; color:#00ffff; margin-bottom:8px; font-weight:600;
        }
        input[type="text"], input[type="email"]{
            width:100%; padding:14px 18px; border-radius:12px; border:1px solid rgba(0,212,255,0.5);
            background:rgba(15,12,41,0.7); color:#e0f7ff; font-size:1.1rem;
            transition:.3s;
        }
        input:focus{
            outline:none; border-color:#00ffff; box-shadow:0 0 15px rgba(0,255,255,0.3);
        }
        button{
            background:linear-gradient(135deg,#00d4ff,#0099ff); color:#0f0c29;
            padding:14px 40px; border:none; border-radius:12px; font-weight:700; font-size:1.1rem;
            cursor:pointer; transition:.4s; box-shadow:0 6px 20px rgba(0,212,255,0.4);
        }
        button:hover{
            background:linear-gradient(135deg,#00ffff,#00ccff);
            transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,212,255,0.6);
        }
        .success{
            background:rgba(0,212,255,0.1); border:1px solid #00d4ff; color:#00ffff;
            padding:15px; border-radius:12px; text-align:center; margin:20px 0;
        }
        .error{
            background:rgba(255,50,50,0.1); border:1px dashed #ff6666; color:#ff9999;
            padding:15px; border-radius:12px; text-align:center; margin:20px 0;
        }
        .logout{
            display:block; text-align:center; margin-top:30px;
        }
        .logout a{
            color:#ff6666; text-decoration:none; font-weight:600; padding:10px 20px;
            border:2px solid #ff6666; border-radius:10px; transition:.3s;
        }
        .logout a:hover{
            background:#ff6666; color:#0f0c29;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>پنل کاربری</h1>
    <div class="welcome">
        خوش آمدید، <strong><?= htmlspecialchars($user['name'] . ' ' . $user['family']) ?></strong> عزیز
    </div>

    <?= $message ?>

    <div class="profile-card">
        <h2 style="color:#00ffff; margin-bottom:25px; text-align:center;">ویرایش مشخصات</h2>
        <form method="POST">
            <div class="form-group">
                <label>نام</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>نام خانوادگی</label>
                <input type="text" name="family" value="<?= htmlspecialchars($user['family']) ?>" required>
            </div>
            <div class="form-group">
                <label>شماره دانشجویی</label>
                <input type="text" name="student_id" value="<?= htmlspecialchars($user['student_id'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>تلفن</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <div style="text-align:center;">
                <button type="submit" name="update_profile">ذخیره تغییرات</button>
            </div>
        </form>
    </div>

    <div class="logout">
        <a href="logout.php">خروج از حساب کاربری</a>
    </div>

    <div style="text-align:center; margin-top:40px;">
        <a href="index.php" style="color:#00d4ff; text-decoration:none;">← بازگشت به صفحه اصلی</a>
    </div>
</div>

</body>
</html>