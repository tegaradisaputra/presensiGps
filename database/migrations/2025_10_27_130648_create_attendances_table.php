<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->date('attendance_date');
            $table->time('time_in')->nullalbe();
            $table->time('time_out')->nullalbe();
            $table->string('photo_in')->nullalbe();
            $table->string('photo_out')->nullalbe();
            $table->string('location')->nullalbe();
            $table->timestamps();

            $table->foreign('nik')
                    ->references('nik')
                    ->on('employees')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
