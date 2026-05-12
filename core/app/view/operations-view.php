<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Órdenes de Servicio</h2>
        <p class="text-muted">Gestione todas las recepciones y procesos de reparación del taller.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=operations&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-plus-lg me-2"></i> Nueva Orden</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$operations = OperationData::getAll();
		if(count($operations)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Folio</th>
			<th>Vehículo</th>
      <th>Cliente</th>
      <th>Estado</th>
      <th>Espacio</th>
      <th>Total</th>
      <th>Fecha</th>
			<th style="width:120px;">Acciones</th>
			</thead>
			<?php
			foreach($operations as $op):
        $vehicle = $op->getVehicle();
        $contact = $op->getContact();
        $status = $op->getStatus();
        $space = $op->getSpace();
				?>
				<tr>
				<td><span class="fw-bold">#<?php echo str_pad($op->id, 5, "0", STR_PAD_LEFT); ?></span></td>
				<td>
          <?php if($vehicle): ?>
            <span class="badge bg-dark"><?php echo $vehicle->plate; ?></span><br>
            <small class="text-muted"><?php echo $vehicle->brand." ".$vehicle->model; ?></small>
          <?php else: ?>
            <span class="text-muted small">Sin vehículo</span>
          <?php endif; ?>
        </td>
        <td><?php echo $contact ? $contact->name." ".$contact->lastname : "Sin contacto"; ?></td>
        <td>
          <?php if($status): ?>
            <span class="badge shadow-sm" style="background-color: <?php echo $status->color; ?>"><?php echo $status->name; ?></span>
          <?php endif; ?>
        </td>
        <td><small><?php echo $space ? $space->name : 'N/A'; ?></small></td>
        <td><span class="fw-bold text-success">$<?php echo number_format($op->total, 2); ?></span></td>
        <td><small><?php echo date("d/m/Y", strtotime($op->created_at)); ?></small></td>
				<td class="text-center">
        <a href="index.php?view=operations&opt=details&id=<?php echo $op->id;?>" class="btn btn-primary btn-sm" title="Detalles"><i class="bi bi-eye"></i></a>
				<a href="index.php?view=operations&opt=edit&id=<?php echo $op->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delitem-<?php echo $op->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delitem-<?php echo $op->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar esta orden de servicio.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=operations&opt=del&id=<?=$op->id;?>";
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
        <i class="bi bi-info-circle me-2"></i> No hay órdenes de servicio registradas.
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
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Nueva Orden de Servicio</h2>
        <p class="text-muted">Inicie un nuevo proceso de reparación registrando los datos del cliente y el vehículo.</p>
    </div>
</div>

<div class="mb-4">
    <button class="btn btn-primary fw-bold px-3 shadow-sm me-2" type="button" data-coreui-toggle="modal" data-coreui-target="#modalAddContact"><i class="bi bi-person-plus-fill me-2"></i> Nuevo Cliente</button>
    <button class="btn btn-dark fw-bold px-3 shadow-sm" type="button" id="btn-add-vehicle-top" data-coreui-toggle="modal" data-coreui-target="#modalAddVehicle" disabled><i class="bi bi-car-front-fill me-2"></i> Nuevo Vehículo</button>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" action="index.php?action=operations&opt=add" role="form">
  <div class="row g-4">
    <div class="col-md-6 mb-2">
      <label for="contact_id" class="form-label fw-bold">Cliente*</label>
        <select name="contact_id" id="contact_id" class="form-select select2" required>
          <option value="">-- SELECCIONE CLIENTE --</option>
          <?php foreach(ContactData::getAllBy("type", 1) as $c): ?>
            <option value="<?php echo $c->id; ?>"><?php echo $c->name." ".$c->lastname; ?></option>
          <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6 mb-2">
      <label for="vehicle_id" class="form-label fw-bold">Vehículo*</label>
        <select name="vehicle_id" id="vehicle_id" class="form-select select2" required disabled>
          <option value="">-- SELECCIONE CLIENTE PRIMERO --</option>
        </select>
    </div>

    <div class="col-md-4 mb-2">
      <label for="space_id" class="form-label fw-bold">Ubicación / Espacio ocupado*</label>
      <select name="space_id" class="form-select select2" required>
        <?php foreach(SpaceData::getAll() as $s): ?>
          <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-2">
      <label for="status_id" class="form-label fw-bold text-start">Estado inicial de recepción*</label>
      <select name="status_id" class="form-select select2" required>
        <?php foreach(StatusData::getAll() as $s): ?>
          <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-2">
      <label for="mechanic_id" class="form-label fw-bold text-start">Técnico / Mecánico responsable</label>
      <select name="mechanic_id" class="form-select select2">
        <option value="">-- SIN ASIGNAR --</option>
        <?php foreach(UserData::getAllBy("type", 2) as $m): ?>
          <option value="<?php echo $m->id; ?>"><?php echo $m->name." ".$m->lastname; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3 mb-2">
      <label for="start_date" class="form-label fw-bold">Fecha de Ingreso</label>
      <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-md-3 mb-2">
      <label for="end_date" class="form-label fw-bold">Promesa de Entrega</label>
      <input type="date" name="end_date" class="form-control">
    </div>
    <div class="col-md-6 mb-2">
      <label for="description" class="form-label fw-bold">Diagnóstico preliminar / Observaciones</label>
      <input type="text" name="description" class="form-control" placeholder="Ej. Cambio de balatas y rectificado...">
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Crear Orden de Servicio</button>
    <a href="./?view=operations&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

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
              <input type="text" name="phone" id="c_phone" class="form-control">
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

<!-- Modal Add Vehicle -->
<div class="modal fade" id="modalAddVehicle" tabindex="-1">
  <div class="modal-dialog border-0">
    <div class="modal-content shadow-lg border-0">
      <form id="formAddVehicle">
        <input type="hidden" name="contact_id" id="v_contact_id">
        <div class="modal-header bg-dark text-white border-0">
          <h5 class="modal-title fw-bold">Agregar Nuevo Vehículo</h5>
          <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-start">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Placa*</label>
              <input type="text" name="plate" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Marca*</label>
              <input type="text" name="brand" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Modelo*</label>
              <input type="text" name="model" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Año*</label>
              <input type="number" name="year" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Color*</label>
              <input type="text" name="color" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">VIN / Serie</label>
              <input type="text" name="vin" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary fw-bold">Guardar Vehículo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  // Update vehicle dropdown when client changes
  $("#contact_id").change(function(){
    let cid = $(this).val();
    if(cid != ""){
      $("#vehicle_id").prop("disabled", false);
      $("#btn-add-vehicle-top").prop("disabled", false);
      $("#v_contact_id").val(cid);
      refreshVehicles(cid);
    }else{
      $("#vehicle_id").prop("disabled", true).empty().append('<option value="">-- SELECCIONE CLIENTE PRIMERO --</option>');
      $("#btn-add-vehicle-top").prop("disabled", true);
    }
  });

  function refreshVehicles(contact_id){
    $.getJSON("./?action=vehicles&opt=get_all_ajax&contact_id=" + contact_id, function(data){
      let vselect = $("#vehicle_id");
      vselect.empty().append('<option value="">-- SELECCIONE VEHÍCULO --</option>');
      data.forEach(function(v){
        let label = v.plate + " - " + v.brand + " " + v.model;
        let opt = new Option(label, v.id, false, false);
        vselect.append(opt);
      });
      vselect.trigger('change');
    });
  }

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

  // Handle Add Vehicle AJAX
  $("#formAddVehicle").submit(function(e){
    e.preventDefault();
    $.post("./?action=vehicles&opt=add_ajax", $(this).serialize(), function(data){
      let res = (typeof data === 'string') ? JSON.parse(data) : data;
      if(res.status == "success"){
        let label = res.plate + " - " + res.brand + " " + res.model;
        let newOption = new Option(label, res.id, true, true);
        $("#vehicle_id").append(newOption).trigger('change');
        $("#modalAddVehicle").modal('hide');
        $("#formAddVehicle")[0].reset();

        // Show Premium SweetAlert
        Swal.fire({
          title: "¡Vehículo Agregado!",
          text: "El vehículo ha sido vinculado al cliente.",
          icon: "success",
          confirmButtonText: "Continuar",
          timer: 2000,
          timerProgressBar: true
        });
      }
    });
  });

  // Re-initialize Select2 for dynamic elements
  if(window.initSelect2){ window.initSelect2(); }
});
</script>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="details"):?>
<?php 
$op = OperationData::getById($_GET["id"]);
$vehicle = $op->getVehicle();
$contact = $op->getContact();
$status = $op->getStatus();
$space = $op->getSpace();
$mechanic = $op->getMechanic();
?>
<section class="container-fluid text-start">
  <div class="row g-4">
    <!-- INFO CARDS -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white fw-bold">
          <i class="bi bi-info-circle me-2"></i> Información General
        </div>
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-primary text-white rounded p-2 me-3">
              <i class="bi bi-car-front fs-3"></i>
            </div>
            <div>
              <h5 class="mb-0 fw-bold"><?php echo $vehicle ? $vehicle->plate : 'Sin Vehículo'; ?></h5>
              <?php if($vehicle): ?>
                <small class="text-muted"><?php echo $vehicle->brand." ".$vehicle->model; ?> (<?php echo $vehicle->year; ?>)</small>
              <?php endif; ?>
            </div>
          </div>
          <hr>
          <div class="mb-3">
            <label class="small text-muted d-block">Cliente</label>
            <span class="fw-bold"><?php echo $contact ? $contact->name." ".$contact->lastname : "Sin contacto"; ?></span>
            <?php if($contact): ?>
              <small class="d-block text-muted"><i class="bi bi-telephone me-1"></i> <?php echo $contact->phone; ?></small>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="small text-muted d-block">Mecánico Asignado</label>
            <span class="fw-bold"><?php echo $mechanic ? $mechanic->name." ".$mechanic->lastname : 'Sin asignar'; ?></span>
          </div>
          <div class="mb-0">
            <label class="small text-muted d-block">Notas de Entrada</label>
            <p class="small mb-0"><?php echo $op->description; ?></p>
          </div>
          <hr>
          <div class="d-grid gap-2 text-start">
            <a href="./report/order-pdf.php?id=<?php echo $op->id; ?>" target="_blank" class="btn btn-outline-dark fw-bold btn-sm"><i class="bi bi-printer me-2"></i> Imprimir Orden (PDF)</a>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
          <span><i class="bi bi-hdd-stack me-2"></i> Control de Estado</span>
          <?php if($status): ?>
            <span class="badge shadow-sm" style="background-color: <?php echo $status->color; ?>"><?php echo $status->name; ?></span>
          <?php endif; ?>
        </div>
        <div class="card-body">
          <form method="post" action="./?action=operations&opt=upd_status">
            <div class="mb-3">
              <label class="form-label small fw-bold">Cambiar Estado</label>
              <select name="status_id" class="form-select form-select-sm mb-2">
                <?php foreach(StatusData::getAll() as $s): ?>
                  <option value="<?php echo $s->id; ?>" <?php if($op->status_id==$s->id) echo "selected"; ?>><?php echo $s->name; ?></option>
                <?php endforeach; ?>
              </select>
              <label class="form-label small fw-bold">Cambiar Ubicación</label>
              <select name="space_id" class="form-select form-select-sm mb-3">
                <?php foreach(SpaceData::getAll() as $s): ?>
                  <option value="<?php echo $s->id; ?>" <?php if($op->space_id==$s->id) echo "selected"; ?>><?php echo $s->name; ?></option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="id" value="<?php echo $op->id; ?>">
              <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Actualizar Estado</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- MAIN WORKSPACE -->
    <div class="col-md-8">
      <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white p-0">
          <ul class="nav nav-tabs border-bottom-0" id="opTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active px-4 py-3 fw-bold border-0 border-bottom" id="jobs-tab" data-coreui-toggle="tab" data-coreui-target="#tab-jobs" type="button" role="tab" aria-controls="tab-jobs" aria-selected="true"><i class="bi bi-list-check me-2"></i> Tareas</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link px-4 py-3 fw-bold border-0 border-bottom" id="details-tab" data-coreui-toggle="tab" data-coreui-target="#tab-details" type="button" role="tab" aria-controls="tab-details" aria-selected="false"><i class="bi bi-cart-plus me-2"></i> Refacciones / Servicios</button>
            </li>
          </ul>
        </div>
        <div class="card-body p-4">
          <div class="tab-content" id="opTabsContent">
            <!-- TAB JOBS -->
            <div class="tab-pane show active" id="tab-jobs" role="tabpanel" aria-labelledby="jobs-tab">
              <div class="d-flex justify-content-between align-items-center mb-4 text-start">
                <h5 class="mb-0 fw-bold">Desglose de Trabajos</h5>
                <button type="button" class="btn btn-dark btn-sm fw-bold" data-coreui-toggle="modal" data-coreui-target="#modalAddJob"><i class="bi bi-plus-lg"></i> Agregar Tarea</button>
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="bg-light">
                    <tr class="text-start">
                      <th>Tarea</th>
                      <th>Área</th>
                      <th>Mecánico</th>
                      <th>Estado</th>
                      <th>Costo</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="text-start">
                    <?php 
                    $jobs = JobData::getAllByOperationId($op->id);
                    foreach($jobs as $j):
                      $js = $j->getStatus();
                      $jm = $j->getMechanic();
                    ?>
                    <tr>
                      <td class="text-start">
                        <span class="fw-bold"><?php echo $j->name; ?></span>
                        <small class="d-block text-muted"><?php echo $j->description; ?></small>
                      </td>
                      <td class="text-start"><span class="badge bg-secondary"><?php echo $j->getCategory()->name; ?></span></td>
                      <td class="text-start"><small><?php echo $jm ? $jm->name : 'N/A'; ?></small></td>
                      <td class="text-start">
                        <?php if($js): ?>
                          <span class="badge rounded-pill" style="background-color:<?php echo $js->color; ?>80; color:<?php echo $js->color; ?>; border: 1px solid <?php echo $js->color; ?>"><?php echo $js->name; ?></span>
                        <?php endif; ?>
                      </td>
                      <td class="text-start">
                        <?php if($j->is_billable): ?>
                          <span class="fw-bold text-success">$<?php echo number_format($j->price, 2); ?></span>
                        <?php else: ?>
                          <small class="text-muted text-start">No cobrable</small>
                        <?php endif; ?>
                      </td>
                      <td class="text-end">
                        <a href="./?action=jobs&opt=del&id=<?php echo $j->id; ?>&op_id=<?php echo $op->id; ?>" class="text-danger"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- TAB DETAILS (PARTS/SERVICES) -->
            <div class="tab-pane" id="tab-details" role="tabpanel" aria-labelledby="details-tab">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold">Refacciones y Servicios Adicionales</h5>
                <button type="button" class="btn btn-dark btn-sm fw-bold" data-coreui-toggle="modal" data-coreui-target="#modalAddDetail"><i class="bi bi-plus-lg"></i> Agregar Item</button>
              </div>
              <div class="table-responsive text-start">
                <table class="table table-hover align-middle text-start">
                  <thead class="bg-light text-start">
                    <tr class="text-start">
                      <th class="text-start">Item</th>
                      <th class="text-start">Cant.</th>
                      <th class="text-start">P. Unitario</th>
                      <th class="text-start">Subtotal</th>
                      <th class="text-start"></th>
                    </tr>
                  </thead>
                  <tbody class="text-start">
                    <?php 
                    $details = OperationDetailData::getAllByOperationId($op->id);
                    foreach($details as $d):
                      $name = "";
                      if($d->service_id) $name = $d->getService()->name;
                      else if($d->part_id) $name = $d->getPart()->name;
                    ?>
                    <tr class="text-start">
                      <td  class="text-start"><?php echo $name; ?></td>
                      <td class="text-start"><?php echo $d->quantity; ?></td>
                      <td class="text-start">$<?php echo number_format($d->price, 2); ?></td>
                      <td class="text-start fw-bold">$<?php echo number_format($d->price * $d->quantity, 2); ?></td>
                      <td class="text-end text-start">
                        <a href="./?action=operations&opt=del_detail&id=<?php echo $d->id; ?>&op_id=<?php echo $op->id; ?>" class="text-danger"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot class="table-light text-start">
                    <tr>
                      <td colspan="3" class="text-end fw-bold text-start">TOTAL:</td>
                      <td class="fw-bold text-success fs-5 text-start">$<?php echo number_format($op->total, 2); ?></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MODALS -->
<div class="modal fade" id="modalAddJob" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content text-start">
      <form method="post" action="./?action=jobs&opt=add">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Agregar Tarea / Trabajo</h5>
          <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-start">
          <div class="mb-3 text-start">
            <label class="form-label fw-bold">Nombre de la Tarea*</label>
            <input type="text" name="name" required class="form-control" placeholder="Ej. Revisar frenos traseros">
          </div>
          <div class="mb-3 text-start">
            <label class="form-label fw-bold">Área / Categoría*</label>
            <select name="job_category_id" class="form-select" required>
              <?php foreach(JobCategoryData::getAll() as $c): ?>
                <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-3 text-start">
            <div class="col-md-6 mb-3 text-start">
              <label class="form-label fw-bold">Precio</label>
              <input type="number" step="any" name="price" class="form-control" value="0">
            </div>
            <div class="col-md-6 mb-3 mt-4 pt-2 text-start">
              <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" name="is_billable" value="1" id="is_billable" checked>
                <label class="form-check-label text-start" for="is_billable">Cobrable</label>
              </div>
            </div>
          </div>
          <div class="mb-0 text-start">
            <label class="form-label fw-bold">Observaciones</label>
            <textarea name="description" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation_id" value="<?php echo $op->id; ?>">
          <button type="submit" class="btn btn-primary fw-bold">Guardar Tarea</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddDetail" tabindex="-1">
  <div class="modal-dialog text-start">
    <div class="modal-content text-start">
      <form method="post" action="./?action=operations&opt=add_detail">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Agregar Refacción o Servicio</h5>
          <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-start">
          <div class="mb-3 text-start">
            <label class="form-label fw-bold text-start">Tipo de Item</label>
            <select id="select-type" class="form-select mb-3">
              <option value="part">Refacción (Inventario)</option>
              <option value="service" selected>Servicio (Mano de Obra)</option>
            </select>
          </div>
          
          <div id="div-service" class="mb-3 text-start">
            <label class="form-label fw-bold">Servicio*</label>
            <select name="service_id" class="form-select">
              <option value="">-- SELECCIONE SERVICIO --</option>
              <?php foreach(ServiceData::getAll() as $s): ?>
                <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?> ($<?php echo number_format($s->price, 2); ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div id="div-part" class="mb-3 d-none text-start">
            <label class="form-label fw-bold">Refacción*</label>
            <select name="part_id" class="form-select">
              <option value="">-- SELECCIONE REFACCION --</option>
              <?php foreach(PartData::getAll() as $p): ?>
                <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?> (Stock: <?php echo $p->quantity; ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row g-3 text-start">
            <div class="col-md-6 mb-3 text-start">
              <label class="form-label fw-bold text-start">Cantidad*</label>
              <input type="number" name="quantity" class="form-control" value="1" required>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label class="form-label fw-bold text-start">Precio Unitario Override</label>
              <input type="number" step="any" name="price" class="form-control" placeholder="Opcional">
              <small class="text-muted text-start">Dejar vacío para usar precio base.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation_id" value="<?php echo $op->id; ?>">
          <button type="submit" class="btn btn-primary fw-bold">Agregar a la Orden</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    // Manual tab initialization for CoreUI 4
    const triggerTabList = [].slice.call(document.querySelectorAll('#opTabs button'))
    triggerTabList.forEach(function (triggerEl) {
      const tabTrigger = new coreui.Tab(triggerEl)
      triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
      })
    })

    $("#select-type").change(function(){
      if($(this).val()=="part"){
        $("#div-part").removeClass("d-none");
        $("#div-service").addClass("d-none");
      }else{
        $("#div-part").addClass("d-none");
        $("#div-service").removeClass("d-none");
      }
    });
  });
</script>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $op = OperationData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0 text-start"><i class="bi bi-pencil-square me-2"></i> Editar Orden de Servicio</h5>
    </div>
    <div class="card-body">
		<form class="form-horizontal" method="post" action="index.php?action=operations&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-6 mb-3 text-start">
          <label for="vehicle_id" class="form-label fw-bold">Vehículo*</label>
          <select name="vehicle_id" id="vehicle_id" class="form-select" required>
            <?php foreach(VehicleData::getAll() as $v): $c = $v->getContact(); ?>
              <option value="<?php echo $v->id; ?>" <?php if($op->vehicle_id==$v->id) echo "selected"; ?>><?php echo $v->plate; ?> - <?php echo $v->brand; ?> <?php echo $v->model; ?> (<?php echo $c->name; ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 mb-3 text-start">
          <label for="space_id" class="form-label fw-bold">Ubicación / Espacio*</label>
          <select name="space_id" class="form-select" required>
            <?php foreach(SpaceData::getAll() as $s): ?>
              <option value="<?php echo $s->id; ?>" <?php if($op->space_id==$s->id) echo "selected"; ?>><?php echo $s->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 mb-3 text-start">
          <label for="status_id" class="form-label fw-bold">Estado*</label>
          <select name="status_id" class="form-select" required>
            <?php foreach(StatusData::getAll() as $s): ?>
              <option value="<?php echo $s->id; ?>" <?php if($op->status_id==$s->id) echo "selected"; ?>><?php echo $s->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3 text-start">
          <label for="mechanic_id" class="form-label fw-bold text-start">Mecánico Asignado</label>
          <select name="mechanic_id" class="form-select">
            <option value="">-- NO ASIGNADO --</option>
            <?php foreach(UserData::getAllBy("type", 2) as $m): ?>
              <option value="<?php echo $m->id; ?>" <?php if($op->mechanic_id==$m->id) echo "selected"; ?>><?php echo $m->name." ".$m->lastname; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 mb-3 text-start">
          <label for="start_date" class="form-label fw-bold">Fecha de Inicio</label>
          <input type="date" name="start_date" class="form-control" value="<?php echo $op->start_date; ?>">
        </div>
        <div class="col-md-3 mb-3 text-start">
          <label for="end_date" class="form-label fw-bold">Fecha Estimada Entrega</label>
          <input type="date" name="end_date" class="form-control" value="<?php echo $op->end_date; ?>">
        </div>
        <div class="col-md-12 mb-3 text-start">
          <label for="description" class="form-label fw-bold">Descripción / Motivo de Entrada</label>
          <textarea name="description" class="form-control" rows="4"><?php echo $op->description; ?></textarea>
        </div>
      </div>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $op->id; ?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar Orden</button>
        <a href="./?view=operations&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
