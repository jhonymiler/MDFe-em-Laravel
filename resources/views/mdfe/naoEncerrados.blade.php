@extends('painel.main')
@section('content')

<div class="row">
	<div class="col s12">

		<h4>{{$title}}</h4>

		<div class="row">
			<br>

			@if(session()->has('message'))
			<div class="row">
				<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
					<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
				</div>
			</div>
			@endif

			<div class="col s12">
				<label>Numero de registros: {{count($mdfes)}}</label>
			</div>

			<table class="col s12">
				<thead>
					<tr>
						<th></th>
						<th>Chave</th>
						<th>Protocolo</th>
						<th>Numero</th>
						<th>Data</th>
					</tr>
				</thead>

				<tbody id="body">
					<?php
					$total = 0;
					?>

					@if(count($mdfes) == 0)
						<tr>
							<td colspan="5" class="center-align"><h5 class="red-text">Nada Encontrado</h5></td>
						</tr>
					@endif

					@foreach($mdfes as $m)
					<tr>
						<td id="checkbox">
							<p>
								<input type="checkbox" class="check" id="test_{{$m['chave']}}" />
								<label for="test_{{$m['chave']}}"></label>
							</p>
						</td>
						<td id="chave">{{$m['chave']}}</td>
						<td id="protocolo">{{$m['protocolo']}}</td>
						<td>{{$m['numero'] > 0 ? $m['numero'] : '--'}}</td>
						<th>{{$m['data'] != '' ? \Carbon\Carbon::parse($m['data'])->format('d/m/Y') : '--'}}</th>


					</tr>

					@endforeach

				</tbody>
			</table>
		</div>


		<input type="hidden" id="token" value="{{csrf_token()}}" name="">

		<div class="row" id="preloader1" style="display: none">
			<div class="col s12 center-align">
				<div class="preloader-wrapper active">
					<div class="spinner-layer spinner--only">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div><div class="gap-patch">
							<div class="circle"></div>
						</div><div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col s3">
				<a @if(count($mdfes) == 0) disabled @endif id="btn-encerrar" onclick="encerrar()" style="width: 100%" class="btn-large red" href="#!">Encerrar</a>
			</div>


		</div>

		<div class="row" id="preloader" style="display: none">
			<div class="col s12 center-align">
				<div class="preloader-wrapper active">
					<div class="spinner-layer spinner--only">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div><div class="gap-patch">
							<div class="circle"></div>
						</div><div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div id="modal-alert-success" class="modal">

	<div class="modal-content">
		<p class="center-align"><i class="large material-icons green-text">check_circle</i></p>
		<h4 class="center-align">Tudo Certo</h4>
		<p class="center-align" id="evento">MDF-e(s) Encerrada(s)</p>

	</div>
	<div class="modal-footer">
		<a href="#!" onclick="redireciona()" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
	</div>
</div>

<div id="modal-alert-erro" class="modal">

	<div class="modal-content">
		<p class="center-align"><i class="large material-icons red-text">error</i></p>
		<h4 class="center-align">Algo dando errado</h4>
		<p class="center-align" id="evento-erro">Contate o Desenvolvedor</p>

	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
	</div>
</div>


@endsection
