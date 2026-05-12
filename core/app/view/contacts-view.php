<?php 
$type = isset($_GET["type"]) ? $_GET["type"] : 1;
$type_label = ($type == 1) ? "Clientes" : "Proveedores";
$type_icon = ($type == 1) ? "bi-people" : "bi-truck";

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1"><?php echo $type_label; ?></h2>
        <p class="text-muted">Gestione su base de datos de <?php echo strtolower($type_label); ?> para operaciones del taller.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=contacts&opt=new&type=<?php echo $type; ?>" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-person-plus-fill me-2"></i> Nuevo <?php echo ($type==1) ? 'Cliente' : 'Proveedor'; ?></a>
</div>

<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
		<?php
		$contacts = ContactData::getAllBy("type", $type);
		if(count($contacts)>0){
			?>
			<table class="table table-bordered table-hover datatable align-middle">
			<thead class="table-light">
			<th>Nombre completo</th>
			<th>Email</th>
      <th>Teléfono</th>
      <th>Tipo</th>
      <th>Estado</th>
			<th style="width:100px;">Acciones</th>
			</thead>
			<?php
			foreach($contacts as $contact):
				?>
				<tr>
				<td><span class="fw-bold"><?php echo $contact->name." ".$contact->lastname; ?></span></td>
				<td><?php echo $contact->email; ?></td>
        <td><?php echo $contact->phone; ?></td>
        <td>
          <?php 
          if($contact->type== 1){
            echo "<span class='badge bg-primary shadow-sm'>Cliente</span>";
          }else if($contact->type== 2){
            echo "<span class='badge bg-info shadow-sm'>Proveedor</span>";
          }
          ?>
        </td>
        <td class="text-center">
          <?php if($contact->is_active==1): ?>
            <span class="badge bg-success shadow-sm">Activo</span>
          <?php else: ?>
            <span class="badge bg-danger shadow-sm">Inactivo</span>
          <?php endif; ?>
        </td>
				<td class="text-center">
				<a href="index.php?view=contacts&opt=edit&id=<?php echo $contact->id;?>" class="btn btn-warning btn-sm text-white" title="Editar"><i class="bi bi-pencil-square"></i></a>
				<a id="delitem-<?php echo $contact->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
<script type="text/javascript">
    $("#delitem-<?php echo $contact->id?>").click(function(){
Swal.fire({
  title: "¿Estas seguro?",
  text: "Deseas eliminar este contacto. Se perderá su historial.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#6c757d',
  confirmButtonText: "Sí, Eliminar",
  cancelButtonText: "Cancelar"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "./?action=contacts&opt=del&id=<?=$contact->id;?>&type=<?=$type;?>";
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
        <i class="bi bi-info-circle me-2"></i> No hay contactos registrados.
      </div>
			<?php
		}
		?>
	</div>
</div>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):
  $type = isset($_GET["type"]) ? $_GET["type"] : 1;
  $type_label = ($type == 1) ? "Cliente" : "Proveedor";
?>
<section class="container-fluid text-start">
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Nuevo <?php echo $type_label; ?></h2>
    <p class="text-muted">Cree un nuevo registro de <?php echo strtolower($type_label); ?>.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=contacts&opt=add" role="form">
  <div class="row g-3">
    <div class="col-md-6 mb-3">
      <label for="name" class="form-label fw-bold">Nombre*</label>
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
    </div>
    <div class="col-md-6 mb-3">
      <label for="lastname" class="form-label fw-bold fw-bold">Apellido</label>
      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido">
    </div>
    <div class="col-md-6 mb-3">
      <label for="email" class="form-label fw-bold">Email</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="Correo electrónico">
    </div>
    <div class="col-md-6 mb-3">
      <label for="phone" class="form-label fw-bold">Teléfono</label>
      <input type="text" name="phone" class="form-control" id="phone" placeholder="Teléfono">
    </div>
    <div class="col-md-6 mb-3">
      <label for="address" class="form-label fw-bold">Dirección</label>
      <input type="text" name="address" class="form-control" id="address" placeholder="Dirección">
    </div>
    <div class="col-md-6 mb-3">
      <label for="company" class="form-label fw-bold">Empresa / Razón Social</label>
      <input type="text" name="company" class="form-control" id="company" placeholder="Empresa">
    </div>
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <div class="col-md-12 mb-3">
      <label for="description" class="form-label fw-bold">Notas / Descripción</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Notas adicionales"></textarea>
    </div>
  </div>
  <p class="text-muted small">* Campos obligatorios</p>
  <div class="mt-4">
    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Agregar <?php echo $type_label; ?></button>
    <a href="./?view=contacts&opt=all&type=<?php echo $type; ?>" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<section class="container-fluid text-start">
<?php 
$contact = ContactData::getById($_GET["id"]);
$type = $contact->type;
$type_label = ($type == 1) ? "Cliente" : "Proveedor";
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Editar <?php echo $type_label; ?></h2>
    <p class="text-muted">Actualice la información del <?php echo strtolower($type_label); ?>.</p>
</div>

<div class="row">
	<div class="col-md-12">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=contacts&opt=upd" role="form">
      <div class="row g-3">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label fw-bold">Nombre*</label>
          <input type="text" name="name" value="<?php echo $contact->name;?>" required class="form-control" id="name" placeholder="Nombre">
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastname" class="form-label fw-bold">Apellido</label>
          <input type="text" name="lastname" value="<?php echo $contact->lastname;?>" class="form-control" id="lastname" placeholder="Apellido">
        </div>
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label fw-bold">Email</label>
          <input type="email" name="email" value="<?php echo $contact->email;?>" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label fw-bold">Teléfono</label>
          <input type="text" name="phone" value="<?php echo $contact->phone;?>" class="form-control" id="phone" placeholder="Teléfono">
        </div>
        <div class="col-md-6 mb-3">
          <label for="address" class="form-label fw-bold">Dirección</label>
          <input type="text" name="address" value="<?php echo $contact->address;?>" class="form-control" id="address" placeholder="Dirección">
        </div>
        <div class="col-md-6 mb-3">
          <label for="company" class="form-label fw-bold">Empresa</label>
          <input type="text" name="company" value="<?php echo $contact->company;?>" class="form-control" id="company" placeholder="Empresa">
        </div>
          <input type="hidden" name="type" value="<?php echo $contact->type; ?>">
        <div class="col-md-6 mb-3">
          <label for="is_active" class="form-label fw-bold">Estado*</label>
          <select name="is_active" class="form-select select2" required>
            <option value="1" <?php if($contact->is_active==1){ echo "selected"; } ?>>Activo</option>
            <option value="0" <?php if($contact->is_active==0){ echo "selected"; } ?>>Inactivo</option>
          </select>
        </div>
        <div class="col-md-12 mb-3">
          <label for="description" class="form-label fw-bold">Notas / Descripción</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Notas adicionales"><?php echo $contact->description; ?></textarea>
        </div>
      </div>
      <p class="text-muted small">* Campos obligatorios</p>
      <div class="mt-4">
        <input type="hidden" name="id" value="<?php echo $contact->id;?>">
        <button type="submit" class="btn btn-success text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Actualizar <?php echo $type_label; ?></button>
        <a href="./?view=contacts&opt=all&type=<?php echo $type; ?>" class="btn btn-secondary me-2"><i class="bi bi-arrow-left-short me-1"></i> Cancelar</a>
      </div>
    </form>
	</div>
</div>
</div>
</div>
</section>
<?php endif; ?>
