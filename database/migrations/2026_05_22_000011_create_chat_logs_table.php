<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->text('user_message');
            $table->text('bot_reply');
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('tag', 50);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->unsignedInteger('input_tokens')->nullable();
            $table->unsignedInteger('output_tokens')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_logs');
    }
};
