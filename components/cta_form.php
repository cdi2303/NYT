<?php
header('Content-Type: text/html; charset=utf-8');
require 'config.php';

// PRG + DB INSERT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        error_log("[DB CONNECT FAIL] " . $conn->connect_error . "\n", 3, "db_connect_fail.log");
        die("Database connection failed");
    }

    $name = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $biz = htmlspecialchars(trim($_POST['biz'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');

    if ($name && $biz && $email && $phone && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO leads (name, biz, email, phone) VALUES (?,?,?,?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $biz, $email, $phone);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conn->close();

    // 동일 루트 success 페이지로 redirect
    header("Location: cta_success.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>서비스 문의 접수</title>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/common.css?v=<?= date('Ymd-His') ?>>">

    <style>
        /* 내부 <style>에서는 "레이아웃/장식"만 정의, input/button에 영향 X */

        #tsparticles {
            position: fixed;
            inset: 0;
            z-index: -1;
        }

        .header {
            height: 100vh;
            display: grid;
            place-content: center;
            text-align: center;
            position: relative;
            padding: 0 20px;
        }

        .header h1 {
            font-size: 76px;
            font-weight: 900;
            margin: 0;
            line-height: 1.05;
            background: linear-gradient(90deg, #fff, #818cf8, #4f46e5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2.8px;
        }

        .header p {
            font-size: 22px;
            color: var(--sub);
            margin-top: 28px;
        }

        .section-title {
            font-size: 34px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(90deg, #fff, #818cf8, #4f46e5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>

<div id="tsparticles"></div>

<header class="header">
    <h1>Stunning Landing.<br/>Same-Day Delivery.</h1>
    <p>한 줄 요구사항으로 범위 확정, 즉시 DB 저장, 당일 착수합니다</p>
</header>

<main class="wrap">

    <section class="card">
        <h2>서비스 제공 가치</h2>
        <p>요구사항 정의 → 원격 DB 저장 → FTP 서버 배포까지 당일 착수</p>

        <div class="grid3">
            <div class="feature">
                <h3>요구사항 확정</h3>
                <p>3가지 질문으로 기능·범위·일정 구조화</p>
            </div>
            <div class="feature">
                <h3>원격 DB 저장</h3>
                <p>Submit 즉시 DB 저장, 당일 착수합니다.</p>
            </div>
            <div class="feature">
                <h3>서버 배포</h3>
                <p>FTP 업로드까지 검수 완료된 환경</p>
            </div>
        </div>
    </section>

    <section class="formbox">
        <div class="section-title">문의 즉시 접수</div>
        <form action="api_lead_insert.php" method="POST" accept-charset="UTF-8">
            <input type="text" name="name" placeholder="성함" required/>
            <input type="text" name="biz" placeholder="업종/필요기능 요약" required/>
            <input type="email" name="email" placeholder="이메일 주소" required/>
            <input type="text" name="phone" placeholder="연락처(예: +82 10-0000-0000)" required/>

            <!-- 버튼은 HTML과 외부 CSS의 .submit-btn만 사용 -->
            <button class="submit-btn" type="submit">요구사항 확정 & 저장</button>
        </form>
    </section>

    <section class="grid3" style="margin-top: 80px;">
        <div class="feature">
            <h3>빠른 착수</h3>
            <p>문의 당일 바로 구현 시작</p>
        </div>
        <div class="feature">
            <h3>안정 문자 처리</h3>
            <p>utf8mb4 일관 저장</p>
        </div>
        <div class="feature">
            <h3>중복 저장 방지</h3>
            <p>PRG 리다이렉션 적용</p>
        </div>
    </section>

</main>

<footer class="footer">
    Copyright 2025, Donil Dev
</footer>

<script>
    // Particle system 그대로 유지(이목 집중 배경)
    tsParticles.load("tsparticles", {
        particles: {
            number: {value: 120},
            size: {value: {min: 1, max: 4}},
            move: {enable: true, speed: 1.2},
            opacity: {value: {min: 0.1, max: 0.5}},
            links: {enable: true, opacity: 0.15}
        },
        interactivity: {
            events: {onHover: {enable: true, mode: "grab"}}
        }
    });
</script>

</body>
</html>
