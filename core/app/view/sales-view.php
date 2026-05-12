<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"): ?>
<section class="container-fluid text-start">
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h2 class="fw-bold text-dark mb-1">Ventas Directas</h2>
        <p class="text-muted">Gestione las ventas de refacciones y materiales realizadas fuera de una orden de servicio.</p>
    </div>
</div>

<div class="mb-4">
    <a href="./?view=sales&opt=new" class="btn btn-primary fw-bold px-3 shadow-sm"><i class="bi bi-cart-plus-fill me-2"></i> Nueva Venta Directa</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <?php 
                $sales = OperationData::getAllByQ("where kind=3 order by created_at desc");
                if(count($sales) > 0):
                ?>
                <table class="table table-bordered datatable align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sales as $b): 
                            $c = $b->getContact();
                        ?>
                        <tr>
                            <td class="fw-bold">VE-<?php echo str_pad($b->id, 5, "0", STR_PAD_LEFT); ?></td>
                            <td><?php echo $c ? $c->name." ".$c->lastname : "Cliente Mostrador"; ?></td>
                            <td><?php echo $b->created_at; ?></td>
                            <td class="fw-bold text-success">$<?php echo number_format($b->total, 2); ?></td>
                            <td class="text-center">
                                <a href="./report/order-pdf.php?id=<?php echo $b->id; ?>" target="_blank" class="btn btn-outline-dark btn-sm" title="Imprimir"><i class="bi bi-printer"></i></a>
                                <a id="delsale-<?php echo $b->id; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                <script type="text/javascript">
                                    $("#delsale-<?php echo $b->id; ?>").click(function(){
                                        Swal.fire({
                                            title: "¿Estas seguro?",
                                            text: "Deseas eliminar esta venta. El stock será devuelto.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: "Sí, Eliminar",
                                            cancelButtonText: "Cancelar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location = "./?action=sales&opt=del&id=<?php echo $b->id; ?>";
                                            }
                                        });
                                    });
                                </script>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-info mb-0">No hay ventas registradas.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"): ?>
<section class="container-fluid text-start">
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Nueva Venta Directa</h2>
    <p class="text-muted">Procese una venta rápida de mostrador para refacciones en stock.</p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="post" action="./?action=sales&opt=add" id="saleForm">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cliente*</label>
                            <select name="contact_id" class="form-select select2" required>
                                <option value="">-- CLIENTE MOSTRADOR --</option>
                                <?php foreach(ContactData::getAllBy("type", 1) as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name." ".$c->lastname; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-start">Descripción / Referencia</label>
                            <input type="text" name="description" class="form-control" placeholder="Ej. Venta de aceite y filtros">
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle" id="itemsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50%;">Refacción</th>
                                    <th style="width: 10%;">Cant.</th>
                                    <th style="width: 15%;">Precio Unit. (Venta)</th>
                                    <th style="width: 15%;">Subtotal</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows added by JS -->
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL VENTA:</td>
                                    <td class="fw-bold text-success fs-5" id="grandTotal">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-dark btn-sm fw-bold" id="addRow"><i class="bi bi-plus-lg"></i> Agregar Refacción</button>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary text-white fw-bold"><i class="bi bi-check-lg me-1"></i> Procesar Venta</button>
                        <a href="./?view=sales&opt=all" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

<script>
$(document).ready(function(){
    let rowCount = 0;

    function addRow() {
        rowCount++;
        let row = `
        <tr id="row-${rowCount}">
            <td>
                <input type="hidden" name="type[]" value="part">
                <select name="item_id[]" class="form-select form-select-sm item-select select2" id="select-${rowCount}" required>
                    <option value="">-- SELECCIONE REFACCIÓN --</option>
                    <?php foreach(PartData::getAll() as $p): ?>
                        <option value="<?php echo $p->id; ?>" data-price="<?php echo $p->price_out; ?>" data-stock="<?php echo $p->quantity; ?>"><?php echo $p->name; ?> (Stock: <?php echo $p->quantity; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" name="quantity[]" class="form-control form-control-sm qty-input" value="1" min="1" required></td>
            <td><input type="number" step="0.01" name="price[]" class="form-control form-control-sm price-input" value="0" required></td>
            <td class="fw-bold subtotal">$0.00</td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row" data-row="${rowCount}"><i class="bi bi-trash"></i></button></td>
        </tr>`;
        $("#itemsTable tbody").append(row);
        if ($.fn.select2) {
            $("#select-"+rowCount).select2({ width: '100%' });
        }
    }

    $("#addRow").click(function(){ addRow(); });

    $(document).on("change", ".item-select", function(){
        let price = $(this).find(':selected').data('price') || 0;
        $(this).closest("tr").find(".price-input").val(price);
        calculate();
    });

    $(document).on("input", ".qty-input, .price-input", function(){ calculate(); });

    $(document).on("click", ".remove-row", function(){
        let id = $(this).data("row");
        $("#row-"+id).remove();
        calculate();
    });

    function calculate() {
        let grandTotal = 0;
        $("#itemsTable tbody tr").each(function(){
            let qty = $(this).find(".qty-input").val() || 0;
            let price = $(this).find(".price-input").val() || 0;
            let subtotal = qty * price;
            $(this).find(".subtotal").text("$" + subtotal.toFixed(2));
            grandTotal += subtotal;
        });
        $("#grandTotal").text("$" + grandTotal.toFixed(2));
    }

    addRow();
});
</script>
<?php endif; ?>
