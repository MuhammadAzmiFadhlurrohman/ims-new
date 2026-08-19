<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('olts', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('pop_code', 50)->nullable();
            $table->string('name');
            $table->string('ip_address', 45)->nullable();
            $table->string('brand', 50)->nullable(); // ZTE, Huawei, HSGQ
            $table->integer('total_pon_ports')->default(8);
            $table->timestamps();

            $table->foreign('pop_code')->references('code')->on('pops')->nullOnDelete();
        });

        Schema::create('pon_ports', function (Blueprint $table) {
            $table->id();
            $table->string('olt_code', 50);
            $table->integer('port_number');
            $table->integer('total_subscribers')->default(0);
            $table->timestamps();

            $table->foreign('olt_code')->references('code')->on('olts')->onDelete('cascade');
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('category_code', 50);
            $table->string('name');
            $table->string('brand', 50)->nullable();
            $table->string('unit', 20)->default('PCS');
            $table->integer('stock')->default(0);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('category_code')->references('code')->on('item_categories')->onDelete('cascade');
        });

        Schema::create('subscription_logs', function (Blueprint $table) {
            $table->id();
            $table->string('internet_number', 50);
            $table->string('action', 50);
            $table->text('description')->nullable();
            $table->string('performed_by', 100)->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
        });

        Schema::create('work_order_teams', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->string('leader_name')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_teams');
        Schema::dropIfExists('subscription_logs');
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_categories');
        Schema::dropIfExists('pon_ports');
        Schema::dropIfExists('olts');
    }
};
