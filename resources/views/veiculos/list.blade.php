@extends('painel.main')
@section('content')

<div class="row">
	<div class="col s12">

		<h4>Lista de Veiculos</h4>

		@if(session()->has('message'))
		<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
			<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
		</div>
		@endif

		<div class="row"></div>
		<div class="row">
			<a href="/veiculos/new" class="btn green accent-3">
				<i class="material-icons left">add</i>
				Novo Veiculo
			</a>
		</div>



		<div class="row">
			<div class="col s12">
				<label>Numero de registros: {{count($veiculos)}}</label>
			</div>
			<table class="col s12">
				<thead>
					<tr>
						<th>#</th>
						<th>Placa</th>
						<th>Cor</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Tipo</th>
						<th>RNTRC</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
					@foreach($veiculos as $v)
					<tr>
						<th>{{ $v->id }}</th>
						<th>{{ $v->placa }}</th>
						<th>{{ $v->cor }}</th>
						<th>{{ $v->marca }}</th>
						<th>{{ $v->modelo }}</th>
						<th>{{ $v->getTipo($v->tipo) }}</th>
						<th>{{ $v->rntrc }}</th>
						<th>
							<a href="/veiculos/edit/{{ $v->id }}">
								<i class="material-icons left">edit</i>
							</a>

							<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/veiculos/delete/{{ $v->id }}" }else{return false} })' href="#!">
								<i class="material-icons left red-text">delete</i>
							</a>
						</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
