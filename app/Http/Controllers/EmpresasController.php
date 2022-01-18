<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Certificado;
use NFePHP\Common\Certificate;

class EmpresasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tela de cadastro das empresas
     *
     * @param bool $id
     *
     * @return void
     */
    public function index($id = false)
    {

        try {
            if ($id) {
                $config = Empresas::find($id);
                $certificado = Certificado::find($config->id);
            } else {
                $config = '';
                $certificado = '';
            }
            $infoCertificado = null;
            if ($certificado != null) {
                $infoCertificado = $this->getInfoCertificado($certificado);
            }
            $cUF = Empresas::estados();
            $soapDesativado = !extension_loaded('soap');

            return view('empresas', [
                'campos' => $config,
                'infoCertificado' => $infoCertificado,
                'soapDesativado' => $soapDesativado,
                'estados' => Empresas::estados(),
                'certificado' => $certificado,
                'lista' => Empresas::all(),
                'link_menu' => 'empresas'
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo "<br><a href='/empresas/deleteCertificado'>Remover Certificado</a>";
        }
    }


    /**
     * Gravar e Editar Empresa
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function save(Request $request)
    {
        $this->_validate($request);
        try {
            if ($request->id == 0) {
                $config = Empresas::create([
                    'razao_social' => strtoupper($this->sanitizeString($request->razao_social)),
                    'nome_fantasia' => strtoupper($this->sanitizeString($request->nome_fantasia)),
                    'cnpj' => $request->cnpj,
                    'ie' => $request->ie,
                    'logradouro' => strtoupper($this->sanitizeString($request->logradouro)),
                    'numero' => strtoupper($this->sanitizeString($request->numero)),
                    'bairro' => strtoupper($this->sanitizeString($request->bairro)),
                    'cep' => $request->cep,
                    'email' => $request->email,
                    'municipio' => strtoupper($this->sanitizeString($request->municipio)),
                    'codMun' => $request->codMun,
                    'codPais' => $request->codPais,
                    'UF' => $request->UF,
                    'pais' => strtoupper($request->pais),
                    'fone' => $this->sanitizeString($request->fone),
                    'cUF' => Empresas::getCodUF($request->UF),

                    'ultimo_numero_mdfe' => $request->ultimo_numero_mdfe

                ]);
                session()->flash('msg', [
                    'tipo' => 'sucesso',
                    'msg' => 'Gravado com sucesso'
                ]);
            } else {
                $config = Empresas::find($request->id);

                $config->razao_social = strtoupper($this->sanitizeString($request->razao_social));
                $config->nome_fantasia = strtoupper($this->sanitizeString($request->nome_fantasia));
                $config->cnpj = $this->sanitizeString($request->cnpj);
                $config->ie = $this->sanitizeString($request->ie);
                $config->logradouro = strtoupper($this->sanitizeString($request->logradouro));
                $config->numero = strtoupper($this->sanitizeString($request->numero));
                $config->bairro = strtoupper($this->sanitizeString($request->bairro));
                $config->cep = $request->cep;
                $config->email = $request->email;
                $config->municipio = strtoupper($this->sanitizeString($request->municipio));
                $config->codMun = $request->codMun;
                $config->codPais = $request->codPais;
                $config->UF = $request->UF;
                $config->pais = strtoupper($request->pais);
                $config->fone = $request->fone;

                $config->cUF = Empresas::getCodUF($request->UF);

                $config->ultimo_numero_mdfe = $request->ultimo_numero_mdfe;


                $config->save();
                session()->flash('msg', [
                    'tipo' => 'sucesso',
                    'msg' => 'Atualizado com sucesso'
                ]);
            }

            return redirect("/empresas/{$config->id}");
        } catch (\Exception $e) {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => $e->getMessage()
            ]);
            return redirect("/empresas");
        }
    }

    /**
     * Excluir empresa
     *
     * @param [type] $id
     *
     * @return void
     */
    public function excluir($id)
    {
        $res = Empresas::find($id)->delete();
        if ($res) {
            session()->flash('msg', [
                'tipo' => 'sucesso',
                'msg' => 'Empresa excluída com sucesso.'
            ]);
        } else {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => 'A empresa não pode ser excluída.'
            ]);
        }
        return redirect("/empresas");
    }

    /**
     * Função para excluir múltiplas empresas
     *
     * @param \Illuminate\Http\Request $req
     *
     * @return void
     */
    public function excluirMultiplos(Request $req)
    {
        $delete = Empresas::destroy($req->get('selAll'));
        if ($delete) {
            session()->flash('msg', [
                'tipo' => 'sucesso',
                'msg' => "Empresas excluídas com sucesso."
            ]);
        } else {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => "As empresas não puderam ser excluídas."
            ]);
        }
        return redirect("/empresas");
    }


    /**
     * Validação do formulário de empresas
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    private function _validate(Request $request)
    {
        $rules = [
            'razao_social' => 'required|max:100',
            'nome_fantasia' => 'required|max:80',
            'cnpj' => 'required',
            'ie' => 'required',
            'logradouro' => 'required|max:80',
            'numero' => 'required|max:10',
            'bairro' => 'required|max:50',
            'fone' => 'required',
            'cep' => 'required',
            'municipio' => 'required',
            'pais' => 'required',

            'codPais' => 'required|min:4',
            'codMun' => 'required|min:7',
            'UF' => 'required|max:2|min:2',

            'ultimo_numero_mdfe' => 'required',


        ];

        $messages = [
            'razao_social.required' => 'O Razão social nome é obrigatório.',
            'razao_social.max' => '100 caracteres maximos permitidos.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'nome_fantasia.max' => '80 caracteres maximos permitidos.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'ie.required' => 'O campo Inscrição Estadual é obrigatório.',
            'logradouro.max' => '80 caracteres maximos permitidos.',
            'numero.required' => 'O campo Numero é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'municipio.required' => 'O campo Municipio é obrigatório.',
            'numero.max' => '10 caracteres maximos permitidos.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'bairro.max' => '50 caracteres maximos permitidos.',
            'fone.required' => 'O campo Telefone é obrigatório.',

            'uf.required' => 'O campo UF é obrigatório.',
            'uf.max' => 'UF inválida.',
            'uf.min' => 'UF inválida.',

            'pais.required' => 'O campo Pais é obrigatório.',
            'codPais.required' => 'O campo Código do Pais é obrigatório.',
            'codPais.min' => 'Informe 1058 para Brasil.',
            'codMun.required' => 'O campo Código do Municipio é obrigatório.',
            'codMun.min' => 'Informe no minimo 7 caracteres, código IBGE.',

            'ultimo_numero_mdfe.required' => 'O último número do MDFE deve ser informado.',


        ];
        $this->validate($request, $rules, $messages);
    }

    /**
     * Upload do arquivo do certificado digital
     *
     * @return void
     */
    public function certificado()
    {
        return view('empresas/upload', [
            'titulo', 'Upload de Certificado',
            'link_menu' => 'empresas'
        ]);
    }

    /**
     * Download do arquivo de certificado digital
     *
     * @return void
     */
    public function download()
    {
        $certificado = Certificado::first();
        // echo "Senha: " . $certificado->senha;
        try {
            file_put_contents(public_path('cd.bin'), $certificado->arquivo);
            return response()->download(public_path('cd.bin'));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Senha do certificado digital
     *
     * @return void
     */
    public function senha()
    {
        $certificado = Certificado::first();
        echo "Senha: " . $certificado->senha;
    }

    /**
     * Salvar certificado digital no banco de dados
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function saveCertificado(Request $request)
    {

        if ($request->hasFile('file') && strlen($request->senha) > 0) {
            $file = $request->file('file');
            $temp = file_get_contents($file);

            $res = Certificado::create([
                'senha' => $request->senha,
                'arquivo' => $temp
            ]);

            if ($res) {
                session()->flash('color', 'green');
                session()->flash("message", "Upload de certificado realizado!");
                return redirect('/empresas');
            }
        } else {
            session()->flash('color', 'red');
            session()->flash("message", "Envie o arquivo e senha por favor!");
            return redirect('/empresas/certificado');
        }
    }

    public function getCertificado(Request $request)
    {
        if ($request->hasFile('file') && strlen($request->senha) > 0) {
            $file = $request->file('file');
            $temp = file_get_contents($file);

            try {
                $certificado = Certificate::readPfx($temp, $request->senha);
                return response()->json($certificado->publicKey, 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 200);
            }
        }
    }


    /**
     * Trás as informaçoes do certificado digital
     *
     * @param [type] $certificado
     *
     * @return void
     */
    private function getInfoCertificado($certificado)
    {

        $infoCertificado =  Certificate::readPfx($certificado->arquivo, $certificado->senha);

        $publicKey = $infoCertificado->publicKey;

        $inicio =  $publicKey->validFrom->format('Y-m-d H:i:s');
        $expiracao =  $publicKey->validTo->format('Y-m-d H:i:s');

        return [
            'serial' => $publicKey->serialNumber,
            'inicio' => \Carbon\Carbon::parse($inicio)->format('d-m-Y H:i'),
            'expiracao' => \Carbon\Carbon::parse($expiracao)->format('d-m-Y H:i'),
            'id' => $publicKey->commonName
        ];
    }

    /**
     * Exclui o certificado digital
     *
     * @return void
     */
    public function deleteCertificado()
    {
        Certificado::truncate();
        session()->flash('color', 'green');
        session()->flash("message", "Certificado Removido!");
        return redirect('empresas');
    }

    function sanitizeString($str)
    {
        return preg_replace('{\W}', ' ', preg_replace('{ +}', ' ', strtr(
            utf8_decode(html_entity_decode($str)),
            utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
            'AAAAEEIOOOUUCNaaaaeeiooouucn'
        )));
    }
}
