<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('titulo')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/plugins/sweetalert2/sweetalert2.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="/plugins/inputfile/css/fileinput.css" media="all" rel="stylesheet"
            type="text/css" />
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/dist/css/emojis.css">

        <!-- FAVICON -->
        <link rel="apple-touch-icon" sizes="180x180" href="/dist/img/aro-logo.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/dist/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/dist/img/favicon-16x16.png">
        <link rel="manifest" href="/dist/img/site.webmanifest">
        <!-- DataTables -->
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- ./wrapper -->
        <link href="/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/dist/css/adminlte.css">

        <link rel="stylesheet" href="/dist/css/cropper.css">
        <link rel="stylesheet" href="/dist/css/custom.css">

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/jquery.validate.min.js"></script>
        <script src="/dist/js/jquery.validation.pt-br.js"></script>
        <script src="/plugins/inputmask/jquery.inputmask.min.js"></script>

        <script src="/dist/js/twemoji.min.js" crossorigin="anonymous"></script>
        <script src="/dist/js/DisMojiPicker.js"></script>

        <script src="/dist/js/autobahn.js"></script>


        <script src="/dist/js/adminlte.min.js"></script>





    </head>

    <body class="sidebar-collapse control-sidebar-slide-open sidebar-mini-md">
        <div class="wrapper">

            @php($imagem='/dist/img/avatar.png')



            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="/dist/img/aro-logo.png" alt="ARO HELPDESK"
                    height="60" width="60">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/login/sair" class="nav-link">Sair</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->

                                <div class="media">
                                    <img src="/dist/img/user1-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Fulano
                                            <span class="float-right text-sm text-danger"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Dúvida Nota Fiscal</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/dist/img/user8-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Ciclano
                                            <span class="float-right text-sm text-muted"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Não consigo fazer lançamento</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/dist/img/user3-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Bertana
                                            <span class="float-right text-sm text-warning"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Olá, como faço para...</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">Mostrar todas mensagens</a>
                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notificações</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-ticket mr-2"></i> 4 Protocolos
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->


            <!-- Main Sidebar Container -->
            @include('sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">@yield('titulo')</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @if(isset($navLinks))
                                        @foreach ( $navLinks as $link)
                                            @if (isset($counter))
                                            <li class="breadcrumb-item active">{{$link->nome}}</li>
                                            @else
                                            <li class="breadcrumb-item"><a href="/{$link.url}">{{$link->nome}}</a>
                                            </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Conteudos da página -->

                       @yield('content')
                        <!-- /.conteudos -->
                    </div>
                    <!--/. container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->


            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2021 <a href="https://www.grupoarobr.com.br/" target="_blank">
                        GRUPO ARO
                    </a>.</strong>
                Direitos reservados.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.1.0
                </div>
            </footer>
        </div>

        <textarea id="campos" style="display: none;">
            @if (isset($campos))
                {{$campos}}
                @elseif(old())
                {{json_encode(old())}}
            @endif

            </textarea>
        <script type="text/javascript">
            $(document).ready(function() {
                @if (Session::has( 'msg' ))
                    msg('{{{Session::get('msg')['tipo']}}}}','{{{Session::get('msg')['msg']}}}');
                @endif

                $(".nav-link").removeClass('active');
                @if(isset($link_menu))
                    $("[data-link={{$link_menu}}]").addClass('active');
                @endif
                @if(isset($sub_link))
                    $("[sub-link={{$sub_link}}]").addClass('active');
                @endif
            });

            function msg(tipo,msg){

                status = '';
                switch (tipo) {
                    case 'erro':
                        status = 'bg-danger';
                        break;
                    case 'sucesso':
                        status = 'bg-success';
                        break;
                    case 'alerta':
                        status = 'bg-warning';
                        break;
                    case 'info':
                        status = 'bg-info';
                        break;
                    default:
                        status = 'bg-info';
                        break;
                }
                 // Mensagens de alerta
                 $(document).Toasts('create', {
                    toast: true,
                    delay: 5000,
                    class: status,
                    position: 'topRight',
                    autohide: true,
                    body: msg
                });
            };

            if($("#campos").val() != ''){
                var campos = JSON.parse($("#campos").val());
                preencher(campos);
            }

            function preencher(json) {
                for (var key in json) {
                    $("[name=" + key + "]").val(json[key]);
                }
            };


        </script>

    </body>

</html>
