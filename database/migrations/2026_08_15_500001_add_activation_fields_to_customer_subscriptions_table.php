<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'activation_date')) {
                $table->date('activation_date')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_time_slot')) {
                $table->string('activation_time_slot', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_team')) {
                $table->json('activation_team')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_note')) {
                $table->text('activation_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_finished_at')) {
                $table->date('activation_finished_at')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_finished_note')) {
                $table->text('activation_finished_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'activation_equipment')) {
                $table->json('activation_equipment')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = [
                'activation_date',
                'activation_time_slot',
                'activation_team',
                'activation_note',
                'activation_finished_at',
                'activation_finished_note',
                'activation_equipment',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
