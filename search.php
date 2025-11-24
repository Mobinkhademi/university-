<?php
session_start();
include("includes/conn.php");

// دریافت شماره دانشجویی
$num = trim($_GET['num'] ?? '');

// پیام‌های موقت (فلش مسیج)
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

// ──────── حذف امن ────────
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    if ($delete_id > 0) {
        $stmt = $mysqli->prepare("DELETE FROM students WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['message'] = "<div class='success'>کاربر با موفقیت حذف شد.</div>";
        } else {
            $_SESSION['message'] = "<div class='error'>کاربر یافت نشد یا قبلاً حذف شده است.</div>";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "<div class='error'>شناسه نامعتبر است.</div>";
    }

    header("Location: search.php?num=" . urlencode($num));
    exit;
}

// ──────── ویرایش امن ────────
if ($_POST && isset($_POST['edit_id'])) {
    $edit_id     = (int)$_POST['edit_id'];
    $name        = trim($_POST['name']);
    $family      = trim($_POST['family']);
    $phone       = trim($_POST['phone']);
    $student_id  = trim($_POST['student_id']);

    if ($edit_id > 0 && !empty($name) && !empty($family)) {
        $stmt = $mysqli->prepare("UPDATE students SET name=?, family=?, phone=?, student_id=? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $family, $phone, $student_id, $edit_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "<div class='success'>کاربر با موفقیت ویرایش شد.</div>";
        } else {
            $_SESSION['message'] = "<div class='error'>خطا در ویرایش کاربر.</div>";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "<div class='error'>اطلاعات ناقص یا نامعتبر است.</div>";
    }

    header("Location: search.php?num=" . urlencode($num));
    exit;
}

// ──────── جستجوی امن ────────
$result = null;
if (!empty($num)) {
    $stmt = $mysqli->prepare("SELECT * FROM students WHERE student_id LIKE ?");
    $like = "%$num%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

    <!DOCTYPE html>
    <html lang="fa" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>نتایج جستجو برای: <?= htmlspecialchars($num) ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Vazirmatn', sans-serif; background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #302b63 100%); color: #e0f7ff; min-height: 100vh; padding: 40px 20px; position: relative; }
            body::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 30%, rgba(0,212,255,0.15), transparent 60%), radial-gradient(circle at 80% 70%, rgba(0,255,255,0.1), transparent 60%); z-index: -1; animation: pulse 8s infinite alternate; }
            @keyframes pulse { 0% { opacity: 0.6; } 100% { opacity: 1; } }
            .container { max-width: 1000px; margin: 0 auto; background: rgba(15,12,41,0.7); backdrop-filter: blur(16px); border-radius: 20px; padding: 40px; box-shadow: 0 15px 40px rgba(0,0,0,0.6), 0 0 35px rgba(0,212,255,0.2); border: 1px solid rgba(0,212,255,0.3); position: relative; overflow: hidden; }
            .container::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #00d4ff, #00ffff, #00d4ff); background-size: 200% 100%; animation: glowLine 3s linear infinite; }
            @keyframes glowLine { 0% { background-position: 0% 0; } 100% { background-position: 200% 0; } }
            h2 { color: #00ffff; text-align: center; margin-bottom: 30px; font-size: 2rem; text-shadow: 0 0 15px rgba(0,255,255,0.5); letter-spacing: 1px; }
            .success { background: rgba(0,212,255,0.1); border: 1px solid #00d4ff; color: #00ffff; padding: 12px; border-radius: 12px; text-align: center; margin: 15px 0; }
            .error { background: rgba(255,50,50,0.1); border: 1px dashed #ff6666; color: #ff9999; padding: 15px; border-radius: 12px; text-align: center; margin: 15px 0; }
            table { width: 100%; border-collapse: collapse; background: rgba(26,26,46,0.6); border-radius: 16px; overflow: hidden; margin: 20px 0; box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
            th, td { padding: 16px; text-align: center; border-bottom: 1px solid rgba(0,212,255,0.15); }
            th { background: rgba(0,212,255,0.1); color: #00ffff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.95rem; }
            tr:hover td { background: rgba(0,212,255,0.08); }
            .actions { display: flex; gap: 10px; justify-content: center; }
            .edit-btn, .delete-btn { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.2);  }
            .edit-btn { background: rgba(0,212,255,0.15); color: #00d4ff; border: 1px solid rgba(0,212,255,0.3);font-size: 13px}
            .edit-btn:hover { background: #00d4ff; color: #0f0c29; transform: translateY(-2px) scale(1.1); box-shadow: 0 8px 20px rgba(0,212,255,0.5); }
            .delete-btn { background: rgba(255,100,100,0.15); color: #ff6666; border: 1px solid rgba(255,100,100,0.3); }
            .delete-btn:hover { background: #ff6666; color: #0f0c29; transform: translateY(-2px) scale(1.1); box-shadow: 0 8px 20px rgba(255,100,100,0.5); }
            .edit-form { background: rgba(26,26,46,0.8); padding: 15px; border-radius: 12px; margin: 10px 0; border: 1px solid rgba(0,212,255,0.4); }
            .edit-form input { width: 100%; padding: 10px; margin: 8px 0; background: rgba(15,12,41,0.6); border: 1px solid rgba(0,212,255,0.3); border-radius: 8px; color: #e0f7ff; }
            .edit-form button { background: #00d4ff; color: #0f0c29; border: none; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-weight: 700; margin-left: 5px; }
            .edit-form button:hover { background: #00ffff; }
            .back-btn { display: block; width: fit-content; margin: 30px auto 0; padding: 14px 32px; background: #00d4ff; color: #0f0c29; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; text-transform: uppercase; box-shadow: 0 6px 20px rgba(0,212,255,0.4); }
            .back-btn:hover { background: #00ffff; transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,212,255,0.5); }
            @media (max-width: 768px) { .container { padding: 25px; } th, td { padding: 12px 8px; font-size: 0.9rem; } .edit-form input { padding: 8px; } }
            *{margin:0;padding:0;box-sizing:border-box}
            body{font-family:'Vazirmatn',sans-serif;background:linear-gradient(135deg,#0f0c29 0%,#1a1a2e 50%,#302b63 100%);color:#e0f7ff;min-height:100vh;padding:40px 20px;position:relative}

            .success{background:rgba(0,212,255,0.1);border:1px solid #00d4ff;color:#00ffff;padding:12px;border-radius:12px;text-align:center;margin:15px 0}
            .error{background:rgba(255,50,50,0.1);border:1px dashed #ff6666;color:#ff9999;padding:15px;border-radius:12px;text-align:center;margin:15px 0}
        </style>
    </head>
    <body>
    <div class="container">
        <h2>نتایج جستجو برای: "<?= htmlspecialchars($num) ?>"</h2>

        <?= $message ?>

        <?php if (empty($num)): ?>
            <p class="error">لطفاً شماره دانشجویی را وارد کنید.</p>

        <?php elseif ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>آیدی</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>شماره</th>
                    <th>شماره دانشجویی</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['family']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['student_id']) ?></td>
                        <td class="actions">
                            <!-- دکمه ویرایش (فقط باز کردن فرم) -->
                            <a href="search.php?num=<?= urlencode($num) ?>&edit_id=<?= $user['id'] ?>#editform"
                               class="edit-btn" title="ویرایش">ویرایش</a>

                            <!-- حذف با تأیید -->
                            <a href="search.php?num=<?= urlencode($num) ?>&delete_id=<?= $user['id'] ?>"
                               class="delete-btn" title="حذف"
                               onclick="return confirm('آیا از حذف این کاربر مطمئن هستید؟');">حذف</a>
                        </td>
                    </tr>

                    <!-- فرم ویرایش (فقط وقتی edit_id با این ردیف برابر باشد) -->
                    <?php if (isset($_GET['edit_id']) && (int)$_GET['edit_id'] === $user['id']): ?>
                        <tr id="editform">
                            <td colspan="6">
                                <form action="" method="POST" class="edit-form">
                                    <input type="hidden" name="edit_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="num" value="<?= htmlspecialchars($num) ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required placeholder="نام">
                                    <input type="text" name="family" value="<?= htmlspecialchars($user['family']) ?>" required placeholder="نام خانوادگی">
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required placeholder="شماره">
                                    <input type="text" name="student_id" value="<?= htmlspecialchars($user['student_id']) ?>" required placeholder="شماره دانشجویی">
                                    <button type="submit">ذخیره تغییرات</button>
                                    <a href="search.php?num=<?= urlencode($num) ?>" style="color:#ff6666;margin-right:10px;">لغو</a>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="error">هیچ نتیجه‌ای یافت نشد.</p>
        <?php endif; ?>

        <button onclick="history.back()" class="back-btn">بازگشت به پنل</button>
    </div>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>feather.replace();</script>
    </body>
    </html>

<?php
$mysqli->close();
?>