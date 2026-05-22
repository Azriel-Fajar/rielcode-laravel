<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('package_name', 20);
            $table->integer('idr_price');
            $table->decimal('us_price', 10, 2)->default(0.00);
            $table->smallInteger('orders')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
