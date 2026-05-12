<?php
$products = AccountData::getAll();
$stocks = TaxData::getCategories();
$operations = OperationData::getAll();
?>
<section class="container-fluid">
<div class="row">
	<div class="col-md-12">
    <div class="card mb-4 border-0 shadow-sm text-start">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph me-2 text-start"></i> Reporte de Operaciones</h5>
      </div>
      <div class="card-body">
		<form>
			<input type="hidden" name="view" value="reports">
			<div class="row g-3">
				<div class="col-md-3 text-start">
          <label class="form-label fw-bold">Cuenta*</label>
				<select name="account_id" required class="form-select">
					<option value="">-- CUENTAS --</option>
					<?php foreach($products as $p):?>
						<option value="<?php echo $p->id;?>" <?php if(isset($_GET["account_id"]) && $_GET["account_id"]==$p->id){ echo "selected"; }?>><?php echo $p->name;?></option>
					<?php endforeach; ?>
				</select>
				</div>
				<div class="col-md-3 text-start">
          <label class="form-label fw-bold">Categoria</label>
				<select name="category_id" class="form-select">
					<option value="">--  CATEGORIAS --</option>
					<?php foreach($stocks as $p):?>
						<option value="<?php echo $p->id;?>" <?php if(isset($_GET["category_id"]) && $_GET["category_id"]==$p->id){ echo "selected"; }?>><?php echo $p->name;?></option>
					<?php endforeach; ?>
				</select>
				</div>
				<div class="col-md-2 text-start">
          <label class="form-label fw-bold">Desde</label>
					<input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control">
				</div>
				<div class="col-md-2 text-start">
          <label class="form-label fw-bold">Hasta</label>
					<input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control">
				</div>
				<div class="col-md-2 d-flex align-items-end text-start">
					<button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi-search"></i> BUSCAR</button>
				</div>
			</div>
		</form>
    </div>
    </div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<?php if(isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"]!="" && $_GET["ed"]!=""):?>
				<?php 
				$operations = array();
				if(!isset($_GET["category_id"]) || $_GET["category_id"]==""){
					$operations = OperationData::getReportByA($_GET["account_id"],$_GET["sd"],$_GET["ed"]);
				}
				else{
					$operations = OperationData::getReportByAC($_GET["account_id"],$_GET["category_id"],$_GET["sd"],$_GET["ed"]);
				} 
				?>
				<?php if(count($operations)>0):?>
					<div class="card mb-4 border-0 shadow-sm text-start">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
              <h6 class="mb-0 fw-bold text-start"><i class="bi bi-list-check me-2 text-start"></i> Resultados del Reporte</h6>
              <button onclick="thePDF()" id="makepdf" class="btn btn-outline-light btn-sm fw-bold"><i class="bi-file-pdf"></i> Exportar PDF</button>
            </div>
					<div class="card-body">
					<table class="table table-bordered table-hover datatable align-middle">
						<thead class="table-light">
							<th style="width:50px;">ID</th>
							<th>Concepto / Descripción</th>		
							<th>Monto</th>		
						  <th>Tipo</th>    
							<th>Fecha</th>
						</thead>
						<?php foreach($operations as $op):?>
							<tr>
							<td><small class="text-muted"><?php echo $op->id;?></small></td>
							<td><span class="fw-bold"><?php echo $op->concept;?></span><br><small class="text-muted"><?php echo $op->description;?></small></td>		
							<td><span class="fw-bold <?php echo ($op->kind==1) ? 'text-success' : 'text-danger'; ?>">$ <?php echo number_format($op->amount,2);?></span></td>		
						  <td>
                <?php if($op->kind==1): ?>
                  <span class="badge bg-success">Entrada</span>
                <?php else: ?>
                  <span class="badge bg-danger">Salida</span>
                <?php endif; ?>
              </td>    
							<td><small><?php echo $op->date_at;?></small></td>		
							</tr>
						<?php endforeach;?>
					</table>
					<?php
					$total=0;
					foreach($operations as $op){
						if($op->kind==1){ $total+=$op->amount; }
						else if($op->kind==2){ $total-=$op->amount; }
					}
					?>
          <div class="d-flex justify-content-end mt-4">
            <div class="card bg-light border-0">
              <div class="card-body p-3">
                <h4 class="mb-0">Balance Total: <span class="<?php echo ($total >= 0) ? 'text-success' : 'text-danger'; ?> fw-bold">$ <?php echo number_format($total,2); ?></span></h4>
              </div>
            </div>
          </div>
					</div>
					</div>
				<?php else:?>
          <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>
              <h5 class="alert-heading mb-1 fw-bold text-start">No se encontraron operaciones</h5>
              <p class="mb-0 text-start">El rango de fechas seleccionado no proporcionó ningún resultado.</p>
            </div>
          </div>
				<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
</section>

<script src="plugins/jspdf/jspdf.min.js"></script>
<script src="plugins/jspdf/jspdf.plugin.autotable.js"></script>

<script type="text/javascript">
function thePDF() {
    var doc = new jsPDF('p', 'pt');
    doc.setFontSize(20);
    doc.text("Reporte de Operaciones", 40, 50);
    doc.setFontSize(12);
    doc.text("Generado por: <?php echo Core::$user->name; ?>", 40, 70);
    doc.text("Fecha: <?php echo date("d-m-Y"); ?>", 40, 85);

    var columns = [
        {title: "Id", dataKey: "id"}, 
        {title: "Concepto", dataKey: "concept"}, 
        {title: "Monto", dataKey: "amount"}, 
        {title: "Tipo", dataKey: "kind"}, 
        {title: "Fecha", dataKey: "date_at"}, 
    ];
    var rows = [
      <?php foreach($operations as $op): ?>
        {
          "id": "<?php echo $op->id; ?>",
          "concept": "<?php echo $op->concept; ?>",
          "amount": "$ <?php echo number_format($op->amount,2); ?>",
          "kind": "<?php echo ($op->kind==1)?"Entrada":"Salida"; ?>",
          "date_at": "<?php echo $op->date_at; ?>",
        },
      <?php endforeach; ?>
    ];
    doc.autoTable(columns, rows, {
        margin: {top: 100},
        theme: 'grid'
    });
    doc.save('reporte_operaciones_<?php echo date("Ymd_His"); ?>.pdf');
}
</script>
