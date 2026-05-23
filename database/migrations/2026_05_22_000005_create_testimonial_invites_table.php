<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('testimonial_invites')) return;
        Schema::create('testimonial_invites', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('token', 64)->unique();
            $table->string('label', 200)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('used_at')->nullable();
            $table->integer('testimonial_id')->nullable();
            $table->foreign('testimonial_id')->references('id')->on('testimonials')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_invites');
    }
};
