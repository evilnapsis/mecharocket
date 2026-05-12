<section class="container-fluid text-start">
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Configuración del Taller</h2>
    <p class="text-muted">Configure la información general de su taller, logotipos y datos de contacto para reportes y órdenes de servicio.</p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="post" action="./?action=settings&opt=upd" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nombre del Taller</label>
                                <input type="text" name="workshop_name" class="form-control" value="<?php echo ConfigurationData::getByShort('workshop_name')->val; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Persona Responsable</label>
                                <input type="text" name="workshop_manager" class="form-control" value="<?php echo ConfigurationData::getByShort('workshop_manager')->val; ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Dirección</label>
                                <input type="text" name="workshop_address" class="form-control" value="<?php echo ConfigurationData::getByShort('workshop_address')->val; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Teléfono</label>
                                <input type="text" name="workshop_phone" class="form-control" value="<?php echo ConfigurationData::getByShort('workshop_phone')->val; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border-start text-center">
                        <label class="form-label fw-bold d-block mb-3">Logo del Taller</label>
                        <?php 
                        $logo = ConfigurationData::getByShort('workshop_logo')->val;
                        if($logo != ""): ?>
                            <img src="storage/branding/<?php echo $logo; ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 150px;">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" style="height: 150px; border: 2px dashed #dee2e6;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="logo" class="form-control form-control-sm">
                        <small class="text-muted mt-2 d-block">Recomendado: 300x120px (PNG/JPG)</small>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-start">
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-2"></i> Guardar Cambios</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>