<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Espacios y Bahías</h2>
    <p class="text-muted">Gestione las áreas físicas del taller para la asignación de trabajos y organización de bahías.</p>
</div>

<div class="mb-4">
    <a href="./?view=spaces&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-geo-alt me-2"></i> Nuevo Espacio</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4 text-start">
		<?php
		$spaces = SpaceData::getAll();
		if(count($spaces)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre del Espacio</th>
            <th>Descripción / Ubicación</th>
            <th class="text-center">Estado</th>
			<th style="width:120px;">Acciones</th>
			</thead>
			<?php
			foreach($spaces as $space):
				?>
				<tr>
				<td><span class="fw-bold text-dark"><?php echo $space->name; ?></span></td>
                <td><?php echo $space->description; ?></td>
                <td class="text-center">
                  <?php if($space->is_active==1): ?>
                    <span class="badge bg-success shadow-sm">Activo</span>
                  <?php else: ?>
                    <span class="badge bg-danger shadow-sm">Inactivo</span>
                  <?php endif; ?>
                </td>
				<td class="text-center">
    				<a href="index.php?view=spaces&opt=edit&id=<?php echo $space->id;?>" class="btn btn-warning btn-sm text-white shadow-sm" title="Editar"><i class="bi bi-pencil-square"></i></a>
    				<a id="delspace-<?php echo $space->id;?>" class="btn btn-danger btn-sm shadow-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                    <script type="text/javascript">
                        $("#delspace-<?php echo $space->id?>").click(function(){
                    Swal.fire({
                      title: "¿Eliminar espacio?",
                      text: "Desea quitar esta bahía del sistema.",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#d33',
                      cancelButtonColor: '#6c757d',
                      confirmButtonText: "Sí, Eliminar",
                      cancelButtonText: "Cancelar"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location = "./?action=spaces&opt=del&id=<?=$space->id;?>";
                      }
                    });
                        });
                    </script>
				</td>
				</tr>
				<?php
			endforeach; ?>
</table>
<?php		}else{
			?>
      <div class="alert alert-info border-0 shadow-sm mb-0">
        <i class="bi bi-info-circle-fill me-2"></i> No hay espacios registrados actualmente.
      </div>
			<?php
		}
		?>
	</div>
</div>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="container-fluid text-start">
<div class="mb-4 text-start">
    <h2 class="fw-bold text-dark mb-1">Nuevo Espacio</h2>
    <p class="text-muted">Cree un nuevo lugar de trabajo físico para el control de capacidad del taller.</p>
</div>

<div class="row text-start text-start">
	<div class="col-md-12 text-start">
  <div class="card mb-4 border-0 shadow-sm text-start">
    <div class="card-body p-4 text-start">
<form class="form-horizontal text-start" method="post" action="index.php?action=spaces&opt=add" role="form">
  <div class="row g-3 text-start">
    <div class="col-md-12 mb-3 text-start">
      <label for="name" class="form-label fw-bold">Nombre del Espacio*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Bahía 1, Elevador Hidráulico A, Área de Detallado">
    </div>
    <div class="col-md-12 mb-3 text-start">
      <label for="description" class="form-label fw-bold">Descripción / Notas Adicionales</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Información sobre la ubicación o herramientas disponibles en este espacio"></textarea>
    </div>
  </div>
  <p class="text-muted small text-start">* Campos obligatorios</p>
  <div class="mt-4 text-start">
    <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Guardar Nuevo Espacio</button>
    <a href="./?view=spaces&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $space = SpaceData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Espacio</h2>
    <p class="text-muted text-start">Actualice la información del área de trabajo seleccionada.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm text-start">
    <div class="card-body p-4 text-start">
		<form class="form-horizontal text-start" method="post" action="index.php?action=spaces&opt=upd" role="form">
      <div class="row g-3 text-start">
        <div class="col-md-12 text-start">
          <label for="name" class="form-label fw-bold">Nombre del Espacio*</label>
          <input type="text" name="name" value="<?php echo $space->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-12 text-start">
          <label for="description" class="form-label fw-bold">Descripción</label>
          <textarea name="description" class="form-control" rows="3"><?php echo $space->description; ?></textarea>
        </div>
        <div class="col-md-12 text-start">
          <label for="is_active" class="form-label fw-bold">Estado del Espacio*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($space->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($space->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4 pt-3 border-top text-start">
        <input type="hidden" name="id" value="<?php echo $space->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Actualizar Información</button>
        <a href="./?view=spaces&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
