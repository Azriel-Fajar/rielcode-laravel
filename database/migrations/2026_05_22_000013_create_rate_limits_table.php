<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('rate_limits')) return;
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45)->index();
            $table->enum('bucket', ['hour', 'day', 'tokens_day']);
            $table->dateTime('window_start')->index();
            $table->unsignedInteger('counter')->default(0);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['ip_address', 'bucket', 'window_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
