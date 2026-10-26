<footer><div class="wrap fg">
<div><b class="fh"><?=h($S['n'])?></b><p>Touching lives, touching rural communities everyday. Caring for children and empowering rural families since <?=$S['since']?>.</p></div>
<div><b class="fh">Explore</b><a href="about.php">About us</a><a href="programmes.php">Our work</a><a href="gallery.php">Gallery</a><a href="support.php">Support us</a><a href="contact.php">Contact</a></div>
<div><b class="fh">Call or message</b><?php foreach($S['ph'] as $p)echo '<a href="tel:+234'.substr(preg_replace('/\D/','',$p[0]),1).'">'.h($p[0]).' <small>'.h($p[1]).'</small></a>';?><a href="mailto:<?=h($S['mail'])?>"><?=h($S['mail'])?></a></div>
<div><b class="fh">Visit</b><p><?=h($S['loc'][0][0])?><br><?=h($S['loc'][0][1])?></p></div>
</div><div class="wrap fb">© <?=date('Y')?> <?=h($S['n'])?>, <?=h($S['s'])?>. All rights reserved.</div></footer>
<a class="wa" href="https://wa.me/<?=$S['wa']?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">Chat</a>
<script src="assets/js/main.js"></script></body></html>
