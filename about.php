
<?php
$title = 'About us';
require 'includes/header.php';
?>

<div class="page">
    <div class="wrap">
        <span class="bar"></span>
        <h1>About <?=h($S['n'])?></h1>
        <p class="lead">
            Supporting vulnerable children, strengthening rural communities,
            and working towards a future of hope, dignity and opportunity
            since <?=$S['since']?>.
        </p>
    </div>
</div>

<!-- ABOUT RACO -->
<section>
    <div class="wrap split">
        <div class="rv">
            <span class="bar"></span>
            <h2>Welcome to RACO Child Orphanage</h2>

            <p class="lead">
                RACO Child Orphanage is the care and rehabilitation arm of
                RACO Child and Rural Care Initiative, a non-governmental
                agency committed to supporting orphans, vulnerable,
                displaced and poor children, as well as widows in rural
                communities.
            </p>

            <p>
                Our work focuses on meeting essential needs through shelter,
                education, feeding, medication and welfare support. We also
                support community development through initiatives that
                create opportunities for rural families and individuals.
            </p>

            <p>
                We believe every child deserves care, protection, dignity
                and the opportunity to develop their potential in a safe
                and supportive environment.
            </p>

            <p class="quote">
                Our goal is to help every child grow towards a life of
                purpose, independence and positive impact in society.
            </p>

            <a class="btn btn-b" href="programmes.php">Explore our work</a>
        </div>

        <div class="rv">
            <?=photo('children-courtyard.jpg', 'Children at RACO Child Orphanage')?>
        </div>
    </div>
</section>

<!-- MISSION -->
<section class="alt">
    <div class="wrap">
        <span class="bar"></span>
        <h2>Our mission</h2>

        <p class="lead">
            <?=h($S['mission'])?>
        </p>

        <div class="bento">
            <div class="tile rv">
                <h3>Care and protection</h3>
                <p>
                    Supporting children through shelter, feeding, welfare
                    and a caring environment that respects their dignity.
                </p>
            </div>

            <div class="tile rv">
                <h3>Education and opportunity</h3>
                <p>
                    Promoting access to education and learning resources
                    to help children build a stronger future.
                </p>
            </div>

            <div class="tile rv">
                <h3>Community empowerment</h3>
                <p>
                    Supporting rural widows and communities through
                    empowerment and development initiatives.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- RACO COMMISSION STRUCTURE -->
<section>
    <div class="wrap">
        <span class="bar"></span>
        <h2>One commission, six entities</h2>

        <p class="lead">
            RACO Commission is the umbrella body bringing together the
            organisations and services that contribute to the wider RACO
            mission.
        </p>

        <div class="bento">
            <?php foreach ($S['entities'] as $entity): ?>
                <div class="tile rv">
                    <h3><?=h($entity)?></h3>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="margin-top:24px">
            The work of these entities sits within a wider commitment to
            care, education, welfare and community development.
        </p>
    </div>
</section>

<!-- PEOPLE BEHIND RACO -->
<section class="alt">
    <div class="wrap">
        <span class="bar"></span>
        <h2>The people behind RACO</h2>

        <p class="lead">
            RACO's trustees and ambassadors are presented here as part of
            the people associated with its leadership, governance and
            community engagement.
        </p>

        <?php foreach (['Trustees' => 'Board of Trustees', 'Ambassadors' => 'Our ambassadors'] as $g => $t): ?>

            <h3 style="margin:38px 0 18px"><?=h($t)?></h3>

            <div class="tm">
                <?php foreach ($S['team'] as $m): ?>
                    <?php if ($m[3] === $g): ?>
                        <div class="mem rv">
                            <?=photo($m[2], $m[0], 'pt')?>
                            <b><?=h($m[0])?></b>
                            <span><?=h($m[1])?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </div>
</section>

<!-- LOCATIONS -->
<section>
    <div class="wrap">
        <span class="bar"></span>
        <h2>Where to find us</h2>

        <p class="lead">
            RACO's listed locations serve as points of operation and
            coordination for its work.
        </p>

        <div class="g2" style="margin-top:28px">
            <?php foreach ($S['loc'] as $l): ?>
                <div class="tile rv">
                    <h3><?=h($l[0])?></h3>
                    <p><?=h($l[1])?></p>

                    <?php if (!empty($l[2])): ?>
                        <p style="margin-top:8px">
                            <b><?=h($l[2])?></b>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="cta">
    <div class="wrap rv">
        <h2>Be part of the RACO story</h2>

        <p>
            Your support, time, skills or partnership can contribute to
            the wellbeing of children and rural communities.
        </p>

        <a class="btn btn-r" href="support.php">Support our work</a>
        <a class="btn btn-o" href="contact.php">Contact us</a>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
