

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
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="empresa">Empresa</label>
                                <select class="form-control" id="empresa" required name="empresa">
                                    <option value="null">--</option>
                                    @foreach($empresas as $emp)
                                        <option value="{{$emp->id}}">{{$emp->razao_social}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tpEmit">Tipo do Emitente</label>
                                        <select class="form-control" id="tpEmit" required name="tpEmit">
                                            <option value="null">--</option>
                                            <option value="1">Prestador de serviço de transporte</option>
                                            <option value="2">Transportador de Carga Própria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tpTransp">Tipo Transp.</label>
                                        <select class="form-control" id="tpTransp" required name="tpTransp">
                                            <option value="null">--</option>
                                            <option value="1">ETC</option>
                                            <option value="2">TAC</option>
                                            <option value="3">CTC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Lacre Rodov.</label>
                                        <input type="text" name="lacre_rodo" class="form-control" id="lacre_rodo" placeholder="000000">
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
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
                                        <label>Data Viagem:</label>
                                          <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" data-toggle="datetimepicker"/>
                                              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                              </div>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-4">
                                    <div class="form-group">
                                        <label for="cnpj_contratante">CNPJ Contratante</label>
                                        <input type="text" name="cnpj_contratante" class="form-control" id="cnpj_contratante" data-inputmask='"mask": "99.999.999/9999-99"' data-mask >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="valor_carga">Qtd. Carga</label>
                                        <input type="text" name="valor_carga" class="form-control" id="valor_carga" placeholder="1000 KG" >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="valor_carga">Valor Carga</label>
                                        <input type="text" name="valor_carga" class="form-control dinheiro" id="valor_carga"  >
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

<script>
    $(document).ready(function(){

        //Date picker
        jQuery('#reservationdate').datetimepicker({
            format: 'L'
        });

        $('[data-mask]').inputmask();
        $(".dinheiro").inputmask( 'currency',{"autoUnmask": true,
            radixPoint:",",
            groupSeparator: ".",
            allowMinus: false,
            //prefix: 'R$ ',
            digits: 2,
            digitsOptional: false,
            rightAlign: true,
            unmaskAsNumber: true
        });

    });

</script>

@endsection
