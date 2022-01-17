<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/dist/img/aro-logo.png" alt="ARO HELPDESK" class="brand-image"
            style="opacity: .8">
        <span class="brand-text font-weight-light"><b>ARO HELPDESK</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        @php($avatar='/dist/img/avatar.png')

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{$avatar}}" class="img-circle elevation-2" alt="">
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>{{Auth::user()->nome}}</b></a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-collapse-hide-child flex-column" data-widget="treeview"
                role="menu">
                <li class="nav-item">
                    <a href="/" data-link="home" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Painel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/empresas" data-link="empresas" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a href="/configuracoes" data-link="configuracoes" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Configurações
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="/modelosemail" sub-link="modelosemail" class="nav-link">
                                <i class="far fa-envelope nav-icon"></i>
                                <p>Modelos de Email</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/status" sub-link="status" class="nav-link">
                                <i class="fas fa-exclamation nav-icon"></i>
                                <p>Status</p>
                            </a>
                        </li>

                    </ul>
                </li> !-->
                <li class="nav-item">
                    <a href="/protocolos" data-link="protocolos" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            MDF-e
                        </p>
                    </a>
                </li>

                <!--<li class="nav-item">
                    <a href="/os" data-link="os" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Ordens de Serviço</p>
                    </a>
                </li> !-->


                <li class="nav-item">
                    <a href="/departamentos" data-link="departamentos" class="nav-link">
                        <i class="nav-icon fas fa-truck-moving"></i>
                        <p>
                            Veículos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/usuarios" data-link="usuarios" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Motoristas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/usuarios" data-link="usuarios" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuários
                        </p>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a href="/suporte" data-link="suporte" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            Suporte Online
                        </p>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
