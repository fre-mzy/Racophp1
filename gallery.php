
<?php
$title = 'Gallery';
require 'includes/header.php';

/*
|--------------------------------------------------------------------------
| RACO GOOGLE DRIVE GALLERY CONNECTION
|--------------------------------------------------------------------------
*/

$galleryApiUrl = 'https://script.google.com/macros/s/AKfycbx6PaBzHI8wFz2jaCSiuahKdc6DTTa7T80RLMW3GsIS0fHHIzI3pM80TqJLKQBNdsbf/exec';

$allowedCategories = [
    'Children and Care',
    'Visitors and Partners',
    'Events and Programmes'
];

$photos = [];
$galleryError = false;

/*
|--------------------------------------------------------------------------
| FETCH AND CACHE GOOGLE DRIVE DATA
|--------------------------------------------------------------------------
*/

function racoGalleryFetch($url) {

    if (function_exists('curl_init')) {

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'RACO-Gallery/1.0'
        ]);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($response !== false && $status === 200) {
            return $response;
        }

        return false;
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => 15,
            'follow_location' => 1,
            'max_redirects' => 5,
            'ignore_errors' => true
        ]
    ]);

    return @file_get_contents($url, false, $context);
}

/*
|--------------------------------------------------------------------------
| CACHE STORAGE
|--------------------------------------------------------------------------
*/

$cacheFile = sys_get_temp_dir()
    . DIRECTORY_SEPARATOR
    . 'raco_gallery_cache.json';

$payload = null;
$cachedPayload = null;

// Read existing cache.
if (is_file($cacheFile)) {

    $cachedPayload = json_decode(
        file_get_contents($cacheFile),
        true
    );
}

// Use fresh cache when available.
if (
    is_file($cacheFile) &&
    (time() - filemtime($cacheFile)) < 300 &&
    is_array($cachedPayload) &&
    !empty($cachedPayload['success'])
) {
    $payload = $cachedPayload;

} else {

    // Request updated photographs.
    $response = racoGalleryFetch($galleryApiUrl);

    if ($response !== false) {

        $newPayload = json_decode($response, true);

        if (
            is_array($newPayload) &&
            !empty($newPayload['success']) &&
            isset($newPayload['photos']) &&
            is_array($newPayload['photos'])
        ) {

            $payload = $newPayload;

            // Save a fresh cache.
            @file_put_contents(
                $cacheFile,
                json_encode($newPayload)
            );
        }
    }

    // Use old cache if the live request fails.
    if ($payload === null) {

        if (
            is_array($cachedPayload) &&
            !empty($cachedPayload['success'])
        ) {
            $payload = $cachedPayload;

        } else {
            $galleryError = true;
        }
    }
}

/*
|--------------------------------------------------------------------------
| PREPARE PHOTO DATA
|--------------------------------------------------------------------------
*/

if (is_array($payload) && isset($payload['photos'])) {

    foreach ($payload['photos'] as $photo) {

        $id = $photo['id'] ?? '';
        $name = $photo['name'] ?? '';
        $category = $photo['category'] ?? '';

        // Validate Drive file ID.
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
            continue;
        }

        // Only display approved gallery categories.
        if (!in_array($category, $allowedCategories, true)) {
            continue;
        }

        if ($name === '') {
            $name = 'RACO Gallery Photograph';
        }

        // Generate a readable caption from the filename.
        $caption = pathinfo($name, PATHINFO_FILENAME);
        $caption = str_replace(['_', '-'], ' ', $caption);
        $caption = trim($caption);

        $photos[] = [
            'id' => $id,
            'name' => $caption,
            'category' => $category,
            'url' => 'https://drive.google.com/thumbnail?id='
                . rawurlencode($id)
                . '&sz=w1200'
        ];
    }
}

?>

<div class="page">
    <div class="wrap">
        <span class="bar"></span>

        <h1>Our Gallery</h1>

        <p class="lead">
            Moments from our homes, schools, celebrations,
            partnerships and community programmes.
        </p>
    </div>
</div>

<section>
    <div class="wrap">

        <!-- INTRODUCTION -->
        <div class="gallery-intro">
            <h2>Stories Through Pictures</h2>

            <p>
                Every photograph tells a story of hope,
                care, partnership and community impact.
                Explore moments from the work of RACO.
            </p>
        </div>

        <!-- CATEGORY FILTERS -->
        <div class="gallery-filters"
             role="group"
             aria-label="Filter gallery photographs">

            <button type="button"
                    class="btn btn-b gallery-filter active"
                    data-filter="all"
                    aria-pressed="true">
                All Photos
            </button>

            <?php foreach ($allowedCategories as $category): ?>

                <button type="button"
                        class="btn btn-b gallery-filter"
                        data-filter="<?=h($category)?>"
                        aria-pressed="false">

                    <?=h($category)?>

                </button>

            <?php endforeach; ?>

        </div>

        <!-- PHOTO COUNT -->
        <p class="gallery-count">
            <?=count($photos)?> photographs
        </p>

        <!-- GALLERY GRID -->
        <div class="gal gallery-grid" id="raco-gallery">

            <?php foreach ($photos as $i => $photo): ?>

                <figure class="gallery-item rv"
                        data-category="<?=h($photo['category'])?>">

                    <button type="button"
                            class="gallery-open"
                            aria-label="View photograph: <?=h($photo['name'])?>">

                        <div class="gallery-image-frame">

                            <img
                                src="<?=h($photo['url'])?>"
                                alt="<?=h($photo['name'])?>"
                                loading="lazy"
                                decoding="async"
                            >

                            <span class="gallery-zoom">
                                View Photo
                            </span>

                            <span class="gallery-image-error" hidden>
                                Image unavailable
                            </span>

                        </div>

                    </button>

                    <figcaption>
                        <b><?=h($photo['name'])?></b>

                        <span><?=h($photo['category'])?></span>
                    </figcaption>

                </figure>

            <?php endforeach; ?>

        </div>

        <!-- EMPTY STATE -->
        <div id="gallery-empty"
             class="gallery-empty"
             <?=count($photos) ? 'hidden' : ''?>>

            <?php if ($galleryError): ?>

                <h3>Gallery temporarily unavailable</h3>

                <p>
                    We are having trouble loading our photographs.
                    Please check back shortly.
                </p>

            <?php else: ?>

                <h3>No photographs available yet</h3>

                <p>
                    New photographs will appear here as
                    they are added to our gallery.
                </p>

            <?php endif; ?>

        </div>

    </div>
</section>

<!-- IMAGE LIGHTBOX -->
<div class="gallery-lightbox"
     id="gallery-lightbox"
     role="dialog"
     aria-modal="true"
     aria-label="Gallery photograph viewer"
     hidden>

    <button type="button"
            class="gallery-close"
            aria-label="Close image viewer">
        &times;
    </button>

    <button type="button"
            class="gallery-prev"
            aria-label="Previous photograph">
        &#10094;
    </button>

    <figure class="gallery-lightbox-content">

        <img id="gallery-large-image" src="" alt="">

        <figcaption id="gallery-large-caption"></figcaption>

    </figure>

    <button type="button"
            class="gallery-next"
            aria-label="Next photograph">
        &#10095;
    </button>

</div>

<style>

/* INTRODUCTION */

.gallery-intro {
    max-width: 650px;
    margin-bottom: 28px;
}

.gallery-intro p {
    opacity: .8;
    line-height: 1.8;
}

/* FILTERS */

.gallery-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
}

.gallery-filter {
    cursor: pointer;
    border: 1px solid currentColor;
}

.gallery-filter:not(.active) {
    background: transparent;
    color: inherit;
}

/* COUNT */

.gallery-count {
    font-size: .88rem;
    opacity: .7;
    margin-bottom: 20px;
}

/* GRID */

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.gallery-item {
    min-width: 0;
    margin: 0;
}

.gallery-open {
    display: block;
    width: 100%;
    padding: 0;
    border: 0;
    border-radius: 10px;
    overflow: hidden;
    background: transparent;
    cursor: zoom-in;
    text-align: left;
}

.gallery-image-frame {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 10px;
    background: var(--alt, #f1f1f1);
}

.gallery-image-frame img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}

.gallery-open:hover img,
.gallery-open:focus-visible img {
    transform: scale(1.04);
}

.gallery-zoom {
    position: absolute;
    right: 12px;
    bottom: 12px;
    padding: 7px 11px;
    border-radius: 6px;
    color: #fff;
    background: rgba(0, 0, 0, .72);
    font-size: 13px;
}

.gallery-image-error {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    opacity: .7;
}

/* CAPTIONS */

.gallery-item figcaption {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 12px 2px;
}

.gallery-item figcaption span {
    font-size: .85rem;
    opacity: .75;
}

/* EMPTY STATE */

.gallery-empty {
    padding: 45px 20px;
    text-align: center;
    border-radius: 12px;
    background: var(--alt, #f4f3f1);
}

.gallery-empty p {
    opacity: .75;
}

/* LIGHTBOX */

.gallery-lightbox[hidden] {
    display: none;
}

.gallery-lightbox {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    padding: 60px 24px 24px;
    background: rgba(0, 0, 0, .94);
}

.gallery-lightbox-content {
    max-width: min(900px, 78vw);
    max-height: 82vh;
    margin: 0;
    text-align: center;
}

.gallery-lightbox-content img {
    display: block;
    max-width: 100%;
    max-height: 72vh;
    margin: auto;
    object-fit: contain;
}

.gallery-lightbox-content figcaption {
    padding-top: 12px;
    color: #fff;
}

.gallery-close,
.gallery-prev,
.gallery-next {
    position: absolute;
    border: 0;
    color: #fff;
    background: rgba(255, 255, 255, .12);
    cursor: pointer;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    font-size: 25px;
}

.gallery-close {
    top: 18px;
    right: 22px;
    font-size: 32px;
}

.gallery-prev,
.gallery-next {
    position: static;
    flex: 0 0 auto;
}

body.gallery-view-open {
    overflow: hidden;
}

/* ACCESSIBILITY */

.gallery-open:focus-visible,
.gallery-filters button:focus-visible,
.gallery-lightbox button:focus-visible {
    outline: 3px solid #e6a23c;
    outline-offset: 3px;
}

/* RESPONSIVE */

@media (max-width: 760px) {

    .gallery-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .gallery-lightbox {
        gap: 8px;
        padding: 60px 8px 18px;
    }

    .gallery-lightbox-content {
        max-width: calc(100vw - 100px);
    }

    .gallery-prev,
    .gallery-next {
        width: 34px;
        height: 34px;
        font-size: 18px;
    }
}

@media (max-width: 420px) {

    .gallery-grid {
        grid-template-columns: 1fr;
    }
}

@media (prefers-reduced-motion: reduce) {

    .gallery-open img {
        transition: none;
    }
}

</style>

<script>

(function () {

    const gallery = document.getElementById('raco-gallery');
    const lightbox = document.getElementById('gallery-lightbox');

    if (!gallery || !lightbox) return;

    const items = Array.from(
        gallery.querySelectorAll('.gallery-item')
    );

    const filters = Array.from(
        document.querySelectorAll('.gallery-filter')
    );

    const emptyMessage = document.getElementById('gallery-empty');

    const largeImage = document.getElementById('gallery-large-image');
    const largeCaption = document.getElementById('gallery-large-caption');

    const closeButton = lightbox.querySelector('.gallery-close');
    const previousButton = lightbox.querySelector('.gallery-prev');
    const nextButton = lightbox.querySelector('.gallery-next');

    let activeItems = [];
    let currentIndex = 0;
    let lastFocusedElement = null;

    // FILTER PHOTOGRAPHS

    function applyFilter(category) {

        let visibleCount = 0;

        items.forEach(function (item) {

            const matches =
                category === 'all' ||
                item.dataset.category === category;

            item.hidden = !matches;

            if (matches) visibleCount++;

        });

        if (emptyMessage) {
            emptyMessage.hidden = visibleCount !== 0;
        }

        filters.forEach(function (button) {

            const active = button.dataset.filter === category;

            button.classList.toggle('active', active);

            button.setAttribute(
                'aria-pressed',
                String(active)
            );

        });

    }

    filters.forEach(function (button) {

        button.addEventListener('click', function () {
            applyFilter(button.dataset.filter);
        });

    });

    // IMAGE DATA

    function getImageData(item) {

        const image = item.querySelector('img');

        const caption = item.querySelector('figcaption b');

        return {
            src: image ? image.currentSrc || image.src : '',
            alt: image ? image.alt : '',
            caption: caption ? caption.textContent : ''
        };

    }

    // DISPLAY IMAGE

    function showImage(index) {

        if (!activeItems.length) return;

        currentIndex =
            (index + activeItems.length) % activeItems.length;

        const data = getImageData(activeItems[currentIndex]);

        largeImage.src = data.src;
        largeImage.alt = data.alt;

        largeCaption.textContent = data.caption;

        previousButton.disabled = activeItems.length < 2;
        nextButton.disabled = activeItems.length < 2;

    }

    // OPEN LIGHTBOX

    function openLightbox(item) {

        activeItems = items.filter(function (entry) {
            return !entry.hidden;
        });

        currentIndex = activeItems.indexOf(item);

        if (currentIndex < 0) return;

        lastFocusedElement = document.activeElement;

        showImage(currentIndex);

        lightbox.hidden = false;

        document.body.classList.add('gallery-view-open');

        closeButton.focus();

    }

    // CLOSE LIGHTBOX

    function closeLightbox() {

        lightbox.hidden = true;

        document.body.classList.remove('gallery-view-open');

        largeImage.src = '';
        largeImage.alt = '';

        if (
            lastFocusedElement &&
            lastFocusedElement.focus
        ) {
            lastFocusedElement.focus();
        }

    }

    // OPEN IMAGE EVENTS

    items.forEach(function (item) {

        const button = item.querySelector('.gallery-open');

        const image = item.querySelector('img');

        const errorMessage = item.querySelector('.gallery-image-error');

        if (image) {

            image.addEventListener('error', function () {

                image.hidden = true;

                if (errorMessage) {
                    errorMessage.hidden = false;
                }

            });

        }

        if (button) {

            button.addEventListener('click', function () {
                openLightbox(item);
            });

        }

    });

    // NAVIGATION

    closeButton.addEventListener('click', closeLightbox);

    previousButton.addEventListener('click', function () {
        showImage(currentIndex - 1);
    });

    nextButton.addEventListener('click', function () {
        showImage(currentIndex + 1);
    });

    // CLICK OUTSIDE IMAGE TO CLOSE

    lightbox.addEventListener('click', function (event) {

        if (event.target === lightbox) {
            closeLightbox();
        }

    });

    // KEYBOARD CONTROLS

    document.addEventListener('keydown', function (event) {

        if (lightbox.hidden) return;

        if (event.key === 'Escape') {

            closeLightbox();

        } else if (event.key === 'ArrowLeft') {

            showImage(currentIndex - 1);

        } else if (event.key === 'ArrowRight') {

            showImage(currentIndex + 1);

        }

    });

    // INITIAL FILTER

    applyFilter('all');

})();

</script>

<?php require 'includes/footer.php'; ?>
