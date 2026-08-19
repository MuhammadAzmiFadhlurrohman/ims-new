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
        Schema::create('bandwidth_categories', function (Blueprint $table) {
            $table->string('code', 50)->primary(); // e.g. MSN-HOME
            $table->string('name');
            $table->string('alias_name')->nullable();
            $table->decimal('registration_fee', 15, 2)->default(0);
            $table->boolean('has_registration_ppn')->default(false);
            $table->decimal('registration_ppn_percent', 5, 2)->default(11);
            $table->boolean('has_billing_ppn')->default(false);
            $table->decimal('billing_ppn_percent', 5, 2)->default(11);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bandwidth_packages', function (Blueprint $table) {
            $table->string('code', 50)->primary(); // e.g. HOME-20M
            $table->string('category_code', 50);
            $table->string('name');
            $table->integer('speed_mbps');
            $table->decimal('price', 15, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_code')->references('code')->on('bandwidth_categories')->onDelete('cascade');
        });

        Schema::create('pops', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('odps', function (Blueprint $table) {
            $table->string('code', 50)->primary(); // e.g. ODP-MSN-01
            $table->string('pop_code', 50)->nullable();
            $table->string('name');
            $table->integer('total_ports')->default(8);
            $table->integer('used_ports')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('pop_code')->references('code')->on('pops')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odps');
        Schema::dropIfExists('pops');
        Schema::dropIfExists('bandwidth_packages');
        Schema::dropIfExists('bandwidth_categories');
    }
};
