<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mdfe extends Model
{
    protected $table = "mdfes";

    protected $fillable = [
        'uf_inicio', 'uf_fim', 'encerrado', 'data_inicio_viagem', 'carga_posterior', 'veiculo_tracao_id',
        'veiculo_reboque_id', 'estado', 'seguradora_nome', 'seguradora_cnpj', 'numero_apolice',
        'numero_averbacao', 'valor_carga', 'quantidade_carga', 'info_complementar',
        'info_adicional_fisco', 'cnpj_contratante', 'mdfe_numero', 'condutor_nome', 'condutor_cpf',
        'tp_emit', 'tp_transp', 'lac_rodo', 'chave', 'protocolo'
    ];

    public function veiculoTracao()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_tracao_id');
    }
    public function veiculoReboque()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_reboque_id');
    }

    public function municipiosCarregamento()
    {
        return $this->hasMany('App\Model\MunicipioCarregamento', 'mdfe_id', 'id');
    }

    public function ciots()
    {
        return $this->hasMany('App\Model\Ciot', 'mdfe_id', 'id');
    }

    public function percurso()
    {
        return $this->hasMany('App\Model\Percurso', 'mdfe_id', 'id');
    }

    public function valesPedagio()
    {
        return $this->hasMany('App\Model\ValePedagio', 'mdfe_id', 'id');
    }

    public function infoDescarga()
    {
        return $this->hasMany('App\Model\InfoDescarga', 'mdfe_id', 'id');
    }

    public static function filtroData($dataInicial, $dataFinal, $estado)
    {
        $c = Mdfe::whereBetween('created_at', [
            $dataInicial,
            $dataFinal
        ]);

        if ($estado != 'TODOS') $c->where('estado', $estado);

        return $c->get();
    }

    public static function lastMdfe()
    {
        $mdfe = Mdfe::where('mdfe_numero', '!=', 0)
            ->orderBy('mdfe_numero', 'desc')
            ->first();

        if ($mdfe == null) {
            return Empresas::first()->ultimo_numero_mdfe;
        } else {
            $configNum = Empresas::first()->ultimo_numero_mdfe;
            return $configNum > $mdfe->mdfe_numero ? $configNum : $mdfe->mdfe_numero;
        }
    }

    public function itens()
    {
        return $this->hasMany('App\Model\ItemVenda', 'venda_id', 'id');
    }

    public static function cUF()
    {
        return [
            '12' => 'AC',
            '27' => 'AL',
            '13' => 'AM',
            '16' => 'AP',
            '29' => 'BA',
            '23' => 'CE',
            '53' => 'DF',
            '32' => 'ES',
            '52' => 'GO',
            '21' => 'MA',
            '31' => 'MG',
            '50' => 'MS',
            '51' => 'MT',
            '15' => 'PA',
            '25' => 'PB',
            '26' => 'PE',
            '22' => 'PI',
            '41' => 'PR',
            '33' => 'RJ',
            '24' => 'RN',
            '11' => 'RO',
            '14' => 'RR',
            '43' => 'RS',
            '42' => 'SC',
            '28' => 'SE',
            '35' => 'SP',
            '17' => 'TO'
        ];
    }

    public static function tiposUnidadeTransporte()
    {
        return [
            '1' => 'Rodoviário Tração',
            '2' => 'Rodoviário Reboque',
            '3' => 'Navio',
            '4' => 'Balsa',
            '5' => 'Aeronave',
            '6' => 'Vagão',
            '7' => 'Outros'
        ];
    }
}
