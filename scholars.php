
<?php
$title = 'Our Scholars';

require 'includes/header.php';

/*
 * IMPORTANT:
 * sheet_rows() and drive_img() are already defined
 * in includes/config.php. Do not redeclare them here.
 */

/**
 * Find a Google Sheet column by its heading.
 */
function scholar_column($headers, $keywords, $exclude = [])
{
    foreach ($headers as $index => $heading) {
        $heading = strtolower(trim((string) $heading));

        foreach ($exclude as $word) {
            if (strpos($heading, strtolower($word)) !== false) {
                continue 2;
            }
        }

        foreach ($keywords as $word) {
            if (strpos($heading, strtolower($word)) !== false) {
                return $index;
            }
        }
    }

    return -1;
}

/**
 * Load scholar records from the published Google Sheet.
 */
$rows = sheet_rows($S['sheet'] ?? '');
$cards = [];

if (is_array($rows) && count($rows) > 1) {

    // Clean and normalize the column headings.
    $headers = array_map(function ($heading) {
        return strtolower(trim((string) $heading));
    }, $rows[0]);

    // Identify the relevant columns.
    $nameColumn = scholar_column(
        $headers,
        ['name'],
        ['school', 'institution', 'course']
    );

    $schoolColumn = scholar_column(
        $headers,
        ['institution', 'school', 'university']
    );

    $courseColumn = scholar_column(
        $headers,
        ['course', 'programme', 'program', 'department']
    );

    $levelColumn = scholar_column(
        $headers,
        ['level', 'year', 'class']
    );

    $storyColumn = scholar_column(
        $headers,
        ['story', 'background', 'about']
    );

    $photoColumn = scholar_column(
        $headers,
        ['picture', 'photo', 'image', 'upload']
    );

    $approvalColumn = scholar_column(
        $headers,
        ['approved', 'approval', 'approve']
    );

    // Process submitted records.
    foreach (array_slice($rows, 1) as $row) {

        $name = $nameColumn >= 0
            ? trim((string) ($row[$nameColumn] ?? ''))
            : '';

        if ($name === '') {
            continue;
        }

        // Only display approved scholars.
        if ($approvalColumn >= 0) {
            $approval = strtolower(
                trim((string) ($row[$approvalColumn] ?? ''))
            );

            if (!in_array($approval, ['yes', 'approved', 'true', '1'], true)) {
                continue;
            }
        }

        $school = $schoolColumn >= 0
            ? trim((string) ($row[$schoolColumn] ?? ''))
            : '';

        $course = $courseColumn >= 0
            ? trim((string) ($row[$courseColumn] ?? ''))
            : '';

        $level = $levelColumn >= 0
            ? trim((string) ($row[$levelColumn] ?? ''))
            : '';

        $story = $storyColumn >= 0
            ? trim((string) ($row[$storyColumn] ?? ''))
            : '';

        $photoValue = $photoColumn >= 0
            ? trim((string) ($row[$photoColumn] ?? ''))
            : '';

        // Convert Google Drive links into displayable image URLs.
        $photo = $photoValue !== ''
            ? drive_img($photoValue)
            : '';

        $cards[] = [
            'n' => $name,
            's' => $school,
            'c' => $course,
            'l' => $level,
            'b' => $story,
            'p' => $photo
        ];
    }
}
?>

<style>
.sch-page {
    padding: 65px 0 85px;
}

.sch-intro {
    max-width: 760px;
    margin: 0 auto 45px;
    text-align: center;
}

.sch-intro h1 {
    font-size: clamp(2rem, 5vw, 3.3rem);
    margin-bottom: 15px;
    line-height: 1.15;
}

.sch-intro p {
    color: var(--muted, #667085);
    line-height: 1.8;
}

.sch-count {
    display: inline-block;
    margin-top: 15px;
    padding: 8px 16px;
    border-radius: 30px;
    background: #edf6ef;
    color: #236b3b;
    font-size: .9rem;
    font-weight: 700;
}

.sch-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 25px;
}

.sch-card {
    overflow: hidden;
    border-radius: 17px;
    background: #fff;
    border: 1px solid #e8e8e8;
    box-shadow: 0 7px 25px rgba(0,0,0,.055);
    transition: transform .25s ease, box-shadow .25s ease;
}

.sch-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 13px 32px rgba(0,0,0,.10);
}

.sch-photo {
    height: 260px;
    background: #edf2ed;
    overflow: hidden;
}

.sch-photo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.sch-photo-fallback {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 20px;
    text-align: center;
    color: #47704e;
    background: linear-gradient(135deg, #e7f0e7, #f5f7f2);
}

.sch-photo-fallback span {
    font-size: 3rem;
    margin-bottom: 10px;
}

.sch-body {
    padding: 23px;
}

.sch-body h3 {
    font-size: 1.2rem;
    margin: 0 0 10px;
    color: #1d3524;
}

.sch-meta {
    color: #47704e;
    font-size: .9rem;
    line-height: 1.7;
    margin-bottom: 12px;
}

.sch-story {
    color: #667085;
    font-size: .92rem;
    line-height: 1.75;
    overflow-wrap: anywhere;
}

.sch-empty {
    max-width: 650px;
    margin: 35px auto;
    padding: 35px 25px;
    text-align: center;
    border-radius: 16px;
    background: #f5f8f5;
}

.sch-empty h3 {
    margin-bottom: 10px;
}

.sch-empty p {
    color: #667085;
    line-height: 1.7;
}

.sch-cta {
    margin-top: 65px;
    padding: 40px 25px;
    text-align: center;
    border-radius: 18px;
    background: #173d25;
    color: #fff;
}

.sch-cta h2 {
    margin-bottom: 12px;
}

.sch-cta p {
    max-width: 600px;
    margin: 0 auto 22px;
    line-height: 1.7;
    color: rgba(255,255,255,.85);
}

.sch-cta a {
    display: inline-block;
    padding: 13px 24px;
    border-radius: 7px;
    background: #fff;
    color: #173d25;
    font-weight: 700;
    text-decoration: none;
}

@media (max-width: 900px) {
    .sch-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {
    .sch-page {
        padding: 42px 0 60px;
    }

    .sch-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .sch-photo {
        height: 280px;
    }

    .sch-cta {
        padding: 32px 20px;
    }
}
</style>

<main class="sch-page">
    <div class="wrap">

        <section class="sch-intro">
            <h1>Our University Scholars</h1>

            <p>
                Meet the students whose educational journeys are being
                supported through RACO. Every scholar represents hope,
                opportunity and a future worth investing in.
            </p>

            <div class="sch-count">
                <?= count($cards) ?>
                <?= count($cards) === 1 ? 'Approved Scholar' : 'Approved Scholars' ?>
            </div>
        </section>

        <?php if (!empty($cards)): ?>

            <section class="sch-grid">

                <?php foreach ($cards as $c): ?>

                    <article class="sch-card">

                        <div class="sch-photo">

                            <?php if (!empty($c['p'])): ?>

                                <img
                                    src="<?= h($c['p']) ?>"
                                    alt="<?= h($c['n']) ?>"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                >

                                <div class="sch-photo-fallback" style="display:none">
                                    <span>🎓</span>
                                    <strong><?= h($c['n']) ?></strong>
                                    <small>Scholar photograph unavailable</small>
                                </div>

                            <?php else: ?>

                                <div class="sch-photo-fallback">
                                    <span>🎓</span>
                                    <strong><?= h($c['n']) ?></strong>
                                    <small>Scholar photograph coming soon</small>
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="sch-body">

                            <h3><?= h($c['n']) ?></h3>

                            <div class="sch-meta">

                                <?php if ($c['s'] !== ''): ?>
                                    <div>
                                        <strong>Institution:</strong>
                                        <?= h($c['s']) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($c['c'] !== ''): ?>
                                    <div>
                                        <strong>Course:</strong>
                                        <?= h($c['c']) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($c['l'] !== ''): ?>
                                    <div>
                                        <strong>Level:</strong>
                                        <?= h($c['l']) ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <?php if ($c['b'] !== ''): ?>
                                <p class="sch-story">
                                    <?= nl2br(h($c['b'])) ?>
                                </p>
                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </section>

        <?php else: ?>

            <div class="sch-empty">
                <h3>Scholar profiles are being updated</h3>

                <p>
                    Our scholars' profiles will appear here once their
                    information has been submitted and approved.
                    Please check back soon.
                </p>
            </div>

        <?php endif; ?>

        <section class="sch-cta">
            <h2>Help a Student Go Further</h2>

            <p>
                Your support can help provide access to education and
                create opportunities for children and young people.
            </p>

            <a href="support.php">Support Our Mission</a>
        </section>

    </div>
</main>

<?php require 'includes/footer.php'; ?>
