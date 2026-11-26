<?php
/**
 * Contacto (estilo checkout v2, layouts/sitio.php). El formulario se envia por fetch a
 * home/enviar_contacto, que responde un fragmento HTML con la clase "success" o "error".
 */
$cab = [
    'titulo' => 'Contáctanos',
    'sub' => 'Siempre estamos listos para saber de ti. Escríbenos y te responderemos lo antes posible.',
    'etiqueta' => 'Contacto',
    'migas' => [['Inicio', ''], ['Contáctanos', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
$campo = 'w-full rounded-xl border border-line bg-white px-4 py-3 text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand';
?>
<section class="bg-surface pb-16 pt-4">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 lg:grid-cols-3">
        <!-- Canales -->
        <div class="space-y-4">
            <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="reveal flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#25D366] text-2xl text-white"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                <span><span class="block font-display text-lg font-bold text-deep">WhatsApp</span><span class="text-sm text-muted">La forma más rápida de escribirnos</span></span>
            </a>
            <a href="tel:+51941208020" class="reveal flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand text-xl text-white"><i class="fas fa-phone-alt" aria-hidden="true"></i></span>
                <span><span class="block font-display text-lg font-bold text-deep">+51 941 208 020</span><span class="text-sm text-muted">Llámanos en cualquier momento</span></span>
            </a>
            <a href="mailto:informes@icc.com.pe" class="reveal flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand text-xl text-white"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                <span><span class="block font-display text-lg font-bold text-deep">informes@icc.com.pe</span><span class="text-sm text-muted">Envíanos un correo electrónico</span></span>
            </a>
        </div>

        <!-- Formulario -->
        <div class="reveal rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5 sm:p-8 lg:col-span-2" x-data="formContacto()">
            <h2 class="font-display text-2xl font-bold text-brand-dark">Envíanos un mensaje</h2>
            <p class="mt-1 text-sm text-muted">Los campos con * son obligatorios.</p>
            <form action="<?= BASE_URL ?>home/enviar_contacto" method="POST" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2" @submit.prevent="enviar($el)">
                <!-- Anti-spam: si un bot llena este campo, el mensaje se descarta -->
                <div class="hidden" aria-hidden="true"><input type="text" name="telefono_falso" tabindex="-1" autocomplete="off"></div>
                <div>
                    <label for="c-nombre" class="mb-1 block text-sm font-semibold text-deep">Nombre *</label>
                    <input id="c-nombre" type="text" name="name" required autocomplete="name" class="<?= $campo ?>">
                </div>
                <div>
                    <label for="c-email" class="mb-1 block text-sm font-semibold text-deep">Correo electrónico *</label>
                    <input id="c-email" type="email" name="email" required autocomplete="email" class="<?= $campo ?>">
                </div>
                <div>
                    <label for="c-tel" class="mb-1 block text-sm font-semibold text-deep">Teléfono</label>
                    <input id="c-tel" type="tel" name="phone" autocomplete="tel" class="<?= $campo ?>">
                </div>
                <div>
                    <label for="c-asunto" class="mb-1 block text-sm font-semibold text-deep">Asunto</label>
                    <input id="c-asunto" type="text" name="subject" class="<?= $campo ?>">
                </div>
                <div class="sm:col-span-2">
                    <label for="c-mensaje" class="mb-1 block text-sm font-semibold text-deep">Mensaje *</label>
                    <textarea id="c-mensaje" name="message" rows="5" required class="<?= $campo ?>"></textarea>
                </div>
                <div class="sm:col-span-2">
                    <p x-show="mensaje" x-cloak x-text="mensaje" role="status" aria-live="polite"
                       :class="ok ? 'bg-emerald-50 text-emerald-800 ring-emerald-200' : 'bg-red-50 text-red-800 ring-red-200'" class="mb-4 rounded-xl px-4 py-3 text-sm font-semibold ring-1"></p>
                    <button type="submit" :disabled="enviando" class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-7 py-3 font-display font-bold text-deep shadow-md hover:brightness-95 disabled:opacity-60 sm:w-auto">
                        <span x-text="enviando ? 'Enviando…' : 'Enviar mensaje'">Enviar mensaje</span> <i class="fas fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
function formContacto() {
    return {
        enviando: false, mensaje: '', ok: false,
        enviar: function (form) {
            var self = this;
            this.enviando = true; this.mensaje = '';
            fetch(form.action, { method: 'POST', body: new FormData(form) })
                .then(function (r) { return r.text(); })
                .then(function (html) {
                    var div = document.createElement('div'); div.innerHTML = html;
                    self.ok = !!div.querySelector('.success');
                    self.mensaje = div.textContent.trim() || 'No pudimos enviar tu mensaje. Escríbenos por WhatsApp.';
                    if (self.ok) form.reset();
                })
                .catch(function () { self.ok = false; self.mensaje = 'No pudimos enviar tu mensaje. Revisa tu conexión o escríbenos por WhatsApp.'; })
                .then(function () { self.enviando = false; });
        }
    };
}
</script>
