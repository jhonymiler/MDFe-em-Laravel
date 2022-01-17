<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Empresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao_social', 200);
            $table->string('nome_fantasia', 200);
            $table->string('cnpj', 19);
            $table->string('ie', 20);
            $table->string('email', 200);
            $table->string('logradouro', 200);

            $table->string('numero', 10);
            $table->string('bairro', 200);
            $table->string('fone', 100);
            $table->string('cep', 10);
            $table->string('pais', 20);
            $table->string('municipio', 200);
            $table->integer('codPais');
            $table->integer('codMun');
            $table->char('UF', 2);

            $table->string('cUF', 2);

            $table->integer('ultimo_numero_mdfe');

            $table->integer('certificado')->default(0);

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
        //
    }
}
