<?php
$base       = '';
$page_title = 'Forthright & Oak — Construction & Interior Design, Built to Live In';
$page_desc  = 'Design-build construction, interior design, and exterior work for homeowners who want it built once and built right.';
$active     = 'home';
include __DIR__ . '/php/partials/header.php';
?>

<!-- ================= HERO ================= -->
<section class="hero">
  <div class="hero-media">
    <img class="hero-photo" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1800&auto=format&fit=crop" alt="Completed timber-frame residence built by Forthright & Oak">
  </div>

  <svg class="hero-blueprint" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <!-- ground -->
    <line data-draw x1="680" y1="650" x2="1520" y2="650"></line>
    <!-- walls -->
    <line data-draw x1="820" y1="650" x2="820" y2="420"></line>
    <line data-draw x1="1300" y1="650" x2="1300" y2="420"></line>
    <!-- roofline -->
    <line data-draw x1="820" y1="420" x2="1060" y2="255"></line>
    <line data-draw x1="1300" y1="420" x2="1060" y2="255"></line>
    <!-- chimney -->
    <line data-draw x1="1195" y1="345" x2="1195" y2="270"></line>
    <line data-draw x1="1195" y1="270" x2="1245" y2="270"></line>
    <line data-draw x1="1245" y1="270" x2="1245" y2="365"></line>
    <!-- door -->
    <path data-draw d="M 1045 650 L 1045 515 L 1115 515 L 1115 650"></path>
    <!-- window + mullions -->
    <path data-draw d="M 880 565 L 880 475 L 960 475 L 960 565 Z"></path>
    <line data-draw x1="920" y1="475" x2="920" y2="565"></line>
    <line data-draw x1="880" y1="520" x2="960" y2="520"></line>
    <!-- dimension line -->
    <line data-draw x1="820" y1="700" x2="1300" y2="700"></line>
    <line data-draw x1="820" y1="690" x2="820" y2="710"></line>
    <line data-draw x1="1300" y1="690" x2="1300" y2="710"></line>

    <!-- spec-marker tags (stamp in, not drawn) -->
    <g class="fill-tag">
      <circle cx="1060" cy="255" r="5" fill="var(--signal)" stroke="none"></circle>
    </g>
    <g class="fill-tag">
      <circle cx="1080" cy="700" r="5" fill="var(--signal)" stroke="none"></circle>
    </g>
    <g class="fill-tag">
      <circle cx="900" cy="520" r="5" fill="var(--signal)" stroke="none"></circle>
    </g>
  </svg>

  <div class="hero-content hero-stagger">
    <span class="hero-tagline-eyebrow">Design‑Build Studio · Tampa Bay, FL</span>
    <h1>We build it <em>once</em>. We build it right.</h1>
    <p class="hero-sub">From foundation to finish nail, Forthright &amp; Oak plans, builds, and furnishes homes that hold up to real life — not just the photos.</p>
    <div class="hero-actions">
      <a href="contact.php" class="btn btn-primary">Start Your Project <span class="btn-arrow">→</span></a>
      <a href="#projects" class="btn btn-ghost on-dark">See Our Work</a>
    </div>
  </div>

  <div class="hero-scroll">Scroll</div>
</section>

<!-- ================= STATS ================= -->
<div class="stat-strip">
  <div class="container stat-grid">
    <div class="stat"><span class="stat-num" data-count-to="19">0</span><span class="stat-label">Years Building</span></div>
    <div class="stat"><span class="stat-num" data-count-to="214">0</span><span class="stat-label">Projects Completed</span></div>
    <div class="stat"><span class="stat-num" data-count-to="97" data-suffix="%">0%</span><span class="stat-label">Client Referral Rate</span></div>
    <div class="stat"><span class="stat-num" data-count-to="12">0</span><span class="stat-label">Trade Partners In‑House</span></div>
  </div>
</div>

<!-- ================= SERVICES ================= -->
<section id="services">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">What We Do</span>
        <h2>Three trades. One crew. No handoffs.</h2>
      </div>
      <p class="lede">Most homes suffer at the seams between builder, designer, and landscaper. We keep all three under one roof so nothing gets lost in translation.</p>
    </div>
  </div>

  <div class="services-grid">
    <article class="service-card reveal">
      <span class="service-num">01 / Structure</span>
      <h3>Home Building</h3>
      <p>New construction and additions engineered for your site, your climate, and your budget — with a fixed schedule and open books.</p>
      <a class="card-link" href="services/home-building.php">Explore Home Building <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </article>
    <article class="service-card reveal">
      <span class="service-num">02 / Surfaces &amp; Space</span>
      <h3>Interior Design</h3>
      <p>Space planning, materials, lighting, and furnishing — resolved together instead of bolted on after the walls are already closed up.</p>
      <a class="card-link" href="services/interior-design.php">Explore Interior Design <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </article>
    <article class="service-card reveal">
      <span class="service-num">03 / Site &amp; Envelope</span>
      <h3>Exterior Work</h3>
      <p>Decks, siding, hardscape, and landscape design that hold up to weather and still look intentional a decade in.</p>
      <a class="card-link" href="services/exterior-work.php">Explore Exterior Work <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </article>
  </div>
</section>

<!-- ================= PROJECT GALLERY (dynamic, PHP/MySQL-backed) ================= -->
<section id="projects" style="background:var(--paper-2);">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Completed Work</span>
        <h2>A field record, not a highlight reel.</h2>
      </div>
      <p class="lede">Every project below is pulled live from our project database — filter by trade to see recent work in that category.</p>
    </div>

    <div class="gallery-filters" data-gallery-filters>
      <button class="filter-btn is-active" data-filter="all">All Work</button>
      <button class="filter-btn" data-filter="home-building">Home Building</button>
      <button class="filter-btn" data-filter="interior-design">Interior Design</button>
      <button class="filter-btn" data-filter="exterior-work">Exterior Work</button>
    </div>

    <div class="gallery-grid" data-gallery-grid>
      <!-- Populated at runtime by js/main.js from php/get_projects.php -->
    </div>
  </div>
</section>

<!-- ================= PROCESS (a real sequence — numbering earns its keep) ================= -->
<section id="process" class="on-dark">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">How A Project Runs</span>
        <h2>Five stages. Same crew throughout.</h2>
      </div>
    </div>

    <ol class="process-list" style="border-top-color:var(--line-dark);">
      <li class="process-item reveal" style="border-bottom-color:var(--line-dark);">
        <span class="idx">01</span>
        <h3 style="margin:0;">Discovery &amp; Site Walk</h3>
        <p>We walk the site or the existing rooms with you, talk budget honestly, and rule out anything that won't work before you fall in love with it.</p>
      </li>
      <li class="process-item reveal" style="border-bottom-color:var(--line-dark);">
        <span class="idx">02</span>
        <h3 style="margin:0;">Design &amp; Drawings</h3>
        <p>Architectural drawings, material boards, and a real line-item budget — reviewed together until every number and finish is signed off.</p>
      </li>
      <li class="process-item reveal" style="border-bottom-color:var(--line-dark);">
        <span class="idx">03</span>
        <h3 style="margin:0;">Permitting</h3>
        <p>We file, track, and manage every permit and inspection so you're not the one on hold with the county.</p>
      </li>
      <li class="process-item reveal" style="border-bottom-color:var(--line-dark);">
        <span class="idx">04</span>
        <h3 style="margin:0;">Build &amp; Fit‑Out</h3>
        <p>Weekly progress photos and a shared schedule — you always know what happened this week and what's next.</p>
      </li>
      <li class="process-item reveal">
        <span class="idx">05</span>
        <h3 style="margin:0;">Walkthrough &amp; Warranty</h3>
        <p>A room-by-room walkthrough before you move a single box in, backed by a two-year workmanship warranty.</p>
      </li>
    </ol>
  </div>
</section>

<!-- ================= TESTIMONIAL ================= -->
<section>
  <div class="container reveal">
    <span class="spec-label">In Their Words</span>
    <blockquote class="testimonial">
      "They kept us informed at every framing milestone and the final walkthrough had zero surprises. It's the first contractor experience we've had that didn't feel like a negotiation."
      <cite>— J. &amp; M. Alvarez, Hollow Creek Residence</cite>
    </blockquote>
  </div>
</section>

<!-- ================= MATERIAL MARQUEE ================= -->
<div class="marquee">
  <div class="marquee-track" style="padding:1.4rem 0; font-family:var(--font-mono); font-size:0.78rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--concrete-2);">
    <span>Reclaimed Oak</span><span>Standing‑Seam Metal</span><span>Poured Concrete</span><span>Cedar Shake</span><span>Cable Rail</span><span>Limewash Plaster</span><span>White Oak Millwork</span>
    <span>Reclaimed Oak</span><span>Standing‑Seam Metal</span><span>Poured Concrete</span><span>Cedar Shake</span><span>Cable Rail</span><span>Limewash Plaster</span><span>White Oak Millwork</span>
  </div>
</div>

<!-- ================= CTA ================= -->
<section>
  <div class="container reveal" style="text-align:center;">
    <span class="spec-label" style="justify-content:center;">Ready When You Are</span>
    <h2>Tell us about the project you keep putting off.</h2>
    <div class="hero-actions" style="justify-content:center;">
      <a href="contact.php" class="btn btn-primary">Request a Consultation</a>
      <a href="tel:+18135550142" class="btn btn-ghost" style="border-color:var(--ink);">Call (813) 555‑0142</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/php/partials/footer.php'; ?>
