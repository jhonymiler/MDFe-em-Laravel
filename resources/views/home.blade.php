
        @extends('painel.main')
        @section('titulo','Painel Administrativo')
        @section('content')

        <!-- =========================================================== -->
        <style>
            .col-6 .info-box-text {
                font-size: 20px;
            }

            @media only screen and (max-width: 1020px) {

                .col-6 .info-box-text {
                    font-size: 14px;
                }
            }

            @media only screen and (max-width: 1230px) {

                .col-6 .info-box-text {
                    font-size: 16px;
                }
            }
        </style>
        <div class="row" id="home-protocolos">
            <div class="col-md-3 col-sm-6 col-6">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-ticket-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Novos</span>
                        <span class="info-box-number">2</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-6">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Aprovados</span>
                        <span class="info-box-number">3</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-6">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Cancelados</span>
                        <span class="info-box-number">2</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-6">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-comments"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Rejeitados</span>
                        <span class="info-box-number">1</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->



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
                            <a href="/veiculos" type="button" class="btn btn-success">
                                <i class="fas fa-plus"></i>
                                Novo
                            </a>
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
                                            <th>Data Viagem</th>
                                            <th>CNPJ Contratante</th>
                                            <th>UF</th>
                                            <th>Veículo</th>
                                            <th>Valor</th>
                                            <th>Ações</th>
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
                                                    <td>
                                                        valor
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



        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="/plugins/raphael/raphael.min.js"></script>
        <script src="/dist/js/canvasjs.min.js"></script>


        <script src="/plugins/datatables/jquery.dataTables.js"></script>
        <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
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

                $('.dataTables_filter').parent().parent('.row').hide()
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
            });


        </script>
        @endsection
