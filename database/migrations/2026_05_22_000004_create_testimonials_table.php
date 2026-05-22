<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('client_name', 80);
            $table->string('business_name', 100);
            $table->string('role_title', 80);
            $table->tinyInteger('rating');
            $table->string('project_url', 255);
            $table->text('problem_before');
            $table->text('solution_after');
            $table->text('recommendation');
            $table->string('headline', 120)->nullable();
            $table->string('client_email', 120)->nullable();
            $table->boolean('consent_given')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->dateTime('submitted_at')->useCurrent();
            $table->dateTime('reviewed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('invite_token', 64)->nullable()->unique();
            $table->boolean('token_used')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
