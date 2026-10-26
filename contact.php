<?php $title='Contact';require 'includes/header.php';?>
<div class="page"><div class="wrap"><span class="bar"></span><h1>Contact us</h1><p class="lead">Call, message or visit. We would love to hear from you.</p></div></div>
<section><div class="wrap split" style="align-items:start">
<div><h2>Send us a message</h2>
<form id="wf" data-wa="<?=$S['wa']?>"><input name="name" placeholder="Your name" required><textarea name="msg" rows="5" placeholder="How would you like to help, or what would you like to know?" required></textarea><button class="btn btn-r" type="submit">Send on WhatsApp</button></form>
<p class="lead" style="margin-top:14px;font-size:.9rem">This opens WhatsApp with your message ready to send.</p></div>
<div><h2>Reach us</h2>
<?php foreach($S['ph'] as $p)echo '<p><a href="tel:+234'.substr(preg_replace('/\D/','',$p[0]),1).'"><b>'.h($p[0]).'</b></a> <span class="lead">'.h($p[1]).'</span></p>';?>
<p><a href="mailto:<?=h($S['mail'])?>"><b><?=h($S['mail'])?></b></a></p>
<div style="margin-top:24px"><?php foreach($S['loc'] as $l)echo '<p style="margin-bottom:14px"><b>'.h($l[0]).'</b><br><span class="lead">'.h($l[1]).'</span></p>';?></div></div>
</div></section>
<?php require 'includes/footer.php';?>
