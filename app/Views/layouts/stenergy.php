<?php
/**
 * Diseno de la pagina publica de verificacion de ST Energy (verifica.stenergyedu.com).
 * Es independiente del sitio de ICC: sin su menu ni su pie. Recibe $content, $title y $marca.
 */
$e = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $e($title ?? 'Verificar certificado - ST Energy') ?></title>
    <meta name="description" content="<?= $e($meta_description ?? '') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;600;700&family=League+Spartan:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --st-black: #0a0a0a; --st-yellow: #F5C500; --st-text: #1e293b; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Kumbh Sans', Arial, sans-serif; background: #f3f4f6; color: var(--st-text); }
        .st-header { background: var(--st-black); border-bottom: 3px solid var(--st-yellow); padding: 14px 16px; text-align: center; }
        .st-header img { height: 56px; width: auto; vertical-align: middle; }
        .st-titulo { text-align: center; padding: 34px 16px 6px; }
        .st-titulo h1 { margin: 0; font-family: 'League Spartan', Arial, sans-serif; font-weight: 800; font-size: 1.9rem; color: var(--st-black); }
        .st-titulo h1 span { background: var(--st-yellow); padding: 0 8px; border-radius: 4px; }
        .st-main { padding: 22px 16px 60px; }
        .st-foot { text-align: center; font-size: .82rem; color: #64748b; padding: 0 16px 28px; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
    <header class="st-header">
        <img src="<?= BASE_URL ?>assets/images/stenergy/logo.jpeg" alt="ST Energy">
    </header>
    <div class="st-titulo"><h1>Verificar <span>certificado</span></h1></div>
    <main class="st-main">
        <?= $content ?>
    </main>
    <div class="st-foot">© ST Energy · <a href="mailto:<?= $e($marca['email'] ?? '') ?>"><?= $e($marca['email'] ?? '') ?></a></div>
</body>
</html>
