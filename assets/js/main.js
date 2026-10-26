
(() => {
  'use strict';

  const $ = (selector, root = document) =>
    root.querySelector(selector);

  const $$ = (selector, root = document) =>
    [...root.querySelectorAll(selector)];

  const reduceMotion = window.matchMedia(
    '(prefers-reduced-motion: reduce)'
  );

  // -----------------------------
  // PRELOADER
  // -----------------------------
  const preloader = $('#pre');
  let preloaderHidden = false;

  function hidePreloader() {
    if (!preloader || preloaderHidden) return;

    preloaderHidden = true;
    preloader.classList.add('done');
  }

  if (preloader) {
    window.addEventListener('load', hidePreloader, {
      once: true
    });

    // Never keep the visitor behind the loader indefinitely.
    window.setTimeout(hidePreloader, 3000);
  }

  // -----------------------------
  // HEADER + MOBILE NAVIGATION
  // -----------------------------
  const header = $('header');
  const burger = $('.burger');
  const nav = $('#site-nav');

  function setMenu(open) {
    if (!header || !burger) return;

    header.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', String(open));
    burger.setAttribute(
      'aria-label',
      open ? 'Close navigation menu' : 'Open navigation menu'
    );

    burger.textContent = open ? 'Close' : 'Menu';
  }

  function updateHeader() {
    if (!header) return;

    header.classList.toggle('s', window.scrollY > 40);
  }

  updateHeader();

  window.addEventListener('scroll', updateHeader, {
    passive: true
  });

  if (burger) {
    burger.addEventListener('click', () => {
      const isOpen =
        burger.getAttribute('aria-expanded') === 'true';

      setMenu(!isOpen);
    });
  }

  if (nav) {
    nav.addEventListener('click', event => {
      if (event.target.closest('a')) {
        setMenu(false);
      }
    });
  }

  
document.addEventListener('keydown', event => {
  if (
    event.key === 'Escape' &&
    header?.classList.contains('open')
  ) {
    setMenu(false);
    burger?.focus();
  }
});


  document.addEventListener('click', event => {
    if (
      header &&
      header.classList.contains('open') &&
      !header.contains(event.target)
    ) {
      setMenu(false);
    }
  });

  // -----------------------------
  // SCROLL REVEALS + COUNTERS
  // -----------------------------
  const revealItems = $$('.rv, [data-count]');
  const counters = new WeakSet();

  function animateCounter(element) {
    if (counters.has(element)) return;
    counters.add(element);

    const target = Number(element.dataset.count);

    if (!Number.isFinite(target)) return;

    const suffix = element.dataset.s || '';

    if (reduceMotion.matches) {
      element.textContent =
        target.toLocaleString() + suffix;
      return;
    }

    const duration = 1200;
    let startTime;

    function frame(now) {
      if (startTime === undefined) startTime = now;

      const progress = Math.min(
        (now - startTime) / duration,
        1
      );

      const eased = 1 - Math.pow(1 - progress, 3);
      const value = Math.round(target * eased);

      element.textContent =
        value.toLocaleString() + suffix;

      if (progress < 1) {
        requestAnimationFrame(frame);
      }
    }

    requestAnimationFrame(frame);
  }

  function reveal(element) {
    element.classList.add('in');

    if (element.hasAttribute('data-count')) {
      animateCounter(element);
    }
  }

  if ('IntersectionObserver' in window) {
    try {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;

          reveal(entry.target);
          observer.unobserve(entry.target);
        });
      }, {
        threshold: 0.15
      });

      // Activate hidden reveal states only after observer setup.
      if (!reduceMotion.matches) {
        document.documentElement.classList.add('js-ready');
      }

      revealItems.forEach(element => {
        observer.observe(element);
      });
    } catch (error) {
      // Animation failure must never hide page content.
      document.documentElement.classList.remove('js-ready');
      revealItems.forEach(reveal);
    }
  } else {
    // Older browser fallback.
    revealItems.forEach(reveal);
  }

  // -----------------------------
  // HERO SLIDER
  // -----------------------------
  const slides = $$('.sl');
  const texts = $$('.hc .t');
  const dots = $$('.dots b');

  let current = Math.max(
    0,
    slides.findIndex(slide => slide.classList.contains('on'))
  );

  let timer = null;
  let touchStartX = null;

  const hero = $('.hero');

  function showSlide(nextIndex) {
    if (!slides.length) return;

    const next =
      (nextIndex + slides.length) % slides.length;

    slides.forEach((slide, index) => {
      const active = index === next;

      slide.classList.toggle('on', active);
      slide.setAttribute('aria-hidden', String(!active));
    });

    texts.forEach((text, index) => {
      const active = index === next;

      text.classList.toggle('on', active);
      text.setAttribute('aria-hidden', String(!active));
    });

    dots.forEach((dot, index) => {
      const active = index === next;

      dot.classList.toggle('on', active);

      if (dot.matches('button')) {
        dot.setAttribute('aria-pressed', String(active));
      }
    });

    current = next;
  }

  function stopAutoplay() {
    if (timer !== null) {
      window.clearInterval(timer);
      timer = null;
    }
  }

  function startAutoplay() {
    stopAutoplay();

    if (
      slides.length < 2 ||
      reduceMotion.matches ||
      document.hidden
    ) {
      return;
    }

    timer = window.setInterval(() => {
      if (!hero || !hero.matches(':hover')) {
        showSlide(current + 1);
      }
    }, 6500);
  }

  if (slides.length > 1 && texts.length === slides.length) {
    showSlide(current);

    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        showSlide(index);
        startAutoplay();
      });
    });

    [['prev', -1], ['next', 1]].forEach(([direction, step]) => {
      const button = document.createElement('button');

      button.type = 'button';
      button.className = `arr ${direction}`;
      button.setAttribute(
        'aria-label',
        direction === 'prev' ? 'Previous slide' : 'Next slide'
      );
      button.textContent = direction === 'prev' ? '\u2039' : '\u203a';

      button.addEventListener('click', () => {
        showSlide(current + step);
        startAutoplay();
      });

      hero?.appendChild(button);
    });

    hero?.addEventListener('mouseenter', stopAutoplay);
    hero?.addEventListener('mouseleave', startAutoplay);

    hero?.addEventListener('focusin', stopAutoplay);
    hero?.addEventListener('focusout', startAutoplay);

    hero?.addEventListener('touchstart', event => {
      touchStartX = event.touches[0]?.clientX ?? null;
    }, { passive: true });

    hero?.addEventListener('touchend', event => {
      if (touchStartX === null) return;

      const endX = event.changedTouches[0]?.clientX;
      const difference = endX - touchStartX;

      touchStartX = null;

      if (Math.abs(difference) > 50) {
        showSlide(current + (difference < 0 ? 1 : -1));
        startAutoplay();
      }
    }, { passive: true });

    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        stopAutoplay();
      } else {
        startAutoplay();
      }
    });

    reduceMotion.addEventListener?.('change', startAutoplay);

    startAutoplay();
  }

  // -----------------------------
  // CONTACT FORM -> WHATSAPP
  // -----------------------------
  const form = $('#wf');

  if (form) {
    form.addEventListener('submit', event => {
      event.preventDefault();

      if (!form.reportValidity()) return;

      const data = new FormData(form);
      const name = String(data.get('name') || '').trim();
      const message = String(data.get('msg') || '').trim();
      const phone = form.dataset.wa;

      if (!name || !message || !phone) return;

      const text =
        `Hello RACO, my name is ${name}. ${message}`;

      const url =
        `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;

      window.open(url, '_blank', 'noopener,noreferrer');
    });
  }
})();
                 
