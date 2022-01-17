
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
                        <span class="info-box-number">{$abertos.qtd}</span>

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
                        <span class="info-box-text">Resolvidos</span>
                        <span class="info-box-number">{$fechados.qtd}</span>

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
                        <span class="info-box-text">Aguardando</span>
                        <span class="info-box-number">{$aguardando.qtd}</span>

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
                        <span class="info-box-text">Atendidos</span>
                        <span class="info-box-number">{$atendidos.qtd}</span>

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
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-6">
                <div id="grafico_clientes" style="height:300px;width:100%; paddin-left: 5px;"></div>
            </div>
            <div class="col-md-6">
                <div id="status_protocolos" style="height:300px;width:100%"></div>
            </div>
        </div>


        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="/plugins/raphael/raphael.min.js"></script>
        <script src="/dist/js/canvasjs.min.js"></script>

        <script>
            $(document).ready(function() {

            });


        </script>
        @endsection
