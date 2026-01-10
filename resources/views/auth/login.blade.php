@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px;margin-top:4rem;">
	<div class="card">
		<div class="card-body">
			<h3 class="card-title mb-3">Iniciar sesión</h3>

			@if($errors->any())
				<div class="alert alert-danger">
					<ul class="mb-0">
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('login.post') }}">
				@csrf

				<div class="mb-3">
					<label for="email" class="form-label">Correo</label>
					<input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" />
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Contraseña</label>
					<input id="password" type="password" name="password" required class="form-control" />
				</div>

				<div class="mb-3 form-check">
					<input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
					<label class="form-check-label" for="remember">Recordarme</label>
				</div>

				<div class="d-grid">
					<button type="submit" class="btn btn-primary">Entrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
