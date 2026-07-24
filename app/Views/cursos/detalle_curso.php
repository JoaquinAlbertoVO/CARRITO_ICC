<!--Page Header Start-->
    <!--<section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/backgrounds/page-header-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>Course Details</h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="index.html">Home</a></li>
                                <li class="active">Course Details</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>-->
    <!--Page Header End-->

    <!--Start Course Details-->
    <section class="course-details">
        <div class="container">
            <div class="row">
                <!--Start Course Details Content-->
                <div class="col-xl-8 col-lg-8">
                    <div class="course-details__content">
                        <!--Start Single Courses One-->
                        <div class="courses-one__single style2 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                            <?php
                            $cName = mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8');
                            if (strpos($cName, 'condensadores') !== false) {
                                $video_url = 'https://www.youtube.com/embed/8TLJJCuo8Yg?rel=0';
                            } elseif (strpos($cName, 'terminaciones') !== false) {
                                $video_url = 'https://www.youtube.com/embed/EFj6mLwhkjg?rel=0';
                            } elseif (strpos($cName, 'industrial') !== false) {
                                $video_url = 'https://www.youtube.com/embed/lvb5RYvgjL0?rel=0';
                            } elseif (strpos($cName, 'analizador') !== false) {
                                $video_url = 'https://www.youtube.com/embed/h9UIxWA7_Lw?rel=0';
                            } elseif (strpos($cName, 'canalizaciones') !== false) {
                                $video_url = 'https://www.youtube.com/embed/HhwUmtNPrto?rel=0';
                            } elseif (strpos($cName, 'empalmes') !== false) {
                                $video_url = 'https://www.youtube.com/embed/EFwgRMFiN-A?rel=0';
                            } else {
                                $video_url = 'https://www.youtube.com/embed/7SMbMxs27K0?rel=0';
                            }
                            ?>
                            <div class="course-video-container" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 20px;">
                                <iframe width="100%" height="450" src="<?= $video_url ?>" title="Video de introducción" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display: block;"></iframe>
                            </div>
                            <div class="courses-one__single-content" style="padding-top: 0; border: none; box-shadow: none;">
                                <div class="course-details__content-list">
                                    <h3 class="course-details__curriculum-single-title">Requisitos</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>No se necesita conocimiento previo.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Una laptop o cualquier dispositivo con conexión a internet.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>
                            </div>
                        </div>
                        <!--End Single Courses One-->

                        <!--Start Dynamic Course Curriculum Accordions-->

<style>
    .course-cards-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 20px !important;
        margin-top: 20px;
        margin-bottom: 30px;
        width: 100%;
    }
    @media (max-width: 768px) {
        .course-cards-grid {
            grid-template-columns: 1fr !important;
        }
    }
    .info-card {
        text-align: left !important;
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        width: 100% !important;
        box-sizing: border-box;
    }
    .info-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); 
    }
    .info-card-title {
        font-size: 1.15rem; 
        margin-bottom: 18px; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        font-weight: 700; 
        color: #0f172a;
    }
    .info-card-content {
        font-size: 0.95rem; 
        color: #475569; 
        line-height: 1.6;
        flex-grow: 1;
    }
    .info-card-content ul { 
        padding-left: 0; 
        margin-bottom: 10px; 
        list-style-type: none;
    }
    .info-card-content ul li { 
        margin-bottom: 10px; 
        position: relative; 
        padding-left: 28px;
    }
    .info-card-content ul li::before { 
        content: '\f00c'; 
        font-family: 'Font Awesome 5 Free'; 
        font-weight: 900; 
        position: absolute; 
        left: 0; 
        font-size: 1rem; 
        top: 2px; 
        color: #10b981;
    }
    .schedule-box { 
        background: #f8fafc; 
        border: 1px dashed #cbd5e1; 
        padding: 15px; 
        border-radius: 8px; 
        margin-bottom: 15px; 
    }
    .schedule-box h5 { margin-top: 0; margin-bottom: 10px; color: #0f172a; font-weight: 700; font-size: 1rem; }
    .schedule-box ul li::before { content: '📅'; }
</style>
<!--Start Dynamic Course Curriculum Accordions-->


<?php if (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'subestaciones') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 25 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado a planificar, ejecutar y documentar mantenimientos de subestaciones eléctricas, combinando contenido teórico y práctica en campo.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Mantenimiento correctivo, preventivo y predictivo</li>
                                        <li>Tipos y partes de subestaciones eléctricas</li>
                                        <li>Transformadores, seccionadores y fusibles</li>
                                        <li>Equipos de protección personal y trajes ignífugos</li>
                                        <li>Equipos de maniobra y reglas de seguridad</li>
                                        <li>Medición de aislamiento y relación de transformación</li>
                                        <li>Análisis de aceite dieléctrico</li>
                                        <li>Visitas técnicas, informes y protocolos</li>
                                        <li>Certificado de operatividad</li>
                                        <li>Procedimientos de corte y puesta en marcha</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Megómetro digital de 5000V</li>
                                                <li style="margin-bottom: 5px;">Kit extractor de aceite dieléctrico</li>
                                                <li style="margin-bottom: 5px;">Pértigas de maniobra</li>
                                                <li style="margin-bottom: 5px;">Revelador de tensión</li>
                                                <li style="margin-bottom: 5px;">Pinza amperimétrica</li>
                                                <li style="margin-bottom: 5px;">Traje ignífugo</li>
                                                <li style="margin-bottom: 5px;">Careta contra arco eléctrico</li>
                                                <li style="margin-bottom: 5px;">Guantes dieléctricos</li>
                                                <li style="margin-bottom: 5px;">Equipos de seguridad y señalización</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>18/08:</strong> Online - Zoom de 6:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>19/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>20/08:</strong> Online - Zoom de 6:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>21/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>22/08:</strong> Online - Zoom de 2:00 p.m. a 7:00 p.m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'condensadores') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 25 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado a la compensación de energía reactiva y a la mejora del factor de potencia en sistemas eléctricos industriales.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Energía reactiva y triángulo de potencia</li>
                                        <li>Sistemas inductivos y capacitivos</li>
                                        <li>Determinación y corrección del factor de potencia</li>
                                        <li>Cálculo de KVAR con compensación fija</li>
                                        <li>Cálculo de KVAR con compensación automática</li>
                                        <li>Análisis de KVAR.h en facturación eléctrica</li>
                                        <li>Bancos de condensadores fijos y automáticos</li>
                                        <li>Diseño bajo normativa IEC</li>
                                        <li>Reducción de pérdidas y caídas de tensión</li>
                                        <li>Selección de contactores, fusibles, conductores y reguladores</li>
                                        <li>Instalación práctica de condensadores</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Condensadores cilíndricos de 25 KVAR</li>
                                                <li style="margin-bottom: 5px;">Kit de contactores para condensadores</li>
                                                <li style="margin-bottom: 5px;">Interruptores termomagnéticos</li>
                                                <li style="margin-bottom: 5px;">Controlador de factor de potencia</li>
                                                <li style="margin-bottom: 5px;">Transformadores de corriente</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>01/09:</strong> En VIVO Zoom de 7:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>02/09:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>03/09:</strong> En VIVO Zoom de 7:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>04/09:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>05/09:</strong> En VIVO Zoom de 9:00 a. m. a 1:00 p. m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'analizador') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 25 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso dirigido a quienes desean evaluar, registrar y analizar parámetros eléctricos y perturbaciones en redes de baja y media tensión.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Tipos de analizadores y normativa vigente</li>
                                        <li>Parámetros eléctricos y perturbaciones</li>
                                        <li>Selección e instalación de analizadores</li>
                                        <li>Conexionado en tablero y campo</li>
                                        <li>Configuración de eventos y parámetros</li>
                                        <li>Tipos de conexión e intervalos de medición</li>
                                        <li>Extracción y modelación de datos</li>
                                        <li>Elaboración de informes técnicos</li>
                                        <li>Taller con analizador My Ebox 1500 – Circutor</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Analizador de redes Circutor</li>
                                                <li style="margin-bottom: 5px;">Analizador de redes Fluke o Metrel</li>
                                                <li style="margin-bottom: 5px;">Traje ignífugo y careta contra arco eléctrico</li>
                                                <li style="margin-bottom: 5px;">Interruptor y transformador de prueba</li>
                                                <li style="margin-bottom: 5px;">Laptop, recomendable para el alumno</li>
                                                <li style="margin-bottom: 5px;">Equipos de seguridad y señalización</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>17/08:</strong> Zoom de 6:00 p.m. a 8:00 p.m.</li>
                                            <li><strong>18/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>20/08:</strong> Zoom de 6:00 p.m. a 8:00 p.m.</li>
                                            <li><strong>22/08:</strong> Zoom de 9:00 a.m. a 1:00 p.m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'canalizacion') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 16 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso enfocado en la ejecución de canalizaciones eléctricas con tuberías Conduit para instalaciones residenciales, comerciales e industriales.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Fundamentos de canalización eléctrica</li>
                                        <li>Tuberías EMT, IMC y Conduit flexible</li>
                                        <li>Accesorios, conectores, cajas de paso y condulet</li>
                                        <li>Interpretación de planos eléctricos</li>
                                        <li>Trazado de rutas y metrado de materiales</li>
                                        <li>Herramientas de corte, perforación y doblado</li>
                                        <li>Anclajes, soportes, riel Unistrut y abrazaderas</li>
                                        <li>Curvas de 90°, offset y bayoneta</li>
                                        <li>Roscado de tubería IMC</li>
                                        <li>Montaje de canalizaciones</li>
                                        <li>Inspección, pruebas y mantenimiento</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Tuberías Conduit IMC de ¾”</li>
                                                <li style="margin-bottom: 5px;">Tuberías Conduit IMC de 1”</li>
                                                <li style="margin-bottom: 5px;">Tuberías Conduit EMT de ¾”</li>
                                                <li style="margin-bottom: 5px;">Doblador manual y doblador hidráulico</li>
                                                <li style="margin-bottom: 5px;">Cortador manual</li>
                                                <li style="margin-bottom: 5px;">Bandeja metálica y cajas de pase</li>
                                                <li style="margin-bottom: 5px;">Accesorios para anclaje</li>
                                                <li style="margin-bottom: 5px;">Uniones, conectores, curvas y adaptadores</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países (NO HAY POR EL MOMENTO)</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>04/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>05/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>06/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                                            <li><strong>07/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>09/08:</strong> Zoom en VIVO de 8:00 a.m. a 12:00 p.m.</li>
                                            <li><strong>09/08:</strong> Zoom en VIVO de 1:00 p.m. a 5:00 p.m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'terminaciones') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 15 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado a aprender la correcta instalación de terminaciones en cables de media tensión, aplicando procedimientos técnicos, criterios de seguridad y buenas prácticas del sector.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Tipos de cables y niveles de tensión</li>
                                        <li>Conductor, aislamiento, semiconductoras y pantalla metálica</li>
                                        <li>Aislamientos XLPE, HEPR y EPR</li>
                                        <li>Terminaciones rectas, interiores, exteriores y tripolares hasta 36 kV</li>
                                        <li>Componentes de una terminación</li>
                                        <li>Medición de aislamiento con megómetro</li>
                                        <li>Herramientas aisladas y equipos de protección personal</li>
                                        <li>Práctica de terminaciones interior y exterior hasta 25 kV</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Cilindro de gas GLP y boquilla de 2”</li>
                                                <li style="margin-bottom: 5px;">Kit de terminación termocontraíble de uso exterior</li>
                                                <li style="margin-bottom: 5px;">Cable de media tensión de 10 kV y/o 25 kV</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>26/08:</strong> Zoom en VIVO de 6:00 p.m. a 8:00 p.m.</li>
                                            <li><strong>27/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>29/08:</strong> Zoom en VIVO de 8:00 a.m. a 12:00 p.m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'empalmes') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 15 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado a aprender la correcta instalación de empalmes en cables de media tensión, aplicando procedimientos técnicos, criterios de seguridad y buenas prácticas del sector.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Tipos de cables y niveles de tensión</li>
                                        <li>Conductor, aislamiento, semiconductoras y pantalla metálica</li>
                                        <li>Aislamientos XLPE, HEPR y EPR</li>
                                        <li>Empalmes termocontraíbles unipolares hasta 36 kV</li>
                                        <li>Componentes y preparación del empalme</li>
                                        <li>Medición de aislamiento con megómetro</li>
                                        <li>Herramientas aisladas y equipos de protección personal</li>
                                        <li>Práctica de empalmes termocontraíbles hasta 25 kV</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">Cilindro de gas GLP y boquilla de 2”</li>
                                                <li style="margin-bottom: 5px;">Kit de terminación termocontraíble de uso exterior</li>
                                                <li style="margin-bottom: 5px;">Cable de media tensión de 10 kV y/o 25 kV</li>
                                                <li style="margin-bottom: 5px;">Herramientas manuales</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>26/08:</strong> Zoom en VIVO de 6:00 p.m. a 8:00 p.m.</li>
                                            <li><strong>27/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>29/08:</strong> Zoom en VIVO de 1:00 p.m. a 5:00 p.m.</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'variadores') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 30 horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado al conexionado, programación y puesta en marcha de variadores de velocidad utilizados en procesos industriales.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                                        <li>Interpretación de planos y manuales</li>
                                        <li>Conexionado de variadores de velocidad</li>
                                        <li>Configuración y operación en modo local y remoto</li>
                                        <li>Programación y puesta en marcha de variadores Schneider</li>
                                        <li>Programación y puesta en marcha de variadores Danfoss</li>
                                        <li>Programación y puesta en marcha de variadores ABB</li>
                                        <li>Programación y puesta en marcha de variadores Delta</li>
                                        <li>Programación y puesta en marcha de variadores Siemens</li>
                                        <li>Programación y puesta en marcha de variadores Allen Bradley</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                    
                    <li style="margin-top: 15px; list-style: none; padding-left: 0;">
                        <h5 style="font-size: 1rem; color: #0f172a; font-weight: 700; margin-bottom: 10px;">🛠️ Equipos y herramientas</h5>
                        <ul style="padding-left: 0; margin-bottom: 0;">
                                                <li style="margin-bottom: 5px;">6 motores eléctricos trifásicos de ¼ HP</li>
                                                <li style="margin-bottom: 5px;">Módulo externo de controles</li>
                                                <li style="margin-bottom: 5px;">Variador Schneider</li>
                                                <li style="margin-bottom: 5px;">Variador Danfoss</li>
                                                <li style="margin-bottom: 5px;">Variador ABB</li>
                                                <li style="margin-bottom: 5px;">Variador Delta</li>
                                                <li style="margin-bottom: 5px;">Variador Siemens</li>
                                                <li style="margin-bottom: 5px;">Variador Allen Bradley</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">

                                    <div class="schedule-box" style="margin-bottom: 15px;">
                                        <h5>🌎 VIRTUAL Perú, Ecuador y otros países AGOSTO</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>20/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p. m.</li>
                                            <li><strong>21/08:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>22/08:</strong> Zoom en VIVO de 9:00 a.m. a 11:00 a.m. (BLOQUE 1)</li>
                                            <li><strong>22/08:</strong> Zoom en VIVO de 11:00 a.m. a 1:00 p.m. (BLOQUE 2)</li>
                                            <li><strong>29/08:</strong> Zoom en VIVO de 9:00 a.m. a 11:00 a.m.(BLOQUE 1)</li>
                                            <li><strong>29/08:</strong> Zoom en VIVO de 11:00 a.m. a 1:00 p.m. (BLOQUE 2)</li>
                                            <li><strong>05/09:</strong> Zoom en VIVO de 9:00 a.m. a 11:00 a.m. (BLOQUE 1)</li>
                                            <li><strong>05/09:</strong> Zoom en VIVO de 11:00 a.m. a 1:00 p.m. (BLOQUE 2)</li>
                                        </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (strpos(mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8'), 'electricidad industrial') !== false): ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 20px;"></i>
                Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p><strong>Duración:</strong> 40 horas académicas</p>
                <p><strong>Modalidad:</strong> 100% Virtual (En vivo y Asíncrono)</p>
                <p><strong>Incluye:</strong> Certificado de participación.</p>
                <p style="margin-top: 10px;">Curso enfocado en brindar los conocimientos y habilidades necesarios para el trabajo en el sector eléctrico industrial, abarcando desde los fundamentos hasta el mantenimiento de sistemas y automatización.</p>
            </div>
        </div>

        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-list-ul" style="color: #3b82f6; font-size: 20px;"></i>
                Temas a tratar
            </h4>
            <div class="info-card-content">
                <ul class="list-unstyled" style="padding-left: 10px; margin-bottom: 0;">
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 1: FUNDAMENTOS DE ELECTROTECNIA</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 2: INSTRUMENTOS ELÉCTRICOS</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 3: PROTECCIONES ELÉCTRICAS</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 4: INTERPRETACIÓN DE PLANOS ELÉCTRICOS</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 5: TRANSFORMADORES ELÉCTRICOS</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 6: MOTORES ELÉCTRICOS INDUSTRIALES</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 7: EQUIPOS DE AUTOMATIZACIÓN</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 8: AUTOMATIZACIÓN INDUSTRIAL</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>MÓDULO 9: MANTENIMIENTO ELÉCTRICO INDUSTRIAL</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-star" style="color: #f59e0b; font-size: 20px;"></i>
                Beneficios del Curso
            </h4>
            <div class="info-card-content">
                <ul class="list-unstyled" style="padding-left: 10px; margin-bottom: 0;">
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>Acceso de por vida al material.</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>Soporte directo del docente.</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>Material de estudio descargable.</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>Certificado de participación.</li>
                </ul>
            </div>
        </div>

        <div class="info-card">
            <h4 class="info-card-title">
                <i class="far fa-calendar-alt" style="color: #ec4899; font-size: 20px;"></i>
                Programación
            </h4>
            <div class="info-card-content">
                <div class="schedule-box" style="margin-bottom: 15px;">
                    <h5>🌎 VIRTUAL Perú, Ecuador, Colombia y otros</h5>
                    <ul style="margin-bottom: 0;">
                        <li><strong>17/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>19/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>24/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>26/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>31/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>02/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>07/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>09/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>14/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                        <li><strong>16/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="course-cards-grid">
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> Evaluado por horas académicas</p>
                <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                <p style="line-height: 1.5;">Curso orientado a desarrollar competencias prácticas y teóricas en la especialidad elegida, brindando herramientas actualizadas y útiles para el sector industrial.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Fundamentos teóricos y normativos</li>
                    <li>Equipos de protección y maniobra</li>
                    <li>Procedimientos de trabajo seguro (5 reglas de oro)</li>
                    <li>Mantenimiento preventivo y correctivo</li>
                    <li>Protocolos de pruebas y elaboración de informes técnicos</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <ul>
                    <li>Certificado de participacion con QR</li>
                    <li>Material digital exclusivo</li>
                    <li>Grupo de WhatsApp del curso</li>
                    <li>Entregables técnicos y formatos</li>
                    <li>Clases teóricas grabadas y/o en vivo</li>
                    <li>Acceso al aula virtual por tiempo limitado</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                📅 Programación y Horarios
            </h4>
            <div class="info-card-content">
                <div class="schedule-box" >
                    <h5>🇵🇪 Virtual Perú</h5>
                    <ul style="margin-bottom: 5px;">
                        <li><strong>Horario:</strong> Por definir</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>






                        <!--Start Course Details Reviews-->
                        <div class="course-details__reviews">
                            <h3 class="course-details__reviews-title">Reseñas</h3>
                            <div class="course-details__progress-review">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7 col-md-7">
                                        <div class="course-details__progress clearfix">
                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Excelente</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 90%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">2</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Muy bueno</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 80%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">1</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Promedio</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 70%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">1</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Pobre</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 0%;" class="no-bubble"></span>
                                                </div>
                                                <p class="course-details__progress-count">0</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Horrible</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 0%;" class="no-bubble"></span>
                                                </div>
                                                <p class="course-details__progress-count">0</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                        <div class="course-details__review-box">
                                            <h2 class="course-details__review-count">4.6</h2>
                                            <div class="course-details__review-stars">
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                            </div>
                                            <p class="course-details__review-text">30 RESEÑAS</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="course-details__add-review">
                                <div class="course-details__add-review-form">
                                    <form action="assets/inc/sendemail.php" class="comment-one__form contact-form-validated" novalidate="novalidate">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <a href="https://wa.link/zkj9jo" target="_black" class="thm-btn comment-form__btn">Inscríbete Aquí</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--End Course Details Reviews-->
                    </div>
                </div>
                <!--End Course Details Content-->

                <!--Start Course Details Sidebar-->
                <div class="col-xl-4 col-lg-4">
                    <div class="course-details__sidebar">
                        <div class="courses-one__single style2 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 30px; box-shadow: 0px 10px 30px 0px rgba(0, 0, 0, 0.07); border-radius: 8px; overflow: hidden; background-color: #ffffff;">
                            <div class="courses-one__single-img">
                                <img src="<?= BASE_URL ?>assets/images/cursos/<?= htmlspecialchars($curso['foto'] ?? 'default.png') ?>" alt="<?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso') ?>" style="width: 100%; height: 220px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                <div class="overlay-text">
                                    <p>libre</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content" style="padding: 20px 20px 10px 20px;">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="https://ui-avatars.com/api/?name=Ricardo+Cardenas&background=random&color=fff&size=50" alt="Profesor" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <h6 class="courses-one__single-content-name">Ricardo Cardenas <span>Actualizado recientemente</span></h6>
                                <h4 class="courses-one__single-content-title" style="font-size: 18px; line-height: 1.3; margin-bottom: 10px;"><?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso en ICC') ?></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(5)</span>
                                    </div>
                                </div>
                                
                                <hr style="margin: 25px 0 20px 0; border-top: 1px solid #eaeaea;">
                                
                                <?php
                                $precioPreventa = 89.90;
                                $precioRegular = 99.90;
                                $precioPreventaUSD = 30.00;
                                $precioRegularUSD = 60.00;
                                $nombreCursoSafe = mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8');

                                if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 450.00;
                                    $precioPreventaUSD = 45.00;
                                    $precioRegularUSD = 120.00;
                                } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 200.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 150.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                                    $precioPreventa = 100.00;
                                    $precioRegular = 450.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 200.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 200.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                                    $precioPreventa = 99.00;
                                    $precioRegular = 200.00;
                                    $precioPreventaUSD = 35.00;
                                    $precioRegularUSD = 60.00;
                                } elseif (strpos($nombreCursoSafe, 'electricidad industrial') !== false) {
                                    $precioPreventa = 100.00;
                                    $precioRegular = 200.00;
                                    $precioPreventaUSD = 30.00;
                                    $precioRegularUSD = 60.00;
                                }
                                ?>
                                <div class="course-details__price-united" style="text-align: center; padding-bottom: 10px;">
                                    
                                    
                    <style>
                    .currency-toggle-detalle {
                        display: inline-flex;
                        background-color: #e4e6eb;
                        border-radius: 30px;
                        padding: 5px;
                        box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
                        margin-bottom: 20px;
                    }
                    .currency-toggle-detalle .currency-btn {
                        border: none;
                        background: transparent;
                        padding: 6px 15px;
                        border-radius: 25px;
                        font-size: 14px;
                        font-weight: 600;
                        color: #555;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        outline: none;
                        display: flex;
                        align-items: center;
                        gap: 6px;
                    }
                    .currency-toggle-detalle .currency-btn:hover {
                        color: #1a1e68;
                    }
                    .currency-toggle-detalle .currency-btn.active {
                        background-color: #1a1e68;
                        color: #fff;
                        box-shadow: 0 4px 10px rgba(26, 30, 104, 0.3);
                    }
                    </style>
                    <div style="text-align: center;">
                        <div class="currency-toggle-detalle" id="detailCurrencyToggle">
                            <button type="button" class="currency-btn active" data-currency="PEN">
                                PEN
                            </button>
                            <button type="button" class="currency-btn" data-currency="USD">
                                USD
                            </button>
                        </div>
                    </div>

                                    
                                    
                                    <style>
                                    .price-showcase-box {
                                        background-color: #0b1126;
                                        border: 2px solid #3b4cb8;
                                        border-radius: 12px;
                                        padding: 30px 20px;
                                        position: relative;
                                        text-align: center;
                                        margin: 30px auto;
                                        max-width: 100%;
                                        box-shadow: 0 10px 30px rgba(11, 17, 38, 0.4);
                                    }
                                    .price-showcase-box .monto-label {
                                        color: #8b9be5;
                                        font-size: 14px;
                                        font-weight: 700;
                                        letter-spacing: 1px;
                                        text-transform: uppercase;
                                        margin-bottom: 5px;
                                    }
                                    .price-showcase-box .monto-value {
                                        color: #ffffff;
                                        font-size: 55px;
                                        font-weight: 700;
                                        line-height: 1;
                                        display: flex;
                                        align-items: baseline;
                                        justify-content: center;
                                        gap: 8px;
                                    }
                                    .price-showcase-box .monto-value .currency-code {
                                        font-size: 20px;
                                        color: #8b9be5;
                                        font-weight: 700;
                                    }
                                    
                                    .price-regular-tag {
                                        position: absolute;
                                        top: -20px;
                                        right: -10px;
                                        background-color: #ffd000;
                                        color: #000;
                                        padding: 8px 18px;
                                        border-radius: 6px;
                                        transform: rotate(5deg);
                                        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                                        text-align: center;
                                        z-index: 10;
                                    }
                                    .price-regular-tag .tag-label {
                                        font-size: 11px;
                                        font-weight: 800;
                                        text-transform: uppercase;
                                        line-height: 1.2;
                                        letter-spacing: 0.5px;
                                    }
                                    .price-regular-tag .tag-value {
                                        font-size: 20px;
                                        font-weight: 800;
                                        text-decoration: line-through;
                                        text-decoration-color: #3b4cb8;
                                        text-decoration-thickness: 3px;
                                        line-height: 1.2;
                                    }
                                    </style>
                                    
                                    <div class="price-showcase-box">
                                        <div class="price-regular-tag">
                                            <div class="tag-label">Precio Regular</div>
                                            <div class="tag-value" id="priceRegularDisplay">S/ <?= number_format($precioRegular, 2) ?></div>
                                        </div>
                                        <div class="monto-label">Monto total a pagar</div>
                                        <div class="monto-value">
                                            <span id="priceDisplay">S/ <?= number_format($precioPreventa, 2) ?></span>
                                            <span class="currency-code" id="currencyCodeDisplay">PEN</span>
                                        </div>
                                    </div>

                                    <div class="course-details__price-btn">
                                        <a id="buyButton" href="<?= BASE_URL ?>checkout?curso=<?= urlencode($curso['nombre_curso'] ?? 'Curso en ICC') ?>&precio=<?= $precioPreventa ?>&moneda=PEN" class="thm-btn" style="width: 100%; display: block; text-align: center; background-color: #0d1b2a; padding: 12px 0; border-radius: 6px;">compra este curso</a>
                                    </div>
                                </div>
                                
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const toggleContainer = document.getElementById('detailCurrencyToggle');
                                    const priceDisplay = document.getElementById('priceDisplay');
                                    const priceRegularDisplay = document.getElementById('priceRegularDisplay');
                                    const buyButton = document.getElementById('buyButton');
                                    
                                    if(toggleContainer) {
                                        const prices = {
                                            PEN: {
                                                preventa: '<?= number_format($precioPreventa, 2) ?>',
                                                preventa_raw: '<?= $precioPreventa ?>',
                                                regular: '<?= number_format($precioRegular, 2) ?>',
                                                symbol: 'S/'
                                            },
                                            USD: {
                                                preventa: '<?= number_format($precioPreventaUSD, 2) ?>',
                                                preventa_raw: '<?= $precioPreventaUSD ?>',
                                                regular: '<?= number_format($precioRegularUSD, 2) ?>',
                                                symbol: 'US$'
                                            }
                                        };
                                        
                                        const baseUrl = '<?= BASE_URL ?>checkout?curso=<?= urlencode($curso['nombre_curso'] ?? 'Curso en ICC') ?>';
                                        
                                        const buttons = toggleContainer.querySelectorAll('.currency-btn');
                                        buttons.forEach(btn => {
                                            btn.addEventListener('click', function() {
                                                buttons.forEach(b => b.classList.remove('active'));
                                                this.classList.add('active');
                                                
                                                const currency = this.getAttribute('data-currency');
                                                const data = prices[currency];
                                                
                                                priceDisplay.innerText = data.symbol + " " + data.preventa;
                                                priceRegularDisplay.innerText = data.symbol + " " + data.regular;
                                                const currencyCodeDisplay = document.getElementById('currencyCodeDisplay');
                                                if(currencyCodeDisplay) {
                                                    currencyCodeDisplay.innerText = currency;
                                                }
                                                
                                                buyButton.href = baseUrl + '&precio=' + data.preventa_raw + '&moneda=' + currency;
                                            });
                                        });
                                    }
                                });
                                </script>
                            </div>
                        </div>



                        <div class="course-details__new-courses wow fadeInUp animated" data-wow-delay="0.5s">
                            <h3 class="course-details__new-courses-title">Nuevos cursos</h3>
                            <ul class="course-details__new-courses-list list-unstyled">
                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_ANA.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/analisis-facturacion">Análisis de facturación y tarifas eléctricas</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>

                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_EMPTER.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/puesta-tierra">Sistema puesta a tierra</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>

                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_BDC.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/banco-condensadores">Banco de condensadores</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End Course Details Sidebar-->
            </div>
        </div>
    </section>
    <!--End Course Details-->



