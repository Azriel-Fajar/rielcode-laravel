<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('projects')) return;
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('title', 150);
            $table->string('slug', 160)->unique()->default('');
            $table->text('description');
            $table->string('image_path', 255);
            $table->string('url', 255)->nullable();
            $table->string('tags', 255)->nullable()->comment('comma-separated');
            $table->string('stack', 255)->nullable();
            $table->enum('layout', ['featured', 'side'])->default('side');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
