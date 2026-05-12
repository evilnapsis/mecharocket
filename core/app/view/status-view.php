<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Catálogo de Estados</h2>
        <p class="text-muted">Personalice las etapas del flujo de trabajo para sus órdenes de servicio.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=status&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-flag-fill me-2"></i> Nuevo Estado</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$statuses = StatusData::getAll();
		if(count($statuses)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre del Estado</th>
            <th>Color</th>
            <th class="text-center">Vista Previa</th>
			<th style="width:120px;">Acciones</th>
			</thead>
			<?php
			foreach($statuses as $status):
				?>
				<tr>
				<td><span class="fw-bold text-dark"><?php echo $status->name; ?></span></td>
                <td><code class="px-2 py-1 bg-light rounded text-dark border"><?php echo $status->color; ?></code></td>
                <td class="text-center">
                    <span class="badge shadow-sm px-3 py-2 fw-bold" style="background-color: <?php echo $status->color; ?>; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.2)"><?php echo $status->name; ?></span>
                </td>
				<td class="text-center">
    				<a href="index.php?view=status&opt=edit&id=<?php echo $status->id;?>" class="btn btn-warning btn-sm text-white shadow-sm" title="Editar"><i class="bi bi-pencil-square"></i></a>
    				<a id="delstatus-<?php echo $status->id;?>" class="btn btn-danger btn-sm shadow-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                    <script type="text/javascript">
                        $("#delstatus-<?php echo $status->id?>").click(function(){
                    Swal.fire({
                      title: "¿Eliminar estado?",
                      text: "Las órdenes que usen este estado podrían verse afectadas.",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#d33',
                      cancelButtonColor: '#6c757d',
                      confirmButtonText: "Sí, Eliminar",
                      cancelButtonText: "Cancelar"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location = "./?action=status&opt=del&id=<?=$status->id;?>";
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
        <i class="bi bi-info-circle-fill me-2"></i> No hay estados personalizados registrados. Use el botón superior para crear uno.
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
    <h2 class="fw-bold text-dark mb-1">Nuevo Estado</h2>
    <p class="text-muted">Cree un nuevo paso para el seguimiento de sus reparaciones y servicios.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" action="index.php?action=status&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-8">
      <label for="name" class="form-label fw-bold font-start">Nombre del Estado*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Pendiente, En Diagnóstico, Completado">
    </div>
    <div class="col-md-4">
      <label for="color" class="form-label fw-bold font-start">Color de Identificación*</label>
      <input type="color" name="color" required class="form-control form-control-color w-100" id="color" value="#3b71ca">
      <small class="text-muted">Este color se usará en los listados generales.</small>
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4 pt-3 border-top">
    <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Guardar Nuevo Estado</button>
    <a href="./?view=status&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $status = StatusData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Estado</h2>
    <p class="text-muted">Actualice el nombre o color visual del estado de servicio.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" action="index.php?action=status&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-8">
          <label for="name" class="form-label fw-bold font-start">Nombre del Estado*</label>
          <input type="text" name="name" value="<?php echo $status->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-4">
          <label for="color" class="form-label fw-bold font-start">Color de Identificación*</label>
          <input type="color" name="color" value="<?php echo $status->color;?>" required class="form-control form-control-color w-100" id="color">
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4 pt-3 border-top">
        <input type="hidden" name="id" value="<?php echo $status->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Actualizar Estado</button>
        <a href="./?view=status&opt=all" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
