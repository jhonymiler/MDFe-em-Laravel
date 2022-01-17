@extends('painel.main')
@section('content')
<div class="row">
	<div class="col s12">
		<h4>{{{ isset($veiculo) ? "Editar": "Cadastrar" }}} Veiculo</h4>
		<form method="post" action="{{{ isset($veiculo) ? '/veiculos/update': '/veiculos/save' }}}">
			<input type="hidden" name="id" value="{{{ isset($veiculo->id) ? $veiculo->id : 0 }}}">

			<div class="row">
				<div class="input-field col s2">
					<input value="{{{ isset($veiculo->placa) ? $veiculo->placa : old('placa') }}}" id="placa" name="placa" type="text" class="validate">
					<label for="placa">Placa</label>

					@if($errors->has('placa'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('placa') }}</span>
					</div>
					@endif

				</div>


				<div class="input-field col s1">
					<select name="uf">
						@foreach($ufs as $u)
						<option
						@if(isset($veiculo))
						@if($u == $veiculo->uf)
						selected
						@endif
						@endisset
						value="{{$u}}">{{$u}}</option>
						@endforeach
					</select>
					<label>UF</label>
				</div>

				<div class="input-field col s2">
					<input value="{{{ isset($veiculo->cor) ? $veiculo->cor : old('placa') }}}" id="cor" name="cor" type="text" class="validate">
					<label for="cor">Cor</label>

					@if($errors->has('cor'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('cor') }}</span>
					</div>
					@endif

				</div>
			</div>

			<div class="row">
				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->marca) ? $veiculo->marca : old('marca') }}}" id="marca" name="marca" type="text" class="validate">
					<label for="placa">Marca</label>

					@if($errors->has('marca'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('marca') }}</span>
					</div>
					@endif

				</div>

				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->modelo) ? $veiculo->modelo : old('modelo') }}}" id="modelo" name="modelo" type="text" class="validate">
					<label for="modelo">Modelo</label>

					@if($errors->has('modelo'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('modelo') }}</span>
					</div>
					@endif

				</div>
			</div>

			<div class="row">
				<div class="input-field col s3">
					<select name="tipo">
						@foreach($tipos as $key => $t)
						<option
						@isset($veiculo)
						@if($key == $veiculo->tipo)
						selected
						@endif
						@endisset
						value="{{$key}}">{{$key}} - {{$t}}</option>
						@endforeach
					</select>
					<label>Tipo</label>

				</div>

				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->rntrc) ? $veiculo->rntrc : old('rntrc') }}}" id="rntrc" name="rntrc" type="text" class="validate">
					<label for="rntrc">RNTRC</label>

					@if($errors->has('rntrc'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('rntrc') }}</span>
					</div>
					@endif

				</div>
			</div>

			<div class="row">
				<div class="input-field col s3">
					<select name="tipo_carroceira">
						@foreach($tiposCarroceria as $key => $t)
						<option
						@isset($veiculo)
						@if($key == $veiculo->tipo_carroceira)
						selected
						@endif
						@endisset
						value="{{$key}}">{{$key}} - {{$t}}</option>
						@endforeach
					</select>
					<label>Tipo de Carroceria</label>

				</div>

				<div class="input-field col s3">
					<select name="tipo_rodado">
						@foreach($tiposRodado as $key => $t)
						<option
						@isset($veiculo)
						@if($key == $veiculo->tipo_rodado)
						selected
						@endif
						@endisset
						value="{{$key}}">{{$key}} - {{$t}}</option>
						@endforeach
					</select>
					<label>Tipo de Rodado</label>

				</div>

			</div>

			<div class="row">
				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->tara) ? $veiculo->tara : old('tara') }}}" id="tara" name="tara" type="text" class="validate">
					<label for="tara">Tara</label>

					@if($errors->has('tara'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('tara') }}</span>
					</div>
					@endif

				</div>

				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->capacidade) ? $veiculo->capacidade : old('capacidade') }}}" id="capacidade" name="capacidade" type="text" class="validate">
					<label for="capacidade">Capacidade</label>

					@if($errors->has('capacidade'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('capacidade') }}</span>
					</div>
					@endif

				</div>
			</div>


			<div class="row">
				<div class="input-field col s6">
					<input value="{{{ isset($veiculo->proprietario_nome) ? $veiculo->proprietario_nome : old('proprietario_nome') }}}" id="proprietario_nome" name="proprietario_nome" type="text" class="validate">
					<label for="proprietario_nome">Nome Proprietário</label>

					@if($errors->has('proprietario_nome'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('proprietario_nome') }}</span>
					</div>
					@endif

				</div>

			</div>

			<div class="row">
				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->proprietario_documento) ? $veiculo->proprietario_documento : old('proprietario_documento') }}}" id="proprietario_documento" name="proprietario_documento" type="text" class="validate">
					<label for="proprietario_documento">CPF/CNPJ Proprietário</label>

					@if($errors->has('proprietario_documento'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('proprietario_documento') }}</span>
					</div>
					@endif

				</div>


				<div class="input-field col s3">
					<input value="{{{ isset($veiculo->proprietario_ie) ? $veiculo->proprietario_ie : old('proprietario_ie') }}}" id="proprietario_ie" name="proprietario_ie" type="text" class="validate">
					<label for="proprietario_ie">I.E/RG Proprietário</label>

					@if($errors->has('proprietario_ie'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('proprietario_ie') }}</span>
					</div>
					@endif

				</div>
			</div>


			<div class="row">

				<div class="input-field col s2">
					<select name="proprietario_uf">
						@foreach($ufs as $key => $u)
						<option
						@isset($veiculo)
						@if($key == $veiculo->proprietario_uf)
						selected
						@endif
						@endisset
						value="{{$key}}">{{$key}} - {{$u}}</option>
						@endforeach
					</select>
					<label for="proprietario_ie">UF Proprietário</label>

				</div>

				<div class="input-field col s3">
					<select name="proprietario_tp">
						@foreach($tiposProprietario as $key => $t)
						<option
						@isset($veiculo)
						@if($key == $veiculo->proprietario_tp)
						selected
						@endif
						@endisset
						value="{{$key}}">{{$key}} - {{$t}}</option>
						@endforeach
					</select>
					<label for="proprietario_tp">Tipo do Proprietário</label>

				</div>

			</div>


			@csrf


			<br>
			<div class="row">
				<a class="btn-large red lighten-2" href="/veiculos">Cancelar</a>
				<input type="submit" value="Salvar" class="btn-large green accent-3">
			</div>
		</form>
	</div>
</div>
@endsection
