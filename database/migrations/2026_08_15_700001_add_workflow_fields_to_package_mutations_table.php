<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_mutations', function (Blueprint $table) {
            $table->string('status', 50)->default('Request')->change();
            if (!Schema::hasColumn('package_mutations', 'schedule_date')) {
                $table->date('schedule_date')->nullable();
            }
            if (!Schema::hasColumn('package_mutations', 'schedule_note')) {
                $table->text('schedule_note')->nullable();
            }
            if (!Schema::hasColumn('package_mutations', 'closed_at')) {
                $table->date('closed_at')->nullable();
            }
            if (!Schema::hasColumn('package_mutations', 'closing_note')) {
                $table->text('closing_note')->nullable();
            }
            if (!Schema::hasColumn('package_mutations', 'proof_file')) {
                $table->string('proof_file')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_mutations', function (Blueprint $table) {
            $cols = [
                'schedule_date',
                'schedule_note',
                'closed_at',
                'closing_note',
                'proof_file',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('package_mutations', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
