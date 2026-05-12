<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Vehículos</h2>
        <p class="text-muted">Gestione el inventario de vehículos registrados en el taller.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=vehicles&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-plus-lg me-2"></i> Nuevo Vehículo</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$vehicles = VehicleData::getAll();
		if(count($vehicles)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Placa</th>
			<th>Marca / Modelo</th>
      <th>Dueño</th>
      <th>Año / Color</th>
			<th style="width:100px;">Acciones</th>
			</thead>
			<?php
			foreach($vehicles as $vehicle):
        $contact = $vehicle->getContact();
				?>
				<tr>
				<td><span class="badge bg-dark"><?php echo $vehicle->plate; ?></span></td>
				<td><span class="fw-bold"><?php echo $vehicle->brand." ".$vehicle->model; ?></span></td>
        <td><?php echo $contact->name." ".$contact->lastname; ?></td>
        <td><?php echo $vehicle->year." / ".$vehicle->color; ?></td>
				<td class="text-center">
				<a href="index.php?view=vehicles&opt=edit&id=<?php echo $vehicle->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delitem-<?php echo $vehicle->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delitem-<?php echo $vehicle->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar este vehículo.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=vehicles&opt=del&id=<?=$vehicle->id;?>";
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
        <i class="bi bi-info-circle me-2"></i> No hay vehículos registrados.
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
    <h2 class="fw-bold text-dark mb-1">Nuevo Vehículo</h2>
    <p class="text-muted">Complete los datos técnicos para registrar una nueva unidad.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=vehicles&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-4 mb-3">
      <label for="plate" class="form-label fw-bold">Placa*</label>
      <input type="text" name="plate" required class="form-control text-uppercase" id="plate" placeholder="ABC-123">
    </div>
    <div class="col-md-4 mb-3">
      <label for="vin" class="form-label fw-bold">VIN / No. Serie</label>
      <input type="text" name="vin" class="form-control" id="vin" placeholder="VIN">
    </div>
    <div class="col-md-4 mb-3">
      <label for="contact_id" class="form-label fw-bold d-flex justify-content-between align-items-center">
        Dueño / Cliente* 
        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" data-coreui-toggle="modal" data-coreui-target="#modalAddContact"><i class="bi bi-plus-circle me-1"></i>Nuevo</button>
      </label>
      <select name="contact_id" id="contact_id" class="form-select select2" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ContactData::getAllClients() as $c): ?>
          <option value="<?php echo $c->id; ?>"><?php echo $c->name." ".$c->lastname; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="brand" class="form-label fw-bold">Marca*</label>
      <input type="text" name="brand" required class="form-control" id="brand" placeholder="Ej. Nissan">
    </div>
    <div class="col-md-4 mb-3">
      <label for="model" class="form-label fw-bold">Modelo*</label>
      <input type="text" name="model" required class="form-control" id="model" placeholder="Ej. Sentra">
    </div>
    <div class="col-md-2 mb-3">
      <label for="year" class="form-label fw-bold text-start">Año</label>
      <input type="number" name="year" class="form-control" id="year" placeholder="2024">
    </div>
    <div class="col-md-2 mb-3">
      <label for="color" class="form-label fw-bold text-start">Color</label>
      <input type="text" name="color" class="form-control" id="color" placeholder="Color">
    </div>
    <div class="col-md-12 mb-3">
      <label for="description" class="form-label fw-bold">Notas del Vehículo</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Detalles específicos del vehículo"></textarea>
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar Vehículo</button>
    <a href="./?view=vehicles&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $vehicle = VehicleData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Vehículo</h2>
    <p class="text-muted">Actualice la información técnica de la unidad.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" action="index.php?action=vehicles&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-4 mb-3">
          <label for="plate" class="form-label fw-bold">Placa*</label>
          <input type="text" name="plate" value="<?php echo $vehicle->plate;?>" required class="form-control text-uppercase" id="plate">
        </div>
        <div class="col-md-4 mb-3">
          <label for="vin" class="form-label fw-bold">VIN</label>
          <input type="text" name="vin" value="<?php echo $vehicle->vin;?>" class="form-control" id="vin">
        </div>
        <div class="col-md-4 mb-3">
          <label for="contact_id" class="form-label fw-bold text-start">Dueño*</label>
          <select name="contact_id" class="form-select select2" required>
            <?php foreach(ContactData::getAll() as $c): ?>
              <option value="<?php echo $c->id; ?>" <?php if($vehicle->contact_id==$c->id){ echo "selected"; } ?>><?php echo $c->name." ".$c->lastname; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="brand" class="form-label fw-bold">Marca*</label>
          <input type="text" name="brand" value="<?php echo $vehicle->brand;?>" required class="form-control" id="brand">
        </div>
        <div class="col-md-4 mb-3">
          <label for="model" class="form-label fw-bold">Modelo*</label>
          <input type="text" name="model" value="<?php echo $vehicle->model;?>" required class="form-control" id="model">
        </div>
        <div class="col-md-2 mb-3">
          <label for="year" class="form-label fw-bold">Año</label>
          <input type="number" name="year" value="<?php echo $vehicle->year;?>" class="form-control" id="year">
        </div>
        <div class="col-md-2 mb-3">
          <label for="color" class="form-label fw-bold">Color</label>
          <input type="text" name="color" value="<?php echo $vehicle->color;?>" class="form-control" id="color">
        </div>
        <div class="col-md-12 mb-3">
          <label for="description" class="form-label fw-bold text-start">Notas</label>
          <textarea name="description" class="form-control text-start" rows="3"><?php echo $vehicle->description; ?></textarea>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $vehicle->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar Vehículo</button>
        <a href="./?view=vehicles&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>

<!-- Modal Add Contact -->
<div class="modal fade" id="modalAddContact" tabindex="-1">
  <div class="modal-dialog border-0">
    <div class="modal-content shadow-lg border-0">
      <form id="formAddContact">
        <div class="modal-header bg-dark text-white border-0">
          <h5 class="modal-title fw-bold">Agregar Nuevo Cliente</h5>
          <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-start">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nombre*</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Apellido</label>
              <input type="text" name="lastname" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Teléfono</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-bold">Dirección</label>
              <input type="text" name="address" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary fw-bold">Guardar Cliente</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  // Handle Add Contact AJAX
  $("#formAddContact").submit(function(e){
    e.preventDefault();
    $.post("./?action=contacts&opt=add_ajax", $(this).serialize(), function(data){
      let res = (typeof data === 'string') ? JSON.parse(data) : data;
      if(res.status == "success"){
        let newOption = new Option(res.name, res.id, true, true);
        $("#contact_id").append(newOption).trigger('change');
        $("#modalAddContact").modal('hide');
        $("#formAddContact")[0].reset();
        
        // Show Premium SweetAlert
        Swal.fire({
          title: "¡Cliente Agregado!",
          text: "El cliente ha sido registrado correctamente.",
          icon: "success",
          confirmButtonText: "Continuar",
          timer: 2000,
          timerProgressBar: true
        });
      }
    });
  });
});
</script>
