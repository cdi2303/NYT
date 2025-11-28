<?php
include "config.php"; // 중요: 반드시 먼저 로딩

if(!empty($demo_links)): ?>
    <section>
        <h2>데모 확인</h2>
        <?php foreach ($demo_links as $t => $u): ?>
            <div><a href="<?= $u ?>"><?= $t ?></a></div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
