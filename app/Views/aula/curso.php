<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$datosOk = !empty($alumno['datos_cert_ok']);
$modulos = [];
foreach ($clases as $i => $c) {
    $modulos[$c['modulo']][] = $i;
}
$iconoMat = ['pdf' => 'fa-file-pdf text-red-500', 'pptx' => 'fa-file-powerpoint text-orange-500', 'ppt' => 'fa-file-powerpoint text-orange-500',
    'xlsx' => 'fa-file-excel text-emerald-600', 'docx' => 'fa-file-word text-brand', 'gdoc' => 'fa-file-alt text-brand', 'carpeta' => 'fa-folder text-amber-500'];
$cfg = ['base' => BASE_URL, 'curso' => (int) $curso['id_curso'], 'clases' => $clases, 'actual' => $actual, 'token' => $token];
$horas = (int) $curso['horas_academicas'];
?>
<div x-data="aulaCurso()" x-init="init()" @keydown.window.alt.arrow-right="ir(i + 1)" @keydown.window.alt.arrow-left="ir(i - 1)">
    <!-- Encabezado -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <a href="<?= BASE_URL ?>aula" class="text-sm font-semibold text-brand hover:underline"><i class="fas fa-arrow-left mr-1 text-xs"></i> Mis cursos</a>
            <h1 class="mt-2 font-display text-2xl font-extrabold leading-tight text-deep sm:text-3xl"><?= $h($curso['nombre_curso']) ?></h1>
            <p class="mt-1 text-sm text-muted"><?= $asincrono ? 'Curso grabado' : 'Curso en vivo' ?> · <?= count($clases) ?> clases<?= $horas > 0 ? ' · ' . $horas . ' horas académicas' : '' ?></p>
        </div>
        <div class="w-full shrink-0 sm:w-64">
            <div class="flex justify-between text-xs font-semibold"><span class="text-muted"><span x-text="vistos"></span> de <?= count($clases) ?> vistas</span><span class="text-brand" x-text="porcentaje + '%'"></span></div>
            <div class="mt-1.5 h-2.5 overflow-hidden rounded-full bg-mist" role="progressbar" :aria-valuenow="porcentaje" aria-valuemin="0" aria-valuemax="100" aria-label="Avance del curso">
                <div class="h-full rounded-full bg-brand transition-all duration-500" :class="porcentaje >= 100 && '!bg-emerald-500'" :style="'width:' + porcentaje + '%'"></div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 <?= $clases ? 'lg:grid-cols-3' : '' ?>">
        <!-- Reproductor -->
        <div class="<?= $clases ? 'lg:col-span-2' : '' ?>">
            <?php if (!$clases): ?>
            <div class="rounded-2xl bg-white p-10 text-center ring-1 ring-line">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-mist text-xl text-brand"><i class="fas fa-video"></i></span>
                <p class="mt-4 font-display text-xl font-bold text-deep">Las grabaciones de este curso aún no están en el aula</p>
                <p class="mt-2 text-muted">Si ya debería tenerlas, escríbenos por WhatsApp y las revisamos.</p>
            </div>
            <?php else: ?>
            <div class="overflow-hidden rounded-2xl bg-black shadow-xl ring-1 ring-deep/10">
                <div class="relative aspect-video">
                    <template x-if="clase.yt">
                        <iframe :src="'https://www.youtube-nocookie.com/embed/' + clase.yt + '?rel=0&modestbranding=1'" :title="clase.titulo" class="absolute inset-0 h-full w-full" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </template>
                    <template x-if="!clase.yt">
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-deep p-6 text-center text-white">
                            <i class="fas fa-external-link-alt text-3xl text-accent"></i>
                            <p>Esta clase se abre en otra pestaña.</p>
                            <a :href="clase.url" target="_blank" rel="noopener" class="rounded-xl bg-accent px-5 py-2.5 font-bold text-deep">Abrir clase</a>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-line sm:flex-row sm:items-center">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold uppercase tracking-wide text-brand">Clase <span x-text="clase.n"></span> de <?= count($clases) ?></p>
                    <h2 class="mt-1 font-display text-lg font-bold text-deep" x-text="clase.titulo"></h2>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" @click="ir(i - 1)" :disabled="i === 0" class="flex h-11 w-11 items-center justify-center rounded-xl border border-line text-ink hover:bg-surface disabled:opacity-40" aria-label="Clase anterior"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" @click="alternarVisto()" :disabled="guardando" class="inline-flex min-h-[44px] items-center gap-2 rounded-xl px-4 text-sm font-bold transition" :class="clase.visto ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-brand text-white hover:bg-brand-dark'">
                        <i class="fas" :class="clase.visto ? 'fa-check-circle' : 'fa-check'"></i>
                        <span x-text="clase.visto ? 'Vista' : 'Marcar como vista'"></span>
                    </button>
                    <button type="button" @click="siguiente()" :disabled="i === clases.length - 1" class="inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-deep px-4 text-sm font-bold text-white hover:bg-ink disabled:opacity-40">Siguiente <i class="fas fa-chevron-right text-xs"></i></button>
                </div>
            </div>
            <p x-show="clase.descripcion" x-text="clase.descripcion" class="mt-4 whitespace-pre-line rounded-2xl bg-white p-5 text-sm leading-relaxed text-ink ring-1 ring-line"></p>
            <?php endif; ?>

            <!-- Materiales y certificado -->
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-line" aria-labelledby="t-mat">
                    <h2 id="t-mat" class="flex items-center gap-2 font-display font-bold text-deep"><i class="fas fa-folder-open text-brand"></i> Material del curso</h2>
                    <?php if ($materiales): ?>
                    <ul class="mt-3 divide-y divide-mist">
                        <?php foreach ($materiales as $m): ?>
                        <li>
                            <a href="<?= $h($m['url']) ?>" target="_blank" rel="noopener" class="flex items-center gap-3 py-2.5 text-sm hover:text-brand">
                                <i class="fas <?= $iconoMat[$m['tipo']] ?? 'fa-link text-muted' ?> w-5 text-center text-lg"></i>
                                <span class="flex-1"><?= $h($m['titulo']) ?></span>
                                <?php if ($m['tamano_mb'] !== null && (float) $m['tamano_mb'] > 0): ?><span class="text-xs text-muted"><?= $h(rtrim(rtrim(number_format((float) $m['tamano_mb'], 1), '0'), '.')) ?> MB</span><?php endif; ?>
                                <i class="fas fa-external-link-alt text-xs text-muted"></i>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                        <p class="mt-3 text-sm text-muted">Este curso no tiene material para descargar todavía.</p>
                    <?php endif; ?>
                </section>

                <section class="rounded-2xl bg-gradient-to-br from-deep to-brand-dark p-5 text-white shadow-sm" aria-labelledby="t-cert">
                    <h2 id="t-cert" class="flex items-center gap-2 font-display font-bold"><i class="fas fa-award text-accent"></i> Tu certificado</h2>
                    <?php if ($asincrono && $certificado): ?>
                        <?php if ($horas <= 0): ?>
                            <p class="mt-3 text-sm text-sky-100">Estamos terminando de preparar el certificado de este curso. Aparecerá aquí en breve.</p>
                        <?php else: ?>
                            <p class="mt-3 text-sm text-sky-100">Ya está listo. Código <code class="rounded bg-white/10 px-1.5 py-0.5 text-xs text-white"><?= $h($certificado['codigo']) ?></code></p>
                            <a href="<?= BASE_URL . ($datosOk ? 'aula/certificado/' : 'aula/mis_datos?certificado=') . (int) $curso['id_curso'] ?>" class="mt-4 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep hover:brightness-95">
                                <i class="fas fa-download"></i> <?= $datosOk ? 'Descargar PDF' : 'Confirmar datos y descargar' ?>
                            </a>
                        <?php endif; ?>
                    <?php elseif (!empty($certificadoSubido)): ?>
                        <p class="mt-3 text-sm text-sky-100">Tu certificado ya fue emitido.</p>
                        <a href="<?= BASE_URL ?>assets/certificados/<?= implode('/', array_map('rawurlencode', explode('/', (string) $certificadoSubido['archivo_pdf']))) ?>" target="_blank" rel="noopener" class="mt-4 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep"><i class="fas fa-download"></i> Descargar PDF</a>
                    <?php elseif (!empty($certificadoRegistrado)): ?>
                        <p class="mt-3 text-sm text-sky-100">Tu certificado ya fue emitido. Código <code class="rounded bg-white/10 px-1.5 py-0.5 text-xs text-white"><?= $h($certificadoRegistrado['codigo']) ?></code></p>
                        <a href="<?= $certificadoRegistrado['pdf'] ? $h($certificadoRegistrado['pdf']) : BASE_URL . 'verificar/' . rawurlencode($certificadoRegistrado['codigo']) ?>" target="_blank" rel="noopener" class="mt-4 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep"><i class="fas <?= $certificadoRegistrado['pdf'] ? 'fa-download' : 'fa-eye' ?>"></i> <?= $certificadoRegistrado['pdf'] ? 'Descargar PDF' : 'Ver certificado' ?></a>
                    <?php elseif ($estadoCertificado === 1): ?>
                        <p class="mt-3 text-sm text-sky-100">Solicitud enviada. El equipo está emitiendo tu certificado.</p>
                    <?php elseif ($estadoCertificado >= 2): ?>
                        <p class="mt-3 text-sm text-sky-100">Tu certificado figura como emitido. Si no lo ves aquí, escríbenos y te lo enviamos.</p>
                        <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="mt-4 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep"><i class="fab fa-whatsapp"></i> Pedir mi certificado</a>
                    <?php elseif (!$clases): ?>
                        <p class="mt-3 text-sm text-sky-100">Aparecerá aquí cuando el equipo lo emita al terminar el curso.</p>
                    <?php else: ?>
                        <p class="mt-3 text-sm text-sky-100" x-show="porcentaje < 100">Termina todas las clases para solicitar tu certificado.</p>
                        <form method="post" action="<?= BASE_URL ?>aula/solicitar_certificado" x-show="porcentaje >= 100" x-cloak>
                            <input type="hidden" name="_token" value="<?= $h($token) ?>">
                            <input type="hidden" name="id_curso" value="<?= (int) $curso['id_curso'] ?>">
                            <p class="mt-3 text-sm text-sky-100">¡Terminaste el curso!</p>
                            <button class="mt-3 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep">Solicitar certificado</button>
                        </form>
                    <?php endif; ?>
                </section>
            </div>
        </div>

        <!-- Lista de clases -->
        <?php if ($clases): ?>
        <aside class="lg:col-span-1">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-line lg:sticky lg:top-24">
                <div class="border-b border-mist px-5 py-4">
                    <h2 class="font-display font-bold text-deep">Contenido del curso</h2>
                </div>
                <nav class="max-h-[60vh] overflow-y-auto lg:max-h-[calc(100vh-11rem)]" aria-label="Clases">
                    <?php foreach ($modulos as $modulo => $indices): ?>
                        <?php if (count($modulos) > 1): ?><p class="sticky top-0 bg-surface px-5 py-2 text-xs font-bold uppercase tracking-wide text-muted"><?= $h($modulo) ?></p><?php endif; ?>
                        <ol>
                        <?php foreach ($indices as $idx): ?>
                            <li>
                                <button type="button" @click="ir(<?= $idx ?>)" :aria-current="i === <?= $idx ?> ? 'true' : 'false'"
                                        class="flex w-full items-start gap-3 border-l-4 px-4 py-3 text-left text-sm transition"
                                        :class="i === <?= $idx ?> ? 'border-brand bg-mist font-semibold text-deep' : 'border-transparent hover:bg-surface'">
                                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[11px] font-bold"
                                          :class="clases[<?= $idx ?>].visto ? 'bg-emerald-500 text-white' : (i === <?= $idx ?> ? 'bg-brand text-white' : 'bg-mist text-brand')">
                                        <i class="fas fa-check" x-show="clases[<?= $idx ?>].visto"></i><span x-show="!clases[<?= $idx ?>].visto"><?= $idx + 1 ?></span>
                                    </span>
                                    <span class="flex-1"><?= $h($clases[$idx]['titulo']) ?></span>
                                    <?php if ($clases[$idx]['duracion']): ?><span class="text-xs text-muted"><?= $h($clases[$idx]['duracion']) ?></span><?php endif; ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                        </ol>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>
        <?php endif; ?>
    </div>
</div>

<script>
    const AULA = <?= json_encode($cfg, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    function aulaCurso() {
        return {
            clases: AULA.clases, i: AULA.actual, guardando: false,
            get clase() { return this.clases[this.i] || {}; },
            get vistos() { return this.clases.filter(c => c.visto).length; },
            get porcentaje() { return this.clases.length ? Math.round(this.vistos * 100 / this.clases.length) : 0; },
            init() {},
            ir(n) {
                if (n < 0 || n >= this.clases.length) return;
                this.i = n;
                history.replaceState(null, '', '?clase=' + this.clases[n].id);
                if (window.innerWidth < 1024) window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            guardar(visto) {
                const c = this.clase;
                const fd = new FormData();
                fd.append('_token', AULA.token); fd.append('id_curso', AULA.curso); fd.append('id_video', c.id); fd.append('visto', visto ? '1' : '');
                this.guardando = true;
                return fetch(AULA.base + 'aula/progreso', { method: 'POST', body: fd })
                    .then(r => r.json()).then(d => { if (d.ok) c.visto = visto; })
                    .catch(() => {}).finally(() => { this.guardando = false; });
            },
            alternarVisto() { this.guardar(!this.clase.visto); },
            siguiente() {
                const avanzar = () => this.ir(this.i + 1);
                if (!this.clase.visto) this.guardar(true).then(avanzar); else avanzar();
            },
        };
    }
</script>
