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
                <div class="col-xl-8 col-lg-8 order-2 order-lg-1">
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
                            } elseif (strpos($cName, 'variadores') !== false) {
                                $video_url = 'https://www.youtube.com/embed/r6lolq0LJhE?rel=0';
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
<?php if (isset($curso) && $curso): ?>
<div class="course-cards-grid">
    <?php if (!empty($curso['resumen'])): ?>
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-bolt" style="color: #eab308; font-size: 1.3rem;"></i> Resumen del Curso
            </h4>
            <div class="info-card-content">
                <?= $curso['resumen'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($curso['temas'])): ?>
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.3rem;"></i> Temas Principales
            </h4>
            <div class="info-card-content">
                <?= $curso['temas'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($curso['beneficios'])): ?>
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-award" style="color: #f59e0b; font-size: 1.3rem;"></i> Beneficios
            </h4>
            <div class="info-card-content">
                <?= $curso['beneficios'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($curso['programacion'])): ?>
    <div>
        <div class="info-card">
            <h4 class="info-card-title">
                <i class="fas fa-calendar-alt" style="color: #10b981; font-size: 1.3rem;"></i> Programación y Horarios
            </h4>
            <div class="info-card-content">
                <?= $curso['programacion'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="course-cards-grid">
    <div style="padding: 15px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; color: #856404; margin-bottom: 20px; width: 100%;">
        No se encontraron detalles adicionales para este curso.
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
                                    <form action="<?= BASE_URL ?>home/enviar_contacto" method="POST" class="comment-one__form contact-form-validated" novalidate="novalidate">
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
                <div class="col-xl-4 col-lg-4 order-1 order-lg-2">
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
                                $precioPreventa = $curso['precio'] ?? 89.90;
                                $precioPreventaUSD = $curso['precio_usd'] ?? 30.00;
                                $precioRegular = $precioPreventa * 1.5;
                                $precioRegularUSD = $precioPreventaUSD * 1.5; ?>
                                <div class="course-details__price-united" style="text-align: center; padding-bottom: 10px;">
                                    
                                    
                    <style>
                    .currency-toggle-detalle {
                        display: inline-flex;
                        background-color: #e4e6eb;
                        border-radius: 30px;
                        padding: 3px;
                        box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
                        margin-bottom: 20px;
                        line-height: 1;
                        height: auto;
                        min-height: 0;
                    }
                    .currency-toggle-detalle .currency-btn {
                        margin: 0;
                        border: none;
                        background: transparent;
                        padding: 7px 18px;
                        border-radius: 25px;
                        font-size: 14px;
                        font-weight: 600;
                        color: #555;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        outline: none;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        line-height: 1;
                        height: auto;
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



                        <div class="d-none d-lg-block">
<div class="course-details__new-courses wow fadeInUp animated" data-wow-delay="0.5s">
                            <h3 class="course-details__new-courses-title">Nuevos cursos</h3>
                            <ul class="course-details__new-courses-list list-unstyled">
                                <?php foreach($latest_courses as $lc): 
                                    $lc_slug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $lc['nombre_curso'])));
                                    $img = $lc['foto'] ? $lc['foto'] : 'default.png';
                                ?>
                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/<?= $img ?>" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title">
                                            <a href="<?= BASE_URL ?>cursos/detalle/<?= $lc_slug ?>"><?= htmlspecialchars($lc['nombre_curso']) ?></a>
                                        </h4>
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
                                        <p class="course-details__new-courses-price">S/<?= number_format($lc['precio_calculado'], 2) ?></p>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
</div>   </div>
                <!--End Course Details Sidebar-->
            </div>
<div class="col-12 d-block d-lg-none order-3" style="margin-top: 30px;">
<div class="course-details__new-courses wow fadeInUp animated" data-wow-delay="0.5s">
                            <h3 class="course-details__new-courses-title">Nuevos cursos</h3>
                            <ul class="course-details__new-courses-list list-unstyled">
                                <?php foreach($latest_courses as $lc): 
                                    $lc_slug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $lc['nombre_curso'])));
                                    $img = $lc['foto'] ? $lc['foto'] : 'default.png';
                                ?>
                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/<?= $img ?>" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title">
                                            <a href="<?= BASE_URL ?>cursos/detalle/<?= $lc_slug ?>"><?= htmlspecialchars($lc['nombre_curso']) ?></a>
                                        </h4>
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
                                        <p class="course-details__new-courses-price">S/<?= number_format($lc['precio_calculado'], 2) ?></p>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
</div>
        </div>
    </section>
    <!--End Course Details-->



