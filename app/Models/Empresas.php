<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
        'razao_social', 'nome_fantasia', 'cnpj', 'ie', 'logradouro',
        'numero', 'bairro', 'municipio', 'codMun', 'pais', 'codPais',
        'fone', 'cep', 'UF', 'cUF', 'email', 'ultimo_numero_mdfe', 'certificado_a3'
    ];


    public static function tiposPagamento()
    {
        return [
            '01' => 'Dinheiro',
            '02' => 'Cheque',
            '03' => 'Cartão de Crédito',
            '04' => 'Cartão de Débito',
            '05' => 'Crédito Loja',
            '10' => 'Vale Alimentação',
            '11' => 'Vale Refeição',
            '12' => 'Vale Presente',
            '13' => 'Vale Combustível',
            '14' => 'Duplicata Mercantil',
            '15' => 'Boleto Bancário',
            '90' => 'Sem pagamento',
            '99' => 'Outros',
        ];
    }

    public static function listaCST()
    {
        return [
            '00' => 'Tributa integralmente',
            '10' => 'Tributada e com cobrança do ICMS por substituição tributária',
            '20' => 'Com redução da Base de Calculo',
            '30' => 'Isenta / não tributada e com cobrança do ICMS por substituição tributária',
            '40' => 'Isenta',
            '41' => 'Não tributada',
            '50' => 'Com suspensão',
            '51' => 'Com diferimento',
            '60' => 'ICMS cobrado anteriormente por substituição tributária',
            '70' => 'Com redução da BC e cobrança do ICMS por substituição tributária',
            '90' => 'Outras',

            '101' => 'Tributada pelo Simples Nacional com permissão de crédito',
            '102' => 'Tributada pelo Simples Nacional sem permissão de crédito',
            '103' => 'Isenção do ICMS no Simples Nacional para faixa de receita bruta',
            '201' => 'Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por substituição tributária',
            '202' => 'Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por substituição tributária',
            '203' => 'Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS por substituição tributária',
            '300' => 'Imune',
            '400' => 'Não tributada pelo Simples Nacional',
            '500' => 'ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação',
            '900' => 'Outros'
        ];
    }

    public static function listaCST_PIS_COFINS()
    {
        return [
            '01' => 'Operação Tributável com Alíquota Básica',
            '02' => 'Operação Tributável com Alíquota por Unidade de Medida de Produto',
            '03' => 'Operação Tributável com Alíquota por Unidade de Medida de Produto',
            '04' => 'Operação Tributável Monofásica – Revenda a Alíquota Zero',
            '05' => 'Operação Tributável por Substituição Tributária',
            '06' => 'Operação Tributável a Alíquota Zero',
            '07' => 'Operação Isenta da Contribuição',
            '08' => 'Operação sem Incidência da Contribuição',
            '09' => 'Operação com Suspensão da Contribuição',
            '49' => 'Outras Operações de Saída'
        ];
    }

    public static function listaCST_IPI()
    {
        return [
            '50' => 'Saída Tributada',
            '51' => 'Saída Tributável com Alíquota Zero',
            '52' => 'Saída Isenta',
            '53' => 'Saída Não Tributada',
            '54' => 'Saída Imune',
            '55' => 'Saída com Suspensão',
            '99' => 'Outras Saídas'
        ];
    }

    public static function tiposFrete()
    {

        return [
            '0' => 'Emitente',
            '1' => 'Destinatário',
            '2' => 'Terceiros',
            '9' => 'Sem Frete',
        ];
    }

    public static function estados()
    {
        return [
            '11' => 'RO',
            '12' => 'AC',
            '13' => 'AM',
            '14' => 'RR',
            '15' => 'PA',
            '16' => 'AP',
            '17' => 'TO',
            '21' => 'MA',
            '22' => 'PI',
            '23' => 'CE',
            '24' => 'RN',
            '25' => 'PB',
            '26' => 'PE',
            '27' => 'AL',
            '28' => 'SE',
            '29' => 'BA',
            '31' => 'MG',
            '32' => 'ES',
            '33' => 'RJ',
            '35' => 'SP',
            '41' => 'PR',
            '42' => 'SC',
            '43' => 'RS',
            '50' => 'MS',
            '51' => 'MT',
            '52' => 'GO',
            '53' => 'DF'
        ];
    }


    public static function getUF($cUF)
    {
        foreach (Empresas::estados() as $key => $u) {
            if ($cUF == $key) {
                return $u;
            }
        }
    }

    public static function getCodUF($uf)
    {
        foreach (Empresas::estados() as $key => $u) {
            if ($uf == $u) {
                return $key;
            }
        }
    }
}
