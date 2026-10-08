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
   * CART QUANTITY & STATE SYNCHRONIZATION
   * ───────────────────────────────────────── */
  function initCartQuantity() {
    if (window.phCartQtyInitialized) return;
    window.phCartQtyInitialized = true;

    // Remove invalid negative or zero max attributes that cause HTML5 validation errors
    function sanitizeQtyMax(input) {
      if (!input) return;
      const m = input.getAttribute('max');
      if (m !== null) {
        const num = parseInt(m, 10);
        if (isNaN(num) || num <= 0) {
          input.removeAttribute('max');
        }
      }
    }

    function cleanAllQtyInputs() {
      document.querySelectorAll('input.qty, .ph-qty-wrap input, input[type=number]').forEach((inp) => {
        sanitizeQtyMax(inp);
        if (!inp.hasAttribute('data-saved-qty')) {
          inp.setAttribute('data-saved-qty', inp.value || '1');
        }
      });
    }
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', cleanAllQtyInputs);
    } else {
      cleanAllQtyInputs();
    }

    // Check if any draft input quantity differs from persisted/saved quantity
    window.checkDraftChanges = function() {
      let hasChanges = false;
      document.querySelectorAll('.ph-cart-item input.qty, .ph-qty-wrap input.qty').forEach((inp) => {
        const current = Number(inp.value) || 1;
        const saved = Number(inp.getAttribute('data-saved-qty') || inp.defaultValue || current);
        if (current !== saved) {
          hasChanges = true;
        }
      });
      const updateBtns = document.querySelectorAll('button[name="update_cart"], .ph-update-cart-btn');
      updateBtns.forEach((btn) => {
        if (hasChanges) {
          btn.classList.add('ph-btn--highlight');
          btn.disabled = false;
        } else {
          btn.classList.remove('ph-btn--highlight');
        }
      });
      return hasChanges;
    };

    // Universal Quantity Setter enforcing strict minimum boundary Math.max(1, newQuantity)
    // Note: Updates ONLY local draft input state; does not auto-submit or reload
    window.handleQuantityChange = function(target, newQty) {
      let input = null;
      if (typeof target === 'number') {
        const inputs = document.querySelectorAll('input.qty, .ph-qty-wrap input');
        input = inputs[target];
      } else if (typeof target === 'string') {
        input = document.querySelector(`input[name*="${target}"], input[data-cart-item-key="${target}"]`);
      } else if (target && target.nodeType) {
        input = target.tagName === 'INPUT' ? target : target.querySelector('input.qty');
      }
      if (!input) return;
      sanitizeQtyMax(input);

      const max = parseInt(input.max, 10);
      let parsed = Number(newQty);
      if (isNaN(parsed)) parsed = 1;
      let validQty = Math.max(1, parsed);
      if (!isNaN(max) && max > 0) validQty = Math.min(validQty, max);

      input.value = String(validQty);
      window.checkDraftChanges();
    };

    // Universal Quantity Increment/Decrement function
    window.updateQuantity = function(target, delta) {
      let input = null;
      if (typeof target === 'number') {
        const inputs = document.querySelectorAll('input.qty, .ph-qty-wrap input');
        input = inputs[target];
      } else if (typeof target === 'string') {
        input = document.querySelector(`input[name*="${target}"], input[data-cart-item-key="${target}"]`);
      } else if (target && target.nodeType) {
        input = target.tagName === 'INPUT' ? target : target.querySelector('input.qty');
      }
      if (!input) return;

      let current = Number(input.value);
      if (isNaN(current) || current < 1) current = 1;

      let d = Number(delta);
      if (isNaN(d)) d = 1;

      const nextQty = Math.max(1, current + d);
      window.handleQuantityChange(input, nextQty);
    };

    // Commit Cart Updates Function: triggers on "Update Cart" button click
    window.commitCartUpdates = function() {
      let totalItemsCount = 0;
      let subtotalSum = 0;

      document.querySelectorAll('.ph-cart-item input.qty, .ph-qty-wrap input.qty').forEach((inp) => {
        const qtyVal = Math.max(1, Number(inp.value) || 1);
        inp.value = String(qtyVal);
        inp.setAttribute('data-saved-qty', String(qtyVal));

        const price = parseFloat(inp.getAttribute('data-price')) || 0;
        const lineTotal = (price * qtyVal).toFixed(2);
        totalItemsCount += qtyVal;
        subtotalSum += (price * qtyVal);

        // 1. Update Cart Row subtotal in cart table
        const row = inp.closest('.ph-cart-item');
        if (row) {
          const subtotalEl = row.querySelector('.ph-cart-item__subtotal .woocommerce-Price-amount, .ph-cart-item__subtotal');
          if (subtotalEl) {
            const symbol = (subtotalEl.textContent.match(/[\$\€\£\¥]/) || ['$'])[0];
            const subtotalInner = row.querySelector('.ph-cart-item__subtotal .woocommerce-Price-amount');
            if (subtotalInner) {
              subtotalInner.innerHTML = `<bdi><span class="woocommerce-Price-currencySymbol">${symbol}</span>${lineTotal}</bdi>`;
            } else {
              subtotalEl.textContent = symbol + lineTotal;
            }
          }
        }

        // 2. Update matching Itemized Order Summary row
        const itemKey = inp.getAttribute('data-cart-item-key');
        if (itemKey) {
          const summaryItem = document.querySelector(`.ph-summary-item[data-cart-item-key="${itemKey}"]`);
          if (summaryItem) {
            const qtySpan = summaryItem.querySelector('.ph-summary-item__qty');
            if (qtySpan) qtySpan.textContent = `× ${qtyVal}`;
            const priceSpan = summaryItem.querySelector('.ph-summary-item__price .woocommerce-Price-amount, .ph-summary-item__price');
            if (priceSpan) {
              const sym = (priceSpan.textContent.match(/[\$\€\£\¥]/) || ['$'])[0];
              const priceInner = summaryItem.querySelector('.ph-summary-item__price .woocommerce-Price-amount');
              if (priceInner) {
                priceInner.innerHTML = `<bdi><span class="woocommerce-Price-currencySymbol">${sym}</span>${lineTotal}</bdi>`;
              } else {
                priceSpan.textContent = sym + lineTotal;
              }
            }
          }
        }
      });

      // 3. Recalculate Subtotal, Total, and Cart Badge count
      if (subtotalSum > 0) {
        const formattedSum = subtotalSum.toFixed(2);
        document.querySelectorAll('.ph-summary-row span:last-child .woocommerce-Price-amount, .order-total .woocommerce-Price-amount, .ph-summary-total .woocommerce-Price-amount').forEach((amountEl) => {
          const curSym = (amountEl.textContent.match(/[\$\€\£\¥]/) || ['$'])[0];
          amountEl.innerHTML = `<bdi><span class="woocommerce-Price-currencySymbol">${curSym}</span>${formattedSum}</bdi>`;
        });

        document.querySelectorAll('.ph-cart-badge, .ph-nav-cart__badge').forEach((badge) => {
          badge.textContent = String(totalItemsCount);
        });
      }

      // Remove highlight from Update Cart button
      window.checkDraftChanges();

      // Display "Cart updated." notification
      let noticeWrap = document.querySelector('.woocommerce-notices-wrapper');
      if (!noticeWrap) {
        const cartPage = document.querySelector('.ph-cart-page, .woocommerce-cart');
        if (cartPage) {
          noticeWrap = document.createElement('div');
          noticeWrap.className = 'woocommerce-notices-wrapper';
          cartPage.insertBefore(noticeWrap, cartPage.firstChild);
        }
      }
      if (noticeWrap) {
        noticeWrap.innerHTML = '<div class="woocommerce-message" role="alert">Cart updated.</div>';
        noticeWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }

      // Asynchronously sync to WooCommerce backend without full page reload
      const form = document.querySelector('form.woocommerce-cart-form');
      if (form) {
        const formData = new FormData(form);
        formData.append('update_cart', 'Update cart');
        fetch(form.getAttribute('action') || window.location.href, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        }).catch((err) => {
          console.warn('WooCommerce cart sync background request:', err);
        });
      }
    };

    // Click Handler on Cart Quantity Buttons & Update Cart Button
    document.addEventListener('click', (e) => {
      // 1. "Update Cart" Button Click
      const updateBtn = e.target.closest('button[name="update_cart"], .ph-update-cart-btn');
      if (updateBtn) {
        e.preventDefault();
        e.stopPropagation();
        window.commitCartUpdates();
        return;
      }

      // 2. Quantity +/- Buttons Click (only updates local draft state)
      const btn = e.target.closest('.ph-qty-btn, .plus, .minus');
      if (!btn) return;

      e.preventDefault();
      e.stopPropagation();

      const wrap = btn.closest('.ph-qty-wrap, .quantity');
      if (!wrap) return;
      const qty = wrap.querySelector('input.qty, input[type=number]');
      if (!qty) return;
      sanitizeQtyMax(qty);

      let currentVal = Number(qty.value);
      if (isNaN(currentVal) || currentVal < 1) {
        currentVal = 1;
      }

      const max = parseInt(qty.max, 10);

      // Precise action identification
      const isPlus = btn.dataset.action === 'plus' ||
                     btn.classList.contains('plus') ||
                     (btn.getAttribute('aria-label') && /increase/i.test(btn.getAttribute('aria-label'))) ||
                     btn.textContent.trim() === '+' ||
                     btn.textContent.includes('+');

      let newQuantity;
      if (isPlus) {
        newQuantity = currentVal + 1;
      } else {
        newQuantity = currentVal - 1;
      }

      newQuantity = Math.max(1, newQuantity);
      if (!isNaN(max) && max > 0) {
        newQuantity = Math.min(newQuantity, max);
      }

      qty.value = String(newQuantity);
      window.checkDraftChanges();
    });

    // Manual typing in quantity input
    document.addEventListener('input', (e) => {
      const qty = e.target.closest('input.qty, input[type=number]');
      if (!qty) return;
      sanitizeQtyMax(qty);
      const val = Number(qty.value);
      if (!isNaN(val) && val < 1) {
        qty.value = '1';
      }
      window.checkDraftChanges();
    });

    // Form submit interception (e.g. Enter key inside input)
    document.addEventListener('submit', (e) => {
      if (e.target && e.target.matches('form.woocommerce-cart-form')) {
        e.preventDefault();
        e.stopPropagation();
        window.commitCartUpdates();
      }
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
      initCartQuantity();
    });
  });

})();
