<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'custom_monthly_fee')) {
                $table->decimal('custom_monthly_fee', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'billing_range_months')) {
                $table->integer('billing_range_months')->default(1);
            }
            if (!Schema::hasColumn('customer_subscriptions', 'tax_percentage')) {
                $table->decimal('tax_percentage', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('customer_subscriptions', 'tax_status')) {
                $table->string('tax_status', 20)->default('Tidak Aktif');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'suspend_by_payment')) {
                $table->string('suspend_by_payment', 10)->default('TIDAK');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'late_fee_enabled')) {
                $table->string('late_fee_enabled', 10)->default('TIDAK');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'termination_period_months')) {
                $table->string('termination_period_months', 20)->default('term BULAN');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = [
                'custom_monthly_fee',
                'billing_range_months',
                'tax_percentage',
                'tax_status',
                'suspend_by_payment',
                'late_fee_enabled',
                'termination_period_months',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
