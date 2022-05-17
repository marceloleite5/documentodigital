<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->unsignedBigInteger('tipodocumento_id');
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumento');
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('setor');
            $table->unsignedBigInteger('filial_id');
            $table->foreign('filial_id')->references('id')->on('filial');
            $table->string('armario', 10);
            $table->string('gaveta', 10);
            $table->string('pasta', 10);
            $table->date('data_documento');
            $table->date('data_inclusao');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento');
    }
}
