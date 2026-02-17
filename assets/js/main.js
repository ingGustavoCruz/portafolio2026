/**
 * main.js — Portfolio Ing. Gustavo Cruz
 * Módulos: Dark Mode | Navegación | Carrusel | Filtros | Modal Video | Formulario | Scroll
 */

'use strict';

/* ═══════════════════════════════════════════════════════
   HELPERS
════════════════════════════════════════════════════════ */
const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

/** Genera un token CSRF simple (para protección básica) */
function generateToken() {
  const arr = new Uint8Array(18);
  crypto.getRandomValues(arr);
  return btoa(String.fromCharCode(...arr));
}

/* ═══════════════════════════════════════════════════════
   1. DARK MODE
════════════════════════════════════════════════════════ */
const DarkMode = (() => {
  const HTML        = document.documentElement;
  const STORAGE_KEY = 'gc-theme';
  const toggles     = $$('[id^="dark-toggle"]');  // #dark-toggle y #dark-toggle-mobile

  function applyTheme(theme) {
    HTML.setAttribute('data-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);
    toggles.forEach(btn => {
      btn.setAttribute('aria-label',
        theme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'
      );
    });
  }

  function toggle() {
    const current = HTML.getAttribute('data-theme') || 'light';
    applyTheme(current === 'light' ? 'dark' : 'light');
  }

  function init() {
    // Preferencia guardada → luego mediaQuery del sistema
    const saved = localStorage.getItem(STORAGE_KEY);
    const preferred = saved ||
      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    applyTheme(preferred);
    toggles.forEach(btn => btn.addEventListener('click', toggle));
  }

  return { init };
})();


/* ═══════════════════════════════════════════════════════
   2. NAVEGACIÓN POR SECCIONES
════════════════════════════════════════════════════════ */
const Navigation = (() => {
  const SECTIONS = ['inicio', 'portafolio', 'contacto'];
  let currentSection = 'inicio';

  function showSection(id) {
    if (!SECTIONS.includes(id)) return;
    if (id === currentSection) return;

    // Ocultar sección activa
    const prev = $(`#${currentSection}`);
    if (prev) {
      prev.classList.remove('active');
      prev.classList.add('hidden');
    }

    // Mostrar nueva sección
    const next = $(`#${id}`);
    if (next) {
      next.classList.remove('hidden');
      next.classList.add('active');
      // Re-disparar animaciones
      next.querySelectorAll('.fade-in').forEach(el => {
        el.style.animationName = 'none';
        // Forzar reflow
        void el.offsetWidth;
        el.style.animationName = '';
      });
    }

    // Actualizar nav links
    $$('[data-section]').forEach(link => {
      link.classList.toggle('active', link.dataset.section === id);
      if (link.dataset.section === id) {
        link.setAttribute('aria-current', 'page');
      } else {
        link.removeAttribute('aria-current');
      }
    });

    currentSection = id;
    // Scroll suave al top del header
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function init() {
    // Clicks en links con data-section
    $$('[data-section]').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const section = link.dataset.section;
        showSection(section);
        // Cerrar menú móvil si está abierto
        MobileMenu.close();
      });
    });

    // Sección inicial
    showSection('inicio');
    // Forzar "inicio" como activo explícitamente
    const inicioPrev = $('#inicio');
    if (inicioPrev) {
      inicioPrev.classList.add('active');
      inicioPrev.classList.remove('hidden');
    }
  }

  return { init, showSection };
})();


/* ═══════════════════════════════════════════════════════
   3. MENÚ HAMBURGUESA (MÓVIL)
════════════════════════════════════════════════════════ */
const MobileMenu = (() => {
  const hamburger  = $('#hamburger');
  const mobileMenu = $('#mobile-menu');
  let isOpen = false;

  function open() {
    isOpen = true;
    hamburger.classList.add('open');
    hamburger.setAttribute('aria-expanded', 'true');
    mobileMenu.classList.add('open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    isOpen = false;
    hamburger?.classList.remove('open');
    hamburger?.setAttribute('aria-expanded', 'false');
    mobileMenu?.classList.remove('open');
    mobileMenu?.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  function toggle() { isOpen ? close() : open(); }

  function init() {
    if (!hamburger || !mobileMenu) return;
    hamburger.addEventListener('click', toggle);

    // Cerrar al hacer click fuera
    document.addEventListener('click', e => {
      if (isOpen && !hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
        close();
      }
    });

    // Cerrar con Escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && isOpen) close();
    });
  }

  return { init, close };
})();


/* ═══════════════════════════════════════════════════════
   4. FILTROS DE PROYECTOS
════════════════════════════════════════════════════════ */
const ProjectFilters = (() => {
  function init() {
    const filterBtns = $$('.filter-btn');
    const cards      = $$('.project-card');

    if (!filterBtns.length) return;

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const filter = btn.dataset.filter;

        // Actualizar botones
        filterBtns.forEach(b => {
          b.classList.toggle('active', b === btn);
          b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
        });

        // Filtrar tarjetas con animación
        cards.forEach(card => {
          const cardFilters = card.dataset.filter?.split(' ') || [];
          const show = filter === 'all' || cardFilters.includes(filter);

          if (show) {
            card.style.display = '';
            card.style.opacity = '0';
            card.style.transform = 'translateY(16px)';
            // Pequeño delay para la animación
            requestAnimationFrame(() => {
              requestAnimationFrame(() => {
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
              });
            });
          } else {
            card.style.transition = 'opacity 0.2s ease';
            card.style.opacity = '0';
            setTimeout(() => { card.style.display = 'none'; }, 200);
          }
        });
      });
    });
  }

  return { init };
})();


/* ═══════════════════════════════════════════════════════
   5. MODAL DE VIDEO
════════════════════════════════════════════════════════ */
const VideoModal = (() => {
  const modal    = $('#video-modal');
  const backdrop = $('#modal-backdrop');
  const closeBtn = $('#modal-close');
  const wrapper  = $('#video-wrapper');
  const title    = $('#modal-title');

  function open(videoSrc, tipo, projectTitle) {
    if (!modal || !wrapper) return;

    title.textContent = projectTitle || 'Video del Proyecto';
    wrapper.innerHTML = '';  // Limpiar contenido previo

    if (tipo === 'youtube') {
      // Asegurar que sea URL de embed
      const embedUrl = videoSrc.includes('embed/')
        ? videoSrc
        : videoSrc.replace('watch?v=', 'embed/');
      const iframe = document.createElement('iframe');
      iframe.src = `${embedUrl}?autoplay=1&rel=0&modestbranding=1`;
      iframe.allow = 'autoplay; encrypted-media; fullscreen';
      iframe.setAttribute('allowfullscreen', '');
      iframe.title = `Video: ${projectTitle}`;
      wrapper.appendChild(iframe);
    } else {
      // Video local
      const video = document.createElement('video');
      video.src = videoSrc;
      video.controls = true;
      video.autoplay = true;
      video.setAttribute('preload', 'auto');
      wrapper.appendChild(video);
    }

    modal.classList.remove('hidden');
    backdrop.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    // Focus en el botón de cerrar (accesibilidad)
    setTimeout(() => closeBtn?.focus(), 100);
  }

  function close() {
    if (!modal) return;
    modal.classList.add('hidden');
    backdrop.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    wrapper.innerHTML = '';  // Detener video
    document.body.style.overflow = '';
  }

  function init() {
    if (!modal) return;

    // Botones de reproducción en tarjetas
    document.addEventListener('click', e => {
      const btn = e.target.closest('[data-video]');
      if (btn && btn.dataset.video && btn.dataset.video !== '') {
        e.preventDefault();
        open(btn.dataset.video, btn.dataset.tipo || 'youtube', btn.dataset.title);
      }
    });

    closeBtn?.addEventListener('click', close);
    backdrop?.addEventListener('click', close);

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') close();
    });
  }

  return { init, open, close };
})();


/* ═══════════════════════════════════════════════════════
   6. FORMULARIO DE CONTACTO
════════════════════════════════════════════════════════ */
const ContactForm = (() => {
  const form       = $('#contact-form');
  const submitBtn  = $('#btn-enviar');
  const feedback   = $('#form-feedback');
  const formWrap   = $('#contacto-form-wrap');
  const graciasWrap = $('#gracias-wrap');
  const nuevoMsgBtn = $('#btn-nuevo-mensaje');
  const csrfInput  = $('#csrf_token');

  // Reglas de validación
  const rules = {
    nombre:  { min: 2, max: 100, msg: 'El nombre debe tener entre 2 y 100 caracteres.' },
    correo:  { pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, msg: 'Ingresa un correo electrónico válido.' },
    mensaje: { min: 10, max: 1000, msg: 'El mensaje debe tener entre 10 y 1000 caracteres.' },
  };

  function showError(fieldId, msg) {
    const input = $(`#${fieldId}`);
    const error = $(`#${fieldId}-error`);
    if (input) input.classList.add('error');
    if (error) error.textContent = msg;
  }

  function clearError(fieldId) {
    const input = $(`#${fieldId}`);
    const error = $(`#${fieldId}-error`);
    if (input) input.classList.remove('error');
    if (error) error.textContent = '';
  }

  function validate() {
    let valid = true;
    const nombre  = $('#nombre')?.value.trim() || '';
    const correo  = $('#correo')?.value.trim() || '';
    const mensaje = $('#mensaje')?.value.trim() || '';

    clearError('nombre'); clearError('correo'); clearError('mensaje');

    if (nombre.length < rules.nombre.min || nombre.length > rules.nombre.max) {
      showError('nombre', rules.nombre.msg); valid = false;
    }
    if (!rules.correo.pattern.test(correo)) {
      showError('correo', rules.correo.msg); valid = false;
    }
    if (mensaje.length < rules.mensaje.min || mensaje.length > rules.mensaje.max) {
      showError('mensaje', rules.mensaje.msg); valid = false;
    }
    return valid;
  }

  function setLoading(isLoading) {
    if (!submitBtn) return;
    submitBtn.classList.toggle('loading', isLoading);
    submitBtn.disabled = isLoading;
  }

  function showFeedback(msg, type) {
    if (!feedback) return;
    feedback.textContent = msg;
    feedback.className = `form-feedback ${type}`;
  }

  function showGracias() {
    if (formWrap)    formWrap.classList.add('hidden');
    if (graciasWrap) {
      graciasWrap.classList.remove('hidden');
      graciasWrap.setAttribute('aria-hidden', 'false');
      // Re-animar
      const card = graciasWrap.querySelector('.gracias-card');
      if (card) {
        card.style.animationName = 'none';
        void card.offsetWidth;
        card.style.animationName = '';
      }
    }
  }

  function resetForm() {
    form?.reset();
    ['nombre', 'correo', 'mensaje'].forEach(clearError);
    if (feedback) feedback.className = 'form-feedback';
  }

  async function submit(e) {
    e.preventDefault();
    if (!validate()) return;

    setLoading(true);
    showFeedback('', '');

    const formData = new FormData(form);

    try {
      const res  = await fetch('api/contacto.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      });

      // Intentar parsear JSON
      let data;
      const text = await res.text();
      try { data = JSON.parse(text); }
      catch { data = { success: false, message: 'Error inesperado del servidor.' }; }

      if (res.ok && data.success) {
        resetForm();
        showGracias();
      } else {
        showFeedback(data.message || 'Ocurrió un error. Intenta nuevamente.', 'error');
      }
    } catch (err) {
      showFeedback('Error de conexión. Verifica tu internet e intenta de nuevo.', 'error');
      console.error('Error al enviar formulario:', err);
    } finally {
      setLoading(false);
    }
  }

  function init() {
    if (!form) return;

    // Generar CSRF token
    if (csrfInput) {
      csrfInput.value = generateToken();
      sessionStorage.setItem('gc_csrf', csrfInput.value);
    }

    form.addEventListener('submit', submit);

    // Validación en tiempo real (al perder foco)
    ['nombre', 'correo', 'mensaje'].forEach(id => {
      const input = $(`#${id}`);
      if (!input) return;
      input.addEventListener('blur', () => {
        // Validar solo ese campo
        const val = input.value.trim();
        clearError(id);
        if (id === 'nombre' && (val.length < 2 || val.length > 100)) {
          showError(id, rules.nombre.msg);
        } else if (id === 'correo' && !rules.correo.pattern.test(val)) {
          showError(id, rules.correo.msg);
        } else if (id === 'mensaje' && (val.length < 10 || val.length > 1000)) {
          showError(id, rules.mensaje.msg);
        }
      });
    });

    // Botón "enviar otro mensaje"
    nuevoMsgBtn?.addEventListener('click', () => {
      graciasWrap?.classList.add('hidden');
      graciasWrap?.setAttribute('aria-hidden', 'true');
      formWrap?.classList.remove('hidden');
    });
  }

  return { init };
})();


/* ═══════════════════════════════════════════════════════
   7. SCROLL TO TOP
════════════════════════════════════════════════════════ */
const ScrollTop = (() => {
  const btn = $('#scroll-top');

  function init() {
    if (!btn) return;
    window.addEventListener('scroll', () => {
      btn.classList.toggle('hidden', window.scrollY < 400);
    }, { passive: true });
    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  return { init };
})();


/* ═══════════════════════════════════════════════════════
   8. AÑO DINÁMICO EN FOOTER
════════════════════════════════════════════════════════ */
function setFooterYear() {
  const el = $('#footer-year');
  if (el) el.textContent = new Date().getFullYear();
}


/* ═══════════════════════════════════════════════════════
   9. LAZY LOAD DE IMÁGENES (Intersection Observer)
════════════════════════════════════════════════════════ */
function initLazyImages() {
  if (!('IntersectionObserver' in window)) return;
  const imgs = $$('img[loading="lazy"]');
  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.setAttribute('data-loaded', 'true');
        obs.unobserve(img);
      }
    });
  }, { rootMargin: '200px' });
  imgs.forEach(img => observer.observe(img));
}


/* ═══════════════════════════════════════════════════════
   10. INIT — Punto de entrada
════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  DarkMode.init();
  Navigation.init();
  MobileMenu.init();
  ProjectFilters.init();
  VideoModal.init();
  ContactForm.init();
  ScrollTop.init();
  setFooterYear();
  initLazyImages();
});