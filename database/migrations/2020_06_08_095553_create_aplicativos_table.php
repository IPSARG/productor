<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('categoria_id');
            $table->text('titulo',1000);
            $table->text('novedades',5000)->nullable();
            $table->text('descripcion',5000)->nullable();
            $table->text('nota',5000)->nullable();
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
        Schema::dropIfExists('aplicativos');
    }
}
