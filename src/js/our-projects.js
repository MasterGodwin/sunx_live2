
    /* ── Projects Data ── */
    const projects = [
      {
        img: "src/assets/images/Projects/Banglore_Project.webp",
        title: "Bangalore Development Authority Project",
        desc: "Sun-X is the concrete partner of the Bangalore Development Authority project. Our team enabled a concrete pour of 321.5 cum of M25 grade with 12 TMs in just 11 hours."
      },
      {
        img: "src/assets/images/Projects/High_Strength_Concrete.webp",
        title: "High Strength Concrete for Foundation",
        desc: "M55 Grade high strength concrete for Aishwarya Fertility Center Foundation at SRP Tools, Perungudi."
      },
      {
        img: "src/assets/images/Projects/Roofing_Annur.webp",
        title: "Roofing – Annur",
        desc: "Our Trained Technical Team in action for Roofing at Sakthivel Area, Annur, Coimbatore."
      },
      {
        img: "src/assets/images/Projects/Railway_Kanchi.webp",
        title: "Railway Work – Kanchi Koodu",
        desc: "SunX team in a Railway work at Kanchi Koodu, designed and executed for KMC Infrastructure."
      },
      {
        img: "src/assets/images/Projects/Coimbatore_Railway_Project.webp",
        title: "Coimbatore Railway Project",
        desc: "Designed and Executed by SunX Concrete."
      },
      {
        img: "src/assets/images/Projects/Concrete_Pour.webp",
        title: "Concrete Pour – Srinivasa Associates",
        desc: "Designed and Executed by SunX Concrete."
      },
      {
        img: "src/assets/images/Projects/Coimbatore_Kurumbapalayam.webp",
        title: "Coimbatore Kurumbapalayam",
        desc: "Roofing M20 Grade concrete at Kurumbampalayam, Coimbatore."
      },
      {
        img: "src/assets/images/Projects/Industrial_Flooring.webp",
        title: "Industrial Flooring – Ascent",
        desc: "Industrial flooring using Steel fibre – Zigzag model – High impact & abrasion resistance for Ascent Vellivoyalchavadi."
      },
      {
        img: "src/assets/images/Projects/BNR_CMRL.webp",
        title: "BNR CMRL Ekaduthangal",
        desc: "Execution of RAFT concrete (Foundation)."
      },
      {
        img: "src/assets/images/Projects/Akshya_Thaiyur_Site.webp",
        title: "Akshya Thaiyur Site",
        desc: "Designed and Executed by SunX Concrete."
      },
      {
        img: "src/assets/images/Projects/Pile_Foundation.webp",
        title: "Pile Foundation – Hiranandani",
        desc: "Concrete is pushed into the ground through the pile for steady support to structures built on top of it. SunX Concrete is a 24-hour concrete supplier for the Pile Foundation at Hiranandani."
      },
    ];

    const PER_PAGE = 6;
    let currentPage = 1;
    const totalPages = Math.ceil(projects.length / PER_PAGE);

    function renderProjects(page) {
      const grid = document.getElementById('projectsGrid');
      const start = (page - 1) * PER_PAGE;
      const end = start + PER_PAGE;
      const slice = projects.slice(start, end);

      grid.innerHTML = slice.map(p => `
        <div class="proj-card reveal">
          <div class="proj-card-img">
            <img src="${p.img}" alt="${p.title}" loading="lazy"/>
          </div>
          <div class="proj-card-body">
            <div class="proj-card-title">${p.title}</div>
            <p class="proj-card-desc">${p.desc}</p>
          </div>
        </div>
      `).join('');

      /* re-observe new cards */
      document.querySelectorAll('.proj-card').forEach(el => obs.observe(el));
    }

    function renderPagination() {
      const pag = document.getElementById('pagination');
      let html = '';
      for (let i = 1; i <= totalPages; i++) {
        html += `<button class="page-btn${i === currentPage ? ' active' : ''}" data-page="${i}">${i}</button>`;
        if (i < totalPages) html += `<span class="page-sep">|</span>`;
      }
      pag.innerHTML = html;
      pag.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          currentPage = parseInt(btn.dataset.page);
          renderProjects(currentPage);
          renderPagination();
          document.querySelector('.projects-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      });
    }

    /* ── Scroll reveal ── */
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visible');
        else e.target.classList.remove('visible');
      });
    }, { threshold: 0.08 });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => obs.observe(el));

    /* ── Init ── */
    renderProjects(1);
    renderPagination();
