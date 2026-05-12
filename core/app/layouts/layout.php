<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Mecharocket - CRM & Workshop Management">
    <meta name="author" content="Mecharocket">
    <title>Mecharocket - Taller Mechanico</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="vendors/datatables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/select2/select2.min.css">
    <script type="text/javascript" src="vendors/sweetalert/sweetalert2.all.min.js"></script>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"])):
      $curr_user = UserData::getById($_SESSION["user_id"]);
    ?>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
          <span class="sidebar-brand-full" style="font-size:22px; font-weight: bold;"><i class="bi bi-rocket-takeoff me-2"></i>MECHA<span class="text-primary">ROCKET</span></span>
          <span class="sidebar-brand-narrow">MR</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
          <a class="nav-link" href="./">
            <i class="nav-icon bi bi-speedometer2"></i> Inicio
          </a>
        </li>

        <li class="nav-title">TALLER</li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=operations&opt=all">
            <i class="nav-icon bi bi-tools"></i> Órdenes de Servicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=vehicles&opt=all">
            <i class="nav-icon bi bi-car-front"></i> Vehículos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=contacts&opt=all&type=1">
            <i class="nav-icon bi bi-people"></i> Clientes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=contacts&opt=all&type=2">
            <i class="nav-icon bi bi-truck"></i> Proveedores
          </a>
        </li>

        <li class="nav-title">FINANZAS Y STOCK</li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=sales&opt=all">
            <i class="nav-icon bi bi-cart-check"></i> Ventas Directas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=purchases&opt=all">
            <i class="nav-icon bi bi-box-arrow-in-down"></i> Compras / Entradas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=parts&opt=all">
            <i class="nav-icon bi bi-box-seam"></i> Catálogo Partes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=services&opt=all">
            <i class="nav-icon bi bi-briefcase"></i> Catálogo Servicios
          </a>
        </li>

        <li class="nav-title">CONFIGURACIÓN</li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=settings">
            <i class="nav-icon bi bi-gear-wide-connected"></i> Mi Taller (Branding)
          </a>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon bi bi-gear"></i> Catálogos Sistema
          </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="./?view=categories&opt=all"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Categorías Inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=jobcategories&opt=all"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Áreas de Trabajo</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=spaces&opt=all"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Espacios/Bahías</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=status&opt=all"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Estados de Orden</a></li>
          </ul>
        </li>

        <?php if($curr_user->type==1):?>
        <li class="nav-item">
          <a class="nav-link" href="./?view=users&opt=all">
            <i class="nav-icon bi bi-people-fill"></i> Usuarios
          </a>
        </li>
        <?php endif; ?>
      </ul>
      <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100">
      <header class="header header-sticky p-0 mb-4 shadow-sm">
        <div class="container-fluid border-bottom px-4">
          <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <i class="bi bi-list fs-3"></i>
          </button>
          
          <ul class="header-nav ms-auto">
          </ul>
          <ul class="header-nav">
            <li class="nav-item py-1">
              <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md bg-primary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold">
                  <?php echo substr($curr_user->name ?? '',0,1).substr($curr_user->lastname ?? '',0,1); ?>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0 shadow border-0">
                <div class="dropdown-header bg-light text-body-secondary fw-semibold rounded-top mb-2">Mi Cuenta</div>
                <div class="px-3 py-2">
                  <div class="fw-bold"><?php echo $curr_user->name." ".$curr_user->lastname; ?></div>
                  <div class="small text-muted">Administrador</div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="./?action=processlogout">
                  <i class="bi bi-box-arrow-right me-2 text-danger"></i> Cerrar sesión
                </a>
              </div>
            </li>
          </ul>
        </div>
      </header>
      <div class="body flex-grow-1">
        <div class="container-fluid px-4">
          <?php View::load("index"); ?>
        </div>
      </div>
      <footer class="footer px-4 border-top-0 bg-transparent text-muted small">
        <div>Mecharocket © 2026.</div>
        <div class="ms-auto">v1.5</div>
      </footer>
    </div>
    <?php else:?>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card shadow-lg border-0">
              <div class="card-body p-5">
                <div class="text-center mb-4">
                  <div class="display-1 text-primary mb-2"><i class="bi bi-rocket-takeoff-fill"></i></div>
                  <h1 class="h3 fw-bold">Mecharocket</h1>
                  <p class="text-muted">Gestión de Taller Mecánico</p>
                </div>
                <form method="post" action="./?action=access&opt=login">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Usuario</label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-muted"></i></span>
                      <input class="form-control border-start-0" name="email" required type="text" placeholder="Tu correo electrónico">
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label fw-bold">Contraseña</label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                      <input class="form-control border-start-0" name="password" required type="password" placeholder="Tu contraseña">
                    </div>
                  </div>
                  <div class="d-grid mb-3">
                    <button class="btn btn-primary btn-lg shadow-sm fw-bold" type="submit">Acceder</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="vendors/simplebar/js/simplebar.min.js"></script>
    <script src="vendors/datatables/datatables.min.js"></script>
    <script src="vendors/select2/select2.full.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".datatable").DataTable({
          "responsive": true,
          "language": {
            "url": "./vendors/datatables/esmx.json"
          }
        });

        // Initialize Select2 globally
        if ($.fn.select2) {
          $('.select2').each(function() {
            $(this).select2({
              width: '100%',
              dropdownParent: $(this).parent()
            });
          });
        }

        // SweetAlert from Session
        <?php if(isset($_SESSION["sweetalert"])): 
          $icon = isset($_SESSION["sweetalert_icon"]) ? $_SESSION["sweetalert_icon"] : 'info';
          $title = 'Notificación';
          if($icon == 'success') $title = '¡Éxito!';
          if($icon == 'error') $title = 'Error';
          if($icon == 'warning') $title = 'Atención';
        ?>
          Swal.fire({
            title: '<?php echo $title; ?>',
            text: '<?php echo $_SESSION["sweetalert"]; ?>',
            icon: '<?php echo $icon; ?>',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonColor: '#5856d6'
          });
          <?php 
            unset($_SESSION["sweetalert"]); 
            unset($_SESSION["sweetalert_icon"]); 
          ?>
        <?php endif; ?>
      });
    </script>
  </body>
</html>