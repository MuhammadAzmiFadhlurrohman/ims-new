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
        Schema::create('ftth_network_elements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['marker', 'line'])->default('marker');
            $table->string('element_type'); // olt, odc, odp, pole, joint_box, customer, feeder, distribution, dropcore, other
            $table->string('olt_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 11, 7)->nullable();
            $table->json('path_coordinates')->nullable(); // Array of [[lat, lng], [lat, lng], ...]
            $table->unsignedInteger('length_meters')->nullable();
            $table->string('color', 20)->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('element_type');
            $table->index('olt_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftth_network_elements');
    }
};
