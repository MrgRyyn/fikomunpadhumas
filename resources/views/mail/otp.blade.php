<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <title>Email OTP</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f0f1f5;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #780000;
            color: #ffffff;
            border-radius: 14px;
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 30px 20px 10px;
        }

        .logo {
            width: 120px;
            border-radius: 10px;
        }

        .title {
            margin-top: 10px;
            font-size: 26px;
            font-weight: bold;
            line-height: 1.2;
        }

        .subtitle {
            margin-top: 8px;
            font-size: 15px;
            opacity: 0.9;
        }

        .otp-box {
            background: #ffdb4f;
            color: #0f428d;
            font-size: 30px;
            font-weight: 800;
            text-align: center;
            margin: 25px auto;
            padding: 18px 0;
            border-radius: 10px;
            width: 70%;
            letter-spacing: 4px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .note {
            margin: 20px;
            text-align: center;
            font-size: 13px;
            opacity: 0.85;
            line-height: 1.4;
        }

        .footer {
            background: #fffcef;
            padding: 25px 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .footer div {
            margin-bottom: 6px;
        }

        @media only screen and (max-width: 480px) {
            .otp-box {
                width: 90%;
                font-size: 26px;
                padding: 14px 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <img class="logo" src="https://i.ibb.co.com/3yTB6m4G/logo.png" alt="Logo" />
            <div class="title">Halo, {{$data['user']}}</div>
            <div class="subtitle">Berikut adalah kode OTP Anda:</div>
        </div>

        <!-- OTP -->
        <div class="otp-box">
            {{$data['otp']}}
        </div>

        <div class="note">
            Jangan berikan kode ini kepada siapa pun.  
            Kode OTP berlaku selama <b>10 menit</b>.
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <div>Panitia Pemilu Raya HIMA HUMAS 2025</div>
            <div>Mohon untuk tidak membalas email ini.</div>
            <div>Butuh bantuan? Hubungi Panitia</div>
        </div>
    </div>
</body>
</html>
