<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('date');
            $table->integer('duration')->comment('Durée en minutes');
            $table->string('description');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
