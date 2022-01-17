

        @extends('painel.main')
        @section('titulo','Cadastro de Empresas')
        @section('content')
<style>
    #tabela_empresas_filter {
        display: none;
    }
</style>


<div class="row" id='cadastro'>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cadastro de Empresas</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="fecha">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>


            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{route('empresas.save')}}" id="formcadastro" class="needs-validation">
                @csrf
                <input type="hidden" name="id" value="{{{ isset($config->id) ? $config->id : 0 }}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cnpj">CNPJ</label>
                                        <input name="cnpj" type="text" class="form-control" id="cnpj"
                                            data-inputmask='"mask": "99.999.999/9999-99"' data-mask required>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ie">I.E</label>
                                        <input name="ie" type="text" class="form-control" id="ie" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ultimo_numero_mdfe">Último nº da MDF-e</label>
                                        <input name="ultimo_numero_mdfe" type="text" class="form-control" id="ultimo_numero_mdfe" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="razao_social">Razão Social</label>
                                <input name="razao_social" type="text" class="form-control" id="razao_social" required>
                            </div>
                            <div class="form-group">
                                <label for="nome_fantasia">Nome Fantasia</label>
                                <input name="nome_fantasia" type="text" class="form-control" id="nome_fantasia" required>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="email@site.com.br" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fone">Telefone</label>
                                        <input name="fone" type="text" class="form-control" id="fone"

                                            placeholder="(99) 9999-9999" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input name="cep" type="text" class="form-control" id="cep"
                                            data-inputmask='"mask": "99999-999"' data-mask data-maskplaceholder="99999-999"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="municipio">Cidade</label>
                                        <input type="hidden" name="codMun" id="codMun"/>
                                        <input type="hidden" name="codPais" id="codPais"/>
                                        <input type="hidden" name="pais" id="pais"/>

                                        codPais
                                        <input name="municipio" type="text" class="form-control" id="municipio"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select class="form-control" id="UF" required name="UF">
                                            <option value="null">--</option>
                                            @foreach($estados as $key => $u)
                                            <option
                                            @if(isset($config))
                                            @if($key == $config->cUF)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$u}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                        <input name="cUF" type="hidden" class="form-control" id="cUF" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input name="bairro" type="text" class="form-control" id="bairro"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logradouro">Rua</label>
                                        <input name="logradouro" type="text" class="form-control" id="logradouro" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Nº</label>
                                        <input name="numero" type="text" class="form-control" id="numero" required>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="btn-group float-right">
                                @if (isset($campos))
                                    <a href="/empresas" type="button" class="btn btn-success">
                                        <i class="fas fa-plus"></i>
                                        Novo
                                    </a>
                                @endif
                            </div>
                                <!-- /.float-right -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive mailbox-messages">

                                        <table id="tabela_empresas" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><input id="select-all" type="checkbox"></th>
                                                    <th>Nome Fantasia</th>
                                                    <th>CNPJ</th>
                                                    <th>Email</th>
                                                    <th>Telefone</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                                <tbody>

                                                        @foreach ( $lista as $empresas)

                                                            <tr empresa="{{$empresas->id}}">
                                                                <td>
                                                                    <div class="icheck-primary">
                                                                        <input name="selAll[]" type="checkbox" class="check-table"
                                                                            value="{{$empresas->id}}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-12">
                                                                        <a href="/empresas/{{$empresas->id}}"><b>{{$empresas->nome_fantasia}}</b></a><br>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    {{$empresas->cnpj}}
                                                                </td>
                                                                <td>
                                                                    {{$empresas->email}}

                                                                </td>
                                                                <td>{{$empresas->fone}}</td>
                                                                <td class="botao_tabela_edit_exclui" style="padding: 10px 0 0 0;">
                                                                    <a href="/empresas/{{$empresas->id}}"
                                                                        class="btn btn-default">
                                                                        <i class="fas fa-edit"></i>

                                                                    </a>
                                                                    <a href="/empresas/excluir/{{$empresas->id}}" nome="{{$empresas->nome_fantasia}}" class="btn btn-default deletar" >
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                </tbody>

                                        </table>

                                    </div>
                                    <!-- /.mail-box-messages -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Gravar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>

@if(isset($lista))
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" class="form-control" id="busca" placeholder="Buscar na Tabela">
        </div>
    </div>
    <div class="col-md-6 card-header">
        <div class="card-tools">

            <div class="input-group input-group-mm">
                <!-- Check all button -->
                <div class="btn-group">
                    @if (isset($campos))
                        <a href="/empresas" type="button" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Novo
                        </a>
                    @endif
                </div>
                <div class="btn-group" style="margin-left: 10px;">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-danger">
                        <i class="fas fa-trash"></i>
                        Excluir Selecionados
                    </button>
                </div>
                <!-- /.float-right -->
            </div>
        </div>
    </div>
</div>
<!-- /.card-tools -->

<div class="row">
    <div class="col-md-12">

        <div class="card card-primary card-outline">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <form method="post" action="{{route('empresas.excluirMultiplos')}}" id="deleteAll">
                        @csrf

                    <table id="tabela_empresas" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th><input id="select-all" type="checkbox"></th>
                                <th>Nome Fantasia</th>
                                <th>CNPJ</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>

                                    @foreach ( $lista as $empresas)

                                        <tr empresa="{{$empresas->id}}">
                                            <td>
                                                <div class="icheck-primary">
                                                    <input name="selAll[]" type="checkbox" class="check-table"
                                                        value="{{$empresas->id}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <a href="/empresas/{{$empresas->id}}"><b>{{$empresas->nome_fantasia}}</b></a><br>
                                                </div>

                                            </td>
                                            <td>
                                                {{$empresas->cnpj}}
                                            </td>
                                            <td>
                                                {{$empresas->email}}

                                            </td>
                                            <td>{{$empresas->fone}}</td>
                                            <td class="botao_tabela_edit_exclui" style="padding: 10px 0 0 0;">
                                                <a href="/empresas/{{$empresas->id}}"
                                                    class="btn btn-default">
                                                    <i class="fas fa-edit"></i>

                                                </a>
                                                <a href="/empresas/excluir/{{$empresas->id}}" nome="{{$empresas->nome_fantasia}}" class="btn btn-default deletar" >
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>

                    </table>
                </form>

                </div>
                <!-- /.mail-box-messages -->
            </div>
        </div>
    </div>

</div>
@endif
<!-- /.modal -->

<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DELETAR CADASTROS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Tem certeza que deseja deletar todos os cadastros selecionados?</h5>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-success" id="deletarSelecionados">SIM</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">NÃO</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Excluir Cadastro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Tem certeza que deseja excluir?</h5>
                <p  id="deletar-empresa" style="color: red"></p>
            </div>
            <div class="modal-footer justify-content-between">
                <a id="confirma-delete" href="" type="button" class="btn btn-success" id="deletar">SIM</a>
                <button type="button" class="btn btn-info" data-dismiss="modal">NÃO</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/plugins/jszip/jszip.min.js"></script>
<script src="/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
    $(document).ready(function() {



        var table = $("#tabela_empresas").DataTable({
            "lengthMenu": [
                [5, 25, 50, -1],
                [5, 25, 50, "Tudo"]
            ],
            "pageLength": 20,
            "language": pt_br,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "select": true,
            "ordering": true,
            "rowReorder": true,
            "columnDefs": [{
                orderable: true,
                className: 'reorder',
                targets: [0]
            }, {
                orderable: false,
                targets: [-1],
            }]
        });

        table.columns('.reorder').order('desc').draw();
        $("#example1_filter").hide();

        $('#busca').on('keyup', function() {
            table.search(this.value).draw();
        });


        $("#select-all").click(function() {
            $('input.check-table').attr("checked",this.checked);
        });


        $("#deletarSelecionados").click(function() {
            $("#deleteAll").submit();
        });

        $(".deletar").click(function() {
            emp = $(this).attr("nome");
            href = $(this).attr("href");
            $("#deletar-empresa").html(emp)
            $("#confirma-delete").attr('href',href);
            $("#modal-delete").modal();
            return false;
        });


        $('[data-mask]').inputmask();
       /* {if isset($empresa) && is_array($empresa)}
            $("#cadastro").show(100);
        {else}
            $("#cadastro").hide();
        {/if}

        {if isset($_GET['novo'])}
            $("#cadastro").show(100);
        {/if}*/

        $('#novo-cadastro').click(function() {
            $("#cadastro").show(100);
        });
        $('#fecha').click(function() {
            $("#cadastro").hide(100);
        });

        @if ($errors->any())
             @foreach ($errors->all() as $error)
                msg('erro','{{$error}}');
            @endforeach
        @endif

        $("#UF").change(function(){
            getUF($(this).val(), (res) => {
                $('#cUF').val(res);
            });
        });

        //Quando o campo cep perde o foco.
        $("#cnpj").blur(function() {

            //Nova variável "cnpj" somente com dígitos.
            var cnpj = $(this).val().replace(/\D/g, '');

            if(cnpj.length != 14){
				msg("erro", "CNPJ inválido")
			}else{

				$.ajax({

					url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj,
					type: 'GET',
					crossDomain: true,
					dataType: 'jsonp',
					success: function(data)
					{

						$('#razao_social').val(data.nome);
						$('#nome_fantasia').val(data.fantasia);
						$('#logradouro').val(data.logradouro +' '+ data.complemento);
						$('#numero').val(data.numero);
						$('#bairro').val(data.bairro);
						let cep = data.cep.replace(/\D/g, '');
						$('#cep').val(cep);
						$('#municipio').val(data.municipio);
                        $('#email').val(data.email);
                        $("#fone").val(data.telefone);
                        $("#UF").val(data.uf);

						getUF(data.uf, (res) => {
							$('#cUF').val(res);
							$('#pais').val('BRASIL');
							$('#codPais').val('1058');
						});

						findNomeCidade(data.municipio, (res) => {
							let jsCidade = JSON.parse(res);
							console.log(jsCidade)
							if (jsCidade) {
								console.log(jsCidade.id + " - " + jsCidade.nome)
								$('#codMun').val(jsCidade.codigo)
							}
						});




					},
					error: function(e) {
						$('#btn-consulta-cadastro').removeClass('spinner');

						console.error(e);
						swal("Erro", "Erro na consulta", "error");

					},
				});
			}


        });



    });



		function findNomeCidade(nomeCidade, call) {
			$.get('/cidades/findNome/' + nomeCidade)
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


  $('#formcadastro').validate({
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

</script>
@endsection
