<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativosRsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativos_rs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aplicativos_id');
            $table->text('posicion');
            $table->text('titulo');
            $table->text('version');
            $table->text('link',3000);
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
        Schema::dropIfExists('aplicativos_rs');
    }
}
