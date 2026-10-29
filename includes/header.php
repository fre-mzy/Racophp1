
<?php
require_once __DIR__ . '/config.php';

$cur = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$home = $cur === 'index.php';

$nav = [
    'index.php' => 'Home',
    'about.php' => 'About',
    'programmes.php' => 'Our work',
    'gallery.php' => 'Gallery',
    'scholars.php' => 'Our Scholars',
    'contact.php' => 'Contact'
];

$pageTitle = trim($title ?? 'Home');
$siteName = $S['n'] ?? 'RACO Commission';
$siteSubtitle = $S['s'] ?? 'Child and Rural Care Initiative';

$descriptions = [
    'index.php' => 'Discover RACO Commission and its work supporting vulnerable children, education and rural community development.',
    'about.php' => 'Learn about RACO Child Orphanage, RACO Commission, its mission, people and community initiatives.',
    'programmes.php' => 'Explore RACO programmes supporting children, education, healthcare and rural community empowerment.',
    'gallery.php' => 'View photographs and moments from RACO activities, schools and community outreach.',
    'scholars.php' => 'Discover the RACO scholars and NYSC page celebrating education, development and community service.',
    'contact.php' => 'Contact RACO Commission about support, volunteering, partnerships and enquiries.',
    'support.php' => 'Find out how to support RACO and its work with children and rural communities.'
];

$description = $descriptions[$cur]
    ?? 'Learn about RACO Commission, its work, programmes and community initiatives.';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?=h($description)?>">

    <title><?=h($pageTitle)?> | <?=h($siteName)?>, <?=h($siteSubtitle)?></title>

    <link rel="icon" href="assets/img/logo.png">

    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">

    <noscript>
        <style>
            .rv {
                opacity: 1;
                transform: none;
            }

            #pre {
                display: none;
            }
        </style>
    </noscript>
</head>

<body>
    <div id="pre" aria-hidden="true">
        <img src="assets/img/logo.png" alt="">
        <i></i>
    </div>

    <header<?= $home ? '' : ' class="solid"' ?>>
        <div class="wrap nav">

            <a class="brand" href="index.php" aria-label="<?=h($siteName)?> home">
                <img src="assets/img/logo.png" alt="">
                <span>
                    <?=h($siteName)?>
                    <small><?=h($siteSubtitle)?></small>
                </span>
            </a>

            <button
                class="burger"
                type="button"
                aria-label="Open navigation menu"
                aria-expanded="false"
                aria-controls="site-nav"
            >
                Menu
            </button>

            <nav id="site-nav" aria-label="Main navigation">
                <?php foreach ($nav as $file => $label): ?>
                    <a
                        href="<?=h($file)?>"
                        <?= $file === $cur ? 'class="act" aria-current="page"' : '' ?>
                    ><?=h($label)?></a>
                <?php endforeach; ?>

                <a class="btn btn-r" href="support.php">Donate</a>
            </nav>

        </div>
    </header>
</body>
</html>
