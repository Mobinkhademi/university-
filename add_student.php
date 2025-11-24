<?php
include("includes/conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name       = trim($_POST['name']);
    $family     = trim($_POST['family']);
    $phone      = trim($_POST['phone']);
    $student_id = trim($_POST['student_id']);
    $username   = trim($_POST['username']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT); // رمز امن

    // آپلود عکس
    $photo = "default.jpg"; // عکس پیش‌فرض
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($ext), $allowed) && $_FILES['photo']['size'] < 2*1024*1024) {
            $photo = "uploads/" . time() . "_" . rand(1000,9999) . "." . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }
    }

    // چک تکراری بودن username یا student_id
    $check = $mysqli->prepare("SELECT id FROM students WHERE username = ? OR student_id = ?");
    $check->bind_param("ss", $username, $student_id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        header("Location: admin-panel.php?add=error&msg=duplicate");
        exit;
    }

    // درج در دیتابیس
    $stmt = $mysqli->prepare("INSERT INTO students (name, family, phone, student_id, username, password, pic) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $family, $phone, $student_id, $username, $password, $photo);

    if ($stmt->execute()) {
        // ایجاد پوشه uploads اگر وجود نداشته باشه
        if (!is_dir('uploads')) mkdir('uploads', 0755, true);

        header("Location: admin-panel.php?add=success");
    } else {
        header("Location: admin-panel.php?add=error");
    }
    exit;
}
?>