<div class="modal fade" id="editarVentaModal{{ $venta->id }}" tabindex="-1" role="dialog" aria-labelledby="editarVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarVentaLabel">Editar Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="total-hidden-editar-{{ $venta->id }}" name="total" value="{{ $venta->total }}">

                    <h5>Cliente</h5>
                    <div class="form-group">
                        <label for="cliente-select-editar-{{ $venta->id }}">Seleccionar Cliente</label>
                        <select id="cliente-select-editar-{{ $venta->id }}" name="cliente_id" class="form-control" required>
                            <option value="" disabled>Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5>Productos</h5>
                    <div class="form-group">
                        <label for="producto-select-editar-{{ $venta->id }}">Seleccionar Producto</label>
                        <select id="producto-select-editar-{{ $venta->id }}" class="form-control">
                            <option value="" selected disabled>Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_por_unidad }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="productos-container-editar-{{ $venta->id }}">
                        @foreach($venta->detalles as $detalle)
                            <div class="form-group row product-row" data-precio="{{ $detalle->producto->precio_por_unidad }}" data-producto-id="{{ $detalle->producto_id }}">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $detalle->producto->nombre }}" readonly>
                                    <input type="hidden" name="productos[{{ $loop->index }}][producto_id]" value="{{ $detalle->producto_id }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="productos[{{ $loop->index }}][peso_vendido]" class="form-control peso-input" value="{{ $detalle->peso_vendido }}" placeholder="Peso en kg" step="0.01" min="0.01">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{ $detalle->producto->precio_por_unidad }}" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-product">X</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-success" id="add-product-editar-{{ $venta->id }}">Añadir Producto</button>

                    <h5>Total: <span id="total-venta-editar-{{ $venta->id }}">{{ $venta->total }}</span></h5>

                    <h5>Pago</h5>
                    <div class="form-group">
                        <label for="metodo_pago-editar-{{ $venta->id }}">Método de Pago</label>
                        <select id="metodo_pago-editar-{{ $venta->id }}" name="metodo_pago" class="form-control" required>
                            <option value="EFECTIVO" {{ $venta->pago->metodo_pago === 'EFECTIVO' ? 'selected' : '' }}>EFECTIVO 💵</option>
                            <option value="QR" {{ $venta->pago->metodo_pago === 'QR' ? 'selected' : '' }}>TRANSFERENCIA QR 📱</option>
                        </select>
                    </div>

                    <div class="form-group" id="imagen_pago_container-editar-{{ $venta->id }}" style="{{ $venta->pago->metodo_pago === 'QR' ? '' : 'display:none;' }}">
                        <label for="imagen_pago-editar-{{ $venta->id }}">Imagen de Pago (QR)</label>
                        <input type="file" class="form-control" name="imagen_pago" id="imagen_pago-editar-{{ $venta->id }}">
                        @if($venta->pago->imagen_pago)
                            <img src="{{ $venta->pago->imagen_pago }}" alt="Imagen Pago" style="width: 100px;">
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editarVentaModal{{ $venta->id }}').on('shown.bs.modal', function () {
            $('#add-product-editar-{{ $venta->id }}').on('click', function() {
                const productoSelect = $('#producto-select-editar-{{ $venta->id }}').find(':selected');
                if (!productoSelect.val()) {
                    alert("Seleccione un producto válido.");
                    return;
                }

                const productoId = productoSelect.val();
                const productoNombre = productoSelect.text();
                const productoPrecio = productoSelect.data('precio');
                const productosContainer = $('#productos-container-editar-{{ $venta->id }}');
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
                calcularTotalEditar();
            });

            $('#productos-container-editar-{{ $venta->id }}').on('input', '.peso-input', function() {
                calcularTotalEditar();
            });

            $('#productos-container-editar-{{ $venta->id }}').on('click', '.remove-product', function() {
                $(this).closest('.product-row').remove();
                calcularTotalEditar();
            });

            $('#metodo_pago-editar-{{ $venta->id }}').on('change', function() {
                $('#imagen_pago_container-editar-{{ $venta->id }}').toggle($(this).val() === 'QR');
            });
        });

        function calcularTotalEditar() {
            let total = 0;
            $('#productos-container-editar-{{ $venta->id }} .product-row').each(function() {
                const precio = parseFloat($(this).data('precio'));
                const peso = parseFloat($(this).find('.peso-input').val()) || 0;
                total += precio * peso;
            });
            $('#total-venta-editar-{{ $venta->id }}').text(total.toFixed(2));
            $('#total-hidden-editar-{{ $venta->id }}').val(total.toFixed(2));
        }
    });
</script>
