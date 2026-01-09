@extends('layouts.app')

@section('title', 'Categorías y Subcategorías')

@section('content')
	<div class="text-center mb-4">
		<h1 class="mb-1">Categorías y Subcategorías</h1>
		<p class="text-muted">Listado organizado de categorías con sus subcategorías</p>
	</div>

	<style>
		/* Remove white background/shadow so only the blue border remains */
		.card-dashboard { border-radius: 12px; box-shadow: none; background: transparent; }
		.card-dashboard .card-body { background: transparent; }
		.card-dashboard .card-header { background: linear-gradient(90deg,#147bff,#0b63e6); color:#fff; padding:16px; }
		.card-dashboard .card-header h4 { margin:0; font-weight:700; }
	</style>

	<div class="row">
		<div class="col-12">
			<div class="border border-primary border-3 rounded p-1">
				<div class="card card-dashboard bg-transparent border-0 shadow-none">
					<div class="card-body py-4">
						<div class="text-center mb-3">
							<div style="font-size:28px;">
								<span style="display:inline-block; font-size:28px; margin-right:8px;">📋</span>
								<span class="text-primary fw-bold" style="font-size:28px;">Categorías y Subcategorías</span>
							</div>
						</div>

						@if($categorias->isEmpty())
							<div style="background:#dff7ff; border-radius:8px; padding:18px;">
								<p class="mb-0 text-center text-muted">No hay categorías registradas.</p>
							</div>
						@else
							<div class="table-responsive">
								<table class="table table-hover align-middle mb-0">
									<thead class="table-light">
										<tr>
											<th style="width:5%">#</th>
											<th style="width:35%">Categoría</th>
											<th>Subcategorías</th>
											<th style="width:15%">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($categorias as $index => $categoria)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td class="fw-semibold">{{ $categoria->nombre }}</td>
												<td>
													@if($categoria->subcategorias->isEmpty())
														<span class="text-muted fst-italic">Sin subcategorías</span>
													@else
														<ul class="mb-0 ps-3">
															@foreach($categoria->subcategorias as $sub)
																<li>{{ $sub->nombre }}</li>
															@endforeach
														</ul>
													@endif
												</td>
												<td>
													<a href="/categorias?categoria_id={{ $categoria->id }}" class="btn btn-sm btn-outline-primary">Editar</a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

