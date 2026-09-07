<?php
$base       = '../';
$page_title = 'Interior Design — Forthright & Oak';
$page_desc  = 'Space planning, materials, lighting, and furnishing designed alongside your build — not bolted on after the walls close.';
$active     = 'interior-design';
include __DIR__ . '/../php/partials/header.php';
?>

<section class="page-hero container">
  <div class="reveal">
    <span class="spec-label">Service 02 / Surfaces &amp; Space</span>
    <h1 style="font-size:clamp(2.5rem,6vw,4.5rem);">Interior Design</h1>
    <p class="lede">We design interiors while the walls are still open, so the electrical, the millwork, and the furniture all agree with each other.</p>
    <div class="hero-actions">
      <a href="../contact.php" class="btn btn-primary">Book a Design Consult</a>
    </div>
  </div>
  <div class="reveal">
    <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1200&auto=format&fit=crop" alt="Open-plan kitchen and living space interior design" style="aspect-ratio:4/3; object-fit:cover; width:100%;">
  </div>
</section>

<section>
  <div class="container feature-split reverse">
    <div class="feature-media reveal">
      <img src="https://images.unsplash.com/photo-1615529182904-14819c35db37?q=80&w=1200&auto=format&fit=crop" alt="Custom millwork reading nook">
    </div>
    <div class="reveal">
      <span class="spec-label">What's Included</span>
      <h2>Every finish decided on purpose, not by default.</h2>
      <p>Space planning, lighting design, material and color palettes, custom millwork, and furnishing — coordinated with the build schedule so nothing gets ordered twice or installed out of sequence.</p>
      <ul class="feature-list">
        <li>Full-home or single-room design packages</li>
        <li>Lighting plans &amp; electrical coordination</li>
        <li>Custom millwork &amp; built-ins</li>
        <li>Material, tile &amp; fixture sourcing</li>
        <li>Furniture selection &amp; installation day</li>
      </ul>
    </div>
  </div>
</section>

<section class="on-dark">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Recent Interiors</span>
        <h2>Rooms we've resolved.</h2>
      </div>
      <a href="../index.php#projects" class="btn btn-ghost on-dark">View Full Portfolio</a>
    </div>
    <div class="gallery-grid" data-gallery-grid data-category="interior-design"></div>
  </div>
</section>

<section>
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="spec-label">Investment</span>
        <h2>Three ways to start.</h2>
      </div>
      <p class="lede">Design fees scale with scope — these reflect the packages most clients begin with.</p>
    </div>

    <div class="package-grid">
      <div class="package-card reveal">
        <span class="spec-label">Focused</span>
        <h3>Single Room</h3>
        <div class="package-price">From $6,500</div>
        <p>A kitchen, primary suite, or living space designed and furnished start to finish.</p>
        <ul class="feature-list">
          <li>Space plan &amp; material board</li>
          <li>Lighting &amp; fixture selection</li>
          <li>4–6 week design timeline</li>
        </ul>
        <a href="../contact.php" class="btn">Ask About This</a>
      </div>

      <div class="package-card is-featured reveal">
        <span class="spec-label">Most Requested</span>
        <h3>Whole-Home Design</h3>
        <div class="package-price">From $22,000</div>
        <p>Every room designed against one cohesive material and lighting language.</p>
        <ul class="feature-list">
          <li>Full space planning &amp; millwork design</li>
          <li>Coordinated with your build schedule</li>
          <li>10–14 week design timeline</li>
        </ul>
        <a href="../contact.php" class="btn btn-primary">Start Here</a>
      </div>

      <div class="package-card reveal">
        <span class="spec-label">Ongoing</span>
        <h3>Design Retainer</h3>
        <div class="package-price">$1,200/mo</div>
        <p>Continued sourcing, seasonal refreshes, and new-room design as your home evolves.</p>
        <ul class="feature-list">
          <li>Priority scheduling</li>
          <li>Quarterly walkthrough &amp; refresh</li>
          <li>No minimum term</li>
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
        <button class="accordion-trigger" aria-expanded="false">Can you design a space without also building it?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>Yes. Design-only engagements are common, especially for furnishing and material selection in homes we didn't build. We'll flag anything that would benefit from coordinating with a contractor.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">Do I have to use your furniture sources?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>No. We'll recommend trade sources for better pricing and lead times, but you're always free to supply your own pieces — we'll design around them.</p></div></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger" aria-expanded="false">How involved will I be in decisions?</button>
        <div class="accordion-panel"><div class="accordion-panel-inner"><p>As involved as you want. Most clients review and approve at three checkpoints — concept, materials, and final furnishing plan — rather than every individual selection.</p></div></div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>
