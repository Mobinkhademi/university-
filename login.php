<?php
session_start();
include("includes/conn.php");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود و ثبت‌نام</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

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

        .auth-container {
            position: relative;
            width: 100%;
            max-width: 450px;
            height: 620px;
            perspective: 1000px;
        }

        .form-box {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(15, 12, 41, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6),
            0 0 35px rgba(0, 212, 255, 0.3);
            border: 1px solid rgba(0, 212, 255, 0.4);
            padding: 40px;
            transition: all 0.8s ease;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        .form-box.login {
            transform: rotateY(0deg);
            z-index: 2;
        }

        .form-box.register {
            transform: rotateY(180deg);
            z-index: 1;
        }

        .form-box.active {
            z-index: 3;
        }

        .form-box::before {
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

        .form-title {
            text-align: center;
            color: #00ffff;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
            letter-spacing: 1.2px;
        }

        /* ===== INPUT GROUP ===== */
        .input-group {
            position: relative;
            margin-bottom: 28px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            color: rgba(0, 255, 255, 0.7);
            font-size: 1.2rem;
            pointer-events: none;
            z-index: 2;
            transition: all 0.3s ease;
        }

        /* وقتی فیلد پر یا فوکوس داره، آیکون کمی کوچیک‌تر و روشن‌تر */
        .input-group:focus-within .input-icon,
        .input-group input:not(:placeholder-shown) ~ .input-icon {
            color: #00ffff;
            font-size: 1.1rem;
            transform: translateY(-50%) scale(0.9);
        }

        input {
            width: 100%;
            padding: 15px 48px 15px 48px;
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(0, 212, 255, 0.4);
            border-radius: 12px;
            font-size: 1rem;
            color: #e0f7ff;
            transition: all 0.4s ease;
            outline: none;
        }

        input::placeholder {
            color: transparent;
        }

        input:focus {
            background: rgba(26, 26, 46, 0.8);
            border-color: #00ffff;
            box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.3);
            transform: scale(1.02);
        }

        label {
            position: absolute;
            top: 50%;
            right: 48px;
            transform: translateY(-50%);
            font-size: 1rem;
            color: rgba(0, 255, 255, 0.7);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            font-weight: 500;
            white-space: nowrap;
        }

        input:focus ~ label,
        input:not(:placeholder-shown) ~ label {
            top: -12px;
            right: 16px;
            font-size: 0.8rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            padding: 2px 10px;
            border-radius: 8px;
            color: #0f0c29;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(0, 255, 255, 0.7);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .toggle-password:hover {
            color: #00ffff;
            transform: translateY(-50%) scale(1.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #00d4ff, #00aaff);
            color: #0f0c29;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
            margin-top: 15px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.6s;
        }

        button[type="submit"]:hover::before {
            left: 100%;
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 212, 255, 0.5);
            background: linear-gradient(135deg, #00ffff, #00ccff);
        }

        .switch-text {
            text-align: center;
            margin-top: 20px;
            color: #a0faff;
            font-size: 0.95rem;
        }

        .switch-link {
            color: #00ffff;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            transition: all 0.3s ease;
        }

        .switch-link:hover {
            color: #00ccff;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

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

        @media (max-width: 480px) {
            .auth-container { max-width: 380px; height: 580px; }
            .form-box { padding: 30px 25px; }
            .form-title { font-size: 1.6rem; }
            input { padding: 14px 44px; }
        }
    </style>
</head>
<body>

<div class="particles" id="particles"></div>

<div class="auth-container">
    <!-- فرم ورود -->
    <div class="form-box login active" id="loginBox">
        <h3 class="form-title">ورود به سیستم</h3>
        <form id="loginForm" action="validate.php" method="post">
            <div class="input-group">
                <i class="input-icon" data-feather="user"></i>
                <input type="text" id="username" name="username" placeholder=" " required>
                <label for="username">نام کاربری</label>
            </div>

            <div class="input-group">
                <i class="input-icon" data-feather="lock"></i>
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">رمز عبور</label>
                <button type="button" class="toggle-password" onclick="toggleLoginPassword()">
                    <i data-feather="eye"></i>
                </button>
            </div>

            <button type="submit">ورود امن</button>
        </form>
        <p class="switch-text">حساب ندارید؟ <span class="switch-link" onclick="switchToRegister()">ثبت‌نام کنید</span></p>
    </div>

    <!-- فرم ثبت‌نام -->
    <div class="form-box register" id="registerBox">
        <h3 class="form-title">ثبت‌نام دانشجو</h3>
        <form id="registerForm" method="post" action="reg.php">
            <div class="input-group">
                <i class="input-icon" data-feather="user"></i>
                <input type="text" id="firstName" name="name" placeholder=" " required>
                <label for="firstName">نام</label>
            </div>
            <div class="input-group">
                <i class="input-icon" data-feather="users"></i>
                <input type="text" id="lastName" name="lastname" placeholder=" " required>
                <label for="lastName">نام خانوادگی</label>
            </div>
            <div class="input-group">
                <i class="input-icon" data-feather="mail"></i>
                <input type="text" id="regUsername" name="username" placeholder=" " required>
                <label for="regUsername">نام کاربری</label>
            </div>
            <div class="input-group">
                <i class="input-icon" data-feather="lock"></i>
                <input type="password" id="regPassword" name="password" placeholder=" " required>
                <label for="regPassword">رمز عبور</label>
                <button type="button" class="toggle-password" onclick="toggleRegPassword()">
                    <i data-feather="eye"></i>
                </button>
            </div>
            <div class="input-group">
                <i class="input-icon" data-feather="phone"></i>
                <input type="text" id="phone" name="phone" placeholder=" " required>
                <label for="phone">شماره موبایل</label>
            </div>
            <button type="submit">ثبت‌نام</button>
        </form>
        <p class="switch-text">حساب دارید؟ <span class="switch-link" onclick="switchToLogin()">وارد شوید</span></p>
    </div>
</div>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    // سوئیچ بین فرم‌ها
    function switchToRegister() {
        document.getElementById('loginBox').style.transform = 'rotateY(-180deg)';
        document.getElementById('registerBox').style.transform = 'rotateY(0deg)';
        setTimeout(() => {
            document.getElementById('loginBox').classList.remove('active');
            document.getElementById('registerBox').classList.add('active');
        }, 400);
    }

    function switchToLogin() {
        document.getElementById('registerBox').style.transform = 'rotateY(180deg)';
        document.getElementById('loginBox').style.transform = 'rotateY(0deg)';
        setTimeout(() => {
            document.getElementById('registerBox').classList.remove('active');
            document.getElementById('loginBox').classList.add('active');
        }, 400);
    }

    // نمایش/مخفی رمز
    function toggleLoginPassword() {
        const field = document.getElementById('password');
        const icon = document.querySelector('#loginBox .toggle-password i');
        toggleField(field, icon);
    }

    function toggleRegPassword() {
        const field = document.getElementById('regPassword');
        const icon = document.querySelector('#registerBox .toggle-password i');
        toggleField(field, icon);
    }

    function toggleField(field, icon) {
        if (field.type === 'password') {
            field.type = 'text';
            icon.setAttribute('data-feather', 'eye-off');
        } else {
            field.type = 'password';
            icon.setAttribute('data-feather', 'eye');
        }
        feather.replace();
    }

    // ثبت‌نام
    // document.getElementById('registerForm').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     const firstName = document.getElementById('firstName').value.trim();
    //     const lastName = document.getElementById('lastName').value.trim();
    //     const username = document.getElementById('regUsername').value.trim();
    //     const password = document.getElementById('regPassword').value;
    //     const confirm = document.getElementById('confirmPassword').value;
    //     const studentId = document.getElementById('studentId').value.trim();
    //
    //     if (password !== confirm) {
    //         alert('رمز عبور و تأیید آن مطابقت ندارند!');
    //         return;
    //     }
    //
    //     const users = JSON.parse(localStorage.getItem('users') || '[]');
    //     if (users.find(u => u.username === username)) {
    //         alert('این نام کاربری قبلاً ثبت شده است!');
    //         return;
    //     }
    //
    //     users.push({ firstName, lastName, username, password, studentId });
    //     localStorage.setItem('users', JSON.stringify(users));
    //     alert('ثبت‌نام با موفقیت انجام شد! حالا وارد شوید.');
    //     switchToLogin();
    // });
    //
    // // ورود
    // document.getElementById('loginForm').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     const username = document.getElementById('loginUsername').value.trim();
    //     const password = document.getElementById('loginPassword').value;
    //
    //     const users = JSON.parse(localStorage.getItem('users') || '[]');
    //     const user = users.find(u => u.username === username && u.password === password);
    //
    //     if (user) {
    //         localStorage.setItem('currentUser', JSON.stringify(user));
    //         window.location.href = 'admin-panel.html';
    //     } else {
    //         window.location.href = 'error.html?reason=invalid';
    //     }
    // });

    // ایجاد ذرات
    const particlesContainer = document.getElementById('particles');
    const particleCount = 25;
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
</script>
</body>
</html>