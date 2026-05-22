<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('order_name', 30);
            $table->string('email', 50);
            $table->enum('package', ['Student Plan', 'Starter Plan', 'Pro Plan', 'Premium Plan', 'Custom Plan']);
            $table->integer('package_id');
            $table->enum('custom_preset', ['blank', 'copy', 'ecommerce'])->nullable();
            $table->string('copy_source_url', 500)->nullable();
            $table->json('custom_config')->nullable();
            $table->enum('owns_domain', ['Yes', 'No'])->default('No');
            $table->enum('owns_hosting', ['Yes', 'No'])->default('No');
            $table->string('phone_number', 13);
            $table->string('description', 255);
            $table->enum('status', ['Pending', 'On Progress', 'Staging Ready', 'Completed'])->default('Pending');
            $table->enum('project_stage', ['pending', 'design', 'development', 'qa', 'delivered', 'closed'])->default('pending');
            $table->string('staging_url', 255)->nullable();
            $table->string('invoice_number', 50);
            $table->string('invoice_file', 255)->nullable();
            $table->enum('invoice_sent', ['pending', 'sent', 'failed'])->default('pending');
            $table->enum('invoice_status', ['draft', 'sent', 'paid', 'void'])->default('draft');
            $table->decimal('invoice_amount', 12, 2)->nullable();
            $table->enum('invoice_currency', ['IDR', 'USD'])->default('IDR');
            $table->date('invoice_due_date')->nullable();
            $table->text('invoice_notes')->nullable();
            $table->json('invoice_line_items')->nullable();
            $table->integer('package_price')->default(0);
            $table->integer('addons_total')->default(0);
            $table->integer('final_price')->default(0);
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('payment_method', 50)->nullable()->default('Bank Transfer');
            $table->string('referral_code', 20)->nullable();

            $table->foreign('package_id')->references('id')->on('packages')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
