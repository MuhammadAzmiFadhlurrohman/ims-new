<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_suspensions', function (Blueprint $table) {
            $table->string('status', 100)->default('(KD11) Request')->change();
            $table->string('reason', 150)->nullable()->change();

            if (!Schema::hasColumn('service_suspensions', 'start_suspend_date')) {
                $table->date('start_suspend_date')->nullable();
            }
            if (!Schema::hasColumn('service_suspensions', 'send_whatsapp')) {
                $table->boolean('send_whatsapp')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_suspensions', function (Blueprint $table) {
            if (Schema::hasColumn('service_suspensions', 'start_suspend_date')) {
                $table->dropColumn('start_suspend_date');
            }
            if (Schema::hasColumn('service_suspensions', 'send_whatsapp')) {
                $table->dropColumn('send_whatsapp');
            }
        });
    }
};
