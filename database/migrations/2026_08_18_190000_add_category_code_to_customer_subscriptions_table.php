<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'category_code')) {
                $table->string('category_code', 50)->nullable()->after('building_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('customer_subscriptions', 'category_code')) {
                $table->dropColumn('category_code');
            }
        });
    }
};
