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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id(); 

            $table->char('nik', 10); 
            $table->date('leave_date'); 

            $table->char('leave_type', 1)
                ->comment('i = leave, s = sick'); 

            $table->string('description', 255)->nullable(); 

            $table->char('approval_status', 1)
                ->default('0')
                ->comment('0 = Pending, 1 = Approved, 2 = Rejected'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};