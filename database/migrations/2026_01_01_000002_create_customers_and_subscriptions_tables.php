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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('nik', 50)->primary();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('email', 100)->nullable()->index();
            $table->string('phone_number', 25)->index();
            $table->string('alt_phone_number', 25)->nullable();
            $table->text('id_card_address');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('village_code', 20)->nullable(); // Kelurahan KTP
            $table->timestamps();
        });

        Schema::create('customer_subscriptions', function (Blueprint $table) {
            $table->string('internet_number', 50)->primary(); // Nomor Internet / Pelanggan
            $table->string('customer_nik', 50);
            $table->string('customer_name');
            $table->string('package_code', 50);
            $table->string('pop_code', 50)->nullable();
            $table->string('odp_code', 50)->nullable();
            $table->integer('odp_port')->nullable();
            
            // Lokasi Pemasangan
            $table->text('installation_address');
            $table->string('building_number', 10)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('village_code', 20)->nullable();
            $table->string('building_type', 50)->nullable();
            $table->string('lat_long')->nullable();
            $table->text('maps_url')->nullable();

            // Data Teknis & MikroTik
            $table->string('ont_username', 50)->nullable();
            $table->string('ont_password', 50)->nullable();
            $table->string('pppoe_profile', 50)->nullable();
            $table->string('media_access', 50)->default('FIBER_OPTIC');
            
            // Status & Billing Cycle
            $table->string('registration_status', 10)->default('REG'); // REG, SUR, INS, AKT, LIVE, DLL
            $table->integer('billing_cycle_day')->default(1); // Tanggal jatuh tempo (1-31)
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->string('discount_note')->nullable();
            $table->boolean('is_isolated')->default(false);
            $table->boolean('is_terminated')->default(false);
            $table->boolean('is_locked')->default(false);
            
            $table->string('sales_name', 100)->nullable();
            $table->timestamps();

            $table->foreign('customer_nik')->references('nik')->on('customers');
            $table->foreign('package_code')->references('code')->on('bandwidth_packages');
            $table->foreign('pop_code')->references('code')->on('pops');
            $table->foreign('odp_code')->references('code')->on('odps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_subscriptions');
        Schema::dropIfExists('customers');
    }
};
