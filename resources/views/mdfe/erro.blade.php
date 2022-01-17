@extends('painel.main')
@section('content')

<div class="row">
	<div class="col s12">
		<h5>Para emissão do MDF-e é necessario ter cadastrado:</h5>
		<h5>* Emitente fiscal com certificado digital</h5>
		<h5>* Veiculo cadastrado</h5>
		<h5>* Natureza de operação cadastrado</h5>
		<h5>* Cliente destinatário cadastrado</h5>

		<div class="row">


			@if(!is_array($veiculos) || sizeof($veiculos) == 0)
			<a href="/veiculos" class="btn-large">ir para veiculos</a>
			@endif

			@if($config == null)
			<a href="/configNF" class="btn-large">ir para emitente fiscal</a>
			@endif

			@if($clienteCadastrado == null)
			<a href="/clientes" class="btn-large">ir para clientes</a>
			@endif
		</div>
	</div>
</div>
@endsection
