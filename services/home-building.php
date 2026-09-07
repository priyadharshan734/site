<?php
$base       = '../';
$page_title = 'Home Building — Forthright & Oak';
$page_desc  = 'Ground-up home construction and additions, engineered for your site and built by one accountable crew.';
$active     = 'home-building';
include __DIR__ . '/../php/partials/header.php';
?>

<section class="page-hero container">
  <div class="reveal">
    <span class="spec-label">Service 01 / Structure</span>
    <h1 style="font-size:clamp(2.5rem,6vw,4.5rem);">Home Building</h1>
    <p class="lede">New construction and additions built from a fixed schedule and an open budget — so the only surprises are the good kind.</p>
    <div class="hero-actions">
      <a href="../contact.php" class="btn btn-primary">Request a Site Visit</a>
    </div>
  </div>
  <div class="reveal">
    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop" alt="Timber-frame home under construction" style="aspect-ratio:4/3; object-fit:cover; width:100%;">
  </div>
</section>

<section>
  <div class="container feature-split">
    <div class="feature-media reveal">
      <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1200&auto=format&fit=crop" alt="Framing crew working on a second-story addition">
    </div>
    <div class="reveal">
      <span class="spec-label">What's Included</span>
      <h2>From foundation drawings to the final punch list.</h2>
      <p>We handle structural engineering, permitting, site work, framing, mechanical/electrical/plumbing coordination, and finish carpentry under one contract — so you have one point of contact from groundbreaking to move-in.</p>
      <ul class="feature-list">
        <li>Custom new builds, 1,200–6,000 sq ft</li>
        <li>Second-story and single-story additions</li>
        <li>Foundation, framing &amp; structural engineering</li>
        <li>Full permitting &amp; inspection management</li>
        <li>Energy-efficient envelope &amp; window packages</li>
      </ul>
    </div>
  </div>
</section>

<section class="on-dark">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Recent Builds</span>
        <h2>Homes we've broken ground on.</h2>
      </div>
      <a href="../index.php#projects" class="btn btn-ghost on-dark">View Full Portfolio</a>
    </div>
    <div class="gallery-grid" data-gallery-grid data-category="home-building"></div>
  </div>
</section>

<section>
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Investment</span>
        <h2>Three ways to start.</h2>
      </div>
      <p class="lede">Every build is custom-quoted after a site visit — these are the typical starting scopes we're asked for most.</p>
    </div>

    <div class="package-grid">
      <div class="package-card reveal">
        <span class="spec-label">Addition</span>
        <h3>Room Addition</h3>
        <div class="package-price">From $185k</div>
        <p>A single or second-story addition matched to your home's existing structure and character.</p>
        <ul class="feature-list">
          <li>400–900 sq ft typical scope</li>
          <li>Structural tie-in engineering included</li>
          <li>8–12 week build timeline</li>
        </ul>
        <a href="../contact.php" class="btn">Ask About This</a>
      </div>

      <div class="package-card is-featured reveal">
        <span class="spec-label">Most Requested</span>
        <h3>Custom Home</h3>
        <div class="package-price">From $420k</div>
        <p>Ground-up construction on your lot, from a design we develop with you or drawings you already have.</p>
        <ul class="feature-list">
          <li>1,800–4,000 sq ft typical scope</li>
          <li>Full architectural &amp; engineering package</li>
          <li>7–11 month build timeline</li>
        </ul>
        <a href="../contact.php" class="btn btn-primary">Start Here</a>
      </div>

      <div class="package-card reveal">
        <span class="spec-label">Legacy</span>
        <h3>Estate Build</h3>
        <div class="package-price">From $900k</div>
        <p>Larger-format homes with expanded structural, mechanical, and finish scope, project-managed in-house.</p>
        <ul class="feature-list">
          <li>4,000+ sq ft typical scope</li>
          <li>Dedicated project manager on site weekly</li>
          <li>12–18 month build timeline</li>
        </ul>
        <a href="../contact.php" class="btn">Ask About This</a>
      </div>
    </div>
  </div>
</section>

<section style="background:var(--paper-2);">
  <div class="container" style="max-width:840px;">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Common Questions</span>
        <h2>Before you call.</h2>
      </div>
    </div>

    <div class="accordion reveal">
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">How long does permitting take?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>In most of our service area, plan review runs 3–6 weeks for additions and 6–10 weeks for new construction. We submit the day drawings are finalized and track every review comment so nothing sits idle.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">Do you subcontract or use in-house crews?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>Framing, site work, and project management are in-house. Electrical, plumbing, and HVAC are licensed trade partners we've worked with for years — not the low bidder from that week.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">Can I make changes once construction starts?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>Yes — through a documented change order that shows the cost and schedule impact before you approve it, so nothing shows up as a surprise on an invoice.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">What warranty is included?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>Every build carries a two-year workmanship warranty in addition to manufacturer warranties on materials and mechanical systems.</p></div></div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>
