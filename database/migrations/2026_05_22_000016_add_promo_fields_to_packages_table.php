<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('packages', 'slug')) Schema::table('packages', function (Blueprint $table) {
            $table->string('slug', 30)->nullable()->unique()->after('id');
            $table->integer('original_idr')->nullable()->after('idr_price');
            $table->decimal('original_us', 10, 2)->nullable()->after('us_price');
            $table->unsignedSmallInteger('delivery_days_min')->default(3)->after('original_us');
            $table->unsignedSmallInteger('delivery_days_max')->default(7)->after('delivery_days_min');
            $table->boolean('includes_free_hosting')->default(false)->after('delivery_days_max');
            $table->boolean('includes_free_domain')->default(false)->after('includes_free_hosting');
            $table->boolean('is_popular')->default(false)->after('includes_free_domain');
            $table->enum('badge_color', ['green', 'blue', 'amber', 'gray'])->default('blue')->after('is_popular');
            $table->string('blurb', 255)->nullable()->after('badge_color');
            $table->longText('features_json')->nullable()->after('blurb');
            $table->boolean('is_visible')->default(true)->after('features_json');
            $table->unsignedSmallInteger('sort_order')->default(0)->after('is_visible');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'slug','original_idr','original_us','delivery_days_min','delivery_days_max',
                'includes_free_hosting','includes_free_domain','is_popular','badge_color',
                'blurb','features_json','is_visible','sort_order',
            ]);
        });
    }
};
