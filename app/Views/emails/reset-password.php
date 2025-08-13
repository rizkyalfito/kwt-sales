<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Kelompok Wanita Tani</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kelompok Wanita Tani</h1>
            <p>Reset Password Request</p>
        </div>
        
        <div class="content">
            <p>Halo <strong><?= esc($email) ?></strong>,</p>
            
            <p>Anda telah menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
            
            <p>Silakan klik tombol di bawah ini untuk reset password Anda:</p>
            
            <div style="text-align: center;">
                <a href="<?= esc($resetLink) ?>" class="button">Reset Password</a>
            </div>
            
            <div class="warning">
                <strong>Penting:</strong> Link ini akan kadaluarsa dalam 1 jam. Jika Anda tidak meminta reset password, abaikan email ini.
            </div>
            
            <p>Jika tombol tidak berfungsi, Anda dapat menyalin dan menempel link berikut di browser Anda:</p>
            <p style="word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                <?= esc($resetLink) ?>
            </p>
        </div>
        
        <div class="footer">
            <p>Terima kasih,<br>Tim Kelompok Wanita Tani</p>
            <p style="font-size: 12px; color: #999;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
