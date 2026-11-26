<?php
/**
 * Pagina de inicio con el estilo del checkout v2 (layouts/sitio.php + assets/css/sitio.css).
 * Datos: HomeController::index ($ingenieria_courses, $packs).
 */
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$ingenieria_courses = $ingenieria_courses ?? [];
$img = BASE_URL . 'assets/images/inicio/';
$testimonios = [
    ['curso' => 'Regulación del Mercado Eléctrico', 'texto' => 'Un curso muy recomendado, ayuda ampliar los conocimientos acerca del Sector Energía. Además de conocer el Marco Interinstitucional del Subsector Eléctrico de una forma muy didáctica.'],
    ['curso' => 'Curso de Especialización de Analizador de Redes', 'texto' => 'Este curso fue útil para abarcarme en la especialización de Redes. Los Ponentes son muy concisos y se observa su profesionalismo.'],
    ['curso' => 'Especialización de Motores Eléctricos', 'texto' => 'Los materiales educativos son muy buenos y completos, del mismo modo que resulta muy fácil de abordar sin tener conocimientos previos.'],
    ['curso' => 'Banco de Condensadores', 'texto' => 'Fue todo un placer realizar este curso. Puesto que el enfoque del ponente fue impecable. Me gustaría realizar otro curso que amplíe más conocimientos relacionado a este campo.'],
    ['curso' => 'Sistema de Puesta a Tierra', 'texto' => 'El curso dictado fue muy interesante. La estructura y la calidad de los contenidos han sido de lo mejor para el aprendizaje. Me han permitido descubrir acerca de este tema que tardaría en descubrir por mí mismo.'],
];
?>
<!-- Hero -->
<section class="relative overflow-hidden bg-brand-dark bg-cover bg-center text-white" style="background-image: url('<?= BASE_URL ?>assets/images/fondo_icc_hero.jpg');">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-deep/50 via-transparent to-deep/30"></div>
    <div class="relative mx-auto grid max-w-6xl items-center gap-8 px-4 pb-20 pt-10 md:grid-cols-2 md:pb-24 md:pt-14">
        <div class="text-center md:text-left">
            <span class="inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Instituto de Capacitación Continua</span>
            <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">
                Capacítate y certifícate con <span class="text-accent">nosotros</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-base text-sky-50 sm:text-lg md:mx-0">Actualiza tus conocimientos con cursos de Ingeniería Eléctrica dictados por especialistas, en vivo por Zoom o grabados para avanzar a tu ritmo.</p>
            <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row md:justify-start sm:justify-center">
                <a href="<?= BASE_URL ?>cursos" class="flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-7 py-3 font-display text-base font-bold text-deep shadow-lg hover:brightness-95 sm:w-auto">Ver cursos online <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                <?php if (!empty($packs)): ?>
                <a href="#packs" class="flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl border border-white/50 px-7 py-3 font-display text-base font-semibold text-white hover:bg-white/10 sm:w-auto">Packs grabados</a>
                <?php else: ?>
                <a href="<?= BASE_URL ?>verificar" class="flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl border border-white/50 px-7 py-3 font-display text-base font-semibold text-white hover:bg-white/10 sm:w-auto">Verificar certificado</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="relative mx-auto w-full max-w-[15rem] sm:max-w-xs md:max-w-md">
            <div class="absolute inset-8 rounded-full bg-brand/40 blur-3xl" aria-hidden="true"></div>
            <img src="<?= $img ?>mascota-900.webp" srcset="<?= $img ?>mascota-480.webp 480w, <?= $img ?>mascota-900.webp 900w"
                 sizes="(min-width: 768px) 448px, 320px" width="900" height="900" fetchpriority="high"
                 alt="Bruno, el ingeniero mascota de ICC, con casco y multímetro" class="animate-flotar relative w-full drop-shadow-2xl">
        </div>
    </div>
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="absolute bottom-0 left-0 block h-10 w-full sm:h-16" aria-hidden="true"><path d="M0,40 C240,80 480,0 720,30 C960,60 1200,80 1440,20 L1440,80 L0,80 Z" fill="#ffffff"></path></svg>
</section>

<!-- Por que ICC -->
<section class="bg-white pb-14 pt-6">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-4 px-4 sm:grid-cols-3">
        <?php foreach ([
            ['fas fa-lightbulb', 'Aprende habilidades', 'Nuestros cursos se actualizan constantemente.'],
            ['fas fa-chalkboard-teacher', 'Profesores expertos', 'Te acompañarán docentes con amplia experiencia.'],
            ['fas fa-award', 'Cursos certificados', 'Al culminar las horas lectivas recibirás un certificado otorgado por ICC.'],
        ] as $f): ?>
        <div class="reveal flex items-start gap-4 rounded-2xl border border-line/60 bg-surface p-5">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand text-xl text-white"><i class="<?= $f[0] ?>" aria-hidden="true"></i></span>
            <div>
                <h2 class="font-display text-lg font-bold text-deep"><?= $f[1] ?></h2>
                <p class="mt-1 text-sm text-muted"><?= $f[2] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Cursos -->
<section id="cursos" class="bg-surface py-14" x-data="{ moneda: 'PEN' }">
    <div class="mx-auto max-w-6xl px-4">
        <div class="reveal text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand">Todos los meses hay contenido nuevo</p>
            <h2 class="mt-2 font-display text-2xl font-bold text-brand-dark sm:text-3xl">Cursos especializados en Ingeniería</h2>
            <div class="mt-5 inline-flex rounded-full bg-white p-1 shadow-sm ring-1 ring-line/60" role="group" aria-label="Moneda de los precios">
                <button type="button" @click="moneda = 'PEN'" :aria-pressed="moneda === 'PEN'" :class="moneda === 'PEN' ? 'bg-brand text-white shadow' : 'text-muted hover:text-deep'" class="min-h-[40px] rounded-full px-5 text-sm font-bold">Soles (S/)</button>
                <button type="button" @click="moneda = 'USD'" :aria-pressed="moneda === 'USD'" :class="moneda === 'USD' ? 'bg-brand text-white shadow' : 'text-muted hover:text-deep'" class="min-h-[40px] rounded-full px-5 text-sm font-bold">Dólares (US$)</button>
            </div>
        </div>

        <?php if ($ingenieria_courses): ?>
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($ingenieria_courses as $course):
                $url = BASE_URL . 'cursos/detalle/' . str_replace(['detalle_', '.php', '_'], ['', '', '-'], $course['link']); ?>
            <article class="reveal group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
                <div class="aspect-video overflow-hidden bg-deep">
                    <img src="<?= BASE_URL . $h($course['image']) ?>" alt="" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="flex flex-1 flex-col p-5">
                    <span class="w-fit rounded-full bg-accent px-3 py-0.5 text-xs font-bold uppercase tracking-wide text-deep">Curso</span>
                    <h3 class="mt-3 font-display text-lg font-bold leading-snug text-deep">
                        <a href="<?= $h($url) ?>" class="after:absolute after:inset-0 focus:outline-none"><?= $h($course['title']) ?></a>
                    </h3>
                    <div class="mt-auto flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-mist pt-4 text-sm text-muted">
                        <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-brand" aria-hidden="true"></i><?= $h($course['date'] ?? 'PRÓXIMAMENTE') ?></span>
                        <span class="flex items-center gap-1.5"><i class="far fa-clock text-brand" aria-hidden="true"></i><?= $h($course['hours']) ?></span>
                        <span class="ml-auto font-display text-lg font-extrabold text-brand">
                            <span x-show="moneda === 'PEN'">S/ <?= $h($course['price']) ?></span>
                            <span x-show="moneda === 'USD'" x-cloak>US$ <?= $h($course['price_usd'] ?? '30.00') ?></span>
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="mt-8 text-center text-muted">Pronto publicaremos nuevos cursos. Escríbenos por WhatsApp para conocer las próximas fechas.</p>
        <?php endif; ?>

        <div class="mt-10 text-center">
            <a href="<?= BASE_URL ?>cursos" class="inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-brand px-7 py-3 font-display font-bold text-white shadow-md hover:bg-brand-dark">Ver todos los cursos <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<?php if (!empty($packs)) { require __DIR__ . '/packs.php'; } ?>

<!-- Aprende con ICC -->
<section class="overflow-hidden bg-white py-16">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 md:grid-cols-2">
        <div class="reveal">
            <p class="text-sm font-bold uppercase tracking-widest text-brand">Así aprendes con nosotros</p>
            <h2 class="mt-2 font-display text-3xl font-bold leading-tight text-brand-dark sm:text-4xl">Aprende ahora con ICC</h2>
            <p class="mt-4 text-lg text-muted">Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.</p>
            <ul class="mt-8 space-y-4">
                <li class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="fas fa-video" aria-hidden="true"></i></span>
                    <span class="font-display text-lg font-bold text-deep">Empieza a aprender de nuestros expertos</span>
                </li>
                <li class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
                    <span class="font-display text-lg font-bold text-deep">Mejora tus habilidades con nosotros ahora</span>
                </li>
            </ul>
        </div>
        <div class="reveal relative mx-auto h-[420px] w-full max-w-md sm:h-[460px]">
            <div class="absolute -right-10 top-6 h-72 w-72 rounded-full bg-mist" aria-hidden="true"></div>
            <img src="<?= $img ?>clases-zoom-600.webp" width="600" height="699" loading="lazy"
                 alt="Clases en vivo por Zoom: alumnos de ICC conectados a una sesión"
                 class="absolute right-0 top-0 w-[68%] rounded-2xl shadow-xl ring-1 ring-black/5">
            <img src="<?= $img ?>material-curso-600.webp" width="600" height="600" loading="lazy"
                 alt="Material del curso virtual: guías en PDF, plantillas, manuales y libros"
                 class="absolute bottom-0 left-0 w-[56%] rounded-2xl shadow-2xl ring-4 ring-white">
        </div>
    </div>
</section>

<!-- Opiniones -->
<section class="bg-surface py-16">
    <div class="mx-auto max-w-6xl px-4">
        <div class="reveal text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand">Qué opinan nuestros alumnos</p>
            <h2 class="mt-2 font-display text-2xl font-bold text-brand-dark sm:text-3xl">¿Qué están diciendo?</h2>
        </div>
        <div class="mt-8 flex snap-x gap-4 overflow-x-auto pb-4 md:grid md:grid-cols-3 md:overflow-visible md:pb-0">
            <?php foreach ($testimonios as $t): ?>
            <figure class="reveal flex w-[85%] shrink-0 snap-center flex-col rounded-2xl border-t-4 border-brand bg-white p-6 shadow-sm md:w-auto">
                <i class="fas fa-quote-left text-2xl text-accent" aria-hidden="true"></i>
                <blockquote class="mt-3 flex-1 text-sm leading-relaxed text-ink"><?= $h($t['texto']) ?></blockquote>
                <figcaption class="mt-5 border-t border-mist pt-4">
                    <p class="font-display font-bold text-deep"><?= $h($t['curso']) ?></p>
                    <p class="text-xs text-muted">Alumno de ICC</p>
                </figcaption>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Llamado final -->
<section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-4">
        <div class="reveal relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-dark to-brand px-6 py-12 text-center text-white shadow-xl sm:px-12 md:flex md:items-center md:justify-between md:text-left">
            <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-accent/20 blur-2xl" aria-hidden="true"></div>
            <div class="relative">
                <h2 class="font-display text-2xl font-bold sm:text-3xl">Comienza tu carrera educativa con ICC</h2>
                <p class="mt-2 text-sky-100">Te ayudamos a elegir el curso que necesitas.</p>
            </div>
            <div class="relative mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center md:mt-0">
                <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3 font-display font-bold text-deep hover:brightness-95"><i class="fab fa-whatsapp" aria-hidden="true"></i> Escríbenos</a>
                <a href="<?= BASE_URL ?>contacto" class="flex min-h-[48px] items-center justify-center gap-2 rounded-xl border border-white/50 px-6 py-3 font-display font-semibold text-white hover:bg-white/10">Descubrir más</a>
            </div>
        </div>
    </div>
</section>
