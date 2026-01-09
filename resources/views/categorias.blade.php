@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <h2 class="text-center mb-4">Categorías y Subcategorías</h2>

    <!-- Contenedor de Toast (notificación en esquina superior derecha) -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2000">
        <div id="toastSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto" id="toastTitle">✅ Éxito</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body" id="toastBody">
                La acción se ha realizado correctamente.
            </div>
        </div>
    </div>

    <!-- Botón para abrir modal -->
    <div class="text-center mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            ➕ Crear Categoría / Subcategorías
        </button>
    </div>

    <!-- Formulario de selección -->
    <form>
        <div class="mb-4 d-flex align-items-center gap-2">
            <label for="categoria_id" class="form-label fw-bold">Categoría</label>
            <select id="categoria_id" name="categoria_id" class="form-select">
                <option value="">-- Seleccione una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>

            <!-- Botón Editar (oculto hasta seleccionar categoría) -->
            <button type="button" id="btnEditarCategoria" class="btn btn-warning d-none"
                    data-bs-toggle="modal" data-bs-target="#modalEditar">
                ✏️ Editar
            </button>
        </div>

        <div class="mb-4">
            <label for="subcategoria_id" class="form-label fw-bold">Subcategoría</label>
            <select id="subcategoria_id" name="subcategoria_id" class="form-select" disabled>
                <option value="">-- Seleccione una subcategoría --</option>
            </select>
        </div>
    </form>

    <!-- Modal para crear categoría y subcategorías -->
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCrearLabel">Crear Categoría / Subcategorías</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formCrearCategoria">
                        <div class="mb-3">
                            <label for="nueva_categoria" class="form-label fw-bold">Nueva Categoría</label>
                            <input type="text" class="form-control" id="nueva_categoria" name="nueva_categoria" placeholder="Ej: Hardware">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subcategorías</label>
                            <div id="subcategorias_container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="subcategorias[]" placeholder="Ej: Teclados">
                                    <button type="button" class="btn btn-outline-danger btnRemoveSub">✖</button>
                                </div>
                            </div>
                            <button type="button" id="btnAddSubcategoria" class="btn btn-outline-success mt-2">
                                ➕ Agregar otra subcategoría
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnConfirmarModal">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="modalConfirmarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalConfirmarLabel">Confirmar creación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold">¿Está seguro de crear la nueva categoría y sus subcategorías?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnGuardarCategoria">Sí, Crear</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoría/Subcategorías -->
    <!-- Modal Confirmar Edición (separado para evitar problemas con backdrops) -->
    <div class="modal fade" id="modalConfirmarEditar" tabindex="-1" aria-labelledby="modalConfirmarEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalConfirmarEditarLabel">Confirmar edición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold">¿Está seguro que desea guardar los cambios de la categoría?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnConfirmarEditar">Sí, guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Categoría / Subcategorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formEditarCategoria">
                        <input type="hidden" id="edit_categoria_id">

                        <div class="mb-3">
                            <label for="edit_categoria_nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="edit_categoria_nombre">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subcategorías</label>
                            <div id="edit_subcategorias_container"></div>

                            <button type="button" id="btnAddSubEditar" class="btn btn-outline-success mt-2">
                                ➕ Agregar subcategoría
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" id="btnEliminarCategoria">🗑 Eliminar Categoría</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="btnGuardarEdicion">💾 Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold">⚠️ ¿Seguro que deseas eliminar esta categoría y todas sus subcategorías?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">🗑 Eliminar Categoría</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        // ================== CREAR ==================

        // Agregar más subcategorías (modal crear)
        document.getElementById('btnAddSubcategoria').addEventListener('click', function () {
            let container = document.getElementById('subcategorias_container');
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
                <input type="text" class="form-control" name="subcategorias[]" placeholder="Ej: Monitores">
                <button type="button" class="btn btn-outline-danger btnRemoveSub">✖</button>
            `;
            container.appendChild(div);
        });

        // Eliminar subcategoría
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btnRemoveSub')) {
                e.target.parentElement.remove();
            }
        });

        // Cargar subcategorías según categoría seleccionada
        document.getElementById('categoria_id').addEventListener('change', function () {
            let categoriaId = this.value;
            let subcategoriaSelect = document.getElementById('subcategoria_id');
            let btnEditar = document.getElementById('btnEditarCategoria');

            subcategoriaSelect.innerHTML = '<option value="">-- Seleccione una subcategoría --</option>';
            subcategoriaSelect.disabled = true;
            btnEditar.classList.add('d-none');

            if (categoriaId) {
                btnEditar.classList.remove('d-none');
                fetch('/categorias/' + categoriaId + '/subcategorias')
                    .then(response => response.json())
                    .then(data => {
                        subcategoriaSelect.disabled = false;
                        data.forEach(sub => {
                            let option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.nombre;
                            subcategoriaSelect.appendChild(option);
                        });
                    });
            }
        });

        // Mostrar modal de confirmación
        document.getElementById('btnConfirmarModal').addEventListener('click', function () {
            let modalConfirmar = new bootstrap.Modal(document.getElementById('modalConfirmar'));
            modalConfirmar.show();
        });

        // Guardar nueva categoría/subcategorías (AJAX)
        document.getElementById('btnGuardarCategoria').addEventListener('click', function () {
            let categoria = document.getElementById('nueva_categoria').value;
            let subInputs = document.querySelectorAll('input[name="subcategorias[]"]');
            let subcategorias = [];
            subInputs.forEach(input => {
                if (input.value.trim() !== '') subcategorias.push(input.value.trim());
            });

            fetch('/categorias/crear', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    categoria: categoria,
                    subcategorias: subcategorias
                })
            })
            .then(response => response.json())
            .then(data => {
                bootstrap.Modal.getInstance(document.getElementById('modalCrear')).hide();
                bootstrap.Modal.getInstance(document.getElementById('modalConfirmar')).hide();

                let toastEl = document.getElementById('toastSuccess');
                toastEl.querySelector('#toastTitle').textContent = '✅ Categoría creada';
                toastEl.querySelector('#toastBody').textContent = 'La categoría y sus subcategorías se han creado correctamente.';
                toastEl.querySelector('.toast-header').className = 'toast-header bg-success text-white';
                let toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();

                setTimeout(() => location.reload(), 3500);
            })
            .catch(error => console.error(error));
        });

        // ================== EDITAR ==================

        // Cargar datos en el modal editar
        document.getElementById('btnEditarCategoria').addEventListener('click', function () {
            let categoriaId = document.getElementById('categoria_id').value;

            fetch('/categorias/' + categoriaId + '/detalles')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_categoria_id').value = data.id;
                    document.getElementById('edit_categoria_nombre').value = data.nombre;

                    let container = document.getElementById('edit_subcategorias_container');
                    container.innerHTML = '';
                    data.subcategorias.forEach(sub => {
                        let div = document.createElement('div');
                        div.classList.add('input-group', 'mb-2');
                        div.innerHTML = `
                            <input type="text" class="form-control" value="${sub.nombre}" data-id="${sub.id}">
                            <button type="button" class="btn btn-outline-danger btnRemoveSubEdit">✖</button>
                        `;
                        container.appendChild(div);
                    });
                });
        });

        // Agregar subcategoría en edición
        document.getElementById('btnAddSubEditar').addEventListener('click', function () {
            let container = document.getElementById('edit_subcategorias_container');
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
                <input type="text" class="form-control" value="">
                <button type="button" class="btn btn-outline-danger btnRemoveSubEdit">✖</button>
            `;
            container.appendChild(div);
        });

        // Eliminar subcategoría del modal editar
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btnRemoveSubEdit')) {
                e.target.parentElement.remove();
            }
        });

        // Guardar cambios en edición: primero ocultar modal editar y abrir modal de confirmación
        let reopenEditOnClose = false;
        document.getElementById('btnGuardarEdicion').addEventListener('click', function () {
            reopenEditOnClose = true;
            // ocultar modal editar para evitar que queden múltiples backdrops
            let editarModalEl = document.getElementById('modalEditar');
            let editarModalInst = bootstrap.Modal.getInstance(editarModalEl);
            if (editarModalInst) editarModalInst.hide();

            // mostrar modal de confirmación
            let modalConfirmarEdit = new bootstrap.Modal(document.getElementById('modalConfirmarEditar'));
            modalConfirmarEdit.show();
        });

        // Al confirmar la edición, realizar la petición PUT
        document.getElementById('btnConfirmarEditar').addEventListener('click', function () {
            reopenEditOnClose = false;
            let categoriaId = document.getElementById('edit_categoria_id').value;
            let categoriaNombre = document.getElementById('edit_categoria_nombre').value;

            let subInputs = document.querySelectorAll('#edit_subcategorias_container input');
            let subcategorias = [];
            subInputs.forEach(input => {
                subcategorias.push({
                    id: input.dataset.id || null,
                    nombre: input.value.trim()
                });
            });

            fetch('/categorias/' + categoriaId + '/editar', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nombre: categoriaNombre,
                    subcategorias: subcategorias
                })
            })
            .then(res => res.json())
            .then(data => {
                // Cerrar modal de edición y confirmación si están abiertos
                let editarModal = document.getElementById('modalEditar');
                if (bootstrap.Modal.getInstance(editarModal)) bootstrap.Modal.getInstance(editarModal).hide();
                let confirmarModal = document.getElementById('modalConfirmarEditar');
                if (bootstrap.Modal.getInstance(confirmarModal)) bootstrap.Modal.getInstance(confirmarModal).hide();

                let toastEl = document.getElementById('toastSuccess');
                // si se eliminaron subcategorías, mostrar alerta en rojo y mencionar nombres
                if (data.deleted_subcategorias && data.deleted_subcategorias.length > 0) {
                    const names = data.deleted_subcategorias.join(', ');
                    toastEl.querySelector('#toastTitle').textContent = '🗑 Subcategoría(s) eliminada(s)';
                    toastEl.querySelector('#toastBody').textContent = 'Se eliminaron: ' + names + '.';
                    // aplicar estilo rojo
                    toastEl.querySelector('.toast-header').className = 'toast-header bg-danger text-white';
                } else {
                    toastEl.querySelector('#toastTitle').textContent = '✅ Categoría actualizada';
                    toastEl.querySelector('#toastBody').textContent = 'La categoría se ha actualizado correctamente.';
                    toastEl.querySelector('.toast-header').className = 'toast-header bg-success text-white';
                }
                let toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
                setTimeout(() => location.reload(), 3500);
            })
            .catch(err => console.error(err));
        });

        // Si se cierra el modal de confirmación sin confirmar, reabrir el modal de edición
        document.getElementById('modalConfirmarEditar').addEventListener('hidden.bs.modal', function () {
            if (reopenEditOnClose) {
                let editarModal = new bootstrap.Modal(document.getElementById('modalEditar'));
                editarModal.show();
                reopenEditOnClose = false;
            }
        });

        // Eliminar categoría: abrir modal de confirmación en lugar de confirm()
        document.getElementById('btnEliminarCategoria').addEventListener('click', function () {
            // ocultar modal editar para evitar backdrops dobles
            let editarModalEl = document.getElementById('modalEditar');
            let editarModalInst = bootstrap.Modal.getInstance(editarModalEl);
            if (editarModalInst) editarModalInst.hide();

            let modalEliminar = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
            modalEliminar.show();
        });

        // Confirmar eliminación: realizar DELETE
        document.getElementById('btnConfirmarEliminar').addEventListener('click', function () {
            let categoriaId = document.getElementById('edit_categoria_id').value;

            fetch('/categorias/' + categoriaId + '/eliminar', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                // ocultar modal eliminar si está abierto
                let confirmarModal = document.getElementById('modalConfirmarEliminar');
                if (bootstrap.Modal.getInstance(confirmarModal)) bootstrap.Modal.getInstance(confirmarModal).hide();

                let toastEl = document.getElementById('toastSuccess');
                // para borrado de categoría mostramos mensaje en rojo
                toastEl.querySelector('#toastTitle').textContent = '🗑 Categoría eliminada';
                toastEl.querySelector('#toastBody').textContent = 'La categoría y sus subcategorías han sido eliminadas.';
                toastEl.querySelector('.toast-header').className = 'toast-header bg-danger text-white';
                let toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
                setTimeout(() => location.reload(), 1500);
            })
            .catch(err => console.error(err));
        });

        // Si se abre la página con ?categoria_id=xx, seleccionar y abrir el modal editar
        (function autoOpenEditFromQuery(){
            try {
                const params = new URLSearchParams(window.location.search);
                const preCat = params.get('categoria_id');
                if (preCat) {
                    const sel = document.getElementById('categoria_id');
                    if (sel) {
                        sel.value = preCat;
                        sel.dispatchEvent(new Event('change'));
                        setTimeout(() => {
                            const btn = document.getElementById('btnEditarCategoria');
                            if (btn) btn.click();
                        }, 300);
                    }
                }
            } catch (e) { console.error(e); }
        })();
    </script>
@endsection