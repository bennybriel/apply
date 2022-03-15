<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUGParentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_g_parent_infos', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('othername');
            $table->string('matricno');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('relation');
            $table->boolean('status');
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
        Schema::dropIfExists('u_g_parent_infos');
    }
}
