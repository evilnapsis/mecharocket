<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Categorías de Inventario</h2>
        <p class="text-muted">Organice sus refacciones y materiales en categorías para un mejor control de stock.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=categories&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-tag-fill me-2"></i> Nueva Categoría</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$categories = CategoryData::getAll();
		if(count($categories)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre</th>
      <th>Estado</th>
			<th style="width:100px;">Acciones</th>
			</thead>
			<?php
			foreach($categories as $category):
				?>
				<tr>
				<td><span class="fw-bold"><?php echo $category->name; ?></span></td>
        <td class="text-center">
          <?php if($category->is_active==1): ?>
            <span class="badge bg-success shadow-sm">Activo</span>
          <?php else: ?>
            <span class="badge bg-danger shadow-sm">Inactivo</span>
          <?php endif; ?>
        </td>
				<td class="text-center">
				<a href="index.php?view=categories&opt=edit&id=<?php echo $category->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delcat-<?php echo $category->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delcat-<?php echo $category->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar esta categoría.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=categories&opt=del&id=<?=$category->id;?>";
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
        <i class="bi bi-info-circle me-2"></i> No hay categorías registradas.
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
    <h2 class="fw-bold text-dark mb-1">Nueva Categoría</h2>
    <p class="text-muted">Cree una nueva categoría para clasificar sus productos y servicios.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" action="index.php?action=categories&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-12 mb-3">
      <label for="name" class="form-label fw-bold">Nombre*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Filtros, Aceites, Frenos">
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar Categoría</button>
    <a href="./?view=categories&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $category = CategoryData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Categoría</h2>
    <p class="text-muted">Actualice el nombre o estado de la categoría.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" action="index.php?action=categories&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-12 mb-3">
          <label for="name" class="form-label fw-bold">Nombre*</label>
          <input type="text" name="name" value="<?php echo $category->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-12 mb-3">
          <label for="is_active" class="form-label fw-bold">Estado*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($category->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($category->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $category->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar Categoría</button>
        <a href="./?view=categories&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
