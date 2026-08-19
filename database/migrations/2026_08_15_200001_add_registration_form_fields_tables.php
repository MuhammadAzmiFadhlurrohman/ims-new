<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'province')) {
                $table->string('province', 100)->nullable();
            }
            if (!Schema::hasColumn('customers', 'city')) {
                $table->string('city', 100)->nullable();
            }
            if (!Schema::hasColumn('customers', 'district')) {
                $table->string('district', 100)->nullable();
            }
            if (!Schema::hasColumn('customers', 'is_corporate')) {
                $table->boolean('is_corporate')->default(false);
            }
            if (!Schema::hasColumn('customers', 'pic_name')) {
                $table->string('pic_name', 100)->nullable();
            }
            if (!Schema::hasColumn('customers', 'id_card_photo')) {
                $table->text('id_card_photo')->nullable();
            }
            if (!Schema::hasColumn('customers', 'house_photo')) {
                $table->text('house_photo')->nullable();
            }
        });

        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'province')) {
                $table->string('province', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'city')) {
                $table->string('city', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'district')) {
                $table->string('district', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'group_service')) {
                $table->string('group_service', 100)->nullable()->default('MEDIANET');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'same_as_ktp')) {
                $table->boolean('same_as_ktp')->default(false);
            }
            if (!Schema::hasColumn('customer_subscriptions', 'special_request')) {
                $table->text('special_request')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $cols = ['province', 'city', 'district', 'is_corporate', 'pic_name', 'id_card_photo', 'house_photo'];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customers', $c)) {
                    $table->dropColumn($c);
                }
            }
        });

        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = ['province', 'city', 'district', 'group_service', 'same_as_ktp', 'special_request'];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
