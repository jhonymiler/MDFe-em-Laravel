<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Veiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa', 8);
            $table->string('uf', 2);
            $table->string('cor', 10);
            $table->string('marca', 20);
            $table->string('modelo', 20);
            $table->string('rntrc', 12);


            $table->string('tipo', 2);
            $table->string('tipo_carroceria', 2);
            $table->string('tipo_rodado', 2);

            $table->string('tara', 10);
            $table->string('capacidade', 10);

            $table->string('proprietario_documento', 20);
            $table->string('proprietario_nome', 40);
            $table->string('proprietario_ie', 13);
            $table->string('proprietario_uf', 2);
            $table->integer('proprietario_tp');


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
        Schema::dropIfExists('veiculos');
    }
}
