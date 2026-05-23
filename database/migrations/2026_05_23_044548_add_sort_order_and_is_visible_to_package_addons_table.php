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
        Schema::table('package_addons', function (Blueprint $table) {
            if (!Schema::hasColumn('package_addons', 'is_visible')) {
                $table->boolean('is_visible')->default(true)->after('type');
            }
            if (!Schema::hasColumn('package_addons', 'sort_order')) {
                $table->unsignedSmallInteger('sort_order')->default(0)->after('is_visible');
            }
            if (!Schema::hasColumn('package_addons', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_addons', function (Blueprint $table) {
            $table->dropColumn(['is_visible', 'sort_order', 'updated_at']);
        });
    }
};
