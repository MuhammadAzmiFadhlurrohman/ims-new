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
        Schema::table('pon_ports', function (Blueprint $table) {
            if (!Schema::hasColumn('pon_ports', 'name')) {
                $table->string('name')->nullable()->after('olt_code');
            }
            if (!Schema::hasColumn('pon_ports', 'max_ports')) {
                $table->integer('max_ports')->default(8)->after('port_number');
            }
            if (!Schema::hasColumn('pon_ports', 'used_ports')) {
                $table->integer('used_ports')->default(0)->after('max_ports');
            }
        });

        Schema::table('odps', function (Blueprint $table) {
            if (!Schema::hasColumn('odps', 'olt_code')) {
                $table->string('olt_code', 50)->nullable()->after('pop_code');
                $table->foreign('olt_code')->references('code')->on('olts')->nullOnDelete();
            }
            if (!Schema::hasColumn('odps', 'pon_port_id')) {
                $table->unsignedBigInteger('pon_port_id')->nullable()->after('olt_code');
                $table->foreign('pon_port_id')->references('id')->on('pon_ports')->nullOnDelete();
            }
            if (!Schema::hasColumn('odps', 'latitude')) {
                $table->string('latitude', 50)->nullable()->after('used_ports');
            }
            if (!Schema::hasColumn('odps', 'longitude')) {
                $table->string('longitude', 50)->nullable()->after('latitude');
            }
        });

        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'olt_code')) {
                $table->string('olt_code', 50)->nullable()->after('odp_code');
            }
            if (!Schema::hasColumn('customer_subscriptions', 'gpon_onu')) {
                $table->string('gpon_onu')->nullable()->after('ont_password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('customer_subscriptions', 'gpon_onu')) {
                $table->dropColumn('gpon_onu');
            }
            if (Schema::hasColumn('customer_subscriptions', 'olt_code')) {
                $table->dropColumn('olt_code');
            }
        });

        Schema::table('odps', function (Blueprint $table) {
            if (Schema::hasColumn('odps', 'pon_port_id')) {
                $table->dropForeign(['pon_port_id']);
                $table->dropColumn('pon_port_id');
            }
            if (Schema::hasColumn('odps', 'olt_code')) {
                $table->dropForeign(['olt_code']);
                $table->dropColumn('olt_code');
            }
            if (Schema::hasColumn('odps', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('odps', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });

        Schema::table('pon_ports', function (Blueprint $table) {
            if (Schema::hasColumn('pon_ports', 'used_ports')) {
                $table->dropColumn('used_ports');
            }
            if (Schema::hasColumn('pon_ports', 'max_ports')) {
                $table->dropColumn('max_ports');
            }
            if (Schema::hasColumn('pon_ports', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
