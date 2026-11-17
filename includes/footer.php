
<footer>
    <div class="wrap fg">

        <!-- ORGANISATION IDENTITY -->
        <div>
            <b class="fh"><?=h($S['n'])?></b>

            <p>
                <?=h($S['description'])?>
            </p>

            <p>
                <a href="about.php">Learn about our mission</a>
            </p>
        </div>

        <!-- QUICK LINKS -->
        <div>
            <b class="fh">Explore</b>

            <a href="index.php">Home</a>
            <a href="about.php">About us</a>
            <a href="programmes.php">Our work</a>
            <a href="gallery.php">Gallery</a>
            <a href="scholars.php">Our scholars</a>
            <a href="contact.php">Contact us</a>
        </div>

        <!-- SUPPORT -->
        <div>
            <b class="fh">Get involved</b>

            <p>
                Your generosity, time and skills can help support
                children and rural communities.
            </p>

            <a href="support.php">Support our work</a>
            <a href="contact.php">Volunteer or partner</a>
        </div>

        <!-- CONTACT DETAILS -->
        <div>
            <b class="fh">Call or message</b>

            <?php foreach ($S['ph'] as $p): ?>
                <?php
                $digits = preg_replace('/\D/', '', $p[0]);

                // Convert Nigerian local numbers to international format.
                if (strlen($digits) === 11 && $digits[0] === '0') {
                    $international = '234' . substr($digits, 1);
                } elseif (strpos($digits, '234') === 0) {
                    $international = $digits;
                } else {
                    $international = '';
                }
                ?>

                <?php if ($international !== ''): ?>
                    <a href="tel:+<?=h($international)?>">
                        <?=h($p[0])?>
                        <small><?=h($p[1])?></small>
                    </a>
                <?php else: ?>
                    <span>
                        <?=h($p[0])?>
                        <small><?=h($p[1])?></small>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>

            <a href="mailto:<?=h($S['mail'])?>">
                <?=h($S['mail'])?>
            </a>

            <a href="https://wa.me/<?=h($S['wa'])?>"
               target="_blank"
               rel="noopener noreferrer">
                Chat with us on WhatsApp
            </a>
        </div>

    </div>

    <!-- LOCATION -->
    <div class="wrap" style="padding-bottom:20px">
        <b class="fh">Our locations</b>

        <?php foreach ($S['loc'] as $location): ?>
            <p>
                <b><?=h($location[0])?></b><br>
                <?=h($location[1])?>
            </p>
        <?php endforeach; ?>
    </div>

    <!-- COPYRIGHT -->
    <div class="wrap fb">
        <p>
            © <?=date('Y')?> <?=h($S['n'])?>.
            All rights reserved.
        </p>

        <p>
            Supporting children, education and rural community development
            since <?=h($S['since'])?>.
        </p>
    </div>
</footer>

<a class="wa"
   href="https://wa.me/<?=h($S['wa'])?>"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat with RACO on WhatsApp">
    Chat
</a>

<script src="assets/js/main.js"></script>
</body>
</html>
