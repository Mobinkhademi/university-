<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : '';
$roll = $is_logged_in ? $_SESSION['roll'] : '';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دانشگاه فناوری نئون</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Vazirmatn',sans-serif;
            background:linear-gradient(135deg,#0f0c29 0%,#1a1a2e 50%,#302b63 100%);
            min-height:100vh; color:#e0f7ff; overflow-x:hidden; position:relative;
        }
        body::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(circle at 30% 20%,rgba(0,212,255,0.15),transparent 60%),
            radial-gradient(circle at 70% 80%,rgba(0,255,255,0.1),transparent 60%);
            z-index:-1; animation:pulse 8s infinite alternate;
        }
        @keyframes pulse { 0%{opacity:0.6} 100%{opacity:1} }

        header {
            background:rgba(15,12,41,0.8); backdrop-filter:blur(16px);
            padding:20px 40px; position:fixed; top:0; left:0; right:0; z-index:1000;
            box-shadow:0 4px 20px rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,212,255,0.3);
        }
        .header-container { display:flex; justify-content:space-between; align-items:center; max-width:1400px; margin:0 auto; }
        .logo { display:flex; align-items:center; gap:15px; }
        .logo img { width:60px; height:60px; border-radius:50%; border:2px solid #00ffff; box-shadow:0 0 20px rgba(0,255,255,0.5); }
        .logo h1 { font-size:1.8rem; color:#00ffff; text-shadow:0 0 15px rgba(0,255,255,0.5); }

        nav ul { display:flex; list-style:none; gap:30px; }
        nav ul li a { color:#a0faff; text-decoration:none; font-weight:600; position:relative; transition:.3s; }
        nav ul li a:hover { color:#00ffff; text-shadow:0 0 10px rgba(0,255,255,0.5); }
        nav ul li a::after { content:''; position:absolute; bottom:-5px; left:0; width:0; height:2px; background:#00ffff; transition:.3s; }
        nav ul li a:hover::after { width:100%; }

        .user-info {
            display:flex; align-items:center; gap:15px; background:rgba(0,212,255,0.1);
            padding:10px 20px; border-radius:12px; border:1px solid rgba(0,212,255,0.3); color:#00ffff; font-weight:600;
            a{
                color: #00ffff;
                text-decoration: none;
            }
        }
        .user-icon {
            width:40px; height:40px; background:#00d4ff; color:#0f0c29; border-radius:50%;
            display:flex; align-items:center; justify-content:center; font-weight:700;
            box-shadow:0 0 15px rgba(0,212,255,0.5);
        }
        .btn-logout {
            background:rgba(255,100,100,0.15); border:2px solid #ff6666; color:#ff6666;
            padding:8px 18px; border-radius:10px; text-decoration:none; font-weight:600; transition:.3s;
        }
        .btn-logout:hover { background:#ff6666; color:#0f0c29; transform:translateY(-2px); }

        .btn-register {
            background:linear-gradient(135deg,#00d4ff,#00aaff); color:#0f0c29; padding:12px 28px;
            border-radius:12px; text-decoration:none; font-weight:600; box-shadow:0 4px 15px rgba(0,212,255,0.4); transition:.4s;
        }
        .btn-register:hover { background:linear-gradient(135deg,#00ffff,#00ccff); transform:translateY(-3px); }

        /* هیرو */
        .hero { height:100vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:0 20px; }
        .hero-content { max-width:900px; animation:fadeInUp 1.5s ease-out; }

        /* کارت خوش‌آمدگویی برای کاربر لاگین شده */
        .welcome-card {
            background:rgba(15,12,41,0.85); backdrop-filter:blur(20px);
            padding:60px 40px; border-radius:30px; text-align:center;
            border:2px solid rgba(0,212,255,0.4); box-shadow:0 20px 60px rgba(0,0,0,0.5), 0 0 50px rgba(0,212,255,0.3);
            position:relative; overflow:hidden; animation:glowPulse 4s infinite alternate;
        }
        .welcome-card::before {
            content:''; position:absolute; inset:-50%; background:conic-gradient(from 0deg,transparent,#00ffff,transparent);
            animation:rotate 20s linear infinite; opacity:0.15;
        }
        @keyframes glowPulse { 0%{box-shadow:0 20px 60px rgba(0,0,0,0.5),0 0 50px rgba(0,212,255,0.3)}
            100%{box-shadow:0 20px 60px rgba(0,0,0,0.6),0 0 70px rgba(0,212,255,0.6)} }
        @keyframes rotate { to{transform:rotate(360deg)} }

        .welcome-card h2 { font-size:3rem; color:#00ffff; margin-bottom:20px; text-shadow:0 0 20px rgba(0,255,255,0.7); }
        .welcome-card p { font-size:1.4rem; color:#b0e0ff; margin-bottom:40px; line-height:1.8; }
        .btn-dashboard {
            display:inline-block; padding:18px 60px; background:linear-gradient(135deg,#00d4ff,#0099ff);
            color:#0f0c29; font-size:1.3rem; font-weight:700; border-radius:50px; text-decoration:none;
            box-shadow:0 10px 30px rgba(0,212,255,0.5); transition:.4s;
        }
        .btn-dashboard:hover {
            transform:translateY(-8px) scale(1.05); background:linear-gradient(135deg,#00ffff,#00ccff);
            box-shadow:0 20px 50px rgba(0,212,255,0.7);
        }

        /* حالت عادی (مهمان) */
        .hero h2 { font-size:3.5rem; color:#00ffff; margin-bottom:20px; text-shadow:0 0 20px rgba(0,255,255,0.6); }
        .hero p { font-size:1.4rem; color:#b0e0ff; margin-bottom:40px; line-height:1.8; }

        /* امکانات و فوتر */
        .features { padding:100px 40px; max-width:1400px; margin:0 auto; }
        .section-title { text-align:center; font-size:2.5rem; color:#00ffff; margin-bottom:60px; text-shadow:0 0 15px rgba(0,255,255,0.5); }
        .features-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:30px; }
        .feature-card {
            background:rgba(15,12,41,0.7); backdrop-filter:blur(16px); padding:30px; border-radius:20px;
            text-align:center; border:1px solid rgba(0,212,255,0.3);
            transition:.4s; box-shadow:0 10px 30px rgba(0,0,0,0.4);
        }
        .feature-card:hover { transform:translateY(-10px); box-shadow:0 20px 40px rgba(0,212,255,0.3); }
        .feature-icon { font-size:3rem; color:#00ffff; margin-bottom:20px; }

        footer { background:rgba(15,12,41,0.9); padding:60px 40px 30px; text-align:center; border-top:1px solid rgba(0,212,255,0.3); }
        .footer-links { display:flex; justify-content:center; gap:40px; margin-bottom:30px; flex-wrap:wrap; }
        .footer-links a { color:#a0faff; text-decoration:none; transition:.3s; }
        .footer-links a:hover { color:#00ffff; text-shadow:0 0 10px rgba(0,255,255,0.5); }

        /* ذرات */
        .particles { position:fixed; inset:0; pointer-events:none; z-index:-1; }
        .particle { position:absolute; background:#00ffff; border-radius:50%; box-shadow:0 0 15px #00ffff; animation:floatGlow 5s infinite ease-in-out; }
        @keyframes floatGlow { 0%,100%{transform:translateY(0) translateX(0);opacity:0.4} 50%{transform:translateY(-25px) translateX(15px);opacity:1} }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(50px)} to{opacity:1;transform:translateY(0)} }

        @media (max-width:768px) {
            .header-container { flex-direction:column; gap:20px; }
            .welcome-card h2 { font-size:2.2rem; }
            .btn-dashboard { padding:15px 40px; font-size:1.1rem; }
        }
    </style>
</head>
<body>

<div class="particles" id="particles"></div>

<header>
    <div class="header-container">
<!--        <div class="logo">-->
<!--            <img src="https://via.placeholder.com/60?text=UT" alt="لوگو">-->
<!--            <h1>دانشگاه فناوری نئون</h1>-->
<!--        </div>-->
        <div class="logo">
            <img src="svg/logo.svg" alt="لوگو" width="70">
            <h1>دانشگاه فناوری نئون</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#home">خانه</a></li>
                <li><a href="#features">امکانات</a></li>
                <li><a href="#about">درباره ما</a></li>
                <li><a href="#contact">تماس</a></li>
            </ul>
        </nav>

        <?php if ($is_logged_in): ?>
            <div style="display:flex; align-items:center; gap:15px;">
                <div class="user-info">
                    <div class="user-icon"><?= strtoupper(substr($username,0,1)) ?></div>
                    <span>سلام، <?= htmlspecialchars($username) ?>!</span>
                    <a href="<?php
                    if ($roll == 1)
                        echo "AdminPanel.php";
                    elseif($roll == 0)
                        echo "panel.php";
                    ?>">ورود به پنل</a>
                </div>
                <a href="logout.php" class="btn-logout">خروج</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-register">ثبت‌نام / ورود</a>
        <?php endif; ?>
    </div>
</header>

<section class="hero" id="home">
    <div class="hero-content">
        <?php if ($is_logged_in): ?>
            <!-- کاربر لاگین کرده -->
            <div class="welcome-card">
                <h2>خوش آمدید، <?= htmlspecialchars($username) ?> عزیز!</h2>

            </div>
        <?php else: ?>
            <!-- مهمان -->
            <h2>به دانشگاه فناوری نئون خوش آمدید</h2>
            <p>جایی که نوآوری و دانش با هم دیدار می‌کنند. با سیستم‌های پیشرفته آموزشی، اساتید برجسته و امکانات مدرن، آینده خود را بسازید.</p>
            <a href="login.php" class="btn-register">شروع کنید</a>
        <?php endif; ?>
    </div>
</section>

<section class="features" id="features">
    <h2 class="section-title">امکانات دانشگاه</h2>
    <div class="features-grid">
        <div class="feature-card">
            <i class="feature-icon" data-feather="book-open"></i>
            <h3>دوره‌های آنلاین</h3>
            <p>دسترسی به هزاران دوره آموزشی با کیفیت بالا و گواهی معتبر.</p>
        </div>
        <div class="feature-card">
            <i class="feature-icon" data-feather="users"></i>
            <h3>اساتید متخصص</h3>
            <p>یادگیری از بهترین اساتید دانشگاه‌های برتر جهان.</p>
        </div>
        <div class="feature-card">
            <i class="feature-icon" data-feather="award"></i>
            <h3>گواهی معتبر</h3>
            <p>دریافت مدرک رسمی پس از اتمام دوره‌ها.</p>
        </div>
        <div class="feature-card">
            <i class="feature-icon" data-feather="globe"></i>
            <h3>شبکه جهانی</h3>
            <p>ارتباط با دانشجویان از سراسر جهان.</p>
        </div>
        <div class="feature-card">
            <i class="feature-icon" data-feather="cpu"></i>
            <h3>آزمایشگاه‌های پیشرفته</h3>
            <p>دسترسی به تجهیزات هوش مصنوعی و رباتیک.</p>
        </div>
        <div class="feature-card">
            <i class="feature-icon" data-feather="calendar"></i>
            <h3>رویدادهای علمی</h3>
            <p>سمینارها و کنفرانس‌های بین‌المللی.</p>
        </div>
    </div>
</section>

<footer>
    <div class="footer-links">
        <a href="#">درباره دانشگاه</a>
        <a href="#">قوانین</a>
        <a href="#">حریم خصوصی</a>
        <a href="#">پشتیبانی</a>
        <a href="#">تماس با ما</a>
    </div>
    <p>© ۱۴۰۴ دانشگاه فناوری نئون. تمامی حقوق محفوظ است.</p>
</footer>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    // ذرات نوری
    const container = document.getElementById('particles');
    for(let i=0; i<40; i++){
        const p = document.createElement('div');
        p.classList.add('particle');
        const size = Math.random()*5 + 2;
        p.style.width = p.style.height = size + 'px';
        p.style.left = Math.random()*100 + '%';
        p.style.top = Math.random()*100 + '%';
        p.style.animationDelay = Math.random()*5 + 's';
        p.style.animationDuration = Math.random()*4 + 4 + 's';
        container.appendChild(p);
    }

    // اسکرول نرم
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector(a.getAttribute('href')).scrollIntoView({behavior:'smooth'});
        });
    });
</script>
</body>
</html>