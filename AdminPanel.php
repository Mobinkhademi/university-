<?php
include("includes/conn.php");
$sql = "SELECT * FROM students";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت کاربران</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- همون استایل دقیق قبلی تو -->
    <style>
        /* تمام استایل‌های قبلی‌ات رو عیناً کپی کردم — هیچ تغییری ندادم */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Vazirmatn', sans-serif; background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #302b63 100%); min-height: 100vh; color: #e0f7ff; overflow-x: hidden; position: relative; }
        body::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.15) 0%, transparent 60%), radial-gradient(circle at 80% 70%, rgba(0, 255, 255, 0.1) 0%, transparent 60%); z-index: -1; animation: pulse 8s infinite alternate; }
        @keyframes pulse { 0% { opacity: 0.6; } 100% { opacity: 1; } }
        .container { max-width: 1200px; margin: 40px auto; padding: 20px; }
        .panel-header { text-align: center; margin-bottom: 40px; animation: fadeInDown 0.8s ease-out; }
        .panel-header h1 { font-size: 2.2rem; color: #00ffff; text-shadow: 0 0 15px rgba(0, 255, 255, 0.5); letter-spacing: 1.5px; margin-bottom: 10px; }
        .panel-header p { color: #a0faff; font-size: 1.1rem; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        .table-container { background: rgba(15, 12, 41, 0.7); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6), 0 0 35px rgba(0, 212, 255, 0.2); border: 1px solid rgba(0, 212, 255, 0.3); animation: fadeInUp 0.9s ease-out; position: relative; }
        .table-container::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #00d4ff, #00ffff, #00d4ff); background-size: 200% 100%; animation: glowLine 3s linear infinite; }
        @keyframes glowLine { 0% { background-position: 0% 0; } 100% { background-position: 200% 0; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        table { width: 100%; border-collapse: collapse; font-size: 1rem; }
        thead { background: rgba(0, 212, 255, 0.1); }
        th { padding: 18px 15px; text-align: center; color: #00ffff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid rgba(0, 212, 255, 0.3); text-shadow: 0 0 8px rgba(0, 255, 255, 0.4); }
        td { padding: 16px 15px; text-align: center; color: #d0f8ff; border-bottom: 1px solid rgba(0, 212, 255, 0.15); transition: all 0.3s ease; }
        tr:hover td { background: rgba(0, 212, 255, 0.08); color: #ffffff; transform: scale(1.02); }
        .btn-back { display: block; width: fit-content; margin: 30px auto 0; padding: 14px 32px; background: linear-gradient(135deg, #00d4ff, #00aaff); color: #0f0c29; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; transition: all 0.4s ease; box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4); text-transform: uppercase; letter-spacing: 1px; }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0, 212, 255, 0.5); background: linear-gradient(135deg, #00ffff, #00ccff); }
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1; }
        .particle { position: absolute; background: #00ffff; border-radius: 50%; box-shadow: 0 0 15px #00ffff, 0 0 30px #00d4ff; animation: floatGlow 5s infinite ease-in-out; }
        @keyframes floatGlow { 0%, 100% { transform: translateY(0) translateX(0); opacity: 0.4; } 50% { transform: translateY(-25px) translateX(15px); opacity: 1; } }

        /* دکمه افزودن دانشجو — کاملاً هم استایل با بقیه */
        .add-student-btn {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #0f0c29;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 16px;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(0, 255, 136, 0.4);
            transition: all 0.4s ease;
            margin-bottom: 25px;
        }
        .add-student-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 255, 136, 0.6);
            background: linear-gradient(135deg, #00ffaa, #00ff77);
        }

        /* مودال — دقیقاً هم استایل صفحه */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(10px);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: rgba(15, 12, 41, 0.95);
            border: 1px solid rgba(0, 212, 255, 0.4);
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 212, 255, 0.3);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            color: #00ffff;
            font-size: 1.5rem;
        }
        .close { color: #ff6666; font-size: 2rem; background: none; border: none; cursor: pointer; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #00ffff; font-weight: 600; }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(0, 212, 255, 0.4);
            border-radius: 12px;
            color: #e0f7ff;
            font-size: 1rem;
        }
        .form-group input:focus {
            outline: none;
            border-color: #00ffff;
            box-shadow: 0 0 0 3px rgba(0,255,255,0.2);
        }
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #0f0c29;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .submit-btn:hover {
            background: linear-gradient(135deg, #00ffaa, #00ff77);
            transform: translateY(-3px);
        }

        /* سرچ باکس و بقیه استایل‌ها دقیقاً همون قبلی */
        .search-container { max-width: 500px; margin: 0 auto 30px; padding: 0 15px; }
        .search-box { position: relative; display: flex; align-items: center; background: rgba(26, 26, 46, 0.6); border: 1px solid rgba(0, 212, 255, 0.4); border-radius: 16px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .search-box:focus-within { border-color: #00ffff; box-shadow: 0 0 0 3px rgba(0,255,255,0.3), 0 8px 25px rgba(0,212,255,0.4); }
        #searchInput { flex: 1; padding: 16px 60px 16px 20px; background: transparent; border: none; outline: none; color: #e0f7ff; font-size: 1rem; }
        .search-btn { position: absolute; left: 8px; background: linear-gradient(135deg, #00d4ff, #00aaff); border: none; color: #0f0c29; width: 44px; height: 44px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.4s ease; box-shadow: 0 4px 12px rgba(0,212,255,0.4); }
        .search-btn:hover { background: linear-gradient(135deg, #00ffff, #00ccff); transform: translateY(-2px) scale(1.05); }
    </style>
</head>
<body>

<div class="particles" id="particles"></div>

<div class="container">
    <div class="panel-header">
        <h1>پنل مدیریت کاربران</h1>
        <p>مدیریت کامل دانشجویان و اطلاعات آنها</p>
    </div>

    <!-- دکمه افزودن دانشجو -->
    <div style="text-align: left; margin-bottom: 20px;">
        <button class="add-student-btn" onclick="document.getElementById('addModal').style.display='flex'">
            افزودن دانشجو
        </button>
    </div>

    <!-- مودال افزودن دانشجو -->
    <div id="addModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(8px); justify-content:center; align-items:center; z-index:999;">
        <div style="background:rgba(15,12,41,0.95); border:1px solid rgba(0,212,255,0.5); border-radius:20px; padding:30px; width:90%; max-width:500px; box-shadow:0 20px 50px rgba(0,212,255,0.3); position:relative;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; color:#00ffff; font-size:1.5rem; font-weight:600;">
                <span>افزودن دانشجوی جدید</span>
                <span onclick="document.getElementById('addModal').style.display='none'" style="cursor:pointer; font-size:2.2rem; color:#ff6666; user-select:none;">×</span>
            </div>

            <form action="add_student.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="نام" required style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <input type="text" name="family" placeholder="نام خانوادگی" required style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <input type="text" name="phone" placeholder="شماره موبایل (09123456789)" required pattern="09[0-9]{9}" style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <input type="text" name="student_id" placeholder="شماره دانشجویی" required style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <input type="text" name="username" placeholder="نام کاربری (برای ورود)" required style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <input type="password" name="password" placeholder="رمز عبور" required style="width:100%; padding:14px; margin:12px 0; background:rgba(26,26,46,0.7); border:1px solid rgba(0,212,255,0.4); border-radius:12px; color:#e0f7ff; font-size:1rem;"><br>

                <div style="margin:15px 0; text-align:center;">
                    <label style="color:#00ffff; cursor:pointer; background:rgba(0,212,255,0.15); padding:12px 20px; border-radius:12px; border:1px dashed rgba(0,212,255,0.5); display:inline-block;">
                        انتخاب عکس پروفایل
                        <input type="file" name="photo" accept="image/*" required style="display:none;">
                    </label>
                    <div id="photoName" style="margin-top:8px; color:#a0faff; font-size:0.9rem;"></div>
                </div>

                <button type="submit" style="width:100%; padding:16px; margin-top:20px; background:linear-gradient(135deg,#00ff88,#00cc66); color:#0f0c29; border:none; border-radius:12px; font-weight:700; font-size:1.1rem; cursor:pointer; box-shadow:0 6px 20px rgba(0,255,136,0.4);">
                    ثبت دانشجو
                </button>
            </form>
        </div>
    </div>

    <script>
        // نمایش اسم فایل انتخاب شده
        document.querySelector('input[type=file]').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'هیچ فایلی انتخاب نشده';
            document.getElementById('photoName').textContent = 'فایل انتخاب شده: ' + fileName;
        });
    </script>

    <!-- سرچ باکس -->
    <div class="search-container">
        <form action="search.php" method="GET" class="search-form">
            <div class="search-box">
                <input type="text" name="num" id="searchInput" placeholder="شماره دانشجویی را وارد کنید" required />
                <button type="submit" class="search-btn">جستجو</button>
            </div>
        </form>
    </div>

    <!-- جدول -->
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
            <tbody id="tableBody">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['family'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['student_id'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="btn-back">بازگشت به صفحه اصلی</a>
</div>

<script>
    // ذرات
    for(let i=0; i<30; i++){
        let p = document.createElement('div');
        p.className = 'particle';
        let s = Math.random()*4+1;
        p.style.width = p.style.height = s+'px';
        p.style.left = Math.random()*100+'%';
        p.style.top = Math.random()*100+'%';
        p.style.animationDelay = Math.random()*5+'s';
        document.getElementById('particles').appendChild(p);
    }

    // ارسال فرم افزودن
    document.getElementById('addForm').onsubmit = function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('add_student.php', {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(res => {
                if(res.success){
                    // اضافه کردن به جدول بدون رفرش
                    document.getElementById('tableBody').insertAdjacentHTML('afterbegin', `
                    <tr>
                        <td>${res.id}</td>
                        <td>${formData.get('name')}</td>
                        <td>${formData.get('family')}</td>
                        <td>${formData.get('phone')}</td>
                        <td>${formData.get('student_id')}</td>
                    </tr>`);
                    document.getElementById('addModal').style.display = 'none';
                    this.reset();
                    alert('دانشجو با موفقیت اضافه شد :)');
                } else {
                    alert('خطا: ' + res.message);
                }
            });
    };
</script>
</body>
</html>