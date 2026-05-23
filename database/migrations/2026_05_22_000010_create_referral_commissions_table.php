<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('referral_commissions')) return;
        Schema::create('referral_commissions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('referrer_id');
            $table->integer('order_id');
            $table->decimal('order_amount', 15, 2);
            $table->decimal('commission_amount', 15, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('referrer_id')->references('id')->on('referrers');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_commissions');
    }
};
