
<?php
$title = 'Our Scholars';

require_once __DIR__ . '/includes/header.php';

// Find a spreadsheet column using possible heading names
function find_column($headers, $keywords, $exclude = []) {
    foreach ($headers as $index => $header) {
        $header = strtolower(trim((string)$header));

        foreach ($keywords as $keyword) {
            if (strpos($header, strtolower($keyword)) !== false) {
                $excluded = false;

                foreach ($exclude as $word) {
                    if (strpos($header, strtolower($word)) !== false) {
                        $excluded = true;
                        break;
                    }
                }

                if (!$excluded) {
                    return $index;
                }
            }
        }
    }

    return null;
}

$sheetUrl = $S['sheet'] ?? '';
$rows = sheet_rows($sheetUrl);

$scholars = [];
$errorMessage = '';

if (count($rows) > 1) {
    $headers = array_shift($rows);

    $nameCol = find_column($headers, ['name', 'full name', 'student']);
    $schoolCol = find_column($headers, ['school', 'institution', 'university']);
    $courseCol = find_column($headers, ['course', 'department', 'programme']);
    $levelCol = find_column($headers, ['level', 'class', 'year']);
    $storyCol = find_column($headers, ['story', 'about', 'description']);
    $photoCol = find_column($headers, ['photo', 'picture', 'image']);
    $approvalCol = find_column($headers, ['approval', 'approved', 'status']);

    if ($nameCol === null) {
        $errorMessage = 'The Name column could not be found in the spreadsheet.';
    } elseif ($approvalCol === null) {
        $errorMessage = 'An Approval column is required. Add one to your Google Sheet and mark approved scholars as Yes.';
    } else {
        foreach ($rows as $row) {
            $name = trim($row[$nameCol] ?? '');
            $approval = strtolower(trim($row[$approvalCol] ?? ''));

            // Only display scholars approved for publication
            if ($name === '' || !in_array($approval, ['yes', 'approved', 'true'], true)) {
                continue;
            }

            $scholars[] = [
                'name'  => $name,
                'school' => $schoolCol !== null ? trim($row[$schoolCol] ?? '') : '',
                'course' => $courseCol !== null ? trim($row[$courseCol] ?? '') : '',
                'level' => $levelCol !== null ? trim($row[$levelCol] ?? '') : '',
                'story' => $storyCol !== null ? trim($row[$storyCol] ?? '') : '',
                'photo' => $photoCol !== null ? drive_img($row[$photoCol] ?? '') : ''
            ];
        }
    }
} else {
    $errorMessage = 'The scholars spreadsheet could not be loaded. Please check the published Google Sheets link.';
}
?>

<style>
.scholar-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 65px 20px;
}

.scholar-intro {
    max-width: 700px;
    margin: 0 auto 40px;
    text-align: center;
}

.scholar-intro h1 {
    font-size: clamp(2rem, 5vw, 3rem);
    margin-bottom: 12px;
}

.scholar-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.scholar-card {
    overflow: hidden;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 25px rgba(0,0,0,.08);
}

.scholar-card img,
.scholar-photo-placeholder {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
}

.scholar-photo-placeholder {
    background: #f0f2ed;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #64705e;
}

.scholar-info {
    padding: 22px;
}

.scholar-info h3 {
    margin: 0 0 10px;
    font-size: 1.25rem;
}

.scholar-info p {
    margin: 7px 0;
    line-height: 1.6;
}

.scholar-error,
.no-scholars {
    text-align: center;
    padding: 25px;
    background: #f8f8f4;
    border-radius: 12px;
}

.scholar-error {
    color: #9b2c2c;
}
</style>

<main class="scholar-section">

    <div class="scholar-intro">
        <h1>Our Scholars</h1>
        <p>
            Meet the students whose educational journeys are supported
            through the work and commitment of RACO.
        </p>
    </div>

    <?php if ($errorMessage !== ''): ?>

        <div class="scholar-error">
            <?= h($errorMessage) ?>
        </div>

    <?php elseif (empty($scholars)): ?>

        <div class="no-scholars">
            <h3>No approved scholars to display yet.</h3>
            <p>Please check back later.</p>
        </div>

    <?php else: ?>

        <div class="scholar-grid">

            <?php foreach ($scholars as $scholar): ?>

                <article class="scholar-card">

                    <?php if ($scholar['photo'] !== ''): ?>

                        <img
                            src="<?= h($scholar['photo']) ?>"
                            alt="<?= h($scholar['name']) ?>"
                            loading="lazy"
                        >

                    <?php else: ?>

                        <div class="scholar-photo-placeholder">
                            Scholar Photo
                        </div>

                    <?php endif; ?>

                    <div class="scholar-info">

                        <h3><?= h($scholar['name']) ?></h3>

                        <?php if ($scholar['school'] !== ''): ?>
                            <p><strong>Institution:</strong>
                                <?= h($scholar['school']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($scholar['course'] !== ''): ?>
                            <p><strong>Course:</strong>
                                <?= h($scholar['course']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($scholar['level'] !== ''): ?>
                            <p><strong>Level:</strong>
                                <?= h($scholar['level']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($scholar['story'] !== ''): ?>
                            <p><?= nl2br(h($scholar['story'])) ?></p>
                        <?php endif; ?>

                    </div>
                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
