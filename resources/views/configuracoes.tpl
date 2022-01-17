<link rel="stylesheet" href="/plugins/froala/css/froala_editor.css">
<link rel="stylesheet" href="/plugins/froala/css/froala_style.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/code_view.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/draggable.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/colors.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/emoticons.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/image_manager.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/image.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/table.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/char_counter.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/video.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/fullscreen.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/file.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/quick_insert.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/help.css">
<link rel="stylesheet" href="/plugins/froala/css/third_party/spell_checker.css">
<link rel="stylesheet" href="/plugins/froala/css/plugins/special_characters.css">
<link rel="stylesheet" href="/plugins/froala/css/codemirror.min.css">

<style>
    table {
        table-layout: fixed !important;
    }
</style>

<div class="col-sm-12">
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="email-tab" data-toggle="pill" href="#email" role="tab"
                        aria-controls="email" aria-selected="true">Modelos e E-mail</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show active" id="email" role="tabpanel" aria-labelledby="email-tab">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="btn-group float-right">
                                <a type="button" href="/painel/configuracoes/?novo"
                                    class="btn btn-block bg-gradient-success " style="margin-bottom: 10px;;">
                                    <i class="fas fa-plus"></i>
                                    Novo
                                </a>
                            </div>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Data</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {if isset($modelos)}
                                        {foreach from=$modelos item="mod"}
                                            <tr>
                                                <td>{$mod.MOD_id}</td>
                                                <td>{$mod.MOD_titulo}</td>
                                                <td>{$mod.MOD_data|date_format:"%d/%m/%Y - %H:%M:%S"}</td>
                                                <td>
                                                    <!--<button type="button" id="{$mod.MOD_id}"
                                                        class="btn btn-danger float-right excluir" style="margin-right: 10px;"
                                                        data-toggle="modal" data-target="#modal_excluir">
                                                        <i class="fas fa-trash "></i>
                                                    </button>!-->
                                                    <a href="/painel/configuracoes/email/editar/{$mod.MOD_id}"
                                                        class="btn btn-primary float-right" style="margin-right: 10px;">
                                                        <i class="fas fa-edit"></i>

                                                    </a>

                                                    <button type="button" class="btn btn-default  float-right"
                                                        style="margin-right: 10px;" data-toggle="modal"
                                                        data-target="#modal_{$mod.MOD_id}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <div class="modal fade" id="modal_{$mod.MOD_id}">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">{$mod.MOD_titulo}</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {$mod.MOD_html}
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </td>

                                            {/foreach}
                                        {/if}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </div>
</div>


<div class="modal fade" id="modal_email">
    <div class="modal-dialog modal-lg">
        <form method="post" action="" id="editor">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar modelo de e-mail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <label for="MOD_titulo" class="float-left">Titulo do Modelo de Email</label>
                            <input name="MOD_titulo" type="text" value="{$modelo.MOD_titulo|default:''}"
                                class="form-control" id="MOD_titulo" required>
                        </div>
                        <div class="form-group clearfix">
                            <textarea name="MOD_html" type="text" class="form-control"
                                id="MOD_html">{$modelo.MOD_html|default:''}</textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="excluir-sim">Salvar</button>

                </div>
            </div>
        </form>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal_excluir">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Excluir Modelo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja mesmo excluir este modelo de email?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" id="excluir-sim">Excluir</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript" src="/plugins/froala/js/plugins/codemirror.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/xml.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/purify.min.js"></script>

<script type="text/javascript" src="/plugins/froala/js/froala_editor.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/file.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/help.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/plugins/print.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/third_party/spell_checker.min.js">
</script>
<script type="text/javascript" src="/plugins/froala/js/plugins/special_characters.min.js">
</script>
<script type="text/javascript" src="/plugins/froala/js/plugins/word_paste.min.js"></script>
<script type="text/javascript" src="/plugins/froala/js/languages/pt_br.js"></script>

<script>
    (function() {
        new FroalaEditor("#MOD_html", {
            language: 'pt_br',
            events: {
                "image.beforeUpload": function(files) {
                    var editor = this;
                    if (files.length) {
                        // Create a File Reader.
                        var reader = new FileReader();
                        // Set the reader to insert images when they are loaded.
                        reader.onload = function(e) {
                            var result = e.target.result;
                            editor.image.insert(result, null, null, editor.image.get());
                        };
                        // Read image as base64.
                        reader.readAsDataURL(files[0]);
                    }
                    editor.popups.hideAll();
                    // Stop default upload chain.
                    return false;
                }
            }
        })
    })();

    var excluir;
    $(".excluir").click(function() {
        excluir = "/painel/configuracoes/email/excluir/" + $(this).attr('id');
        $("#modal-excluir").modal(show);
    });

    $("#excluir-sim").click(function() {
        window.location.href = excluir;
    });

    {if isset($modelo) || isset($smarty.get.novo)}
        $("#modal_email").modal('show');
    {/if}
</script>
