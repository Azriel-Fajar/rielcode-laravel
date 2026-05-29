<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('packages', 'included_addons')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->json('included_addons')->nullable()->after('features_json');
            });
        }
        if (! Schema::hasColumn('packages', 'included_tiers')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->json('included_tiers')->nullable()->after('included_addons');
            });
        }
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['included_addons', 'included_tiers']);
        });
    }
};
