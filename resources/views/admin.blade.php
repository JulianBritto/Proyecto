@extends('layouts.app')

@section('title', 'Admin - Dashboard')

@section('content')
    <div class="text-center mb-4">
        <h1 class="mb-1">Panel Administrativo</h1>
        <p class="text-muted">Resumen rápido y accesos directos</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Categorías</h5>
                    <p class="card-text text-muted flex-grow-1">Crear y editar categorías y subcategorías.</p>
                    <a href="/categorias" class="btn btn-primary mt-3">Gestionar Categorías</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Solicitudes</h5>
                    <p class="card-text text-muted flex-grow-1">Crear nuevas solicitudes o revisar existentes.</p>
                    <a href="/solicitud" class="btn btn-success mt-3">Crear Solicitud</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text text-muted flex-grow-1">Ver y administrar usuarios (próximamente).</p>
                    <a href="#" class="btn btn-outline-secondary mt-3 disabled">Ir a Usuarios</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Actividad reciente</h5>
                    <p class="text-muted">Aquí aparecerán las últimas acciones del sistema.</p>
                    <small class="text-muted">(Más widgets pueden agregarse según necesidades.)</small>
                </div>
            </div>
        </div>
    </div>
@endsection
