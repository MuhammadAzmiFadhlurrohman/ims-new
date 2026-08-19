<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_nik')) {
                $table->string('employee_nik', 50)->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 25)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'avatar_url')) {
                $table->string('avatar_url')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable();
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('users', 'employee_nik') ? 'employee_nik' : null,
                Schema::hasColumn('users', 'username') ? 'username' : null,
                Schema::hasColumn('users', 'phone_number') ? 'phone_number' : null,
                Schema::hasColumn('users', 'avatar_url') ? 'avatar_url' : null,
                Schema::hasColumn('users', 'is_active') ? 'is_active' : null,
                Schema::hasColumn('users', 'last_login_ip') ? 'last_login_ip' : null,
                Schema::hasColumn('users', 'last_login_at') ? 'last_login_at' : null,
            ]);
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
