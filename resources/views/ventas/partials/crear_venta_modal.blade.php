<div class="modal fade" id="crearVentaModal" tabindex="-1" role="dialog" aria-labelledby="crearVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearVentaLabel">Añadir Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="total-hidden-crear" name="total" value="0.00">

                    <h5>Cliente</h5>
                    <div class="form-group">
                        <label for="cliente-select-crear">Seleccionar Cliente</label>
                        <select id="cliente-select-crear" name="cliente_id" class="form-control" required>
                            <option value="" selected disabled>Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5>Productos</h5>
                    <div class="form-group">
                        <label for="producto-select-crear">Seleccionar Producto</label>
                        <select id="producto-select-crear" class="form-control">
                            <option value="" selected disabled>Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_por_unidad }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="productos-container-crear"></div>

                    <button type="button" class="btn btn-success" id="add-product-crear">Añadir Producto</button>

                    <h5>Total: <span id="total-venta-crear">0.00</span></h5>

                    <h5>Pago</h5>
                    <div class="form-group">
                        <label for="metodo_pago-crear">Método de Pago</label>
                        <select id="metodo_pago-crear" name="metodo_pago" class="form-control" required>
                            <option value="EFECTIVO">EFECTIVO 💵</option>
                            <option value="QR">TRANSFERENCIA QR 📱</option>
                        </select>
                    </div>

                    <div class="form-group" id="imagen_pago_container-crear" style="display: none;">
                        <label for="imagen_pago-crear">Imagen de Pago (QR)</label>
                        <input type="file" class="form-control" name="imagen_pago" id="imagen_pago-crear">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Venta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#crearVentaModal').on('shown.bs.modal', function () {
            $('#add-product-crear').on('click', function() {
                const productoSelect = $('#producto-select-crear').find(':selected');
                if (!productoSelect.val()) {
                    alert("Seleccione un producto válido.");
                    return;
                }

                const productoId = productoSelect.val();
                const productoNombre = productoSelect.text();
                const productoPrecio = productoSelect.data('precio');
                const productosContainer = $('#productos-container-crear');
                const index = productosContainer.children().length;

                productosContainer.append(`
                    <div class="form-group row product-row" data-precio="${productoPrecio}" data-producto-id="${productoId}">
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="${productoNombre}" readonly>
                            <input type="hidden" name="productos[${index}][producto_id]" value="${productoId}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="productos[${index}][peso_vendido]" class="form-control peso-input" placeholder="Peso en kg" step="0.01" min="0.01">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" value="${productoPrecio}" readonly>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-product">X</button>
                        </div>
                    </div>
                `);
                productoSelect.prop('disabled', true);
                calcularTotalCrear();
            });

            $('#productos-container-crear').on('input', '.peso-input', function() {
                calcularTotalCrear();
            });

            $('#productos-container-crear').on('click', '.remove-product', function() {
                $(this).closest('.product-row').remove();
                calcularTotalCrear();
            });

            $('#metodo_pago-crear').on('change', function() {
                $('#imagen_pago_container-crear').toggle($(this).val() === 'QR');
            });
        });

        function calcularTotalCrear() {
            let total = 0;
            $('#productos-container-crear .product-row').each(function() {
                const precio = parseFloat($(this).data('precio'));
                const peso = parseFloat($(this).find('.peso-input').val()) || 0;
                total += precio * peso;
            });
            $('#total-venta-crear').text(total.toFixed(2));
            $('#total-hidden-crear').val(total.toFixed(2));
        }
    });
</script>
