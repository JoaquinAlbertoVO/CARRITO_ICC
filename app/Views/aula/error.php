<div class="mdk-header-layout__content page" style="background-color: var(--bg-dark); min-height: 100vh;">
    <div class="container mt-5 pt-5 text-center">
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 60px 20px; max-width: 600px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div style="width: 100px; height: 100px; background: rgba(220, 53, 69, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                <i class="material-icons text-danger" style="font-size: 50px;">error_outline</i>
            </div>
            <h3 class="text-white mb-3" style="font-weight: 700;"><?= htmlspecialchars($title ?? 'Error') ?></h3>
            <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 30px;"><?= htmlspecialchars($error ?? 'Ha ocurrido un error inesperado.') ?></p>
            <a href="<?= BASE_URL ?>aula" class="btn btn-primary" style="padding: 12px 30px; font-size: 1.1rem; border-radius: 30px;"><i class="material-icons mr-2">arrow_back</i> Volver a Mi Aula</a>
        </div>
    </div>
</div>
