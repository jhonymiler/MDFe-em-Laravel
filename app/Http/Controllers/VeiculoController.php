<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

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
}
