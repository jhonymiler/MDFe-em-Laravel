@extends('painel.main')
@section('content')


<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player
		src="/anime/success.json"  background="transparent" speed="0.8"
		style="width: 100%; height: 300px;" autoplay >
	</lottie-player>
</div>
</div>

<div class="row" id="content" style="display: block">
	<div class="col s12">
		<div class="card">
			<div class="row">
				<div class="col s12">
					@if(!isset($mdfe))
					<h4 class="center-align">EMISSÃO DE MDF-e</h4>
					@else
					<h4 class="center-align">ALTERAÇÃO DE MDF-e</h4>
					@endif
					<h5 class="grey-text">DADOS INICIAIS</h5>

					@if(!isset($mdfe))
					<h6>Ultima MDF-e: <strong>{{$lastMdfe}}</strong></h6>
					@endif

				</div>

				<!-- hiddens -->
				@if(isset($mdfe))
				<input type="hidden" value="{{$mdfe->id}}" id="mdfe_id">
				<input type="hidden" value="{{json_encode($municipiosDeCarregamento)}}" id="municipios_hidden">
				<input type="hidden" value="{{json_encode($percurso)}}" id="percurso_hidden">
				<input type="hidden" value="{{json_encode($ciots)}}" id="ciots_hidden">
				<input type="hidden" value="{{json_encode($valesPedagio)}}" id="vales_pedagio_hidden">
				<input type="hidden" value="{{json_encode($infoDescarga)}}" id="info_descarga_hidden">
				@endif

				<!-- fim hiddens -->
				<div class="row">
					<div class="col s2 input-field">
						<select id="uf_inicio">
							@foreach($ufs as $key => $u)
							<option value="{{$u}}" @isset($mdfe) @if($mdfe->uf_inicio == $u) selected @endif @endisset>{{$u}}</option>
							@endforeach
						</select>
						<label>UF Inicial</label>
					</div>

					<div class="col s2 input-field">
						<select id="uf_fim">
							@foreach($ufs as $key => $u)
							<option value="{{$u}}" @isset($mdfe) @if($mdfe->uf_fim == $u) selected @endif @endisset>{{$u}}</option>
							@endforeach
						</select>
						<label>UF Final</label>
					</div>

					<div class="col s2 input-field">
						<input type="text" class="datepicker" value="@isset($mdfe) {{ \Carbon\Carbon::parse($mdfe->data_inicio_viagem)->format('d/m/Y')}} @endisset" id="data_inicio_viagem">
						<label>Data Inicio da Viagem</label>
					</div>

					<div class="col s2">
						<label>Carga Posterior</label>

						<div class="switch">
							<label class="">
								Não
								<input @isset($mdfe) @if($mdfe->carga_posterior) checked @endif @endisset value="true" id="carga_posteior" class="red-text" type="checkbox">
								<span class="lever"></span>
								Sim
							</label>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s3">
						<label>Tipo do Emitente</label>

						<select id="tpEmit">
							<option @isset($mdfe) @if($mdfe->tp_emit == 1) selected @endif @endisset value="1">1 - Prestador de serviço de transporte</option>
							<option @isset($mdfe) @if($mdfe->tp_emit == 2) selected @endif @endisset value="2">2 - Transportador de Carga Própria</option>
						</select>
					</div>

					<div class="col s2">
						<label>Tipo do Transportador</label>

						<select id="tpTransp">
							<option @isset($mdfe) @if($mdfe->tp_transp == 1) selected @endif @endisset value="1">1 - ETC</option>
							<option @isset($mdfe) @if($mdfe->tp_transp == 2) selected @endif @endisset value="2">2 - TAC</option>
							<option @isset($mdfe) @if($mdfe->tp_transp == 3) selected @endif @endisset value="3">3 - CTC</option>
						</select>
					</div>

					<div class="col s2">
						<label>Lacre Rodoviário</label>
						<input type="text" class="validate" value="{{{ isset($mdfe) ? $mdfe->lac_rodo : '' }}}" id="lacre_rodo">
					</div>
				</div>

				<div class="row">
					<div class="col s3 input-field">
						<input type="text" class="validate" value="{{{ isset($mdfe) ?
						$mdfe->cnpj_contratante : '' }}}" id="cnpj_contratante">
						<label>CNPJ do Contratante</label>
					</div>
				</div>

				<div class="row">

					<div class="col s2 input-field">
						<input type="text" class="validate" value="{{{ isset($mdfe) ?
						$mdfe->quantidade_carga : '' }}}" id="quantidade_carga">
						<label>Quantidade da carga</label>
					</div>

					<div class="col s2 input-field">
						<input type="text" class="validate" value="{{{ isset($mdfe) ?
						$mdfe->valor_carga : '' }}}" id="valor_carga">
						<label>Valor da Carga</label>
					</div>

				</div>

				<div class="row">
					<div class="col s4 input-field">
						<select id="veiculo_tracao">
							<option value="null">--</option>
							@foreach($veiculos as $v)
							<option value="{{$v}}" @isset($mdfe) @if($v->id == $mdfe->veiculo_tracao_id) selected @endif @endisset>{{$v->marca}} {{$v->modelo}} - {{$v->placa}}</option>
							@endforeach
						</select>
						<label>Veiculo de Tração</label>

						<div id="display-tracao" class="row" style="display: none">
							<div class="card">
								<div class="card-header center-align blue-text">
									Veiculo de Tração Selecionado
								</div>
								<div class="card-content">
									<p>Marca: <strong id="tracao_marca"></strong></p>
									<p>Modelo: <strong id="tracao_modelo"></strong></p>
									<p>Placa: <strong id="tracao_placa"></strong></p>
									<p>Proprietário: <strong id="tracao_proprietario_nome"></strong></p>
									<p>Documento Proprietário: <strong id="tracao_proprietario_documento"></strong></p>
								</div>
							</div>
						</div>
					</div>

					<div class="col s4 input-field">
						<select id="veiculo_reboque">
							<option value="null">--</option>
							@foreach($veiculos as $v)
							<option value="{{$v}}" @isset($mdfe) @if($v->id == $mdfe->veiculo_reboque_id) selected @endif @endisset>{{$v->marca}} {{$v->modelo}} - {{$v->placa}}</option>
							@endforeach
						</select>
						<label>Veiculo de Reboque</label>
						<div id="display-reboque" style="display: none">
							<div class="row">
								<div class="card">
									<div class="card-header center-align red-text">
										Veiculo de Reboque Selecionado
									</div>
									<div class="card-content">
										<p>Marca: <strong id="reboque_marca"></strong></p>
										<p>Modelo: <strong id="reboque_modelo"></strong></p>
										<p>Placa: <strong id="reboque_placa"></strong></p>
										<p>Proprietário: <strong id="reboque_proprietario_nome"></strong></p>
										<p>Documento Proprietário: <strong id="reboque_proprietario_documento"></strong></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="card">
			<div class="">
				<div class="col s12">
					<ul class="tabs">
						<li class="tab col s4"><a href="#itens" class="blue-text">INFORMAÇÕES GERAIS</a></li>

						<li class="tab col s4"><a href="#info-transp" class="blue-text">INFORMAÇÕES DE TRANSPORTE</a></li>

						<li class="tab col s4"><a class="blue-text" href="#descarregamento">INFORMAÇÕES DE DESCARREGAMENTO</a></li>


					</ul>
				</div>
				<div id="itens" class="col s12">
					<div class="row">
						<div class="col s12">
							<h5 class="grey-text">INFORMAÇÕES GERAIS</h5>
						</div>

						<div class="col s12">
							<div class="card">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>Seguradora (opcional)</h5>

											<div class="input-field col s5">
												<input value="{{{ isset($mdfe) ? $mdfe->seguradora_nome : '' }}}" type="text"  id="seguradora_nome">
												<label>Nome da Seguradora</label>
											</div>

											<div class="input-field col s3">
												<input value="{{{ isset($mdfe) ? $mdfe->seguradora_cnpj : '' }}}" type="text" id="seguradora_cnpj">
												<label>CNPJ da Seguradora</label>
											</div>
										</div>
										<div class="col s12">
											<div class="input-field col s3">
												<input value="{{{ isset($mdfe) ? $mdfe->seguradora_numero_apolice : '' }}}" type="text" id="seguradora_numero_apolice">
												<label>Numero da Apolice</label>
											</div>

											<div class="input-field col s3">
												<input value="{{{ isset($mdfe) ? $mdfe->seguradora_numero_averbacao : '' }}}" type="text" id="seguradora_numero_averbacao">
												<label>Numero de Averbação</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col s7" >

							<div class="card" style="height: 380px;">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>Municipio(s) de Carregamento</h5>
											<div class="col s10 input-field">
												<input autocomplete="off" type="text" name="autocomplete-cidade-carregamento" id="autocomplete-cidade-carregamento" value=" " class="autocomplete-cidade-carregamento">
												<label>Cidade</label>
											</div>
											<div class="col s2">
												<button class="btn-large" id="btn-add-municipio-carregamento">
													<i class="material-icons">add</i>
												</button>
											</div>

											<div class="col s12" style="height:200px; overflow:auto;">
												<table style="overflow:scroll;">
													<thead>
														<tr>
															<th>#</th>
															<th>Cidade</th>
															<th>Ações</th>
														</tr>
													</thead>
													<tbody id="tbody-municipio-carregamento">
														<tr>
															<td>-</td>
															<td>-</td>
															<td>-</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col s5">


							<div class="card" style="height: 380px;">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>Percurso</h5>
											<div class="col s6 input-field">
												<select id="percurso">
													@foreach($ufs as $u)
													<option value="{{$u}}">{{$u}}</option>
													@endforeach
												</select>
											</div>
											<div class="col s2">
												<button class="btn-large" id="btn-add-percurso">
													<i class="material-icons">add</i>
												</button>
											</div>

											<div class="col s12" style="height:200px; overflow:auto;">
												<table>
													<thead>
														<tr>
															<th>UF</th>
															<th>Ações</th>
														</tr>
													</thead>
													<tbody id="tbody-percurso">
														<tr>
															<td>-</td>
															<td>-</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<input type="hidden" value="{{csrf_token()}}" id="_token">


					</div>

				</div>

				<div id="info-transp" class="col s12">
					<div class="row">
						<div class="col s12">
							<h5 class="grey-text">INFORMAÇÕES DO TRANSPORTE</h5>
						</div>

						<div class="col s12">
							<div class="card">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>CIOT (opcional)</h5>
											<div class="col s3 input-field">
												<input type="text" id="ciot_codigo">
												<label>Código CIOT</label>
											</div>
											<div class="col s3 input-field">
												<input type="text" id="ciot_cpf_cnpj">
												<label>CPF/CNPJ</label>

											</div>
											<div class="col s2">
												<button class="btn-large" id="btn-add-ciot">
													<i class="material-icons">add</i>
												</button>
											</div>

											<div class="col s8" style="height:200px; overflow:auto;">
												<table>
													<thead>
														<tr>
															<th>Código</th>
															<th>CPF/CNPJ</th>
															<th>Ações</th>

														</tr>
													</thead>
													<tbody id="tbody-ciot">
														<tr>
															<td>-</td>
															<td>-</td>
															<td>-</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col s12">
							<div class="card">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>Vale Pedagio (opcional)</h5>
											<div class="col s2 input-field">
												<input type="text" id="vale_cnpj_fornecedor">
												<label>CNPJ Fornecedor</label>
											</div>
											<div class="col s2 input-field">
												<input type="text" id="vale_cpf_cnpj_pagador">
												<label>CPF/CNPJ do Pagador</label>

											</div>

											<div class="col s2 input-field">
												<input type="text" id="vale_numero_compra">
												<label>Numero de Compra</label>

											</div>

											<div class="col s2 input-field">
												<input type="text" id="vale_valor">
												<label>Valor</label>

											</div>
											<div class="col s2">
												<button class="btn-large" id="btn-add-vale">
													<i class="material-icons">add</i>
												</button>
											</div>

											<div class="col s10" style="height:200px; overflow:auto;">
												<table>
													<thead>
														<tr>
															<th>CNPJ Fornecedor</th>
															<th>CPF/CNPJ do Pagador</th>
															<th>Numero de Compra</th>
															<th>Valor</th>
															<th>Ações</th>

														</tr>
													</thead>
													<tbody id="tbody-vale-pegadio">
														<tr>
															<td>-</td>
															<td>-</td>
															<td>-</td>
															<td>-</td>
															<td>-</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col s12">
							<div class="card">
								<div class="row">

									<div class="card-content">
										<div class="col s12">
											<h5>Condutor</h5>
											<div class="col s4 input-field">
												<input value="{{{ isset($mdfe) ?
												$mdfe->condutor_nome : '' }}}" type="text" id="condutor_nome">
												<label>Nome</label>
											</div>
											<div class="col s2 input-field">
												<input value="{{{ isset($mdfe) ?
												$mdfe->condutor_cpf : '' }}}" type="text" id="condutor_cpf">
												<label>CPF</label>

											</div>


										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div id="descarregamento" class="col s12">

					<div class="row">
						<div class="col s12">
							<h5 class="grey-text">INFORMAÇÕES DE DESCARREGAMENTO</h5>
						</div>

						<div class="col s12">
							<div class="card">
								<div class="row">

									<div class="card-content">
										<div class="row">
											<h5>Informações da Unidade de Transporte / Documentos Fiscais / Lacres</h5>

											<div class="row">

												<div class="input-field col s3">

													<select id="tp_unid_transp">
														@foreach($tiposUnidadeTransporte as $key => $t)
														<option value="{{$key}}">{{$key}} - {{$t}}</option>
														@endforeach
													</select>
													<label>Tipo Unidade de Transporte</label>
												</div>

												<div class="input-field col s3">
													<input class="upper-input" type="text" id="id_unid_transp">
													<label>ID da Unidade de Transporte (Placa)</label>
												</div>

												<div class="input-field col s3">
													<input type="text" class="qtd_rateio" id="qtd_rateio_transp">
													<label>Quantidade de Rateio (Transporte)</label>
												</div>
											</div>

											<div class="row">
												<div class="input-field col s3">
													<input type="text" id="id_unid_carga">
													<label>ID Unidade da Carga</label>
												</div>

												<div class="input-field col s3">
													<input type="text" class="qtd_rateio" id="qtd_rateio_unid_carga">
													<label>Quantidade de Rateio (Unidade Carga)</label>
												</div>
											</div>

											<div class="col s12">
												<div class="card">
													<div class="row">

														<div class="card-content">
															<h5>NF-e Referência</h5>
															<div class="input-field col s6">
																<input type="text" id="chave_nfe" class="chave">
																<label>Chave NF-e</label>
															</div>

															<div class="input-field col s6">
																<input class="chave" type="text" id="seg_cod_nfe" class="">
																<label>Segundo Código de Barra NF-e (Contigencia)</label>
															</div>
														</div>
													</div>
												</div>

											</div>

											<div class="col s12">
												<div class="card">
													<div class="row">

														<div class="card-content">
															<h5>CT-e Referência</h5>

															<div class="input-field col s6">
																<input type="text" id="chave_cte" class="chave">
																<label>Chave CT-e</label>
															</div>

															<div class="input-field col s6">
																<input type="text" class="chave" id="seg_cod_cte" class="">
																<label>Segundo Código de Barra CT-e (Contigencia)</label>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col s6">
												<div class="card">
													<div class="row">

														<div class="card-content">
															<h5>Lacres de Transporte</h5>

															<div class="col s8 input-field">
																<input type="text" class="v-lacre" id="lacre_transp">
																<label>Numero do Lacre</label>
															</div>
															<div class="col s2">
																<button class="btn-large" id="btn-add-lacre-transp">
																	<i class="material-icons">add</i>
																</button>
															</div>

															<div class="col s12" style="height:200px; overflow:auto;">
																<table>
																	<thead>
																		<tr>
																			<th>Número Lacre</th>
																		</tr>
																	</thead>
																	<tbody id="tbody-lacre-transp">
																		<tr>
																			<td>-</td>

																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col s6">
												<div class="card">
													<div class="row">

														<div class="card-content">
															<h5>Lacres da Unidade da Carga</h5>

															<div class="col s8 input-field">
																<input type="text" class="v-lacre" id="lacre_unidade">
																<label>Numero do Lacre</label>
															</div>
															<div class="col s2">
																<button class="btn-large" id="btn-add-larcre-unidade">
																	<i class="material-icons">add</i>
																</button>
															</div>

															<div class="col s12" style="height:200px; overflow:auto;">
																<table>
																	<thead>
																		<tr>
																			<th>Número Lacre</th>
																		</tr>
																	</thead>
																	<tbody id="tbody-lacre-unid">
																		<tr>
																			<td>-</td>

																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col s12">
												<div class="card">
													<div class="row">

														<div class="card-content">
															<h5>Municipio de Descarregamento</h5>


															<div class="input-field col s6">
																<input autocomplete="off" type="text" name="autocomplete-cidade-descarregamento"
																id="autocomplete-cidade-descarregamento" value="{{old('cidade')}}" class="autocomplete-cidade-descarregamento">
																<label for="autocomplete-cidade-descarregamento">Cidade</label>
																<input type="hidden" id="cidadeId" value="{{{ isset($cliente) ? $cliente->cidade_id : 0 }}}"
																>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col s12">
												<button id="btn-add-info-desc" style="width: 100%" class="btn-large green"> Adicionar Informação de Descarregamento</button>
											</div>

											<div class="col s12">
												<h5></h5>
												<table>
													<thead>
														<tr>
															<th>Tipo Transp</th>
															<th>ID Unid Transp</th>
															<th>Quantidade rateio</th>
															<th>NF-e Referênia</th>
															<th>CT-e Referênia</th>
															<th>Mun. Decarrega</th>

															<th>Lacres de Transp</th>
															<th>Lacres Unidade Carga</th>

															<th>Ações</th>
														</tr>
													</thead>
													<tbody id="tbody-info-descarga">
														<tr>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>
															<td>--</td>

														</tr>
													</tbody>
												</table>
											</div>


										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col s12">
					<div class="col s5 input-field"><br>
						<input type="text" id="info_complementar" name="">
						<label>Informação Complementar</label>
					</div>

					<div class="col s5 input-field"><br>
						<input type="text" id="info_fisco" name="">
						<label>Informação Fiscal</label>
					</div>

					<div class="col s2 "><br>

						<a id="finalizar" style="width: 100%;" href="#" onclick="salvarMDFe()" class="btn-large red disabled">Finalizar</a>
					</div>
				</div>
			</div>
			<div class="row" >
				<div id="preloader2" style="display: none;">
					<div class="col s12 center-align">
						<div class="preloader-wrapper active">
							<div class="spinner-layer spinner-red-only">
								<div class="circle-clipper left">
									<div class="circle red"></div>
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

	</div>
</div>

@endsection
