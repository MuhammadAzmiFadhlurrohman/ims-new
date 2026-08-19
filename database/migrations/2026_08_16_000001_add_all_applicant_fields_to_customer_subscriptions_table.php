<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'gender')) {
                $table->string('gender', 20)->nullable()->default('male');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'birth_date')) {
                $table->date('birth_date')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'is_corporate')) {
                $table->boolean('is_corporate')->default(false);
            }
            if (!Schema::hasColumn('customer_subscriptions', 'pic_name')) {
                $table->string('pic_name', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'email')) {
                $table->string('email', 150)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'phone_number')) {
                $table->string('phone_number', 50)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'alt_phone_number')) {
                $table->string('alt_phone_number', 50)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'province_ktp')) {
                $table->string('province_ktp', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'city_ktp')) {
                $table->string('city_ktp', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'district_ktp')) {
                $table->string('district_ktp', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'village_ktp')) {
                $table->string('village_ktp', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'rt_ktp')) {
                $table->string('rt_ktp', 20)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'rw_ktp')) {
                $table->string('rw_ktp', 20)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'address_ktp')) {
                $table->text('address_ktp')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'id_card_photo')) {
                $table->text('id_card_photo')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'house_photo')) {
                $table->text('house_photo')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'building_number')) {
                $table->string('building_number', 50)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'maps_url')) {
                $table->text('maps_url')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'sales_name')) {
                $table->string('sales_name', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'admin_name')) {
                $table->string('admin_name', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = [
                'gender',
                'birth_date',
                'is_corporate',
                'pic_name',
                'email',
                'phone_number',
                'alt_phone_number',
                'province_ktp',
                'city_ktp',
                'district_ktp',
                'village_ktp',
                'rt_ktp',
                'rw_ktp',
                'address_ktp',
                'id_card_photo',
                'house_photo',
                'building_number',
                'maps_url',
                'sales_name',
                'admin_name',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
