<?php
include("includes/conn.php");

$name = $_POST["name"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$username = $_POST["username"];
$password = $_POST["password"];


$num = random_int(1000, 9999);
$student_id = $num;

// آپلود عکس
$filename = $_FILES['pic']['name'];

$pic_tmp = pathinfo($filename, PATHINFO_EXTENSION);
$rand = random_int(10000, 99999);
$dt = new DateTime();
$now = $dt->format('Y_m_d_His');
$newFilename = $now . $rand . "." . $pic_tmp;

$size = round($_FILES['pic']['size'] / 1024, 0);

if ($size <= 20 && !empty($filename)) {
    $upload_path = "images/" . $newFilename;
    move_uploaded_file($_FILES['pic']['tmp_name'], $upload_path);

    $sqlins = "INSERT INTO `students`
               (`student_id`, `name`, `family`, `phone`, `username`, `password`, `pic`)
               VALUES ('$student_id', '$name', '$lastname', '$phone', '$username', '$password', '$newFilename')";

    mysqli_query($mysqli, $sqlins);
    header("Location: login.php");
    exit;
} else { ?>

    <div class="error-message">
    <i class="error-icon" data-feather="alert-triangle"></i>
    <span>حجم فایل شما بیش از 20 کیلوبایت است</span>
</div>

<?php } ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

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


        .error-message {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: rgba(255, 50, 50, 0.15);
            border: 1px solid rgba(255, 100, 100, 0.4);
            color: #ff6666;
            padding: 16px 20px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
            max-width: 420px;
            margin: 20px auto;
            box-shadow: 0 6px 20px rgba(255, 50, 50, 0.2),
            0 0 20px rgba(255, 100, 100, 0.15);
            backdrop-filter: blur(8px);
            animation: shake 0.6s ease-out, fadeIn 0.5s ease-out;
            text-shadow: 0 0 8px rgba(255, 100, 100, 0.3);
            font-family: 'Vazirmatn', sans-serif;
        }

        .error-icon {
            width: 22px;
            height: 22px;
            color: #ff6666;
            filter: drop-shadow(0 0 6px rgba(255, 100, 100, 0.5));
        }

        .error-message:hover {
            border-color: #ff6666;
            box-shadow: 0 8px 25px rgba(255, 50, 50, 0.3),
            0 0 30px rgba(255, 100, 100, 0.25);
            transform: translateY(-2px);
        }

        /* انیمیشن لرزش */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); }
            20%, 40%, 60%, 80% { transform: translateX(6px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ریسپانسیو */
        @media (max-width: 480px) {
            .error-message {
                font-size: 0.95rem;
                padding: 14px 16px;
                gap: 10px;
            }
            .error-icon { width: 20px; height: 20px; }
        }
    </style>
</head>
<body>

</body>
</html>
