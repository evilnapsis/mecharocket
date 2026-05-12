<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Áreas de Trabajo</h2>
    <p class="text-muted">Gestione las especialidades del taller para la clasificación de servicios.</p>
</div>

<div class="mb-4">
    <a href="./?view=jobcategories&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-grid-3x3-gap me-2"></i> Nueva Área</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4 text-start">
		<?php
		$jobcategories = JobCategoryData::getAll();
		if(count($jobcategories)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre del Área</th>
            <th class="text-center">Estado</th>
			<th style="width:120px;">Acciones</th>
			</thead>
			<?php
			foreach($jobcategories as $jc):
				?>
				<tr>
				<td><span class="fw-bold text-dark"><?php echo $jc->name; ?></span></td>
                <td class="text-center">
                  <?php if($jc->is_active==1): ?>
                    <span class="badge bg-success shadow-sm">Activo</span>
                  <?php else: ?>
                    <span class="badge bg-danger shadow-sm">Inactivo</span>
                  <?php endif; ?>
                </td>
				<td class="text-center">
    				<a href="index.php?view=jobcategories&opt=edit&id=<?php echo $jc->id;?>" class="btn btn-warning btn-sm text-white shadow-sm" title="Editar"><i class="bi bi-pencil-square"></i></a>
    				<a id="deljc-<?php echo $jc->id;?>" class="btn btn-danger btn-sm shadow-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                    <script type="text/javascript">
                        $("#deljc-<?php echo $jc->id?>").click(function(){
                    Swal.fire({
                      title: "¿Eliminar área?",
                      text: "Esto podría afectar a los servicios que usen esta categoría.",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#d33',
                      cancelButtonColor: '#6c757d',
                      confirmButtonText: "Sí, Eliminar",
                      cancelButtonText: "Cancelar"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location = "./?action=jobcategories&opt=del&id=<?=$jc->id;?>";
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
        <i class="bi bi-info-circle-fill me-2"></i> No hay áreas de trabajo registradas. Use el botón superior para crear la primera.
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
    <h2 class="fw-bold text-dark mb-1">Nueva Área de Trabajo</h2>
    <p class="text-muted">Defina una nueva categoría para agrupar servicios.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm text-start">
    <div class="card-body p-4 text-start">
<form class="form-horizontal text-start" method="post" action="index.php?action=jobcategories&opt=add" role="form">
  <div class="row g-3 text-start">
    <div class="col-md-12 text-start">
      <label for="name" class="form-label fw-bold">Nombre del Área*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Motor, Transmisión, Sistema Eléctrico">
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4 pt-3 border-top text-start text-start">
    <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Guardar Área</button>
    <a href="./?view=jobcategories&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start text-start">
<?php $jc = JobCategoryData::getById($_GET["id"]);?>
<div class="mb-4 text-start">
    <h2 class="fw-bold text-dark mb-1 font-start">Editar Área de Trabajo</h2>
    <p class="text-muted text-start">Actualice la información de la categoría seleccionada.</p>
</div>

<div class="row text-start text-start">
	<div class="col-md-12 text-start text-start">
  <div class="card mb-4 border-0 shadow-sm text-start text-start">
    <div class="card-body p-4 text-start text-start">
		<form class="form-horizontal text-start text-start" method="post" action="index.php?action=jobcategories&opt=upd" role="form">
      <div class="row g-3 text-start">
        <div class="col-md-12 text-start">
          <label for="name" class="form-label fw-bold">Nombre del Área*</label>
          <input type="text" name="name" value="<?php echo $jc->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-12 text-start">
          <label for="is_active" class="form-label fw-bold test-start text-start">Estado del Área*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($jc->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($jc->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
      </div>
      <p class="text-muted small text-start">* Campos obligatorios</p>
      <div class="mt-4 pt-3 border-top text-start text-start">
        <input type="hidden" name="id" value="<?php echo $jc->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Actualizar Área</button>
        <a href="./?view=jobcategories&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
