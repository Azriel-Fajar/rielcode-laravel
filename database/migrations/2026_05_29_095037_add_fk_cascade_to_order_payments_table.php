<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove any orphaned payments so the FK can be created.
        DB::table('order_payments')
            ->whereNotIn('order_id', fn ($q) => $q->select('id')->from('orders'))
            ->delete();

        Schema::table('order_payments', function (Blueprint $table) {
            // Match orders.id (signed INT) so the FK type-checks.
            $table->integer('order_id')->change();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
    }
};
