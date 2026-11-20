<div class="mx-auto max-w-lg rounded-3xl bg-white p-8 text-center shadow-sm ring-1 ring-line">
    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mist text-2xl text-brand"><i class="fas fa-lock"></i></span>
    <p class="mt-4 font-display text-xl font-bold text-deep"><?= htmlspecialchars($mensaje ?? 'No se pudo abrir esta página.', ENT_QUOTES, 'UTF-8') ?></p>
    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
        <a href="<?= BASE_URL ?>aula" class="inline-flex min-h-[44px] items-center justify-center rounded-xl bg-brand px-5 font-bold text-white hover:bg-brand-dark">Volver a mis cursos</a>
        <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl border border-line px-5 font-bold hover:bg-surface"><i class="fab fa-whatsapp"></i> Soporte</a>
    </div>
</div>
