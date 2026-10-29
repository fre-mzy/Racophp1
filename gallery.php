
<?php
$title = 'Gallery';
require 'includes/header.php';

$g = [
    ['children-courtyard.jpg', 'Children in matching ankara outfits at RACO', 'Children & Care'],
    ['children-praying.jpg', 'Children praying in school uniform', 'Children & Care'],
    ['group-photo.jpg', 'Children and visitors at the orphanage', 'Children & Care'],
    ['gallery-medical-outreach.jpg', 'Free medical outreach', 'Community Outreach'],
    ['gallery-widows-ceremony.jpg', 'Rural widows empowerment ceremony', 'Community Outreach'],
    ['gallery-christmas-fair.jpg', 'Christmas Grace Fun Fair', 'Events'],
    ['gallery-graduation.jpg', 'Schools graduation and thanksgiving', 'Events'],
    ['gallery-skills-training.jpg', 'Youth skills training', 'Training'],
    ['gallery-light-city.jpg', 'Light City, Ogun State', 'Our Locations'],
];
?>

<div class="page">
    <div class="wrap">
        <span class="bar"></span>
        <h1>Our Gallery</h1>
        <p class="lead">
            Moments from our homes, schools, celebrations and community
            outreach activities.
        </p>
    </div>
</div>

<section>
    <div class="wrap">

        <!-- CATEGORY FILTERS -->
        <div class="gallery-filters" role="group" aria-label="Filter gallery images">
            <button type="button" class="btn btn-b gallery-filter active"
                    data-filter="all" aria-pressed="true">All photos</button>
            <button type="button" class="btn btn-b gallery-filter"
                    data-filter="Children & Care" aria-pressed="false">Children & Care</button>
            <button type="button" class="btn btn-b gallery-filter"
                    data-filter="Community Outreach" aria-pressed="false">Community Outreach</button>
            <button type="button" class="btn btn-b gallery-filter"
                    data-filter="Events" aria-pressed="false">Events</button>
            <button type="button" class="btn btn-b gallery-filter"
                    data-filter="Training" aria-pressed="false">Training</button>
            <button type="button" class="btn btn-b gallery-filter"
                    data-filter="Our Locations" aria-pressed="false">Our Locations</button>
        </div>

        <!-- GALLERY GRID -->
        <div class="gal gallery-grid" id="raco-gallery">
            <?php foreach ($g as $i => $x): ?>
                <figure class="gallery-item rv"
                        data-category="<?=h($x[2])?>">

                    <button type="button"
                            class="gallery-open"
                            data-index="<?=$i?>"
                            aria-label="View image: <?=h($x[1])?>">

                        <?=photo($x[0], $x[1])?>

                        <span class="gallery-zoom" aria-hidden="true">View photo</span>
                    </button>

                    <figcaption>
                        <b><?=h($x[1])?></b>
                        <span><?=h($x[2])?></span>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>

        <p id="gallery-empty" hidden>
            No photos are available in this category yet.
        </p>

    </div>
</section>

<!-- IMAGE LIGHTBOX -->
<div class="gallery-lightbox" id="gallery-lightbox"
     role="dialog" aria-modal="true" aria-label="Gallery image viewer" hidden>

    <button type="button" class="gallery-close"
            aria-label="Close image viewer">&times;</button>

    <button type="button" class="gallery-prev"
            aria-label="Previous image">&#10094;</button>

    <figure class="gallery-lightbox-content">
        <img id="gallery-large-image" src="" alt="">
        <figcaption id="gallery-large-caption"></figcaption>
    </figure>

    <button type="button" class="gallery-next"
            aria-label="Next image">&#10095;</button>
</div>

<style>
.gallery-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 28px;
}

.gallery-filter {
    cursor: pointer;
    border: 1px solid currentColor;
}

.gallery-filter:not(.active) {
    background: transparent;
    color: inherit;
}

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
    position: relative;
    width: 100%;
    padding: 0;
    overflow: hidden;
    border: 0;
    border-radius: 10px;
    background: transparent;
    cursor: zoom-in;
    text-align: left;
}

.gallery-open img {
    display: block;
    width: 100%;
    aspect-ratio: 4 / 3;
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

.gallery-lightbox .gallery-close {
    position: absolute;
}

body.gallery-view-open {
    overflow: hidden;
}

.gallery-open:focus-visible,
.gallery-filters button:focus-visible,
.gallery-lightbox button:focus-visible {
    outline: 3px solid #e6a23c;
    outline-offset: 3px;
}

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

    const items = Array.from(gallery.querySelectorAll('.gallery-item'));
    const filters = Array.from(document.querySelectorAll('.gallery-filter'));
    const emptyMessage = document.getElementById('gallery-empty');

    const largeImage = document.getElementById('gallery-large-image');
    const largeCaption = document.getElementById('gallery-large-caption');

    const closeButton = lightbox.querySelector('.gallery-close');
    const previousButton = lightbox.querySelector('.gallery-prev');
    const nextButton = lightbox.querySelector('.gallery-next');

    let activeItems = [];
    let currentIndex = 0;
    let lastFocusedElement = null;

    function applyFilter(category) {
        let visibleCount = 0;

        items.forEach(function (item) {
            const matches = category === 'all' ||
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
            button.setAttribute('aria-pressed', String(active));
        });
    }

    filters.forEach(function (button) {
        button.addEventListener('click', function () {
            applyFilter(button.dataset.filter);
        });
    });

    function getImageData(item) {
        const image = item.querySelector('img');
        const button = item.querySelector('.gallery-open');
        const caption = item.querySelector('figcaption b');

        return {
            src: image ? image.currentSrc || image.src : '',
            alt: image ? image.alt : '',
            caption: caption ? caption.textContent : '',
            button: button
        };
    }

    function showImage(index) {
        if (!activeItems.length) return;

        currentIndex = (index + activeItems.length) % activeItems.length;

        const data = getImageData(activeItems[currentIndex]);

        largeImage.src = data.src;
        largeImage.alt = data.alt;
        largeCaption.textContent = data.caption;

        previousButton.disabled = activeItems.length < 2;
        nextButton.disabled = activeItems.length < 2;
    }

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

    function closeLightbox() {
        lightbox.hidden = true;
        document.body.classList.remove('gallery-view-open');

        largeImage.src = '';
        largeImage.alt = '';

        if (lastFocusedElement && lastFocusedElement.focus) {
            lastFocusedElement.focus();
        }
    }

    items.forEach(function (item) {
        const button = item.querySelector('.gallery-open');

        if (button) {
            button.addEventListener('click', function () {
                openLightbox(item);
            });
        }
    });

    closeButton.addEventListener('click', closeLightbox);

    previousButton.addEventListener('click', function () {
        showImage(currentIndex - 1);
    });

    nextButton.addEventListener('click', function () {
        showImage(currentIndex + 1);
    });

    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

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

    applyFilter('all');
})();
</script>

<?php require 'includes/footer.php'; ?>
