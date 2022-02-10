<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mdfe;
use App\Models\MunicipioCarregamento;
use App\Models\Percurso;
use App\Models\Ciot;
use App\Models\Cidade;
use App\Models\ValePedagio;
use App\Models\InfoDescarga;
use App\Models\NFeDescarga;
use App\Models\CTeDescarga;
use App\Models\UnidadeCarga;
use App\Models\LacreTransporte;
use App\Models\LacreUnidadeCarga;

use App\Models\Veiculo;
use App\Models\Empresas;
use Illuminate\Support\Facades\Auth;

class MdfeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mdfes = Mdfe::all();

        $menos30 = $this->menos30Dias();
        $date = date('d/m/Y');

        return view("home")
            ->with('lista', $mdfes)
            ->with('mdfeEnvioJs', true)
            ->with('links', true)
            ->with('dataInicial', $menos30)
            ->with('dataFinal', $date)
            ->with('title', "Lista de MDF-e");
    }

    public function filtro(Request $request)
    {

        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;
        $estado = $request->estado;

        $mdfes = null;

        if (isset($dataInicial) && isset($dataFinal)) {
            $mdfes = Mdfe::filtroData(
                $this->parseDate($dataInicial),
                $this->parseDate($dataFinal, true),
                $estado
            );
        }

        return view("mdfe/list")
            ->with('mdfes', $mdfes)
            ->with('mdfeEnvioJs', true)
            ->with('dataInicial', $dataInicial)
            ->with('dataFinal', $dataFinal)
            ->with('estado', $estado)
            ->with('title', "Filtro de MDF-e");
    }


    public function nova()
    {
        $lastMdfe = Mdfe::lastMdfe();
        $veiculos = Veiculo::all();
        $empresas = Empresas::all();
        $ufs = Mdfe::cUF();
        $tiposUnidadeTransporte = Mdfe::tiposUnidadeTransporte();

        return view("mdfe/cadastro")
            ->with('veiculos', $veiculos)
            ->with('ufs', $ufs)
            ->with('empresas', $empresas)
            ->with('tiposUnidadeTransporte', $tiposUnidadeTransporte)
            ->with('lastMdfe', $lastMdfe)
            ->with('title', "Cadastro de MDF-e");
    }

    private function menos30Dias()
    {
        return date('d/m/Y', strtotime("-30 days", strtotime(str_replace(
            "/",
            "-",
            date('Y-m-d')
        ))));
    }

    private function parseDate($date, $plusDay = false)
    {
        if ($plusDay == false)
            return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
        else
            return date('Y-m-d', strtotime("+1 day", strtotime(str_replace("/", "-", $date))));
    }

    public function salvar(Request $request)
    {
        $data = $request->data;
        $infoDescarga = $data['infoDescarga'];
        $municipiosCarregamento = $data['municipios_carregamento'];
        $ciot = isset($data['ciot']) ? $data['ciot'] : null;
        $valePedagio = isset($data['vale_pedagio']) ? $data['vale_pedagio'] : null;
        $percurso = $data['percurso'] ?? null;
        $veiculoTracao = $data['veiculo_tracao'];
        $veiculoReboque = $data['veiculo_reboque'];
        $ufInicio = $data['uf_inicio'];
        $ufFim = $data['uf_fim'];
        $dataInicioViagem = $data['data_inicio_viagem'];
        $cargaPosterior = $data['carga_posteior'];
        $cnpjContratante = $data['cnpj_contratante'];
        $seguradoraNome = $data['seguradora_nome'] ?? '';
        $seguradraNumeroApolice = $data['seguradora_numero_apolice'] ?? '';
        $seguradoNumeroAverbacao = $data['seguradora_numero_averbacao'] ?? '';
        $seguradoraCnpj = $data['seguradora_cnpj'] ?? '';
        $valorCarga = str_replace(",", ".", $data['valor_carga']);
        $qtdCarga = str_replace(",", ".", $data['qtd_carga']);
        $infoComplementar = $data['info_complementar'] ?? '';
        $infoFisco = $data['info_fisco'] ?? '';

        $condutorNome = $data['condutor_nome'];
        $condutorCpf = $data['condutor_cpf'];
        $tpEmit = $data['tp_emit'];
        $tpTransp = $data['tp_transp'];
        $lacreRodo = $data['lacre_rodo'];



        $mdfe = Mdfe::create([
            'uf_inicio' => $ufInicio,
            'uf_fim' => $ufFim,
            'encerrado' => false,
            'data_inicio_viagem' => $this->parseDate($dataInicioViagem),
            'carga_posterior' => $cargaPosterior,
            'veiculo_tracao_id' => $veiculoTracao,
            'veiculo_reboque_id' => $veiculoReboque,
            'estado' => 'NOVO',
            'seguradora_nome' => $seguradoraNome,
            'seguradora_cnpj' => $seguradoraCnpj,
            'numero_apolice' => $seguradraNumeroApolice,
            'numero_averbacao' => $seguradoNumeroAverbacao,
            'valor_carga' => $valorCarga,
            'quantidade_carga' => $qtdCarga,
            'info_complementar' => $infoComplementar,
            'info_adicional_fisco' => $infoFisco,
            'cnpj_contratante' => $cnpjContratante,
            'mdfe_numero' => 0,
            'condutor_nome' => $condutorNome,
            'condutor_cpf' => $condutorCpf,
            'tp_emit' => $tpEmit,
            'tp_transp' => $tpTransp,
            'lac_rodo' => $lacreRodo,
            'encerrado' => false,
            'chave' => '',
            'protocolo' => '',

        ]);

        foreach ($municipiosCarregamento as $m) {
            MunicipioCarregamento::create([
                'cidade_id' => $m['id'],
                'mdfe_id' => $mdfe->id
            ]);
        }

        if ($percurso != null) {
            foreach ($percurso as $p) {
                Percurso::create([
                    'uf' => $p,
                    'mdfe_id' => $mdfe->id
                ]);
            }
        }

        if ($valePedagio != null) {
            foreach ($valePedagio as $v) {
                ValePedagio::create([
                    'mdfe_id' => $mdfe->id,
                    'cnpj_fornecedor' => $v['cnpj_fornecedor'],
                    'cnpj_fornecedor_pagador' => $v['doc_pagador'],
                    'numero_compra' => $v['numero_compra'],
                    'valor' => $v['valor']
                ]);
            }
        }

        if ($ciot != null) {
            foreach ($ciot as $c) {
                Ciot::create([
                    'mdfe_id' => $mdfe->id,
                    'cpf_cnpj' => $c['documento'],
                    'codigo' => $c['codigo']

                ]);
            }
        }

        foreach ($infoDescarga as $i) {
            $info = InfoDescarga::create([
                'mdfe_id' => $mdfe->id,
                'tp_unid_transp' => $i['tpTransp'],
                'id_unid_transp' => $i['idUnidTransp'],
                'quantidade_rateio' => $i['qtdRateioTransp'],
                'cidade_id' => (int)explode("-", $i['municipio'])[0]
            ]);

            if ($i['chaveNFe'] || $i['segCodNFe']) {
                NFeDescarga::Create([
                    'info_id' => $info->id,
                    'chave' => str_replace(" ", "", $i['chaveNFe']),
                    'seg_cod_barras' => str_replace(" ", "", $i['segCodNFe'])
                ]);
            }

            if ($i['chaveCTe'] || $i['segCodCTe']) {
                CTeDescarga::Create([
                    'info_id' => $info->id,
                    'chave' => str_replace(" ", "", $i['chaveCTe']),
                    'seg_cod_barras' => str_replace(" ", "", $i['segCodCTe'])
                ]);
            }

            foreach ($i['lacresUnidCarga'] as $l) {
                LacreUnidadeCarga::create([
                    'info_id' => $info->id,
                    'numero' => $l
                ]);
            }

            foreach ($i['lacresUnidTransp'] as $l) {
                LacreTransporte::create([
                    'info_id' => $info->id,
                    'numero' => $l
                ]);
            }

            UnidadeCarga::create([
                'info_id' => $info->id,
                'id_unidade_carga' => $i['idUnidCarga'],
                'quantidade_rateio' => $i['qtdRateioUnidCarga']
            ]);
        }


        echo json_encode($mdfe);
    }

    public function edit($id)
    {
        $mdfe = Mdfe::find($id);

        $lastMdfe = Mdfe::lastMdfe();
        $veiculos = Veiculo::all();
        $config = Empresas::first();
        $ufs = Mdfe::cUF();
        $tiposUnidadeTransporte = Mdfe::tiposUnidadeTransporte();

        $municipiosDeCarregamento = $this->getMunicipiosCarregamento($mdfe);
        $percurso = $this->getPercurso($mdfe);
        $ciots = $this->getCiots($mdfe);
        $valesPedagio = $this->getValesPedagio($mdfe);
        $infoDescarga = $this->getInfoDescarga($mdfe);


        return view("mdfe/register")
            ->with('mdfeJs', true)
            ->with('veiculos', $veiculos)
            ->with('ufs', $ufs)
            ->with('tiposUnidadeTransporte', $tiposUnidadeTransporte)
            ->with('lastMdfe', $lastMdfe->mdfe_numero ?? 'Nulo')
            ->with('mdfe', $mdfe)
            ->with('municipiosDeCarregamento', $municipiosDeCarregamento)
            ->with('percurso', $percurso)
            ->with('ciots', $ciots)
            ->with('valesPedagio', $valesPedagio)
            ->with('infoDescarga', $infoDescarga)
            ->with('title', "Editar MDF-e");
    }

    private function getMunicipiosCarregamento($mdfe)
    {
        $temp = [];
        foreach ($mdfe->municipiosCarregamento as $m) {
            $arr = [
                'id' => $m->cidade->id,
                'nome' => $m->cidade->nome . "(" . $m->cidade->uf . ")"
            ];
            array_push($temp, $arr);
        }
        return $temp;
    }

    private function getPercurso($mdfe)
    {
        $temp = [];
        foreach ($mdfe->percurso as $p) {

            array_push($temp, $p->uf);
        }
        return $temp;
    }

    private function getCiots($mdfe)
    {
        $temp = [];
        foreach ($mdfe->ciots as $c) {
            $arr = [
                'codigo' => $c->codigo,
                'documento' => $c->cpf_cnpj
            ];
            array_push($temp, $arr);
        }
        return $temp;
    }

    private function getValesPedagio($mdfe)
    {
        $temp = [];
        foreach ($mdfe->valesPedagio as $v) {
            $arr = [
                'cnpj_fornecedor' => $v->cnpj_fornecedor,
                'cnpj_fornecedor_pagador' => $v->cnpj_fornecedor_pagador,
                'numero_compra' => $v->numero_compra,
                'valor' => $v->valor
            ];
            array_push($temp, $arr);
        }
        return $temp;
    }

    private function getInfoDescarga($mdfe)
    {
        $temp = [];

        foreach ($mdfe->infoDescarga as $key => $v) {
            $arr = [
                'id' => $key + 1,
                'tpTransp' => $v->tp_unid_transp,
                'idUnidTransp' => $v->id_unid_transp,
                'qtdRateioTransp' => $v->quantidade_rateio,
                'idUnidCarga' => $v->unidadeCarga->id_unidade_carga,
                'qtdRateioUnidCarga' => $v->unidadeCarga->quantidade_rateio,
                'chaveNFe' => $v->nfe ? $v->nfe->chave : '',
                'segCodNFe' => $v->nfe ? $v->nfe->seg_cod_barras : '',
                'chaveCTe' => $v->cte ? $v->cte->chave : '',
                'segCodCTe' => $v->cte ? $v->cte->seg_cod_barras : '',
                'lacresUnidTransp' => $this->getLacresTransp($v),
                'lacresUnidCarga' => $this->getLacresUnidCarga($v),
                'municipio' => $v->cidade->id . " - " . $v->cidade->nome
            ];
            array_push($temp, $arr);
        }
        return $temp;
    }

    private function getLacresTransp($info)
    {
        $temp = [];
        foreach ($info->lacresTransp as $l) {

            array_push($temp, $l->numero);
        }
        return $temp;
    }

    private function getLacresUnidCarga($info)
    {
        $temp = [];
        foreach ($info->lacresUnidCarga as $l) {
            array_push($temp, $l->numero);
        }
        return $temp;
    }

    public function update(Request $request)
    {
        $data = $request->data;
        $infoDescarga = $data['infoDescarga'];
        $municipiosCarregamento = $data['municipios_carregamento'];
        $ciot = isset($data['ciot']) ? $data['ciot'] : null;
        $valePedagio = isset($data['vale_pedagio']) ? $data['vale_pedagio'] : null;
        $percursos = $data['percurso'] ?? null;
        $veiculoTracao = $data['veiculo_tracao'];
        $veiculoReboque = $data['veiculo_reboque'];
        $ufInicio = $data['uf_inicio'];
        $ufFim = $data['uf_fim'];
        $dataInicioViagem = $data['data_inicio_viagem'];
        $cargaPosterior = $data['carga_posteior'];
        $cnpjContratante = $data['cnpj_contratante'];
        $seguradoraNome = $data['seguradora_nome'] ?? '';
        $seguradraNumeroApolice = $data['seguradora_numero_apolice'] ?? '';
        $seguradoNumeroAverbacao = $data['seguradora_numero_averbacao'] ?? '';
        $seguradoraCnpj = $data['seguradora_cnpj'] ?? '';
        $valorCarga = str_replace(",", ".", $data['valor_carga']);
        $qtdCarga = str_replace(",", ".", $data['qtd_carga']);
        $infoComplementar = $data['info_complementar'] ?? '';
        $infoFisco = $data['info_fisco'] ?? '';

        $condutorNome = $data['condutor_nome'];
        $condutorCpf = $data['condutor_cpf'];
        $tpEmit = $data['tp_emit'];
        $tpTransp = $data['tp_transp'];
        $lacreRodo = $data['lacre_rodo'];

        $mdfe = Mdfe::find($data['id']);


        $mdfe->uf_inicio = $ufInicio;
        $mdfe->uf_fim = $ufFim;
        $mdfe->data_inicio_viagem = $this->parseDate($dataInicioViagem);
        $mdfe->carga_posterior = $cargaPosterior;
        $mdfe->veiculo_tracao_id = $veiculoTracao;
        $mdfe->veiculo_reboque_id = $veiculoReboque;
        $mdfe->seguradora_nome = $seguradoraNome;
        $mdfe->seguradora_cnpj = $seguradoraCnpj;
        $mdfe->numero_apolice = $seguradraNumeroApolice;
        $mdfe->numero_averbacao = $seguradoNumeroAverbacao;
        $mdfe->valor_carga = $valorCarga;
        $mdfe->quantidade_carga = $qtdCarga;
        $mdfe->info_complementar = $infoComplementar;
        $mdfe->info_adicional_fisco = $infoFisco;
        $mdfe->cnpj_contratante = $cnpjContratante;
        $mdfe->mdfe_numero = 0;
        $mdfe->condutor_nome = $condutorNome;
        $mdfe->condutor_cpf = $condutorCpf;
        $mdfe->tp_emit = $tpEmit;
        $mdfe->tp_transp = $tpTransp;
        $mdfe->lac_rodo = $lacreRodo;

        $mdfe->save();

        $municipiosTemp = MunicipioCarregamento::where('mdfe_id', $mdfe->id)
            ->get();

        foreach ($municipiosTemp as $temp) {
            $temp->delete();
        }

        foreach ($municipiosCarregamento as $m) {
            MunicipioCarregamento::create([
                'cidade_id' => $m['id'],
                'mdfe_id' => $mdfe->id
            ]);
        }

        $percursosTemp = Percurso::where('mdfe_id', $mdfe->id)
            ->get();

        foreach ($percursosTemp as $temp) {
            $temp->delete();
        }

        if ($percursos != null) {

            foreach ($percursos as $p) {
                // return $p;
                Percurso::create([
                    'uf' => strval($p),
                    'mdfe_id' => $mdfe->id
                ]);
            }
        }


        //limpa ValePedagio
        $vales = ValePedagio::where('mdfe_id', $mdfe->id)
            ->get();
        // add ValePedagio
        foreach ($vales as $v) {
            $v->delete();
        }

        if ($valePedagio != null) {
            foreach ($valePedagio as $v) {
                ValePedagio::create([
                    'mdfe_id' => $mdfe->id,
                    'cnpj_fornecedor' => $v['cnpj_fornecedor'],
                    'cnpj_fornecedor_pagador' => $v['doc_pagador'],
                    'numero_compra' => $v['numero_compra'],
                    'valor' => $v['valor']
                ]);
            }
        }


        $ciots = Ciot::where('mdfe_id', $mdfe->id)
            ->get();

        foreach ($ciots as $c) {
            $c->delete();
        }

        if ($ciot != null) {

            foreach ($ciot as $c) {
                Ciot::create([
                    'mdfe_id' => $mdfe->id,
                    'cpf_cnpj' => $c['documento'],
                    'codigo' => $c['codigo']

                ]);
            }
        }

        $infos = InfoDescarga::where('mdfe_id', $mdfe->id)
            ->get();

        foreach ($infos as $i) {
            $i->delete();
        }

        foreach ($infoDescarga as $i) {

            $info = InfoDescarga::create([
                'mdfe_id' => $mdfe->id,
                'tp_unid_transp' => $i['tpTransp'],
                'id_unid_transp' => $i['idUnidTransp'],
                'quantidade_rateio' => $i['qtdRateioTransp'],
                'cidade_id' => (int)explode("-", $i['municipio'])[0]
            ]);

            if ($i['chaveNFe'] || $i['segCodNFe']) {
                NFeDescarga::Create([
                    'info_id' => $info->id,
                    'chave' => str_replace(" ", "", $i['chaveNFe']),
                    'seg_cod_barras' => str_replace(" ", "", $i['segCodNFe'])
                ]);
            }

            if ($i['chaveCTe'] || $i['segCodCTe']) {
                CTeDescarga::Create([
                    'info_id' => $info->id,
                    'chave' => str_replace(" ", "", $i['chaveCTe']),
                    'seg_cod_barras' => str_replace(" ", "", $i['segCodCTe'])
                ]);
            }

            foreach ($i['lacresUnidCarga'] as $l) {
                LacreUnidadeCarga::create([
                    'info_id' => $info->id,
                    'numero' => $l
                ]);
            }

            foreach ($i['lacresUnidTransp'] as $l) {
                LacreTransporte::create([
                    'info_id' => $info->id,
                    'numero' => $l
                ]);
            }

            UnidadeCarga::create([
                'info_id' => $info->id,
                'id_unidade_carga' => $i['idUnidCarga'],
                'quantidade_rateio' => $i['qtdRateioUnidCarga']
            ]);
        }

        session()->flash('color', 'green');
        session()->flash("message", "MDFe Alterada!");

        echo json_encode($mdfe);
    }
}
