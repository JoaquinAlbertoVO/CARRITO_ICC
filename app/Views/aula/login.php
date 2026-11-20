<?php $h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Ingresar | Aula virtual ICC</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/logo_icc.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/aula.css?v=1">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-surface font-sans text-ink antialiased">
<div class="grid min-h-screen lg:grid-cols-2">
    <!-- Marca -->
    <section class="relative hidden overflow-hidden bg-deep bg-cover bg-center lg:block" style="background-image:url('<?= BASE_URL ?>assets/images/fondo_icc_hero.jpg')">
        <div class="absolute inset-0 bg-gradient-to-br from-deep/95 via-deep/80 to-brand-dark/70"></div>
        <div class="relative flex h-full flex-col justify-between p-12 text-white">
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" class="h-12 w-auto self-start">
            <div>
                <span class="rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Aula virtual</span>
                <h1 class="mt-5 max-w-md font-display text-4xl font-extrabold leading-tight">Tus clases, tu material y tus certificados en un solo lugar.</h1>
                <ul class="mt-8 space-y-3 text-sky-50">
                    <li class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10"><i class="fas fa-play text-accent text-xs"></i></span> Clases grabadas a tu ritmo</li>
                    <li class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10"><i class="fas fa-folder-open text-accent text-xs"></i></span> Material para descargar</li>
                    <li class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10"><i class="fas fa-award text-accent text-xs"></i></span> Certificados con QR verificable</li>
                </ul>
            </div>
            <p class="text-xs text-sky-200">© <?= date('Y') ?> Instituto de Capacitación Continua S.R.L.</p>
        </div>
    </section>

    <!-- Formulario -->
    <section class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-sm">
            <div class="mb-8 rounded-2xl bg-deep p-4 lg:hidden"><img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC" class="mx-auto h-10 w-auto"></div>
            <h2 class="font-display text-3xl font-extrabold text-deep">Ingresa a tu aula</h2>
            <p class="mt-2 text-muted">Usa el usuario y la contraseña que te enviamos por correo.</p>

            <?php if (!empty($error)): ?>
                <p role="alert" class="mt-6 flex items-start gap-2 rounded-xl bg-red-50 p-3 text-sm text-red-700 ring-1 ring-red-200"><i class="fas fa-exclamation-circle mt-0.5"></i><?= $h($error) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>aula/login" class="mt-6 space-y-4" x-data="{ ver: false, enviando: false }" @submit="enviando = true">
                <label class="block text-sm font-semibold">Usuario o correo
                    <span class="relative mt-1 block">
                        <i class="fas fa-user pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-muted" aria-hidden="true"></i>
                        <input name="usuario" value="<?= $h($usuario ?? '') ?>" autocomplete="username" required autofocus class="w-full rounded-xl border border-line bg-white py-3 pl-10 pr-3 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                    </span>
                </label>
                <label class="block text-sm font-semibold">Contraseña
                    <span class="relative mt-1 block">
                        <i class="fas fa-lock pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-muted" aria-hidden="true"></i>
                        <input name="clave" :type="ver ? 'text' : 'password'" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-line bg-white py-3 pl-10 pr-12 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                        <button type="button" @click="ver = !ver" :aria-label="ver ? 'Ocultar contraseña' : 'Mostrar contraseña'" class="absolute right-2 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-lg text-muted hover:bg-surface"><i class="fas" :class="ver ? 'fa-eye-slash' : 'fa-eye'"></i></button>
                    </span>
                </label>
                <button type="submit" :disabled="enviando" class="flex min-h-[52px] w-full items-center justify-center gap-2 rounded-xl bg-brand font-display text-base font-bold text-white shadow-lg shadow-brand/30 hover:bg-brand-dark disabled:opacity-70">
                    <span x-text="enviando ? 'Ingresando…' : 'Ingresar'">Ingresar</span> <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="mt-8 rounded-xl bg-white p-4 text-sm ring-1 ring-line">
                <p class="font-semibold text-deep">¿Olvidaste tu contraseña?</p>
                <p class="mt-1 text-muted">Escríbenos y te la enviamos.</p>
                <a href="https://wa.me/51941208020?text=<?= rawurlencode('Hola ICC, necesito recuperar mi acceso al aula virtual.') ?>" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-2 font-bold text-brand hover:underline"><i class="fab fa-whatsapp"></i> WhatsApp +51 941 208 020</a>
            </div>
            <p class="mt-6 text-center text-sm text-muted">¿Aún no tienes cursos? <a href="<?= BASE_URL ?>tienda" class="font-bold text-brand hover:underline">Mira los packs</a></p>
        </div>
    </section>
</div>
</body>
</html>
