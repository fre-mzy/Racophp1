
<?php
$title = 'Our Scholars';
require 'includes/header.php';

/*
|--------------------------------------------------------------------------
| RACO PUBLIC SCHOLARS
|--------------------------------------------------------------------------
| This page reads ONLY the published Public Scholars Google Sheet.
| The private Google Forms response sheet is not accessed here.
|
| Expected columns:
| Name | Photo | Course of Study | Level | Institution |
| Faculty/Department
|--------------------------------------------------------------------------
*/

$publicScholarsCsvUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vR9m6VlnqMmkEw_oi9vXLDzgIeUPxp3uULTF9BtmqpauwsCys061pOn4SRtC7CdQaghzlnw5nOSXrpO/pub?gid=651312413&single=true&output=csv';

$scholars = [];
$scholarsError = false;

/*
|--------------------------------------------------------------------------
| FETCH CSV DATA
|--------------------------------------------------------------------------
*/

$cacheFile = sys_get_temp_dir() . '/raco_public_scholars.csv';
$cacheDuration = 300; // 5 minutes

$csvContent = false;
$cacheIsFresh = (
    file_exists($cacheFile) &&
    (time() - filemtime($cacheFile)) < $cacheDuration
);

if ($cacheIsFresh) {
    $csvContent = @file_get_contents($cacheFile);
} else {

    $context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'user_agent' => 'RACO-Scholars-Website/1.0',
            'follow_location' => 1
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true
        ]
    ]);

    $csvContent = @file_get_contents(
        $publicScholarsCsvUrl,
        false,
        $context
    );

    // cURL fallback if URL file access is unavailable.
    if (
        ($csvContent === false || $csvContent === '') &&
        function_exists('curl_init')
    ) {
        $ch = curl_init($publicScholarsCsvUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'RACO-Scholars-Website/1.0',
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $csvContent = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($csvContent === false || $httpCode >= 400) {
            $csvContent = false;
        }

        curl_close($ch);
    }
}

/*
|--------------------------------------------------------------------------
| READ AND VALIDATE CSV
|--------------------------------------------------------------------------
*/

if ($csvContent !== false && trim($csvContent) !== '') {

    $stream = fopen('php://temp', 'r+');

    if ($stream !== false) {

        fwrite($stream, $csvContent);
        rewind($stream);

        $headers = fgetcsv($stream);

        if ($headers !== false) {

            // Remove UTF-8 BOM and normalize headings.
            $headers = array_map(function ($header) {
                $header = preg_replace('/^\xEF\xBB\xBF/', '', (string)$header);
                return strtolower(trim($header));
            }, $headers);

            $columns = [
                'name' => array_search('name', $headers, true),
                'photo' => array_search('photo', $headers, true),
                'course' => array_search('course of study', $headers, true),
                'level' => array_search('level', $headers, true),
                'institution' => array_search('institution', $headers, true),
                'faculty' => array_search('faculty/department', $headers, true)
            ];

            $headersValid = true;

            foreach ($columns as $index) {
                if ($index === false) {
                    $headersValid = false;
                    break;
                }
            }

            if ($headersValid) {

                // Cache only a CSV with the expected headings.
                if (!$cacheIsFresh) {
                    @file_put_contents($cacheFile, $csvContent);
                }

                while (($row = fgetcsv($stream)) !== false) {

                    $person = [];

                    foreach ($columns as $key => $index) {
                        $person[$key] = trim(
                            (string)($row[$index] ?? '')
                        );
                    }

                    // Ignore empty records.
                    if ($person['name'] === '') {
                        continue;
                    }

                    $scholars[] = $person;
                }

            } else {
                $scholarsError = true;
            }

        } else {
            $scholarsError = true;
        }

        fclose($stream);

    } else {
        $scholarsError = true;
    }

} else {
    $scholarsError = true;
}

/*
|--------------------------------------------------------------------------
| GOOGLE DRIVE IMAGE CONVERTER
|--------------------------------------------------------------------------
| Supports:
| https://drive.google.com/open?id=FILE_ID
| https://drive.google.com/file/d/FILE_ID/view
| https://drive.google.com/uc?id=FILE_ID
|--------------------------------------------------------------------------
*/

$scholarImageUrl = function ($value) {

    $value = trim((string)$value);

    if ($value === '') {
        return '';
    }

    $fileId = '';

    if (preg_match('~/d/([a-zA-Z0-9_-]+)~', $value, $match)) {
        $fileId = $match[1];

    } elseif (
        preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $value, $match)
    ) {
        $fileId = $match[1];
    }

    if ($fileId !== '') {
        return 'https://drive.google.com/thumbnail?id=' .
            rawurlencode($fileId) . '&sz=w1000';
    }

    if (filter_var($value, FILTER_VALIDATE_URL)) {

        $scheme = strtolower(
            (string)parse_url($value, PHP_URL_SCHEME)
        );

        if (in_array($scheme, ['http', 'https'], true)) {
            return $value;
        }
    }

    return '';
};

/*
|--------------------------------------------------------------------------
| NYSC CORPS MEMBERS
|--------------------------------------------------------------------------
| This section remains separate until approved NYSC profiles are added.
|--------------------------------------------------------------------------
*/

$corpsMembers = [
    [
        'name' => 'NYSC profiles coming soon',
        'type' => 'NYSC Corps Members',
        'achievement' => 'Approved service profiles and highlights will be added here.'
    ]
];

?>

<!-- PAGE INTRODUCTION -->

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

<!-- INTRODUCTION SECTION -->

<section>
    <div class="wrap split">

        <div class="rv">

            <span class="bar"></span>

            <h2>Investing in education and opportunity</h2>

            <p class="lead">
                Education can open doors to opportunity, independence
                and meaningful contribution to society.
            </p>

            <p>
                This page recognises university scholars and National
                Youth Service Corps members associated with RACO.
                It celebrates their educational journeys, academic
                progress and contributions to the community.
            </p>

            <p>
                Our aim is to celebrate progress, encourage younger
                learners and recognise the importance of continued
                learning and community service.
            </p>

            <a class="btn btn-b" href="support.php">
                Support our work
            </a>

        </div>

        <div class="rv">

            <?=photo(
                'group-photo.jpg',
                'RACO community members'
            )?>

        </div>

    </div>
</section>

<!-- UNIVERSITY SCHOLARS -->

<section class="alt" id="university-scholars">

    <div class="wrap">

        <span class="bar"></span>

        <h2>University scholars</h2>

        <p class="lead">
            Recognising students pursuing higher education and
            developing the knowledge and skills to contribute to society.
        </p>

        <?php if ($scholarsError): ?>

            <div class="scholar-message">

                <h3>Scholar profiles are being updated</h3>

                <p>
                    We are currently unable to retrieve the scholar
                    records. Please check back soon.
                </p>

            </div>

        <?php elseif (empty($scholars)): ?>

            <div class="scholar-message">

                <h3>No approved profiles available yet</h3>

                <p>
                    Approved scholar profiles will appear here once
                    they are available.
                </p>

            </div>

        <?php else: ?>

            <div class="scholar-count">
                <?=count($scholars)?> approved
                <?=count($scholars) === 1 ? 'scholar' : 'scholars'?>
            </div>

            <div class="scholar-grid">

                <?php foreach ($scholars as $person): ?>

                    <?php
                    $image = $scholarImageUrl($person['photo']);
                    ?>

                    <article class="scholar-card rv">

                        <div class="scholar-image-wrap">

                            <?php if ($image !== ''): ?>

                                <img
                                    class="scholar-photo"
                                    src="<?=h($image)?>"
                                    alt="<?=h($person['name'])?>"
                                    loading="lazy"
                                    referrerpolicy="no-referrer"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                >

                                <div
                                    class="scholar-placeholder"
                                    style="display:none"
                                >
                                    <span>Photograph unavailable</span>
                                </div>

                            <?php else: ?>

                                <div class="scholar-placeholder">
                                    <span>Photograph unavailable</span>
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="scholar-details">

                            <span class="scholar-type">
                                University Scholar
                            </span>

                            <h3>
                                <?=h($person['name'])?>
                            </h3>

                            <div class="scholar-info">

                                <p>
                                    <b>Institution</b>
                                    <span>
                                        <?=h($person['institution'])?>
                                    </span>
                                </p>

                                <p>
                                    <b>Faculty/Department</b>
                                    <span>
                                        <?=h($person['faculty'])?>
                                    </span>
                                </p>

                                <p>
                                    <b>Course of Study</b>
                                    <span>
                                        <?=h($person['course'])?>
                                    </span>
                                </p>

                                <p>
                                    <b>Level</b>
                                    <span>
                                        <?=h($person['level'])?>
                                    </span>
                                </p>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<!-- NYSC CORPS MEMBERS -->

<section id="nysc-corps-members">

    <div class="wrap">

        <span class="bar"></span>

        <h2>NYSC corps members</h2>

        <p class="lead">
            Recognising service, responsibility, skills development
            and contributions to communities.
        </p>

        <div class="scholar-grid">

            <?php foreach ($corpsMembers as $person): ?>

                <article class="scholar-card rv">

                    <div class="scholar-placeholder">
                        <span>Corps member profile</span>
                        <small>Profile coming soon</small>
                    </div>

                    <div class="scholar-details">

                        <span class="scholar-type">
                            <?=h($person['type'])?>
                        </span>

                        <h3>
                            <?=h($person['name'])?>
                        </h3>

                        <p>
                            <?=h($person['achievement'])?>
                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<!-- CALL TO ACTION -->

<section class="cta">

    <div class="wrap rv">

        <h2>Help create more opportunities</h2>

        <p>
            Your support can help strengthen educational opportunities
            and the wellbeing of children and young people.
        </p>

        <a class="btn btn-r" href="support.php">
            Support RACO
        </a>

        <a class="btn btn-o" href="contact.php">
            Partner with us
        </a>

    </div>

</section>

<!-- PAGE STYLES -->

<style>
}
    
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

.scholar-image-wrap {
    width: 100%;
    overflow: hidden;
    background: rgba(128, 128, 128, .10);
}


/* Scholar photograph display */
.scholar-photo {
    display: block;
    width: 100%;
    aspect-ratio: 4 / 5;
    object-fit: contain;
    object-position: center;
    background: var(--alt);
}

/* Photograph placeholder */
.scholar-placeholder {
    display: flex;
    width: 100%;
    aspect-ratio: 4 / 5;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 20px;
    text-align: center;
    background: rgba(128, 128, 128, .10);
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
    margin-bottom: 18px;
}

.scholar-info p {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin: 0 0 14px;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.scholar-info p b {
    font-size: .9rem;
}

.scholar-info p span {
    opacity: .85;
}

.scholar-count {
    margin-top: 22px;
    font-weight: 700;
    opacity: .8;
}

.scholar-message {
    margin-top: 25px;
    padding: 28px;
    border: 1px solid rgba(128, 128, 128, .25);
    border-radius: 12px;
    text-align: center;
}

.scholar-message h3 {
    margin-top: 0;
}

.scholar-message p {
    margin-bottom: 0;
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
