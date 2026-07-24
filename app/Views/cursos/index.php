
    <!--Page Header Start-->
    <section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/backgrounds/icc_capacitacion.png);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>Cursos</h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                                <li class="active">Cursos</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleContainer = document.getElementById('globalCurrencyToggle');
                    if(toggleContainer) {
                        const buttons = toggleContainer.querySelectorAll('.currency-btn');
                        buttons.forEach(btn => {
                            btn.addEventListener('click', function() {
                                // Remove active class from all
                                buttons.forEach(b => b.classList.remove('active'));
                                // Add to clicked
                                this.classList.add('active');
                                
                                const currency = this.getAttribute('data-currency');
                                const symbol = currency === 'PEN' ? 'S/' : 'US$';
                                
                                document.querySelectorAll('.price-container').forEach(function(el) {
                                    const priceVal = currency === 'PEN' ? el.getAttribute('data-price-pen') : el.getAttribute('data-price-usd');
                                    el.querySelector('.price-val').innerText = symbol + priceVal;
                                });
                            });
                        });
                    }
                });
            </script>

    <!--Page Header End-->



    <!--Courses One Start-->
    <section class="courses-one courses-one--courses">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Revisar nueva lista</span>
                <h2 class="section-title__title">Explorar Cursos</h2>
                <div class="currency-toggle-wrapper" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 20px;">
                    <style>
                    .currency-toggle {
                        display: inline-flex;
                        background-color: #e4e6eb;
                        border-radius: 30px;
                        padding: 3px;
                        box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
                        line-height: 1;
                        height: auto;
                        min-height: 0;
                    }
                    .currency-toggle .currency-btn {
                        margin: 0;
                        border: none;
                        background: transparent;
                        padding: 8px 25px;
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
                    .currency-toggle .currency-btn:hover {
                        color: #1a1e68;
                    }
                    .currency-toggle .currency-btn.active {
                        background-color: #1a1e68;
                        color: #fff;
                        box-shadow: 0 4px 10px rgba(26, 30, 104, 0.3);
                    }
                    </style>
                    <div class="currency-toggle" id="globalCurrencyToggle">
                        <button type="button" class="currency-btn active" data-currency="PEN">
                            PEN
                        </button>
                        <button type="button" class="currency-btn" data-currency="USD">
                            USD
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--Start case-studies-one Top-->
                <div class="courses-one--courses__top">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="courses-one--courses__menu-box">
                            <ul class="project-filter clearfix post-filter has-dynamic-filters-counter list-unstyled">
                                <li data-filter=".filter-item" class="active"><span class="filter-text">Todos</span></li>
                                <li data-filter=".featured"><span class="filter-text">Ingeniería Eléctrica</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End case-studies-one Top-->
            </div>


            <div class="row filter-layout masonary-layout">
                <?php if (!empty($cursos)): ?>
                    <?php foreach ($cursos as $curso): ?>
                        <?php 
                            $slug = strtolower(str_replace(' ', '_', $curso['nombre_curso']));
                            $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                            $slug = str_replace('_', '-', $slug);
                            $foto = !empty($curso['foto']) ? $curso['foto'] : 'default.png';
                            $docFoto = !empty($curso['docente_foto']) ? $curso['docente_foto'] : '50x50';
                        ?>
                        <!--Start Single Courses One-->
                        <div class="col-xl-4 col-lg-4 col-md-6 filter-item featured">
                            <div class="courses-one__single" data-aos="fade-up">
                                <div class="courses-one__single-img">
                                    <div style="width: 100%; height: 200px; overflow: hidden;"><img src="<?= BASE_URL ?>assets/images/cursos/<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($curso['nombre_curso']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius: 12px; margin-bottom: 20px;"></div>
                                    <div class="overlay-text">
                                        <p>libre</p>
                                    </div>
                                </div>
                                <div class="courses-one__single-content" style="background-color: white;">
                                    <div class="courses-one__single-content-overlay-img">
                                        <div style="background-color: var(--mo-surface); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 5px; margin: 0 auto; overflow: hidden;">
                                            <?php if ($docFoto !== '50x50'): ?>
                                                <img src="<?= BASE_URL ?>assets/images/docentes/<?= htmlspecialchars($docFoto) ?>" style="width:100%; height:100%; object-fit:cover; border-radius: 50%;" alt="Docente">
                                            <?php else: ?>
                                                <span style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 9px; line-height: 1;">FOTO<br>50x50</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <h6 class="courses-one__single-content-name"><?= htmlspecialchars($curso['docente'] ?? 'Docente ICC') ?></h6>
                                    <h4 class="courses-one__single-content-title"><a href="<?= BASE_URL ?>cursos/detalle/<?= $slug ?>"><?= htmlspecialchars($curso['nombre_curso']) ?></a></h4>
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
                                    <?php
                                    $precioPreventa = 89.90;
                                    $precioPreventaUSD = 30.00;
                                    $horas = ($curso['horas_academicas'] ?? 20);
                                    $nombreCursoSafe = mb_strtolower($curso['nombre_curso'] ?? '', 'UTF-8');
                                    
                                    if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 45.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                                        $precioPreventa = 100.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 16;
                                    } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 15;
                                    } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 15;
                                    } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                                        $precioPreventa = 99.00;
                                        $precioPreventaUSD = 35.00;
                                        $horas = 30;
                                    } elseif (strpos($nombreCursoSafe, 'electricidad industrial') !== false) {
                                        $precioPreventa = 100.00;
                                        $precioPreventaUSD = 30.00;
                                        $horas = 40;
                                    } else {
                                        $precioPreventa = $curso['precio'] ?? 89.90;
                                        $precioPreventaUSD = 30.00;
                                    }
                                    ?>
                                    <p class="courses-one__single-content-price price-container" data-price-pen="<?= number_format($precioPreventa, 2) ?>" data-price-usd="<?= number_format($precioPreventaUSD, 2) ?>">
                                        <span class="price-val">S/<?= number_format($precioPreventa, 2) ?></span>
                                    </p>
                                    <ul class="courses-one__single-content-courses-info list-unstyled">
                                        <li><?= htmlspecialchars($curso['lecciones'] ?? 10) ?> Lecciones</li>
                                        <li><?= htmlspecialchars($horas) ?> Horas</li>
                                        <li>Experto</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--End Single Courses One-->
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" style="margin-bottom: 50px;">
                        <p>No hay cursos disponibles por el momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Courses One End-->
