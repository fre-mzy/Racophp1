<?php $title='About us';require 'includes/header.php';?>
<div class="page"><div class="wrap"><span class="bar"></span><h1>About <?=h($S['n'])?></h1><p class="lead">Since <?=$S['since']?>, bringing hope, dignity and a future to children and families in rural Nigeria.</p></div></div>
<section><div class="wrap split">
<div><h2>Welcome to RACO Child Orphanage and School</h2>
<p class="lead">RACO Child Orphanage is a faith-based care and protection centre for orphans, vulnerable and displaced poor children in rural communities. We are committed to providing hope, dignity and a future to children in need by meeting their daily needs: meals, shelter, welfare, education and emotional support.</p>
<p class="quote">Our ultimate goal is to formally reintegrate each child into society, well equipped for a life of purpose and positive impact.</p></div>
<?=photo('children-courtyard.jpg','Children of RACO in the courtyard')?>
</div></section>
<section class="alt"><div class="wrap"><span class="bar"></span><h2>Our mission</h2>
<p class="lead">To nurture and protect vulnerable children, educate the next generation, and empower rural communities, especially women, youths and the aged, with tools, training and opportunities for sustainable development.</p></div></section>
<section><div class="wrap"><span class="bar"></span><h2>The people behind RACO</h2>
<p class="lead">Our board ensures financial transparency, spiritual integrity and lasting impact across everything RACO does.</p>
<?php foreach(['Trustees'=>'Board of Trustees','Ambassadors'=>'Our ambassadors'] as $g=>$t): ?>
<h3 style="margin:38px 0 18px"><?=$t?></h3><div class="tm">
<?php foreach($S['team'] as $m) if($m[3]==$g) echo '<div class="mem rv">'.photo($m[2],$m[0],'pt').'<b>'.h($m[0]).'</b><span>'.h($m[1]).'</span></div>';?>
</div><?php endforeach; ?>
</div></section>
<section class="alt"><div class="wrap"><span class="bar"></span><h2>Where to find us</h2><div class="g2" style="margin-top:28px">
<?php foreach($S['loc'] as $l)echo '<div class="tile"><h3>'.h($l[0]).'</h3><p>'.h($l[1]).'</p>'.($l[2]?'<p style="margin-top:8px"><b>'.h($l[2]).'</b></p>':'').'</div>';?>
</div></div></section>
<?php require 'includes/footer.php';?>
