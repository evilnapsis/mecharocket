<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Catálogo de Refacciones</h2>
        <p class="text-muted">Gestione su inventario de partes, piezas y materiales para las reparaciones.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=parts&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-box-seam me-2"></i> Nueva Parte/Material</a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$parts = PartData::getAll();
		if(count($parts)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Código</th>
			<th>Nombre</th>
      <th>Categoría</th>
      <th>Stock</th>
      <th>Precio Venta</th>
      <th>Estado</th>
			<th style="width:100px;">Acciones</th>
			</thead>
			<?php
			foreach($parts as $part):
        $category = $part->getCategory();
				?>
				<tr>
				<td><span class="badge bg-secondary"><?php echo $part->code; ?></span></td>
				<td><span class="fw-bold"><?php echo $part->name; ?></span></td>
        <td><?php echo $category->name; ?></td>
        <td>
          <?php if($part->quantity <= 5): ?>
            <span class="badge bg-danger"><?php echo $part->quantity." ".$part->unit; ?> (Bajo)</span>
          <?php else: ?>
            <span class="badge bg-success"><?php echo $part->quantity." ".$part->unit; ?></span>
          <?php endif; ?>
        </td>
        <td><span class="fw-bold text-success">$<?php echo number_format($part->price_out, 2); ?></span></td>
        <td class="text-center">
          <?php if($part->is_active==1): ?>
            <span class="badge bg-success shadow-sm">Activo</span>
          <?php else: ?>
            <span class="badge bg-danger shadow-sm">Inactivo</span>
          <?php endif; ?>
        </td>
				<td class="text-center">
				<a href="index.php?view=parts&opt=edit&id=<?php echo $part->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delitem-<?php echo $part->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delitem-<?php echo $part->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar este item del inventario.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=parts&opt=del&id=<?=$part->id;?>";
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
        <i class="bi bi-info-circle me-2"></i> No hay refacciones registradas en el inventario.
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
    <h2 class="fw-bold text-dark mb-1">Nueva Refacción / Material</h2>
    <p class="text-muted">Ingrese los detalles para registrar un nuevo producto en el inventario.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" action="index.php?action=parts&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-4 mb-3">
      <label for="code" class="form-label fw-bold">Código / SKU*</label>
      <input type="text" name="code" required class="form-control" id="code" placeholder="Ej. FILT-001">
    </div>
    <div class="col-md-8 mb-3">
      <label for="name" class="form-label fw-bold">Nombre del Producto*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Ej. Filtro de Aceite Sintético">
    </div>
    <div class="col-md-4 mb-3">
      <label for="category_id" class="form-label fw-bold">Categoría*</label>
      <select name="category_id" class="form-select select2" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(CategoryData::getAll() as $c): ?>
          <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="quantity" class="form-label fw-bold">Stock Inicial*</label>
      <input type="number" name="quantity" required class="form-control" id="quantity" value="0">
    </div>
    <div class="col-md-4 mb-3">
      <label for="unit" class="form-label fw-bold">Unidad de Medida*</label>
      <input type="text" name="unit" required class="form-control" id="unit" value="Pieza" placeholder="Ej. Pieza, Litro, Galón">
    </div>
    <div class="col-md-6 mb-3 text-start">
      <label for="price_in" class="form-label fw-bold text-start">Precio Compra (Costo)</label>
      <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="number" step="any" name="price_in" class="form-control text-start" id="price_in" value="0">
      </div>
    </div>
    <div class="col-md-6 mb-3 text-start">
      <label for="price_out" class="form-label fw-bold text-start">Precio Venta (Público)*</label>
      <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="number" step="any" name="price_out" required class="form-control text-start" id="price_out" value="0">
      </div>
    </div>
    <div class="col-md-12 mb-3">
      <label for="description" class="form-label fw-bold">Descripción / Detalles</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Detalles técnicos o notas"></textarea>
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar al Inventario</button>
    <a href="./?view=parts&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php $part = PartData::getById($_GET["id"]);?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar Refacción</h2>
    <p class="text-muted">Actualice la información del producto en el catálogo.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" action="index.php?action=parts&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-4 mb-3">
          <label for="code" class="form-label fw-bold">Código / SKU*</label>
          <input type="text" name="code" value="<?php echo $part->code;?>" required class="form-control" id="code">
        </div>
        <div class="col-md-8 mb-3">
          <label for="name" class="form-label fw-bold">Nombre del Producto*</label>
          <input type="text" name="name" value="<?php echo $part->name;?>" required class="form-control" id="name">
        </div>
        <div class="col-md-4 mb-3">
          <label for="category_id" class="form-label fw-bold">Categoría*</label>
          <select name="category_id" class="form-select select2" required>
            <?php foreach(CategoryData::getAll() as $c): ?>
              <option value="<?php echo $c->id; ?>" <?php if($part->category_id==$c->id){ echo "selected"; } ?>><?php echo $c->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="quantity" class="form-label fw-bold">Stock Actual*</label>
          <input type="number" name="quantity" value="<?php echo $part->quantity;?>" required class="form-control" id="quantity">
        </div>
        <div class="col-md-4 mb-3">
          <label for="unit" class="form-label fw-bold">Unidad de Medida*</label>
          <input type="text" name="unit" value="<?php echo $part->unit;?>" required class="form-control" id="unit">
        </div>
        <div class="col-md-4 mb-3">
          <label for="price_in" class="form-label fw-bold">Precio Compra</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="any" name="price_in" value="<?php echo $part->price_in;?>" class="form-control" id="price_in">
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="price_out" class="form-label fw-bold">Precio Venta*</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="any" name="price_out" value="<?php echo $part->price_out;?>" required class="form-control" id="price_out">
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="is_active" class="form-label fw-bold">Estado*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($part->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($part->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
        <div class="col-md-12 mb-3">
          <label for="description" class="form-label fw-bold">Descripción</label>
          <textarea name="description" class="form-control" rows="3"><?php echo $part->description; ?></textarea>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $part->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar Item</button>
        <a href="./?view=parts&opt=all" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
