
<?php
$title = 'About us';
require 'includes/header.php';

$entityDetails = [
    [
        'name' => 'RACO Child and Rural Care Initiative',
        'category' => 'NGO & Community Development',
        'description' => 'RACO Child and Rural Care Initiative is a non-governmental agency committed to supporting orphans, vulnerable, displaced and poor children, as well as widows in rural communities. Through shelter, education, feeding, medication, welfare support and community empowerment initiatives, the organisation works to improve lives and create opportunities for a better future.'
    ],
    [
        'name' => 'RACO Child Orphanage',
        'category' => 'Care & Rehabilitation',
        'description' => 'RACO Child Orphanage is the care and rehabilitation arm of RACO Child and Rural Care Initiative. It provides shelter, feeding, education, medication and welfare support to children in need, offering a safe and nurturing environment where they can grow, learn and develop their potential.'
    ],
    [
        'name' => 'RACO Child Orphanage Nursery and Primary Schools',
        'category' => 'Education',
        'description' => 'RACO Child Orphanage Nursery and Primary Schools provide education and support the academic, social and moral development of children. The schools serve both children living within RACO and pupils from the wider community, creating an inclusive learning environment where every child has the opportunity to learn and build a brighter future.'
    ],
    [
        'name' => 'RACO Life Center',
        'category' => 'Healthcare',
        'description' => 'RACO Life Center supports children’s health and wellbeing by providing medical care and essential medicines. Its services are available to children living within RACO as well as children from the wider community, helping address their healthcare needs.'
    ],
    [
        'name' => 'RACO Integrated Services',
        'category' => 'Business & Economic Development',
        'description' => 'RACO Integrated Services is the business and economic arm of RACO Commission. Its activities include agricultural production and processing, gari production, farming, livestock, bakery operations, printing, estate development and sales, as well as property and estate maintenance. Through these activities, it contributes to the Commission’s economic and business operations.'
    ],
    [
        'name' => 'RACO Broadcasting Network (RBN)',
        'category' => 'Media, ICT & Public Relations',
        'description' => 'RACO Broadcasting Network is the media and ICT arm of RACO Commission. Its areas of focus include broadcasting, public awareness, public relations and public consultation services. It uses media and communication platforms to share information, promote awareness and support engagement with the public.'
    ]
];
?>

<style>
/* =========================================
   RACO COMMISSION ENTITY CARDS
========================================= */

.raco-entities {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
    margin-top: 35px;
}

.raco-entity-card {
    width: 100%;
    min-height: 190px;
    padding: 28px;
    text-align: left;
    font: inherit;
    color: inherit;
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    border: 1px solid rgba(0,0,0,.08);
    transition: transform .3s ease, box-shadow .3s ease,
                border-color .3s ease;
}

.raco-entity-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(0,0,0,.09);
    border-color: var(--r, #b28a45);
}

.raco-entity-card:focus-visible {
    outline: 3px solid var(--r, #b28a45);
    outline-offset: 4px;
}

.raco-entity-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(0,0,0,.055);
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 20px;
}

.raco-entity-card h3 {
    font-size: 19px;
    line-height: 1.4;
    margin: 0 0 16px;
}

.raco-entity-category {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .5px;
    opacity: .7;
    text-transform: uppercase;
}

.raco-entity-open {
    position: absolute;
    right: 25px;
    bottom: 25px;
    font-size: 21px;
    transition: transform .25s ease;
}

.raco-entity-card:hover .raco-entity-open {
    transform: translate(4px, -4px);
}

/* =========================================
   ENTITY MODAL
========================================= */

.raco-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(10, 17, 15, .78);
    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);
    opacity: 0;
    visibility: hidden;
    transition: opacity .25s ease, visibility .25s ease;
}

.raco-modal.is-open {
    opacity: 1;
    visibility: visible;
}

.raco-modal[hidden] {
    display: none;
}

.raco-modal-panel {
    width: min(100%, 620px);
    max-height: min(85vh, 700px);
    overflow-y: auto;
    position: relative;
    background: #fff;
    color: #222;
    border-radius: 18px;
    padding: 45px;
    transform: translateY(20px);
    transition: transform .3s ease;
    box-shadow: 0 25px 80px rgba(0,0,0,.25);
}

.raco-modal.is-open .raco-modal-panel {
    transform: translateY(0);
}

.raco-modal-close {
    position: absolute;
    top: 17px;
    right: 19px;
    width: 42px;
    height: 42px;
    border: 0;
    border-radius: 50%;
    background: #f1f1f1;
    color: #222;
    font-size: 25px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s ease, transform .2s ease;
}

.raco-modal-close:hover {
    background: #e4e4e4;
    transform: rotate(90deg);
}

.raco-modal-close:focus-visible {
    outline: 3px solid #b28a45;
    outline-offset: 3px;
}

.raco-modal-label {
    display: inline-block;
    margin-bottom: 18px;
    color: #a47b36;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.raco-modal-panel h2 {
    font-size: clamp(25px, 4vw, 34px);
    line-height: 1.3;
    margin: 0 0 20px;
}

.raco-modal-panel p {
    font-size: 16px;
    line-height: 1.9;
    color: #555;
    margin: 0;
}

.raco-modal-footer {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .7px;
    color: #888;
    text-transform: uppercase;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {
    .raco-entities {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 560px) {
    .raco-entities {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .raco-entity-card {
        min-height: 155px;
        padding: 23px;
    }

    .raco-entity-card h3 {
        font-size: 18px;
        max-width: 85%;
    }

    .raco-modal {
        padding: 12px;
        align-items: center;
    }

    .raco-modal-panel {
        padding: 55px 25px 30px;
        max-height: 88vh;
        border-radius: 15px;
    }

    .raco-modal-panel p {
        font-size: 15px;
        line-height: 1.8;
    }
}

@media (prefers-reduced-motion: reduce) {
    .raco-entity-card,
    .raco-entity-open,
    .raco-modal,
    .raco-modal-panel,
    .raco-modal-close {
        transition: none !important;
    }
}
</style>

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

<!-- RACO COMMISSION FAMILY -->
<section id="raco-family">
    <div class="wrap">
        <span class="bar"></span>
        <h2>The RACO Commission Family</h2>

        <p class="lead">
            RACO Commission brings together six interconnected entities,
            each contributing to the Commission's wider mission through
            care, education, healthcare, business, media and community
            development.
        </p>

        <div class="raco-entities">

            <?php foreach ($entityDetails as $index => $entity): ?>
                <button
                    type="button"
                    class="tile rv raco-entity-card"
                    data-entity-name="<?=h($entity['name'])?>"
                    data-entity-category="<?=h($entity['category'])?>"
                    data-entity-description="<?=h($entity['description'])?>"
                    aria-haspopup="dialog"
                    aria-label="Learn more about <?=h($entity['name'])?>"
                >
                    <span class="raco-entity-number">
                        <?=str_pad($index + 1, 2, '0', STR_PAD_LEFT)?>
                    </span>

                    <span>
                        <span class="raco-entity-category">
                            <?=h($entity['category'])?>
                        </span>

                        <h3><?=h($entity['name'])?></h3>
                    </span>

                    <span class="raco-entity-open" aria-hidden="true">
                        ↗
                    </span>
                </button>
            <?php endforeach; ?>

        </div>

        <p style="margin-top:24px">
            Together, these entities contribute to RACO Commission's
            commitment to care, education, welfare, economic development
            and service to society.
        </p>
    </div>
</section>

<!-- ENTITY DETAILS MODAL -->
<div
    class="raco-modal"
    id="racoEntityModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="racoModalTitle"
    aria-describedby="racoModalDescription"
    aria-hidden="true"
    hidden
>
    <div class="raco-modal-panel" role="document">

        <button
            type="button"
            class="raco-modal-close"
            id="racoModalClose"
            aria-label="Close entity details"
        >
            &times;
        </button>

        <span class="raco-modal-label" id="racoModalCategory">
            RACO Commission
        </span>

        <h2 id="racoModalTitle"></h2>

        <p id="racoModalDescription"></p>

        <div class="raco-modal-footer">
            Part of RACO Commission
        </div>

    </div>
</div>

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

<script>
(function () {
    'use strict';

    const modal = document.getElementById('racoEntityModal');

    if (!modal) return;

    const modalPanel = modal.querySelector('.raco-modal-panel');
    const closeButton = document.getElementById('racoModalClose');
    const modalTitle = document.getElementById('racoModalTitle');
    const modalCategory = document.getElementById('racoModalCategory');
    const modalDescription = document.getElementById('racoModalDescription');

    const entityCards = document.querySelectorAll('.raco-entity-card');

    let previousFocus = null;

    function openModal(card) {
        previousFocus = card;

        modalTitle.textContent = card.dataset.entityName || '';
        modalCategory.textContent = card.dataset.entityCategory || 'RACO Commission';
        modalDescription.textContent = card.dataset.entityDescription || '';

        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';

        requestAnimationFrame(function () {
            modal.classList.add('is-open');
            closeButton.focus();
        });
    }

    function closeModal() {
        if (modal.hidden) return;

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        modal.hidden = true;

        if (previousFocus) {
            previousFocus.focus();
        }
    }

    entityCards.forEach(function (card) {
        card.addEventListener('click', function () {
            openModal(card);
        });
    });

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (modal.hidden) return;

        if (event.key === 'Escape') {
            event.preventDefault();
            closeModal();
            return;
        }

        // Keep keyboard focus inside the open dialog.
        if (event.key === 'Tab') {
            const focusable = modalPanel.querySelectorAll(
                'button:not([disabled]), a[href], input:not([disabled]), ' +
                'select:not([disabled]), textarea:not([disabled]), ' +
                '[tabindex]:not([tabindex="-1"])'
            );

            if (!focusable.length) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });

})();
</script>

<?php require 'includes/footer.php'; ?>
