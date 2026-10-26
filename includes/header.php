
<?php
require_once __DIR__ . '/config.php';

$cur = basename($_SERVER['SCRIPT_NAME']);
$home = $cur === 'index.php';

$nav = [
    'index.php' => 'Home',
    'about.php' => 'About',
    'programmes.php' => 'Our work',
    'gallery.php' => 'Gallery',
    'contact.php' => 'Contact'
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= h($title ?? 'Home') ?> | <?= h($S['n']) ?>, <?= h($S['s']) ?></title>

    <meta name="description" content="Faith-based care, free education and rural empowerment since 2003. Touching lives, touching rural communities everyday.">

    <link rel="icon" href="assets/img/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">

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
    <div id="pre">
        <img src="assets/img/logo.png" alt="">
        <i></i>
    </div>

    <header<?= $home ? '' : ' class="solid"' ?>>
        <div class="wrap nav">

            <a class="brand" href="index.php">
                <img src="assets/img/logo.png" alt="RACO Commission logo">
                <span>
                    <?= h($S['n']) ?>
                    <small><?= h($S['s']) ?></small>
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
                <?php foreach ($nav as $f => $l): ?>
                    <a
                        href="<?= h($f) ?>"
                        <?= $f === $cur ? 'class="act" aria-current="page"' : '' ?>
                    ><?= h($l) ?></a>
                <?php endforeach; ?>

                <a class="btn btn-r" href="support.php">Donate</a>
            </nav>

        </div>
    </header>
</body>
</html>
