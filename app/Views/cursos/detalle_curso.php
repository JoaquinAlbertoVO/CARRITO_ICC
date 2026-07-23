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
                            $cName = strtolower($curso['nombre_curso'] ?? '');
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
                            .accordion-btn {
                                width: 100%; padding: 14px 18px; text-align: left; background: var(--surface-color, #f8f9fa); border: 1px solid var(--surface-border, #e9ecef); border-radius: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 600; color: var(--text-color, #333); margin-bottom: 8px; transition: all 0.2s ease;
                            }
                            .accordion-btn:hover { background: #e9ecef; }
                            .accordion-btn.active { background: #e0f2fe; border-color: #bae6fd; color: #0369a1; border-bottom-left-radius: 0; border-bottom-right-radius: 0; margin-bottom: 0;}
                            .accordion-content {
                                padding: 18px; border: 1px solid #bae6fd; border-top: none; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; font-size: 0.9rem; color: var(--text-muted, #555); background: #fff; margin-bottom: 8px;
                            }
                            .accordion-content ul { padding-left: 0; margin-bottom: 10px; list-style-type: none; }
                            .accordion-content ul li { margin-bottom: 8px; position: relative; padding-left: 24px; line-height: 1.4; }
                            .accordion-content ul li::before { content: '\f00c'; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute; left: 0; font-size: 0.9rem; top: 2px; color: #10b981;}
                            .schedule-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
                            .schedule-box h5 { margin-top: 0; margin-bottom: 10px; color: #0f172a; font-weight: 700; font-size: 1rem; }
                            .schedule-box ul li::before { content: '📅'; }
                        </style>
<?php if (strpos(strtolower($curso['nombre_curso'] ?? ''), 'subestaciones') !== false): ?>
<div class="course-accordion"   style="margin-top: 20px;">
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn vanilla-btn active"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"  >
                                    <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 25 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                                    <p style="line-height: 1.5;">Curso orientado a planificar, ejecutar y documentar mantenimientos de subestaciones eléctricas, combinando contenido teórico y práctica en campo.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
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

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Herramientas y Materiales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-tools" style="color: #f97316; font-size: 1.1rem;"></i> Herramientas y Materiales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Megómetro digital de 5000V</li>
                                        <li>Kit extractor de aceite dieléctrico</li>
                                        <li>Pértigas de maniobra</li>
                                        <li>Revelador de tensión</li>
                                        <li>Pinza amperimétrica</li>
                                        <li>Traje ignífugo</li>
                                        <li>Careta contra arco eléctrico</li>
                                        <li>Guantes dieléctricos</li>
                                        <li>Equipos de seguridad y señalización</li>
                                        <li>Herramientas manuales</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 5: Programación -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>📅 Programación y Horarios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <div class="schedule-box" >
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>20/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>23/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/07:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box"  style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>20/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>23/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/07:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
<?php elseif (strpos(strtolower($curso['nombre_curso'] ?? ''), 'condensadores') !== false): ?>
<div class="course-accordion"   style="margin-top: 20px;">
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn vanilla-btn active"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"  >
                                    <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 25 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
                                    <p style="line-height: 1.5;">Curso orientado a la compensación de energía reactiva y a la mejora del factor de potencia en sistemas eléctricos industriales.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Energía reactiva y triángulo de potencia</li>
                                        <li>Sistemas inductivos y capacitivos</li>
                                        <li>Determinación y corrección del factor de potencia</li>
                                        <li>Cálculo de KVAR con compensación fija y automática</li>
                                        <li>Análisis de KVAR.h en facturación eléctrica</li>
                                        <li>Bancos de condensadores fijos y automáticos</li>
                                        <li>Diseño bajo normativa IEC</li>
                                        <li>Reducción de pérdidas y caídas de tensión</li>
                                        <li>Selección de contactores, fusibles, conductores y reguladores</li>
                                        <li>Instalación práctica de condensadores</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Herramientas y Materiales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>🛠️ Equipos y herramientas</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Condensadores cilíndricos de 25 KVAR</li>
                                        <li>Kit de contactores para condensadores</li>
                                        <li>Interruptores termomagnéticos</li>
                                        <li>Controlador de factor de potencia</li>
                                        <li>Transformadores de corriente</li>
                                        <li>Herramientas manuales</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 5: Programación -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>📅 Programación y Horarios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <div class="schedule-box" >
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>01/09:</strong> Zoom en VIVO de 7:00 pm a 9:00 pm</li>
                                            <li><strong>02/09:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>03/09:</strong> Zoom en VIVO de 7:00 pm a 9:00 pm</li>
                                            <li><strong>04/09:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box"  style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>01/09:</strong> Zoom en VIVO de 7:00 pm a 9:00 pm</li>
                                            <li><strong>02/09:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>03/09:</strong> Zoom en VIVO de 7:00 pm a 9:00 pm</li>
                                            <li><strong>04/09:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
<?php elseif (strpos(strtolower($curso['nombre_curso'] ?? ''), 'industrial') !== false): ?>
<div class="course-accordion"   style="margin-top: 20px;">
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn vanilla-btn active"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"  >
                                    <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 40 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación</p>
                                    <p style="line-height: 1.5;">Curso de especialización en electricidad industrial, cubriendo desde los fundamentos hasta el mantenimiento y automatización.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>MÓDULO 1: FUNDAMENTOS DE ELECTROTECNIA</li>
                                        <li>MÓDULO 2: INSTRUMENTOS ELÉCTRICOS</li>
                                        <li>MÓDULO 3: PROTECCIONES ELÉCTRICAS</li>
                                        <li>MÓDULO 4: INTERPRETACIÓN DE PLANOS ELÉCTRICOS</li>
                                        <li>MÓDULO 5: TRANSFORMADORES ELÉCTRICOS</li>
                                        <li>MÓDULO 6: MOTORES ELÉCTRICOS INDUSTRIALES</li>
                                        <li>MÓDULO 7: EQUIPOS DE AUTOMATIZACIÓN</li>
                                        <li>MÓDULO 8: AUTOMATIZACIÓN INDUSTRIAL</li>
                                        <li>MÓDULO 9: MANTENIMIENTO ELÉCTRICO INDUSTRIAL</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Programación -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>📅 Programación y Horarios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <div class="schedule-box" >
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>03/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>05/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>07/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>10/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>12/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>14/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>17/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>19/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box"  style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>03/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>05/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>07/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>10/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>12/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>14/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>17/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>19/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/08:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
<?php elseif (strpos(strtolower($curso['nombre_curso'] ?? ''), 'terminaciones') !== false): ?>
<div class="course-accordion"   style="margin-top: 20px;">
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn vanilla-btn active"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"  >
                                    <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 15 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación.</p>
                                    <p style="line-height: 1.5;">Curso orientado a aprender la correcta instalación de terminaciones en cables de media tensión, aplicando procedimientos técnicos, criterios de seguridad y buenas prácticas del sector.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
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

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Programación -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>📅 Programación y Horarios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <div class="schedule-box" >
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>15/07:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>16/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>18/07:</strong> Zoom en VIVO PRACTICA de 9:00 a. m. a 1:00 p. m.</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box"  style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>15/07:</strong> Zoom en VIVO de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>16/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>18/07:</strong> Zoom en VIVO PRACTICA de 9:00 a. m. a 1:00 p. m.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
<?php elseif (strpos(strtolower($curso['nombre_curso'] ?? ''), 'analizador') !== false): ?>
<div class="course-accordion"   style="margin-top: 20px;">
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn vanilla-btn active"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"  >
                                    <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> 15 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación</p>
                                    <p style="line-height: 1.5;">Curso dirigido a quienes desean evaluar, registrar y analizar parámetros eléctricos y perturbaciones en redes de baja y media tensión.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Tipos de analizadores y normativa vigente</li>
                                        <li>Parámetros eléctricos y perturbaciones</li>
                                        <li>Selección e instalación de analizadores</li>
                                        <li>Conexionado en tablero y campo</li>
                                        <li>Configuración de eventos y parámetros</li>
                                        <li>Tipos de conexión e intervalos de medición</li>
                                        <li>Extracción y modelación de datos</li>
                                        <li>Elaboración de informes técnicos</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Programación -->
                            <div>
                                <button class="accordion-btn vanilla-btn"  >
                                    <span>📅 Programación y Horarios</span>
                                    <span  style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content"   style="display: none;">
                                    <div class="schedule-box" >
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>17/08:</strong> Zoom en Vivo de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>18/08:</strong> Sesión virtual asíncrona (Grabada)</li>
                                            <li><strong>20/08:</strong> Zoom en Vivo de 7:00 p. m. a 9:00 p. m.</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box"  style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>17/08:</strong> Zoom en Vivo de 7:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>18/08:</strong> Sesión virtual asíncrona (Grabada)</li>
                                            <li><strong>20/08:</strong> Zoom en Vivo de 7:00 p. m. a 9:00 p. m.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
<?php else: ?>
<!-- Default Accordion -->
<div class="course-accordion" style="margin-top: 20px;">
    <div>
        <button class="accordion-btn vanilla-btn active">
            <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
            <span style="font-weight: bold; font-size: 1.2rem;">−</span>
        </button>
        <div class="accordion-content">
            <p style="margin-bottom: 8px;"><strong><i class="fas fa-stopwatch" style="color: #3b82f6; margin-right: 5px;"></i> Duración:</strong> Evaluado por horas académicas</p>
            <p style="margin-bottom: 12px;"><strong><i class="fas fa-certificate" style="color: #10b981; margin-right: 5px;"></i> Incluye:</strong> Certificado de participación con QR</p>
            <p style="line-height: 1.5;">Curso orientado a desarrollar competencias prácticas y teóricas en la especialidad elegida, brindando herramientas actualizadas y útiles para el sector industrial.</p>
        </div>
    </div>
    <div>
        <button class="accordion-btn vanilla-btn">
            <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
            <span style="font-weight: bold; font-size: 1.2rem;">+</span>
        </button>
        <div class="accordion-content" style="display: none;">
            <ul>
                <li>Fundamentos teóricos y normativos</li>
                <li>Equipos de protección y maniobra</li>
                <li>Procedimientos de trabajo seguro (5 reglas de oro)</li>
                <li>Mantenimiento preventivo y correctivo</li>
                <li>Protocolos de pruebas y elaboración de informes técnicos</li>
            </ul>
        </div>
    </div>
    <div>
        <button class="accordion-btn vanilla-btn">
            <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
            <span style="font-weight: bold; font-size: 1.2rem;">+</span>
        </button>
        <div class="accordion-content" style="display: none;">
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
<?php endif; ?>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const btns = document.querySelectorAll('.vanilla-btn');
    btns.forEach(btn => {
        btn.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const span = this.querySelector('span:last-child');
            
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                content.style.display = 'none';
                if(span) span.textContent = '+';
            } else {
                const parent = this.closest('.course-accordion');
                if(parent) {
                    parent.querySelectorAll('.vanilla-btn.active').forEach(act => {
                        act.classList.remove('active');
                        if(act.nextElementSibling) act.nextElementSibling.style.display = 'none';
                        const otherSpan = act.querySelector('span:last-child');
                        if(otherSpan) otherSpan.textContent = '+';
                    });
                }
                this.classList.add('active');
                content.style.display = 'block';
                if(span) span.textContent = '−';
            }
        });
    });
});
</script>


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
                                
                                <div class="course-details__price-united" style="text-align: center; padding-bottom: 10px;">
                                    <h2 class="course-details__price-amount" style="font-size: 32px; font-weight: 700; color: #000; margin-bottom: 20px;">S/89.90<span style="font-size: 16px; color: #a1a1a1; margin-left: 10px; text-decoration: line-through; font-weight: 400;">S/99.90</span></h2>
                                    <div class="course-details__price-btn">
                                        <a href="https://wa.link/zkj9jo" target="_black" class="thm-btn" style="width: 100%; display: block; text-align: center; background-color: #0d1b2a; padding: 12px 0; border-radius: 6px;">compra este curso</a>
                                    </div>
                                </div>
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



