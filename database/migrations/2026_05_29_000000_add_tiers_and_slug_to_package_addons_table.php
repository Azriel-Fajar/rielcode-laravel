<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_addons', function (Blueprint $table) {
            if (!Schema::hasColumn('package_addons', 'slug')) {
                $table->string('slug', 60)->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('package_addons', 'tiers')) {
                $table->json('tiers')->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_addons', function (Blueprint $table) {
            $table->dropColumn(['slug', 'tiers']);
        });
    }
};
