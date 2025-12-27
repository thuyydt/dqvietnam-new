<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
    />
    <title>email</title>
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Maven Pro", sans-serif;
        }

        ul,
        ol,
        li {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            text-transform: none;
        }

        body {
            background-color: aquamarine;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .email {
            font-size: 16px;
            font-weight: 500;
            background-image: url("<?=base_url()?>/email/img/bg1.png");
            width: 600px;
            height: 700px;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 15px;
            text-align: center;
            position: relative;
        }

        .logo {
            margin: 28px 0;
        }

        .sub-title {
            color: #0b7cc1;
            font-size: 22px;
            margin-bottom: 12px;
        }

        .title {
            margin-bottom: 12px;
        }

        .txt {
            color: #0b7cc1;
            font-size: 18px;
            font-weight: lighter;
            text-align: start;
            line-height: 1.6;
            margin: 0 48px 12px;
        }

        .txt .link {
            text-transform: none;
            text-decoration: none;
            color: inherit;
        }

        .box {
            margin: 0 48px 24px;
            background-color: #0b7cc1;
            color: #fff;
            border-radius: 5px;
            text-align: start;
            padding: 12px 12px;
            font-weight: 100;
        }

        .box p {
            margin-bottom: 12px;
        }

        .amiga {
            position: absolute;
            bottom: -3px;
            right: 22px;
        }

        .amiga img:first-child {
            position: absolute;
            right: 220px;
            top: -20px;
        }

        .footer {
            position: absolute;
            bottom: 12px;
            left: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 40px;
        }

        .footer-inner {
            background-color: rgba(255, 255, 255, 0.7);
            height: 100%;
            padding: 24px 0;
            border-radius: 12px;
        }

        .footer-inner li {
            display: inline-block;
            height: 100%;
        }

        .footer-links {
            display: block;
            width: 40px;
            height: 100%;
            margin: 0 6px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-links:hover {
            opacity: 0.7;
        }

        .footer-links i {
            font-size: 32px;
            color: #0b7cc1;
        }

        @media (max-width: 600px) {
            .email {
                width: 100%;
            }

            .amiga img:first-child {
                display: none;
            }

            .txt,
            .box {
                margin: 12px auto;
            }

            .title img {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="email">
    <div class="logo">
        <img src="cid:<?= $logo ?>" alt="" loading="lazy" />
    </div>
    <div class="sub-title">Tạo tài khoản thành công</div>
    <div class="title">
        <img src="cid:<?= $contentTitle ?>" alt="" loading="lazy" />
    </div>
    <div class="txt">
        Để bắt đầu chương trình học, bạn vui lòng truy cập: <br/>
        <a href="https://dqvietnam.edu.vn/login" class="link">https://dqvietnam.edu.vn/login</a>
    </div>
    <div class="box">
        <p>Tên đăng nhập: <?php echo $username ?? '___' ?></p>
        <p>Mật khẩu: <?php echo $password ?? '___' ?></p></p>
    </div>
    <div class="amiga">
        <img src="cid:<?= $hello ?>" alt="" loading="lazy" />
        <img src="cid:<?= $amiga ?>" alt="" loading="lazy" />
    </div>
    <div class="footer">
        <ul class="footer-inner">
            <li>
                <a class="footer-links" href="https://www.facebook.com/truyenthonggiaoduccauvong/">
                    <i class="fab fa-facebook"></i>
                </a>
            </li>

            <li>
                <a class="footer-links" href="https://cauvong.vn/"><i class="fab fa-chrome"></i></a>
            </li>

            <li>
                <a class="footer-links" href="https://zalo.me/0376012702"><i class="fas fa-phone-alt"></i></a>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
