<!-- <div id="preloader">
    <div class="preloader-inner">
      <img src="./src/assets/images/sun-x.webp" alt="SUN-X" class="preloader-logo" />
      <div class="preloader-ring"></div>
    </div>
  </div> -->

<nav class="navbar" id="navbar">
    <div class="nav-left">
        <a href="index.php" class="logo">
            <img src="./src/assets/images/sun-x.webp" alt="SUN-X Logo" class="logo-img" fetchpriority="high" width="160"
                height="70" />
        </a>
    </div>
    <div class="main-nav">
        <a href="index.php" class="active">Home</a>

        <div class="nav-item">
            <a href="#">About Us</a>
            <div class="nav-dropdown">
                <a href="about.php">About Sunx Concrete</a>
                <a href="about-sunx-uae.php">About Sunx UAE</a>
                <a href="team.php">Our Team</a>
            </div>
        </div>

        <a href="services.php">Services</a>

        <div class="nav-item">
            <a href="#">Capabilities</a>
            <div class="nav-dropdown">
                <a href="quality-assurance.php">Quality Assurance</a>
                <a href="production-facilities.php">Production Facilities</a>
                <a href="fleet-management.php">Fleet Management</a> 
            </div>
        </div>

        <div class="nav-item">
            <a href="#">Our Works</a>
            <div class="nav-dropdown">
                <a href="our-projects.php">Our Projects</a> 
                <a href="our-products.php">Our Products</a>
            </div>
        </div>

        <a href="https://www.thehindu.com" target="_blank">Media</a>

        <a href="careers.php">Careers</a>
    </div>
    <div class="nav-right">
        <a href="contact.php" class="nav-cta">Contact Us</a>
        <button class="hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
<div class="drawer-overlay" id="drawerOverlay"></div>
<div class="drawer" id="drawer">
    <div class="drawer-header">
        <img src="./src/assets/images/sun-x.webp" alt="SUN-X Logo" class="drawer-logo" fetchpriority="high" width="130"
            height="48" onclick="window.location.href='index.php'" />
        <button class="drawer-close" id="drawerClose">&#x2715;</button>
    </div>
    <nav class="drawer-nav">
        <a href="index.php" class="active">Home</a>

        <details>
            <summary>About Us</summary>
            <div class="drawer-subnav">
                <a href="about.php">About Us</a>
                <a href="about-sunx-uae.php">About Sunx UAE</a>
                <a href="team.php">Our Team</a>
            </div>
        </details>

        <a href="services.php">Services</a>

        <details>
            <summary>Capabilities</summary>
            <div class="drawer-subnav">
                <a href="quality-assurance.php">Quality Assurance</a>
                <a href="production-facilities.php">Production Facilities</a>
                <a href="fleet-management.php">Fleet Management</a> 
            </div>
        </details>

        <details>
            <summary>Our Works</summary>
            <div class="drawer-subnav">
                <a href="our-projects.php">Our Projects</a> 
                <a href="our-products.php">Our Products</a>
            </div>
        </details>

        <a href="https://www.thehindu.com" target="_blank">Media</a>

        <a href="careers.php">Careers</a>

        <a href="contact.php">Contact Us</a>
    </nav>
    <div class="drawer-footer">© 2026 Sun-X Group.</div>
</div>