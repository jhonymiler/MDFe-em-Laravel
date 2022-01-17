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

		@if(sizeof($errors) > 0)
		<div class="row">
			<div style="border-radius: 10px;" class="col s12 red">
				<h5 class="center-align white-text">Erro no Formulário</h5>
			</div>
		</div>
		@endif



		<div class="row">
			<div class="col s6">
				<h4>{{{ isset($config) ? "Editar": "Cadastrar" }}} Emitente Fiscal</h4>
			</div>
			<div class="col s6">

				@if($soapDesativado)
				<p class="red-text center-align"> >> EXTENSÃO SOAP DESATIVADA <<</p>
				@endif

				@if(empty($certificado))
				<p class="red-text center-align">VOCE AINDA NÃO FEZ UPLOAD DO CERTIFICADO ATÉ O MOMENTO</p>
				<a @if($config == null) disabled @endif style="width: 100%" href="/configNF/certificado" class="btn-large blue pulse">
					<i class="material-icons left">cloud</i>
				Fazer upload agora</a>


				@else
				<a onclick='swal("Atenção!", "Deseja remover o certificado?", "warning").then((sim) => {if(sim){ location.href="/configNF/deleteCertificado" }else{return false} })' href="#!" class="btn red">
					<!-- <i class="material-icons left">close</i> -->
				Deletar Certificado</a>
				<a id="testar" class="btn indigo">Testar ambiente Sefaz</a>


				<div id="preloader" style="display: none">
					<br><div class="col s12 center-align">
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


				<h6>Serial Certificado: <strong class="green-text">{{$infoCertificado['serial']}}</strong></h6>
				<h6>Inicio: <strong class="green-text">{{$infoCertificado['inicio']}}</strong></h6>
				<h6>Expiração: <strong class="green-text">{{$infoCertificado['expiracao']}}</strong></h6>
				<h6>IDCTX: <strong class="green-text">{{$infoCertificado['id']}}</strong></h6>


				@endif

				<a style="margin-top: 10px;" id="testarEmail" class="btn orange">Testar Email</a>

				<div id="preloaderEmail" style="display: none">
					<br><div class="col s12 center-align">
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


				@if($soapDesativado)
				<h6 class="red-text">>>Ative no arquivo php.ini a extensão SOAP</h6>
				@endif

			</div>
		</div>

		<form method="post" action="/configNF/save" enctype="multipart/form-data">
			<input type="hidden" name="id" value="{{{ isset($config->id) ? $config->id : 0 }}}">

			<section class="section-1">

				<div class="row">
					<div class="input-field col s3">
						<input value="{{{ isset($config->cnpj) ? $config->cnpj : old('cnpj') }}}" id="cnpj" name="cnpj" type="text" class="validate">
						<label>CNPJ</label>

						@if($errors->has('cnpj'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('cnpj') }}</span>
						</div>
						@endif


					</div>
					<div class="col s1">
						<a href="#!" class="btn blue accent-3" onclick="consultaCNPJ()">
							<i class="material-icons">search</i>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s7">
						<input value="{{{ isset($config->razao_social) ? $config->razao_social : old('razao_social') }}}" id="razao_social" name="razao_social" type="text" class="validate upper-input">
						<label for="razao_social">Razao Social</label>

						@if($errors->has('razao_social'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('razao_social') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">
					<div class="input-field col s7">
						<input value="{{{ isset($config->nome_fantasia) ? $config->nome_fantasia : old('nome_fantasia') }}}" id="nome_fantasia" name="nome_fantasia" type="text" class="validate upper-input">
						<label for="nome_fantasia">Nome Fantasia</label>

						@if($errors->has('nome_fantasia'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('nome_fantasia') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">


					<div class="input-field col s3">
						<input value="{{{ isset($config->ie) ? $config->ie : old('ie') }}}" id="ie" name="ie" type="text" class="validate">
						<label>Inscrição Estadual</label>

						@if($errors->has('ie'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('ie') }}</span>
						</div>
						@endif
					</div>
				</div>
			</section>
			<section class="section-2">

				<div class="row">
					<div class="input-field col s5">
						<input value="{{{ isset($config->logradouro) ? $config->logradouro : old('logradouro') }}}" id="logradouro" name="logradouro" type="text" class="validate upper-input">
						<label for="logradouro">Logradouro</label>

						@if($errors->has('logradouro'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('logradouro') }}</span>
						</div>
						@endif

					</div>
					<div class="input-field col s2">
						<input value="{{{ isset($config->numero) ? $config->numero : old('numero') }}}" id="numero" name="numero" type="text" class="validate upper-input">
						<label for="numero">Numero</label>

						@if($errors->has('numero'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('numero') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">
					<div class="input-field col s3">
						<input value="{{{ isset($config->bairro) ? $config->bairro : old('bairro') }}}" id="bairro" name="bairro" type="text" class="validate upper-input">
						<label for="bairro">Bairro</label>

						@if($errors->has('bairro'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('bairro') }}</span>
						</div>
						@endif

					</div>

					<div class="input-field col s3">
						<input value="{{{ isset($config->cep) ? $config->cep : old('cep') }}}" id="cep" name="cep" type="text" class="validate">
						<label for="cep">CEP</label>

						@if($errors->has('cep'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('cep') }}</span>
						</div>
						@endif

					</div>
				</div>
				<div class="row">
					<div class="input-field col s3">
						<input value="{{{ isset($config->municipio) ? $config->municipio : old('municipio') }}}" id="municipio" name="municipio" type="text" class="validate upper-input">
						<label for="municipio">Municipio</label>

						@if($errors->has('municipio'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('municipio') }}</span>
						</div>
						@endif

					</div>
					<div class="input-field col s2">
						<input  value="{{{ isset($config->codMun) ? $config->codMun : old('codMun') }}}" id="codMun" name="codMun" type="text" class="validate">
						<label for="codMun">Codigo do Municipio</label>

						@if($errors->has('codMun'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('codMun') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">

					<div class="input-field col s2">
						<!-- <input value="{{{ isset($config->UF) ? $config->UF : old('UF') }}}" id="" name="UF" type="text" class="validate upper-input"> -->
						<select id="ufs" name="uf">
							<option value="null">--</option>
							@foreach($cUF as $key => $u)
							<option
							@if(isset($config))
							@if($key == $config->cUF)
							selected
							@endif

							@else
							@if($key == old('uf'))
							selected
							@endif

							@endif
							value="{{$key}}">{{$key}} - {{$u}}</option>
							@endforeach
						</select>

						<label for="UF">UF</label>

						@if($errors->has('uf'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('uf') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">
					<div class="input-field col s3">
						<input value="{{{ isset($config->pais) ? $config->pais : old('pais') }}}" id="pais" placeholder="Brasil" name="pais" type="text" class="validate upper-input">
						<label for="pais">Pais</label>

						@if($errors->has('pais'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('pais') }}</span>
						</div>
						@endif

					</div>
					<div class="input-field col s2">
						<input value="{{{ isset($config->codPais) ? $config->codPais : old('codPais') }}}" placeholder="1058" id="codPais" name="codPais" type="text" class="validate">
						<label for="codPais">Codigo do Pais</label>

						@if($errors->has('codPais'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('codPais') }}</span>
						</div>
						@endif

					</div>
				</div>

				<div class="row">
					<div class="input-field col s3">
						<input value="{{{ isset($config->fone) ? $config->fone : old('fone') }}}" id="telefone" name="fone" type="text" class="validate">
						<label for="fone">Telefone</label>

						@if($errors->has('fone'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('fone') }}</span>
						</div>
						@endif

					</div>

				</div>
			</section>

			<section class="section-3">

				<div class="row">
					<div class="input-field col s8">
						<select name="CST_CSOSN_padrao">
							@foreach($listaCSTCSOSN as $key => $l)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->CST_CSOSN_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$l}}</option>
							@endforeach
						</select>
						<label>CST/CSOSN Padrão</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<select name="CST_PIS_padrao">
							@foreach($listaCSTPISCOFINS as $key => $l)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->CST_PIS_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$l}}</option>
							@endforeach
						</select>
						<label>CST PIS Padrão</label>

					</div>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<select name="CST_COFINS_padrao">
							@foreach($listaCSTPISCOFINS as $key => $l)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->CST_COFINS_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$l}}</option>
							@endforeach
						</select>
						<label>CST COFINS Padrão</label>

					</div>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<select name="CST_IPI_padrao">
							@foreach($listaCSTIPI as $key => $l)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->CST_IPI_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$l}}</option>
							@endforeach
						</select>
						<label>CST IPI Padrão</label>

					</div>
				</div>


				<div class="row">
					<div class="input-field col s4">

						<select name="frete_padrao">
							@foreach($tiposFrete as $key => $t)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->frete_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$t}}</option>
							@endforeach
						</select>
						<label>Frete Padrão</label>

					</div>


					<div class="input-field col s4">

						<select name="tipo_pagamento_padrao">
							@foreach($tiposPagamento as $key => $t)
							<option value="{{$key}}"
							@isset($config)
							@if($key == $config->tipo_pagamento_padrao)
							selected
							@endif
							@endisset
							>{{$key}} - {{$t}}</option>
							@endforeach
						</select>
						<label>Tipo Pagamento Padrão</label>

					</div>

				</div>


				<div class="row">
					<div class="input-field col s8">

						<select name="nat_op_padrao">
							@foreach($naturezas as $n)
							<option value="{{$n->id}}"
								@isset($config)
								@if($n->id == $config->nat_op_padrao)
								selected
								@endif
								@endisset
								>{{$n->natureza}}
							</option>
							@endforeach
						</select>
						<label>Natureza de Operação Padrão Frente de Caixa</label>

					</div>

				</div>

				<div class="row">
					<div class="input-field col s4">

						<select name="ambiente">
							<option @if(isset($config)) @if($config->ambiente == 2) selected @endif @endif value="2">2 - Homologação</option>
							<option @if(isset($config)) @if($config->ambiente == 1) selected @endif @endif value="1">1 - Produção</option>
						</select>
						<label>Ambiente</label>
					</div>
					<div class="input-field col s2">

						<input value="{{{ isset($config->numero_serie_nfe) ? $config->numero_serie_nfe : old('numero_serie_nfe') }}}" id="numero_serie_nfe" name="numero_serie_nfe" type="text" class="validate numero_serie">
						<label for="numero_serie_nfe">Nº Serie NF-e</label>

						@if($errors->has('numero_serie_nfe'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('numero_serie_nfe') }}</span>
						</div>
						@endif
					</div>

					<div class="input-field col s2">

						<input value="{{{ isset($config->numero_serie_nfce) ? $config->numero_serie_nfce : old('numero_serie_nfce') }}}" id="numero_serie_nfce" name="numero_serie_nfce" type="text" class="validate numero_serie">
						<label for="numero_serie_nfce">Nº Serie NFC-e</label>

						@if($errors->has('numero_serie_nfce'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('numero_serie_nfce') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="input-field col s2">

						<input value="{{{ isset($config->ultimo_numero_nfe) ? $config->ultimo_numero_nfe : old('ultimo_numero_nfe') }}}" id="ultimo_numero_nfe" name="ultimo_numero_nfe" type="text" class="validate">
						<label for="ultimo_numero_nfe">Ultimo número de NF-e</label>

						@if($errors->has('ultimo_numero_nfe'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('ultimo_numero_nfe') }}</span>
						</div>
						@endif
					</div>
					<div class="input-field col s2">

						<input value="{{{ isset($config->ultimo_numero_nfce) ? $config->ultimo_numero_nfce : old('ultimo_numero_nfce') }}}" id="ultimo_numero_nfce" name="ultimo_numero_nfce" type="text" class="validate">
						<label for="ultimo_numero_nfce">Ultimo número de NFC-e</label>

						@if($errors->has('ultimo_numero_nfce'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('ultimo_numero_nfce') }}</span>
						</div>
						@endif
					</div>
					<div class="input-field col s2">

						<input value="{{{ isset($config->ultimo_numero_cte) ? $config->ultimo_numero_cte : old('ultimo_numero_cte') }}}" id="ultimo_numero_cte" name="ultimo_numero_cte" type="text" class="validate">
						<label for="ultimo_numero_cte">Ultimo número de CT-e</label>

						@if($errors->has('ultimo_numero_cte'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('ultimo_numero_cte') }}</span>
						</div>
						@endif
					</div>
					<div class="input-field col s2">

						<input value="{{{ isset($config->ultimo_numero_mdfe) ? $config->ultimo_numero_mdfe : old('ultimo_numero_mdfe') }}}" id="ultimo_numero_mdfe" name="ultimo_numero_mdfe" type="text" class="validate">
						<label for="ultimo_numero_mdfe">Ultimo número de MDF-e</label>

						@if($errors->has('ultimo_numero_mdfe'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('ultimo_numero_mdfe') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="input-field col s4">

						<input value="{{{ isset($config->csc) ? $config->csc : old('csc') }}}" id="csc" name="csc" type="text" class="validate">
						<label for="csc">CSC</label>

						@if($errors->has('csc'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('csc') }}</span>
						</div>
						@endif
					</div>

					<div class="input-field col s2">

						<input value="{{{ isset($config->csc_id) ? $config->csc_id : old('csc_id') }}}" id="csc_id" name="csc_id" type="text" class="validate">
						<label for="csc_id">CSC ID</label>

						@if($errors->has('csc_id'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('csc_id') }}</span>
						</div>
						@endif
					</div>

						<!-- <div class="col s2">
							<label>Certificado A3</label>
							<div class="switch">
								<label class="">
									Não
									<input @if(isset($config->certificado_a3) && $config->certificado_a3) checked @endisset value="true" name="certificado_a3" class="red-text" type="checkbox">
									<span class="lever"></span>
									Sim
								</label>

							</div>
							<span class="red-text">*Em desenvolvimento</span>
						</div> -->

					</div>
				</section>

				@csrf

				<br>
				<div class="row">
					<a class="btn-large red lighten-2" href="/">Cancelar</a>
					<input type="submit" value="Salvar" class="btn-large green accent-3">
				</div>
			</form>
		</div>
	</div>

	@section('javascript')
	<script type="text/javascript">
		function consultaCNPJ(){

			let cnpj = $('#cnpj').val();

			cnpj = cnpj.replace('.', '');
			cnpj = cnpj.replace('.', '');
			cnpj = cnpj.replace('-', '');
			cnpj = cnpj.replace('/', '');
			cnpj = cnpj.replace(' ', '');

			if(cnpj.length != 14){
				swal("Erro", "CNPJ inválido", "error")
			}else{

				$.ajax({

					url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj,
					type: 'GET',
					crossDomain: true,
					dataType: 'jsonp',
					success: function(data)
					{
						console.log(data);
						$('#btn-consulta-cadastro').removeClass('spinner')

						$('#razao_social').val(data.nome)
						$('#nome_fantasia').val(data.fantasia)
						$('#logradouro').val(data.logradouro)
						$('#numero').val(data.numero)
						$('#bairro').val(data.bairro)
						$('#complemento').val(data.complemento)
						$('#cnpj2').val(data.cnpj)
						let cep = data.cep;
						cep = cep.replace( '.', '' );
						cep = cep.replace( '-', '' );
						$('#cep').val(cep.substring(0, 5) + '-' + cep.substring(5, 9))
						$('#municipio').val(data.municipio)

						getUF(data.uf, (res) => {
							console.log(res)
							$('#ufs').val(res)
							$('#ufs').material_select();
							$('#pais').val('BRASIL')
							$('#codPais').val('1058')
						})

						findNomeCidade(data.municipio, (res) => {
							let jsCidade = JSON.parse(res);
							console.log(jsCidade)
							if (jsCidade) {
								console.log(jsCidade.id + " - " + jsCidade.nome)
								$('#codMun').val(jsCidade.codigo)
							}
						})

						$('#emil').val(data.email)
						setTimeout(() => {
							Materialize.updateTextFields();
						}, 500)

					},
					error: function(e) {
						$('#btn-consulta-cadastro').removeClass('spinner')

						console.error(e);
						swal("Erro", "Erro na consulta", "error")

					},
				});
			}
		}

		function findNomeCidade(nomeCidade, call) {
			$.get(path + '/cidades/findNome/' + nomeCidade)
			.done((success) => {
				call(success)
			})
			.fail((err) => {
				call(err)
			})
		}

		function getUF(uf, call){

			let js = {
				'RO': '11',
				'AC': '12',
				'AM': '13',
				'RR': '14',
				'PA': '15',
				'AP': '16',
				'TO': '17',
				'MA': '21',
				'PI': '22',
				'CE': '23',
				'RN': '24',
				'PB': '25',
				'PE': '26',
				'AL': '27',
				'SE': '28',
				'BA': '29',
				'MG': '31',
				'ES': '32',
				'RJ': '33',
				'SP': '35',
				'PR': '41',
				'SC': '42',
				'RS': '43',
				'MS': '50',
				'MT': '51',
				'GO': '52',
				'DF': '53'
			};

			call(js[uf])
		}
	</script>
	@endsection
	@endsection
