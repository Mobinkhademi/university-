<?php
include("includes/conn.php");
$sql = "SELECT * FROM students ";
$result = mysqli_query($mysqli, $sql);


?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت کاربران</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #302b63 100%);
            min-height: 100vh;
            color: #e0f7ff;
            overflow-x: hidden;
            position: relative;
        }

        /* افکت نور پس‌زمینه */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 80% 70%, rgba(0, 255, 255, 0.1) 0%, transparent 60%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .panel-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease-out;
        }

        .panel-header h1 {
            font-size: 2.2rem;
            color: #00ffff;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .panel-header p {
            color: #a0faff;
            font-size: 1.1rem;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-container {
            background: rgba(15, 12, 41, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6),
            0 0 35px rgba(0, 212, 255, 0.2);
            border: 1px solid rgba(0, 212, 255, 0.3);
            animation: fadeInUp 0.9s ease-out;
            position: relative;
        }

        .table-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #00d4ff, #00ffff, #00d4ff);
            background-size: 200% 100%;
            animation: glowLine 3s linear infinite;
        }

        @keyframes glowLine {
            0% { background-position: 0% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }

        thead {
            background: rgba(0, 212, 255, 0.1);
        }

        th {
            padding: 18px 15px;
            text-align: center;
            color: #00ffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 212, 255, 0.3);
            text-shadow: 0 0 8px rgba(0, 255, 255, 0.4);
        }

        td {
            padding: 16px 15px;
            text-align: center;
            color: #d0f8ff;
            border-bottom: 1px solid rgba(0, 212, 255, 0.15);
            transition: all 0.3s ease;
        }

        tr:hover td {
            background: rgba(0, 212, 255, 0.08);
            color: #ffffff;
            transform: scale(1.02);
        }

        .action-btn {
            padding: 8px 14px;
            margin: 0 4px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #00cc00, #00aa00);
            color: white;
            box-shadow: 0 3px 10px rgba(0, 200, 0, 0.3);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #00ff00, #00cc00);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 255, 0, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ff3333, #cc0000);
            color: white;
            box-shadow: 0 3px 10px rgba(255, 51, 51, 0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #ff5555, #ff0000);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 0, 0, 0.4);
        }

        .btn-back {
            display: block;
            width: fit-content;
            margin: 30px auto 0;
            padding: 14px 32px;
            background: linear-gradient(135deg, #00d4ff, #00aaff);
            color: #0f0c29;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 212, 255, 0.5);
            background: linear-gradient(135deg, #00ffff, #00ccff);
        }

        /* ذرات نوری */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: #00ffff;
            border-radius: 50%;
            box-shadow: 0 0 15px #00ffff, 0 0 30px #00d4ff;
            animation: floatGlow 5s infinite ease-in-out;
        }

        @keyframes floatGlow {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.4; }
            50% { transform: translateY(-25px) translateX(15px); opacity: 1; }
        }

        /* ریسپانسیو */
        @media (max-width: 768px) {
            .container { padding: 15px; }
            table { font-size: 0.9rem; }
            th, td { padding: 12px 8px; }
            .action-btn { padding: 6px 10px; font-size: 0.8rem; }
        }

        /* ===== SEARCH BOX WITH SUBMIT BUTTON ===== */
        .search-container {
            max-width: 500px;
            margin: 0 auto 30px;
            padding: 0 15px;
        }

        .search-form {
            width: 100%;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(0, 212, 255, 0.4);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .search-box:focus-within {
            border-color: #00ffff;
            box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.3),
            0 8px 25px rgba(0, 212, 255, 0.4);
            background: rgba(26, 26, 46, 0.9);
        }

        .search-icon {
            position: absolute;
            right: 16px;
            color: rgba(0, 255, 255, 0.7);
            font-size: 1.3rem;
            pointer-events: none;
            z-index: 2;
            transition: all 0.3s ease;
        }

        #searchInput {
            flex: 1;
            padding: 16px 60px 16px 20px;
            background: transparent;
            border: none;
            outline: none;
            color: #e0f7ff;
            font-size: 1rem;
            font-family: 'Vazirmatn', sans-serif;
        }

        #searchInput::placeholder {
            color: rgba(0, 255, 255, 0.5);
        }

        #searchInput:focus::placeholder {
            color: rgba(0, 255, 255, 0.3);
        }

        /* دکمه جستجو */
        .search-btn {
            position: absolute;
            left: 8px;
            background: linear-gradient(135deg, #00d4ff, #00aaff);
            border: none;
            color: #0f0c29;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.4);
            z-index: 2;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #00ffff, #00ccff);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 212, 255, 0.6);
        }

        .search-btn:active {
            transform: translateY(0) scale(0.98);
        }

        /* وقتی فوکوس داره */
        .search-box:focus-within .search-icon {
            color: #00ffff;
            transform: scale(0.9);
        }

        .search-box:focus-within .search-btn {
            background: linear-gradient(135deg, #00ffff, #00ccff);
        }

        /* ریسپانسیو */
        @media (max-width: 768px) {
            .search-container { max-width: 100%; }
            #searchInput { padding: 14px 55px 14px 18px; font-size: 0.95rem; }
            .search-btn { width: 40px; height: 40px; }
        }
        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .edit-btn, .delete-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .edit-btn {
            background: rgba(0, 212, 255, 0.15);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.3);
        }

        .edit-btn:hover {
            background: #00d4ff;
            color: #0f0c29;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 212, 255, 0.5);
        }

        .delete-btn {
            background: rgba(255, 100, 100, 0.15);
            color: #ff6666;
            border: 1px solid rgba(255, 100, 100, 0.3);
        }

        .delete-btn:hover {
            background: #ff6666;
            color: #0f0c29;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 100, 100, 0.5);
        }
    </style>
</head>
<body>

<div class="particles" id="particles"></div>

<div class="container">
    <div class="panel-header">
        <h1>پنل مدیریت کاربران</h1>
        <p>مدیریت کامل دانشجویان و اطلاعات آنها</p>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="text-align:center; padding:15px; background:rgba(0,212,255,0.1); border:1px solid #00d4ff; border-radius:12px; margin:20px 0; color:#00ffff;">
            <?php
            if ($_GET['msg'] === 'updated') echo "کاربر با موفقیت ویرایش شد.";
            if ($_GET['msg'] === 'deleted') echo "کاربر با موفقیت حذف شد.";
            ?>
        </div>
    <?php endif; ?>

    <!-- بالای جدول در admin-panel.html قرار بده -->
    <div class="search-container">
        <form action="search.php" method="GET" class="search-form" id="searchForm">
            <div class="search-box">
                <i class="search-icon" data-feather="search"></i>
                <input type="text" name="num" id="searchInput" placeholder="شماره داشنجویی ا وارد کنید" required />
                <button type="submit" class="search-btn">
                    <i data-feather="arrow-left"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>آیدی</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>شماره</th>

                <th>شماره دانشجویی</th>

            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) {?>
            <tr>
                <td><?= $row['id'];?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['family']; ?></td>
                <th><?= $row['phone']; ?></th>
                <td><?= $row['student_id']; ?></td>


            </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

    <a href="index.php" class="btn-back">بازگشت به صفحه اصلی</a>
</div>

<script>
    // ایجاد ذرات
    const particlesContainer = document.getElementById('particles');
    const particleCount = 30;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        const size = Math.random() * 4 + 1;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.animationDelay = `${Math.random() * 5}s`;
        particle.style.animationDuration = `${Math.random() * 3 + 4}s`;
        particlesContainer.appendChild(particle);
    }

    // توابع ویرایش و حذف (نمونه)
    function editUser(id) {
        alert(`ویرایش کاربر با آیدی: ${id}`);
        // اینجا می‌تونی فرم ویرایش باز کنی
    }

    function deleteUser(id) {
        if (confirm(`آیا از حذف کاربر با آیدی ${id} مطمئن هستید؟`)) {
            alert(`کاربر ${id} حذف شد.`);
            // اینجا می‌تونی ردیف رو از جدول حذف کنی
        }
    }

        // فعال‌سازی آیکون‌ها
        feather.replace();

        // سرچ باکس
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const tableRows = document.querySelectorAll('#userTable tbody tr');

        searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const hasValue = query.length > 0;

        // نمایش/مخفی دکمه پاک کردن
        clearBtn.style.display = hasValue ? 'block' : 'none';

                feather.replace();

                // انیمیشن دکمه وقتی صفحه لود می‌شه
                document.addEventListener('DOMContentLoaded', () => {
                const searchBtn = document.querySelector('.search-btn');
                searchBtn.style.animation = 'pulseBtn 2s infinite';
            });

                // پالس دکمه (اختیاری)
                const style = document.createElement('style');
                style.textContent = `
                @keyframes pulseBtn {
                0%, 100% { box-shadow: 0 4px 12px rgba(0, 212, 255, 0.4); }
                50% { box-shadow: 0 8px 25px rgba(0, 212, 255, 0.7); }
            }
                `;
                document.head.appendChild(style);

</script>
</body>
</html>
