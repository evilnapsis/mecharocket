<?php
$active_status = 1; // Assuming 1 is the first active status
$active_ops = OperationData::getAllByQ("where status_id=$active_status");
$all_ops = OperationData::getAll();
$vehicles = VehicleData::getAll();
$parts = PartData::getAll();
$low_stock = PartData::getAllByQ("where quantity <= 5");

$recent_ops = OperationData::getAllByQ("order by created_at desc limit 5");
?>

<div class="row g-4 mb-4 text-start">
  <!-- Ordenes Activas -->
  <div class="col-sm-6 col-xl-3">
    <div class="card text-white bg-primary h-100 border-0 shadow-sm overflow-hidden">
      <div class="card-body pb-3 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-2 fw-bold"><?php echo count($active_ops); ?></div>
          <div class="text-uppercase small fw-bold opacity-75">Órdenes Activas</div>
        </div>
        <i class="bi-tools fs-1 opacity-50"></i>
      </div>
      <div class="card-footer px-3 py-2 border-0 bg-dark bg-opacity-10">
        <a class="btn-block text-white text-decoration-none small fw-bold" href="./?view=operations&opt=all">Ver Órdenes <i class="bi-arrow-right-short"></i></a>
      </div>
    </div>
  </div>
  <!-- Vehiculos -->
  <div class="col-sm-6 col-xl-3">
    <div class="card text-white bg-dark h-100 border-0 shadow-sm overflow-hidden">
      <div class="card-body pb-3 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-2 fw-bold"><?php echo count($vehicles); ?></div>
          <div class="text-uppercase small fw-bold opacity-75">Vehículos</div>
        </div>
        <i class="bi-car-front fs-1 opacity-50"></i>
      </div>
      <div class="card-footer px-3 py-2 border-0 bg-white bg-opacity-10">
        <a class="btn-block text-white text-decoration-none small fw-bold" href="./?view=vehicles&opt=all">Ver Vehículos <i class="bi-arrow-right-short"></i></a>
      </div>
    </div>
  </div>
  <!-- Inventario -->
  <div class="col-sm-6 col-xl-3">
    <div class="card text-white bg-warning h-100 border-0 shadow-sm overflow-hidden">
      <div class="card-body pb-3 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-2 fw-bold text-dark"><?php echo count($low_stock); ?></div>
          <div class="text-uppercase small fw-bold opacity-75 text-dark">Stock Bajo</div>
        </div>
        <i class="bi-box-seam fs-1 opacity-50 text-dark"></i>
      </div>
      <div class="card-footer px-3 py-2 border-0 bg-dark bg-opacity-10">
        <a class="btn-block text-dark text-decoration-none small fw-bold" href="./?view=parts&opt=all">Ver Inventario <i class="bi-arrow-right-short text-dark"></i></a>
      </div>
    </div>
  </div>
  <!-- Ingresos Totales (Simulado o real si tenemos balance) -->
  <div class="col-sm-6 col-xl-3">
    <div class="card text-white bg-success h-100 border-0 shadow-sm overflow-hidden">
      <div class="card-body pb-3 d-flex justify-content-between align-items-start">
        <div>
          <?php 
          $total_revenue = 0;
          foreach($all_ops as $op) $total_revenue += $op->total;
          ?>
          <div class="fs-2 fw-bold">$<?php echo number_format($total_revenue, 0); ?></div>
          <div class="text-uppercase small fw-bold opacity-75">Ingresos Totales</div>
        </div>
        <i class="bi-cash-stack fs-1 opacity-50"></i>
      </div>
      <div class="card-footer px-3 py-2 border-0 bg-dark bg-opacity-10">
        <span class="small fw-bold">Histórico acumulado</span>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 text-start">
  <!-- Ordenes Recientes -->
  <div class="col-md-8 text-start">
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white fw-bold py-3 text-start">
        <i class="bi bi-clock-history me-2"></i> Actividad Reciente (Últimas Órdenes)
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
              <tr class="text-start">
                <th>Folio</th>
                <th>Vehículo</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($recent_ops as $op): 
                $v = $op->getVehicle();
                $c = $op->getContact();
                $s = $op->getStatus();
              ?>
              <tr>
                <td><span class="fw-bold">#<?php echo str_pad($op->id, 5, "0", STR_PAD_LEFT); ?></span></td>
                <td><?php echo $v ? $v->plate : "---"; ?> <small class="text-muted d-block"><?php echo $v ? $v->brand : ""; ?></small></td>
                <td><?php echo $c ? $c->name." ".$c->lastname : "---"; ?></td>
                <td><span class="fw-bold text-success">$<?php echo number_format($op->total, 2); ?></span></td>
                <td>
                  <?php if($s): ?>
                    <span class="badge" style="background-color: <?php echo $s->color; ?>"><?php echo $s->name; ?></span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <a href="./?view=operations&opt=details&id=<?php echo $op->id; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Atajos Rapidos -->
  <div class="col-md-4 text-start">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white fw-bold py-3 text-start">
        <i class="bi bi-lightning-charge me-2 text-start"></i> Acciones Rápidas
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="./?view=operations&opt=new" class="btn btn-primary py-2 fw-bold text-start"><i class="bi bi-plus-lg me-2"></i> Nueva Orden de Servicio</a>
          <a href="./?view=vehicles&opt=new" class="btn btn-dark py-2 fw-bold text-start"><i class="bi bi-car-front me-2"></i> Registrar Nuevo Vehículo</a>
          <a href="./?view=contacts&opt=new&type=1" class="btn btn-outline-dark py-2 fw-bold text-start"><i class="bi bi-person-plus me-2"></i> Nuevo Cliente</a>
          <a href="./?view=parts&opt=new" class="btn btn-outline-secondary py-2 fw-bold text-start"><i class="bi bi-box-seam me-2"></i> Agregar a Inventario</a>
        </div>
      </div>
    </div>
    
    <div class="card border-0 shadow-sm bg-gradient text-white" style="background: linear-gradient(45deg, #1a1a2e, #16213e);">
      <div class="card-body p-4 text-center">
        <i class="bi bi-rocket-takeoff fs-1 text-primary mb-3"></i>
        <h5 class="fw-bold">MECHAROCKET</h5>
        <p class="small opacity-75">Sistema de Gestión de Talleres Mecánicos</p>
        <hr class="opacity-25">
        <small class="opacity-50">V 1.0.0 - Control Total</small>
      </div>
    </div>
  </div>
</div>
