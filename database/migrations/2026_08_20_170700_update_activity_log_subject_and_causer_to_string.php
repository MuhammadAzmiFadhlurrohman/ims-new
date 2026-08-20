<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('activitylog.table_name', 'activity_log');
        $connection = config('activitylog.database_connection');

        if (Schema::connection($connection)->hasTable($tableName)) {
            $driver = DB::connection($connection)->getDriverName();
            if ($driver === 'mysql') {
                DB::connection($connection)->statement("ALTER TABLE `{$tableName}` MODIFY `subject_id` VARCHAR(255) NULL");
                DB::connection($connection)->statement("ALTER TABLE `{$tableName}` MODIFY `causer_id` VARCHAR(255) NULL");
            } else {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                    $table->string('subject_id', 255)->nullable()->change();
                    $table->string('causer_id', 255)->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        $tableName = config('activitylog.table_name', 'activity_log');
        $connection = config('activitylog.database_connection');

        if (Schema::connection($connection)->hasTable($tableName)) {
            $driver = DB::connection($connection)->getDriverName();
            if ($driver === 'mysql') {
                DB::connection($connection)->statement("ALTER TABLE `{$tableName}` MODIFY `subject_id` BIGINT UNSIGNED NULL");
                DB::connection($connection)->statement("ALTER TABLE `{$tableName}` MODIFY `causer_id` BIGINT UNSIGNED NULL");
            } else {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('subject_id')->nullable()->change();
                    $table->unsignedBigInteger('causer_id')->nullable()->change();
                });
            }
        }
    }
};
