<?php
$fondo_body = 'bg-surface';
$meta_description = 'Cursos grabados de electricidad industrial de ICC: compra por curso o por pack, avanza a tu ritmo y descarga tu certificado de cada curso.';
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$f2 = function ($n) { return number_format((float) $n, 2); };
$usd = $pago['moneda'] === 'USD';
$hayManual = in_array('manual', $pago['metodos'], true);
$pagoPayPal = $item['vendible']; // el layout carga el SDK de PayPal solo si se puede comprar
$title = $item['nombre'] . ' | ICC';
$suma = $usd ? $item['suma_usd'] : $item['suma_pen'];
$propio = $usd ? $item['precio_usd'] : $item['precio'];
$barra_movil = $propio > 0; // el layout sube el boton de WhatsApp sobre la barra de compra
$simbolo = $usd ? 'US$ ' : 'S/ ';
$nCert = $item['tipo'] === 'pack' ? count($item['cursos']) : 1;
?>
<section class="bg-gradient-to-br from-deep to-brand-dark text-white">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:py-14">
        <a href="<?= BASE_URL ?>tienda" class="text-sm text-sky-100 hover:text-white"><i class="fas fa-arrow-left mr-1" aria-hidden="true"></i> Todos los cursos y packs</a>
        <span class="mt-4 block w-fit rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep"><?= $h($item['etiqueta']) ?></span>
        <h1 class="mt-3 max-w-3xl font-display text-3xl font-extrabold leading-tight sm:text-4xl"><?= $h($item['nombre']) ?></h1>
        <?php if ($item['publico']): ?><p class="mt-3 max-w-2xl text-sky-50">Ideal para: <?= $h($item['publico']) ?></p><?php endif; ?>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-bold">
            <?php if ($item['tipo'] === 'pack'): ?><span class="rounded-full bg-white px-3 py-1 text-brand-dark"><i class="fas fa-layer-group mr-1"></i><?= count($item['cursos']) ?> cursos</span><?php endif; ?>
            <span class="rounded-full bg-white px-3 py-1 text-brand-dark"><i class="fas fa-play-circle mr-1"></i><?= (int) $item['clases'] ?> clases grabadas</span>
            <?php if ($item['horas']): ?><span class="rounded-full bg-white px-3 py-1 text-brand-dark"><i class="far fa-clock mr-1"></i><?= (int) $item['horas'] ?> horas académicas</span><?php endif; ?>
            <span class="rounded-full bg-white px-3 py-1 text-brand-dark"><i class="fas fa-award mr-1"></i><?= $nCert ?> certificado<?= $nCert > 1 ? 's' : '' ?></span>
        </div>
    </div>
</section>

<?php if ($propio > 0): ?>
<!-- Celular: precio y boton siempre a la vista (el formulario de pago queda al final de la pagina) -->
<div class="fixed inset-x-0 bottom-0 z-30 flex items-center justify-between gap-3 border-t border-line bg-white px-4 py-3 shadow-2xl lg:hidden">
    <p class="leading-tight"><span class="block text-xs text-muted"><?= $item['tipo'] === 'pack' ? count($item['cursos']) . ' cursos · ' . $nCert . ' certificados' : 'Curso grabado + certificado' ?></span><span class="font-display text-xl font-extrabold text-brand"><?= $simbolo . $f2($propio) ?></span></p>
    <a href="#pago" class="inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-accent px-5 font-display font-bold text-deep shadow">Comprar <i class="fas fa-arrow-down text-sm" aria-hidden="true"></i></a>
</div>
<?php endif; ?>
<div class="mx-auto grid max-w-6xl gap-8 px-4 pb-24 pt-10 lg:grid-cols-5 lg:pb-10">
    <!-- Que incluye -->
    <div class="lg:col-span-3">
        <?php if (!$item['vendible']): ?>
            <p class="mb-6 rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900"><i class="fas fa-eye mr-1"></i> <strong>Vista previa del admin:</strong> esto aún no está a la venta (falta precio, horas o publicarlo). Los visitantes ven "no encontrado".</p>
        <?php endif; ?>

        <?php if ($item['descripcion']): ?><p class="mb-8 text-lg leading-relaxed text-ink"><?= nl2br($h($item['descripcion'])) ?></p><?php endif; ?>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-line">
            <h2 class="font-display text-xl font-bold text-deep">Lo que recibes</h2>
            <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                <li class="flex gap-3"><i class="fas fa-bolt mt-1 text-brand" aria-hidden="true"></i><span><strong>Acceso inmediato</strong> al aula virtual al confirmarse el pago.</span></li>
                <li class="flex gap-3"><i class="fas fa-award mt-1 text-brand" aria-hidden="true"></i><span><strong>Certificado de cada curso</strong> listo para descargar desde el primer día, con QR verificable.</span></li>
                <li class="flex gap-3"><i class="fas fa-play-circle mt-1 text-brand" aria-hidden="true"></i><span>Clases grabadas para ver <strong>a tu ritmo</strong>, cuantas veces quieras.</span></li>
                <li class="flex gap-3"><i class="fas fa-folder-open mt-1 text-brand" aria-hidden="true"></i><span>Material de estudio en PDF y presentaciones.</span></li>
            </ul>
        </div>

        <?php if ($item['tipo'] === 'pack'): ?>
        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-line">
            <h2 class="font-display text-xl font-bold text-deep">Cursos incluidos</h2>
            <?php if ($item['incluye']): ?><p class="mt-1 text-sm text-muted">Reúne: <?= $h($item['incluye']) ?></p><?php endif; ?>
            <ol class="mt-4 divide-y divide-mist">
                <?php foreach ($item['cursos'] as $i => $c): ?>
                <li class="flex items-center gap-4 py-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-mist text-sm font-bold text-brand"><?= $i + 1 ?></span>
                    <span class="flex-1 font-semibold text-ink"><?= $h($c['nombre_curso']) ?></span>
                    <span class="text-xs text-muted"><?= (int) $c['total_clases'] ?> clases<?= (int) $c['horas_academicas'] > 0 ? ' · ' . (int) $c['horas_academicas'] . ' h' : '' ?></span>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php elseif (!empty($item['temario'])): ?>
        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-line">
            <h2 class="font-display text-xl font-bold text-deep">Clases del curso</h2>
            <ol class="mt-4 space-y-2 text-sm">
                <?php foreach ($item['temario'] as $i => $t): ?>
                <li class="flex gap-3"><span class="w-6 shrink-0 text-right font-bold text-brand"><?= $i + 1 ?>.</span><span><?= $h($t) ?></span></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif; ?>

        <div class="mt-6 flex items-center gap-4 rounded-2xl bg-mist p-5">
            <img src="<?= BASE_URL ?>assets/images/certificado-modelo-800.webp" alt="Modelo del certificado ICC" class="hidden w-40 rounded-lg shadow sm:block" loading="lazy" width="800" height="566" onerror="this.remove()">
            <p class="text-sm text-ink">Cada certificado lleva tu nombre, el curso, las horas académicas y un <strong>código con QR</strong> que cualquier empresa puede comprobar en <span class="font-semibold">icc.com.pe/verificar</span>.</p>
        </div>
    </div>

    <!-- Pago -->
    <aside class="lg:col-span-2" id="pago">
        <div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-line lg:sticky lg:top-6" x-data="tiendaCheckout()" x-init="init()">
            <template x-if="!exito">
            <div>
                <p class="text-sm font-semibold text-muted">Precio <?= $item['tipo'] === 'pack' ? 'del pack' : 'del curso' ?></p>
                <p class="mt-1 flex items-baseline gap-3">
                    <span class="font-display text-4xl font-extrabold text-brand"><?= $propio > 0 ? $simbolo . $f2($propio) : '—' ?></span>
                    <?php if ($suma && $propio > 0 && $suma > $propio): ?><span class="text-lg text-muted line-through"><?= $simbolo . $f2($suma) ?></span><?php endif; ?>
                </p>
                <?php if ($usd && $hayManual): ?><p class="mt-1 text-xs text-muted">En soles: S/ <?= $f2($item['precio']) ?></p><?php endif; ?>
                <?php if (!$usd): ?><p class="mt-1 text-xs text-muted">Con tarjeta o PayPal se cobra US$ <?= $f2($item['precio_usd']) ?>.</p><?php endif; ?>

                <fieldset class="mt-6 space-y-3" :disabled="!CFG.vendible">
                    <legend class="font-display font-bold text-deep">Tus datos <span class="text-xs font-normal text-muted">(así saldrá tu certificado)</span></legend>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="text-sm font-semibold">Nombres<input x-model="nombre" autocomplete="given-name" class="mt-1 w-full rounded-lg border border-line px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30"></label>
                        <label class="text-sm font-semibold">Apellidos<input x-model="apellido" autocomplete="family-name" class="mt-1 w-full rounded-lg border border-line px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30"></label>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="text-sm font-semibold"><span x-text="CFG.moneda === 'USD' ? 'Documento (opcional)' : 'DNI'"></span><input x-model="dni" inputmode="numeric" class="mt-1 w-full rounded-lg border border-line px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30"></label>
                        <label class="text-sm font-semibold">Celular / WhatsApp<input x-model="celular" type="tel" autocomplete="tel" class="mt-1 w-full rounded-lg border border-line px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30"></label>
                    </div>
                    <label class="block text-sm font-semibold">Correo <span class="font-normal text-muted">(ahí te llegan tus accesos)</span><input x-model="correo" type="email" autocomplete="email" class="mt-1 w-full rounded-lg border border-line px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30"></label>
                </fieldset>

                <?php if ($hayManual): ?>
                <div class="mt-6 flex rounded-xl bg-surface p-1" role="tablist">
                    <button type="button" role="tab" @click="tab = 'manual'" :aria-selected="(tab === 'manual').toString()" :class="tab === 'manual' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-mobile-alt mr-1"></i> Yape / Plin</button>
                    <button type="button" role="tab" @click="setTab('paypal')" :aria-selected="(tab === 'paypal').toString()" :class="tab === 'paypal' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-credit-card mr-1"></i> Tarjeta / PayPal</button>
                </div>
                <div x-show="tab === 'manual'" x-cloak class="mt-5">
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="metodo = 'yape'" :class="metodo === 'yape' ? 'border-brand bg-mist font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Yape</button>
                        <button type="button" @click="metodo = 'plin'" :class="metodo === 'plin' ? 'border-brand bg-mist font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Plin</button>
                    </div>
                    <div class="mt-4 flex flex-col items-center rounded-2xl bg-surface p-4 text-center">
                        <img :src="qr[metodo].img" :alt="'QR de ' + metodo" class="max-h-60 w-auto rounded-xl shadow">
                        <p class="mt-3 text-sm text-muted" x-show="qr[metodo].titular">Paga a nombre de <strong class="text-ink" x-text="qr[metodo].titular"></strong></p>
                        <p class="text-sm">Monto exacto: <strong class="text-brand">S/ <?= $f2($item['precio']) ?></strong></p>
                    </div>
                    <label class="mt-4 flex cursor-pointer flex-col items-center rounded-xl border-2 border-dashed border-line bg-surface px-4 py-5 text-center text-sm font-semibold hover:border-brand focus-within:border-brand">
                        <i class="fas fa-upload text-xl text-brand" aria-hidden="true"></i>
                        <span class="mt-2" x-text="archivo ? '✓ ' + archivo.name : 'Sube la captura de tu pago'"></span>
                        <span class="text-xs font-normal text-muted">JPG, PNG o PDF</span>
                        <input type="file" class="sr-only" accept="image/*,application/pdf" @change="archivo = $event.target.files[0]">
                    </label>
                    <button type="button" @click="enviarVoucher()" :disabled="enviando || !CFG.vendible" class="mt-4 flex min-h-[52px] w-full items-center justify-center gap-2 rounded-xl bg-accent font-display font-bold text-deep shadow hover:brightness-95 disabled:opacity-60">
                        <i class="fas fa-check-circle" aria-hidden="true"></i> <span x-text="enviando ? 'Enviando…' : 'Enviar comprobante'"></span>
                    </button>
                    <p class="mt-2 text-center text-xs text-muted">Activamos tu acceso apenas verificamos el pago (en horario de oficina suele ser en minutos).</p>
                </div>
                <?php endif; ?>

                <div x-show="tab === 'paypal'" x-cloak class="mt-5">
                    <div id="paypal-boton"></div>
                    <p class="mt-2 text-center text-xs text-muted"><i class="fas fa-lock text-emerald-600"></i> Pago seguro. El acceso se activa al instante.</p>
                </div>

                <p x-show="error" x-text="error" x-cloak role="alert" class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700"></p>
                <a href="https://wa.me/<?= $h($whatsapp) ?>?text=<?= rawurlencode('Hola ICC, tengo una consulta sobre ' . $item['nombre']) ?>" target="_blank" rel="noopener" class="mt-5 block text-center text-sm font-semibold text-brand hover:underline"><i class="fab fa-whatsapp"></i> ¿Dudas? Escríbenos</a>
            </div>
            </template>

            <template x-if="exito">
            <div class="text-center" role="status">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-accent text-2xl text-deep"><i class="fas fa-check"></i></span>
                <template x-if="exito === 'paypal'">
                    <div>
                        <h2 class="mt-4 font-display text-2xl font-extrabold text-deep">¡Pago confirmado!</h2>
                        <p class="mt-2 text-ink">Te enviamos tus accesos a <strong x-text="correoFinal"></strong>. Tus certificados ya te esperan en el aula.</p>
                        <a href="<?= BASE_URL ?>aula/login" class="mt-6 inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-brand px-6 font-bold text-white hover:bg-brand-dark">Entrar al aula virtual <i class="fas fa-arrow-right"></i></a>
                        <p class="mt-4 text-xs text-muted">¿No llega el correo? Revisa spam o escríbenos por WhatsApp.</p>
                    </div>
                </template>
                <template x-if="exito === 'manual'">
                    <div>
                        <h2 class="mt-4 font-display text-2xl font-extrabold text-deep">¡Recibimos tu comprobante!</h2>
                        <p class="mt-2 text-ink">Apenas confirmemos el pago te llegarán tus accesos a <strong x-text="correo"></strong>.</p>
                        <a href="https://wa.me/<?= $h($whatsapp) ?>" target="_blank" rel="noopener" class="mt-6 inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-brand px-6 font-bold text-white"><i class="fab fa-whatsapp"></i> Avisar por WhatsApp</a>
                    </div>
                </template>
            </div>
            </template>
        </div>
    </aside>
</div>

<script>
    const CFG = <?= json_encode($js, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    function tiendaCheckout() {
        return {
            tab: CFG.metodos.includes('manual') ? 'manual' : 'paypal',
            metodo: 'yape', archivo: null, enviando: false, error: '', exito: null, correoFinal: '',
            nombre: '', apellido: '', dni: '', celular: '', correo: '',
            qr: {
                yape: { img: CFG.base + 'assets/images/Yape.jpg', titular: 'Mariela Ma.' },
                plin: { img: CFG.base + 'assets/images/plin.jpg', titular: '' },
            },
            init() { if (this.tab === 'paypal') this.$nextTick(() => this.pintarPayPal()); },
            setTab(t) { this.tab = t; if (t === 'paypal') this.$nextTick(() => this.pintarPayPal()); },
            faltan() {
                const f = [];
                if (!this.nombre.trim() || !this.apellido.trim()) f.push('nombres y apellidos');
                if (CFG.moneda !== 'USD' && !/^[A-Za-z0-9-]{6,20}$/.test(this.dni.trim())) f.push('DNI');
                if (this.celular.trim().length < 6) f.push('celular');
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.correo.trim())) f.push('un correo válido');
                return f;
            },
            validar() {
                const f = this.faltan();
                this.error = f.length ? 'Completa ' + f.join(', ') + '.' : '';
                return !f.length;
            },
            datos() {
                return { tipo: CFG.tipo, id: CFG.id, nombre: this.nombre.trim(), apellido: this.apellido.trim(), dni: this.dni.trim(), celular: this.celular.trim(), correo: this.correo.trim() };
            },
            enviarVoucher() {
                if (!this.validar()) return;
                if (!this.archivo) { this.error = 'Sube la captura de tu pago.'; return; }
                const fd = new FormData();
                Object.entries(this.datos()).forEach(([k, v]) => fd.append(k, v));
                fd.append('metodo', this.metodo);
                fd.append('voucher', this.archivo);
                this.enviando = true; this.error = '';
                fetch(CFG.base + 'tienda/voucher', { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => { if (d.success) { this.exito = 'manual'; window.scrollTo({ top: 0, behavior: 'smooth' }); } else { this.error = d.error || 'No se pudo enviar.'; } })
                    .catch(() => { this.error = 'Error de conexión. Intenta de nuevo.'; })
                    .finally(() => { this.enviando = false; });
            },
            pintarPayPal() {
                const el = document.getElementById('paypal-boton');
                if (!el || el.children.length || typeof paypal === 'undefined' || !CFG.vendible) return;
                const self = this;
                paypal.Buttons({
                    onClick(data, actions) { return self.validar() ? actions.resolve() : actions.reject(); },
                    createOrder(data, actions) {
                        return actions.order.create({ purchase_units: [{ amount: { currency_code: 'USD', value: Number(CFG.precioUsd).toFixed(2) }, description: 'ICC: ' + CFG.nombre }] });
                    },
                    onApprove(data, actions) {
                        return actions.order.capture().then(() => {
                            self.enviando = true;
                            return fetch(CFG.base + 'tienda/paypal', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(Object.assign({ orderID: data.orderID }, self.datos())) })
                                .then(r => r.json())
                                .then(d => {
                                    if (d.success) { self.correoFinal = d.correo || self.correo; self.exito = 'paypal'; window.scrollTo({ top: 0, behavior: 'smooth' }); }
                                    else { self.error = d.error || ('Tu pago se recibió. Escríbenos con tu número de orden: ' + data.orderID); }
                                })
                                .catch(() => { self.error = 'Tu pago se recibió pero no pudimos confirmarlo. Escríbenos con tu número de orden: ' + data.orderID; })
                                .finally(() => { self.enviando = false; });
                        });
                    },
                    onError() { self.error = 'Hubo un problema con PayPal. Intenta de nuevo.'; }
                }).render('#paypal-boton');
            },
        };
    }
</script>
