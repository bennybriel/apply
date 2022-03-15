<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUGStudentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_g_student_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('matricno');
            $table->string('session');
            $table->string('semester');
            $table->string('description');
           // $table->int('level');
            $table->double('debit');
            $table->double('credit');
            $table->double('amount');
            $table->boolean('ispaid');
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
        Schema::dropIfExists('u_g_student_accounts');
    }
}
