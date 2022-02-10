

@extends('painel.main')
@section('titulo','Cadastro de MDF-e')
@section('content')
<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
<div class="row" id='cadastro'>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{route('empresas.save')}}" id="formcadastro" class="needs-validation" enctype='multipart/form-data'>
                @csrf
                <input type="hidden" name="id" value="{{{ isset($Empresa->id) ? $Empresa->id : 0 }}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select class="form-control" id="uf_inicio" required name="uf_inicio">
                                            <option value="null">--</option>
                                            @foreach($empresas as $emp)
                                                <option value="{{$emp->id}}">{{$emp->razao_social}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label >Ambiente</label>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-check">
                                                  <input id="producao" type="radio" name="ambiente" value="1">
                                                  <label for="producao" class="form-check-label"><b>Produção</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-check">
                                                  <input id="homolog" type="radio" name="ambiente" checked="checked" value="2">
                                                  <label for="homolog" class="form-check-label"><b>Homologação</b></label>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                            <label for="certificado">Certificado Digital (.pfx)</label>
                            <div class="input-group">

                                <input type="text" id="arquivo" class="form-control" readonly required>
                                <label class="input-group-btn" style="margin-left:-5px; ">
                                    <span class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                        <input name="certificado" id="certificado" type="file" style="display: none;"  required>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="uf">UF Inicial</label>
                                        <select class="form-control" id="uf_inicio" required name="uf_inicio">
                                            <option value="null">--</option>
                                            @foreach($ufs as $key => $u)
                                                <option value="{{$u}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="uf">UF Final</label>
                                        <select class="form-control" id="uf_fim" required name="uf_fim">
                                            <option value="null">--</option>
                                            @foreach($ufs as $key => $u)
                                                <option value="{{$u}}">{{$u}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <div class="input-group date" id="data_inicio_viagem" data-target-input="nearest">
                                            <input type="text" name="data_inicio_viagem" class="form-control datetimepicker-input" data-target="#data_inicio_viagem"/>
                                            <div class="input-group-append" data-target="#data_inicio_viagem" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
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
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(function () {
        //Date picker
        $('#data_inicio_viagem').datetimepicker({
            format: 'L'
        });
    });

</script>

@endsection
