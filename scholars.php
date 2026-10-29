
<?php
$title = 'Our Scholars';
require 'includes/header.php';

/*
 * Replace these demonstration entries with real, verified profiles
 * only after obtaining permission to publish the information.
 */
$scholars = [
    [
        'name' => 'Scholar profile coming soon',
        'type' => 'University Scholar',
        'institution' => 'Institution details to be confirmed',
        'course' => 'Course details to be confirmed',
        'status' => 'Profile coming soon',
        'image' => '',
        'achievement' => 'Approved academic highlights will be added here.'
    ],
];

$corpsMembers = [
    [
        'name' => 'NYSC profile coming soon',
        'type' => 'NYSC Corps Member',
        'institution' => 'Details to be confirmed',
        'course' => 'Qualification details to be confirmed',
        'status' => 'Profile coming soon',
        'image' => '',
        'achievement' => 'Approved service highlights will be added here.'
    ],
];
?>

<div class="page">
    <div class="wrap">
        <span class="bar"></span>
        <h1>Our Scholars and NYSC Corps Members</h1>
        <p class="lead">
            Celebrating educational progress, personal development and
            service as members of the RACO community work towards a
            brighter future.
        </p>
    </div>
</div>

<section>
    <div class="wrap split">
        <div class="rv">
            <span class="bar"></span>
            <h2>Investing in education and opportunity</h2>

            <p class="lead">
                Education can open doors to opportunity, independence and
                meaningful contribution to society.
            </p>

            <p>
                This page is dedicated to recognising university scholars
                and National Youth Service Corps members associated with
                RACO. It will share approved profiles, educational
                milestones and service experiences as verified
                information becomes available.
            </p>

            <p>
                Our aim is to celebrate progress, encourage younger
                learners and recognise the importance of continued
                learning and community service.
            </p>

            <a class="btn btn-b" href="support.php">Support our work</a>
        </div>

        <div class="rv">
            <?=photo(
                'group-photo.jpg',
                'RACO community members'
            )?>
        </div>
    </div>
</section>

<section class="alt" id="university-scholars">
    <div class="wrap">
        <span class="bar"></span>
        <h2>University scholars</h2>

        <p class="lead">
            Recognising students pursuing higher education and
            developing the knowledge and skills to contribute to society.
        </p>

        <div class="scholar-grid">
            <?php foreach ($scholars as $person): ?>
                <article class="scholar-card rv">
                    <?php if (!empty($person['image'])): ?>
                        <img
                            class="scholar-photo"
                            src="<?=h($person['image'])?>"
                            alt="<?=h($person['name'])?>"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="scholar-placeholder">
                            <span>Scholar profile</span>
                            <small>Photo coming soon</small>
                        </div>
                    <?php endif; ?>

                    <div class="scholar-details">
                        <span class="scholar-type">
                            <?=h($person['type'])?>
                        </span>

                        <h3><?=h($person['name'])?></h3>

                        <p>
                            <b>Institution:</b>
                            <?=h($person['institution'])?>
                        </p>

                        <p>
                            <b>Course:</b>
                            <?=h($person['course'])?>
                        </p>

                        <p>
                            <b>Status:</b>
                            <?=h($person['status'])?>
                        </p>

                        <p>
                            <?=h($person['achievement'])?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="nysc-corps-members">
    <div class="wrap">
        <span class="bar"></span>
        <h2>NYSC corps members</h2>

        <p class="lead">
            Recognising service, responsibility, skills development and
            contributions to communities.
        </p>

        <div class="scholar-grid">
            <?php foreach ($corpsMembers as $person): ?>
                <article class="scholar-card rv">
                    <?php if (!empty($person['image'])): ?>
                        <img
                            class="scholar-photo"
                            src="<?=h($person['image'])?>"
                            alt="<?=h($person['name'])?>"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="scholar-placeholder">
                            <span>Corps member profile</span>
                            <small>Photo coming soon</small>
                        </div>
                    <?php endif; ?>

                    <div class="scholar-details">
                        <span class="scholar-type">
                            <?=h($person['type'])?>
                        </span>

                        <h3><?=h($person['name'])?></h3>

                        <p>
                            <b>Institution:</b>
                            <?=h($person['institution'])?>
                        </p>

                        <p>
                            <b>Qualification:</b>
                            <?=h($person['course'])?>
                        </p>

                        <p>
                            <b>Status:</b>
                            <?=h($person['status'])?>
                        </p>

                        <p>
                            <?=h($person['achievement'])?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="wrap rv">
        <h2>Help create more opportunities</h2>

        <p>
            Your support can help strengthen educational opportunities
            and the wellbeing of children and young people.
        </p>

        <a class="btn btn-r" href="support.php">Support RACO</a>
        <a class="btn btn-o" href="contact.php">Partner with us</a>
    </div>
</section>

<style>
.scholar-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
    margin-top: 28px;
}

.scholar-card {
    min-width: 0;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid rgba(128, 128, 128, .25);
    background: var(--card, transparent);
}

.scholar-photo,
.scholar-placeholder {
    display: flex;
    width: 100%;
    aspect-ratio: 4 / 3;
    object-fit: cover;
}

.scholar-placeholder {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 20px;
    text-align: center;
    background: rgba(128, 128, 128, .10);
}

.scholar-placeholder span {
    font-weight: 700;
}

.scholar-placeholder small {
    opacity: .7;
}

.scholar-details {
    padding: 22px;
}

.scholar-type {
    display: inline-block;
    margin-bottom: 10px;
    font-size: .85rem;
    font-weight: 700;
    opacity: .8;
}

.scholar-details h3 {
    margin-top: 0;
}

.scholar-details p {
    overflow-wrap: anywhere;
}

@media (max-width: 650px) {
    .scholar-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .scholar-details {
        padding: 18px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .scholar-card {
        scroll-behavior: auto;
    }
}
</style>

<?php require 'includes/footer.php'; ?>
