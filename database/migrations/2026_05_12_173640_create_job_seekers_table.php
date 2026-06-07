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
        Schema::create('job_seekers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('barangay_zone_id')
                  ->constrained('barangay_zones')
                  ->onDelete('cascade');
            
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number');
            $table->text('address');
            $table->string('education_level')->nullable();
            $table->integer('years_experience')->default(0);
            $table->decimal('preferred_daily_wage', 10, 2)->nullable();
            $table->boolean('is_verified')->default(false);

            $table->timestamps();

            $table->index('user_id');
            $table->index('barangay_zone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seekers');
    }
};
