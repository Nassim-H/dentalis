<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users');
            $table->datetime('start_datetime'); // Start date and time of availability
            $table->datetime('end_datetime');   // End date and time of availability
        });
    }

    public function down()
    {
        Schema::dropIfExists('availabilities');
    }
}
