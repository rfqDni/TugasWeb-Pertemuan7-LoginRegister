<?php
session_start();
$error = '';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi!";
    } else {
        $file = 'users.json';
        if (!file_exists($file)) {
            $error = "Belum ada user terdaftar. Silakan register dulu.";
        } else {
            $users = json_decode(file_get_contents($file), true) ?? [];

            $foundUser = null;
            foreach ($users as $u) {
                if (strtolower($u['email']) === strtolower($email)) {
                    $foundUser = $u;
                    break;
                }
            }

            if ($foundUser && password_verify($password, $foundUser['password'])) {
                $_SESSION['user_id']  = $foundUser['id'];
                $_SESSION['username'] = $foundUser['nama'];
                $_SESSION['email']    = $foundUser['email'];

                if (isset($_POST['remember'])) {
                    setcookie('user_email', $foundUser['email'], time() + (30 * 24 * 60 * 60), '/');
                }

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Email atau password salah!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TR 7</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: radial-gradient(ellipse at top, #1e3a8a 0%, #0f172a 40%, #020617 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                radial-gradient(2px 2px at 20% 30%, #fff, transparent),
                radial-gradient(2px 2px at 60% 70%, #fff, transparent),
                radial-gradient(1px 1px at 50% 50%, #fff, transparent),
                radial-gradient(1px 1px at 80% 10%, #fff, transparent),
                radial-gradient(2px 2px at 90% 60%, #fff, transparent),
                radial-gradient(1px 1px at 33% 80%, #fff, transparent),
                radial-gradient(1px 1px at 15% 90%, #fff, transparent);
            background-size: 200% 200%;
            opacity: 0.6;
            animation: twinkle 8s ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.4; }
            50%      { opacity: 0.9; }
        }

        .card {
            position: relative;
            z-index: 1;
            background: #ffffff;
            padding: 40px;
            border-radius: 0;
            border: 1px solid #1e3a8a;
            box-shadow:
                0 0 0 4px rgba(30, 58, 138, 0.15),
                0 20px 60px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 420px;
        }

        .card::before {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: #1e3a8a;
            margin-bottom: 20px;
        }

        h2 {
            color: #0f172a;
            margin-bottom: 24px;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 14px;
            border-radius: 0;
        }
        .alert-error  {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }
        .alert-sukses {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 2px solid #cbd5e1;
            border-radius: 0;
            font-size: 14px;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #1e3a8a;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.15);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 13px;
            color: #64748b;
        }
        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1e3a8a;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #1e3a8a;
            color: #ffffff;
            border: none;
            border-radius: 0;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: #1d4ed8; }
        button:active { background: #172554; }

        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }
        .link a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 700;
        }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔐 Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registered'): ?>
            <div class="alert alert-sukses">Registrasi berhasil! Silakan login.</div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'logged_out'): ?>
            <div class="alert alert-sukses">Anda telah logout.</div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($_COOKIE['user_email'] ?? '') ?>"
                   placeholder="email@example.com" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="••••••" required>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin:0; font-weight:400; text-transform:none; letter-spacing:0;">Remember Me (30 hari)</label>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <p class="link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>