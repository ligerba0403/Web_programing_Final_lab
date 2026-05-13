/**
 * main.js — Portfolio Frontend Logic
 * Vanilla JS only. No frameworks.
 */

/* ============================================================
   i18n — Translations (EN default, TR optional)
   ============================================================ */
const TRANSLATIONS = {
  en: {
    'nav.about':       'About',
    'nav.projects':    'Projects',
    'nav.contact':     'Contact',
    'hero.badge1':     'Software Engineer',
    'hero.badge2':     'Serial Entrepreneur',
    'hero.greeting':   "Hi, I'm",
    'hero.subtitle':   'Building scalable software systems and founding technology-driven ventures. From idea to product, from code to company — full cycle.',
    'hero.stat1':      'Years Exp.',
    'hero.stat2':      'Active Ventures',
    'hero.stat3':      'Projects Done',
    'hero.cta1':       'View Projects',
    'hero.cta2':       'Get in Touch',
    'about.title':     'About',
    'about.p1':        "Software engineering and entrepreneurship aren't two separate paths for me — they're two sides of the same coin. I combine technical depth with business acumen: I write code and build companies.",
    'about.p2':        'From frontend to backend, from system architecture to product strategy — I think full-stack. Clean code, scalable architecture, and user-centric design are the core principles of every project I build.',
    'about.h1title':   'Software Engineering',
    'about.h1sub':     'Computer Engineering graduate',
    'about.h2title':   'Serial Entrepreneur',
    'about.h2sub':     'Founder of multiple tech ventures',
    'about.h3title':   'Full-Stack Developer',
    'about.h3sub':     'Web, API, mobile & cloud systems',
    'about.tools':     'Tools',
    'projects.title':  'Projects',
    'projects.all':    'All',
    'projects.loading':'Loading projects...',
    'projects.empty':  'No projects added yet.',
    'projects.error':  'Failed to load projects.',
    'contact.title':   'Contact',
    'contact.intro':   'Have a project idea? Want to discuss investment or collaboration? Leave a message and I\'ll get back to you as soon as possible.',
    'contact.available':'Available for new projects & collaborations',
    'contact.name':    'Full Name *',
    'contact.email':   'Email *',
    'contact.subject': 'Subject *',
    'contact.message': 'Message *',
    'contact.send':    'Send Message',
    'contact.success': 'Your message was sent successfully. I\'ll get back to you soon!',
    'contact.error':   'An error occurred, please try again.',
    'contact.offline': 'Could not reach the server. Please try again later.',
    'footer.rights':   'All rights reserved.',
    'val.required':    'This field is required.',
    'val.email':       'Please enter a valid email address.',
    'val.min':         'Please enter at least {n} characters.',
  },
  tr: {
    'nav.about':       'Hakkımda',
    'nav.projects':    'Projeler',
    'nav.contact':     'İletişim',
    'hero.badge1':     'Yazılım Mühendisi',
    'hero.badge2':     'Seri Girişimci',
    'hero.greeting':   'Merhaba, ben',
    'hero.subtitle':   'Ölçeklenebilir yazılım sistemleri inşa ediyor, teknoloji odaklı girişimler kuruyorum. Fikirden ürüne, koddan şirkete — tam döngü.',
    'hero.stat1':      'Yıl Deneyim',
    'hero.stat2':      'Aktif Girişim',
    'hero.stat3':      'Tamamlanan Proje',
    'hero.cta1':       'Projelerimi Gör',
    'hero.cta2':       'İletişime Geç',
    'about.title':     'Hakkımda',
    'about.p1':        'Yazılım mühendisliği ve girişimcilik benim için iki ayrı yol değil — aynı madalyonun iki yüzü. Teknik derinliği iş zekasıyla birleştirerek hem kod yazan hem de şirket kuran bir profil çiziyorum.',
    'about.p2':        "Frontend'den backend'e, sistem mimarisinden ürün stratejisine kadar tam yığın düşünüyorum. Temiz kod, ölçeklenebilir mimari ve kullanıcı odaklı tasarım her projemin temel ilkeleri.",
    'about.h1title':   'Yazılım Mühendisliği',
    'about.h1sub':     'Bilgisayar Mühendisliği mezunu',
    'about.h2title':   'Seri Girişimci',
    'about.h2sub':     'Birden fazla teknoloji girişimi kurucusu',
    'about.h3title':   'Full-Stack Geliştirici',
    'about.h3sub':     'Web, API, mobil ve bulut sistemleri',
    'about.tools':     'Araçlar',
    'projects.title':  'Projeler',
    'projects.all':    'Tümü',
    'projects.loading':'Projeler yükleniyor...',
    'projects.empty':  'Henüz proje eklenmemiş.',
    'projects.error':  'Projeler yüklenirken bir hata oluştu.',
    'contact.title':   'İletişim',
    'contact.intro':   'Bir proje fikriniz mi var? Yatırım veya iş birliği için görüşmek ister misiniz? Mesaj bırakın, en kısa sürede döneyim.',
    'contact.available':'Yeni projeler ve iş birlikleri için müsaitim',
    'contact.name':    'Ad Soyad *',
    'contact.email':   'E-posta *',
    'contact.subject': 'Konu *',
    'contact.message': 'Mesaj *',
    'contact.send':    'Mesaj Gönder',
    'contact.success': 'Mesajınız başarıyla gönderildi. En kısa sürede dönüş yapacağım!',
    'contact.error':   'Bir hata oluştu, lütfen tekrar deneyin.',
    'contact.offline': 'Sunucuya ulaşılamadı. Lütfen daha sonra tekrar deneyin.',
    'footer.rights':   'Tüm hakları saklıdır.',
    'val.required':    'Bu alan zorunludur.',
    'val.email':       'Geçerli bir e-posta adresi girin.',
    'val.min':         'En az {n} karakter giriniz.',
  }
};

/* ============================================================
   0. LANGUAGE SYSTEM
   ============================================================ */
let currentLang = 'en';

(function initLang() {
  const saved = localStorage.getItem('portfolio_lang') || 'en';
  currentLang = saved;
  applyLang(saved, false);

  document.getElementById('langToggle').addEventListener('click', () => {
    const next = currentLang === 'en' ? 'tr' : 'en';
    currentLang = next;
    localStorage.setItem('portfolio_lang', next);
    applyLang(next, true);
  });
})();

function t(key) {
  return (TRANSLATIONS[currentLang] && TRANSLATIONS[currentLang][key])
    || TRANSLATIONS['en'][key]
    || key;
}

function applyLang(lang, animate) {
  document.documentElement.lang = lang;
  document.getElementById('langLabel').textContent = lang === 'en' ? 'TR' : 'EN';

  // Update all data-i18n elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    const val = (TRANSLATIONS[lang] && TRANSLATIONS[lang][key]) || TRANSLATIONS['en'][key];
    if (val !== undefined) el.textContent = val;
  });

  // Update placeholders
  document.querySelectorAll('[data-placeholder-' + lang + ']').forEach(el => {
    el.placeholder = el.getAttribute('data-placeholder-' + lang);
  });

  if (animate) {
    document.body.style.transition = 'opacity 0.15s ease';
    document.body.style.opacity = '0.7';
    setTimeout(() => { document.body.style.opacity = '1'; }, 150);
  }
}

/* ============================================================
   1. THEME TOGGLE (Dark / Light)
   ============================================================ */
(function initTheme() {
  const html        = document.documentElement;
  const btn         = document.getElementById('themeToggle');
  const STORAGE_KEY = 'portfolio_theme';

  const saved = localStorage.getItem(STORAGE_KEY) || 'dark';
  applyTheme(saved);

  btn.addEventListener('click', () => {
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    localStorage.setItem(STORAGE_KEY, next);
  });

  function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    const sun  = document.getElementById('themeIconSun');
    const moon = document.getElementById('themeIconMoon');
    if (theme === 'dark') {
      sun.classList.remove('hidden');
      moon.classList.add('hidden');
    } else {
      sun.classList.add('hidden');
      moon.classList.remove('hidden');
    }
  }
})();

/* ============================================================
   2. NAVBAR — scroll shrink + hamburger
   ============================================================ */
(function initNavbar() {
  const navbar    = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.getElementById('navLinks');

  window.addEventListener('scroll', () => {
    navbar.style.boxShadow = window.scrollY > 20
      ? '0 2px 20px rgba(0,0,0,0.4)'
      : 'none';
  });

  hamburger.addEventListener('click', () => {
    const open = hamburger.classList.toggle('open');
    navLinks.classList.toggle('open', open);
    hamburger.setAttribute('aria-expanded', String(open));
  });

  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      hamburger.classList.remove('open');
      navLinks.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  });
})();

/* ============================================================
   3. TYPING EFFECT — Hero name
   ============================================================ */
(function initTyping() {
  const el   = document.getElementById('typedName');
  const name = 'Abdullah İbrahimagaoğlu';
  let   i    = 0;

  const cursor = document.createElement('span');
  cursor.className = 'cursor';
  cursor.textContent = '|';

  function type() {
    if (i <= name.length) {
      el.textContent = name.slice(0, i);
      el.appendChild(cursor);
      i++;
      setTimeout(type, 90);
    }
  }
  type();
})();

/* ============================================================
   4. FOOTER YEAR
   ============================================================ */
document.getElementById('footerYear').textContent = new Date().getFullYear();

/* ============================================================
   5. PROJECTS — AJAX fetch + filter
   ============================================================ */
(function initProjects() {
  const grid    = document.getElementById('projectsGrid');
  const filters = document.getElementById('projectFilters');
  let allCards  = [];

  function loadProjects() {
    // Clear grid except filters
    grid.innerHTML = `
      <div class="projects__loading" id="projectsLoading">
        <span class="spinner"></span>
        <span data-i18n="projects.loading">${t('projects.loading')}</span>
      </div>`;

    fetch(`api/get_projects.php?lang=${currentLang}`)
      .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
      })
      .then(data => {
        grid.innerHTML = '';
        if (!data.success || !data.projects.length) {
          grid.innerHTML = `<p class="projects__loading">${t('projects.empty')}</p>`;
          allCards = [];
          return;
        }
        allCards = data.projects.map((p, idx) => buildCard(p, idx));
        allCards.forEach(card => grid.appendChild(card));
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // Re-apply active filter
        const activeFilter = filters.querySelector('.filter-btn.active');
        if (activeFilter && activeFilter.dataset.filter !== 'all') {
          const f = activeFilter.dataset.filter;
          allCards.forEach(card => {
            card.style.display = card.dataset.category === f ? '' : 'none';
          });
        }
      })
      .catch(() => {
        grid.innerHTML = `<div class="projects__loading"><i data-lucide="alert-triangle" style="width:16px;height:16px;margin-right:6px;"></i>${t('projects.error')}</div>`;
        if (typeof lucide !== 'undefined') lucide.createIcons();
      });
  }

  // Initial load
  loadProjects();

  // Re-load when language changes
  document.getElementById('langToggle').addEventListener('click', () => {
    // Wait for currentLang to update (initLang fires first)
    setTimeout(loadProjects, 10);
  });

  filters.addEventListener('click', e => {
    const btn = e.target.closest('.filter-btn');
    if (!btn) return;
    filters.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.dataset.filter;
    allCards.forEach(card => {
      card.style.display = (filter === 'all' || card.dataset.category === filter) ? '' : 'none';
    });
  });

  function buildCard(p, idx) {
    const card = document.createElement('article');
    card.className = 'project-card';
    card.dataset.category = p.category || 'Web';
    card.style.animationDelay = `${idx * 0.08}s`;

    const tags = (p.technologies || '')
      .split(',')
      .map(t => `<span class="tag">${escHtml(t.trim())}</span>`)
      .join('');

    const links = [
      p.project_url ? `<a href="${escHtml(p.project_url)}" target="_blank" rel="noopener"><i data-lucide="external-link"></i> Demo</a>` : '',
      p.github_url  ? `<a href="${escHtml(p.github_url)}"  target="_blank" rel="noopener"><i data-lucide="github"></i> GitHub</a>` : '',
    ].join('');

    card.innerHTML = `
      <div class="project-card__img-wrap">
        <img src="${escHtml(p.image_url || 'assets/images/project-placeholder.png')}"
             alt="${escHtml(p.title)}" class="project-card__img" loading="lazy"
             onerror="this.src='assets/images/project-placeholder.png'" />
        <span class="project-card__badge">${escHtml(p.category || 'Web')}</span>
      </div>
      <div class="project-card__body">
        <h3 class="project-card__title">${escHtml(p.title)}</h3>
        <p class="project-card__desc">${escHtml(p.description)}</p>
        <div class="project-card__tags">${tags}</div>
        <div class="project-card__links">${links}</div>
      </div>`;
    return card;
  }
})();

/* ============================================================
   6. CONTACT FORM — validation + AJAX submit
   ============================================================ */
(function initContactForm() {
  const form          = document.getElementById('contactForm');
  const feedback      = document.getElementById('formFeedback');
  const submitBtn     = document.getElementById('submitBtn');
  const submitText    = document.getElementById('submitText');
  const submitSpinner = document.getElementById('submitSpinner');

  const fields = {
    name:    { el: document.getElementById('name'),    err: document.getElementById('nameError'),    min: 2 },
    email:   { el: document.getElementById('email'),   err: document.getElementById('emailError'),   min: 0 },
    subject: { el: document.getElementById('subject'), err: document.getElementById('subjectError'), min: 3 },
    message: { el: document.getElementById('message'), err: document.getElementById('messageError'), min: 10 },
  };

  Object.values(fields).forEach(f => {
    f.el.addEventListener('blur',  () => validateField(f));
    f.el.addEventListener('input', () => { if (f.el.classList.contains('invalid')) validateField(f); });
  });

  form.addEventListener('submit', e => {
    e.preventDefault();
    feedback.className = 'form-feedback';
    feedback.style.display = 'none';

    const valid = Object.values(fields).map(validateField).every(Boolean);
    if (!valid) return;

    setLoading(true);

    fetch('api/send_message.php', { method: 'POST', body: new FormData(form) })
      .then(res => res.json())
      .then(data => {
        setLoading(false);
        if (data.success) {
          feedback.innerHTML = `<i data-lucide="check-circle" style="width:16px;height:16px;vertical-align:middle;margin-right:6px;"></i>${t('contact.success')}`;
          feedback.className = 'form-feedback success';
          form.reset();
        } else {
          feedback.innerHTML = `<i data-lucide="x-circle" style="width:16px;height:16px;vertical-align:middle;margin-right:6px;"></i>${escHtml(data.message || t('contact.error'))}`;
          feedback.className = 'form-feedback error';
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
      })
      .catch(() => {
        setLoading(false);
        feedback.innerHTML = `<i data-lucide="wifi-off" style="width:16px;height:16px;vertical-align:middle;margin-right:6px;"></i>${t('contact.offline')}`;
        feedback.className = 'form-feedback error';
        if (typeof lucide !== 'undefined') lucide.createIcons();
      });
  });

  function validateField(f) {
    const val = f.el.value.trim();
    let msg = '';
    if (!val) {
      msg = t('val.required');
    } else if (f.el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
      msg = t('val.email');
    } else if (f.min && val.length < f.min) {
      msg = t('val.min').replace('{n}', f.min);
    }
    f.err.textContent = msg;
    f.el.classList.toggle('invalid', !!msg);
    return !msg;
  }

  function setLoading(on) {
    submitBtn.disabled = on;
    submitText.classList.toggle('hidden', on);
    submitSpinner.classList.toggle('hidden', !on);
  }
})();

/* ============================================================
   7. SCROLL REVEAL
   ============================================================ */
(function initScrollReveal() {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll('.section').forEach(el => {
    el.classList.add('reveal');
    observer.observe(el);
  });
})();

/* ============================================================
   8. HERO PARTICLES
   ============================================================ */
(function initParticles() {
  const container = document.getElementById('heroParticles');
  if (!container) return;
  for (let i = 0; i < 18; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    p.style.cssText = `left:${Math.random()*100}%;top:${40+Math.random()*50}%;--dur:${3+Math.random()*4}s;--delay:${Math.random()*5}s;`;
    container.appendChild(p);
  }
})();

/* ============================================================
   Helpers
   ============================================================ */
function escHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}
