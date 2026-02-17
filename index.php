<?php
// index.php — Portfolio Web — Ing. Gustavo Cruz
// Desarrollador Web Full-Stack
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- SEO Básico -->
  <title>Ing. Gustavo Cruz | Desarrollador Web Full-Stack</title>
  <meta name="description" content="Portafolio profesional de Ing. Gustavo Cruz, Desarrollador Web Full-Stack con más de 3 años de experiencia en PHP, MySQL, JavaScript, Bootstrap y React." />
  <meta name="keywords" content="desarrollador web, full-stack, PHP, MySQL, JavaScript, Bootstrap, React, portafolio, Gustavo Cruz" />
  <meta name="author" content="Ing. Gustavo Cruz" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://www.tudominio.com/" />

  <!-- Open Graph / Redes Sociales -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.tudominio.com/" />
  <meta property="og:title" content="Ing. Gustavo Cruz | Desarrollador Web Full-Stack" />
  <meta property="og:description" content="Portafolio profesional de Ing. Gustavo Cruz. Soluciones web eficientes, escalables y robustas." />
  <meta property="og:image" content="assets/img/og-preview.jpg" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Ing. Gustavo Cruz | Desarrollador Web Full-Stack" />
  <meta name="twitter:description" content="Portafolio profesional. PHP, MySQL, JavaScript, Bootstrap, React." />
  <meta name="twitter:image" content="assets/img/og-preview.jpg" />

  <!-- Schema.org JSON-LD -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Ing. Gustavo Cruz",
    "jobTitle": "Desarrollador Web Full-Stack",
    "url": "https://www.tudominio.com",
    "email": "ing.erickgustavocruz@gmail.com",
    "sameAs": [
      "https://github.com/tuusuario",
      "https://linkedin.com/in/tuusuario"
    ],
    "knowsAbout": ["PHP", "MySQL", "JavaScript", "Bootstrap", "React", "HTML5", "CSS3", "Git"]
  }
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg" />

  <!-- Google Fonts: Syne (display) + DM Sans (body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- Íconos: Remix Icon CDN -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- CSS Principal -->
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<body>

  <!-- ═══════════════════════════════════════
       HEADER / NAVEGACIÓN
  ═══════════════════════════════════════ -->
  <header class="site-header" id="site-header" role="banner">
    <div class="header-inner container">

      <!-- Logo / Marca -->
      <a href="#inicio" class="brand" aria-label="Ir al inicio" data-section="inicio">
        <span class="brand-icon" aria-hidden="true">&lt;/&gt;</span>
        <span class="brand-text">
          <strong>Ing. Gustavo Cruz</strong>
          <small>Desarrollador Web Full-Stack</small>
        </span>
      </a>

      <!-- Navegación principal (desktop) -->
      <nav class="main-nav" id="main-nav" role="navigation" aria-label="Menú principal">
        <ul class="nav-list" role="list">
          <li>
            <a href="#inicio" class="nav-link active" data-section="inicio" aria-current="page">
              <i class="ri-home-5-line" aria-hidden="true"></i>
              <span>Inicio</span>
            </a>
          </li>
          <li>
            <a href="assets/docs/CV_GustavoCruz.pdf" class="nav-link" id="btn-cv" target="_blank" rel="noopener noreferrer" download aria-label="Descargar Curriculum Vitae en PDF">
              <i class="ri-file-pdf-2-line" aria-hidden="true"></i>
              <span>Curriculum Vitae</span>
            </a>
          </li>
          <li>
            <a href="#portafolio" class="nav-link" data-section="portafolio" aria-label="Ver portafolio de proyectos">
              <i class="ri-briefcase-4-line" aria-hidden="true"></i>
              <span>Portafolio</span>
            </a>
          </li>
          <li>
            <a href="#contacto" class="nav-link" data-section="contacto" aria-label="Ir a sección de contacto">
              <i class="ri-mail-send-line" aria-hidden="true"></i>
              <span>Contáctame</span>
            </a>
          </li>
        </ul>

        <!-- Toggle Modo Oscuro -->
        <button class="dark-mode-toggle" id="dark-toggle" aria-label="Cambiar a modo oscuro" title="Alternar modo oscuro/claro">
          <span class="toggle-track" aria-hidden="true">
            <i class="ri-sun-line icon-light"></i>
            <i class="ri-moon-line icon-dark"></i>
            <span class="toggle-thumb"></span>
          </span>
        </button>
      </nav>

      <!-- Botón hamburguesa (móvil) -->
      <button class="hamburger" id="hamburger" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-menu">
        <span class="ham-bar"></span>
        <span class="ham-bar"></span>
        <span class="ham-bar"></span>
      </button>
    </div>

    <!-- Menú Móvil (dropdown desde arriba) -->
    <div class="mobile-menu" id="mobile-menu" role="dialog" aria-label="Menú de navegación móvil" aria-hidden="true">
      <ul class="mobile-nav-list" role="list">
        <li>
          <a href="#inicio" class="mobile-nav-link" data-section="inicio">
            <i class="ri-home-5-line" aria-hidden="true"></i> Inicio
          </a>
        </li>
        <li>
          <a href="assets/docs/CV_GustavoCruz.pdf" class="mobile-nav-link" target="_blank" rel="noopener noreferrer" download>
            <i class="ri-file-pdf-2-line" aria-hidden="true"></i> Curriculum Vitae
          </a>
        </li>
        <li>
          <a href="#portafolio" class="mobile-nav-link" data-section="portafolio">
            <i class="ri-briefcase-4-line" aria-hidden="true"></i> Portafolio
          </a>
        </li>
        <li>
          <a href="#contacto" class="mobile-nav-link" data-section="contacto">
            <i class="ri-mail-send-line" aria-hidden="true"></i> Contáctame
          </a>
        </li>
        <li class="mobile-dark-toggle-wrap">
          <button class="dark-mode-toggle mobile" id="dark-toggle-mobile" aria-label="Cambiar modo oscuro">
            <i class="ri-sun-line icon-light"></i>
            <i class="ri-moon-line icon-dark"></i>
            <span>Modo oscuro</span>
          </button>
        </li>
      </ul>
    </div>
  </header>

  <!-- ═══════════════════════════════════════
       MAIN — CONTENIDO PRINCIPAL
  ═══════════════════════════════════════ -->
  <main id="main-content" role="main">

    <!-- ───────────────────────────────────
         SECCIÓN 1: INICIO
    ─────────────────────────────────────── -->
    <section class="section section-inicio active" id="inicio" aria-labelledby="inicio-title">

      <!-- Hero -->
      <div class="hero container">
        <div class="hero-content fade-in">
          <p class="hero-eyebrow">¡Hola, soy</p>
          <h1 class="hero-name" id="inicio-title">Ing. Gustavo Cruz</h1>
          <p class="hero-role">
            <span class="role-accent">Desarrollador Web</span>
            <span class="role-separator" aria-hidden="true">&nbsp;/&nbsp;</span>
            <span>Full-Stack</span>
          </p>
          <p class="hero-bio">
            Más de <strong>3 años de experiencia</strong> diseñando y desarrollando aplicaciones web
            eficientes, escalables y robustas. Ingeniero en Computación por la <strong>UNAM</strong>,
            apasionado por el código limpio y la experiencia de usuario.
          </p>

          <!-- CTA Buttons -->
          <div class="hero-cta" role="group" aria-label="Acciones principales">
            <a href="#portafolio" class="btn btn-primary" data-section="portafolio">
              <i class="ri-briefcase-4-line" aria-hidden="true"></i> Ver Proyectos
            </a>
            <a href="#contacto" class="btn btn-outline" data-section="contacto">
              <i class="ri-mail-send-line" aria-hidden="true"></i> Contáctame
            </a>
          </div>

          <!-- Redes sociales -->
          <div class="hero-social" aria-label="Redes sociales">
            <a href="https://github.com/tuusuario" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="GitHub de Gustavo Cruz">
              <i class="ri-github-fill" aria-hidden="true"></i>
            </a>
            <a href="https://linkedin.com/in/tuusuario" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn de Gustavo Cruz">
              <i class="ri-linkedin-box-fill" aria-hidden="true"></i>
            </a>
            <a href="mailto:ing.erickgustavocruz@gmail.com" class="social-link" aria-label="Enviar correo a Gustavo Cruz">
              <i class="ri-mail-fill" aria-hidden="true"></i>
            </a>
          </div>
        </div>

        <!-- Foto de perfil -->
        <div class="hero-image fade-in fade-delay">
          <div class="hero-img-wrapper">
            <div class="hero-img-glow" aria-hidden="true"></div>
            <img
              src="assets/img/perfil.jpg"
              alt="Fotografía profesional de Ing. Gustavo Cruz, Desarrollador Web Full-Stack"
              class="hero-photo"
              width="420"
              height="420"
              loading="eager"
            />
          </div>
        </div>
      </div>

      <!-- Carrusel de Tecnologías -->
      <div class="tech-carousel-section fade-in fade-delay-2" aria-label="Tecnologías que domino">
        <p class="carousel-label">Tecnologías que domino</p>

        <div class="carousel-track-wrapper" role="marquee" aria-label="Carrusel de tecnologías">
          <div class="carousel-track" id="carousel-track">

            <!-- Ítem duplicados para loop infinito -->
            <?php
            $tecnologias = [
              ['nombre' => 'HTML5',       'icono' => 'ri-html5-fill',       'color' => '#E34F26'],
              ['nombre' => 'CSS3',        'icono' => 'ri-css3-fill',        'color' => '#1572B6'],
              ['nombre' => 'JavaScript',  'icono' => 'ri-javascript-fill',  'color' => '#F7DF1E'],
              ['nombre' => 'PHP',         'icono' => 'ri-code-s-slash-line','color' => '#777BB4'],
              ['nombre' => 'MySQL',       'icono' => 'ri-database-2-fill',  'color' => '#4479A1'],
              ['nombre' => 'Bootstrap',   'icono' => 'ri-bootstrap-fill',   'color' => '#7952B3'],
              ['nombre' => 'React',       'icono' => 'ri-reactjs-line',     'color' => '#61DAFB'],
              ['nombre' => 'Git',         'icono' => 'ri-git-branch-fill',  'color' => '#F05032'],
              ['nombre' => 'GitHub',      'icono' => 'ri-github-fill',      'color' => '#181717'],
              ['nombre' => 'Linux',       'icono' => 'ri-terminal-box-fill','color' => '#FCC624'],
            ];

            // Duplicamos para el efecto infinito
            $items = array_merge($tecnologias, $tecnologias);
            foreach ($items as $tech) {
              echo '<div class="carousel-item">';
              echo '  <div class="tech-icon" style="--tech-color:' . $tech['color'] . '">';
              echo '    <i class="' . $tech['icono'] . '" aria-hidden="true" style="color:' . $tech['color'] . '"></i>';
              echo '  </div>';
              echo '  <span class="tech-name">' . $tech['nombre'] . '</span>';
              echo '</div>';
            }
            ?>

          </div><!-- /.carousel-track -->
        </div><!-- /.carousel-track-wrapper -->
      </div><!-- /.tech-carousel-section -->

      <!-- Estadísticas rápidas -->
      <div class="stats-row container fade-in fade-delay-3" role="list" aria-label="Estadísticas profesionales">
        <div class="stat-item" role="listitem">
          <span class="stat-number" aria-label="Más de 3 años de experiencia">3+</span>
          <span class="stat-label">Años de experiencia</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item" role="listitem">
          <span class="stat-number" aria-label="Más de 8 proyectos completados">8+</span>
          <span class="stat-label">Proyectos completados</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item" role="listitem">
          <span class="stat-number" aria-label="10 tecnologías dominadas">10+</span>
          <span class="stat-label">Tecnologías</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item" role="listitem">
          <span class="stat-number" aria-label="Egresado de la UNAM">UNAM</span>
          <span class="stat-label">Ing. Computación</span>
        </div>
      </div>

    </section><!-- /#inicio -->


    <!-- ───────────────────────────────────
         SECCIÓN 2: PORTAFOLIO
    ─────────────────────────────────────── -->
    <section class="section section-portafolio hidden" id="portafolio" aria-labelledby="portafolio-title">

      <div class="container">
        <header class="section-header fade-in">
          <span class="section-tag">Mis trabajos</span>
          <h2 class="section-title" id="portafolio-title">Últimos Proyectos</h2>
          <p class="section-subtitle">Soluciones web construidas con pasión, buenas prácticas y tecnología moderna.</p>
        </header>

        <!-- Filtros de proyectos -->
        <div class="project-filters fade-in" role="group" aria-label="Filtrar proyectos por tecnología">
          <button class="filter-btn active" data-filter="all" aria-pressed="true">Todos</button>
          <button class="filter-btn" data-filter="php" aria-pressed="false">PHP</button>
          <button class="filter-btn" data-filter="javascript" aria-pressed="false">JavaScript</button>
          <button class="filter-btn" data-filter="react" aria-pressed="false">React</button>
          <button class="filter-btn" data-filter="mysql" aria-pressed="false">MySQL</button>
        </div>

        <!-- Grid de proyectos -->
        <div class="projects-grid" id="projects-grid" role="list" aria-label="Lista de proyectos">

          <?php
          $proyectos = [
            [
              'id'          => 1,
              'titulo'      => 'Sistema de Gestión KA',
              'descripcion' => 'Plataforma web para gestión y seguimiento de procesos operativos. Incluye dashboards interactivos, reportes en tiempo real y gestión de usuarios con roles y permisos.',
              'imagen'      => 'assets/img/proyectos/proyecto1.jpg',
              'stack'       => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
              'filtros'     => ['php', 'mysql', 'javascript'],
              'github'      => 'https://github.com/tuusuario/proyecto1',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_1',
              'tipo_video'  => 'youtube',
            ],
            [
              'id'          => 2,
              'titulo'      => 'Portal de Reportes Dinámicos',
              'descripcion' => 'Sistema de reportería avanzada con filtros dinámicos, exportación a PDF/Excel y visualización de métricas KPI para toma de decisiones empresariales.',
              'imagen'      => 'assets/img/proyectos/proyecto2.jpg',
              'stack'       => ['PHP', 'MySQL', 'Chart.js', 'Bootstrap'],
              'filtros'     => ['php', 'mysql'],
              'github'      => 'https://github.com/tuusuario/proyecto2',
              'demo'        => '#',
              'video'       => 'assets/videos/proyecto2.mp4',
              'tipo_video'  => 'local',
            ],
            [
              'id'          => 3,
              'titulo'      => 'App de Inventario Web',
              'descripcion' => 'Control de inventario en tiempo real con alertas de stock mínimo, historial de movimientos, código de barras y panel administrativo multi-usuario.',
              'imagen'      => 'assets/img/proyectos/proyecto3.jpg',
              'stack'       => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
              'filtros'     => ['php', 'mysql', 'javascript'],
              'github'      => 'https://github.com/tuusuario/proyecto3',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_3',
              'tipo_video'  => 'youtube',
            ],
            [
              'id'          => 4,
              'titulo'      => 'Dashboard Analytics React',
              'descripcion' => 'Dashboard interactivo construido con React para visualización de datos analíticos. Gráficas en tiempo real, filtros avanzados y diseño responsivo mobile-first.',
              'imagen'      => 'assets/img/proyectos/proyecto4.jpg',
              'stack'       => ['React', 'JavaScript', 'CSS3', 'REST API'],
              'filtros'     => ['react', 'javascript'],
              'github'      => 'https://github.com/tuusuario/proyecto4',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_4',
              'tipo_video'  => 'youtube',
            ],
            [
              'id'          => 5,
              'titulo'      => 'Sistema de Tickets de Soporte',
              'descripcion' => 'Plataforma completa de gestión de tickets de soporte técnico con asignación automática, seguimiento de SLA, notificaciones por correo y base de conocimiento.',
              'imagen'      => 'assets/img/proyectos/proyecto5.jpg',
              'stack'       => ['PHP', 'MySQL', 'JavaScript', 'PHPMailer'],
              'filtros'     => ['php', 'mysql', 'javascript'],
              'github'      => 'https://github.com/tuusuario/proyecto5',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_5',
              'tipo_video'  => 'youtube',
            ],
            [
              'id'          => 6,
              'titulo'      => 'E-commerce con Carrito',
              'descripcion' => 'Tienda en línea completa con catálogo de productos, carrito de compras, integración de pasarela de pagos, gestión de pedidos y panel de administración.',
              'imagen'      => 'assets/img/proyectos/proyecto6.jpg',
              'stack'       => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
              'filtros'     => ['php', 'mysql', 'javascript'],
              'github'      => 'https://github.com/tuusuario/proyecto6',
              'demo'        => '#',
              'video'       => 'assets/videos/proyecto6.mp4',
              'tipo_video'  => 'local',
            ],
            [
              'id'          => 7,
              'titulo'      => 'API REST con Autenticación JWT',
              'descripcion' => 'API RESTful robusta con autenticación JWT, control de acceso por roles, documentación Swagger, rate limiting y pruebas automatizadas con PHPUnit.',
              'imagen'      => 'assets/img/proyectos/proyecto7.jpg',
              'stack'       => ['PHP', 'MySQL', 'JWT', 'REST API'],
              'filtros'     => ['php', 'mysql'],
              'github'      => 'https://github.com/tuusuario/proyecto7',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_7',
              'tipo_video'  => 'youtube',
            ],
            [
              'id'          => 8,
              'titulo'      => 'Landing Page Corporativa',
              'descripcion' => 'Landing page de alto impacto para empresa corporativa con animaciones CSS avanzadas, formulario de contacto integrado y optimización SEO completa.',
              'imagen'      => 'assets/img/proyectos/proyecto8.jpg',
              'stack'       => ['HTML5', 'CSS3', 'JavaScript', 'PHP'],
              'filtros'     => ['javascript', 'php'],
              'github'      => 'https://github.com/tuusuario/proyecto8',
              'demo'        => '#',
              'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID_8',
              'tipo_video'  => 'youtube',
            ],
          ];

          foreach ($proyectos as $p) {
            $filtrosStr = implode(' ', $p['filtros']);
            $stackHtml  = '';
            foreach ($p['stack'] as $tech) {
              $stackHtml .= '<span class="stack-tag">' . htmlspecialchars($tech) . '</span>';
            }
            echo <<<HTML
            <article class="project-card fade-in" data-filter="{$filtrosStr}" data-video="{$p['video']}" data-tipo="{$p['tipo_video']}" data-title="{$p['titulo']}" role="listitem">
              <div class="project-img-wrap">
                <img
                  src="{$p['imagen']}"
                  alt="Captura de pantalla del proyecto: {$p['titulo']}"
                  class="project-img"
                  loading="lazy"
                  width="600"
                  height="380"
                />
                <div class="project-overlay" aria-hidden="true">
                  <button class="btn-play-video" data-video="{$p['video']}" data-tipo="{$p['tipo_video']}" data-title="{$p['titulo']}" aria-label="Ver video del proyecto {$p['titulo']}">
                    <i class="ri-play-circle-fill"></i>
                    <span>Ver demo</span>
                  </button>
                </div>
              </div>
              <div class="project-body">
                <h3 class="project-title">{$p['titulo']}</h3>
                <p class="project-desc">{$p['descripcion']}</p>
                <div class="project-stack" aria-label="Tecnologías usadas">
                  {$stackHtml}
                </div>
                <div class="project-links" role="group" aria-label="Acciones del proyecto">
                  <a href="{$p['github']}" target="_blank" rel="noopener noreferrer" class="btn-project btn-github" aria-label="Ver código en GitHub">
                    <i class="ri-github-fill" aria-hidden="true"></i> GitHub
                  </a>
                  <a href="{$p['demo']}" target="_blank" rel="noopener noreferrer" class="btn-project btn-demo" aria-label="Ver demo en vivo">
                    <i class="ri-external-link-line" aria-hidden="true"></i> Demo
                  </a>
                  <button class="btn-project btn-video" data-video="{$p['video']}" data-tipo="{$p['tipo_video']}" data-title="{$p['titulo']}" aria-label="Reproducir video del proyecto">
                    <i class="ri-video-line" aria-hidden="true"></i> Video
                  </button>
                </div>
              </div>
            </article>
HTML;
          }
          ?>

        </div><!-- /#projects-grid -->
      </div>
    </section><!-- /#portafolio -->


    <!-- ───────────────────────────────────
         SECCIÓN 3: CONTACTO
    ─────────────────────────────────────── -->
    <section class="section section-contacto hidden" id="contacto" aria-labelledby="contacto-title">
      <div class="container">

        <!-- Formulario de contacto -->
        <div class="contacto-wrapper" id="contacto-form-wrap">
          <div class="contacto-info fade-in">
            <span class="section-tag">¿Trabajamos juntos?</span>
            <h2 class="section-title" id="contacto-title">Contáctame</h2>
            <p class="contacto-bio">
              ¿Tienes un proyecto en mente o quieres colaborar? Escríbeme y en breve me pongo en contacto contigo.
            </p>
            <p class="contacto-email">
              <i class="ri-mail-line" aria-hidden="true"></i>
              <a href="mailto:ing.erickgustavocruz@gmail.com">ing.erickgustavocruz@gmail.com</a>
            </p>
            <div class="contacto-social" aria-label="Redes sociales">
              <a href="https://github.com/tuusuario" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                <i class="ri-github-fill" aria-hidden="true"></i>
              </a>
              <a href="https://linkedin.com/in/tuusuario" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                <i class="ri-linkedin-box-fill" aria-hidden="true"></i>
              </a>
            </div>
            <!-- Mascota / Avatar decorativo -->
            <div class="contacto-avatar" aria-hidden="true">
              <img src="assets/img/avatar-call.png" alt="" role="presentation" width="220" loading="lazy" />
            </div>
          </div>

          <div class="contacto-form-wrap fade-in fade-delay">
            <div class="form-card" role="region" aria-label="Formulario de contacto">
              <form id="contact-form" novalidate aria-label="Formulario para enviar un mensaje">

                <!-- Nombre -->
                <div class="form-group">
                  <label for="nombre" class="form-label">
                    <i class="ri-user-3-line" aria-hidden="true"></i> Nombre completo
                  </label>
                  <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control"
                    placeholder="Tu nombre completo"
                    required
                    minlength="2"
                    maxlength="100"
                    autocomplete="name"
                    aria-required="true"
                    aria-describedby="nombre-error"
                  />
                  <span class="form-error" id="nombre-error" role="alert" aria-live="polite"></span>
                </div>

                <!-- Correo -->
                <div class="form-group">
                  <label for="correo" class="form-label">
                    <i class="ri-mail-line" aria-hidden="true"></i> Correo electrónico
                  </label>
                  <input
                    type="email"
                    id="correo"
                    name="correo"
                    class="form-control"
                    placeholder="tucorreo@ejemplo.com"
                    required
                    maxlength="150"
                    autocomplete="email"
                    aria-required="true"
                    aria-describedby="correo-error"
                  />
                  <span class="form-error" id="correo-error" role="alert" aria-live="polite"></span>
                </div>

                <!-- Mensaje -->
                <div class="form-group">
                  <label for="mensaje" class="form-label">
                    <i class="ri-chat-3-line" aria-hidden="true"></i> Mensaje
                  </label>
                  <textarea
                    id="mensaje"
                    name="mensaje"
                    class="form-control form-textarea"
                    placeholder="Cuéntame sobre tu proyecto..."
                    required
                    minlength="10"
                    maxlength="1000"
                    rows="5"
                    aria-required="true"
                    aria-describedby="mensaje-error"
                  ></textarea>
                  <span class="form-error" id="mensaje-error" role="alert" aria-live="polite"></span>
                </div>

                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" id="csrf_token" value="" />

                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-full" id="btn-enviar" aria-label="Enviar mensaje">
                  <span class="btn-text">
                    <i class="ri-send-plane-fill" aria-hidden="true"></i> Enviar mensaje
                  </span>
                  <span class="btn-loading" aria-hidden="true">
                    <i class="ri-loader-4-line spin" aria-hidden="true"></i> Enviando...
                  </span>
                </button>

                <div class="form-feedback" id="form-feedback" role="alert" aria-live="assertive"></div>

              </form>
            </div>
          </div>
        </div>

        <!-- ── Sección de Agradecimiento (oculta inicialmente) ── -->
        <div class="gracias-wrap hidden" id="gracias-wrap" role="region" aria-label="Mensaje de agradecimiento" aria-hidden="true">
          <div class="gracias-card fade-in">
            <div class="gracias-avatar" aria-hidden="true">
              <img src="assets/img/avatar-gracias.png" alt="" role="presentation" width="180" loading="lazy" />
            </div>
            <div class="gracias-texto">
              <h2 class="gracias-titulo">¡Gracias!</h2>
              <p class="gracias-subtitulo">En breve nos pondremos en contacto.</p>
              <p class="gracias-desc">Tu mensaje fue enviado correctamente. Te responderé a la brevedad posible.</p>
              <button class="btn btn-outline" id="btn-nuevo-mensaje" aria-label="Enviar otro mensaje">
                <i class="ri-arrow-left-line" aria-hidden="true"></i> Enviar otro mensaje
              </button>
            </div>
          </div>
        </div>

      </div>
    </section><!-- /#contacto -->

  </main><!-- /#main-content -->


  <!-- ═══════════════════════════════════════
       FOOTER
  ═══════════════════════════════════════ -->
  <footer class="site-footer" role="contentinfo">
    <div class="footer-inner container">
      <div class="footer-avatar" aria-hidden="true">
        <img src="assets/img/avatar-footer.png" alt="" role="presentation" width="40" loading="lazy" />
      </div>
      <p class="footer-copy">
        Copyright &copy; <span id="footer-year"></span> creado por
        <strong>Ing. Gustavo Cruz</strong>
      </p>
      <div class="footer-social" aria-label="Redes sociales en el pie de página">
        <a href="https://github.com/tuusuario" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
          <i class="ri-github-fill" aria-hidden="true"></i>
        </a>
        <a href="https://linkedin.com/in/tuusuario" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
          <i class="ri-linkedin-box-fill" aria-hidden="true"></i>
        </a>
        <a href="mailto:ing.erickgustavocruz@gmail.com" aria-label="Correo electrónico">
          <i class="ri-mail-fill" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </footer>


  <!-- ═══════════════════════════════════════
       MODAL: REPRODUCTOR DE VIDEO
  ═══════════════════════════════════════ -->
  <div class="modal-overlay hidden" id="video-modal" role="dialog" aria-modal="true" aria-label="Reproductor de video del proyecto" aria-hidden="true">
    <div class="modal-container">
      <div class="modal-header">
        <h3 class="modal-title" id="modal-title">Video del Proyecto</h3>
        <button class="modal-close" id="modal-close" aria-label="Cerrar video">
          <i class="ri-close-line" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="video-wrapper" id="video-wrapper">
          <!-- El iframe/video se inyecta dinámicamente por JS -->
        </div>
      </div>
    </div>
  </div>

  <!-- Overlay para cerrar el modal al hacer clic fuera -->
  <div class="modal-backdrop hidden" id="modal-backdrop" aria-hidden="true"></div>


  <!-- ═══════════════════════════════════════
       BOTÓN: SCROLL TO TOP
  ═══════════════════════════════════════ -->
  <button class="scroll-top hidden" id="scroll-top" aria-label="Volver al inicio de la página" title="Subir al inicio">
    <i class="ri-arrow-up-line" aria-hidden="true"></i>
  </button>


  <!-- JS Principal (defer para no bloquear render) -->
  <script src="assets/js/main.js" defer></script>
</body>
</html>