<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دانشگاه فناوری نئون</title>
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
            background: radial-gradient(circle at 30% 20%, rgba(0, 212, 255, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 70% 80%, rgba(0, 255, 255, 0.1) 0%, transparent 60%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        /* هدر */
        header {
            background: rgba(15, 12, 41, 0.8);
            backdrop-filter: blur(16px);
            padding: 20px 40px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid rgba(0, 212, 255, 0.3);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 60px;
            height: 60px;
            margin-left: 15px;
            border-radius: 50%;
            border: 2px solid #00ffff;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .logo h1 {
            font-size: 1.8rem;
            color: #00ffff;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: #a0faff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        nav ul li a:hover {
            color: #00ffff;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #00ffff;
            transition: width 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
        }

        .btn-login {
            background: transparent;
            border: 2px solid #00d4ff;
            color: #00d4ff;
        }

        .btn-login:hover {
            background: #00d4ff;
            color: #0f0c29;
            transform: translateY(-3px);
        }

        .btn-register {
            background: linear-gradient(135deg, #00d4ff, #00aaff);
            color: #0f0c29;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #00ffff, #00ccff);
            transform: translateY(-3px);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 212, 255, 0.1);
            padding: 10px 20px;
            border-radius: 12px;
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: #00ffff;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-icon {
            width: 36px;
            height: 36px;
            background: #00d4ff;
            color: #0f0c29;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
        }

        /* هیرو سکشن */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            animation: fadeInUp 1.2s ease-out;
        }

        .hero h2 {
            font-size: 3.5rem;
            color: #00ffff;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.4rem;
            color: #b0e0ff;
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .hero .btn {
            padding: 15px 40px;
            font-size: 1.2rem;
        }

        /* امکانات */
        .features {
            padding: 100px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #00ffff;
            margin-bottom: 60px;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: rgba(15, 12, 41, 0.7);
            backdrop-filter: blur(16px);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(0, 212, 255, 0.3);
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 212, 255, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            color: #00ffff;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .feature-card h3 {
            font-size: 1.6rem;
            color: #00ffff;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #a0faff;
            line-height: 1.7;
        }

        /* فوتر */
        footer {
            background: rgba(15, 12, 41, 0.9);
            padding: 60px 40px 30px;
            text-align: center;
            border-top: 1px solid rgba(0, 212, 255, 0.3);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #a0faff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #00ffff;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        footer p {
            color: #7799cc;
            font-size: 0.9rem;
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

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ریسپانسیو */
        @media (max-width: 768px) {
            .header-container { flex-direction: column; gap: 20px; }
            nav ul { flex-wrap: wrap; justify-content: center; }
            nav ul li { margin: 10px; }
            .hero h2 { font-size: 2.5rem; }
            .hero p { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<div class="particles" id="particles"></div>

<!-- هدر -->


<header>
    <div class="header-container">
        <div class="logo">
            <img src="https://via.placeholder.com/60?text=UT" alt="لوگو دانشگاه">
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

        <!-- اینجا شرط اصلی -->
        <?php if ($is_logged_in): ?>
            <!-- کاربر لاگین کرده → نمایش نام -->
            <div class="user-info">
                <div class="user-icon">
                    <?= strtoupper(substr($username, 0, 1)) ?>
                </div>
                <span>سلام، <?= htmlspecialchars($username) ?>!</span>
            </div>
        <?php else: ?>
            <!-- کاربر لاگین نکرده → نمایش دکمه -->
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-register">ثبت‌نام/ ورود</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<!-- هیرو -->
<section class="hero" id="home">
    <div class="hero-content">
        <h2>به دانشگاه فناوری نئون خوش آمدید</h2>
        <p>جایی که نوآوری و دانش با هم دیدار می‌کنند. با سیستم‌های پیشرفته آموزشی، اساتید برجسته و امکانات مدرن، آینده خود را بسازید.</p>
        <a href="login.php" class="btn btn-register">شروع کنید</a>
    </div>
</section>

<!-- امکانات -->
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

<!-- فوتر -->
<footer>
    <div class="footer-links">
        <a href="#">درباره دانشگاه</a>
        <a href="#">قوانین</a>
        <a href="#">حریم خصوصی</a>
        <a href="#">پشتیبانی</a>
        <a href="#">تماس با ما</a>
    </div>
    <p>&copy; ۱۴۰۴ دانشگاه فناوری نئون. تمامی حقوق محفوظ است.</p>
</footer>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    // ایجاد ذرات
    const particlesContainer = document.getElementById('particles');
    const particleCount = 40;
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        const size = Math.random() * 5 + 1;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.animationDelay = `${Math.random() * 5}s`;
        particle.style.animationDuration = `${Math.random() * 4 + 4}s`;
        particlesContainer.appendChild(particle);
    }

    // اسکرول نرم
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
</body>
</html>
<?php ?>