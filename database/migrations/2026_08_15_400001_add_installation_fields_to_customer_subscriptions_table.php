<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'installation_date')) {
                $table->date('installation_date')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_time_slot')) {
                $table->string('installation_time_slot', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_team')) {
                $table->json('installation_team')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_note')) {
                $table->text('installation_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_finished_at')) {
                $table->date('installation_finished_at')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_finished_note')) {
                $table->text('installation_finished_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_equipment')) {
                $table->json('installation_equipment')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'installation_mapping_photo')) {
                $table->text('installation_mapping_photo')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = [
                'installation_date',
                'installation_time_slot',
                'installation_team',
                'installation_note',
                'installation_finished_at',
                'installation_finished_note',
                'installation_equipment',
                'installation_mapping_photo',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
