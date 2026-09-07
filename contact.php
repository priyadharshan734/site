<?php
$base       = '';
$page_title = 'Contact — Forthright & Oak';
$page_desc  = 'Tell us about your project. Call, email, or send details through the form and we will reply within one business day.';
$active     = 'contact';
include __DIR__ . '/php/partials/header.php';
?>

<section style="padding-top:6rem;">
  <div class="container reveal">
    <span class="spec-label">Get In Touch</span>
    <h1 style="max-width:16ch;">Let's talk about the project you keep putting off.</h1>
    <p class="lede" style="max-width:56ch;">Tell us a little about what you have in mind. We reply to every inquiry within one business day — no automated sales sequence, just a real answer from our office.</p>
  </div>
</section>

<section style="padding-top:1rem;">
  <div class="container contact-grid">

    <div class="reveal">
      <span class="spec-label">Reach Us Directly</span>

      <div class="contact-detail">
        <span class="k">Phone</span>
        <a href="tel:+18135550142">(813) 555‑0142</a>
      </div>
      <div class="contact-detail">
        <span class="k">Email</span>
        <a href="mailto:projects@forthrightandoak.com">projects@forthrightandoak.com</a>
      </div>
      <div class="contact-detail">
        <span class="k">Office</span>
        <span>412 Millwright Ave<br>Tampa, FL 33602</span>
      </div>
      <div class="contact-detail">
        <span class="k">Hours</span>
        <span>Mon–Fri, 7:30am–5:00pm ET<br>Site visits by appointment, Saturdays</span>
      </div>
      <div class="contact-detail" style="border-bottom:none;">
        <span class="k">License</span>
        <span>General Contractor #CGC‑04471</span>
      </div>
    </div>

    <div class="reveal">
      <span class="spec-label">Send Project Details</span>
      <form id="contact-form" novalidate>
        <!-- Honeypot: hidden from real users, some bots will fill it in -->
        <div style="position:absolute; left:-9999px;" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-row">
          <div class="field">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required minlength="2" autocomplete="name">
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email">
          </div>
        </div>

        <div class="form-row">
          <div class="field">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required autocomplete="tel">
          </div>
          <div class="field">
            <label for="service">Service Interested In</label>
            <select id="service" name="service">
              <option value="">Not sure yet</option>
              <option value="home-building">Home Building</option>
              <option value="interior-design">Interior Design</option>
              <option value="exterior-work">Exterior Work</option>
            </select>
          </div>
        </div>

        <div class="field">
          <label for="message">Project Details</label>
          <textarea id="message" name="message" required minlength="10" placeholder="Tell us about your space, timeline, and budget range."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Message <span class="btn-arrow">→</span></button>
        <p class="form-status" role="status" aria-live="polite"></p>
      </form>
    </div>

  </div>
</section>

<section style="padding-top:0;">
  <div class="container reveal">
    <div style="aspect-ratio:16/6; overflow:hidden; border:1px solid var(--line);">
      <iframe
        title="Forthright & Oak office location map"
        src="https://www.google.com/maps?q=Tampa,FL&output=embed"
        style="width:100%; height:100%; border:0;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<?php include __DIR__ . '/php/partials/footer.php'; ?>
