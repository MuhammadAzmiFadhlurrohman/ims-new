<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('router_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('router_id')->nullable()->constrained('routers')->nullOnDelete();
            $table->string('internet_number', 50)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('executor_name')->default('Admin');
            $table->string('executor_role')->default('admin');
            $table->string('action_type')->default('Buat PPPoE'); // Buat PPPoE, Ubah Status, Hapus Secret, Ganti Profile, dll
            $table->string('old_status')->nullable(); // Suspend, Aktif, dll
            $table->string('new_status')->nullable(); // Terminasi, Aktif, dll
            $table->text('description')->nullable();
            $table->text('response_message')->nullable();
            $table->string('status', 20)->default('success'); // success, failed, pending
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('router_histories');
    }
};
