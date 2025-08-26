@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <h2 class="text-center mb-4">Categorías y Subcategorías</h2>

    <!-- Botón para abrir modal -->
    <div class="text-center mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            ➕ Crear Categoría / Subcategorías
        </button>
    </div>

    <!-- Formulario de selección -->
    <form>
        <div class="mb-4">
            <label for="categoria_id" class="form-label fw-bold">Categoría</label>
            <select id="categoria_id" name="categoria_id" class="form-select">
                <option value="">-- Seleccione una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
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
                    <button type="button" class="btn btn-success" id="btnGuardarCategoria">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para dinámicas --}}
    <script>
        // Agregar más subcategorías
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

        // Cargar subcategorías según la categoría seleccionada
        document.getElementById('categoria_id').addEventListener('change', function () {
            let categoriaId = this.value;
            let subcategoriaSelect = document.getElementById('subcategoria_id');

            subcategoriaSelect.innerHTML = '<option value="">-- Seleccione una subcategoría --</option>';
            subcategoriaSelect.disabled = true;

            if (categoriaId) {
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
                alert('Categoría y subcategorías creadas correctamente');
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Ocurrió un error al guardar');
            });
        });
    </script>
@endsection