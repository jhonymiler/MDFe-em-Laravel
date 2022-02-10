<!-- Media table sample -->
<!-- DataTables  & Plugins -->

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
                    {if isset($campos)}
                        <a type="button" class="btn btn-primary" href="{$_pgParams.RAIZ}painel/usuarios">
                            <i class="fas fa-arrow-left"></i>
                            Voltar
                        </a>
                    {else}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novo-registro">
                            <i class="fas fa-plus"></i>
                            Novo
                        </button>
                    {/if}
                </div>
                <div class="btn-group" style="margin-left: 10px;">
                    <button type="button" id="deletarSelecionados" class="btn btn-info">
                        <i class="fas fa-trash"></i>
                        Excluir Selecionados
                    </button>
                </div>
                <!-- /.float-right -->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 card card-primary card-outline">

        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive mailbox-messages">
                <table id="example1" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><input id="select-all" type="checkbox"> </th>
                            <th></th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Empresa</th>
                            <th data-priority="1"></th>
                        </tr>
                    </thead>

                    <tbody>

                        {if is_array($lista)}
                            {foreach from=$lista item="user_data" name=i}
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input name="selUser" type="checkbox" class="check-table"
                                                value="{$user_data.USU_id}" id="user_{$user_data.USU_id}">
                                        </div>
                                    </td>
                                    <td class="mailbox-name row">
                                        <div class="image col-md-3">
                                            {if  !empty($user_data.USU_imagem)}
                                                {assign var="avatar" value="{$_pgParams.RAIZ}upload/{$user_data.USU_imagem}"}
                                            {else}
                                                {assign var="avatar" value="{$_pgParams.path_layout}dist/img/avatar.png"}

                                            {/if}
                                            {if $user_data.USU_nivel == 1}
                                                <img width="65" src="{$_pgParams.path_layout}dist/img/atendente.png"
                                                    class="atendente" alt="Atendente">
                                            {elseif $user_data.USU_nivel == 3}
                                                <img width="65" src="{$_pgParams.path_layout}dist/img/atendente.png"
                                                    class="atendente" alt="Atendente">
                                            {/if}
                                            <img width="50" src="{$avatar}" class="img-circle elevation-2"
                                                alt="{$user_data.USU_nome}">
                                        </div>

                                    </td>
                                    <td><b>{$user_data.USU_nome}</b></td>
                                    <td>{$user_data.USU_email}</td>
                                    <td>{$user_data.USU_tel}</td>
                                    <td class="mailbox-subject"><a
                                            href="{$_pgParams.RAIZ}painel/empresas/editar/{$user_data.EMP_id}">{$user_data.EMP_fantasia}</a>
                                    </td>
                                    <td class="botao_tabela_edit_exclui">
                                        <a href="{$_pgParams.RAIZ}painel/usuarios/editar/{$user_data.USU_id}"
                                            class="btn btn-default">
                                            <i class="fas fa-edit"></i>

                                        </a>
                                        <a href="{$_pgParams.RAIZ}painel/usuarios/excluir/{$user_data.USU_id}"
                                            class="btn btn-default">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                    </tbody>
                </table>
            </div>
            <!-- /.mail-box-messages -->
        </div>
    </div>
</div>

</div>

<div class="modal fade" id="novo-registro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-blue">
                <h4 class="modal-title">Cadastro de Usuários</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cadastro" onsubmit="return enviar();">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div id="drag-and-drop-zone" class="col-3">
                                    <label id="imagem-avatar" for='up_img'>
                                        {if  !empty($usuario.USU_imagem)}
                                            {assign var="imagem" value="{$_pgParams.RAIZ}upload/{$usuario.USU_imagem}"}
                                        {else}
                                            {assign var="imagem" value="{$_pgParams.path_layout}dist/img/avatar.png"}

                                        {/if}

                                        <img src="{$imagem}" width="100" id="img-avatar"></label>
                                    <span id="icon-avatar" class="badge">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <input type="file" id="up_img" style="display: none;">
                                    {if isset($campos)}
                                        <input type="text" name="USU_id" style="display: none;" value="">
                                    {/if}
                                </div>
                                <div class="col-9">
                                    <label for="USU_nome">Nome Completo</label>
                                    <input type="text" class="form-control" name="USU_nome" id="USU_nome"
                                        placeholder="Nome Completo" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="USU_tel">Telefone</label>
                            <input type="text" class="form-control" name="USU_tel" id="USU_tel"
                                data-inputmask='"mask": "(99) 99999-9999"' data-mask placeholder="(99) 99999-9999"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Empresa</label>
                            <select name="EMP_id" class="form-control required">
                                <option value="">Selecione uma emrpesa</option>
                                {if is_array($emplista) && count($emplista) > 0}
                                    {foreach from=$emplista item="emps"}
                                        <option value="{$emps.EMP_id}">{$emps.EMP_fantasia}</option>
                                    {/foreach}
                                {/if}}
                            </select>
                        </div>
                        {if is_array($user) && $user.USU_nivel > 1}

                            <div class="form-group">
                                <label for="USU_nivel">Nível</label>

                                <select id="USU_nivel" name="USU_nivel" class="form-control required">
                                    <option value="0">Usuário</option>
                                    <option value="1">Atendente</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </div>
                        {/if}
                        <div class="form-group">
                            <label for="USU_nivel">Departamento</label>

                            <select id="DEP_id" name="DEP_id" class="form-control required">
                                <option value="0">Nenhum</option>
                                {foreach from=$departamentos item="departamento"}
                                    <option value="{$departamento.DEP_id}">{$departamento.DEP_titulo}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="USU_email">Email</label>
                            <input type="email" class="form-control" name="USU_email" id="USU_email"
                                placeholder="email@site.com.br" required>
                        </div>
                        {if isset($campos)}
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="alt_senha" value="0">
                                    <label class="custom-control-label" for="alt_senha">Alterar senha?</label>
                                </div>
                            </div>
                            <div id="mostra-campo-senha">
                            {/if}
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" name="USU_senha" class="form-control" id="senha"
                                    placeholder="Senha">
                            </div>
                            <div class="form-group">
                                <label for="confirma_senha">Confirma senha</label>
                                <input type="password" class="form-control" name="confirma_senha" id="confirma_senha">
                            </div>
                            {if isset($campos)}
                        </div>{/if}
                        <div id="meti_o_loko"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal" id="cropimagem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">
                <div><img width="480" src="" id="image-crop" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cortar" class="btn btn-primary">Cortar</button>
                <button type="button" id="crop-fechar" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script src="{$_pgParams.path_layout}plugins/datatables/jquery.dataTables.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/jszip/jszip.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{$_pgParams.path_layout}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="{$_pgParams.path_layout}dist/js/jquery.dm-uploader.min.js"></script>

<script src="{$_pgParams.path_layout}dist/js/cropper.js"></script>


<script>
    var local = '{$FormAction}';
    var redir = '{$_pgParams.RAIZ}painel/usuarios';
    var delAll = '{$_pgParams.RAIZ}painel/usuarios/excluir';

    {if isset($campos)}
        $("#mostra-campo-senha").hide();
        $("#senha").prop("disabled", true);
        $("#novo-registro").modal('toggle');
        $("#alt_senha").change(function() {
            if ($(this).is(":checked")) {
                $("#mostra-campo-senha").show();
                $("#senha").prop("disabled", false);
                $("#confirma_senha").prop("disabled", false);

            } else {
                $("#mostra-campo-senha").hide();
                $("#senha").prop("disabled", true);
                $("#confirma_senha").prop("disabled", true);
            }
        });

    {/if}




    function enviar() {
        $('#cadastro').validate({
            rules: {
                USU_senha: {
                    required: false,
                    minlength: 5
                },
                confirma_senha: {
                    required: false,
                    minlength: 5,
                    equalTo: "#senha"
                },
                USU_empresa: {
                    required: true
                },
                USU_nivel: {
                    required: true
                }
            }
        });
        if ($("#USU_nivel").val() < 1 && $("#DEP_id").val() > 0) {
            $(document).Toasts('create', {
                toast: true,
                delay: 5000,
                class: 'bg-danger',
                position: 'topRight',
                autohide: true,
                fade: true,
                title: 'Erro!',
                body: 'O usuário não pode possuir departamento.'
            });
            $("DEP_id").val(0)
        } else if ($("#USU_nivel").val() == 3 && $("#DEP_id").val() != 0) {
            $(document).Toasts('create', {
                toast: true,
                delay: 5000,
                class: 'bg-danger',
                position: 'topRight',
                autohide: true,
                fade: true,
                title: 'Erro!',
                body: 'O Administrador não pode ser vinculado a um departamento.'
            });
            $("DEP_id").val(0)
        } else if ($("#USU_nivel").val() == 1 && $("#DEP_id").val() == 0) {
            $(document).Toasts('create', {
                toast: true,
                delay: 5000,
                class: 'bg-danger',
                position: 'topRight',
                autohide: true,
                fade: true,
                title: 'Erro!',
                body: 'Selecione um departamento para o Atendente.'
            });
            $("DEP_id").val(0)
        } else {
            $.ajax({
                type: 'POST',
                url: '{$FormAction}',
                data: $("#cadastro").serialize(),
                processData: false,
                cache: false,
                beforeSend: function() {
                    $preloader = $('.preloader')
                    if ($preloader) {
                        $preloader.attr('style', 'height:100%');
                        $preloader.children().show();
                    }
                },
                success: function(data) {
                    window.location.href = redir;
                }
            });
        }
        return false;
    };
    $(function() {



        $("#deletarSelecionados").click(function() {
            var ids = [];
            $('.check-table').each(function() {
                if ($(this).is(":checked")) {
                    ids.push($(this).val());
                }
            });
            $.ajax({
                type: 'POST',
                url: delAll,
                data: {
                    selUser: ids.join()
                },
                beforeSend: function() {
                    $preloader = $('.preloader')
                    if ($preloader) {
                        $preloader.attr('style', 'height:100%');
                        $preloader.children().show();
                    }
                },
                success: function(data) {
                    //window.location.href = redir;
                }
            });
            return false;
        });


        var table = $("#example1").DataTable({
            "language": pt_br,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "select": true,
            "ordering": true,
            "rowReorder": true,
            "columnDefs": [{
                    orderable: false,
                    className: 'reorder',
                    targets: [0, -1]
                },
                {
                    orderable: true,
                    targets: '_all'
                }
            ]
        });
        $("#example1_filter").hide();
        $('#busca').on('keyup', function() {
            table.search(this.value).draw();
        });

        $("#select-all").click(function() {
            $('.check-table').prop('checked', this.checked);
        });
        $('[data-mask]').inputmask()



        $('#up_img').dmUploader({ //
            //url: '/usuarios/registro/novo',
            maxFileSize: 3000000, // 3 Megs max
            multiple: false,
            allowedTypes: 'image/*',
            extFilter: ['jpg', 'jpeg', 'png'],
            auto: false,
            queue: true,
            onNewFile: function(id, file) {


                // When a new file is added using the file selector or the DnD area
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(e) {


                        var img = document.getElementById('img-avatar');
                        var img_crop = document.getElementById('image-crop');
                        var button = document.getElementById('cortar');
                        var croppedCanvas;
                        var roundedCanvas;


                        $(img).attr('src', e.target.result);
                        $(img_crop).attr('src', e.target.result);
                        $('#cropimagem').show();


                        var cropper = new Cropper(img_crop, {
                            aspectRatio: 1,
                            viewMode: 3
                        });

                        button.onclick = function() {

                            croppedCanvas = cropper.getCroppedCanvas();
                            roundedCanvas = getRoundedCanvas(croppedCanvas);
                            Dataimagem = roundedCanvas.toDataURL();
                            $(img).attr('src', Dataimagem);
                            $(img_crop).attr('src', '');


                            document.getElementById("meti_o_loko").innerHTML =
                                '<textarea name="USU_imagem" maxlength="10000000000" cols="10000000000" rows="10000000000" style="display:none;">' +
                                Dataimagem + '</textarea>';
                            $('#cropimagem').hide();
                            cropper.destroy();


                        };


                    };
                    reader.readAsDataURL(file);
                };
            }

        });
    });





    function getRoundedCanvas(sourceCanvas) {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var width = sourceCanvas.width;
        var height = sourceCanvas.height;

        canvas.width = width;
        canvas.height = height;
        context.imageSmoothingEnabled = true;
        context.drawImage(sourceCanvas, 0, 0, width, height);
        context.globalCompositeOperation = 'destination-in';
        context.beginPath();
        context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
        context.fill();
        return canvas;
    }
</script>

<!-- /.col -->


<!-- /.card -->
