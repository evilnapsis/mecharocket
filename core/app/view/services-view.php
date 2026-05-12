<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Catálogo de Servicios</h2>
        <p class="text-muted">Defina los servicios y mano de obra ofrecidos por el taller.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=services&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-briefcase-fill me-2"></i> Nuevo Servicio</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$services = ServiceData::getAll();
		if(count($services)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre</th>
      <th>Precio sugerido</th>
      <th>Estado</th>
			<th style="width:100px;">Acciones</th>
			</thead>
			<?php
			foreach($services as $service):
				?>
				<tr>
				<td><span class="fw-bold"><?php echo $service->name; ?></span></td>
        <td><span class="fw-bold text-primary">$<?php echo number_format($service->price, 2); ?></span></td>
        <td class="text-center">
          <?php if($service->is_active==1): ?>
            <span class="badge bg-success shadow-sm">Activo</span>
          <?php else: ?>
            <span class="badge bg-danger shadow-sm">Inactivo</span>
          <?php endif; ?>
        </td>
				<td class="text-center">
				<a href="index.php?view=services&opt=edit&id=<?php echo $service->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delitem-<?php echo $service->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delitem-<?php echo $service->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar este servicio.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=services&opt=del&id=<?=$service->id;?>";
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
      <div class="alert alert-info mb-0">
        <i class="bi bi-info-circle me-2"></i> No hay servicios registrados.
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
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Nuevo Servicio</h2>
    <p class="text-muted">Registre un nuevo tipo de servicio o mano de obra.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" action="index.php?action=services&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-8 mb-3">
      <label for="name" class="form-label fw-bold">Nombre del Servicio*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Cambio de Aceite y Filtro">
    </div>
    <div class="col-md-4 mb-3">
      <label for="price" class="form-label fw-bold text-start">Precio Sugerido*</label>
      <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="number" step="any" name="price" required class="form-control" id="price" value="0">
      </div>
    </div>
    <div class="col-md-12 mb-3">
      <label for="description" class="form-label fw-bold">Descripción / Notas</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Detalles de lo que incluye el servicio"></textarea>
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar Servicio</button>
    <a href="./?view=services&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $service = ServiceData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Servicio</h2>
    <p class="text-muted">Actualice la descripción o precio del servicio.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" action="index.php?action=services&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-8 mb-3">
          <label for="name" class="form-label fw-bold">Nombre*</label>
          <input type="text" name="name" value="<?php echo $service->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-4 mb-3">
          <label for="price" class="form-label fw-bold">Precio Sugerido*</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="any" name="price" value="<?php echo $service->price;?>" required class="form-control" id="price">
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <label for="description" class="form-label fw-bold">Descripción</label>
          <textarea name="description" class="form-control" rows="3"><?php echo $service->description; ?></textarea>
        </div>
        <div class="col-md-12 mb-3">
          <label for="is_active" class="form-label fw-bold">Estado*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($service->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($service->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $service->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar Servicio</button>
        <a href="./?view=services&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
