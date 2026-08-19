<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_terminations', function (Blueprint $table) {
            $table->string('status', 50)->default('KD11')->change();
            if (!Schema::hasColumn('service_terminations', 'termination_code')) {
                $table->string('termination_code', 50)->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'schedule_collect_date')) {
                $table->date('schedule_collect_date')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'schedule_collect_time')) {
                $table->string('schedule_collect_time', 50)->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'collect_team')) {
                $table->json('collect_team')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'collect_note')) {
                $table->text('collect_note')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'collect_finished_at')) {
                $table->date('collect_finished_at')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'collect_finished_note')) {
                $table->text('collect_finished_note')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'closing_date')) {
                $table->date('closing_date')->nullable();
            }
            if (!Schema::hasColumn('service_terminations', 'closing_note')) {
                $table->text('closing_note')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_terminations', function (Blueprint $table) {
            $cols = [
                'termination_code',
                'schedule_collect_date',
                'schedule_collect_time',
                'collect_team',
                'collect_note',
                'collect_finished_at',
                'collect_finished_note',
                'closing_date',
                'closing_note',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('service_terminations', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
