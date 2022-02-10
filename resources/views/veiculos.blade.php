

        @extends('painel.main')
        @section('titulo','Cadastro de Veículos')
        @section('content')
<style>
    #tabela_veiculos_filter {
        display: none;
    }

    .icon-certificado{
        font-size: 3.875rem;
    }
</style>

<div class="row" id='cadastro'>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{route('veiculos.save')}}" id="formcadastro" class="needs-validation" enctype='multipart/form-data'>
                @csrf
                <input type="hidden" name="id" value="{{{ isset($Veiculo->id) ? $Veiculo->id : 0 }}}">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="placa">Placa</label>
                                        <input name="placa" type="text" class="form-control" id="placa" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select class="form-control" id="uf" required name="uf">
                                            <option value="null">--</option>
                                            @foreach($estados as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->uf)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$u}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cor">Cor</label>
                                        <input name="cor" type="text" class="form-control" id="cor" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="marca">Marca</label>
                                        <input name="marca" type="text" class="form-control" id="marca" required>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="modelo">Modelo</label>
                                        <input name="modelo" type="text" class="form-control" id="modelo" required>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rntrc">RNTRC</label>
                                        <input name="rntrc" type="text" class="form-control" id="rntrc" required>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo</label>
                                        <select class="form-control" id="tipo" required name="tipo">

                                            <option value="null">--</option>
                                            @foreach($tipos as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->tipo)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$key}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_rodado">Tipo Rodado</label>
                                        <select class="form-control" id="tipo_rodado" required name="tipo_rodado">
                                            <option value="null">--</option>
                                            @foreach($tiposRodado as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->tipo_rodado)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$key}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_carroceria">Tipo Carroceria</label>
                                        <select class="form-control" id="tipo_carroceria" name="tipo_carroceria" required>
                                            <option value="null">--</option>
                                            @foreach($tiposCarroceria as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->tipo_carroceria)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$key}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tara">Tara</label>
                                        <input name="tara" type="text" class="form-control" id="tara" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="capacidade">Capacidade</label>
                                        <input name="capacidade" type="text" class="form-control" id="capacidade" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proprietario_nome">Nome do Proprietário</label>
                                        <input name="proprietario_nome" type="text" class="form-control" id="proprietario_nome" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proprietario_documento">CPF/CNPJ do Proprietário</label>
                                        <input name="proprietario_documento" type="text" class="form-control" id="proprietario_documento"
                                            required>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="proprietario_ie">IE/RG do Proprietário</label>
                                        <input name="proprietario_ie" type="text" class="form-control" id="proprietario_ie"
                                            required>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="proprietario_uf">UF - Proprietário</label>
                                        <select class="form-control" id="proprietario_uf" required name="proprietario_uf">
                                            <option value="null">--</option>
                                            @foreach($estados as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->proprietario_uf)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$u}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="proprietario_tp">Tipo do Proprietário</label>
                                        <select class="form-control" id="proprietario_tp" required name="proprietario_tp">
                                            <option value="null">--</option>
                                            @foreach($tiposProprietario as $key => $u)
                                            <option
                                            @if(isset($Veiculos))
                                            @if($key == $Veiculos->proprietario_tp)
                                            selected
                                            @endif


                                            @endif
                                            value="{{$key}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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

@if(isset($lista) && count($lista)>0)
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
                        <a href="/veiculos" type="button" class="btn btn-success">
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
                    <form method="post" action="{{route('veiculos.excluirMultiplos')}}" id="deleteAll">
                        @csrf

                    <table id="tabela_veiculos" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th><input id="select-all" type="checkbox"></th>
                                <th>Nome</th>
                                <th>Placa</th>
                                <th>Tipo</th>
                                <th>Carroceria</th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>

                                    @foreach ( $lista as $veiculos)

                                        <tr empresa="{{$veiculos->id}}">
                                            <td>
                                                <div class="icheck-primary">
                                                    <input name="selAll[]" type="checkbox" class="check-table"
                                                        value="{{$veiculos->id}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <a href="/veiculos/{{$veiculos->id}}"><b>{{$veiculos->proprietario_nome}}</b></a><br>
                                                </div>

                                            </td>
                                            <td>
                                                {{$veiculos->placa}}
                                            </td>
                                            <td>
                                                {{$veiculos->getTipo($veiculos->tipo)}} - {{$veiculos->getTipoRodado($veiculos->tipo_rodado)}}

                                            </td>
                                            <td>{{$veiculos->getTipoCarrocceria($veiculos->tipo_carroceria)}}</td>
                                            <td class="botao_tabela_edit_exclui" style="padding: 10px 0 0 0;">
                                                <a href="/veiculos/{{$veiculos->id}}"
                                                    class="btn btn-default">
                                                    <i class="fas fa-edit"></i>

                                                </a>
                                                <a href="/veiculos/excluir/{{$veiculos->id}}" nome="{{$veiculos->proprietario_nome}}" class="btn btn-default deletar" >
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



        var table = $("#tabela_veiculos").DataTable({
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
        $("input[id*='proprietario_documento']").inputmask({
            mask: ['999.999.999-99', '99.999.999/9999-99'],
            keepStatic: true
        });



        @if ($errors->any())
             @foreach ($errors->all() as $error)
                msg('erro','{{$error}}');
            @endforeach
        @endif




    });




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
