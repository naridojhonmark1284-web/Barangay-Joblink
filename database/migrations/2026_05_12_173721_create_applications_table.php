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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_post_id')
                  ->constrained('job_posts')
                  ->onDelete('cascade');

            $table->foreignId('job_seeker_id')
                  ->costrained('job_seekers')
                  ->onDelete('cascade');
            
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();

            $table->unique(['job_post_id', 'job_seeker_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
