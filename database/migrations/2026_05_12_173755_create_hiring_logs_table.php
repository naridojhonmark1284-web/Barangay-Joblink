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
        Schema::create('hiring_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->date('hiring_date');
            $table->date('completion_date')->nullable();
            $table->decimal('actual_wages_earned', 10, 2)->nullable();
            $table->boolean('is_completed')->default(false);

            $table->timestamps();

            $table->unique('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_logs');
    }
};
