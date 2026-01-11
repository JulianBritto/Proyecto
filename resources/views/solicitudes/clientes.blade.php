@extends('layouts.app')

@section('title', 'Solicitudes de Clientes')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="text-center mb-5">
            <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
            <h1 class="display-6 fw-bold text-primary mb-2">Solicitudes de Clientes</h1>
            <p class="lead text-muted">Gestión completa de solicitudes enviadas por los usuarios</p>
        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list fa-2x me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">Lista de Solicitudes</h4>
                        <small>Administra y responde a las solicitudes de los clientes</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">

        @if($solicitudes->isEmpty())
            <div class="alert alert-info text-center">
                No hay solicitudes registradas.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Asunto</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Subcategoría</th>
                            <th>Fecha creación</th>
                            <!-- <th>Último cambio realizado</th>-->
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $index => $solicitud)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $solicitud->nombre }}</td>
                            <td>{{ $solicitud->email }}</td>
                            <td>{{ $solicitud->asunto }}</td>
                            <td>{{ $solicitud->descripcion }}</td>
                            <td>{{ $solicitud->categoria ?? '---' }}</td>
                            <td>{{ $solicitud->subcategoria ?? '---' }}</td>
                            <td>{{ $solicitud->created_at->timezone('America/Bogota')->format('d/m/Y H:i') }}</td>
                            <!-- <td>
                                @if($solicitud->updated_at && $solicitud->updated_at != $solicitud->created_at)
                                    {{ $solicitud->updated_at->timezone('America/Bogota')->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Sin cambios</span>
                                @endif
                            </td>-->
                            
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $solicitud->id }}">
                                        ✏️ Editar
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $solicitud->id }}">
                                        🗑️ Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de Edición -->
                        <div class="modal fade" id="editModal{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form id="form_update_{{ $solicitud->id }}" action="{{ route('solicitudes.update', $solicitud->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Solicitud</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre" value="{{ $solicitud->nombre }}" required>
                                            
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $solicitud->email }}" required>
                                            
                                            <label>Asunto</label>
                                            <input type="text" name="asunto" value="{{ $solicitud->asunto }}" required>
                                            
                                            <label>Descripción</label>
                                            <textarea name="descripcion" rows="3" required>{{ $solicitud->descripcion }}</textarea>
                                            
                                            <label>Categoría</label>
                                            <select name="categoria" class="categoria-select" data-id="{{ $solicitud->id }}">
                                                <option value="">Seleccione una categoría</option>
                                                @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->nombre }}" {{ $solicitud->categoria == $categoria->nombre ? 'selected' : '' }}>
                                                        {{ $categoria->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            <label>Subcategoría</label>
                                            <select name="subcategoria" id="subcategoria_{{ $solicitud->id }}" class="subcategoria-select" data-id="{{ $solicitud->id }}">
                                                <option value="">Seleccione una subcategoría</option>
                                                @php
                                                    $catSeleccionada = $categorias->where('nombre', $solicitud->categoria)->first();
                                                @endphp
                                                @if($catSeleccionada)
                                                    @foreach($catSeleccionada->subcategorias as $sub)
                                                        <option value="{{ $sub->nombre }}" {{ $solicitud->subcategoria == $sub->nombre ? 'selected' : '' }}>
                                                            {{ $sub->nombre }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal_{{ $solicitud->id }}">
                                                Guardar cambios
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Confirmar Guardar -->
                        <div class="modal fade" id="confirmUpdateModal_{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar cambios</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que quieres guardar los cambios realizados?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('form_update_{{ $solicitud->id }}').submit();">
                                            Sí, guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Confirmar Eliminar -->
                        <div class="modal fade" id="deleteModal{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">⚠️ Confirmar eliminación</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que deseas eliminar la solicitud de <strong>{{ $solicitud->nombre }}</strong>?  
                                        <br><small class="text-muted">Esta acción no se puede deshacer.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('solicitudes.destroy', $solicitud->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Toasts -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">✅ {{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastDeleted" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">🗑️ {{ session('deleted') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const categorias = @json($categorias);
    document.querySelectorAll('.categoria-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const subSelect = document.getElementById('subcategoria_' + id);
            const categoriaSeleccionada = categorias.find(cat => cat.nombre === this.value);
            subSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
            if (categoriaSeleccionada && categoriaSeleccionada.subcategorias) {
                categoriaSeleccionada.subcategorias.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.nombre;
                    option.textContent = sub.nombre;
                    subSelect.appendChild(option);
                });
            }
        });
    });
    @if(session('success'))
        new bootstrap.Toast(document.getElementById('toastSuccess')).show();
    @endif
    @if(session('deleted'))
        new bootstrap.Toast(document.getElementById('toastDeleted')).show();
    @endif
</script>
@endsection
