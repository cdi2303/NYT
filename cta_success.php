<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>접수 완료</title>
<link rel="stylesheet" href="assets/css/common.css?v=<?= date('Ymd-His') ?>">

<style>
/* 장식 스타일만 추가 – 기존 구조 변경 없음 */
.success-container {
  height: 100vh;
  display: grid;
  place-content: center;
  text-align: center;
  padding: 20px;
}
.success-card {
  max-width: 440px;
  padding: 46px 40px;
  background: rgba(255,255,255,0.03);
  backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 22px;
  box-shadow: 0 0 70px rgba(79,70,229,0.34);
  animation: cardEnter 0.8s ease forwards;
  opacity: 0;
  transform: translateY(16px);
}
@keyframes cardEnter {
  to { opacity:1; transform: translateY(0) }
}
.success-card p {
  font-size: 15px;
  color: var(--sub);
  margin-top: 14px;
  margin-bottom: 30px;
}
</style>

<script src="tsparticles.bundle.min.js"></script>
<!-- 파티클 엔진 로드: UI 배경 핵심 -->
<script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
</head>
<body>

<div id="tsparticles"></div>

<main style="display:grid;place-content:center;height:100vh;text-align:center">
  <section class="card" style="text-align:center;padding:40px;max-width:420px">
    <h2 class="gradient-text" style="font-size:36px">접수 완료</h2>
    <p style="margin-top:14px">문의가 정상 저장되었습니다.</p>
    <a href="/" class="submit-btn" style="margin:auto;margin-top:28px;width:auto;padding:12px 30px;display:inline-block">새 문의 작성</a>
  </section>
</main>

<footer class="footer">
  Copyright 2025, Donil Dev
</footer>

<script>
// 파티클 배경 init – 문의폼 화면과 동일 이펙트
tsParticles.load("tsparticles", {
  particles:{
    number:{value:120},
    size:{value:{min:1,max:4}},
    move:{enable:true,speed:1.1},
    opacity:{value:{min:0.12,max:0.52}},
    links:{enable:true,opacity:0.14,distance:120},
  },
  interactivity:{
    events:{onHover:{enable:true,mode:"grab",parallax:{enable:false}}}
  },
  fullScreen:{enable:false}
});
</script>

</body>
</html>
