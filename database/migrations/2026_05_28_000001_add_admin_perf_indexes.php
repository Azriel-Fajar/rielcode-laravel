<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status', 'orders_status_index');
            $table->index('invoice_status', 'orders_invoice_status_index');
            $table->index('created_at', 'orders_created_at_index');
        });

        Schema::table('chat_logs', function (Blueprint $table) {
            $table->index('created_at', 'chat_logs_created_at_index');
        });

        Schema::table('referral_commissions', function (Blueprint $table) {
            $table->index('status', 'referral_commissions_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_status_index');
            $table->dropIndex('orders_invoice_status_index');
            $table->dropIndex('orders_created_at_index');
        });

        Schema::table('chat_logs', function (Blueprint $table) {
            $table->dropIndex('chat_logs_created_at_index');
        });

        Schema::table('referral_commissions', function (Blueprint $table) {
            $table->dropIndex('referral_commissions_status_index');
        });
    }
};
