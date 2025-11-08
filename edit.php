<?php
include("includes/conn.php");
$id = $_GET['id'] ?? 0;
$user = null;
$sql = "SELECT * FROM students WHERE id = ?";

if ($id > 0) {
    $resualt = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($resualt);
}

if (!$user) {
    die("<h3 style='color:#ff6666; text-align:center; font-family:Vazirmatn;'>کاربر یافت نشد!</h3>");
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش کاربر</title>
    <link href="="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Vazirmatn', sans-serif; background: #0f0c29; color: #e0f7ff; padding: 40px; }
        .container { max-width: 500px; margin: 0 auto; background: rgba(15,12,41,0.7); padding: 40px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.6); border: 1px solid rgba(0,212,255,0.3); }
        h2 { color: #00ffff; text-align: center; margin-bottom: 30px; text-shadow: 0 0 15px rgba(0,255,255,0.5); }
        input { width: 100%; padding: 14px; margin: 12px 0; background: rgba(26,26,46,0.6); border: 1px solid rgba(0,212,255,0.4); border-radius: 12px; color: #e0f7ff; font-size: 1rem; }
        input:focus { outline: none; border-color: #00ffff; box-shadow: 0 0 0 3px rgba(0,255,255,0.3); }
        button { width: 100%; padding: 16px; background: #00d4ff; color: #0f0c29; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; margin-top: 20px; font-size: 1.1rem; }
        button:hover { background: #00ffff; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,212,255,0.5); }
        .back { background: #666; margin-top: 10px; }
        .back:hover { background: #888; }
    </style>
</head>
<body>
<div class="container">
    <h2>ویرایش کاربر</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required placeholder="نام">
        <input type="text" name="family" value="<?= htmlspecialchars($user['family']) ?>" required placeholder="نام خانوادگی">
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required placeholder="شماره تماس">
        <input type="text" name="student_id" value="<?= htmlspecialchars($user['student_id']) ?>" required placeholder="شماره دانشجویی">
        <button type="submit">ذخیره تغییرات</button>
    </form>
    <button onclick="history.back()" class="back">بازگشت</button>
</div>
</body>
</html>