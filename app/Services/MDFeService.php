<?php


namespace App\Services;

use NFePHP\MDFe\Make;
use NFePHP\DA\Legacy\FilesFolders;
use NFePHP\Common\Soap\SoapCurl;
use App\ConfigNota;
use App\Mdfe;
use App\Certificado;
use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

class MDFeService
{

    private $config;

    public function __construct($config)
    {
        $this->config = json_encode($config);
        $certificado = Certificado::first();
        $this->tools = new Tools($this->config, Certificate::readPfx($certificado->arquivo, $certificado->senha));
    }

    public function gerar($mdfe)
    {
        $mdfex = new Make();
        $mdfex->setOnlyAscii(true);

        $emitente = ConfigNota::first();
        $std = new \stdClass();
        $std->cUF = $emitente->cUF;
        $std->tpAmb = (int)$emitente->ambiente;
        $std->tpEmit = $mdfe->tp_emit;
        $std->tpTransp = $mdfe->tp_transp;
        $std->mod = '58';
        $std->serie = '0';



        $mdfeLast = Mdfe::lastMdfe();

        $std->nMDF = $mdfeLast + 1; // ver aqui
        $std->cMDF = rand(11111111, 99999999);
        $std->cDV = '5';
        $std->modal = '1';
        $std->dhEmi = date("Y-m-d\TH:i:sP");
        $std->tpEmis = '1';
        $std->procEmi = '0';
        $std->verProc = '1.6';
        $std->UFIni = $mdfe->uf_inicio;
        $std->UFFim = $mdfe->uf_fim;
        $std->dhIniViagem = $mdfe->data_inicio_viagem . 'T06:00:48-03:00';
        // $std->indCanalVerde = '1';
        // $std->indCarregaPosterior = $mdfe->carga_posterior;
        $mdfex->tagide($std);


        foreach ($mdfe->municipiosCarregamento as $m) {
            $infMunCarrega = new \stdClass();
            $infMunCarrega->cMunCarrega = $m->cidade->codigo;
            $infMunCarrega->xMunCarrega = $m->cidade->nome;
            $mdfex->taginfMunCarrega($infMunCarrega);
        }

        foreach ($mdfe->percurso as $p) {

            $infPercurso = new \stdClass();
            $infPercurso->UFPer = $p->uf;
            $mdfex->taginfPercurso($infPercurso);
        }

        $std = new \stdClass();

        $cnpj = $emitente->cnpj;
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace(".", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $std->CNPJ = str_replace(" ", "", $cnpj);
        $std->IE = $emitente->ie;
        $std->xNome = $emitente->razao_social;
        $std->xFant = $emitente->nome_fantasia;
        $mdfex->tagemit($std);


        $std = new \stdClass();
        $std->xLgr = $emitente->logradouro;
        $std->nro = $emitente->numero;
        $std->xBairro = $emitente->bairro;
        $std->cMun = $emitente->codMun;
        $std->xMun = $emitente->municipio;
        $cep = str_replace("-", "", $emitente->cep);
        $cep = str_replace(".", "", $cep);
        $std->CEP = $cep;
        $std->UF = $emitente->UF;
        $std->fone = '';
        $std->email = '';
        $mdfex->tagenderEmit($std);

        /* Grupo infANTT */
        $infANTT = new \stdClass();
        $infANTT->RNTRC = $mdfe->veiculoTracao->rntrc; // pega antt do veiculo de tracao
        $mdfex->taginfANTT($infANTT);

        foreach ($mdfe->ciots as $c) {
            $infCIOT = new \stdClass();
            $infCIOT->CIOT = $c->codigo;

            $doc = str_replace("-", "", $c->cpf_cnpj);
            $doc = str_replace(".", "", $doc);
            $doc = str_replace("/", "", $doc);
            if (strlen($doc) == 11) $infCIOT->CPF = $doc;
            else $infCIOT->CNPJ = $doc;


            $mdfe->taginfCIOT($infCIOT);
        }

        foreach ($mdfe->valesPedagio as $v) {
            $valePed = new \stdClass();
            $valePed->CNPJForn = $v->cnpj_fornecedor;
            $doc = str_replace("-", "", $v->cnpj_fornecedor_pagador);
            $doc = str_replace(".", "", $doc);
            $doc = str_replace("/", "", $doc);
            if (strlen($doc) == 11) $valePed->CPFPg = $doc;
            else $valePed->CNPJPg = $doc;

            $valePed->nCompra = $v->numero_compra;
            $valePed->vValePed = $this->format($v->vpopmail_error());
            $mdfex->tagdisp($valePed);
        }

        $infContratante = new \stdClass();
        $doc = str_replace("-", "", $mdfe->cnpj_contratante);
        $doc = str_replace(".", "", $doc);
        $doc = str_replace("/", "", $doc);
        $infContratante->CNPJ = $doc;
        $mdfex->taginfContratante($infContratante);

        /* Grupo veicTracao */
        $veicTracao = new \stdClass();
        $veicTracao->cInt = '01';
        $placa = str_replace("-", "", $mdfe->veiculoTracao->placa);
        $veicTracao->placa = strtoupper($placa);
        $veicTracao->tara = $mdfe->veiculoTracao->tara;
        $veicTracao->capKG = $mdfe->veiculoTracao->capacidade;
        $veicTracao->tpRod = $mdfe->veiculoTracao->tipo_rodado;
        $veicTracao->tpCar = $mdfe->veiculoTracao->tipo_carroceira;
        $veicTracao->UF = $mdfe->veiculoTracao->uf;

        $condutor = new \stdClass();
        $condutor->xNome = $mdfe->condutor_nome; // banco
        $condutor->CPF = $mdfe->condutor_cpf; // banco
        $veicTracao->condutor = [$condutor];

        $prop = new \stdClass();

        $doc = str_replace("-", "", $mdfe->veiculoTracao->proprietario_documento);
        $doc = str_replace(".", "", $doc);
        $doc = str_replace("/", "", $doc);
        if (strlen($doc) == 11) $prop->CPF = $doc;
        else $prop->CNPJ = $doc;

        $prop->RNTRC = $mdfe->veiculoTracao->rntrc;
        $prop->xNome = $mdfe->veiculoTracao->proprietario_nome;
        $prop->IE = $mdfe->veiculoTracao->proprietario_ie;
        $prop->UF = $mdfe->veiculoTracao->uf;
        $prop->tpProp = $mdfe->veiculoTracao->proprietario_tp;
        $veicTracao->prop = $prop;

        $mdfex->tagveicTracao($veicTracao);

        /* fim veicTracao */

        /* Grupo veicReboque */
        $veicReboque = new \stdClass();
        $veicReboque->cInt = '02';
        $placa = str_replace("-", "", $mdfe->veiculoReboque->placa);

        $veicReboque->placa = strtoupper($placa);
        $veicReboque->tara = $mdfe->veiculoReboque->tara;
        $veicReboque->capKG = $mdfe->veiculoReboque->capacidade;
        $veicReboque->tpCar = $mdfe->veiculoReboque->tipo_carroceira;
        $veicReboque->UF = $mdfe->veiculoReboque->uf;

        $prop = new \stdClass();
        $doc = str_replace("-", "", $mdfe->veiculoReboque->proprietario_documento);
        $doc = str_replace(".", "", $doc);
        $doc = str_replace("/", "", $doc);
        if (strlen($doc) == 11) $prop->CPF = $doc;
        else $prop->CNPJ = $doc;

        $prop->RNTRC = $mdfe->veiculoReboque->rntrc;
        $prop->xNome = $mdfe->veiculoReboque->proprietario_nome;
        $prop->IE = $mdfe->veiculoReboque->proprietario_ie;
        $prop->UF = $mdfe->veiculoReboque->uf;
        $prop->tpProp = $mdfe->veiculoReboque->proprietario_tp;
        $veicReboque->prop = $prop;
        $mdfex->tagveicReboque($veicReboque);

        $lacRodo = new \stdClass();
        $lacRodo->nLacre = $mdfe->lac_rodo; //ver no banco
        $mdfex->taglacRodo($lacRodo);


        /*
		 * Grupo infDoc ( Documentos fiscais )
		 */
        $cont = 0;
        $contNFe = 0;
        $contCTe = 0;
        foreach ($mdfe->infoDescarga as $info) {
            $infMunDescarga = new \stdClass();
            $infMunDescarga->cMunDescarga = $info->cidade->codigo;
            $infMunDescarga->xMunDescarga = $info->cidade->nome;
            $infMunDescarga->nItem = 0;
            $mdfex->taginfMunDescarga($infMunDescarga);

            /* infCTe */
            // $std = new \stdClass();
            // $std->chCTe = $info->cte->chave;
            // $std->SegCodBarra = '';
            // $std->indReentrega = '1';
            // $std->nItem = $cont;


            if ($info->nfe->chave) {
                $std = new \stdClass();
                $std->chNFe = $info->nfe->chave;
                $std->SegCodBarra = '';
                $std->indReentrega = '1';
                $std->nItem = $cont;
                $contNFe++;
            } else {

                /* infCTe */
                $std = new \stdClass();
                $std->chCTe = $info->cte->chave;
                $std->SegCodBarra = '';
                $std->indReentrega = '1';
                $std->nItem = $cont;
                $contCTe++;
            }

            /* Informações das Unidades de Transporte (Carreta/Reboque/Vagão) */
            $stdinfUnidTransp = new \stdClass();
            $stdinfUnidTransp->tpUnidTransp = $info->tp_unid_transp;
            $stdinfUnidTransp->idUnidTransp = strtoupper($info->id_unid_transp);

            /* Lacres das Unidades de Transporte */

            $lacres = [];
            foreach ($info->lacresTransp as $l) {
                array_push($lacres, $l->numero);
            }
            $stdlacUnidTransp = new \stdClass();
            $stdlacUnidTransp->nLacre = $lacres;

            $stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

            /* Informações das Unidades de Carga (Containeres/ULD/Outros) */
            $stdinfUnidCarga = new \stdClass();
            $stdinfUnidCarga->tpUnidCarga = '1';
            $stdinfUnidCarga->idUnidCarga = $info->unidadeCarga->id_unidade_carga;


            /* Lacres das Unidades de Carga */
            $lacres = [];
            foreach ($info->lacresUnidCarga as $l) {
                array_push($lacres, $l->numero);
            }
            $stdlacUnidCarga = new \stdClass();
            $stdlacUnidCarga->nLacre = $lacres;


            $stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
            $stdinfUnidCarga->qtdRat = $info->unidadeCarga->quantidade_rateio;

            $stdinfUnidTransp->infUnidCarga = [$stdinfUnidCarga];
            $stdinfUnidTransp->qtdRat = $info->quantidade_rateio;

            $std->infUnidTransp = [$stdinfUnidTransp];

            $mdfex->taginfNFe($std);

            $cont++;
        }

        /* Grupo do Seguro */
        if ($mdfe->seguradora_cnpj != null) {
            $std = new \stdClass();
            $std->respSeg = '1';

            /* Informações da seguradora */
            $stdinfSeg = new \stdClass();
            $stdinfSeg->xSeg = $mdfe->seguradora_nome;
            $stdinfSeg->CNPJ = $mdfe->seguradora_cnpj;

            $std->infSeg = $stdinfSeg;
            $std->nApol = $mdfe->numero_apolice;
            $std->nAver = [$mdfe->numero_averbacao];
            $mdfe->tagseg($std);
            /* fim grupo Seguro */
        }


        /* grupo de totais */
        $std = new \stdClass();
        $std->vCarga = $this->format($mdfe->valor_carga);
        $std->cUnid = '01';
        $std->qNFe = $contNFe;
        $std->qCTe = $contCTe;
        $std->qCarga = $mdfe->quantidade_carga;
        $mdfex->tagtot($std);
        /* fim grupo de totais */


        $std = new \stdClass();
        $std->CNPJ = str_replace(" ", "", $emitente->cnpj);
        $mdfex->tagautXML($std);

        // $xml = $mdfex->getXML();
        // header("Content-type: text/xml");

        // return [
        // 	'xml' => $xml,
        // 	'numero' => $mdfeLast+1
        // ];

        try {
            $xml = $mdfex->getXML();
            header("Content-type: text/xml");

            return [
                'xml' => $xml,
                'numero' => $mdfeLast + 1
            ];
        } catch (\Exception $e) {
            return [
                'erros_xml' => $mdfex->getErrors()
            ];
        }
    }

    public function format($number, $dec = 2)
    {
        return number_format((float) $number, $dec, ".", "");
    }

    public function sign($xml)
    {
        return $this->tools->signMDFe($xml);
    }

    public function transmitir($signXml)
    {
        try {
            $resp = $this->tools->sefazEnviaLote([$signXml], rand(1, 10000));

            $st = new Standardize();
            $std = $st->toStd($resp);


            sleep(2);

            $resp = $this->tools->sefazConsultaRecibo($std->infRec->nRec);
            $std = $st->toStd($resp);

            if (!isset($std->protMDFe)) {
                return [
                    'erro' => true,
                    'message' => 'Tente enviar novamente em minutos!',
                    'cStat' => '999'
                ];
            }

            $chave = $std->protMDFe->infProt->chMDFe;
            $cStat = $std->protMDFe->infProt->cStat;




            if ($cStat == '100') {
                $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
                file_put_contents($public . 'xml_mdfe/' . $chave . '.xml', $signXml);
                return [
                    'chave' => $chave,
                    'protocolo' => $std->protMDFe->infProt->nProt,
                    'cStat' => $cStat
                ];
            } else {
                return [
                    'erro' => true,
                    'message' => $std->protMDFe->infProt->xMotivo,
                    'cStat' => $cStat
                ];
            }
            return $std->protMDFe->infProt->chMDFe;
        } catch (\Exception $e) {
            return [
                'erro' => true,
                'message' => $e->getMessage(),
                'cStat' => ''
            ];
        }
    }


    public function naoEncerrados()
    {
        try {

            $resp = $this->tools->sefazConsultaNaoEncerrados();

            $st = new Standardize();
            $std = $st->toArray($resp);

            return $std;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function encerrar($chave, $protocolo)
    {
        try {
            $emitente = ConfigNota::first();
            $chave = $chave;
            $nProt = $protocolo;
            $cUF = $emitente->cUF;
            $cMun = $emitente->codMun;
            $dtEnc = date('Y-m-d'); // Opcional, caso nao seja preenchido pegara HOJE
            $resp = $this->tools->sefazEncerra($chave, $nProt, $cUF, $cMun, $dtEnc);

            $st = new Standardize();
            $std = $st->toStd($resp);

            return $std;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function consultar($chave)
    {
        try {

            $chave = $chave;
            $resp = $this->tools->sefazConsultaChave($chave);

            $st = new Standardize();
            $std = $st->toStd($resp);

            return $std;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function cancelar($chave, $protocolo, $justificativa)
    {
        try {


            $xJust = $justificativa;
            $nProt = $protocolo;

            $chave = $chave;
            $resp = $this->tools->sefazCancela($chave, $xJust, $nProt);

            $st = new Standardize();
            $std = $st->toStd($resp);
            return $std;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
