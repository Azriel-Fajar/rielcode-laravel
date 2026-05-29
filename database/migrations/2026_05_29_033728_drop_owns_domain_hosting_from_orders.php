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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['owns_domain', 'owns_hosting']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('owns_domain', ['Yes', 'No'])->default('No')->after('custom_config');
            $table->enum('owns_hosting', ['Yes', 'No'])->default('No')->after('owns_domain');
        });
    }
};
