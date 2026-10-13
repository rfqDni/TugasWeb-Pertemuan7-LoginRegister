<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TR 7</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            padding: 60px 20px;
            background: radial-gradient(ellipse at top, #1e3a8a 0%, #0f172a 40%, #020617 100%);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                radial-gradient(2px 2px at 20% 30%, #fff, transparent),
                radial-gradient(2px 2px at 60% 70%, #fff, transparent),
                radial-gradient(1px 1px at 50% 50%, #fff, transparent),
                radial-gradient(1px 1px at 80% 10%, #fff, transparent),
                radial-gradient(2px 2px at 90% 60%, #fff, transparent),
                radial-gradient(1px 1px at 33% 80%, #fff, transparent);
            opacity: 0.5;
            pointer-events: none;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 0;
            border: 1px solid #1e3a8a;
            box-shadow:
                0 0 0 4px rgba(30, 58, 138, 0.15),
                0 20px 60px rgba(0, 0, 0, 0.6);
        }

        .card::before {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: #1e3a8a;
            margin-bottom: 20px;
        }

        h1 {
            color: #0f172a;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .subtitle {
            color: #64748b;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .info {
            background: #f8fafc;
            border-left: 4px solid #1e3a8a;
            padding: 20px 24px;
            margin-bottom: 28px;
        }
        .info p {
            margin-bottom: 10px;
            color: #475569;
            font-size: 14px;
        }
        .info p:last-child { margin-bottom: 0; }
        .info strong {
            color: #0f172a;
            font-weight: 700;
            display: inline-block;
            min-width: 100px;
        }

        .btn-logout {
            display: inline-block;
            padding: 14px 28px;
            background: #dc2626;
            color: #ffffff;
            text-decoration: none;
            border-radius: 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: #b91c1c; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🏠 Dashboard</h1>
            <p class="subtitle">Selamat datang di halaman terproteksi</p>

            <div class="info">
                <p><strong>Nama:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                <p><strong>User ID:</strong> <?= htmlspecialchars($_SESSION['user_id']) ?></p>
                <p><strong>Login sejak:</strong> <?= date('d F Y H:i:s') ?></p>
            </div>

            <a href="logout.php" class="btn-logout">🚪 Logout</a>
        </div>
    </div>
</body>
</html>