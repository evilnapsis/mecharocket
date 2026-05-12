<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid">
<div class="row"><div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i> Pagos</h5>
      <a href="./?view=sell&opt=alumn" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-plus-lg"></i> Nueva Venta</a>
    </div>
    <div class="card-body">
      <?php $teams = PaymentData::getAll(); if(count($teams)>0): ?>
      <table class="table table-bordered table-hover datatable align-middle">
        <thead class="table-light"><th>Alumno</th><th>Concepto</th><th>Monto</th><th>Fecha</th><th style="width:80px;">Acciones</th></thead>
        <?php foreach($teams as $team): 
          $al = $team->getAlumn();
          $sell = $team->getSell();
          $concept = $sell ? ConceptData::getById($sell->concept_id) : null;
        ?>
        <tr>
          <td><span class="fw-bold"><?php echo $al->name." ".$al->lastname; ?></span></td>
          <td><?php echo $concept ? $concept->name : "-"; ?></td>
          <td>$ <?php echo number_format($team->amount,2); ?></td>
          <td><?php echo $team->created_at; ?></td>
          <td class="text-center">
            <a id="delpay-<?php echo $team->id?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
            <script>$("#delpay-<?php echo $team->id?>").click(function(){ Swal.fire({title:"¿Eliminar pago?",icon:"warning",showCancelButton:true,confirmButtonColor:"#d33",cancelButtonColor:"#6c757d",confirmButtonText:"Sí",cancelButtonText:"Cancelar"}).then((r)=>{ if(r.isConfirmed){ window.location="./?action=payments&opt=del&id=<?=$team->id;?>"; }});});</script>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
      <div class="alert alert-info mb-0"><i class="bi bi-info-circle me-2"></i> No hay pagos registrados.</div>
      <?php endif; ?>
    </div>
  </div>
</div></div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="container-fluid text-start">
<div class="row"><div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-info text-white"><h5 class="mb-0"><i class="bi bi-cash-coin me-2"></i> Nuevo Pago Directo</h5></div>
    <div class="card-body">
      <form method="post" action="./?action=payments&opt=add" role="form">
        <div class="row g-3">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Concepto*</label>
            <select name="concept_id" required class="form-select">
              <option value="">-- SELECCIONE --</option>
              <?php foreach(ConceptData::getAll() as $c): ?>
              <option value="<?php echo $c->id; ?>"><?php echo $c->name." - $ ".$c->price;?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Alumno*</label>
            <select name="alumn_id" required class="form-select">
              <option value="">-- SELECCIONE --</option>
              <?php foreach(PersonData::getAlumns() as $c): ?>
              <option value="<?php echo $c->id; ?>"><?php echo $c->code." - ".$c->name." ".$c->lastname;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar Pago</button>
          <a href="./?view=payments&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div></div>
</section>
<?php endif; ?>
