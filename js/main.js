/**
 * Forthright & Oak — front-end behavior
 * No framework, no build step: vanilla DOM + fetch, progressively enhanced.
 * Every module below no-ops quietly if its markup isn't on the page,
 * so this single file can be shared across every template.
 */
(() => {
  'use strict';

  const $  = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------------------------------------------------------------------
   * 1. Mobile navigation
   * ------------------------------------------------------------------- */
  function initNav() {
    const toggle = $('.nav-toggle');
    const links = $('.nav-links');
    if (!toggle || !links) return;

    toggle.addEventListener('click', () => {
      const open = links.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    links.addEventListener('click', (e) => {
      if (e.target.tagName === 'A') {
        links.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });

    // Header shadow / compact state on scroll
    const header = $('.site-header');
    let lastY = window.scrollY;
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      header.style.boxShadow = y > 8 ? '0 1px 0 rgba(28,27,25,0.08)' : 'none';
      lastY = y;
    }, { passive: true });
  }

  /* ---------------------------------------------------------------------
   * 2. Hero blueprint draw-on sequence
   *    Each SVG path/line gets its real stroke length measured at runtime
   *    (so it works regardless of how the artwork changes), then the
   *    lines draw in order, tags stamp in, and the real photograph
   *    crossfades over the finished line drawing.
   * ------------------------------------------------------------------- */
  function initHeroBlueprint() {
    const svg = $('.hero-blueprint');
    const photo = $('.hero-photo');
    if (!svg) return;

    const drawables = $$('[data-draw]', svg);
    drawables.forEach((el, i) => {
      const len = typeof el.getTotalLength === 'function' ? el.getTotalLength() : 400;
      el.style.setProperty('--len', len);
      el.style.setProperty('--delay', `${i * 0.16}s`);
    });

    const tags = $$('.fill-tag', svg);
    const lastLineDelay = drawables.length * 0.16 + 1.8;
    tags.forEach((tag, i) => {
      tag.style.setProperty('--delay', `${lastLineDelay + i * 0.12}s`);
    });

    if (prefersReducedMotion) {
      if (photo) photo.classList.add('is-revealed');
      return;
    }

    requestAnimationFrame(() => {
      drawables.forEach(el => el.classList.add('is-drawing'));
      tags.forEach(el => el.classList.add('is-stamped'));
    });

    if (photo) {
      const revealAt = (lastLineDelay + 0.6) * 1000;
      setTimeout(() => photo.classList.add('is-revealed'), revealAt);
    }
  }

  /* ---------------------------------------------------------------------
   * 3. Scroll reveals via IntersectionObserver
   * ------------------------------------------------------------------- */
  function initReveals() {
    const items = $$('.reveal');
    if (!items.length) return;

    if (!('IntersectionObserver' in window) || prefersReducedMotion) {
      items.forEach(el => el.classList.add('is-visible'));
      return;
    }

    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    items.forEach(el => io.observe(el));
  }

  /* ---------------------------------------------------------------------
   * 4. Stat counters — animate integers up when the strip enters view
   * ------------------------------------------------------------------- */
  function initStatCounters() {
    const stats = $$('.stat-num[data-count-to]');
    if (!stats.length) return;

    const animate = (el) => {
      const target = parseFloat(el.dataset.countTo);
      const suffix = el.dataset.suffix || '';
      const duration = 1400;
      const start = performance.now();

      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.round(target * eased);
        el.textContent = value.toLocaleString() + suffix;
        el.classList.add('is-counting');
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };

    if (!('IntersectionObserver' in window)) { stats.forEach(animate); return; }

    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animate(entry.target);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });
    stats.forEach(el => io.observe(el));
  }

  /* ---------------------------------------------------------------------
   * 5. Project gallery — fetches from php/get_projects.php.
   *    Falls back to bundled sample data if the endpoint is unreachable
   *    (e.g. viewing the static files without a PHP server), so the page
   *    still demonstrates the intended behaviour.
   * ------------------------------------------------------------------- */
  const FALLBACK_PROJECTS = [
    { id: 1, title: 'Hollow Creek Residence', category: 'home-building', location: 'Hollow Creek, VT', image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop' },
    { id: 2, title: 'Birchwood Kitchen & Living', category: 'interior-design', location: 'Birchwood, MA', image: 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1200&auto=format&fit=crop' },
    { id: 3, title: 'Ridgeline Deck & Pergola', category: 'exterior-work', location: 'Ridgeline, CO', image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1200&auto=format&fit=crop' },
    { id: 4, title: 'Alder Street Addition', category: 'home-building', location: 'Alder Street, OR', image: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1200&auto=format&fit=crop' },
    { id: 5, title: 'Maple Loft Study', category: 'interior-design', location: 'Maple Loft, NY', image: 'https://images.unsplash.com/photo-1615529182904-14819c35db37?q=80&w=1200&auto=format&fit=crop' },
    { id: 6, title: 'Cedar Point Landscape', category: 'exterior-work', location: 'Cedar Point, WA', image: 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?q=80&w=1200&auto=format&fit=crop' },
  ];

  async function loadProjects() {
    const grid = $('[data-gallery-grid]');
    if (!grid) return;

    const onlyCategory = grid.dataset.category || null; // service pages preset a single category
    const endpoint = onlyCategory
      ? `../php/get_projects.php?category=${encodeURIComponent(onlyCategory)}`
      : 'php/get_projects.php';

    let projects = onlyCategory
      ? FALLBACK_PROJECTS.filter(p => p.category === onlyCategory)
      : FALLBACK_PROJECTS;

    try {
      const res = await fetch(endpoint, { headers: { 'Accept': 'application/json' } });
      if (res.ok) {
        const data = await res.json();
        if (Array.isArray(data) && data.length) projects = data;
      }
    } catch (_) {
      /* static preview mode — fallback data already assigned */
    }

    renderProjects(grid, projects);
    initGalleryFilters(projects, grid);
  }

  function renderProjects(grid, projects) {
    grid.innerHTML = projects.map(p => `
      <article class="project-card reveal" data-category="${p.category}">
        <img src="${p.image}" alt="${escapeHtml(p.title)} — completed project" loading="lazy">
        <div class="project-info">
          <span class="spec-label">${labelFor(p.category)}</span>
          <h4>${escapeHtml(p.title)}</h4>
        </div>
      </article>
    `).join('');
    // re-run reveal observer on freshly injected nodes
    $$('.reveal', grid).forEach(el => el.classList.add('is-visible'));
  }

  function labelFor(cat) {
    return ({
      'home-building': 'Home Building',
      'interior-design': 'Interior Design',
      'exterior-work': 'Exterior Work'
    })[cat] || cat;
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function initGalleryFilters(projects, grid) {
    const filterBar = $('[data-gallery-filters]');
    if (!filterBar) return;

    filterBar.addEventListener('click', (e) => {
      const btn = e.target.closest('.filter-btn');
      if (!btn) return;

      $$('.filter-btn', filterBar).forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');

      const filter = btn.dataset.filter;
      $$('.project-card', grid).forEach(card => {
        const match = filter === 'all' || card.dataset.category === filter;
        card.classList.toggle('is-hidden', !match);
      });
    });
  }

  /* ---------------------------------------------------------------------
   * 6. Accordion (service page FAQs)
   * ------------------------------------------------------------------- */
  function initAccordion() {
    $$('.accordion-trigger').forEach(trigger => {
      trigger.addEventListener('click', () => {
        const item = trigger.closest('.accordion-item');
        const panel = $('.accordion-panel', item);
        const isOpen = trigger.getAttribute('aria-expanded') === 'true';

        trigger.setAttribute('aria-expanded', String(!isOpen));
        item.classList.toggle('is-open', !isOpen);
        panel.style.maxHeight = isOpen ? '0px' : panel.scrollHeight + 'px';
      });
    });
  }

  /* ---------------------------------------------------------------------
   * 7. Contact form — client-side validation + fetch to contact_handler.php
   * ------------------------------------------------------------------- */
  function initContactForm() {
    const form = $('#contact-form');
    if (!form) return;

    const status = $('.form-status', form.parentElement) || (() => {
      const el = document.createElement('p');
      el.className = 'form-status';
      form.appendChild(el);
      return el;
    })();

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      status.textContent = '';
      status.className = 'form-status';

      const data = Object.fromEntries(new FormData(form).entries());
      const errors = validateContact(data);

      if (errors.length) {
        status.textContent = errors.join(' ');
        status.classList.add('err');
        return;
      }

      const submitBtn = $('button[type="submit"]', form);
      const originalLabel = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="btn-spinner"></span> Sending';

      try {
        const res = await fetch('php/contact_handler.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });
        const result = await res.json().catch(() => ({ success: res.ok }));

        if (res.ok && result.success !== false) {
          status.textContent = result.message || 'Message sent — we\u2019ll be in touch within one business day.';
          status.classList.add('ok');
          form.reset();
          showToast('Thanks — your message is on its way to our team.');
        } else {
          throw new Error(result.message || 'Something went wrong.');
        }
      } catch (err) {
        status.textContent = 'We couldn\u2019t send that just now — please call us directly or try again shortly.';
        status.classList.add('err');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalLabel;
      }
    });
  }

  function validateContact(data) {
    const errors = [];
    if (!data.name || data.name.trim().length < 2) errors.push('Please enter your name.');
    if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) errors.push('Please enter a valid email.');
    if (!data.phone || data.phone.replace(/\D/g, '').length < 7) errors.push('Please enter a valid phone number.');
    if (!data.message || data.message.trim().length < 10) errors.push('Tell us a little more about your project (10+ characters).');
    return errors;
  }

  function showToast(message) {
    let toast = $('.toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.className = 'toast';
      document.body.appendChild(toast);
    }
    toast.textContent = message;
    requestAnimationFrame(() => toast.classList.add('is-shown'));
    clearTimeout(showToast._t);
    showToast._t = setTimeout(() => toast.classList.remove('is-shown'), 4500);
  }

  /* ---------------------------------------------------------------------
   * 8. Active nav link (works without server templating)
   * ------------------------------------------------------------------- */
  function markActiveNav() {
    const path = window.location.pathname.split('/').pop() || 'index.html';
    $$('.nav-links a').forEach(a => {
      const href = a.getAttribute('href').split('/').pop();
      if (href === path) a.setAttribute('aria-current', 'page');
    });
  }

  /* ---------------------------------------------------------------------
   * Boot
   * ------------------------------------------------------------------- */
  document.addEventListener('DOMContentLoaded', () => {
    initNav();
    markActiveNav();
    initHeroBlueprint();
    initReveals();
    initStatCounters();
    loadProjects();
    initAccordion();
    initContactForm();
  });
})();
