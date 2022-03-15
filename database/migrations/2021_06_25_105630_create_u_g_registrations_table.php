<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUGRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_g_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('firstname');
            $table->string('othername')->nullable();
            $table->string('email')->unique();
            $table->string('matricno')->unique();
            $table->string('phone');
            $table->string('gender');
            $table->date('dob');
            $table->string('maritalstatus');
            $table->string('town');
            $table->string('state');
            $table->string('address');
            $table->string('photo');
            $table->boolean('status')->nullable();
            $table->boolean('isgraduate')->nullable();
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
        Schema::dropIfExists('u_g_registrations');
    }
}
