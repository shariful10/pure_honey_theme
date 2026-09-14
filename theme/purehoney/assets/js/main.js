/**
 * PureHoney – main.js
 * Custom cursor + Lenis smooth scroll + all interactions
 */
(function () {
  'use strict';

  /* ─────────────────────────────────────────
   * 1. CUSTOM CURSOR
   * ───────────────────────────────────────── */
  function initCursor() {
    const cursor   = document.createElement('div');
    const follower = document.createElement('div');
    cursor.className   = 'ph-cursor';
    follower.className = 'ph-cursor-follower';
    document.body.appendChild(cursor);
    document.body.appendChild(follower);

    let mouseX = 0, mouseY = 0;
    let followerX = 0, followerY = 0;
    let raf;

    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      cursor.style.left = mouseX + 'px';
      cursor.style.top  = mouseY + 'px';
    });

    // Smooth follower
    function animateFollower() {
      followerX += (mouseX - followerX) * 0.1;
      followerY += (mouseY - followerY) * 0.1;
      follower.style.left = followerX + 'px';
      follower.style.top  = followerY + 'px';
      raf = requestAnimationFrame(animateFollower);
    }
    animateFollower();

    // Hover states — scale up follower on interactive elements
    const interactiveSelectors = 'a, button, [role="button"], input, textarea, select, label, .ph-btn, .woocommerce ul.products li.product';

    document.querySelectorAll(interactiveSelectors).forEach(el => {
      el.addEventListener('mouseenter', () => {
        cursor.style.transform   = 'translate(-50%,-50%) scale(0.6)';
        follower.style.transform = 'translate(-50%,-50%) scale(1.5)';
        follower.style.borderColor = 'rgba(212,175,55,0.7)';
      });
      el.addEventListener('mouseleave', () => {
        cursor.style.transform   = 'translate(-50%,-50%) scale(1)';
        follower.style.transform = 'translate(-50%,-50%) scale(1)';
        follower.style.borderColor = 'rgba(212,175,55,0.5)';
      });
    });

    // Hide when leaving window
    document.addEventListener('mouseleave', () => {
      cursor.style.opacity   = '0';
      follower.style.opacity = '0';
    });
    document.addEventListener('mouseenter', () => {
      cursor.style.opacity   = '1';
      follower.style.opacity = '1';
    });

    // Click effect
    document.addEventListener('mousedown', () => {
      cursor.style.transform = 'translate(-50%,-50%) scale(0.7)';
    });
    document.addEventListener('mouseup', () => {
      cursor.style.transform = 'translate(-50%,-50%) scale(1)';
    });

    // Disable on touch devices
    if ('ontouchstart' in window) {
      cursor.style.display   = 'none';
      follower.style.display = 'none';
      document.body.style.cursor = 'auto';
    }
  }

  /* ─────────────────────────────────────────
   * 2. PAGE LOADER
   * ───────────────────────────────────────── */
  function initLoader() {
    const loader = document.getElementById('ph-loader');
    if (!loader) return;
    window.addEventListener('load', () => {
      setTimeout(() => {
        loader.classList.add('is-hidden');
        document.body.classList.add('ph-loaded');
      }, 500);
    });
    // Failsafe
    setTimeout(() => loader.classList.add('is-hidden'), 3000);
  }

  /* ─────────────────────────────────────────
   * 3. LENIS SMOOTH SCROLL
   * ───────────────────────────────────────── */
  let lenis;

  function initLenis() {
    if (typeof Lenis === 'undefined') return;

    lenis = new Lenis({
      duration: 1.4,
      easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smooth: true,
      mouseMultiplier: 1,
      smoothTouch: false,
      touchMultiplier: 2,
      infinite: false,
    });

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    window.purehoneyLenis = lenis;

    // Smooth anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
          e.preventDefault();
          lenis.scrollTo(target, { offset: -100, duration: 1.5 });
        }
      });
    });
  }

  /* ─────────────────────────────────────────
   * 4. STICKY HEADER
   * ───────────────────────────────────────── */
  function initStickyHeader() {
    const header = document.getElementById('ph-header');
    if (!header) return;

    let lastY = 0;

    function update(scrollY) {
      if (scrollY > 80) {
        header.classList.add('ph-header--scrolled');
      } else {
        header.classList.remove('ph-header--scrolled');
      }
      if (scrollY > 300) {
        header.classList.toggle('ph-header--hidden', scrollY > lastY);
      } else {
        header.classList.remove('ph-header--hidden');
      }
      lastY = scrollY;
    }

    if (lenis) {
      lenis.on('scroll', ({ scroll }) => update(scroll));
    } else {
      window.addEventListener('scroll', () => update(window.scrollY), { passive: true });
    }
  }

  /* ─────────────────────────────────────────
   * 5. HERO PARALLAX
   * ───────────────────────────────────────── */
  function initParallax() {
    const bg = document.querySelector('.ph-hero__bg');
    if (!bg) return;

    function onScroll(y) {
      bg.style.transform = `translateY(${y * 0.3}px) scale(1.06)`;
    }

    if (lenis) {
      lenis.on('scroll', ({ scroll }) => onScroll(scroll));
    } else {
      window.addEventListener('scroll', () => onScroll(window.scrollY), { passive: true });
    }
  }

  /* ─────────────────────────────────────────
   * 6. SCROLL REVEAL ANIMATIONS
   * ───────────────────────────────────────── */
  function initScrollAnimations() {
    const els = document.querySelectorAll('[data-ph-animate]');
    if (!els.length) return;

    // Stagger delays
    document.querySelectorAll('[data-ph-stagger]').forEach(parent => {
      parent.querySelectorAll('[data-ph-animate]').forEach((el, i) => {
        el.style.transitionDelay = (i * 0.1) + 's';
      });
    });

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

    els.forEach(el => observer.observe(el));
  }

  /* ─────────────────────────────────────────
   * 7. MOBILE MENU
   * ───────────────────────────────────────── */
  function initMobileMenu() {
    const toggle  = document.getElementById('ph-hamburger');
    const overlay = document.getElementById('ph-mobile-overlay');
    const close   = document.getElementById('ph-mobile-close');

    function open()  { document.body.classList.add('menu-open'); }
    function closeMenu() { document.body.classList.remove('menu-open'); }

    toggle  && toggle.addEventListener('click', open);
    overlay && overlay.addEventListener('click', closeMenu);
    close   && close.addEventListener('click', closeMenu);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });

    // Sub-menu toggle on mobile
    document.querySelectorAll('.ph-mobile-menu .menu-item-has-children > a').forEach(link => {
      link.addEventListener('click', e => {
        const sub = link.nextElementSibling;
        if (sub && window.innerWidth < 900) {
          e.preventDefault();
          sub.classList.toggle('is-open');
        }
      });
    });
  }

  /* ─────────────────────────────────────────
   * 8. SEARCH OVERLAY
   * ───────────────────────────────────────── */
  function initSearch() {
    const toggles = document.querySelectorAll('[data-search-toggle]');
    const overlay = document.getElementById('ph-search-overlay');
    const close   = document.getElementById('ph-search-close');
    const input   = document.getElementById('ph-search-input');
    if (!overlay) return;

    function openSearch() {
      overlay.classList.add('is-open');
      overlay.setAttribute('aria-hidden', 'false');
      setTimeout(() => input && input.focus(), 200);
      if (lenis) lenis.stop();
    }

    function closeSearch() {
      overlay.classList.remove('is-open');
      overlay.setAttribute('aria-hidden', 'true');
      if (lenis) lenis.start();
    }

    toggles.forEach(t => t.addEventListener('click', e => { e.preventDefault(); openSearch(); }));
    close   && close.addEventListener('click', closeSearch);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearch(); });
    overlay.addEventListener('click', e => { if (e.target === overlay) closeSearch(); });
  }

  /* ─────────────────────────────────────────
   * 9. COUNTER ANIMATION
   * ───────────────────────────────────────── */
  function initCounters() {
    const counters = document.querySelectorAll('[data-ph-count]');
    if (!counters.length) return;

    const obs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseInt(el.dataset.phCount, 10);
        const suffix = el.dataset.phCountSuffix || '';
        const dur    = 1800;
        const step   = target / (dur / 16);
        let cur = 0;
        const timer = setInterval(() => {
          cur += step;
          if (cur >= target) { cur = target; clearInterval(timer); }
          el.textContent = Math.floor(cur).toLocaleString() + suffix;
        }, 16);
        obs.unobserve(el);
      });
    }, { threshold: 0.5 });

    counters.forEach(c => obs.observe(c));
  }

  /* ─────────────────────────────────────────
   * 10. NEWSLETTER AJAX
   * ───────────────────────────────────────── */
  function initNewsletter() {
    document.querySelectorAll('.ph-newsletter__form').forEach(form => {
      form.addEventListener('submit', async e => {
        e.preventDefault();
        const input = form.querySelector('.ph-newsletter__input');
        const btn   = form.querySelector('button, input[type="submit"]');
        if (!input || !btn) return;
        const email = input.value.trim();
        if (!email) return;

        const orig = btn.textContent;
        btn.textContent = 'Subscribing…';
        btn.disabled = true;

        try {
          const fd = new FormData();
          fd.append('action', 'purehoney_newsletter');
          fd.append('email', email);
          fd.append('nonce', (window.purehoney && window.purehoney.nonce) || '');

          const r = await fetch((window.purehoney && window.purehoney.ajax_url) || '/wp-admin/admin-ajax.php', {
            method: 'POST', body: fd
          });
          const data = await r.json();

          if (data.success) {
            form.innerHTML = `<p style="color:var(--ph-gold);font-weight:600;font-size:1.0625rem;">✓ ${data.data.message}</p>`;
          } else {
            btn.textContent = orig;
            btn.disabled = false;
          }
        } catch {
          btn.textContent = orig;
          btn.disabled = false;
        }
      });
    });
  }

  /* ─────────────────────────────────────────
   * 11. BACK TO TOP
   * ───────────────────────────────────────── */
  function initBackToTop() {
    const btn = document.getElementById('ph-back-to-top');
    if (!btn) return;

    function update(y) { btn.classList.toggle('is-visible', y > 400); }

    if (lenis) {
      lenis.on('scroll', ({ scroll }) => update(scroll));
    } else {
      window.addEventListener('scroll', () => update(window.scrollY), { passive: true });
    }

    btn.addEventListener('click', () => {
      if (lenis) lenis.scrollTo(0, { duration: 1.6 });
      else window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ─────────────────────────────────────────
   * INIT
   * ───────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    initCursor();
    initLoader();
    initLenis();

    requestAnimationFrame(() => {
      initStickyHeader();
      initParallax();
      initScrollAnimations();
      initMobileMenu();
      initSearch();
      initCounters();
      initNewsletter();
      initBackToTop();
    });
  });

})();
