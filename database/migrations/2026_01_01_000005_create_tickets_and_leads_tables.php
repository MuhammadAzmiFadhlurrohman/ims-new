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
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('ticket_number', 50)->primary();
            $table->string('internet_number', 50);
            $table->string('reporter_name');
            $table->string('reporter_phone', 25);
            $table->string('category', 50); // LOS, LAMBAT, KABEL_PUTUS, BILLING, LAINNYA
            $table->enum('priority', ['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'])->default('MEDIUM');
            $table->text('description');
            $table->enum('status', ['OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED'])->default('OPEN');
            $table->string('assigned_technician')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->string('optical_power_dbm', 20)->nullable(); // e.g. -19.5 dBm
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions');
        });

        Schema::create('coverage_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number', 25);
            $table->text('address');
            $table->string('lat_long')->nullable();
            $table->string('status', 30)->default('NEW'); // NEW, IN_COVERAGE, OUT_OF_COVERAGE, CONVERTED
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('company_banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name', 50); // BCA, Mandiri, BNI, BRI
            $table->string('account_number', 50);
            $table->string('account_holder');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('whatsapp_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('api_url');
            $table->string('api_key')->nullable();
            $table->string('sender_number', 25)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone', 25);
            $table->text('message');
            $table->enum('status', ['PENDING', 'SENT', 'FAILED'])->default('PENDING');
            $table->text('response_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
        Schema::dropIfExists('whatsapp_gateways');
        Schema::dropIfExists('company_banks');
        Schema::dropIfExists('coverage_leads');
        Schema::dropIfExists('tickets');
    }
};
