
<?php
$title = 'Our Scholars';
require 'includes/header.php';

/**
 * Fetches the published Google Sheet CSV.
 * The result is cached for 10 minutes.
 */
function sheet_rows($url) {
    if (empty($url)) {
        return [];
    }

    $cache = sys_get_temp_dir() . '/raco_scholars.csv';

    if (!is_file($cache) || (time() - filemtime($cache)) > 600) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'follow_location' => 1,
                'user_agent' => 'RACO-Scholars-Website/1.0'
            ]
        ]);

        $data = @file_get_contents($url, false, $context);

        if ($data !== false && strlen($data) > 10) {
            file_put_contents($cache, $data);
        }
    }

    if (!is_file($cache)) {
        return [];
    }

    $file = fopen($cache, 'r');

    if (!$file) {
        return [];
    }

    $rows = [];

    while (($row = fgetcsv($file, 0, ',', '"', '')) !== false) {
        $rows[] = $row;
    }

    fclose($file);

    return $rows;
}

/**
 * Converts Google Drive and ordinary image links
 * into browser-displayable image URLs.
 */
function drive_img($value) {
    $value = trim((string)$value);

    if ($value === '') {
        return '';
    }

    // Google Forms may return more than one uploaded file.
    $links = preg_split('/,\s*(?=https?:\/\/)/i', $value);
    $value = trim($links[0] ?? '');

    if ($value === '') {
        return '';
    }

    $id = '';

    // Google Drive file links:
    // drive.google.com/file/d/FILE_ID/view
    // drive.google.com/uc?id=FILE_ID
    // drive.google.com/open?id=FILE_ID
    // drive.google.com/thumbnail?id=FILE_ID
    if (preg_match('~/(?:file/)?d/([a-zA-Z0-9_-]+)~', $value, $match)) {
        $id = $match[1];
    } elseif (preg_match('~[?&]id=([a-zA-Z0-9_-]+)~', $value, $match)) {
        $id = $match[1];
    }

    if ($id !== '') {
        return 'https://drive.google.com/thumbnail?id=' .
            rawurlencode($id) . '&sz=w1000';
    }

    // Accept ordinary HTTPS image URLs.
    if (
        filter_var($value, FILTER_VALIDATE_URL) &&
        in_array(strtolower(parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true)
    ) {
        return $value;
    }

    return '';
}

/**
 * Finds a column using its heading.
 */
function find_column($headers, $keywords, $exclude = []) {
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

/**
 * Load scholar records.
 */
$rows = sheet_rows($S['sheet'] ?? 'https://docs.google.com/spreadsheets/d/e/2PACX-1vR9m6VlnqMmkEw_oi9vXLDzgIeUPxp3uULTF9BtmqpauwsCys061pOn4SRtC7CdQaghzlnw5nOSXrpO/pub?gid=656297882&single=true&output=csv');
$cards = [];

if (count($rows) > 1) {
    $headers = array_map(
        function ($heading) {
            return strtolower(trim((string)$heading));
        },
        array_shift($rows)
    );

    $nameColumn = find_column(
        $headers,
        ['name'],
        ['school', 'institution', 'course']
    );

    $schoolColumn = find_column($headers, ['institution', 'school', 'university']);
    $courseColumn = find_column($headers, ['course', 'programme', 'department']);
    $levelColumn = find_column($headers, ['level', 'year', 'class']);
    $storyColumn = find_column($headers, ['story', 'background', 'about']);
    $photoColumn = find_column($headers, ['picture', 'photo', 'image', 'upload']);
    $approvalColumn = find_column($headers, ['approved', 'approve']);

    foreach ($rows as $row) {
        // Only display students approved by RACO.
        if ($approvalColumn < 0 || $nameColumn < 0) {
            continue;
        }

        $approval = strtolower(trim($row[$approvalColumn] ?? ''));

        if ($approval !== 'yes') {
            continue;
        }

        $name = trim($row[$nameColumn] ?? '');

        if ($name === '') {
            continue;
        }

        $course = $courseColumn >= 0
            ? trim($row[$courseColumn] ?? '')
            : '';

        $level = $levelColumn >= 0
            ? trim($row[$levelColumn] ?? '')
            : '';

        $cards[] = [
            'n' => $name,
            's' => $schoolColumn >= 0
                ? trim($row[$schoolColumn] ?? '')
                : '',
            'c' => $course,
            'l' => $level,
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
</style>

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

