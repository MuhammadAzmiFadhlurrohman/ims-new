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
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'status_type')) {
                $table->string('status_type')->nullable()->default('Temporary Delete')->after('registration_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('customer_subscriptions', 'status_type')) {
                $table->dropColumn('status_type');
            }
        });
    }
};
