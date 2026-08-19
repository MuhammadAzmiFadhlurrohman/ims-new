<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('building_types', function (Blueprint $table) {
            $table->string('code', 50)->primary(); // e.g. BN001, BN002
            $table->string('name'); // e.g. KOS-KOSAN, RUMAH-PRIBADI
            $table->string('user_create', 50)->nullable()->default('ADMIN');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('building_service_categories', function (Blueprint $table) {
            $table->string('code', 50)->primary(); // e.g. KLB001
            $table->string('building_type_code', 50);
            $table->string('bandwidth_category_code', 50);
            $table->string('user_create', 50)->nullable()->default('ADMIN');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('building_type_code')->references('code')->on('building_types')->onDelete('cascade');
            $table->foreign('bandwidth_category_code')->references('code')->on('bandwidth_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_service_categories');
        Schema::dropIfExists('building_types');
    }
};
