<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('audit_log')) return;
        Schema::create('audit_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_code', 32)->index();
            $table->enum('severity', ['info', 'warn', 'error'])->default('info');
            $table->string('actor', 120)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('ref_table', 64)->nullable();
            $table->unsignedInteger('ref_id')->nullable();
            $table->string('message', 255)->nullable();
            $table->json('meta')->nullable();
            $table->dateTime('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
