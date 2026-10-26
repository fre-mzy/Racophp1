<?php $title='Home';require 'includes/header.php';$yrs=date('Y')-$S['since'];?>
<section class="hero">
<div class="sl on" style="background-image:url(assets/img/children-courtyard.jpg)"></div>
<div class="sl" style="background-image:url(assets/img/children-praying.jpg)"></div>
<div class="sl" style="background-image:url(assets/img/group-photo.jpg)"></div>
<div class="wrap"><div class="hc">
 <div class="t on"><h1>Touching lives, touching rural communities everyday</h1><p>A faith-based commission caring for orphans and vulnerable children, and lifting rural families, since <?=$S['since']?>.</p><a class="btn btn-r" href="support.php">Give a child hope</a><a class="btn btn-o" href="programmes.php">See our work</a></div>
 <div class="t"><h1>Free education for children who have no one else to pay</h1><p>Tuition, books, uniforms and a hot lunch every school day for children in rural communities.</p><a class="btn btn-r" href="support.php">Sponsor a child</a><a class="btn btn-o" href="programmes.php">Our schools</a></div>
 <div class="t"><h1>Faith, care and a future for every child</h1><p>Meals, shelter, welfare and love, until each child is ready to stand on their own.</p><a class="btn btn-r" href="contact.php">Volunteer with us</a><a class="btn btn-o" href="about.php">Our story</a></div>
</div></div>
<div class="dots"><b class="on"></b><b></b><b></b></div>
</section>

<div class="stats"><div class="wrap sg">
<div><b data-count="<?=$yrs?>">0</b><span>Years of service</span></div>
<div><b data-count="400" data-s="+">0</b><span>Children in our free schools</span></div>
<div><b data-count="3000" data-s="+">0</b><span>Children we aim to reach</span></div>
<div><b data-count="2">0</b><span>States: Lagos and Ogun</span></div>
</div></div>

<section><div class="wrap split">
<div class="rv"><span class="bar"></span><h2>More than an orphanage</h2>
<p class="lead">RACO Child Orphanage is a faith-based care and protection centre for orphans, vulnerable and displaced poor children in rural communities. We meet their daily needs: meals, shelter, welfare, education and emotional support.</p>
<p class="quote">Our goal is to reintegrate each child into society, equipped for a life of purpose and positive impact.</p>
<a class="btn btn-b" href="about.php">Read our story</a></div>
<div class="rv"><?=photo('group-photo.jpg','RACO children and visitors outside the orphanage')?></div>
</div></section>

<section class="alt"><div class="wrap"><span class="bar"></span><h2>What we do</h2>
<p class="lead">From the classroom to the clinic, RACO works across the whole life of a rural community.</p>
<div class="bento">
<?php foreach($S['prog'] as $k=>$p): if($k==0): ?>
 <a class="tile big rv" href="programmes.php"><h3><?=h($p[0])?></h3><p><?=h($p[1])?></p><span class="btn btn-r" style="align-self:flex-start">Learn more</span></a>
<?php else: ?>
 <a class="tile rv" href="programmes.php"><h3><?=h($p[0])?></h3><p><?=h(strtok($p[1],'.')).'.'?></p></a>
<?php endif; endforeach; ?>
</div></div></section>

<section><div class="wrap"><span class="bar"></span><h2>Through the year</h2>
<p class="lead">Joyful, community-driven celebrations. Everyone is welcome.</p>
<div style="margin-top:28px"><?php foreach($S['ev'] as $e)echo '<div class="ev rv"><b>'.h($e[0]).'</b><span>'.h($e[1]).'</span></div>';?></div>
</div></section>

<section class="cta"><div class="wrap rv"><h2>Be part of the story</h2><p>Your gift, your time or your skills can change a child's whole future.</p>
<a class="btn btn-r" href="support.php">Donate</a><a class="btn btn-o" href="contact.php">Volunteer or partner</a></div></section>
<?php require 'includes/footer.php';?>
