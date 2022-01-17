<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        $cidades = Cidade::all();
        $arr = array();
        foreach ($cidades as $c) {
            $arr[$c->id . ' - ' . $c->nome . '(' . $c->uf . ')'] = null;
            //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function find($id)
    {
        $cidade = Cidade::where('id', $id)
            ->first();
        echo json_encode($cidade);
    }

    public function findNome($nome)
    {
        $cidade = Cidade::where('nome', $nome)
            ->first();
        echo json_encode($cidade);
    }
}
