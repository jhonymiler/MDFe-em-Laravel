<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MDFeService;
use App\Models\ConfigNota;
use App\Models\Mdfe;
use NFePHP\DA\MDFe\Damdfe;
use Mail;

class EmiteMdfeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function enviar(Request $request)
    {

        $mdfe = Mdfe::where('id', $request->id)
            ->first();

        $config = ConfigNota::first();
        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);

        $mdfe_service = new MDFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => (int)$config->ambiente,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
            "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
            "schemes" => "PL_MDFe_300a",
            "versao" => '3.00'
        ]);


        $xml = $mdfe_service->gerar($mdfe);
        $resultado = false;


        if ($mdfe->estado == 'NOVO' || $mdfe->estado == 'REJEITADO') {
            header('Content-type: text/html; charset=UTF-8');
            $xml = $mdfe_service->gerar($mdfe);
            if (!isset($xml['erros_xml'])) {


                $signed = $mdfe_service->sign($xml['xml']);


                header("Content-type: text/xml");

                print_r($signed);
                exit();
                $resultado = $mdfe_service->transmitir($signed);

                if (!isset($resultado['erro'])) {
                    $mdfe->chave = $resultado['chave'];
                    $mdfe->protocolo = $resultado['protocolo'];

                    $mdfe->estado = 'APROVADO';

                    $mdfe->mdfe_numero = $xml['numero'];
                    $mdfe->save();
                    return response()->json($resultado, 200);
                } else {
                    $mdfe->estado = 'REJEITADO';
                    $mdfe->save();

                    return response()->json($resultado, 403);
                }
                echo json_encode($resultado);
            } else {
                return response()->json($xml['erros_xml'], 401);
            }
        } else {
            return response()->json("erro", 401);
        }
    }

    public function naoEncerrados()
    {


        $config = ConfigNota::first();
        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);

        $mdfe_service = new MDFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => (int)$config->ambiente,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
            "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
            "schemes" => "PL_MDFe_300a",
            "versao" => '3.00'
        ]);

        $resultados = $mdfe_service->naoEncerrados();
        // echo '<pre>';
        // print_r($resultados);
        // echo "</pre>";

        $naoEncerrados = [];

        if ($resultados['xMotivo'] != 'Consulta não encerrados não localizou MDF-e nessa situação') {
            $array = [
                'chave' => $resultados['infMDFe']['chMDFe'],
                'protocolo' => $resultados['infMDFe']['nProt'],
                'numero' => 0,
                'data' => ''
            ];

            array_push($naoEncerrados, $array);
        }

        $naoEncerrados = $this->percorreDatabaseNaoEncerrados($naoEncerrados);

        return view('mdfe/naoEncerrados')
            ->with('title', 'MDF-e não encerrados')
            ->with('naoEncerradosMDFeJS', true)
            ->with('mdfes', $naoEncerrados);
    }

    private function percorreDatabaseNaoEncerrados($naoEncerrados)
    {
        for ($aux = 0; $aux < count($naoEncerrados); $aux++) {
            $mdfe = Mdfe::where('chave', $naoEncerrados[$aux]['chave'])
                ->first();

            if ($mdfe != null) {
                $naoEncerrados[$aux]['data'] = $mdfe->created_at;
                $naoEncerrados[$aux]['numero'] = $mdfe->mdfe_numero;
            }
        }
        return $naoEncerrados;
    }

    public function encerrar(Request $request)
    {
        $docs = $request->data;

        $config = ConfigNota::first();
        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);

        $mdfe_service = new MDFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => (int)$config->ambiente,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
            "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
            "schemes" => "PL_MDFe_300a",
            "versao" => '3.00'
        ]);

        foreach ($docs as $d) {
            $mdfe = Mdfe::where('chave', $d['chave'])
                ->first();

            $mdfe_service->encerrar($d['chave'], $d['protocolo']);
            if ($mdfe != null) {
                $mdfe->encerrado = true;
                $mdfe->save();
            }
        }

        return response()->json(true, 200);
    }

    public function imprimir($id)
    {

        $mdfe = Mdfe::find($id);

        $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
        $xml = file_get_contents($public . 'xml_mdfe/' . $mdfe->chave . '.xml');
        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents($public . 'imgs/logo.png'));


        try {
            $damdfe = new Damdfe($xml);
            $damdfe->debugMode(true);
            $damdfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
            $pdf = $damdfe->render($logo);
            header('Content-Type: application/pdf');
            echo $pdf;
        } catch (Exception $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }

    public function consultar(Request $request)
    {
        $mdfe = Mdfe::find($request->id);

        if ($mdfe->estado == 'APROVADO' || $mdfe->estado == 'CANCELADO') {
            $config = ConfigNota::first();
            $cnpj = str_replace(".", "", $config->cnpj);
            $cnpj = str_replace("/", "", $cnpj);
            $cnpj = str_replace("-", "", $cnpj);
            $cnpj = str_replace(" ", "", $cnpj);

            $mdfe_service = new MDFeService([
                "atualizacao" => date('Y-m-d h:i:s'),
                "tpAmb" => (int)$config->ambiente,
                "razaosocial" => $config->razao_social,
                "siglaUF" => $config->UF,
                "cnpj" => $cnpj,
                "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
                "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
                "schemes" => "PL_MDFe_300a",
                "versao" => '3.00'
            ]);

            $mdfe = Mdfe::find($request->id);
            $result = $mdfe_service->consultar($mdfe->chave);

            return response()->json($result, 200);
        } else {
            return response()->json("Erro ao consultar", 404);
        }
    }

    public function cancelar(Request $request)
    {
        $mdfe = Mdfe::find($request->id);

        if ($mdfe->estado == 'APROVADO') {
            $config = ConfigNota::first();
            $cnpj = str_replace(".", "", $config->cnpj);
            $cnpj = str_replace("/", "", $cnpj);
            $cnpj = str_replace("-", "", $cnpj);
            $cnpj = str_replace(" ", "", $cnpj);

            $mdfe_service = new MDFeService([
                "atualizacao" => date('Y-m-d h:i:s'),
                "tpAmb" => (int)$config->ambiente,
                "razaosocial" => $config->razao_social,
                "siglaUF" => $config->UF,
                "cnpj" => $cnpj,
                "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
                "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
                "schemes" => "PL_MDFe_300a",
                "versao" => '3.00'
            ]);

            $mdfe = Mdfe::find($request->id);
            $result = $mdfe_service->cancelar($mdfe->chave, $mdfe->protocolo, $request->justificativa);

            if ($result->infEvento->cStat == '101' || $result->infEvento->cStat == '135' || $result->infEvento->cStat == '155') {
                return response()->json($result, 200);
            } else {

                return response()->json($result, 401);
            }
        } else {
            return response()->json("Erro a MDF-e precisa estar atutorizada para cancelar", 404);
        }
    }

    public function enviarXml(Request $request)
    {

        $email = $request->email;
        $id = $request->id;
        $mdfe = Mdfe::find($id);
        $this->criarPdfParaEnvio($mdfe);
        $value = session('user_logged');
        Mail::send('mail.xml_send_mdfe', ['emissao' => $mdfe->created_at, 'mdfe' => $mdfe->numero, 'usuario' => $value['nome']], function ($m) use ($mdfe, $email) {
            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
            $nomeEmpresa = getenv('SMS_NOME_EMPRESA');
            $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
            $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
            $emailEnvio = getenv('MAIL_USERNAME');

            $m->from($emailEnvio, $nomeEmpresa);
            $m->subject('Envio de XML MDF-e ' . $mdfe->numero);
            $m->attach($public . 'xml_mdfe/' . $mdfe->chave . '.xml');
            $m->attach($public . 'pdf/MDFe.pdf');
            $m->to($email);
        });
        return "ok";
    }

    private function criarPdfParaEnvio($mdfe)
    {
        $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
        $xml = file_get_contents($public . 'xml_mdfe/' . $mdfe->chave . '.xml');
        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents($public . 'imgs/logo.jpg'));
        // $docxml = FilesFolders::readFile($xml);

        try {

            $damdfe = new Damdfe($xml);
            $damdfe->debugMode(true);
            $damdfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
            $pdf = $damdfe->render($logo);
            header('Content-Type: application/pdf');
            file_put_contents($public . 'pdf/MDFe.pdf', $pdf);
        } catch (InvalidArgumentException $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }

    public function gerarXml($id)
    {

        $mdfe = Mdfe::where('id', $id)
            ->first();

        $config = ConfigNota::first();
        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);

        $mdfe_service = new MDFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => (int)$config->ambiente,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "inscricaomunicipal" => getenv("INSCRICAO_MUNICIPAL"),
            "codigomunicipio" => getenv("CODIGO_MUNICIPIO"),
            "schemes" => "PL_MDFe_300a",
            "versao" => '3.00'
        ]);

        $xml = $mdfe_service->gerar($mdfe);
        $resultado = false;

        $xml = $mdfe_service->gerar($mdfe);
        if (!isset($xml['erros_xml'])) {


            $signed = $mdfe_service->sign($xml['xml']);
        }
    }
}
