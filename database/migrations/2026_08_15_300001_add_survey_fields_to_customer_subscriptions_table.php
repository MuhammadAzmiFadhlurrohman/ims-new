<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_subscriptions', 'survey_time_slot')) {
                $table->string('survey_time_slot', 100)->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_team')) {
                $table->json('survey_team')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_date')) {
                $table->date('survey_date')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_note')) {
                $table->text('survey_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_finished_at')) {
                $table->date('survey_finished_at')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_finished_note')) {
                $table->text('survey_finished_note')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'is_installable')) {
                $table->boolean('is_installable')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'mapping_photo')) {
                $table->text('mapping_photo')->nullable();
            }
            if (!Schema::hasColumn('customer_subscriptions', 'survey_equipment')) {
                $table->json('survey_equipment')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $cols = [
                'survey_time_slot',
                'survey_team',
                'survey_date',
                'survey_note',
                'survey_finished_at',
                'survey_finished_note',
                'is_installable',
                'mapping_photo',
                'survey_equipment',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('customer_subscriptions', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
