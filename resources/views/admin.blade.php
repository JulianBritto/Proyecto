@extends('layouts.app')

@section('title', 'Panel Administrativo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="text-center mb-5">
            <i class="fas fa-tachometer-alt fa-3x text-primary mb-3"></i>
            <h1 class="display-6 fw-bold text-primary mb-2">Panel Administrativo</h1>
            <p class="lead text-muted">Resumen rápido y accesos directos para gestionar el sistema</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-shadow">
                    <div class="card-body text-center d-flex flex-column">
                        <i class="fas fa-tags fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Categorías</h5>
                        <p class="card-text text-muted flex-grow-1">Crear y editar categorías y subcategorías del sistema.</p>
                        <a href="/categorias" class="btn btn-primary btn-lg mt-3">
                            <i class="fas fa-cog me-2"></i>Gestionar Categorías
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-shadow">
                    <div class="card-body text-center d-flex flex-column">
                        <i class="fas fa-clipboard-list fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Solicitudes</h5>
                        <p class="card-text text-muted flex-grow-1">Crear nuevas solicitudes o revisar las existentes.</p>
                        <a href="/solicitud" class="btn btn-success btn-lg mt-3">
                            <i class="fas fa-plus me-2"></i>Crear Solicitud
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-shadow">
                    <div class="card-body text-center d-flex flex-column">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h5 class="card-title fw-bold">Usuarios</h5>
                        <p class="card-text text-muted flex-grow-1">Ver y administrar usuarios del sistema.</p>
                        <a href="/solicitudes_clientes" class="btn btn-info btn-lg mt-3">
                            <i class="fas fa-list me-2"></i>Ver Solicitudes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Estadísticas del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="p-3">
                                    <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                                    <h4 class="fw-bold text-warning">{{ \App\Models\Solicitud::count() }}</h4>
                                    <p class="text-muted mb-0">Total Solicitudes</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <i class="fas fa-folder fa-2x text-info mb-2"></i>
                                    <h4 class="fw-bold text-info">{{ \App\Models\Categoria::count() }}</h4>
                                    <p class="text-muted mb-0">Categorías</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <i class="fas fa-list fa-2x text-success mb-2"></i>
                                    <h4 class="fw-bold text-success">{{ \App\Models\Subcategoria::count() }}</h4>
                                    <p class="text-muted mb-0">Subcategorías</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                    <h4 class="fw-bold text-primary">{{ \App\Models\User::count() }}</h4>
                                    <p class="text-muted mb-0">Usuarios</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-history me-2 text-secondary"></i>Actividad Reciente</h5>
                        <p class="text-muted">Aquí aparecerán las últimas acciones y cambios en el sistema.</p>
                        <div class="alert alert-light">
                            <small class="text-muted">Funcionalidad de logs próximamente disponible.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}
</style>
@endsection
