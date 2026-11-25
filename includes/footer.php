
<footer class="raco-footer">

    <div class="wrap fg">

        <!-- ORGANISATION IDENTITY -->
        <div class="footer-brand">
            <b class="fh"><?=h($S['n'])?></b>

            <p><?=h($S['description'])?></p>

            <a href="about.php" class="footer-highlight">
                Discover our mission →
            </a>

            <p class="footer-since">
                Supporting children, education and rural
                community development since <?=h($S['since'])?>.
            </p>
        </div>

        <!-- QUICK LINKS -->
        <div>
            <b class="fh">Explore RACO</b>

            <a href="index.php">Home</a>
            <a href="about.php">About us</a>
            <a href="programmes.php">Our programmes</a>
            <a href="gallery.php">Gallery</a>
            <a href="scholars.php">Our scholars</a>
            <a href="contact.php">Contact us</a>
        </div>

        <!-- GET INVOLVED -->
        <div>
            <b class="fh">Get involved</b>

            <p>
                Your generosity, time and skills can help
                create opportunities for children and
                strengthen rural communities.
            </p>

            <a href="support.php">Support our work</a>
            <a href="contact.php">Volunteer with us</a>
            <a href="contact.php">Partner with RACO</a>
        </div>

        
<!-- CONTACT DETAILS -->
<div>
    <b class="fh">Contact RACO</b>

    <?php foreach ($S['ph'] as $p): ?>

        <?php
        $digits = preg_replace('/\D/', '', $p[0]);
        ?>

        <a href="tel:+<?=h($digits)?>" class="footer-phone">
            <?=h($p[0])?>
            <small><?=h($p[1])?></small>
        </a>

    <?php endforeach; ?>

    <a href="mailto:<?=h($S['mail'])?>">
        <?=h($S['mail'])?>
    </a>

    <a href="https://wa.me/<?=h($S['wa'])?>?text=<?=rawurlencode($S['wa_message'])?>"
       target="_blank"
       rel="noopener noreferrer">
        Message us on WhatsApp →
    </a>
</div>


    <!-- LOCATIONS -->
    <div class="wrap footer-locations">

        <b class="fh">Our locations</b>

        <div class="footer-location-grid">

            <?php foreach ($S['loc'] as $location): ?>

                <div class="footer-location">
                    <b><?=h($location[0])?></b>
                    <p><?=h($location[1])?></p>
                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <!-- BOTTOM BAR -->
    <div class="wrap fb footer-bottom">

        <div>
            <p>
                © <?=date('Y')?> <?=h($S['n'])?>.
                All rights reserved.
            </p>

            <small>
                Supporting children, education and rural
                community development.
            </small>
        </div>

        <a href="#top" class="back-to-top">
            Back to top ↑
        </a>

    </div>

</footer>

<!-- FLOATING WHATSAPP BUTTON -->
<a class="wa-float"
   href="https://wa.me/2348026994164?text=Hello%20RACO%2C%20I%20would%20like%20to%20make%20an%20enquiry."
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat with RACO on WhatsApp">

    <svg viewBox="0 0 32 32"
         width="27"
         height="27"
         fill="currentColor"
         aria-hidden="true">

        <path d="M16 .8A15.1 15.1 0 0 0 3.1 23.7L1 31l7.5-2A15.2 15.2 0 1 0 16 .8Zm0 27.6a12.4 12.4 0 0 1-6.3-1.7l-.5-.3-4.4 1.2 1.2-4.3-.3-.5A12.5 12.5 0 1 1 16 28.4Zm6.9-9.3c-.4-.2-2.2-1.1-2.6-1.2-.4-.1-.6-.2-.9.2-.3.4-1 1.2-1.2 1.4-.2.2-.5.3-.9.1-.4-.2-1.6-.6-3.1-1.9-1.1-1-1.9-2.2-2.1-2.6-.2-.4 0-.6.2-.8l.6-.7c.2-.2.3-.4.4-.7.1-.2 0-.5 0-.7l-1.2-2.9c-.3-.8-.7-.7-.9-.7h-.8c-.3 0-.7.1-1 .5-.3.4-1.3 1.3-1.3 3.1s1.3 3.5 1.5 3.7c.2.2 2.5 3.9 6.1 5.4.9.4 1.6.6 2.1.7.9.3 1.7.2 2.3.1.7-.1 2.2-.9 2.5-1.8.3-.9.3-1.6.2-1.8-.1-.2-.4-.3-.8-.5Z"/>

    </svg>

    <span>WhatsApp</span>

</a>

<script src="assets/js/main.js"></script>

</body>
</html>
