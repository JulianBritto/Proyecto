<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Solicitud</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilo para el mensaje flotante */
        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px; /* cambiado a la derecha */
            z-index: 1055;
            opacity: 1;
            transition: opacity 0.8s ease-out;
        }
        .alert-hidden {
            opacity: 0;
        }
    </style>
</head>
<body class="bg-light">

    {{-- Mensaje flotante de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-floating shadow" id="alerta">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Registro de Solicitud</h3>
                    </div>

                    <div class="card-body p-4">

                        {{-- Errores de validación --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulario --}}
                        <form action="{{ route('solicitud.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Escribe tu nombre" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asunto</label>
                                <input type="text" name="asunto" class="form-control" value="{{ old('asunto') }}" placeholder="Motivo de la solicitud" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" placeholder="Escribe los detalles de tu solicitud..." required>{{ old('descripcion') }}</textarea>
                            </div>

                            {{-- Campo Categoría --}}
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select name="categoria" class="form-select" required>
                                    <option value="">-- Selecciona una categoría --</option>
                                    <option value="Soporte" {{ old('categoria') == 'Soporte' ? 'selected' : '' }}>Soporte</option>
                                    <option value="Desarrollo" {{ old('categoria') == 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                                    <option value="Infraestructura" {{ old('categoria') == 'Infraestructura' ? 'selected' : '' }}>Infraestructura</option>
                                    <option value="Administrativa" {{ old('categoria') == 'Administrativa' ? 'selected' : '' }}>Administrativa</option>
                                </select>
                            </div>

                            {{-- Campo Subcategoría --}}
                            <div class="mb-3">
                                <label class="form-label">Subcategoría</label>
                                <select name="subcategoria" class="form-select" required>
                                    <option value="">-- Selecciona una subcategoría --</option>
                                    <option value="Errores" {{ old('subcategoria') == 'Errores' ? 'selected' : '' }}>Errores</option>
                                    <option value="Mejoras" {{ old('subcategoria') == 'Mejoras' ? 'selected' : '' }}>Mejoras</option>
                                    <option value="Consultas" {{ old('subcategoria') == 'Consultas' ? 'selected' : '' }}>Consultas</option>
                                    <option value="Mantenimiento" {{ old('subcategoria') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Enviar Solicitud
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script para desaparecer el mensaje --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alerta = document.getElementById("alerta");
            if (alerta) {
                setTimeout(() => {
                    alerta.classList.add("alert-hidden");
                    setTimeout(() => alerta.remove(), 800); // se elimina después del fade
                }, 3000); // espera 3 segundos antes de desaparecer
            }
        });
    </script>
</body>
</html>