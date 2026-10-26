<?php $title='Our work';require 'includes/header.php';?>
<div class="page"><div class="wrap"><span class="bar"></span><h1>Our work</h1><p class="lead">Education, care, skills and health, all in the communities that need them most.</p></div></div>
<section><div class="wrap">
<?php foreach($S['prog'] as $p): ?>
<div class="row"><div class="pic rv"><?=photo($p[2],$p[0])?></div><div class="rv"><h2><?=h($p[0])?></h2><p class="lead"><?=h($p[1])?></p></div></div>
<?php endforeach; ?>
</div></section>
<section class="cta"><div class="wrap rv"><h2>Help us reach more children</h2><p>Every gift goes straight into school meals, books, uniforms and care.</p><a class="btn btn-r" href="support.php">Support our work</a></div></section>
<?php require 'includes/footer.php';?>
