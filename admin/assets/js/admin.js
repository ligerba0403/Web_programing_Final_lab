/**
 * admin.js — Admin Panel JS
 */

/* ============================================================
   Admin i18n
   ============================================================ */
const ADMIN_TRANSLATIONS = {
  tr: {
    'dashboard':      'Dashboard',
    'add_project':    'Proje Ekle',
    'view_site':      'Siteyi Gör',
    'logout':         'Çıkış',
    'total_projects': 'Toplam Proje',
    'total_messages': 'Toplam Mesaj',
    'unread':         'Okunmamış Mesaj',
    'projects':       'Projeler',
    'new_project':    '+ Yeni Proje',
    'messages':       'Son Mesajlar',
    'modal_title':    'Siteyi Görüntüle',
    'modal_body':     'Portfolio siteniz yeni bir sekmede açılacak. Devam etmek istiyor musunuz?',
    'modal_cancel':   'İptal',
    'modal_confirm':  'Evet, Aç',
    'add_title':      'Yeni Proje Ekle',
    'edit_title':     'Proje Düzenle',
  },
  en: {
    'dashboard':      'Dashboard',
    'add_project':    'Add Project',
    'view_site':      'View Site',
    'logout':         'Logout',
    'total_projects': 'Total Projects',
    'total_messages': 'Total Messages',
    'unread':         'Unread Messages',
    'projects':       'Projects',
    'new_project':    '+ New Project',
    'messages':       'Recent Messages',
    'modal_title':    'View Portfolio',
    'modal_body':     'Your portfolio site will open in a new tab. Do you want to continue?',
    'modal_cancel':   'Cancel',
    'modal_confirm':  'Yes, Open',
    'add_title':      'Add New Project',
    'edit_title':     'Edit Project',
  }
};

let adminLang = localStorage.getItem('admin_lang') || 'tr';

function adminT(key) {
  return (ADMIN_TRANSLATIONS[adminLang] && ADMIN_TRANSLATIONS[adminLang][key])
    || ADMIN_TRANSLATIONS['tr'][key] || key;
}

function applyAdminLang(lang) {
  adminLang = lang;
  localStorage.setItem('admin_lang', lang);

  document.querySelectorAll('[data-admin-i18n]').forEach(el => {
    const key = el.getAttribute('data-admin-i18n');
    const val = adminT(key);
    if (val) el.textContent = val;
  });

  // Update active state on lang buttons
  document.querySelectorAll('.admin-lang-btn').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.lang === lang);
  });
}

/* ============================================================
   Auto-hide alerts after 4 seconds
   ============================================================ */
document.querySelectorAll('.alert').forEach(el => {
  setTimeout(() => {
    el.style.transition = 'opacity 0.5s ease';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 500);
  }, 4000);
});

/* ============================================================
   "Siteyi Gör" — popup confirmation then open in new tab
   ============================================================ */
const viewSiteBtn = document.getElementById('viewSiteBtn');
if (viewSiteBtn) {
  viewSiteBtn.addEventListener('click', e => {
    e.preventDefault();
    showViewSiteModal();
  });
}

function showViewSiteModal() {
  const existing = document.getElementById('viewSiteModal');
  if (existing) existing.remove();

  const modal = document.createElement('div');
  modal.id = 'viewSiteModal';
  modal.innerHTML = `
    <div class="modal-backdrop" id="modalBackdrop"></div>
    <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <div class="modal-icon">
        <i data-lucide="globe"></i>
      </div>
      <h2 id="modalTitle">${adminT('modal_title')}</h2>
      <p>${adminT('modal_body')}</p>
      <div class="modal-actions">
        <button class="btn btn--outline btn--sm" id="modalCancel">
          <i data-lucide="x"></i> ${adminT('modal_cancel')}
        </button>
        <button class="btn btn--primary btn--sm" id="modalConfirm">
          <i data-lucide="external-link"></i> ${adminT('modal_confirm')}
        </button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);

  if (typeof lucide !== 'undefined') lucide.createIcons();

  document.getElementById('modalBackdrop').addEventListener('click', closeModal);
  document.getElementById('modalCancel').addEventListener('click', closeModal);
  document.getElementById('modalConfirm').addEventListener('click', () => {
    closeModal();
    window.open('../index.html', '_blank', 'noopener');
  });

  setTimeout(() => document.getElementById('modalConfirm')?.focus(), 50);
}

function closeModal() {
  const modal = document.getElementById('viewSiteModal');
  if (modal) {
    modal.style.opacity = '0';
    setTimeout(() => modal.remove(), 200);
  }
}

/* ============================================================
   Project Form — Language Tabs (TR / EN)
   ============================================================ */
const langTabs = document.getElementById('langTabs');
if (langTabs) {
  langTabs.addEventListener('click', e => {
    const tab = e.target.closest('.lang-tab');
    if (!tab) return;

    langTabs.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const lang = tab.dataset.lang;
    document.querySelectorAll('.lang-panel').forEach(panel => {
      panel.style.display = panel.classList.contains('lang-panel--' + lang) ? '' : 'none';
    });
  });
}

/* ============================================================
   Admin Lang Toggle (header buttons)
   ============================================================ */
document.querySelectorAll('.admin-lang-btn').forEach(btn => {
  btn.addEventListener('click', () => applyAdminLang(btn.dataset.lang));
});

// Apply saved lang on load
applyAdminLang(adminLang);
