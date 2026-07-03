<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Ventas / Comprobantes Pendientes</h1>
        </div>
    </div>
    
    <div class="container-fluid page__container">
        <p class="text-muted">Aquí aparecen los comprobantes de pago subidos por los alumnos desde la página de compra. Revisa los pagos y luego presiona "Registrar Alumno".</p>
        
        <div class="row">
            <?php if (empty($vouchers)): ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="material-icons text-muted" style="font-size: 4rem;">inbox</i>
                    </div>
                    <h4 class="text-muted">No hay comprobantes pendientes</h4>
                    <p>Todos los comprobantes han sido procesados.</p>
                </div>
            <?php else: ?>
                <?php foreach ($vouchers as $voucher): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <!-- Image container with fixed height and object-fit -->
                            <div style="height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php if (preg_match('/\.pdf$/i', $voucher['filename'])): ?>
                                    <div class="text-center p-3">
                                        <i class="material-icons text-danger" style="font-size: 3rem;">picture_as_pdf</i>
                                        <p class="mt-2 mb-0">Documento PDF</p>
                                        <a href="<?= $voucher['url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Abrir PDF</a>
                                    </div>
                                <?php else: ?>
                                    <a href="<?= $voucher['url'] ?>" target="_blank">
                                        <img src="<?= $voucher['url'] ?>" alt="Comprobante" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title text-primary" style="font-weight: 600; font-size: 1.1rem; line-height: 1.4; margin-bottom: 5px;">
                                    <?= htmlspecialchars($voucher['course']) ?>
                                </h5>
                                <p class="card-text text-muted" style="font-size: 0.85rem; margin-bottom: 15px;">
                                    <i class="material-icons" style="font-size: 1rem; vertical-align: middle;">schedule</i> 
                                    Subido el: <?= $voucher['date'] ?>
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <a href="<?= BASE_URL ?>admin/ingenieria_registro?curso=<?= urlencode($voucher['course']) ?>" class="btn btn-success btn-sm d-flex align-items-center" style="font-weight: 600;">
                                        <i class="material-icons mr-1" style="font-size: 1.1rem;">person_add</i> Registrar
                                    </a>
                                    
                                    <a href="<?= BASE_URL ?>admin/ventas_delete?file=<?= urlencode($voucher['filename']) ?>" class="btn btn-outline-danger btn-sm d-flex align-items-center" onclick="return confirm('¿Estás seguro de archivar/eliminar este comprobante? Haz esto solo si ya registraste al alumno.');">
                                        <i class="material-icons mr-1" style="font-size: 1.1rem;">delete_outline</i> Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
