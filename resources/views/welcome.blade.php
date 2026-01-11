@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card text-center">
            <div class="card-body py-5">
                <div class="mb-4">
                    <i class="fas fa-handshake fa-4x text-primary mb-3"></i>
                    <h1 class="display-5 fw-bold text-primary mb-3">Bienvenido al Sistema de Solicitudes Empresarial</h1>
                    <p class="lead text-muted mb-4">Plataforma integral para gestionar solicitudes, categorías y procesos administrativos de manera eficiente y profesional.</p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-plus-circle fa-2x text-success mb-2"></i>
                                <h5 class="card-title">Crear Solicitud</h5>
                                <p class="card-text small">Envía nuevas solicitudes con categorías específicas.</p>
                                <a href="/solicitud" class="btn btn-success">Crear Ahora</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-list fa-2x text-info mb-2"></i>
                                <h5 class="card-title">Ver Solicitudes</h5>
                                <p class="card-text small">Consulta el estado de tus solicitudes enviadas.</p>
                                <a href="/solicitudes_clientes" class="btn btn-info">Ver Lista</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-cogs fa-2x text-warning mb-2"></i>
                                <h5 class="card-title">Administración</h5>
                                <p class="card-text small">Acceso al panel de administración del sistema.</p>
                                <a href="/admin" class="btn btn-warning">Acceder</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border">
                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>¿Necesitas ayuda?</h6>
                    <p class="mb-0">Si tienes alguna duda sobre el uso del sistema, contacta al administrador o consulta la documentación disponible.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
