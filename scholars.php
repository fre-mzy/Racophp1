
<?php
$title = 'Our Scholars';
require 'includes/header.php';

/**
 * Convert Google Drive photo links into displayable image URLs.
 * Supports Google Forms upload links and normal image URLs.
 */
function drive_img($value) {
    $value = trim((string)$value);

    if ($value === '') {
        return '';
    }

    // If multiple files are uploaded, use the first link.
    $links = preg_split('/,\s*(?=https?:\/\/)/i', $value);
    $value = trim($links[0] ?? '');

    if ($value === '') {
        return '';
    }

    $id = '';

    // Google Drive: /file/d/FILE_ID/view
    if (preg_match('~/(?:file/)?d/([a-zA-Z0-9_-]+)~', $value, $match)) {
        $id = $match[1];
    }
    // Google Drive: ?id=FILE_ID
    elseif (preg_match('~[?&]id=([a-zA-Z0-9_-]+)~', $value, $match)) {
        $id = $match[1];
    }

    if ($id !== '') {
        return 'https://drive.google.com/thumbnail?id=' .
            rawurlencode($id) . '&sz=w1000';
    }

    // Accept ordinary HTTP/HTTPS image links.
    if (
        filter_var($value, FILTER_VALIDATE_URL) &&
        in_array(
            strtolower(parse_url($value, PHP_URL_SCHEME)),
            ['http', 'https'],
            true
        )
    ) {
        return $value;
    }

    return '';
}

/**
 * Find a Google Sheet column using its heading.
 */
function scholar_column($headers, $keywords, $exclude = []) {
    foreach ($headers as $index => $heading) {
        foreach ($exclude as $word) {
            if (strpos($heading, $word) !== false) {
                continue 2;
            }
        }

        foreach ($keywords as $word) {
            if (strpos($heading, $word) !== false) {
                return $index;
            }
        }
    }

    return -1;
}

// sheet_rows() is already declared in includes/config.php.
$rows = sheet_rows($S['sheet'] ?? '');
$cards = [];

if (is_array($rows) && count($rows) > 1) {

    $headers = array_map(
        function ($heading) {
            return strtolower(trim((string)$heading));
        },
        array_shift($rows)
    );

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
        ['course', 'programme', 'department']
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
        ['approved', 'approve']
    );

    foreach ($rows as $row) {

        // Only display students approved by RACO.
        if ($approvalColumn < 0 || $nameColumn < 0) {
            continue;
        }

        $approval = strtolower(
            trim($row[$approvalColumn] ?? '')
        );

        if ($approval !== 'yes') {
            continue;
        }

        $name = trim($row[$nameColumn] ?? '');

        if ($name === '') {
            continue;
        }

        $cards[] = [
            'n' => $name,

            's' => $schoolColumn >= 0
                ? trim($row[$schoolColumn] ?? '')
                : '',

            'c' => $courseColumn >= 0
                ? trim($row[$courseColumn] ?? '')
                : '',

            'l' => $levelColumn >= 0
                ? trim($row[$levelColumn] ?? '')
                : '',

            'b' => $storyColumn >= 0
                ? trim($row[$storyColumn] ?? '')
                : '',

            'p' => $photoColumn >= 0
                ? drive_img($row[$photoColumn] ?? '')
                : ''
        ];
    }
}
?>

<style>
.sch {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
}

.sch .mem {
    min-width: 0;
    overflow: hidden;
}

.sch .pt {
    width: 100%;
    height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    object-fit: cover;
    border-radius: 12px;
    background: #f1f3f2;
}

.sch .ph {
    color: #64736b;
    text-align: center;
    padding: 15px;
}

.sch .mem > b {
    display: block;
    margin-top: 14px;
}

.sch .mem > span {
    display: block;
    margin-top: 5px;
}

.sch details {
    margin-top: 12px;
}

.sch summary {
    cursor: pointer;
    font-weight: 600;
}

.sch details p {
    margin-top: 8px;
}

@media (max-width: 600px) {
    .sch {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .sch .pt {
        height: 190px;
    }
}
</style>

<!-- PAGE INTRODUCTION -->
<div class="page">
    <div class="wrap">
        <span class="bar"></span>

        <h1>Our Scholars</h1>

        <p class="lead">
            The young people RACO is helping to learn, and the stories behind them.
            Each profile is shared with the consent of the student or their guardian.
        </p>
    </div>
</div>

<!-- SCHOLAR PROFILES -->
<section>
    <div class="wrap">

        <?php if (!empty($cards)): ?>

            <div class="tm sch">

                <?php foreach ($cards as $c): ?>

                    <div class="mem rv">

                        <?php if (!empty($c['p'])): ?>

                            <img
                                class="pt"
                                src="<?= h($c['p']) ?>"
                                alt="<?= h($c['n']) ?>"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div class="ph pt" style="display:none">
                                <span>Photo unavailable</span>
                            </div>

                        <?php else: ?>

                            <div class="ph pt">
                                <span>No photo uploaded</span>
                            </div>

                        <?php endif; ?>

                        <b><?= h($c['n']) ?></b>

                        <?php
                        if ($c['c'] || $c['l']) {
                            $details = trim(
                                $c['c'] .
                                ($c['c'] && $c['l'] ? ', ' : '') .
                                $c['l']
                            );

                            echo '<span>' . h($details) . '</span>';
                        }

                        if ($c['s']) {
                            echo '<span>' . h($c['s']) . '</span>';
                        }
                        ?>

                        <?php if (!empty($c['b'])): ?>

                            <details>
                                <summary>Read their story</summary>

                                <p><?= nl2br(h($c['b'])) ?></p>
                            </details>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <p class="lead">
                Student profiles are coming soon. Check back shortly.
            </p>

        <?php endif; ?>

    </div>
</section>

<!-- SUPPORT CTA -->
<section class="cta">
    <div class="wrap rv">

        <h2>Help a child reach the next class</h2>

        <p>
            Sponsor a student's education, books and school fees.
        </p>

        <a class="btn btn-r" href="support.php">
            Sponsor a student
        </a>

    </div>
</section>

<?php require 'includes/footer.php'; ?>
