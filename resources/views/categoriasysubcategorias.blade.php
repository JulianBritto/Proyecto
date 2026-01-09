@extends('layouts.app')

@section('title', 'Categorías y Subcategorías')

@section('content')
    <h2 class="mb-4">Visual: Categorías y Subcategorías</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>Categoría</th>
                        <th>Subcategorías</th>
                        <th style="width:160px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td>
                            @if($categoria->subcategorias->isEmpty())
                                <em class="text-muted">(sin subcategorías)</em>
                            @else
                                <ul class="mb-0 list-unstyled">
                                    @foreach($categoria->subcategorias as $sub)
                                        <li>{{ $sub->nombre }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <a href="/categorias?categoria_id={{ $categoria->id }}" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay categorías registradas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
