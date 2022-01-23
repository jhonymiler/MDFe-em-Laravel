<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use PhpParser\Node\Stmt\TryCatch;

class VeiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id = false)
    {
        try {
            $Veiculo = '';
            if ($id) {
                $Veiculo = Veiculo::find($id);
            }

            $tipos = Veiculo::tipos();
            $tiposRodado = Veiculo::tiposRodado();
            $tiposCarroceria = Veiculo::tiposCarroceria();
            $tiposProprietario = Veiculo::tiposProprietario();
            $ufs = Veiculo::cUF();

            return view('veiculos/veiculos', [
                'campos' => $Veiculo,
                'tipos' => $tipos,
                'tiposRodado' => $tiposRodado,
                'tiposCarroceria' => $tiposCarroceria,
                'tiposProprietario' => $tiposProprietario,
                'estados' => $ufs,
                'title' => 'Cadastrar Veiculo',
                'lista' => Veiculo::all(),
                'link_menu' => 'veiculos'
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function save(Request $request)
    {
        try {
            if ($request->id == 0) {
                $veiculo = new Veiculo();
                $this->_validate($request);

                $resp = $veiculo->create($request->all());

                if ($resp) {
                    session()->flash('msg', [
                        'tipo' => 'sucesso',
                        'msg' => 'Veiculo cadastrado com sucesso.'
                    ]);
                } else {
                    session()->flash('msg', [
                        'tipo' => 'sucesso',
                        'msg' => 'Erro ao cadastrar veiculo.'
                    ]);
                }
            } else {
                $veiculo = new Veiculo();

                $id = $request->input('id');
                $resp = $veiculo->find($request->id);
                $this->_validate($request);

                $resp->cor = $request->input('cor');
                $resp->marca = $request->input('marca');
                $resp->modelo = $request->input('modelo');
                $resp->placa = $request->input('placa');
                $resp->tipo = $request->input('tipo');
                $resp->uf = $request->input('uf');
                $resp->rntrc = $request->input('rntrc');
                $resp->tipo = $request->input('tipo');
                $resp->tipo_carroceria = $request->input('tipo_carroceria');
                $resp->tipo_rodado = $request->input('tipo_rodado');
                $resp->tara = $request->input('tara');
                $resp->capacidade = $request->input('capacidade');
                $resp->proprietario_nome = $request->input('proprietario_nome');
                $resp->proprietario_ie = $request->input('proprietario_ie');
                $resp->proprietario_uf = $request->input('proprietario_uf');
                $resp->proprietario_tp = $request->input('proprietario_tp');
                $resp->proprietario_documento = $request->input('proprietario_documento');


                $result = $resp->save();
                if ($result) {
                    session()->flash('msg', [
                        'tipo' => 'sucesso',
                        'msg' => 'Gravado com sucesso'
                    ]);
                } else {
                    session()->flash('msg', [
                        'tipo' => 'sucesso',
                        'msg' => 'O Veículo não pode ser gravado.'
                    ]);
                }
            }
            return redirect("/veiculos/{$resp->id}");
        } catch (\Exception $e) {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => $e->getMessage()
            ]);
            return redirect("/veiculos");
        }
    }
    public function excluir($id)
    {
        try {
            $delete = Veiculo::find($id)->delete();
            if ($delete) {
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
        } catch (\Exception $e) {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => $e->getMessage()
            ]);
        }
        return redirect('/veiculos');
    }
    public function excluirMultiplos(Request $req)
    {
        $delete = Veiculo::destroy($req->get('selAll'));
        if ($delete) {
            session()->flash('msg', [
                'tipo' => 'sucesso',
                'msg' => "Veículos excluídos com sucesso."
            ]);
        } else {
            session()->flash('msg', [
                'tipo' => 'erro',
                'msg' => "As Veículos não puderam ser excluídos."
            ]);
        }
        return redirect("/veiculos");
    }

    private function _validate(Request $request)
    {
        $rules = [
            'placa' => 'required|max:8',
            'cor' => 'required|max:10',
            'marca' => 'required|max:20',
            'modelo' => 'required|max:20',
            'tara' => 'required|max:10',
            'rntrc' => 'required',
            'capacidade' => 'required|max:10',
            'proprietario_nome' => 'required|max:40',
            'proprietario_ie' => 'required|max:13',
            'proprietario_documento' => 'required|max:20',
        ];

        $messages = [
            'placa.required' => 'O campo placa é obrigatório.',
            'placa.max' => '8 caracteres maximos permitidos.',
            'cor.required' => 'O campo cor é obrigatório.',
            'cor.max' => '10 caracteres maximos permitidos.',
            'marca.required' => 'O campo marca é obrigatório.',
            'marca.max' => '20 caracteres maximos permitidos.',
            'modelo.required' => 'O campo modelo é obrigatório.',
            'modelo.max' => '20 caracteres maximos permitidos.',

            'tara.required' => 'O campo tara é obrigatório.',
            'tara.max' => '10 caracteres maximos permitidos.',
            'rntrc.required' => 'O campo RNTRC é obrigatório.',

            'proprietario_nome.required' => 'O campo Nome proprietário é obrigatório.',
            'proprietario_nome.max' => '40 caracteres maximos permitidos.',
            'proprietario_ie.required' => 'O campo I.E proprietário é obrigatório.',
            'proprietario_ie.max' => '13 caracteres maximos permitidos.',
            'proprietario_documento.required' => 'O campo CPF/CNPJ proprietário é obrigatório.',
            'proprietario_documento.max' => '20 caracteres maximos permitidos.'
        ];
        $this->validate($request, $rules, $messages);
    }
}
