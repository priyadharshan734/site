<?php
$base       = '../';
$page_title = 'Exterior Work — Forthright & Oak';
$page_desc  = 'Decks, siding, hardscape, and landscape design that hold up to weather and still look intentional a decade in.';
$active     = 'exterior-work';
include __DIR__ . '/../php/partials/header.php';
?>

<section class="page-hero container">
  <div class="reveal">
    <span class="spec-label">Service 03 / Site &amp; Envelope</span>
    <h1 style="font-size:clamp(2.5rem,6vw,4.5rem);">Exterior Work</h1>
    <p class="lede">The outside of your home takes the most weather and the least attention. We build it to outlast the trend cycle.</p>
    <div class="hero-actions">
      <a href="../contact.php" class="btn btn-primary">Request a Site Visit</a>
    </div>
  </div>
  <div class="reveal">
    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1200&auto=format&fit=crop" alt="Cedar deck and pergola exterior build" style="aspect-ratio:4/3; object-fit:cover; width:100%;">
  </div>
</section>

<section>
  <div class="container feature-split">
    <div class="feature-media reveal">
      <img src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?q=80&w=1200&auto=format&fit=crop" alt="Regraded landscape with native planting">
    </div>
    <div class="reveal">
      <span class="spec-label">What's Included</span>
      <h2>Structure, drainage, and planting — in that order.</h2>
      <p>Good exterior work starts underground: grading and drainage before a single paver or post goes in. From there we build decks, siding, hardscape, and planting plans that are engineered for your climate, not just your Pinterest board.</p>
      <ul class="feature-list">
        <li>Decks, pergolas &amp; outdoor living structures</li>
        <li>Siding, trim &amp; exterior envelope repair</li>
        <li>Grading, drainage &amp; retaining walls</li>
        <li>Hardscape: patios, walkways, driveways</li>
        <li>Landscape design &amp; native planting plans</li>
      </ul>
    </div>
  </div>
</section>

<section class="on-dark">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Recent Sitework</span>
        <h2>Outdoor spaces we've shaped.</h2>
      </div>
      <a href="../index.php#projects" class="btn btn-ghost on-dark">View Full Portfolio</a>
    </div>
    <div class="gallery-grid" data-gallery-grid data-category="exterior-work"></div>
  </div>
</section>

<section>
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Investment</span>
        <h2>Three ways to start.</h2>
      </div>
      <p class="lede">Sitework is quoted after a site visit and soil/drainage assessment — these are typical starting scopes.</p>
    </div>

    <div class="package-grid">
      <div class="package-card reveal">
        <span class="spec-label">Weekend Upgrade</span>
        <h3>Deck or Patio</h3>
        <div class="package-price">From $18,000</div>
        <p>A single deck, patio, or paved area sized to your yard and how you actually use it.</p>
        <ul class="feature-list">
          <li>200–500 sq ft typical scope</li>
          <li>Material &amp; railing selection included</li>
          <li>2–4 week build timeline</li>
        </ul>
        <a href="../contact.php" class="btn">Ask About This</a>
      </div>

      <div class="package-card is-featured reveal">
        <span class="spec-label">Most Requested</span>
        <h3>Outdoor Living Package</h3>
        <div class="package-price">From $54,000</div>
        <p>Deck or patio plus pergola, lighting, and a planting plan designed as one connected space.</p>
        <ul class="feature-list">
          <li>Structure, lighting &amp; planting coordinated</li>
          <li>Drainage assessment included</li>
          <li>6–9 week build timeline</li>
        </ul>
        <a href="../contact.php" class="btn btn-primary">Start Here</a>
      </div>

      <div class="package-card reveal">
        <span class="spec-label">Full Lot</span>
        <h3>Site &amp; Landscape Overhaul</h3>
        <div class="package-price">From $110,000</div>
        <p>Full-lot regrading, hardscape, retaining structures, and a complete landscape design.</p>
        <ul class="feature-list">
          <li>Engineered drainage &amp; grading plan</li>
          <li>Retaining walls &amp; hardscape</li>
          <li>10–14 week build timeline</li>
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
        <button class="accordion-trigger" aria-expanded="false">Do you handle drainage problems, or just build over them?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>We assess grading and drainage before quoting any hardscape or structure — building over a drainage problem just moves it somewhere more expensive to fix later.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">What materials hold up best in your climate?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>For Gulf Coast humidity and sun, we typically recommend thermally modified wood or composite decking, stainless fasteners, and native or drought-tolerant planting — we'll walk you through trade-offs on cost versus maintenance.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">Can exterior work happen while you're building or renovating the interior?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>Often yes — site work and structural exteriors can run in parallel with interior fit-out, which is one of the advantages of having one crew coordinate the whole schedule.</p></div></div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>
