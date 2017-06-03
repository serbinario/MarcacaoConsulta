<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCgm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cgm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf_cnpj', 20);
            $table->string('numero_sus', 20);
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
        Schema::dropIfExists('cgm');
    }
}
