<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            font-weight: bold;
            color: #0d6efd;
        }
        table thead {
            background-color: #0d6efd;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #f1f5ff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4">
        <h2 class="mb-4 text-center">📋 Solicitudes de Clientes</h2>

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
                            <th>Fecha</th>
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
                                <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</body>
</html>