<?php
/**
 * Libro de Reclamaciones virtual (estilo checkout v2, layouts/sitio.php).
 * Envia a legal/procesar_reclamo (LegalController); mismos campos que antes.
 */
$er = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$cab = [
    'titulo' => 'Libro de Reclamaciones',
    'sub' => 'Conforme al Código de Protección y Defensa del Consumidor.',
    'etiqueta' => 'Legal',
    'migas' => [['Inicio', ''], ['Libro de Reclamaciones', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
$campo = 'w-full rounded-xl border border-line bg-white px-4 py-3 text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand';
$etq = 'mb-1 block text-sm font-semibold text-deep';
$titulo = 'flex items-center gap-3 font-display text-lg font-bold text-deep';
$num = 'flex h-8 w-8 items-center justify-center rounded-lg bg-brand text-sm text-white';
?>
<section class="bg-surface pb-16 pt-4">
    <div class="mx-auto max-w-3xl px-4">
        <?php if (isset($_SESSION['reclamo_exito'])): ?>
        <div class="rounded-2xl border-t-4 border-emerald-600 bg-white p-8 text-center shadow-sm" role="status">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-2xl text-emerald-700"><i class="fas fa-check" aria-hidden="true"></i></span>
            <h2 class="mt-4 font-display text-2xl font-bold text-deep">¡Reclamo registrado correctamente!</h2>
            <p class="mt-3 text-ink">Su solicitud ha sido registrada bajo el código: <strong class="font-mono"><?= $er($_SESSION['reclamo_exito']['codigo']) ?></strong></p>
            <p class="mt-2 text-sm text-muted">Una copia de este reclamo ha sido enviada a su correo electrónico. Le contactaremos en el plazo legal establecido por Indecopi.</p>
        </div>
        <?php unset($_SESSION['reclamo_exito']); ?>
        <?php else: ?>
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5 sm:p-8">
            <p class="text-ink">Conforme a lo establecido en el Código de Protección y Defensa del Consumidor, esta institución cuenta con un Libro de Reclamaciones Virtual a tu disposición. Llena el siguiente formulario para registrar tu queja o reclamo.</p>

            <?php if (isset($_SESSION['reclamo_error'])): ?>
            <p class="mt-5 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 ring-1 ring-red-200" role="alert"><?= $er($_SESSION['reclamo_error']) ?></p>
            <?php unset($_SESSION['reclamo_error']); ?>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>legal/procesar_reclamo" method="POST" class="mt-6 space-y-8">
                <!-- HONEYPOT ANTI-SPAM -->
                <div class="hidden" aria-hidden="true">
                    <label>Si eres humano, deja este campo en blanco: <input type="text" name="telefono_falso" value="" tabindex="-1" autocomplete="off"></label>
                </div>

                <fieldset>
                    <legend class="<?= $titulo ?>"><span class="<?= $num ?>">1</span> Datos del consumidor</legend>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><label for="r-nombres" class="<?= $etq ?>">Nombres completos *</label><input id="r-nombres" type="text" name="nombres" required autocomplete="given-name" class="<?= $campo ?>"></div>
                        <div><label for="r-apellidos" class="<?= $etq ?>">Apellidos completos *</label><input id="r-apellidos" type="text" name="apellidos" required autocomplete="family-name" class="<?= $campo ?>"></div>
                        <div>
                            <label for="r-tipodoc" class="<?= $etq ?>">Tipo de documento *</label>
                            <select id="r-tipodoc" name="tipo_documento" required class="<?= $campo ?>">
                                <option value="">Selecciona</option>
                                <option value="DNI">DNI</option>
                                <option value="CE">Carnet de Extranjería</option>
                                <option value="Pasaporte">Pasaporte</option>
                            </select>
                        </div>
                        <div><label for="r-numdoc" class="<?= $etq ?>">Número de documento *</label><input id="r-numdoc" type="text" name="numero_documento" required class="<?= $campo ?>"></div>
                        <div class="sm:col-span-2"><label for="r-direccion" class="<?= $etq ?>">Dirección / Domicilio *</label><input id="r-direccion" type="text" name="direccion" required autocomplete="street-address" class="<?= $campo ?>"></div>
                        <div><label for="r-tel" class="<?= $etq ?>">Teléfono / Celular *</label><input id="r-tel" type="tel" name="telefono" required autocomplete="tel" class="<?= $campo ?>"></div>
                        <div><label for="r-email" class="<?= $etq ?>">Correo electrónico *</label><input id="r-email" type="email" name="email" required autocomplete="email" class="<?= $campo ?>"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="<?= $titulo ?>"><span class="<?= $num ?>">2</span> Detalle del bien contratado</legend>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="r-tipobien" class="<?= $etq ?>">Identificación *</label>
                            <select id="r-tipobien" name="tipo_bien" required class="<?= $campo ?>">
                                <option value="">Selecciona</option>
                                <option value="Producto">Producto (Certificado Físico, etc)</option>
                                <option value="Servicio">Servicio (Curso Virtual)</option>
                            </select>
                        </div>
                        <div><label for="r-monto" class="<?= $etq ?>">Monto reclamado (opcional)</label><input id="r-monto" type="number" step="0.01" min="0" name="monto_reclamado" class="<?= $campo ?>"></div>
                        <div class="sm:col-span-2"><label for="r-descbien" class="<?= $etq ?>">Descripción del producto o curso *</label><input id="r-descbien" type="text" name="descripcion_bien" required class="<?= $campo ?>"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="<?= $titulo ?>"><span class="<?= $num ?>">3</span> Detalle del reclamo y pedido</legend>
                    <div class="mt-4 grid grid-cols-1 gap-4">
                        <div>
                            <label for="r-tiporec" class="<?= $etq ?>">Tipo *</label>
                            <select id="r-tiporec" name="tipo_reclamo" required class="<?= $campo ?>">
                                <option value="">Selecciona</option>
                                <option value="Reclamo">Reclamo (Disconformidad con el bien o servicio)</option>
                                <option value="Queja">Queja (Disconformidad ajena al bien o servicio)</option>
                            </select>
                        </div>
                        <div><label for="r-detalle" class="<?= $etq ?>">Detalle exactamente qué ocurrió *</label><textarea id="r-detalle" name="detalle_reclamo" rows="4" required class="<?= $campo ?>"></textarea></div>
                        <div><label for="r-pedido" class="<?= $etq ?>">Especifique lo que solicita (ej. devolución, cambio) *</label><textarea id="r-pedido" name="pedido" rows="3" required class="<?= $campo ?>"></textarea></div>
                    </div>
                </fieldset>

                <p class="text-xs leading-relaxed text-muted">Al enviar este formulario, usted declara que los datos consignados son verdaderos. La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.</p>
                <button type="submit" class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-brand px-8 py-3 font-display font-bold text-white hover:bg-brand-dark sm:w-auto"><i class="fas fa-book" aria-hidden="true"></i> Enviar reclamo</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</section>
