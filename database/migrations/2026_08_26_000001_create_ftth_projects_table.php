<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('ftth_projects')) {
            Schema::create('ftth_projects', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code', 64)->nullable()->unique();
                $table->text('description')->nullable();
                $table->string('color', 20)->default('#0878E5');
                $table->decimal('center_latitude', 10, 7)->nullable();
                $table->decimal('center_longitude', 11, 7)->nullable();
                $table->unsignedSmallInteger('default_zoom')->default(15);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('ftth_network_elements') && !Schema::hasColumn('ftth_network_elements', 'project_id')) {
            Schema::table('ftth_network_elements', function (Blueprint $table) {
                $table->foreignId('project_id')->nullable()->after('id')->constrained('ftth_projects')->nullOnDelete();
                $table->index('project_id');
            });
        }

        // Create default project if none exists
        if (DB::table('ftth_projects')->count() === 0) {
            $defaultId = DB::table('ftth_projects')->insertGetId([
                'name' => 'Proyek Utama (Default)',
                'code' => 'PRJ-DEFAULT',
                'description' => 'Area pemetaan utama jaringan FTTH',
                'color' => '#0878E5',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign any existing elements to default project
            DB::table('ftth_network_elements')->whereNull('project_id')->update(['project_id' => $defaultId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ftth_network_elements') && Schema::hasColumn('ftth_network_elements', 'project_id')) {
            Schema::table('ftth_network_elements', function (Blueprint $table) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            });
        }

        Schema::dropIfExists('ftth_projects');
    }
};
