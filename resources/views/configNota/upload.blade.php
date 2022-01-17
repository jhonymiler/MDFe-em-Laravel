@extends('painel.main')
@section('content')
<div class="row">
	<div class="col s12">

		@if(session()->has('message'))
		<div class="row">
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
		</div>
		@endif

		<form class="container" method="post" action="/configNF/certificado"
		enctype="multipart/form-data">
			@csrf

			<div class="row"><br>
				<div class="col s8">
					<div class="file-field input-field">
						<div class="btn black">
							<i class="material-icons left">save</i>
							<span>Arquivo</span>
							<input name="file" accept=".bin, .pfx" type="file">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>

						@if($errors->has('file'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('file') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="col s3">
					<div class="input-field">
						<input type="password" name="senha" id="senha-view">

						<label id="senha">Senha do Certificado </label>
					</div>
				</div>
				<div class="col s1">
					<div class="">
						<a id="ver-senha" class="btn-floating btn-large waves-effect waves-light white"><i class="material-icons blue-text">remove_red_eye</i></a>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s6 offset-s3">
					<button style="width: 100%" class="btn-large green accent-3" type="submit">
						<i class="material-icons left">cloud</i>
					UPLOAD</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#ver-senha').click(() => {
		alert('dsd')
	})
</script>
@endsection
