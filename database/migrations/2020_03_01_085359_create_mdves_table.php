<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdves', function (Blueprint $table) {
            $table->increments('id');

            $table->string('uf_inicio', 2);
            $table->string('uf_fim', 2);
            $table->boolean('encerrado');
            $table->date('data_inicio_viagem');
            $table->boolean('carga_posterior');
            $table->string('cnpj_contratante', 18);

            $table->integer('veiculo_tracao_id')->unsigned();
            $table->foreign('veiculo_tracao_id')->references('id')
            ->on('veiculos');

            $table->integer('veiculo_reboque_id')->unsigned();
            $table->foreign('veiculo_reboque_id')->references('id')
            ->on('veiculos');

            $table->string('estado', 20);
            $table->integer('mdfe_numero');
            $table->string('chave', 44);
            $table->string('protocolo', 16);

            $table->string('seguradora_nome', 30);
            $table->string('seguradora_cnpj', 18);
            $table->string('numero_apolice', 15);
            $table->string('numero_averbacao', 40);

            $table->decimal('valor_carga', 10, 2);
            $table->decimal('quantidade_carga', 10, 4);
            $table->string('info_complementar', 60);
            $table->string('info_adicional_fisco', 60);

            $table->string('condutor_nome', 60);
            $table->string('condutor_cpf', 15);
            $table->string('lac_rodo', 8);
            $table->integer('tp_emit');
            $table->integer('tp_transp');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mdves');
    }
}
