<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('job_category_id')->nullable();

            $table->string('title');
            $table->text('description');
            $table->decimal('daily_wage', 10, 2);
            $table->integer('vacancies')->default(1);
            $table->string('location')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('open');

            $table->timestamps();

            $table->index('employer_id');
            $table->index('job_category_id');
            $table->index('status');

            $table->foreign('employer_id')
                ->references('id')
                ->on('employers')
                ->onDelete('cascade');

            $table->foreign('job_category_id')
                ->references('id')
                ->on('job_categories')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};