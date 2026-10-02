    /* ── PRODUCT DATA ── */
    const products = [
      {
        num: "01 · TCC",
        title: "Temperature\nControlled\nConcrete",
        desc: "Mixed concrete with lower heat of hydration for mass concrete requirements — ensuring lower core temperature and lower temperature differentials, and subsequently higher durability.",
        apps: ["Raft foundations", "Large footings", "Dams", "Thick retaining walls"],
        props: ["Lower drying stress", "Lower temperature stress", "Higher durability", "Reduced thermal cracking"]
      },
      {
        num: "02 · SCC",
        title: "Self\nCompacting\nConcrete",
        desc: "Fresh concrete that flows and consolidates under its own weight — no external vibration required. Ideal for complex reinforcement configurations and hard-to-reach areas.",
        apps: ["Drilled shafts", "Columns", "Earth retaining systems", "High rebar density areas"],
        props: ["Higher strength vs traditional", "Resistance to segregation", "No vibration needed", "Smooth surface finish"]
      },
      {
        num: "03 · GBC",
        title: "Green\nBuilding\nConcrete",
        desc: "Extra steps in mix design and placement to ensure a sustainable structure, long life cycle, and low maintenance surface — with energy saving and significantly reduced CO₂ emissions.",
        apps: ["Green homes", "Exterior walls", "Pavements", "LEED-certified projects"],
        props: ["CO₂ reduced ≥ 30%", "Min 20% residual aggregate", "CO₂-neutral fuels ≥ 10%", "Long service life"]
      },
      {
        num: "04 · HDD",
        title: "High\nDensity\nConcrete",
        desc: "Density approximately 50% more than conventional concrete — up to 5,200 kg/m³ using iron aggregate. Absorbs neutron and gamma rays, reducing radiation to a very weak state.",
        apps: ["Nuclear reactor structures", "Radiation control buildings", "EM wave shielding", "Medical facilities"],
        props: ["Absorbs neutron & gamma rays", "Good mechanical strength", "High durability", "Up to 5,200 kg/m³"]
      },
      {
        num: "05 · HSC",
        title: "High\nStrength\nConcrete",
        desc: "Formulated with portland cement, reactive powders, quartz flour, fine sand, and high-range water reducers. Achieves compressive strengths exceeding 29,000 psi (200 MPa).",
        apps: ["Highway bridges", "Concrete girders", "Buildings over 30 storeys", "Infrastructure projects"],
        props: ["Compressive strength > 200 MPa", "Dense, smooth surface finish", "Precise form-detail transfer", "Reduced column size"]
      },
      {
        num: "06 · ESC",
        title: "Early\nStrength\nConcrete",
        desc: "High compressive strength (>60 MPa) after 28 days — classified in the high performance group. Versatile technical characteristics make it ideal for earthquake-zone high-rise structures.",
        apps: ["High load-bearing columns", "Precast plant products", "Seismic-zone high-rise buildings", "Fast-track construction"],
        props: ["Higher cement content", "Reduced water-cement ratio", "Better workability & compaction", ">60 MPa at 28 days"]
      },
      {
        num: "07 · LWC",
        title: "Light\nWeight\nConcrete",
        desc: "Significantly reduces dead loads, making savings in foundations and reinforcement. Improved thermal properties and fire resistance — with equivalent structural strengths where required.",
        apps: ["Structural applications", "Architectural covering", "Roof heat insulation", "Water pipe insulation"],
        props: ["Reduced dead loads", "Improved thermal properties", "Improved fire resistance", "Less formwork & propping"]
      },
      {
        num: "08 · WPC",
        title: "Water\nPermeable\nConcrete",
        desc: "High porosity flatwork concrete that allows water to pass directly through — reducing site runoff, allowing groundwater recharge, and reducing water logging on roads and pavements.",
        apps: ["Pavements", "Streets and roads", "Water logging reduction", "Urban drainage systems"],
        props: ["High porosity structure", "Direct water pass-through", "Reduces runoff & flooding", "Groundwater recharge"]
      }
    ];

    /* ── DETAIL PANEL ── */
    let activeId = null;

    function openDetail(id) {
      const p = products[id];
      const panel = document.getElementById('detailPanel');

      // update tile active state
      document.querySelectorAll('.tile').forEach((t,i) => {
        t.classList.toggle('active', i === id);
      });

      document.getElementById('dNum').textContent = p.num;
      document.getElementById('dTitle').textContent = p.title.replace(/\n/g,' ');
      document.getElementById('dApps').innerHTML = p.apps.map(a => `<li><span class="ddot"></span>${a}</li>`).join('');
      document.getElementById('dProps').innerHTML = p.props.map(pr => `<li><span class="ddot"></span>${pr}</li>`).join('');
      document.getElementById('dDesc').textContent = p.desc;

      if (activeId === id) {
        closeDetail();
        return;
      }

      activeId = id;
      panel.classList.add('open');

      setTimeout(() => {
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }, 100);
    }

    function closeDetail() {
      document.getElementById('detailPanel').classList.remove('open');
      document.querySelectorAll('.tile').forEach(t => t.classList.remove('active'));
      activeId = null;
    }

    /* ── SCROLL REVEAL ── */
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('in');
        } else {
          e.target.classList.remove('in');
        }
      });
    }, { threshold: 0.06, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('.reveal, .stagger').forEach(el => observer.observe(el));
