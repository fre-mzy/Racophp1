
<?php
$title = 'Home';
require 'includes/header.php';
$yrs = date('Y') - $S['since'];
?>

<section class="hero">
    <div class="sl on" style="background-image:url(assets/img/children-courtyard.jpg)"></div>
    <div class="sl" style="background-image:url(assets/img/children-praying.jpg)"></div>
    <div class="sl" style="background-image:url(assets/img/group-photo.jpg)"></div>

    <div class="wrap">
        <div class="hc">
            <div class="t on">
                <h1>Touching lives, touching rural communities everyday</h1>
                <p>RACO Commission brings together our care, education and community initiatives to support vulnerable children and empower rural families.</p>
                <a class="btn btn-r" href="support.php">Give a child hope</a>
                <a class="btn btn-o" href="programmes.php">See our work</a>
            </div>

            <div class="t">
                <h1>Free education and brighter futures</h1>
                <p>Supporting orphans and vulnerable children through education, learning materials, school meals and care.</p>
                <a class="btn btn-r" href="support.php">Support our children</a>
                <a class="btn btn-o" href="programmes.php">Our schools</a>
            </div>

            <div class="t">
                <h1>Care, rehabilitation and community empowerment</h1>
                <p>From shelter and welfare support for children to empowerment opportunities for rural widows, we work towards stronger communities.</p>
                <a class="btn btn-r" href="contact.php">Work with us</a>
                <a class="btn btn-o" href="about.php">Our story</a>
            </div>
        </div>
    </div>

    <div class="dots"><b class="on"></b><b></b><b></b></div>
</section>

<div class="stats">
    <div class="wrap sg">
        <div><b data-count="<?=$yrs?>">0</b><span>Years of service</span></div>
        <div><b data-count="400" data-s="+">0</b><span>Children in our free schools</span></div>
        <div><b data-count="3000" data-s="+">0</b><span>Children we aim to reach</span></div>
        <div><b data-count="2">0</b><span>States: Lagos and Ogun</span></div>
    </div>
</div>

<section>
    <div class="wrap split">
        <div class="rv">
            <span class="bar"></span>
            <h2>More than an orphanage</h2>

            <p class="lead">
                RACO Child Orphanage is the care and rehabilitation arm of
                RACO Child and Rural Care Initiative, a non-governmental
                agency supporting orphans, vulnerable, displaced and poor
                children in rural communities.
            </p>

            <p>
                Our work includes shelter, free education, feeding,
                medication and welfare support for children, alongside
                empowerment initiatives for widows in rural communities.
            </p>

            <p class="quote">
                Our goal is to help children grow in safety, dignity and
                opportunity, while strengthening the communities around them.
            </p>

            <a class="btn btn-b" href="about.php">Read our story</a>
        </div>

        <div class="rv">
            <?=photo('group-photo.jpg', 'RACO children and visitors outside the orphanage')?>
        </div>
    </div>
</section>

<section class="alt">
    <div class="wrap">
        <span class="bar"></span>
        <h2>What we do</h2>
        <p class="lead">
            From the classroom to child protection, healthcare and rural
            empowerment, RACO supports people through different stages of life.
        </p>

        <div class="bento">
            <?php foreach ($S['prog'] as $k => $p): ?>
                <?php if ($k == 0): ?>
                    <a class="tile big rv" href="programmes.php">
                        <h3><?=h($p[0])?></h3>
                        <p><?=h($p[1])?></p>
                        <span class="btn btn-r" style="align-self:flex-start">Learn more</span>
                    </a>
                <?php else: ?>
                    <a class="tile rv" href="programmes.php">
                        <h3><?=h($p[0])?></h3>
                        <p><?=h(strtok($p[1], '.'))?>.</p>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <span class="bar"></span>
        <h2>One commission, six entities</h2>

        <p class="lead">
            RACO Commission is the umbrella body bringing together the
            following organisations and services under the RACO structure.
        </p>

        <div class="bento">
            <?php foreach ($S['entities'] as $entity): ?>
                <div class="tile rv">
                    <h3><?=h($entity)?></h3>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="margin-top:24px">
            <a class="btn btn-b" href="about.php">Learn about RACO</a>
        </p>
    </div>
</section>

<section>
    <div class="wrap">
        <span class="bar"></span>
        <h2>Through the year</h2>
        <p class="lead">
            Joyful, community-driven celebrations. Everyone is welcome.
        </p>

        <div style="margin-top:28px">
            <?php foreach ($S['ev'] as $e): ?>
                <div class="ev rv">
                    <b><?=h($e[0])?></b>
                    <span><?=h($e[1])?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="wrap rv">
        <h2>Be part of the story</h2>
        <p>Your gift, your time or your skills can help change a child's future.</p>
        <a class="btn btn-r" href="support.php">Donate</a>
        <a class="btn btn-o" href="contact.php">Volunteer or partner</a>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
