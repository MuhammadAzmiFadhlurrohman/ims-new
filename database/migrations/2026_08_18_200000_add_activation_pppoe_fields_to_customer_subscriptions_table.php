<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'router_id')) {
                $table->foreignId('router_id')->nullable()->after('pop_code')->constrained('routers')->nullOnDelete();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'local_address')) {
                $table->string('local_address', 50)->nullable()->after('pppoe_profile');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'remote_address')) {
                $table->string('remote_address', 50)->nullable()->after('local_address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('customer_subscriptions', 'router_id')) {
                $table->dropForeign(['router_id']);
                $table->dropColumn('router_id');
            }
            if (Schema::hasColumn('customer_subscriptions', 'local_address')) {
                $table->dropColumn('local_address');
            }
            if (Schema::hasColumn('customer_subscriptions', 'remote_address')) {
                $table->dropColumn('remote_address');
            }
        });
    }
};
