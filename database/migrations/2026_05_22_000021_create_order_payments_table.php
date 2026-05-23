<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('order_payments')) Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->enum('stage', ['deposit', 'final']);
            $table->string('invoice_number', 30)->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('currency', ['IDR', 'USD'])->default('IDR');
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue'])->default('draft');
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['order_id', 'stage']);
        });

        if (!Schema::hasTable('invoice_counter')) Schema::create('invoice_counter', function (Blueprint $table) {
            $table->year('year')->primary();
            $table->integer('last_number')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_counter');
        Schema::dropIfExists('order_payments');
    }
};
