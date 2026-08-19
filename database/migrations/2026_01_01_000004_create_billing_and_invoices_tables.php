<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_invoices', function (Blueprint $table) {
            $table->string('invoice_number', 50)->primary(); // INV/BULANAN/YYYYMM/XXXX
            $table->string('internet_number', 50);
            $table->string('package_code', 50);
            $table->integer('billing_month'); // 1 - 12
            $table->integer('billing_year');  // 2026
            $table->string('billing_period_text', 100);
            
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->string('discount_note')->nullable();
            $table->decimal('ppn_amount', 15, 2)->default(0);
            $table->decimal('penalty_amount', 15, 2)->default(0); // Denda
            $table->decimal('total_amount', 15, 2);
            
            $table->enum('payment_status', ['UNPAID', 'PENDING', 'PAID', 'EXPIRED', 'CANCELED'])->default('UNPAID');
            $table->string('payment_method', 50)->nullable(); // MIDTRANS, BANK_TRANSFER, CASH
            $table->string('payment_channel', 50)->nullable(); // BCA_VA, QRIS, MANDIRI, DLL
            $table->decimal('amount_paid', 15, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Data Midtrans & Pembayaran
            $table->json('payment_gateway_response')->nullable();
            $table->string('merchant_fee', 50)->nullable();
            $table->text('adjustment_note')->nullable();
            $table->string('pdf_invoice_path')->nullable();

            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions');
            $table->foreign('package_code')->references('code')->on('bandwidth_packages');
        });

        Schema::create('registration_invoices', function (Blueprint $table) {
            $table->string('invoice_number', 50)->primary(); // INV/PSB/YYYYMM/XXXX
            $table->string('internet_number', 50);
            $table->decimal('registration_fee', 15, 2);
            $table->decimal('ppn_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->enum('payment_status', ['UNPAID', 'PENDING', 'PAID', 'CANCELED'])->default('UNPAID');
            $table->string('payment_method', 50)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions');
        });

        Schema::create('customer_devices', function (Blueprint $table) {
            $table->id();
            $table->string('internet_number', 50);
            $table->string('device_type', 50); // ONT, ROUTER, STB
            $table->string('brand', 50)->nullable(); // ZTE, Huawei, FiberHome
            $table->string('model', 50)->nullable();
            $table->string('serial_number', 100)->unique();
            $table->string('mac_address', 50)->nullable();
            $table->enum('ownership_status', ['RENTAL', 'PURCHASED'])->default('RENTAL');
            $table->date('installed_at')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_devices');
        Schema::dropIfExists('registration_invoices');
        Schema::dropIfExists('monthly_invoices');
    }
};
