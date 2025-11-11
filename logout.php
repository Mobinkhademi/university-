<?php
session_start();

// پاک کردن همه سشن‌ها
$_SESSION = array();

// حذف کوکی سشن (اگر وجود داشته باشه)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// نابود کردن سشن
session_destroy();

// برگشت به صفحه اصلی
header("Location: index.php");
exit;
?>