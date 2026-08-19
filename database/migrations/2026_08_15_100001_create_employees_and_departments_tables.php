<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('department_code', 50);
            $table->string('name');
            $table->timestamps();

            $table->foreign('department_code')->references('code')->on('departments')->onDelete('cascade');
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->string('nik', 50)->primary();
            $table->string('department_code', 50)->nullable();
            $table->string('position_code', 50)->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('status_contract', 50)->default('PERMANENT');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('department_code')->references('code')->on('departments')->nullOnDelete();
            $table->foreign('position_code')->references('code')->on('positions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('departments');
    }
};
