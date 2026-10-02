<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'top-includes.php' ?>
</head>

<body>

  <?php include 'header.php' ?>

  <section class="about-hero7" id="hero">
    <div class="about-hero-overlay"></div>
    <div class="about-hero-content">
      <div class="slide-eyebrow">
        <div class="eyebrow-line"></div>
        <span class="eyebrow-text">Contact Us · SUN-X Group</span>
      </div>
      <h1 class="about-hero-title">LET'S <span class="red">CONNECT</span></h1>
      <p class="about-hero-subtitle">Have a project in mind? Reach out to our team for quotes, technical support, plant
        visits or partnership enquiries we're here to help.</p>
    </div>
  </section>

  <div class="contact-page">

    <!-- header -->
    <div class="contact-header">
      <h1>Talk to our friendly <span style="color: #fec403;">team</span></h1>
      <p>We'll help you find the right concrete solution, no matter your project size.</p>
    </div>

    <!-- body -->
    <div class="contact-body">

      <!-- LEFT: form -->
      <div class="contact-form">

        <!-- ── Type Toggle ── -->
        <div class="form-type-toggle">
          <div class="form-type-track">
            <div class="form-type-indicator" id="typeIndicator"></div>
            <button class="form-type-btn active" id="btnIndividual" data-type="individual">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
              Individual
            </button>
            <button class="form-type-btn" id="btnCompany" data-type="company">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" />
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
              </svg>
              Company
            </button>
          </div>
        </div>

        <!-- ── Individual fields ── -->
        <div class="form-mode" id="modeIndividual">
          <div class="form-row">
            <div class="form-field">
              <label class="form-label">First name <span class="req">*</span></label>
              <input class="form-input" id="contactFirstName" name="first_name" type="text" placeholder="First name" />
            </div>
            <div class="form-field">
              <label class="form-label">Last name <span class="req">*</span></label>
              <input class="form-input" id="contactLastName" name="second_name" type="text" placeholder="Last name" />
            </div>
          </div>
        </div>

        <!-- ── Company fields ── -->
        <div class="form-mode" id="modeCompany" style="display:none;">
          <div class="form-field">
            <label class="form-label">Company Name <span class="req">*</span></label>
            <input class="form-input" id="contactCompanyName" name="company_name" type="text"
              placeholder="e.g. SUN-X Concrete Pvt Ltd" />
          </div>
        </div>

        <!-- ── Shared fields ── -->
        <div class="form-field">
          <label class="form-label">Email <span class="req">*</span></label>
          <input class="form-input" id="contactEmail" type="email" name="email" placeholder="you@company.com" />
        </div>

        <div class="form-field">
          <label class="form-label">Phone number</label>
          <div class="phone-wrap">
            <div class="custom-phone-select" id="customPhoneSelect">
              <div class="cps-selected" id="cpsSelected">
                <img id="flagImg"
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA9UlEQVR4nO2UPQ6CQBCF51gUngV6Qi23IKHjGkqhDQewBCw8gLh0VFs/M1sZfzoQx7wveclkt3nfsosIIYQQ8g+gEliKUKCiACjwyNqFQIFq/VKgQGVYwHsPS5ElBZybsN02SNNDSJ43Yc2EgHMTkqTG+ezQtld03RDmON7PKiFLCejJa+G6vqAsTyE69/0t7P28QJoe0bZDKJ5lxxCd9WvonhGB6xuBwYZAnjfoutvLFdI13ft5AecmxPEu3Hk9dX3EOusjHkcDj9h/+I3OWd4vLfCNyDNRsYGlCAUKCoACj6xdKKJAsX6piAKFYQFCCCFEDHIHYAJaJ5T9GcsAAAAASUVORK5CYII="
                  alt="IN" width="22" height="15" />
                <span id="cpsCode">+91</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#700707" stroke-width="2.5"
                  stroke-linecap="round">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </div>
              <div class="cps-dropdown" id="cpsDropdown">
                <div class="cps-option" data-code="+91"
                  data-flag="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA9UlEQVR4nO2UPQ6CQBCF51gUngV6Qi23IKHjGkqhDQewBCw8gLh0VFs/M1sZfzoQx7wveclkt3nfsosIIYQQ8g+gEliKUKCiACjwyNqFQIFq/VKgQGVYwHsPS5ElBZybsN02SNNDSJ43Yc2EgHMTkqTG+ezQtld03RDmON7PKiFLCejJa+G6vqAsTyE69/0t7P28QJoe0bZDKJ5lxxCd9WvonhGB6xuBwYZAnjfoutvLFdI13ft5AecmxPEu3Hk9dX3EOusjHkcDj9h/+I3OWd4vLfCNyDNRsYGlCAUKCoACj6xdKKJAsX6piAKFYQFCCCFEDHIHYAJaJ5T9GcsAAAAASUVORK5CYII="
                  data-alt="IN">
                  <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA9UlEQVR4nO2UPQ6CQBCF51gUngV6Qi23IKHjGkqhDQewBCw8gLh0VFs/M1sZfzoQx7wveclkt3nfsosIIYQQ8g+gEliKUKCiACjwyNqFQIFq/VKgQGVYwHsPS5ElBZybsN02SNNDSJ43Yc2EgHMTkqTG+ezQtld03RDmON7PKiFLCejJa+G6vqAsTyE69/0t7P28QJoe0bZDKJ5lxxCd9WvonhGB6xuBwYZAnjfoutvLFdI13ft5AecmxPEu3Hk9dX3EOusjHkcDj9h/+I3OWd4vLfCNyDNRsYGlCAUKCoACj6xdKKJAsX6piAKFYQFCCCFEDHIHYAJaJ5T9GcsAAAAASUVORK5CYII="
                    alt="IN" width="22" height="15" />
                  <span>IN &nbsp;+91</span>
                </div>
                <div class="cps-option" data-code="+971"
                  data-flag="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAY0lEQVR4nO3PsQnEMBAAwavKOPjovj9VahAG5fepQofSexa2gImQJOkfGt+jnny2zxIHQAMogDmABlAA4w2Aq99LHAAdoADmADpAAYw3ADJziQMgAQpgDiABCmDsDJAkKTbsB4q949k7s9xrAAAAAElFTkSuQmCC"
                  data-alt="AE">
                  <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAY0lEQVR4nO3PsQnEMBAAwavKOPjovj9VahAG5fepQofSexa2gImQJOkfGt+jnny2zxIHQAMogDmABlAA4w2Aq99LHAAdoADmADpAAYw3ADJziQMgAQpgDiABCmDsDJAkKTbsB4q949k7s9xrAAAAAElFTkSuQmCC"
                    alt="AE" width="22" height="15" />
                  <span>UAE &nbsp;+971</span>
                </div>
              </div>
              <input type="hidden" id="phoneCountry" value="+91" />
            </div>
            <input class="phone-num" type="tel" id="phoneNum" placeholder="98765 43210" inputmode="numeric"
              maxlength="10" />
          </div>
        </div>

        <div class="form-field">
          <label class="form-label">Message <span class="req">*</span></label>
          <textarea class="form-textarea" id="contactMessage" name="message"
            placeholder="Leave us a message..."></textarea>
        </div>

        <div class="form-field">
          <div class="cb-label">Services</div>
          <div class="cb-grid">
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span class="cb-text">Ready-Mix
                Concrete</span></label>
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span class="cb-text">Bulk
                Orders</span></label>
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span class="cb-text">Site
                Consultation</span></label>
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span class="cb-text">Project
                Planning</span></label>
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span class="cb-text">Quality
                Testing</span></label>
            <label class="cb-item"><input type="checkbox" /><span class="cb-box"></span><span
                class="cb-text">Other</span></label>
          </div>
        </div>

        <button class="form-submit">Send message</button>

      </div>

      <!-- RIGHT: info -->
      <div class="contact-info">

        <div class="info-block">
          <div class="info-block-title">Chat with us</div>
          <div class="info-block-sub">Speak to our friendly team via email or phone.</div>
          <div class="info-links">
            <a href="mailto:info@sunxconcrete.com" class="info-link">
              <span class="info-link-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                  <polyline points="22,6 12,13 2,6" />
                </svg>
              </span>
              info@sunxconcrete.com
            </a>
            <a href="https://wa.me/919940400050" class="info-link">
              <span class="info-link-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
              </span>
              Message us on WhatsApp
            </a>
          </div>
        </div>

        <div class="info-divider"></div>

        <div class="info-block">
          <div class="info-block-title">Call us</div>
          <div class="info-block-sub">Call our team Mon–Sat from 9am to 6pm.</div>
          <div class="info-links">
            <a href="tel:+919940400050" class="info-link">
              <span class="info-link-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z" />
                </svg>
              </span>
              +91 99404 00050
            </a>
            <a href="tel:+918807147050" class="info-link">
              <span class="info-link-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z" />
                </svg>
              </span>
              +91 88071 47050
            </a>
            <a href="tel:+919384860816" class="info-link">
              <span class="info-link-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z" />
                </svg>
              </span>
              +91 93848 60816
            </a>
          </div>
        </div>

        <div class="info-divider"></div>

        <!-- <div class="info-block">
          <div class="info-block-title">Visit us</div>
          <div class="info-block-sub">No 11, Ramaniyam Isha, Old Mahabalipuram Road,<br>Okkiyam Thoraipakkam, Chennai –
            600097</div>
          <div class="trust-logos">
            <span class="trust-logo">Tamil Nadu</span>
            <span class="trust-logo">Karnataka</span>
            <span class="trust-logo">Andhra Pradesh</span>
            <span class="trust-logo">1000+ Projects</span>
            <span class="trust-logo">ISO Certified</span>
            <span class="trust-logo">Since 2004</span>
          </div>
        </div> -->

      </div>
    </div>

    <!-- ===== PLANT & OFFICE LOCATIONS — "Plant Index" directory ===== -->
    <div class="address-section" id="locations">

      <div class="loc-section-head">
        <div class="loc-heading-group">
          <span class="loc-eyebrow">// Plant Network</span>
          <h3>Our Locations</h3>
        </div>
        <span class="loc-count"><strong>12</strong> locations across Tamil Nadu</span>
      </div>

      <div class="loc-scroll">
        <div class="loc-grid">

        <!-- HEAD OFFICE -->
        <div class="loc-card loc-hq">
          <div class="loc-card-top">
            <span class="loc-tag">Head Office</span>
            <span class="loc-index">N.01</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21h18" />
              <path d="M5 21V7l7-4 7 4v14" />
              <path d="M9 9h1M9 13h1M14 9h1M14 13h1" />
              <path d="M10 21v-5h4v5" />
            </svg>
          </div>
          <h5>SUN-X Group — Head Office</h5>
          <p>No 11, Ramaniyam Isha, Old Mahabalipuram Road, Okkiyam Thoraipakkam, Chennai – 600097</p>
        </div>

        <!-- PLANTS -->
        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.02</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Poonamallee Plant</h5>
          <p>Survey No. 32/1, 32/2A, 32/2B, 33, 46/3, Poonamallee Bypass Road, Thiruvallur District, Chennai – 600056</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.03</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Madhavaram Plant</h5>
          <p>Door No. 95/7, GNT Road, Kamatchiamman Nagar, Puzhal Cycle Shop, Madhavaram, Chennai – 600060</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.04</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Siruseri Plant</h5>
          <p>Survey No. 268/11, OMR Road, Kazhipattur Village, Kanchipuram District, Chennai – 603103</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.05</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Vallam</h5>
          <p>No. 107/1, Plot No. 29, Mambakkam Village, Tiruporur Taluk, Kanchipuram District, Chennai – 600127</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.06</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Mambakkam</h5>
          <p>No. 107/1, Plot No. 29, Mambakkam Village, Tiruporur Taluk, Kanchipuram District, Chennai – 600127</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.07</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X AAC</h5>
          <p>SH 58A, Kancheepuram to Vellore High Road, Kilambi Village, Kancheepuram – 631502</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.08</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Blocks</h5>
          <p>S.No. 114/6A, 114/9A, Patta No. 2126, No. 136, Vaipur B Block, Sriperumbudur Taluk, Eraiyur Village, Kanchipuram – 631604</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.09</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Pozhichalur</h5>
          <p>Casagrand Casamia, 2/381A, Bajanai Koil Street, near Indresan Garden, Vinayaga Nagar, Pozhichalur, Chennai – 600074</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.10</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Thirumudivakkam</h5>
          <p>Survey No. 331/1 &amp; 331/2, 2nd Main Road, Perumal Nagar, Thirumudivakkam, Chennai – 600044</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.11</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Voora</h5>
          <p>Survey No. 268/11, OMR Road, Kazhipattur Village, Kanchipuram District, Chennai – 603103</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.12</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Mathur</h5>
          <p>S.F.No. 55/1A, Thirumukkudal Village, Taluk Uthiramerur, Kanchipuram – 631606</p>
        </div>

        <!-- duplicate set for seamless auto-scroll loop -->
        <div style="display:contents" aria-hidden="true">
        <!-- HEAD OFFICE -->
        <div class="loc-card loc-hq">
          <div class="loc-card-top">
            <span class="loc-tag">Head Office</span>
            <span class="loc-index">N.01</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21h18" />
              <path d="M5 21V7l7-4 7 4v14" />
              <path d="M9 9h1M9 13h1M14 9h1M14 13h1" />
              <path d="M10 21v-5h4v5" />
            </svg>
          </div>
          <h5>SUN-X Group — Head Office</h5>
          <p>No 11, Ramaniyam Isha, Old Mahabalipuram Road, Okkiyam Thoraipakkam, Chennai – 600097</p>
        </div>

        <!-- PLANTS -->
        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.02</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Poonamallee Plant</h5>
          <p>Survey No. 32/1, 32/2A, 32/2B, 33, 46/3, Poonamallee Bypass Road, Thiruvallur District, Chennai – 600056</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.03</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Madhavaram Plant</h5>
          <p>Door No. 95/7, GNT Road, Kamatchiamman Nagar, Puzhal Cycle Shop, Madhavaram, Chennai – 600060</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.04</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>Siruseri Plant</h5>
          <p>Survey No. 268/11, OMR Road, Kazhipattur Village, Kanchipuram District, Chennai – 603103</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.05</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Vallam</h5>
          <p>No. 107/1, Plot No. 29, Mambakkam Village, Tiruporur Taluk, Kanchipuram District, Chennai – 600127</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.06</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Mambakkam</h5>
          <p>No. 107/1, Plot No. 29, Mambakkam Village, Tiruporur Taluk, Kanchipuram District, Chennai – 600127</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.07</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X AAC</h5>
          <p>SH 58A, Kancheepuram to Vellore High Road, Kilambi Village, Kancheepuram – 631502</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.08</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Blocks</h5>
          <p>S.No. 114/6A, 114/9A, Patta No. 2126, No. 136, Vaipur B Block, Sriperumbudur Taluk, Eraiyur Village, Kanchipuram – 631604</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.09</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Pozhichalur</h5>
          <p>Casagrand Casamia, 2/381A, Bajanai Koil Street, near Indresan Garden, Vinayaga Nagar, Pozhichalur, Chennai – 600074</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.10</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Thirumudivakkam</h5>
          <p>Survey No. 331/1 &amp; 331/2, 2nd Main Road, Perumal Nagar, Thirumudivakkam, Chennai – 600044</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.11</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Voora</h5>
          <p>Survey No. 268/11, OMR Road, Kazhipattur Village, Kanchipuram District, Chennai – 603103</p>
        </div>

        <div class="loc-card loc-plant">
          <div class="loc-card-top">
            <span class="loc-tag">Plant</span>
            <span class="loc-index">N.12</span>
          </div>
          <div class="loc-icon">
            <svg viewBox="0 0 24 24">
              <path d="M3 21V10l5 3V10l5 3V10l5 3v8Z" />
              <path d="M3 21h18" />
              <path d="M7 7V4M11 7V4" />
            </svg>
          </div>
          <h5>SUN-X Mathur</h5>
          <p>S.F.No. 55/1A, Thirumukkudal Village, Taluk Uthiramerur, Kanchipuram – 631606</p>
        </div>
        </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ── PAGE SUBMIT LOADER ── -->
  <div class="page-loader-overlay" id="pageLoader">
    <div class="page-loader-box">
      <div class="page-loader-ring"></div>
      <p class="page-loader-title">Sending your message…</p>
      <p class="page-loader-sub">Please wait, do not close this page.</p>
      <div class="page-loader-bar-wrap">
        <div class="page-loader-bar" id="pageLoaderBar"></div>
      </div>
    </div>
  </div>

  <!-- ── SUCCESS POPUP ── -->
  <div class="success-overlay" id="successOverlay">
    <div class="success-popup">
      <div class="success-tick-wrap">
        <svg class="success-tick-svg" viewBox="0 0 24 24">
          <polyline points="4 12 9 17 20 6" />
        </svg>
      </div>
      <div class="success-popup-title">Message Sent!</div>
      <div class="success-popup-sub">Thank you for reaching out.<br>Our team will get back to you shortly.</div>
      <button class="success-popup-close" id="successClose">Close</button>
    </div>
  </div>

  <?php include 'footer.php' ?>

  <script src="src/js/index.js"></script>
  <script src="src/js/index2.js"></script>
  <script src="src/js/index3.js"></script>
  <script type="module" src="src/js/comman.js" defer></script>

  <script>
    const FLAGS = {
      '+91': 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA9UlEQVR4nO2UPQ6CQBCF51gUngV6Qi23IKHjGkqhDQewBCw8gLh0VFs/M1sZfzoQx7wveclkt3nfsosIIYQQ8g+gEliKUKCiACjwyNqFQIFq/VKgQGVYwHsPS5ElBZybsN02SNNDSJ43Yc2EgHMTkqTG+ezQtld03RDmON7PKiFLCejJa+G6vqAsTyE69/0t7P28QJoe0bZDKJ5lxxCd9WvonhGB6xuBwYZAnjfoutvLFdI13ft5AecmxPEu3Hk9dX3EOusjHkcDj9h/+I3OWd4vLfCNyDNRsYGlCAUKCoACj6xdKKJAsX6piAKFYQFCCCFEDHIHYAJaJ5T9GcsAAAAASUVORK5CYII=',
      '+971': 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAY0lEQVR4nO3PsQnEMBAAwavKOPjovj9VahAG5fepQofSexa2gImQJOkfGt+jnny2zxIHQAMogDmABlAA4w2Aq99LHAAdoADmADpAAYw3ADJziQMgAQpgDiABCmDsDJAkKTbsB4q949k7s9xrAAAAAElFTkSuQmCC'
    };

    const PHONE_CONFIG = {
      '+91': { placeholder: '98765 43210', maxLength: 10 },
      '+971': { placeholder: '50 123 4567', maxLength: 9 }
    };

    const phoneNum = document.getElementById('phoneNum');
    const phoneHidden = document.getElementById('phoneCountry');
    const flagImg = document.getElementById('flagImg');
    const cpsCode = document.getElementById('cpsCode');
    const cpsSelected = document.getElementById('cpsSelected');
    const wrapper = document.getElementById('customPhoneSelect');
    const submitBtn = document.querySelector('.form-submit');

    cpsSelected.addEventListener('click', (e) => {
      e.stopPropagation();
      wrapper.classList.toggle('open');
    });

    document.querySelectorAll('.cps-option').forEach(opt => {
      opt.addEventListener('click', () => {
        const code = opt.dataset.code;
        const config = PHONE_CONFIG[code];

        flagImg.src = opt.dataset.flag;
        flagImg.alt = opt.dataset.alt;
        cpsCode.textContent = code;
        phoneHidden.value = code;
        phoneNum.placeholder = config.placeholder;
        phoneNum.maxLength = config.maxLength;
        phoneNum.value = '';

        document.querySelectorAll('.cps-option').forEach(o => o.classList.remove('selected'));
        opt.classList.add('selected');

        wrapper.classList.remove('open');
        phoneNum.focus();
      });
    });

    document.addEventListener('click', () => wrapper.classList.remove('open'));

    phoneNum.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.querySelector('.cps-option[data-code="+91"]').classList.add('selected');

    const pageLoader = document.getElementById('pageLoader');
    const pageLoaderBar = document.getElementById('pageLoaderBar');

    function showLoader() {
      // Reset and restart bar animation
      pageLoaderBar.style.animation = 'none';
      pageLoaderBar.offsetHeight;  // reflow
      pageLoaderBar.style.animation = '';
      pageLoader.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function hideLoader() {
      pageLoader.classList.remove('active');
      document.body.style.overflow = '';
    }

    // ── Success popup ──
    const successOverlay = document.getElementById('successOverlay');
    const successClose = document.getElementById('successClose');

    function showSuccessPopup() {
      hideLoader();
      successOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeSuccessPopup() {
      successOverlay.classList.remove('active');
      document.body.style.overflow = '';
      submitBtn.textContent = 'Send message';
      submitBtn.style.background = '';
      submitBtn.style.color = '';
      submitBtn.style.borderColor = '';
      submitBtn.disabled = false;
    }

    successClose.addEventListener('click', closeSuccessPopup);
    successOverlay.addEventListener('click', (e) => {
      if (e.target === successOverlay) closeSuccessPopup();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeSuccessPopup();
    });

    function resetContactForm() {
      document.querySelectorAll('.form-input').forEach(i => i.value = '');
      document.getElementById('contactMessage').value = '';
      document.querySelectorAll('.cb-item input').forEach(cb => cb.checked = false);
      phoneNum.value = '';
    }

    // ── Type toggle ──
    const btnIndividual = document.getElementById('btnIndividual');
    const btnCompany = document.getElementById('btnCompany');
    const modeIndividual = document.getElementById('modeIndividual');
    const modeCompany = document.getElementById('modeCompany');
    const indicator = document.getElementById('typeIndicator');
    let currentType = 'individual';

    function setType(type) {
      currentType = type;

      // Update button active states
      btnIndividual.classList.toggle('active', type === 'individual');
      btnCompany.classList.toggle('active', type === 'company');

      // Slide indicator
      indicator.style.transform = type === 'individual' ? 'translateX(0)' : 'translateX(100%)';

      // Show/hide correct mode — fade out current, then swap & fade in
      const hide = type === 'individual' ? modeCompany : modeIndividual;
      const show = type === 'individual' ? modeIndividual : modeCompany;

      hide.classList.remove('form-mode-visible');
      setTimeout(() => {
        hide.style.display = 'none';
        show.style.display = '';
        // rAF ensures display:'' has painted before adding the class
        requestAnimationFrame(() => {
          requestAnimationFrame(() => show.classList.add('form-mode-visible'));
        });
      }, 200);

      // Clear fields on switch
      document.getElementById('contactFirstName').value = '';
      document.getElementById('contactLastName').value = '';
      document.getElementById('contactCompanyName').value = '';
    }

    // Set initial state
    indicator.style.transform = 'translateX(0)';
    modeIndividual.style.display = '';
    modeCompany.style.display = 'none';
    modeIndividual.classList.add('form-mode-visible');

    btnIndividual.addEventListener('click', () => setType('individual'));
    btnCompany.addEventListener('click', () => setType('company'));

    submitBtn.addEventListener('click', async () => {
      const isCompany = currentType === 'company';
      const fname = isCompany
        ? document.getElementById('contactCompanyName').value.trim()
        : document.getElementById('contactFirstName').value.trim();
      const lname = isCompany ? '' : document.getElementById('contactLastName').value.trim();
      const email = document.getElementById('contactEmail').value.trim();
      const code = phoneHidden.value;
      const phone = phoneNum.value.trim();
      const message = document.getElementById('contactMessage').value.trim();
      const services = [...document.querySelectorAll('.cb-item input:checked')]
        .map(cb => cb.closest('.cb-item').querySelector('.cb-text').textContent.trim())
        .join(', ') || 'None selected';
      const time = new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' });

      if (!fname || !email || !message) {
        alert(isCompany
          ? 'Please fill in Company Name, Email and Message.'
          : 'Please fill in First name, Email and Message.');
        return;
      }

      submitBtn.disabled = true;
      showLoader();

      // ── Step 1: Save to DB ──
      try {
        const fd = new FormData();
        fd.append('first_name', fname);
        fd.append('second_name', lname);
        fd.append('company_name', isCompany ? fname : '');
        fd.append('email', email);
        fd.append('phone_number', code + ' ' + phone);
        fd.append('message', message);
        fd.append('services', services);
        fd.append('type', currentType);

        const res = await fetch('apply_contact.php', { method: 'POST', body: fd });
        const data = await res.json();

        if (!data.ok) {
          hideLoader();
          alert(data.message || 'Submission failed. Please try again.');
          submitBtn.disabled = false;
          return;
        }
      } catch (err) {
        console.error('DB save error:', err);
        hideLoader();
        alert('Network error. Please try again.');
        submitBtn.disabled = false;
        return;
      }

      // DB save + admin notification email are both handled server-side
      // in apply_contact.php now (Zoho SMTP via PHPMailer).
      hideLoader();
      resetContactForm();
      showSuccessPopup();
    });
  </script>

</body>

</html>