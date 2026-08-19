<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_mutations', function (Blueprint $table) {
            $table->id();
            $table->string('internet_number', 50);
            $table->string('old_package_code', 50);
            $table->string('new_package_code', 50);
            $table->enum('status', ['PENDING', 'APPROVED', 'EXECUTED', 'REJECTED'])->default('PENDING');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('effective_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
            $table->foreign('old_package_code')->references('code')->on('bandwidth_packages');
            $table->foreign('new_package_code')->references('code')->on('bandwidth_packages');
        });

        Schema::create('service_suspensions', function (Blueprint $table) {
            $table->id();
            $table->string('internet_number', 50);
            $table->enum('reason', ['OVERDUE', 'CUSTOMER_REQUEST', 'MAINTENANCE', 'OTHER'])->default('OVERDUE');
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('unsuspended_at')->nullable();
            $table->enum('status', ['ISOLATED', 'RESTORED'])->default('ISOLATED');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
        });

        Schema::create('service_terminations', function (Blueprint $table) {
            $table->id();
            $table->string('internet_number', 50);
            $table->string('reason')->nullable();
            $table->boolean('device_returned')->default(false);
            $table->timestamp('terminated_at')->nullable();
            $table->enum('status', ['PENDING', 'TERMINATED'])->default('PENDING');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_terminations');
        Schema::dropIfExists('service_suspensions');
        Schema::dropIfExists('package_mutations');
    }
};
