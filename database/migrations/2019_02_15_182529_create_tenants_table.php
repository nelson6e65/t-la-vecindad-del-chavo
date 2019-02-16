<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('title_id')->nullable();
            $table->string('name');
            $table->json('nicknames');
            $table->integer('number');
            $table->timestamps();

            $table->foreign('title_id')
                ->references('id')->on('titles')
                ->onDelete('set null');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tenants');
        Schema::enableForeignKeyConstraints();
    }
}
