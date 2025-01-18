<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAptDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('apt_doctors', function (Blueprint $table) {
            $table->foreignId('id_apt')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('id_doctors')->constrained('users')->onDelete('cascade');
            $table->primary(['id_apt', 'id_doctors']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('apt_doctors');
    }
}
